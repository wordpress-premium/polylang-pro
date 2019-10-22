<?php

/**
 * Links Model for translating slugs
 *
 * @since 1.9
 */
class PLL_Translate_Slugs_Model {
	public $translated_slugs;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->model       = &$polylang->model;
		$this->links_model = &$polylang->links_model;

		add_action( 'switch_blog', array( $this, 'switch_blog' ), 20, 2 );

		add_action( 'wp_loaded', array( $this, 'init_translated_slugs' ), 1 );

		// Make sure to prepare rewrite rules when flushing.
		add_action( 'pre_option_rewrite_rules', array( $this, 'prepare_rewrite_rules' ), 20 ); // After Polylang.

		// Flush rewrite rules when saving string translations.
		add_action( 'pll_save_strings_translations', array( $this, 'flush_rewrite_rules' ) );

		// Register strings for translated slugs.
		add_action( 'admin_init', array( $this, 'register_slugs' ) );
		add_filter( 'pll_sanitize_string_translation', array( $this, 'sanitize_string_translation' ), 10, 3 );

		// Reset cache when adding or modifying languages.
		add_action( 'pll_add_language', array( $this, 'clean_cache' ) );
		add_action( 'pll_update_language', array( $this, 'clean_cache' ) );

		// Make sure we have all (possibly new) translatable slugs in the strings list table.
		if ( $polylang instanceof PLL_Settings && isset( $_GET['page'] ) && 'mlang_strings' == $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification
			delete_transient( 'pll_translated_slugs' );
		}
	}

	/**
	 * Updates the list of slugs to translate when switching blog
	 *
	 * @since 1.9
	 *
	 * @param int $new_blog The blog id we switch to.
	 * @param int $old_blog The blog id we switch from.
	 */
	public function switch_blog( $new_blog, $old_blog ) {
		$plugins = ( $sitewide_plugins = get_site_option( 'active_sitewide_plugins' ) ) && is_array( $sitewide_plugins ) ? array_keys( $sitewide_plugins ) : array();
		$plugins = array_merge( $plugins, get_option( 'active_plugins', array() ) );

		// FIXME should I wait for an action as I must have *all* registered post types and taxonomies.
		if ( $new_blog != $old_blog && in_array( POLYLANG_BASENAME, $plugins ) && get_option( 'polylang' ) ) {
			$this->init_translated_slugs();
		}
	}

	/**
	 * Initializes the list of translated slugs
	 * Need to wait for all post types and taxonomies to be registered
	 *
	 * @since 1.9
	 */
	public function init_translated_slugs() {
		$this->translated_slugs = $this->get_translatable_slugs();

		// Keep only the slugs which are translated to avoid unnecessary rewrite rules.
		foreach ( $this->translated_slugs as $key => $value ) {
			if ( 1 == count( array_unique( $value['translations'] ) ) && reset( $value['translations'] ) == $value['slug'] ) {
				unset( $this->translated_slugs[ $key ] );
			}
		}
	}

	/**
	 * Translates a slug in a permalink ( from original slug )
	 *
	 * @since 1.9
	 *
	 * @param string $link The url to modify.
	 * @param object $lang The language.
	 * @param string $type The type of slug to translate.
	 * @return string Modified url.
	 */
	public function translate_slug( $link, $lang, $type ) {
		if ( ! empty( $lang ) && isset( $this->translated_slugs[ $type ] ) && ! empty( $this->translated_slugs[ $type ]['slug'] ) ) {
			$link = preg_replace(
				'#\/' . $this->translated_slugs[ $type ]['slug'] . '(\/|$)#',
				'/' . $this->get_translated_slug( $type, $lang->slug ) . '$1',
				$link
			);
		}
		return $link;
	}

	/**
	 * Translates a slug in a permalink ( from an already translated slug )
	 *
	 * @since 1.9
	 *
	 * @param string $link The url to modify.
	 * @param object $lang The language.
	 * @param string $type The type of slug to translate.
	 * @return string Modified url.
	 */
	public function switch_translated_slug( $link, $lang, $type ) {
		if ( isset( $this->translated_slugs[ $type ] ) && ! empty( $this->translated_slugs[ $type ]['slug'] ) ) {
			$slugs   = $this->translated_slugs[ $type ]['translations'];
			$slugs[] = $this->translated_slugs[ $type ]['slug'];
			$slugs   = $this->encode_deep( $slugs );

			$link = preg_replace(
				'#\/(' . implode( '|', array_unique( $slugs ) ) . ')(\/|$)#',
				'/' . $this->encode_deep( $this->translated_slugs[ $type ]['translations'][ $lang->slug ] ) . '$2',
				$link
			);
		}
		return $link;
	}

	/**
	 * Returns informations on translatable slugs
	 * and stores them in a transient
	 *
	 * @since 1.9
	 *
	 * @return array
	 */
	public function get_translatable_slugs() {
		global $wp_rewrite;

		$slugs = get_transient( 'pll_translated_slugs' );

		if ( false === $slugs ) {
			$slugs = array();

			foreach ( $this->model->get_languages_list() as $language ) {
				$mo = new PLL_MO();
				$mo->import_from_db( $language );

				// Post types.
				foreach ( get_post_types() as $type ) {
					$type = get_post_type_object( $type );

					if ( ! empty( $type->rewrite['slug'] ) && $this->model->is_translated_post_type( $type->name ) ) {
						$slug = preg_replace( '#%.+?%#', '', $type->rewrite['slug'] ); // For those adding a taxonomy base in custom post type link. See http://wordpress.stackexchange.com/questions/94817/add-category-base-to-url-in-custom-post-type-taxonomy.
						$slug = trim( $slug, '/' ); // It seems that some plugins add / (ex: WooCommerce).
						$slugs[ $type->name ]['slug'] = $slug;
						$tr_slug = $mo->translate( $slug );
						$slugs[ $type->name ]['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;

						// Post types archives.
						if ( ! empty( $type->has_archive ) ) {
							if ( true === $type->has_archive ) {
								$slugs[ 'archive_' . $type->name ]['hide'] = true;
							} else {
								$slug = $type->has_archive;
							}

							$slugs[ 'archive_' . $type->name ]['slug'] = $slug;
							$tr_slug = $mo->translate( $slug );
							$slugs[ 'archive_' . $type->name ]['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;
						}
					}
				}

				// Taxonomies.
				foreach ( get_taxonomies() as $tax ) {
					$tax = get_taxonomy( $tax );
					if ( ! empty( $tax->rewrite['slug'] ) && ( $this->model->is_translated_taxonomy( $tax->name ) || 'post_format' == $tax->name ) ) {
						$slug = trim( $tax->rewrite['slug'], '/' ); // It seems that some plugins add / (ex: WooCommerce for product attributes).
						$slugs[ $tax->name ]['slug'] = $slug;
						$tr_slug = $mo->translate( $slug );
						$slugs[ $tax->name ]['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;
					}
				}

				// Post formats.
				// get_theme_support sends an array of arrays.
				$formats = get_theme_support( 'post-formats' );
				if ( isset( $formats[0] ) && is_array( $formats[0] ) ) {
					foreach ( $formats[0] as $format ) {
						$slugs[ 'post-format-' . $format ]['slug'] = $format;
						$tr_format = $mo->translate( $format );
						$slugs[ 'post-format-' . $format ]['translations'][ $language->slug ] = empty( $tr_format ) ? $format : $tr_format;
					}
				}

				// Misc.
				foreach ( array( 'author', 'search', 'attachment' ) as $slug ) {
					$slugs[ $slug ]['slug'] = $slug;
					$tr_slug = $mo->translate( $slug );
					$slugs[ $slug ]['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;
				}

				// Paged pages.
				$slugs['paged']['slug'] = 'page';
				$tr_slug = $mo->translate( 'page' );
				$slugs['paged']['translations'][ $language->slug ] = empty( $tr_slug ) ? 'page' : $tr_slug;

				// /blog/.
				if ( ! empty( $wp_rewrite->front ) ) {
					$slug = trim( $wp_rewrite->front, '/' );
					$slugs['front']['slug'] = $slug;
					$tr_slug = $mo->translate( $slug );
					$slugs['front']['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;
				}

				/**
				 * Filter the list of translated slugs
				 *
				 * @since 1.9
				 *
				 * @param array  $slugs    The list of slugs.
				 * @param object $language The language object.
				 * @param object $mo       The translations object.
				 */
				$slugs = apply_filters_ref_array( 'pll_translated_slugs', array( $slugs, $language, &$mo ) );
			}

			// Make sure to store the transient only after 'wp_loaded' has been fired to avoid a conflict with Page Builder 2.4.10+.
			if ( did_action( 'wp_loaded' ) ) {
				set_transient( 'pll_translated_slugs', $slugs );
			}
		}

		return $slugs;
	}

	/**
	 * Prepares rewrite rules filters to translate slugs
	 *
	 * @since 1.9
	 *
	 * @param array $pre Not used.
	 * @return unmodified $pre
	 */
	public function prepare_rewrite_rules( $pre ) {
		if ( did_action( 'wp_loaded' ) && ! has_filter( 'rewrite_rules_array', array( $this, 'rewrite_translated_slug' ) ) ) {
			$this->init_translated_slugs();
			foreach ( $this->links_model->get_rewrite_rules_filters() as $type ) {
				add_filter( $type . '_rewrite_rules', array( $this, 'rewrite_translated_slug' ), 5 );
			}

			add_filter( 'rewrite_rules_array', array( $this, 'rewrite_translated_slug' ), 5 );
		}

		return $pre;
	}

	/**
	 * Flush rewrite rules when saving strings translations
	 *
	 * @since 1.9
	 */
	public function flush_rewrite_rules() {
		delete_transient( 'pll_translated_slugs' );
		flush_rewrite_rules();
	}

	/**
	 * Returns the rewrite rule pattern for the new slug
	 *
	 * @since 1.9
	 * @since 2.2 Add the $capture parameter
	 *
	 * @param string $type    The type of slug.
	 * @param bool   $capture Whether the slugs must be captured, defaults to false.
	 * @return string The pattern.
	 */
	protected function get_translated_slugs_pattern( $type, $capture = false ) {
		$slugs[] = $this->translated_slugs[ $type ]['slug'];

		foreach ( array_keys( $this->translated_slugs[ $type ]['translations'] ) as $lang ) {
			$slugs[] = $this->translated_slugs[ $type ]['translations'][ $lang ];
		}

		return ( $capture ? '(' : '(?:' ) . implode( '|', array_unique( $slugs ) ) . ')/';
	}

	/**
	 * Translates a slug in rewrite rules
	 *
	 * @since 1.9
	 *
	 * @param array  $rules Rewrite rules.
	 * @param string $type  The type of slug to translate.
	 * @return array Modified rewrite rules.
	 */
	protected function translate_rule( $rules, $type ) {
		if ( empty( $this->translated_slugs[ $type ] ) ) {
			return $rules;
		}

		$old = $this->translated_slugs[ $type ]['slug'] . '/';
		$new = $this->get_translated_slugs_pattern( $type );

		foreach ( $rules as $key => $rule ) {
			if ( false !== $found = strpos( $key, $old ) ) {
				$new_key = 0 === $found ? str_replace( $old, $new, $key ) : str_replace( '/' . $old, '/' . $new, $key );
				$newrules[ $new_key ] = $rule;
			} else {
				$newrules[ $key ] = $rule;
			}
		}
		return $newrules;
	}

	/**
	 * Translates the post format slug in rewrite rules
	 *
	 * @since 1.9
	 *
	 * @param array $rules Rewrite rules.
	 * @return array Modified rewrite rules.
	 */
	protected function translate_post_format_rule( $rules ) {
		$newrules = array();
		$formats = get_theme_support( 'post-formats' );

		if ( isset( $formats[0] ) && is_array( $formats[0] ) ) {
			foreach ( $formats[0] as $format ) {
				if ( isset( $this->translated_slugs[ 'post-format-' . $format ] ) ) {
					$new_slug = '/' . $this->get_translated_slugs_pattern( 'post-format-' . $format, true );
					foreach ( $rules as $key => $rule ) {
						$newrules[ str_replace( '/([^/]+)/', $new_slug, $key ) ] = str_replace( '$matches[1]', $format, $rule );
					}
				}
			}
		}

		return $newrules + $rules;
	}

	/**
	 * Translates the post type archive in rewrite rules
	 *
	 * @since 1.9
	 *
	 * @param array $rules Rewrite rules.
	 * @return array Modified rewrite rules.
	 */
	protected function translate_post_type_archive_rule( $rules ) {
		$cpts = array_intersect( $this->model->get_translated_post_types(), get_post_types( array( '_builtin' => false ) ) );

		foreach ( $rules as $key => $rule ) {
			$query = wp_parse_url( $rule, PHP_URL_QUERY );
			parse_str( $query, $qv );

			if ( ! empty( $cpts ) && ! empty( $qv['post_type'] ) && in_array( $qv['post_type'], $cpts ) && ! strpos( $rule, 'name=' ) && isset( $this->translated_slugs[ 'archive_' . $qv['post_type'] ] ) ) {
				$new_slug = $this->get_translated_slugs_pattern( 'archive_' . $qv['post_type'] );
				$newrules[ str_replace( $this->translated_slugs[ 'archive_' . $qv['post_type'] ]['slug'] . '/', $new_slug, $key ) ] = $rule;
			} else {
				$newrules[ $key ] = $rule;
			}
		}
		return $newrules;
	}

	/**
	 * Translates the page slug in rewrite rules
	 *
	 * @since 1.9
	 *
	 * @param array $rules Rewrite rules.
	 * @return array Modified rewrite rules.
	 */
	protected function translate_paged_rule( $rules ) {
		if ( empty( $this->translated_slugs['paged'] ) ) {
			return $rules;
		}

		$newrules = array();

		$old = $this->translated_slugs['paged']['slug'] . '/';
		$new = $this->get_translated_slugs_pattern( 'paged' );

		foreach ( $rules as $key => $rule ) {
			if ( strpos( $key, '/page/' ) && preg_match( '#\[\d\]|\$\d#', $rule ) ) {
				$newrules[ str_replace( '/' . $old, '/' . $new, $key ) ] = $rule;
			} elseif ( 0 === strpos( $key, 'page/' ) && preg_match( '#\[\d\]|\$\d#', $rule ) ) {
				// Special case for root
				$newrules[ str_replace( $old, $new, $key ) ] = $rule;
			} else {
				$newrules[ $key ] = $rule;
			}
		}

		return $newrules;
	}

	/**
	 * Modifies rewrite rules to translate post types and taxonomies slugs
	 *
	 * @since 1.9
	 *
	 * @param array $rules Rewrite rules.
	 * @return array Modified rewrite rules.
	 */
	public function rewrite_translated_slug( $rules ) {
		$filter = str_replace( '_rewrite_rules', '', current_filter() );

		$rules = $this->translate_paged_rule( $rules ); // Important that it is the first.

		if ( 'rewrite_rules_array' === $filter ) {
			$rules = $this->translate_post_type_archive_rule( $rules );
		} else {
			if ( 'post_format' === $filter ) {
				$rules = $this->translate_post_format_rule( $rules );
			}

			$rules = $this->translate_rule( $rules, $filter );
		}

		$rules = $this->translate_rule( $rules, 'attachment' );
		$rules = $this->translate_rule( $rules, 'front' );

		return $rules;
	}

	/**
	 * Register strings for translated slugs
	 *
	 * @since 1.9
	 */
	public function register_slugs() {
		foreach ( $this->get_translatable_slugs() as $key => $type ) {
			if ( empty( $type['hide'] ) ) {
				pll_register_string( 'slug_' . $key, $type['slug'], __( 'URL slugs', 'polylang-pro' ) );
			}
		}
	}

	/**
	 * Performs the sanitization ( before saving in DB ) of slugs translations
	 *
	 * @since 1.9
	 *
	 * @param string $translation Translation to sanitize.
	 * @param string $name        Unique name for the string, not used.
	 * @param string $context     The group in which the string is registered.
	 * @return string
	 */
	public function sanitize_string_translation( $translation, $name, $context ) {
		if ( 0 === strpos( $name, 'slug_' ) ) {
			// Inspired by category base sanitization.
			$translation = preg_replace( '#/+#', '/', str_replace( '#', '', $translation ) );
			$translation = trim( $translation, '/' );
			$translation = esc_url_raw( $translation );
			$translation = str_replace( 'http://', '', $translation );
		}
		return $translation;
	}

	/**
	 * Deletes the transient when adding or modifying a language
	 *
	 * @since 1.9
	 */
	public function clean_cache() {
		delete_transient( 'pll_translated_slugs' );
	}

	/**
	 * Get the translated slug.
	 *
	 * Encoding the paged slug is necessary to prevent the WordPress redirect_canonical
	 * function to wrongly redirect to a 404 page
	 *
	 * @since 2.2
	 *
	 * @param string $type The type of slug to translate.
	 * @param string $lang The language slug.
	 * @return string
	 */
	public function get_translated_slug( $type, $lang ) {
		$translation = $this->translated_slugs[ $type ]['translations'][ $lang ];
		$translation = $this->encode_deep( $translation );
		return $translation;
	}

	/**
	 * Recursively rawurlencode an array of slugs while preserving forward slashes
	 *
	 * @since 2.6
	 *
	 * @param mixed $slug The slug or the array of slug to encode.
	 * @return mixed
	 */
	public function encode_deep( $slug ) {
		if ( is_array( $slug ) ) {
			return array_map( array( $this, 'encode_deep' ), $slug );
		}
		return implode( '/', array_map( 'rawurlencode', explode( '/', $slug ) ) );
	}
}
