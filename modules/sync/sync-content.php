<?php
/**
 * @package Polylang-Pro
 */

/**
 * Smart copy of post content
 *
 * @since 2.6
 */
class PLL_Sync_Content {
	/**
	 * Stores the plugin options.
	 *
	 * @var array
	 */
	public $options;

	/**
	 * @var PLL_Model
	 */
	public $model;

	/**
	 * Instance of a child class of PLL_Links_Model.
	 *
	 * @var PLL_Links_Model
	 */
	public $links_model;

	/**
	 * @var PLL_CRUD_Posts
	 */
	public $posts;

	/**
	 * Id of the target post.
	 *
	 * @var int
	 */
	public $post_id;

	/**
	 * Language of the target post.
	 *
	 * @var PLL_Language
	 */
	public $language;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param PLL_Frontend|PLL_Admin|PLL_Settings|PLL_REST_Request $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->options = &$polylang->options;
		$this->model   = &$polylang->model;
		$this->posts   = &$polylang->posts;
	}

	/**
	 * Duplicates the feature image if the translation does not exist yet
	 *
	 * @since 2.3
	 *
	 * @param int    $id   Thumbnail id
	 * @param string $key  Meta key
	 * @param string $lang Language code
	 * @return int
	 */
	public function duplicate_thumbnail( $id, $key, $lang ) {
		if ( '_thumbnail_id' === $key && ! $tr_id = $this->model->post->get( $id, $lang ) ) {
			$tr_id = $this->posts->create_media_translation( $id, $lang );
		}
		return empty( $tr_id ) ? $id : $tr_id;
	}

	/**
	 * Duplicates a term if the translation does not exist yet
	 *
	 * @since 2.3
	 *
	 * @param int    $tr_term Translated term id
	 * @param int    $term    Source term id
	 * @param string $lang    Language slug
	 * @return int
	 */
	public function duplicate_term( $tr_term, $term, $lang ) {
		if ( empty( $tr_term ) ) {
			$term = get_term( $term );

			if ( $term instanceof WP_Term ) {
				$language = $this->model->term->get_language( $term->term_id );

				if ( $language && $language->slug !== $lang ) { // Create a new term translation only if the source term has a language.
					$tr_parent = empty( $term->parent ) ? 0 : $this->model->term->get_translation( $term->parent, $lang );

					// Duplicate the parent if the parent translation doesn't exist yet.
					if ( empty( $tr_parent ) && ! empty( $term->parent ) ) {
						$tr_parent = $this->duplicate_term( $tr_parent, $term->parent, $lang );
					}

					$args = array(
						'description' => wp_slash( $term->description ),
						'parent'      => $tr_parent,
					);

					if ( $this->options['force_lang'] ) {
						// Share slugs
						$args['slug'] = $term->slug . '___' . $lang;
					} else {
						// Language set from the content: assign a different slug
						// otherwise we would change the current term language instead of creating a new term
						$args['slug'] = sanitize_title( $term->name ) . '-' . $lang;
					}

					$t = wp_insert_term( wp_slash( $term->name ), $term->taxonomy, $args );

					if ( is_array( $t ) && isset( $t['term_id'] ) ) {
						$tr_term = $t['term_id'];
						$this->model->term->set_language( $tr_term, $lang );
						$translations = $this->model->term->get_translations( $term->term_id );
						$translations[ $lang ] = $tr_term;
						$this->model->term->save_translations( $term->term_id, $translations );

						/**
						 * Fires after a term translation is automatically created when duplicating a post
						 *
						 * @since 2.3.8
						 *
						 * @param int    $from Term id of the source term
						 * @param int    $to   Term id of the new term translation
						 * @param string $lang Language code of the new translation
						 */
						do_action( 'pll_duplicate_term', $term->term_id, $tr_term, $lang );
					}
				}
			}
		}
		return $tr_term;
	}

	/**
	 * Copy the content from one post to the other
	 *
	 * @since 1.9
	 *
	 * @param WP_Post             $from_post The post to copy from.
	 * @param WP_Post             $post      The post to copy to.
	 * @param PLL_Language|string $language  The language of the post to copy to.
	 * @return WP_Post|void
	 */
	public function copy_content( $from_post, $post, $language ) {
		global $shortcode_tags;

		$this->post_id  = $post->ID;
		$this->language = $this->model->get_language( $language );

		if ( ! $this->language ) {
			return;
		}

		// Hack shortcodes
		$backup = $shortcode_tags;
		$shortcode_tags = array();

		// Add our own shorcode actions
		if ( $this->options['media_support'] ) {
			add_shortcode( 'gallery', array( $this, 'ids_list_shortcode' ) );
			add_shortcode( 'playlist', array( $this, 'ids_list_shortcode' ) );
			add_shortcode( 'caption', array( $this, 'caption_shortcode' ) );
			add_shortcode( 'wp_caption', array( $this, 'caption_shortcode' ) );
		}

		$post->post_title   = $from_post->post_title;
		$post->post_name    = wp_unique_post_slug( $from_post->post_name, $post->ID, $post->post_status, $post->post_type, $post->post_parent );
		$post->post_excerpt = $this->translate_content( $from_post->post_excerpt );
		$post->post_content = $this->translate_content( $from_post->post_content );

		// Get the shorcodes back
		$shortcode_tags = $backup;

		return $post;
	}

	/**
	 * Get the media translation id
	 * Create the translation if it does not exist
	 * Attach the media to the parent post
	 *
	 * @since 1.9
	 *
	 * @param int $id Media id
	 * @return int Translated media id
	 */
	public function translate_media( $id ) {
		global $wpdb;

		if ( ! $tr_id = $this->model->post->get( $id, $this->language ) ) {
			$tr_id = $this->posts->create_media_translation( $id, $this->language );
		}

		// If we don't have a translation and did not success to create one, return current media
		if ( empty( $tr_id ) ) {
			return $id;
		}

		// Attach to the translated post
		if ( ! wp_get_post_parent_id( $tr_id ) ) {
			// Query inspired by wp_media_attach_action()
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_parent = %d WHERE post_type = 'attachment' AND ID = %d", $this->post_id, $tr_id ) );
			clean_attachment_cache( $tr_id );
		}

		return $tr_id;
	}

	/**
	 * Translates the 'gallery' and 'playlist' shortcodes
	 *
	 * @since 1.9
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param null   $null Shortcode content, not used.
	 * @param string $tag  Shortcode tag (either 'gallery' or 'playlist').
	 * @return string Translated shortcode.
	 */
	public function ids_list_shortcode( $attr, $null, $tag ) {
		$out = array();

		foreach ( $attr as $k => $v ) {
			if ( 'ids' == $k ) {
				$ids    = explode( ',', $v );
				$tr_ids = array();
				foreach ( $ids as $id ) {
					$tr_ids[] = $this->translate_media( (int) $id );
				}
				$v = implode( ',', $tr_ids );
			}
			$out[] = $k . '="' . $v . '"';
		}

		return '[' . $tag . ' ' . implode( ' ', $out ) . ']';
	}

	/**
	 * Translates the caption shortcode
	 * Compatible only with the new style introduced in WP 3.4
	 *
	 * @since 1.9
	 *
	 * @param array  $attr    Shortcode attrbute
	 * @param string $content Shortcode content
	 * @param string $tag     Shortcode tag (either 'caption' or 'wp-caption')
	 * @return string Translated shortcode
	 */
	public function caption_shortcode( $attr, $content, $tag ) {
		// Translate the caption id
		$out = array();

		foreach ( $attr as $k => $v ) {
			if ( 'id' == $k ) {
				$idarr = explode( '_', $v );
				$id    = $idarr[1]; // Remember this
				$tr_id = $idarr[1] = $this->translate_media( (int) $id );
				$v     = implode( '_', $idarr );
			}
			$out[] = $k . '="' . $v . '"';
		}

		// Translate the caption content
		if ( ! empty( $id ) && ! empty( $tr_id ) ) {
			$p    = get_post( (int) $id );
			$tr_p = get_post( $tr_id );
			if ( $p && $tr_p ) {
				$content = str_replace( $p->post_excerpt, $tr_p->post_excerpt, $content );
			}
		}

		return '[' . $tag . ' ' . implode( ' ', $out ) . ']' . $content . '[/' . $tag . ']';
	}

	/**
	 * Translate images and caption in inner html
	 *
	 * Since 2.5
	 *
	 * @param string $content HTML string
	 * @return string
	 */
	public function translate_html( $content ) {
		$textarr = wp_html_split( $content ); // Since 4.2.3

		if ( $this->options['media_support'] ) {
			$tr_id = false;
			foreach ( $textarr as $i => $text ) {
				// Translate img class and alternative text
				if ( 0 === strpos( $text, '<img' ) ) {
					$tr_id = $this->translate_img( $textarr[ $i ] );

					// Translate <figcaption> if any
					if ( $tr_id && isset( $textarr[ $i + 2 ] ) && '<figcaption>' === $textarr[ $i + 2 ] ) {
						$tr_post = get_post( $tr_id );
						if ( ! empty( $tr_post->post_excerpt ) ) {
							$textarr[ $i + 3 ] = $tr_post->post_excerpt;
						}
					}
				}
			}
		}

		return implode( $textarr );
	}

	/**
	 * Translate shortcodes and <img> attributes in a given text
	 *
	 * @since 1.9
	 *
	 * @param string $content Text to translate
	 * @return string Translated text
	 */
	public function translate_content( $content ) {
		if ( function_exists( 'parse_blocks' ) && function_exists( 'has_blocks' ) && has_blocks( $content ) ) {
			$blocks  = parse_blocks( $content );
			$blocks  = $this->translate_blocks( $blocks );
			$content = serialize_blocks( $blocks );
		} else {
			$content = do_shortcode( $content ); // Translate shortcodes
			$content = $this->translate_html( $content );
		}

		return $content;
	}

	/**
	 * Translates <img> 'class' and 'alt' attributes
	 *
	 * @since 1.9
	 * @since 2.5 The html is passed by reference and the return value is the image id
	 *
	 * @param string $text Reference to <img> html with attributes
	 * @return bool|int Translated image id if exist
	 */
	public function translate_img( &$text ) {
		$attributes = wp_kses_attr_parse( $text ); // since WP 4.2.3

		if ( ! is_array( $attributes ) ) {
			return false;
		}

		// Replace class
		foreach ( $attributes as $k => $attr ) {
			if ( 0 === strpos( $attr, 'class' ) && preg_match( '#wp\-image\-([0-9]+)#', $attr, $matches ) && $id = $matches[1] ) {
				$tr_id            = $this->translate_media( $id );
				$attributes[ $k ] = str_replace( 'wp-image-' . $id, 'wp-image-' . $tr_id, $attr );
			}

			if ( preg_match( '#^data\-id="([0-9]+)#', $attr, $matches ) && $id = $matches[1] ) {
				$tr_id            = $this->translate_media( $id );
				$attributes[ $k ] = str_replace( 'data-id="' . $id, 'data-id="' . $tr_id, $attr );
			}

			if ( 0 === strpos( $attr, 'data-link' ) && preg_match( '#attachment_id=([0-9]+)#', $attr, $matches ) && $id = $matches[1] ) {
				$tr_id            = $this->translate_media( $id );
				$attributes[ $k ] = str_replace( 'attachment_id=' . $id, 'attachment_id=' . $tr_id, $attr );
			}
		}

		if ( ! empty( $tr_id ) ) {
			// Got a tr_id, attempt to replace the alt text
			foreach ( $attributes as $k => $attr ) {
				if ( 0 === strpos( $attr, 'alt' ) && $alt = get_post_meta( $tr_id, '_wp_attachment_image_alt', true ) ) {
					$attributes[ $k ] = 'alt="' . esc_attr( $alt ) . '" ';
				}
			}
		}

		$text = implode( $attributes );

		return empty( $tr_id ) ? false : $tr_id;
	}

	/**
	 * Recursively translate blocks
	 *
	 * @since 2.5
	 *
	 * @param array $blocks An array of blocks arrays
	 * @return array
	 */
	public function translate_blocks( $blocks ) {
		foreach ( $blocks as $k => $block ) {
			switch ( $block['blockName'] ) {
				case 'core/block':
					if ( $this->model->is_translated_post_type( 'wp_block' ) && isset( $block['attrs']['ref'] ) && false !== $tr_id = $this->model->post->get( $block['attrs']['ref'], $this->language ) ) {
						$blocks[ $k ]['attrs']['ref'] = $tr_id;
					}
					break;

				case 'core/latest-posts':
					if ( isset( $block['attrs']['categories'] ) && $tr_id = $this->model->term->get( $block['attrs']['categories'], $this->language ) ) {
						$blocks[ $k ]['attrs']['categories'] = $tr_id;
					} else {
						unset( $blocks[ $k ]['attrs']['categories'] );
					}
					break;
			}

			if ( $this->options['media_support'] ) {
				switch ( $block['blockName'] ) {
					case 'core/audio':
					case 'core/video':
					case 'core/cover':
						if ( array_key_exists( 'id', $blocks[ $k ]['attrs'] ) ) {
							$blocks[ $k ]['attrs']['id'] = $this->translate_media( $block['attrs']['id'] );
						}
						break;

					case 'core/image':
						if ( array_key_exists( 'id', $blocks[ $k ]['attrs'] ) ) {
							$blocks[ $k ]['attrs']['id'] = $this->translate_media( $block['attrs']['id'] );
						}
						$blocks[ $k ] = $this->translate_block_content( $blocks[ $k ] );
						break;

					case 'core/file':
						$source_id = $block['attrs']['id'];
						$tr_id = $this->translate_media( $source_id );
						$blocks[ $k ]['attrs']['id'] = $tr_id;
						$textarr = wp_html_split( $block['innerHTML'] );
						$source_post = get_post( $source_id );
						$replace_file_link_text = 0 === strpos( $textarr[3], '<a' ) && $textarr[4] === $source_post->post_title;
						if ( $replace_file_link_text ) {
							$tr_post = get_post( $tr_id );
							if ( $tr_post ) {
								$textarr[4] = $tr_post->post_title;
								$blocks[ $k ]['innerContent'][0] = implode( $textarr );
								$blocks[ $k ]['innerHTML'] = implode( $textarr );
							}
						}
						break;

					case 'core/gallery':
						if ( is_array( $block['attrs']['ids'] ) ) {
							foreach ( $block['attrs']['ids'] as $n => $id ) {
								$blocks[ $k ]['attrs']['ids'][ $n ] = $this->translate_media( $id );
							}
						}
						$blocks[ $k ] = $this->translate_block_content( $blocks[ $k ] );
						break;

					case 'core/media-text':
						$blocks[ $k ]['attrs']['mediaId'] = $this->translate_media( $block['attrs']['mediaId'] );
						$blocks[ $k ]['innerContent'][0] = $this->translate_html( $block['innerContent'][0] );
						break;

					case 'core/shortcode':
						$blocks[ $k ]['innerContent'][0] = do_shortcode( $block['innerContent'][0] );
						$blocks[ $k ]['innerHTML'] = do_shortcode( $block['innerHTML'] );
						break;

					default:
						if ( ! empty( $block['innerHTML'] ) ) {
							$blocks[ $k ] = $this->translate_block_content( $blocks[ $k ] );
						}
						break;
				}
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				$blocks[ $k ]['innerBlocks'] = $this->translate_blocks( $block['innerBlocks'] );
			}
		}

		/**
		 * Filters parsed blocks after core blocks have been translated
		 *
		 * @since 2.5.3
		 *
		 * @param array  $blocks List of blocks
		 * @param string $lang   Language of target
		 */
		return apply_filters( 'pll_translate_blocks', $blocks, $this->language->slug );
	}

	/**
	 * Updates the block properties with a translation if it is found.
	 *
	 * @since 2.9
	 *
	 * @param array $block An array mimicking the structure of {@see https://github.com/WordPress/WordPress/blob/5.5.1/wp-includes/class-wp-block-parser.php WP_Block_Parser_Block}.
	 * @return array The updated array formatted block.
	 */
	public function translate_block_content( $block ) {
		$inner_content_nb = count( $block['innerContent'] );
		for ( $i = 0; $i < $inner_content_nb; $i++ ) {
			if ( ! empty( $block['innerContent'][ $i ] ) ) {
				$html = do_shortcode( $block['innerContent'][ $i ] ); // Translate shortcodes.
				$html = $this->translate_html( $html ); // Translate inline images.

				$block['innerContent'][ $i ] = $html;
			}
		}
		$html = do_shortcode( $block['innerHTML'] ); // Translate shortcodes.
		$block['innerHTML'] = $this->translate_html( $html );

		return $block;
	}
}
