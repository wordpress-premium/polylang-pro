<?php
/**
 * @package Polylang-Pro
 */

/**
 * Holds the rules defining which part of a block should be "translated".
 * Translated may mean different actions, like exporting it into a translation file, or updating the database...
 *
 * @since 3.3
 */
class PLL_Translation_Block_Parsing_Rules {

	/**
	 * Caches values about parsable and non-parsable blocks.
	 *
	 * @var array
	 * @phpstan-var array<string,mixed>
	 */
	private $cache = array();

	/**
	 * Holds some rules for block attributes to translate.
	 * Keep this list alphabetically sorted when adding entries.
	 *
	 * @var string[][]
	 * @phpstan-var array<string,array<string>>
	 */
	private $parsing_rules_attributes = array(
		'core/more'                 => array(
			'customText',
		),
		'core/navigation-link'      => array(
			'description',
		),
		'core/post-navigation-link' => array(
			'label',
		),
		'core/read-more'            => array(
			'content',
		),
		'core/search'               => array(
			'label',
			'placeholder',
			'buttonText',
		),
	);

	/**
	 * Holds some rules as Xpath expressions to evaluate in the blocks content.
	 * Keep this list alphabetically sorted when adding entries.
	 *
	 * @var string[][]
	 * @phpstan-var array<string,array<string>>
	 */
	private $parsing_rules = array(
		'core/audio'        => array(
			'//figure/figcaption',
		),
		'core/button'       => array(
			'//a',
			'//a/@href',
		),
		'core/cover'        => array(
			'//div/p',
		),
		'core/cover-image'  => array(
			'//div/p',
		),
		'core/embed'        => array(
			'//figure/figcaption',
		),
		'core/file'         => array(
			'//div/a',
		),
		'core/gallery'      => array(
			'//figure/figcaption',
			'//figure/img/@alt', // Backward compatibility.
		),
		'core/heading'      => array(
			'//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6]',
		),
		'core/image'        => array(
			'//figure/figcaption',
			'//figure/img/@alt|//figure/a/img/@alt',
			'//figure/img/@title|//figure/a/img/@title',
			'//figure/a/@href',
		),
		'core/list'         => array(
			'//ul/li|//ol/li',
		),
		'core/media-text'   => array(
			'//figure/img/@alt',
		),
		'core/paragraph'    => array(
			'//p',
		),
		'core/preformatted' => array(
			'//pre',
		),
		'core/pullquote'    => array(
			'//blockquote/p',
			'//blockquote/cite',
		),
		'core/quote'        => array(
			'//blockquote/p',
			'//blockquote/cite',
		),
		'core/subhead'      => array(
			'//p',
		),
		'core/table'        => array(
			'//th',
			'//td',
			'//figure/figcaption',
		),
		'core/text-columns' => array(
			'//div[@class="wp-block-column"]',
		),
		'core/verse'        => array(
			'//pre',
		),
		'core/video'        => array(
			'//figure/figcaption',
		),
	);

	/**
	 * List of known blocks that don't need to be parsed, because they don't contain contents to be translated.
	 * Though, they may contain blocks that need to be parsed.
	 * Keep this list alphabetically sorted when adding entries.
	 *
	 * @var string[]
	 */
	private $blocks_not_to_parse = array(
		'core/buttons',
		'core/code',
		'core/column',
		'core/columns',
		'core/group',
		'core/nextpage',
		'core/separator',
		'core/shortcode',
		'core/spacer',
	);

	/**
	 * Holds the name of the block type being currently parsed.
	 *
	 * @var string $block_type Similar to {@see WP_Block_Parser_Block::$blockName}.
	 */
	private $block_type;

	/**
	 * Only keeps the rules matching a certain block type.
	 *
	 * @since 3.3
	 *
	 * @param string $block_type {@see WP_Block_Parser_Block::$blockName}.
	 * @return PLL_Translation_Block_Parsing_Rules $this This object with its $rules property updated.
	 */
	public function set_block_name( $block_type ) {
		$this->block_type = $block_type;
		return $this;
	}

	/**
	 * Extracts translatable parts from the block content.
	 * Returns an empty array if the parsing rules are not defined.
	 *
	 * @since 3.3
	 *
	 * @param string $content {@see WP_Block_Parser_Block::$innerContent}.
	 * @return string[] Parsing rules as array keys, strings to translate as array values.
	 *
	 * @phpstan-return array<string,string>
	 */
	public function parse( $content ) {
		$rules = $this->get_parsing_rules( $this->block_type );

		if ( ! isset( $rules[ $this->block_type ] ) ) {
			return array();
		}

		// Check if there's HTML encoded non-breaking-space, if so decode it for consistency.
		$content = str_replace( '&nbsp;', html_entity_decode( '&nbsp;' ), $content );

		$rules             = $rules[ $this->block_type ];
		$sanitized_content = wp_kses_post( $content );

		if ( empty( $sanitized_content ) ) {
			return array();
		}

		return ( new PLL_DOM_Content( $content ) )->get_strings( $rules );
	}

	/**
	 * Tells if a block should be parsed using Xpath rules.
	 *
	 * @since 3.3
	 *
	 * @param array $block An array mimicking a {@see WP_Block_Parser_Block}.
	 * @return bool
	 */
	public function has_parsing_rules( $block ) {
		$rules = $this->get_parsing_rules( $block['blockName'] );
		return isset( $rules[ $block['blockName'] ] );
	}

	/**
	 * Tells if a block needs to be parsed, because it contains contents to be translated.
	 * Though, even if not, it may contain blocks that need to be parsed.
	 *
	 * @since 3.3
	 *
	 * @param array $block An array mimicking a {@see WP_Block_Parser_Block}.
	 * @return bool
	 */
	public function should_be_parsed( $block ) {
		if ( '' === trim( $block['innerHTML'] ) && empty( $block['attrs'] ) ) {
			// A block that doesn't have contents and attributes.
			return false;
		}

		if ( in_array( $block['blockName'], $this->get_blocks_not_to_parse(), true ) ) {
			/**
			 * A known block that doesn't contain contents to be translated.
			 * Let's avoid useless operations.
			 */
			return false;
		}

		return true;
	}

	/**
	 * Returns the rules as Xpath expressions to evaluate in the blocks content.
	 *
	 * @since 3.3
	 *
	 * @param string|null $block_name Optional. The block name we want to get the parsing rules for.
	 *                                Only necessary for back-compatibility with the old `core-embed/` blocks.
	 * @return string[][]
	 *
	 * @phpstan-return array<string,array<string>>
	 */
	private function get_parsing_rules( $block_name = null ) {
		if ( ! isset( $this->cache['parsing_rules'] ) || ! is_array( $this->cache['parsing_rules'] ) ) {
			/**
			 * Filters the rules as Xpath expressions to evaluate in the blocks content.
			 *
			 * @since 3.3
			 *
			 * @param string[][] $parsing_rules Rules as Xpath expressions to evaluate in the blocks content.
			 *
			 * @phpstan-param array<string,array<string>> $parsing_rules
			 */
			$this->cache['parsing_rules'] = (array) apply_filters( 'pll_blocks_xpath_rules', $this->parsing_rules );
		}

		$parsing_rules = $this->cache['parsing_rules'];

		if ( is_string( $block_name ) && ! isset( $parsing_rules[ $block_name ] ) && strpos( $block_name, 'core-embed/' ) === 0 ) {
			$parsing_rules[ $block_name ] = array(
				'//figure/figcaption',
			);
		}

		return $parsing_rules;

	}

	/**
	 * Returns the rules for the attributes to translate.
	 *
	 * @since 3.3
	 *
	 * @return string[][]
	 *
	 * @phpstan-return array<string,array<string>>
	 */
	private function get_parsing_rules_for_attributes() {
		if ( ! isset( $this->cache['parsing_rules_for_attributes'] ) || ! is_array( $this->cache['parsing_rules_for_attributes'] ) ) {
			/**
			 * Filters the list of blocks attributes to translate.
			 *
			 * @since 3.3
			 *
			 * @param string[][] $parsing_rules_attributes Rules for block attributes to translate.
			 *
			 * @phpstan-param array<string,array<string>> $parsing_rules_attributes
			 */
			$this->cache['parsing_rules_for_attributes'] = (array) apply_filters( 'pll_blocks_rules_for_attributes', $this->parsing_rules_attributes );
		}

		return $this->cache['parsing_rules_for_attributes'];
	}

	/**
	 * Returns the list of blocks not to parse.
	 *
	 * @since 3.3
	 *
	 * @return string[]
	 */
	private function get_blocks_not_to_parse() {
		$blocks_not_to_parse = isset( $this->cache['blocks_not_to_parse'] ) ? $this->cache['blocks_not_to_parse'] : null;

		if ( is_array( $blocks_not_to_parse ) ) {
			return $blocks_not_to_parse;
		}

		/**
		 * Filters the list of blocks not to parse.
		 *
		 * @since 3.3
		 *
		 * @param string[] $blocks_not_to_parse List of blocks not to parse.
		 */
		$this->cache['blocks_not_to_parse'] = (array) apply_filters( 'pll_blocks_not_to_parse', $this->blocks_not_to_parse );

		return $this->cache['blocks_not_to_parse'];
	}

	/**
	 * Checks if a block has translatable attributes (or not) and returns them.
	 *
	 * @since 3.3
	 *
	 * @param array $block An array mimicking a {@see WP_Block_Parser_Block}.
	 * @return string[] An array with attributes to translate or an empty array.
	 *
	 * @phpstan-return array<string,string>
	 */
	public function get_attributes_to_translate( $block ) {
		if ( empty( $block['attrs'] ) ) {
			return array();
		}

		$rules = $this->get_parsing_rules_for_attributes();
		if ( ! isset( $rules[ $block['blockName'] ] ) ) {
			return array();
		}

		return $rules[ $block['blockName'] ];
	}
}
