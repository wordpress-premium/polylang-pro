<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_Content_Walker_Blocks
 *
 * @since 3.3
 *
 * Walk a block composed content to apply a translation callback on every translatable parts.
 */
class PLL_Translation_Walker_Blocks implements PLL_Translation_Walker_Interface {
	/**
	 * Placeholder for inner blocks, used in exported contents.
	 *
	 * @var string
	 */
	const BLOCK_PLACEHOLDER = '<pre>Polylang placeholder do not modify</pre>';

	/**
	 * Holds the blocks parsed by the WP_Block_Parser.
	 *
	 * @var array[]
	 */
	private $blocks;

	/**
	 * A reference to the block parsing rules.
	 *
	 * @var PLL_Translation_Block_Parsing_Rules
	 */
	private $parsing_rules;

	/**
	 * Holds the callback to be applied on each block, including the nested blocks.
	 *
	 * @var callable
	 */
	private $callback;

	/**
	 * HTML delimiter used in {@see PLL_Translation_Walker_Blocks::parse_as_html()}.
	 *
	 * @var string
	 * @phpstan-var non-empty-string
	 */
	private $placeholder_delimiter;

	/**
	 * PLL_Content_Walker_Blocks constructor.
	 *
	 * @since 3.3
	 *
	 * @param string $content An original (post?) content.
	 */
	public function __construct( $content ) {
		$this->parsing_rules         = new PLL_Translation_Block_Parsing_Rules();
		$this->blocks                = parse_blocks( $content );
		$this->placeholder_delimiter = sprintf( '<!-- PLL_DELIMITER_%d -->', wp_rand( 1, 100000 ) );
	}

	/**
	 * Walks through the blocks and nested blocks to apply a callback on every one of them.
	 *
	 * @since 3.3
	 *
	 * @param callable $callback A callable to be applied on each block.
	 * @return string The walked content, eventually transformed by the callback.
	 */
	public function walk( $callback ) {
		$this->callback = $callback;
		$this->blocks   = array_map( array( $this, 'apply' ), $this->blocks );

		return serialize_blocks( $this->blocks );
	}

	/**
	 * Recursively applies the callback provided to the {@see PLL_Translation_Walker_Blocks::walk()} method on a block.
	 * Searches for translatable strings matching rules defined by {@see PLL_Translation_Rules_Block} and passes those to the callback function.
	 * Delegates to {@see PLL_Translation_Walker_Classic} when no parsing rules match the current block being parsed.
	 *
	 * @since 3.3
	 *
	 * @param array $block An associative array mimicking a WP_Block_Parser_Block object.
	 * @return array An array mimicking a WP_Block_Parser_Block object.
	 */
	private function apply( $block ) {
		if ( ! empty( $block['innerBlocks'] ) ) {
			$block['innerBlocks'] = array_map( array( $this, 'apply' ), $block['innerBlocks'] );
		}

		if ( ! $this->parsing_rules->should_be_parsed( $block ) ) {
			// No contents to translate.
			return $block;
		}

		$attributes_to_translate = $this->parsing_rules->get_attributes_to_translate( $block );
		if ( ! empty( $attributes_to_translate ) ) {
			$block = $this->parse_attributes( $block, $attributes_to_translate );
		}

		if ( $this->parsing_rules->has_parsing_rules( $block ) ) {
			// A known block that will be parsed with Xpath rules.
			return $this->parse_with_rules( $block );
		}

		// A block that will be parsed as HTML.
		return $this->parse_as_html( $block );
	}

	/**
	 * Recursively applies the callback provided to the {@see PLL_Translation_Walker_Blocks::walk()} method on a block.
	 * Searches for translatable strings matching rules defined by {@see PLL_Translation_Rules_Block} and passes those to the callback function.
	 *
	 * @since 3.3
	 *
	 * @param array $block An associative array mimicking a WP_Block_Parser_Block object.
	 * @return array An array mimicking a WP_Block_Parser_Block object.
	 */
	private function parse_with_rules( $block ) {
		// Get the whole block's content to parse with placeholders.
		$source_string = $this->get_block_content_to_parse( $block );

		// Parse by using our pre-defined rules.
		$parsed_strings = $this->parsing_rules->set_block_name( $block['blockName'] )->parse( $source_string );

		if ( empty( $parsed_strings ) ) {
			// Nothing to translate.
			return $block;
		}

		$to_replace = array();

		foreach ( $parsed_strings as $node_path => $parsed_string ) {
			$entry = new PLL_Translation_Entry_Identified(
				array(
					'singular' => $parsed_string,
					'context'  => PLL_Import_Export::POST_CONTENT,
				)
			);

			$result = call_user_func_array( $this->callback, array( &$entry ) );

			if ( ! $result instanceof PLL_Translation_Entry_Identified || empty( $result->translations ) ) {
				continue;
			}

			$translation = reset( $result->translations );

			if ( '' === trim( $translation ) ) {
				continue;
			}

			$to_replace[ $node_path ] = $translation;
		}

		if ( empty( $to_replace ) ) {
			// No need to modify things if there are no translations.
			return $block;
		}

		$result_string = ( new PLL_DOM_Content( $source_string ) )->replace_content( $to_replace );

		// Put the content back into the block.
		return $this->update_block_with_content( $block, $result_string );
	}

	/**
	 * Parses a block's contents as HTML and applies the callback provided to the
	 * {@see PLL_Translation_Walker_Blocks::walk()} method on these contents. Uses {@see PLL_Translation_Walker_Classic}.
	 *
	 * @since 3.3
	 *
	 * @param array $block An associative array mimicking a WP_Block_Parser_Block object.
	 * @return array An array mimicking a WP_Block_Parser_Block object.
	 */
	private function parse_as_html( $block ) {
		// Get the whole block's content to parse with placeholders.
		$source_string = $this->get_block_content_to_parse( $block );

		$walker        = new PLL_Translation_Walker_Classic( $source_string, array( self::BLOCK_PLACEHOLDER ) );
		$result_string = $walker->walk( $this->callback );

		// Put the content back into the block.
		return $this->update_block_with_content( $block, $result_string );
	}

	/**
	 * Returns a block's content as a string and with placeholders in place of sub-blocks, ready to be parsed.
	 *
	 * @since 3.3
	 *
	 * @param array $block An associative array mimicking a WP_Block_Parser_Block object.
	 * @return string The block's content as a string and with placeholders in place of sub-blocks.
	 */
	private function get_block_content_to_parse( array $block ) {
		$content = array_map(
			function ( $content_part ) {
				return is_string( $content_part ) ? $content_part : self::BLOCK_PLACEHOLDER;
			},
			$block['innerContent']
		);

		return implode( '', $content );
	}

	/**
	 * Puts a translated content back into a block.
	 *
	 * @since 3.3
	 *
	 * @param array  $block   An associative array mimicking a WP_Block_Parser_Block object.
	 * @param string $content The content to put back into the block.
	 * @return array An array mimicking a WP_Block_Parser_Block object.
	 */
	private function update_block_with_content( array $block, $content ) {
		// Explode by using a delimiter.
		$content = str_replace(
			self::BLOCK_PLACEHOLDER,
			$this->placeholder_delimiter . self::BLOCK_PLACEHOLDER . $this->placeholder_delimiter,
			$content
		);
		$content = explode( $this->placeholder_delimiter, $content );
		// Replace placeholders by `null` values.
		$block['innerContent'] = array_map(
			function ( $content_part ) {
				return self::BLOCK_PLACEHOLDER === $content_part ? null : $content_part;
			},
			$content
		);
		// Make innerHTML consistent.
		$block['innerHTML'] = implode( '', $block['innerContent'] );

		return $block;
	}

	/**
	 * Returns the translatable block attributes and passes them to the callback function.
	 *
	 * @since 3.3
	 *
	 * @param array    $block                   An associative array mimicking a WP_Block_Parser_Block object.
	 * @param string[] $attributes_to_translate An array of attributes to translate.
	 * @return array An array mimicking a WP_Block_Parser_Block object.
	 *
	 * @phpstan-param array<string,string> $attributes_to_translate
	 */
	private function parse_attributes( $block, $attributes_to_translate ) {
		foreach ( $block['attrs'] as $attr_key => $attr_value ) {
			if ( ! in_array( $attr_key, $attributes_to_translate, true ) || ! is_string( $attr_value ) ) {
				// Do not create translation entry for a non translatable attribute.
				continue;
			}

			$entry = new PLL_Translation_Entry_Identified(
				array(
					'singular' => trim( $attr_value ),
					'context'  => PLL_Import_Export::POST_CONTENT,
					'id'       => $attr_key,
				)
			);

			$result = call_user_func_array( $this->callback, array( &$entry ) );
			if ( ! $result instanceof PLL_Translation_Entry_Identified || empty( $result->translations[0] ) ) {
				continue;
			}

			$block['attrs'][ $entry->get_id() ] = $result->translations[0];

			if ( 'core/more' !== $block['blockName'] ) {
				continue;
			}

			// Special case for 'core/more' block content that need to be updated according to its translated attribute.
			$core_more_content = "<!--more {$result->translations[0]}-->";
			$block             = $this->update_block_with_content( $block, $core_more_content );
		}

		return $block;
	}
}
