<?php
/**
 * Define WordPress backward compatibility functions
 *
 * @package Polylang-Pro
 */

if ( ! function_exists( 'serialize_block_attributes' ) ) {
	// phpcs:disable WordPress.WP.AlternativeFunctions.json_encode_json_encode
	/**
	 * Given an array of attributes, returns a string in the serialized attributes
	 * format prepared for post content.
	 *
	 * The serialized result is a JSON-encoded string, with unicode escape sequence
	 * substitution for characters which might otherwise interfere with embedding
	 * the result in an HTML comment.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param array $block_attributes Attributes object.
	 * @return string Serialized attributes.
	 */
	function serialize_block_attributes( $block_attributes ) {
		$encoded_attributes = json_encode( $block_attributes );
		$encoded_attributes = preg_replace( '/--/', '\\u002d\\u002d', $encoded_attributes );
		$encoded_attributes = preg_replace( '/</', '\\u003c', $encoded_attributes );
		$encoded_attributes = preg_replace( '/>/', '\\u003e', $encoded_attributes );
		$encoded_attributes = preg_replace( '/&/', '\\u0026', $encoded_attributes );
		// Regex: /\\"/
		$encoded_attributes = preg_replace( '/\\\\"/', '\\u0022', $encoded_attributes );

		return $encoded_attributes;
	}
	// phpcs:enable
}
if ( ! function_exists( 'strip_core_block_namespace' ) ) {
	/**
	 * Returns the block name to use for serialization. This will remove the default
	 * "core/" namespace from a block name.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param string $block_name Original block name.
	 * @return string Block name to use for serialization.
	 */
	function strip_core_block_namespace( $block_name = null ) {
		if ( is_string( $block_name ) && 0 === strpos( $block_name, 'core/' ) ) {
			return substr( $block_name, 5 );
		}

		return $block_name;
	}
}
if ( ! function_exists( 'get_comment_delimited_block_content' ) ) {
	/**
	 * Returns the content of a block, including comment delimiters.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param string $block_name       Block name.
	 * @param array  $block_attributes Block attributes.
	 * @param string $block_content    Block save content.
	 * @return string Comment-delimited block content.
	 */
	function get_comment_delimited_block_content( $block_name, $block_attributes, $block_content ) {
		if ( is_null( $block_name ) ) {
			return $block_content;
		}

		$serialized_block_name = strip_core_block_namespace( $block_name );
		$serialized_attributes = empty( $block_attributes ) ? '' : serialize_block_attributes( $block_attributes ) . ' ';

		if ( empty( $block_content ) ) {
			return sprintf( '<!-- wp:%s %s/-->', $serialized_block_name, $serialized_attributes );
		}

		return sprintf(
			'<!-- wp:%s %s-->%s<!-- /wp:%s -->',
			$serialized_block_name,
			$serialized_attributes,
			$block_content,
			$serialized_block_name
		);
	}
}
if ( ! function_exists( 'serialize_block' ) ) {
	/**
	 * Returns the content of a block, including comment delimiters, serializing all
	 * attributes from the given parsed block.
	 *
	 * This should be used when preparing a block to be saved to post content.
	 * Prefer `render_block` when preparing a block for display. Unlike
	 * `render_block`, this does not evaluate a block's `render_callback`, and will
	 * instead preserve the markup as parsed.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param WP_Block_Parser_Block $block A single parsed block object.
	 * @return string String of rendered HTML.
	 */
	function serialize_block( $block ) {
		$block_content = '';
		$index = 0;
		foreach ( $block['innerContent'] as $chunk ) {
			$block_content .= is_string( $chunk ) ? $chunk : serialize_block( $block['innerBlocks'][ $index++ ] );
		}
		if ( ! is_array( $block['attrs'] ) ) {
			$block['attrs'] = array();
		}
		return get_comment_delimited_block_content(
			$block['blockName'],
			$block['attrs'],
			$block_content
		);
	}
}
if ( ! function_exists( 'serialize_blocks' ) ) {
	/**
	 * Returns a joined string of the aggregate serialization of the given parsed
	 * blocks.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param WP_Block_Parser_Block[] $blocks Parsed block objects.
	 * @return string String of rendered HTML.
	 */
	function serialize_blocks( $blocks ) {
		return implode( '', array_map( 'serialize_block', $blocks ) );
	}
}
if ( ! function_exists( 'filter_block_content' ) ) {
	/**
	 * Filters and sanitizes block content to remove non-allowable HTML from
	 * parsed block attribute values.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param string         $text              Text that may contain block content.
	 * @param array[]|string $allowed_html      An array of allowed HTML elements
	 *                                          and attributes, or a context name
	 *                                          such as 'post'.
	 * @param string[]       $allowed_protocols Array of allowed URL protocols.
	 * @return string The filtered and sanitized content result.
	 */
	function filter_block_content( $text, $allowed_html = 'post', $allowed_protocols = array() ) {
		$result = '';

		$blocks = parse_blocks( $text );
		foreach ( $blocks as $block ) {
			$block   = filter_block_kses( $block, $allowed_html, $allowed_protocols );
			$result .= serialize_block( $block );
		}

		return $result;
	}
}
if ( ! function_exists( 'filter_block_kses' ) ) {
	/**
	 * Filters and sanitizes a parsed block to remove non-allowable HTML from block
	 * attribute values.
	 *
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param WP_Block_Parser_Block $block             The parsed block object.
	 * @param array[]|string        $allowed_html      An array of allowed HTML
	 *                                                 elements and attributes, or a
	 *                                                 context name such as 'post'.
	 * @param string[]              $allowed_protocols Allowed URL protocols.
	 * @return array The filtered and sanitized block object result.
	 */
	function filter_block_kses( $block, $allowed_html, $allowed_protocols = array() ) {
		$block['attrs'] = filter_block_kses_value( $block['attrs'], $allowed_html, $allowed_protocols );

		if ( is_array( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $i => $inner_block ) {
				$block['innerBlocks'][ $i ] = filter_block_kses( $inner_block, $allowed_html, $allowed_protocols );
			}
		}

		return $block;
	}
}

if ( ! function_exists( 'filter_block_kses_value' ) ) {
	/**
	 * Filters and sanitizes a parsed block attribute value to remove non-allowable
	 * HTML.
	 * Backward compatibility with WP < 5.3.1
	 *
	 * @since 2.9
	 *
	 * @param mixed          $value             The attribute value to filter.
	 * @param array[]|string $allowed_html      An array of allowed HTML elements
	 *                                          and attributes, or a context name
	 *                                          such as 'post'.
	 * @param string[]       $allowed_protocols Array of allowed URL protocols.
	 * @return array The filtered and sanitized result.
	 */
	function filter_block_kses_value( $value, $allowed_html, $allowed_protocols = array() ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $inner_value ) {
				$filtered_key   = filter_block_kses_value( $key, $allowed_html, $allowed_protocols );
				$filtered_value = filter_block_kses_value( $inner_value, $allowed_html, $allowed_protocols );
				if ( $filtered_key !== $key ) {
					unset( $value[ $key ] );
				}
				$value[ $filtered_key ] = $filtered_value;
			}
		} elseif ( is_string( $value ) ) {
			return wp_kses( $value, $allowed_html, $allowed_protocols );
		}
		return $value;
	}
}
