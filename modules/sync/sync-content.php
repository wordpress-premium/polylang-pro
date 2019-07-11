<?php

/**
 * Smart copy of post content
 *
 * @since 2.6
 */
class PLL_Sync_Content {
	public $options, $model, $posts;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param object $polylang
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
		return $tr_term;
	}

	/**
	 * Copy the content from one post to the other
	 *
	 * @since 1.9
	 *
	 * @param object        $from_post The post to copy from
	 * @param object        $post      The post to copy to
	 * @param object|string $language  The language of the post to copy to
	 */
	public function copy_content( $from_post, $post, $language ) {
		global $shortcode_tags;

		$this->post_id  = $post->ID;
		$this->language = $this->model->get_language( $language );

		if ( ! $from_post || ! $this->language ) {
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
	 * @param array  $attr Shortcode attribute
	 * @param null   $null
	 * @param string $tag  Shortcode tag (either 'gallery' or 'playlist')
	 * @return string Translated shortcode
	 */
	public function ids_list_shortcode( $attr, $null, $tag ) {
		foreach ( $attr as $k => $v ) {
			if ( 'ids' == $k ) {
				$ids    = explode( ',', $v );
				$tr_ids = array();
				foreach ( $ids as $id ) {
					$tr_ids[] = $this->translate_media( $id );
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
		foreach ( $attr as $k => $v ) {
			if ( 'id' == $k ) {
				$idarr = explode( '_', $v );
				$id    = $idarr[1]; // Remember this
				$tr_id = $idarr[1] = $this->translate_media( $id );
				$v     = implode( '_', $idarr );
			}
			$out[] = $k . '="' . $v . '"';
		}

		// Translate the caption content
		if ( ! empty( $id ) ) {
			$p       = get_post( $id );
			$tr_p    = get_post( $tr_id );
			$content = str_replace( $p->post_excerpt, $tr_p->post_excerpt, $content );
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
			$tr_id = $caption = false;
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
			$content = '';
			foreach ( $blocks as $block ) {
				$content = $this->serialize_block( $block, $content );
			}
		} else {
			$content = do_shortcode( $content ); // Translate shorcodes
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
					if ( $this->model->is_translated_post_type( 'wp_block' ) && isset( $block['attrs']['ref'] ) && $tr_id = $this->model->post->get( $block['attrs']['ref'], $this->language ) ) {
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
						$blocks[ $k ]['attrs']['id'] = $this->translate_media( $block['attrs']['id'] );
						break;

					case 'core/image':
						$blocks[ $k ]['attrs']['id'] = $this->translate_media( $block['attrs']['id'] );
						$blocks[ $k ]['innerHTML']   = $this->translate_html( $block['innerHTML'] );
						break;

					case 'core/file':
						$tr_id = $this->translate_media( $block['attrs']['id'] );
						$blocks[ $k ]['attrs']['id'] = $tr_id;
						$textarr = wp_html_split( $block['innerHTML'] );
						if ( 0 === strpos( $textarr[3], '<a' ) ) {
							$tr_post = get_post( $tr_id );
							$textarr[4] = $tr_post->post_title;
							$blocks[ $k ]['innerHTML'] = implode( $textarr );
						}
						break;

					case 'core/gallery':
						if ( is_array( $block['attrs']['ids'] ) ) {
							foreach ( $block['attrs']['ids'] as $n => $id ) {
								$blocks[ $k ]['attrs']['ids'][ $n ] = $this->translate_media( $id );
							}
						}
						$blocks[ $k ]['innerHTML'] = $this->translate_html( $block['innerHTML'] );
						break;

					case 'core/media-text':
						$blocks[ $k ]['attrs']['mediaId'] = $this->translate_media( $block['attrs']['mediaId'] );
						$blocks[ $k ]['innerContent'][0] = $this->translate_html( $block['innerContent'][0] );
						break;

					case 'core/shortcode':
						$blocks[ $k ]['innerHTML'] = do_shortcode( $block['innerHTML'] );
						break;

					default:
						if ( ! empty( $block['innerHTML'] ) ) {
							$html = do_shortcode( $block['innerHTML'] ); // Translate shortcodes
							$html = $this->translate_html( $html ); // Translate inline images

							$blocks[ $k ]['innerHTML'] = $html;
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
		 * @return array
		 */
		return apply_filters( 'pll_translate_blocks', $blocks, $this->language->slug );
	}

	/**
	 * Recursively serialize a blocks array to save it in a post content
	 *
	 * @since 2.5
	 *
	 * @param array  $block   A block array
	 * @param string $content Partially serialized blocks used in the recursive process
	 * @return string
	 */
	public function serialize_block( $block, $content ) {
		if ( ! empty( $block['blockName'] ) ) {
			$name = preg_replace( '#^core\/#', '', $block['blockName'] );

			// Check if $block['attrs'] is an array as it could be an empty object. See: https://core.trac.wordpress.org/ticket/45316
			$attrs = is_array( $block['attrs'] ) && ! empty( $block['attrs'] ) ? ' ' . wp_json_encode( $block['attrs'] ) : '';

			$content .= "<!-- wp:{$name}{$attrs}";

			if ( empty( $block['innerBlocks'] ) && empty( $block['innerHTML'] ) ) {
				$content .= ' /-->';
				return $content;
			}

			$content .= ' -->';

			if ( ! empty( $block['innerBlocks'] ) ) {
				$i = 0;
				foreach ( $block['innerContent'] as $inner ) {
					if ( ! empty( $inner ) ) {
						$content .= $inner;
					} else {
						$content = $this->serialize_block( $block['innerBlocks'][ $i ], $content );
						$i++;
					}
				}
			} elseif ( ! empty( $block['innerHTML'] ) ) {
				$content .= $block['innerHTML'];
			}

			$content .= "<!-- /wp:{$name} -->";
		} else {
			$content .= $block['innerHTML'];
		}

		return $content;
	}
}
