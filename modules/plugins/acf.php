<?php

/**
 * Manages compatibility with Advanced Custom Fields Pro
 * Version tested 5.6.0
 *
 * @since 2.0
 */
class PLL_ACF {
	/**
	 * Initializes filters for ACF
	 *
	 * @since 2.0
	 */
	public function init() {
		add_action( 'add_meta_boxes_acf-field-group', array( $this, 'remove_sync' ) );
		add_action( 'add_meta_boxes_acf-field-group', array( $this, 'duplicate_field_group' ) );
		add_filter( 'acf/duplicate_field/type=clone', array( $this, 'duplicate_clone_field' ) );

		add_filter( 'acf/location/rule_match/page_type', array( $this, 'rule_match_page_type' ), 20, 3 ); // After ACF

		add_filter( 'pll_get_post_types', array( $this, 'get_post_types' ), 10, 2 );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_action( 'wp_ajax_acf_post_lang_choice', array( $this, 'acf_post_lang_choice' ) );

		add_filter( 'acf/load_value', array( $this, 'load_value' ), 10, 3 );
		add_filter( 'acf/load_value/type=repeater', array( $this, 'load_value' ), 20, 3 );
		add_filter( 'acf/load_value/type=flexible_content', array( $this, 'load_value' ), 20, 3 );

		add_filter( 'acf/update_value', array( $this, 'store_updated_field' ), 10, 3 );
		add_filter( 'acf/delete_value', array( $this, 'store_updated_field' ), 10, 3 );
		add_action( 'pll_save_term', array( $this, 'store_term_fields' ), 5, 2 ); // Before PLL_Sync_Metas
		add_action( 'pll_duplicate_term', array( $this, 'store_duplicated_term_fields' ), 5 ); // Before PLL_Sync_Metas

		add_filter( 'pll_copy_post_metas', array( $this, 'get_post_metas_to_copy' ), 999, 3 ); // Very late to wait for the complete list of synchronized fields
		add_filter( 'pll_copy_term_metas', array( $this, 'get_term_metas_to_copy' ), 10, 3 );
		add_filter( 'pll_translate_post_meta', array( $this, 'translate_meta' ), 10, 5 );
		add_filter( 'pll_translate_term_meta', array( $this, 'translate_meta' ), 10, 4 );
	}

	/**
	 * Deactivate synchronization for ACF field groups
	 *
	 * @since 2.1
	 */
	public function remove_sync() {
		foreach ( pll_languages_list() as $lang ) {
			remove_action( "pll_before_post_translation_{$lang}", array( PLL()->sync_post->buttons[ $lang ], 'add_icon' ) );
		}
	}

	/**
	 * Duplicate the field group if content duplication is activated
	 *
	 * @since 2.3
	 *
	 * @param object $post Current post object
	 */
	public function duplicate_field_group( $post ) {
		if ( PLL()->model->is_translated_post_type( 'acf-field-group' ) && 'post-new.php' === $GLOBALS['pagenow'] && isset( $_GET['from_post'], $_GET['new_lang'] ) ) {
			// Capability check already done in post-new.php
			check_admin_referer( 'new-post-translation' );

			$duplicate_options = get_user_meta( get_current_user_id(), 'pll_duplicate_content', true );

			$active = ! empty( $duplicate_options ) && ! empty( $duplicate_options['acf-field-group'] );

			if ( $active ) {
				acf_duplicate_field_group( (int) $_GET['from_post'], $post->ID );
				if ( function_exists( 'acf_delete_cache' ) ) {
					acf_delete_cache( 'get_fields/ID=' . $post->ID ); // Needed for ACF 5.4.0, removed in ACF 5.7.11
				}
			}
		}
	}

	/**
	 * Returns an array containing all the field data for a given field name
	 * Unlike the original ACF function, it works for clone fields
	 *
	 * @since 2.6.2
	 *
	 * @param string     $key     The field name or key.
	 * @param string|int $post_id The post_id of which the value is saved against.
	 * @return array|bool
	 */
	protected function get_field_object( $key, $post_id ) {
		$field = get_field_object( $key, $post_id );

		if ( $field ) {
			return $field;
		}

		$post_id   = acf_get_valid_post_id( $post_id );
		$field_key = acf_get_reference( $key, $post_id );
		$field_key = substr( $field_key, -19 ); // Keep the last key in field_xxx_field_yyy for clone fields.

		if ( acf_is_field_key( $field_key ) ) {
			$field = acf_get_field( $field_key );

			if ( $field ) {
				$field['value'] = acf_get_value( $post_id, $field );
				$field['value'] = acf_format_value( $field['value'], $post_id, $field );
				return $field;
			}
		}

		return false;
	}

	/**
	 * Recursively searches a field by its name in an array of fields
	 *
	 * @since 2.3
	 *
	 * @param string $name   Field name
	 * @param array  $fields An array of fields
	 * @return string Field key, empty string if not found
	 */
	protected function search_field_by_name( $name, $fields ) {
		foreach ( $fields as $field ) {
			if ( $name === $field['name'] ) {
				return $field['key'];
			} elseif ( ! empty( $field['sub_fields'] ) && $key = $this->search_field_by_name( $name, $field['sub_fields'] ) ) {
				return $key;
			} elseif ( ! empty( $field['layouts'] ) ) {
				foreach ( $field['layouts'] as $row => $layout ) {
					if ( ! empty( $layout['sub_fields'] ) && $key = $this->search_field_by_name( $name, $layout['sub_fields'] ) ) {
						return $key;
					}
				}
			}
		}
		return '';
	}

	/**
	 * Translates a clone field when creating a new field group translation
	 *
	 * @since 2.3
	 *
	 * @param array $field
	 * @return array
	 */
	public function duplicate_clone_field( $field ) {
		if ( PLL()->model->is_translated_post_type( 'acf-field-group' ) && ! empty( $field['clone'] ) && 'post-new.php' === $GLOBALS['pagenow'] && isset( $_GET['from_post'], $_GET['new_lang'] ) ) {
			check_admin_referer( 'new-post-translation' );

			foreach ( $field['clone'] as $k => $selector ) {
				if ( acf_is_field_group_key( $selector ) ) {
					// Can't use acf_get_field_group() as it is filtered by language
					$posts = get_posts(
						array(
							'post_type'              => 'acf-field-group',
							'post_status'            => array( 'publish', 'acf-disabled', 'trash' ),
							'name'                   => $selector,
							'update_post_meta_cache' => false,
							'lang'                   => '',
						)
					);

					if ( ! empty( $posts ) && $tr_id = pll_get_post( $posts[0]->ID, sanitize_key( $_GET['new_lang'] ) ) ) {
						$tr_group = acf_get_field_group( $tr_id );

						$field['clone'][ $k ] = $tr_group['key'];
					}
				} elseif ( acf_is_field_key( $selector ) ) {
					$_field    = acf_get_field( $selector );
					$ancestors = get_post_ancestors( $_field['ID'] );
					$group_id  = end( $ancestors );

					if ( $tr_id = pll_get_post( $group_id, sanitize_key( $_GET['new_lang'] ) ) ) {
						$keys      = array();
						$tr_fields = acf_get_fields( $tr_id );

						if ( $key = $this->search_field_by_name( $_field['name'], $tr_fields ) ) {
							$field['clone'][ $k ] = $key;
						}
					}
				}
			}
		}
		return $field;
	}

	/**
	 * Allow page on front and page for posts translations to match the corresponding page type
	 *
	 * @since 2.0
	 *
	 * @param bool  $match
	 * @param array $rule
	 * @param array $options
	 * @return bool
	 */
	public function rule_match_page_type( $match, $rule, $options ) {
		if ( ! empty( $options['post_id'] ) ) {
			$post = get_post( $options['post_id'] );

			if ( 'front_page' === $rule['value'] && $front_page = (int) get_option( 'page_on_front' ) ) {
				$translations = pll_get_post_translations( $front_page );

				if ( '==' === $rule['operator'] ) {
					$match = in_array( $post->ID, $translations );
				} elseif ( '!=' === $rule['operator'] ) {
					$match = ! in_array( $post->ID, $translations );
				}
			} elseif ( 'posts_page' === $rule['value'] && $posts_page = (int) get_option( 'page_for_posts' ) ) {
				$translations = pll_get_post_translations( $posts_page );

				if ( '==' === $rule['operator'] ) {
					$match = in_array( $post->ID, $translations );
				} elseif ( '!=' === $rule['operator'] ) {
					$match = ! in_array( $post->ID, $translations );
				}
			}
		}

		return $match;
	}

	/**
	 * Add the Field Groups post type to the list of translatable post types
	 *
	 * @since 2.0
	 *
	 * @param array $post_types  List of post types
	 * @param bool  $is_settings True when displaying the list of custom post types in Polylang settings
	 * @return array
	 */
	public function get_post_types( $post_types, $is_settings ) {
		if ( $is_settings ) {
			$post_types['acf-field-group'] = 'acf-field-group';
		}
		return $post_types;
	}

	/**
	 * Enqueues javascript to react to a language change in the post metabox
	 *
	 * @since 2.0
	 */
	public function admin_enqueue_scripts() {
		global $pagenow, $typenow;

		if ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) && ! in_array( $typenow, array( 'acf-field-group', 'attachment' ) ) && PLL()->model->is_translated_post_type( $typenow ) ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script( 'pll_acf', plugins_url( '/js/acf' . $suffix . '.js', POLYLANG_FILE ), array( 'acf-input' ), POLYLANG_VERSION );
		}
	}

	/**
	 * Ajax response for changing the language in the post metabox
	 *
	 * @since 2.0
	 */
	public function acf_post_lang_choice() {
		check_ajax_referer( 'pll_language', '_pll_nonce' );

		if ( isset( $_POST['fields'] ) ) {
			$x = new WP_Ajax_Response();
			foreach ( array_map( 'sanitize_key', $_POST['fields'] ) as $field ) {
				ob_start();
				acf_render_field_wrap( acf_get_field( $field ), 'div', 'label' );
				$x->Add( array( 'what' => str_replace( '_', '-', $field ), 'data' => ob_get_contents() ) );
				ob_end_clean();
			}

			$x->send();
		}
	}

	/**
	 * Copy and possibly translate custom fields when creating a new term translation
	 *
	 * @since 2.2
	 *
	 * @param mixed  $value   Custom field value of the source term
	 * @param string $post_id Expects term_{$term_id} for a term
	 * @param array  $field   Custom field
	 * @return mixed
	 */
	public function load_value( $value, $post_id, $field ) {
		if ( 'term_0' === $post_id && isset( $_GET['taxonomy'], $_GET['from_tag'], $_GET['new_lang'] ) && taxonomy_exists( $taxonomy = sanitize_key( $_GET['taxonomy'] ) ) && $lang = PLL()->model->get_language( sanitize_key( $_GET['new_lang'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification

			$tr_id  = acf_get_term_post_id( $taxonomy, (int) $_GET['from_tag'] ); // phpcs:ignore WordPress.Security.NonceVerification
			$fields = get_field_objects( $tr_id );

			if ( ! empty( $fields ) ) {
				$keys = array_keys( $fields );

				/** This filter is documented in modules/sync/admin-sync.php */
				$keys = array_unique( apply_filters( 'pll_copy_term_metas', $keys, false, (int) $_GET['from_tag'], 0, $lang->slug ) ); // phpcs:ignore WordPress.Security.NonceVerification

				// Second test to load the values of subfields of accepted fields
				if ( in_array( $field['name'], $keys ) || preg_match( '#^(' . implode( '|', $keys ) . ')_(.+)#', $field['name'] ) ) {
					$value = acf_get_value( $tr_id, $field );
					$empty = null; // Parameter 1 is useless in this context
					$value = $this->translate_fields( $empty, $value, $field['name'], $field, $lang );

					if ( pll_is_translated_post_type( 'acf-field-group' ) ) {
						$references = $this->translate_fields_references( $tr_id, $lang->slug );
						$this->translate_references_in_value( $value, $references );
					}
				}
			}
		}
		return $value;
	}

	/**
	 * Store updated or deleted fields for future usage
	 *
	 * @since 2.3
	 *
	 * @param mixed $value   Not used
	 * @param mixed $post_id Not used
	 * @param array $field   Custom field
	 * @return mixed Unmodified custom field value
	 */
	public function store_updated_field( $value, $post_id, $field ) {
		$this->fields[ $field['name'] ] = $field;
		return $value;
	}

	/**
	 * Store fields when saving a term
	 *
	 * @since 2.3
	 *
	 * @param int    $term_id
	 * @param string $taxonomy
	 */
	public function store_term_fields( $term_id, $taxonomy ) {
		$this->fields = get_field_objects( acf_get_term_post_id( $taxonomy, $term_id ) );
	}

	/**
	 * Store fields when duplicating a term
	 *
	 * @since 2.6
	 *
	 * @param int $term_id Source term id.
	 */
	public function store_duplicated_term_fields( $term_id ) {
		$term = get_term( $term_id );
		$this->fields = get_field_objects( acf_get_term_post_id( $term->taxonomy, $term_id ) );
	}

	/**
	 * Get the custom fields to copy or synchronize
	 *
	 * @since 2.3
	 *
	 * @param array $metas List of custom fields names
	 * @param bool  $sync  True if it is synchronization, false if it is a copy
	 * @param int   $from  Id of the post from which we copy informations
	 * @return array
	 */
	public function get_post_metas_to_copy( $metas, $sync, $from ) {
		// FIXME public metas are copied if ! $sync which wastes DB requests
		if ( $sync ) {
			foreach ( get_post_custom( $from ) as $key => $value ) {
				$value = reset( $value );
				if ( is_string( $value ) && acf_is_field_key( $value ) && array_search( substr( $key, 1 ), $metas ) ) {
					$metas[] = $key; // Private keys added to non private
				}
			}
		}

		return $metas;
	}

	/**
	 * Get the (term) custom fields to copy or synchronize
	 *
	 * @since 2.3
	 *
	 * @param array $metas List of custom fields names
	 * @param bool  $sync  True if it is synchronization, false if it is a copy
	 * @param int   $from  Id of the term from which we copy informations
	 * @return array
	 */
	public function get_term_metas_to_copy( $metas, $sync, $from ) {
		if ( ! $sync || in_array( 'post_meta', PLL()->options['sync'] ) ) {
			foreach ( array_keys( get_term_meta( $from ) ) as $key ) {
				if ( isset( $this->fields[ $key ] ) || isset( $this->fields[ substr( $key, 1 ) ] ) ) {
					$metas[] = $key;
				}
			}
		}

		return $metas;
	}

	/**
	 * Translate a custom field before it is copied or synchronized
	 *
	 * @since 2.3
	 * @since 2.4 Added parameter $to
	 *
	 * @param mixed  $value Meta value
	 * @param string $key   Meta key
	 * @param string $lang  Language of target
	 * @param int    $from  Id of the object from which we copy informations
	 * @param int    $to    Id of the object to which we copy informations
	 * @return mixed
	 */
	public function translate_meta( $value, $key, $lang, $from, $to = 0 ) {
		if ( ! empty( $value ) && $field = isset( $this->fields[ $key ] ) ? $this->fields[ $key ] : $this->get_field_object( $key, $from ) ) {
			$create_if_not_exists = false;

			// Check if we should create translations if they don't exist
			// $to is not empty only when translating posts
			if ( ! empty( $to ) && ( $post_type = get_post_type( $to ) ) && pll_is_translated_post_type( $post_type ) ) {
				$duplicate_options    = get_user_meta( get_current_user_id(), 'pll_duplicate_content', true );
				$active               = ! empty( $duplicate_options ) && ! empty( $duplicate_options[ $post_type ] );
				$create_if_not_exists = $active || PLL()->sync_post->sync_model->are_synchronized( $from, $to );
			}

			$value = $this->translate_field( $value, $lang, $field, $create_if_not_exists );
		}

		if ( pll_is_translated_post_type( 'acf-field-group' ) && is_string( $value ) && acf_is_field_key( $value ) ) {
			$references = $this->translate_fields_references( $from, $lang );

			if ( isset( $references[ $value ] ) ) {
				$value = $references[ $value ];
			}
		}

		return $value;
	}

	/**
	 * Translate a CPT archive link in a page link field
	 *
	 * @since 2.3.6
	 *
	 * @param string $link CPT archive link
	 * @param string $lang Language slug
	 * @return string Modified link
	 */
	public function translate_cpt_archive_link( $link, $lang ) {
		$lang = PLL()->model->get_language( $lang );
		$link = PLL()->links_model->switch_language_in_link( $link, $lang );

		foreach ( PLL()->translate_slugs->slugs_model->get_translatable_slugs() as $type => $slugs ) {
			// Unfortunately ACF does not pass the post type, so let's try with all post type archives
			if ( 0 === strpos( $type, 'archive_' ) ) {
				$link = PLL()->translate_slugs->slugs_model->switch_translated_slug( $link, $lang, $type );
			}
		}
		return $link;
	}

	/**
	 * Translate a custom field value
	 *
	 * @since 2.3
	 * @since 2.4 Added parameter $create_if_not_exists
	 *
	 * @param mixed  $value                Custom field value
	 * @param string $lang                 Language slug
	 * @param array  $field                Custom field
	 * @param bool   $create_if_not_exists Should we create the translation if it does not exist
	 * @return mixed
	 */
	protected function translate_field( $value, $lang, $field, $create_if_not_exists = false ) {
		switch ( $field['type'] ) {
			case 'image':
			case 'file':
				if ( PLL()->options['media_support'] ) {
					if ( $tr_id = pll_get_post( $value, $lang ) ) {
						$return = $tr_id;
					} elseif ( $create_if_not_exists ) {
						$return = PLL()->posts->create_media_translation( $value, $lang );
					}
				}
				break;

			case 'gallery':
				if ( PLL()->options['media_support'] && is_array( $value ) ) {
					foreach ( $value as $img ) {
						if ( $tr_id = pll_get_post( $img, $lang ) ) {
							$return[] = $tr_id;
						} elseif ( $create_if_not_exists ) {
							$return[] = PLL()->posts->create_media_translation( $img, $lang );
						}
					}
				}
				break;

			case 'post_object':
			case 'relationship':
				if ( is_numeric( $value ) && $tr_id = pll_get_post( $value, $lang ) ) {
					$return = $tr_id;
				} elseif ( is_array( $value ) ) {
					foreach ( $value as $p ) {
						if ( $tr_id = pll_get_post( $p, $lang ) ) {
							$return[] = $tr_id;
						}
					}
				}
				break;

			case 'page_link':
				if ( is_numeric( $value ) && $tr_id = pll_get_post( $value, $lang ) ) {
					// Unique translated post
					$return = $tr_id;
				} elseif ( is_array( $value ) ) {
					// Multiple choice
					foreach ( $value as $p ) {
						if ( is_numeric( $p ) && $tr_id = pll_get_post( $p, $lang ) ) {
							$return[] = $tr_id;
						} else {
							$return[] = $this->translate_cpt_archive_link( $p, $lang ); // Archive
						}
					}
				} else {
					$return = $this->translate_cpt_archive_link( $value, $lang ); // Archive
				}
				break;

			case 'taxonomy':
				if ( pll_is_translated_taxonomy( $field['taxonomy'] ) ) {
					if ( is_numeric( $value ) && $tr_id = pll_get_term( $value, $lang ) ) {
						$return = $tr_id;
					} elseif ( is_array( $value ) ) {
						foreach ( $value as $t ) {
							if ( $tr_id = pll_get_term( $t, $lang ) ) {
								$return[] = $tr_id;
							}
						}
					}
				}
				break;
		}

		return empty( $return ) ? $value : $return;
	}

	/**
	 * Translate repeater and flexible content sub fields
	 *
	 * @since 2.2
	 *
	 * @param array  $r     Reference to a flat list of translated custom fields
	 * @param mixed  $value Custom field value
	 * @param string $name  Custom field name
	 * @param array  $field ACF field or subfield
	 * @param string $lang  Language slug
	 * @return array Hierarchical list of custom fields values
	 */
	protected function translate_sub_fields( &$r, $value, $name, $field, $lang ) {
		$return = array();

		foreach ( $value as $row => $sub_fields ) {
			$sub = array();
			foreach ( $sub_fields as $id => $sub_value ) {
				$field = acf_get_field( substr( $id, -19 ) ); // Keep the last key in field_xxx_field_yyy for clone fields.
				if ( $field ) {
					$sub[ $id ] = $this->translate_fields( $r, $sub_value, $name . '_' . $row . '_' . $field['name'], $field, $lang );
				} else {
					$sub[ $id ] = $sub_value;
				}
			}
			$return[] = $sub;
		}

		return $return;
	}

	/**
	 * Translate custom fields if needed
	 * Recursive for repeaters and flexible content
	 *
	 * @since 2.0
	 *
	 * @param array  $r     Reference to a flat list of translated custom fields
	 * @param mixed  $value Custom field value
	 * @param string $name  Custom field name
	 * @param array  $field ACF field or subfield
	 * @param string $lang  Language slug
	 * @return array Hierarchical list of custom fields values
	 */
	protected function translate_fields( &$r, $value, $name, $field, $lang ) {
		if ( empty( $value ) ) {
			return;
		}

		$r[ '_' . $name ] = $field['key'];

		$return = array();

		switch ( $field['type'] ) {
			case 'group':
				foreach ( $value as $id => $sub_value ) {
					if ( $field = acf_get_field( $id ) ) {
						$sub[ $id ] = $this->translate_fields( $r, $sub_value, $name . '_' . $field['name'], $field, $lang );
					} else {
						$sub[ $id ] = $sub_value;
					}
				}
				$return[] = $sub;
				break;

			case 'repeater':
			case 'flexible_content':
				$return = $this->translate_sub_fields( $r, $value, $name, $field, $lang );
				break;

			default:
				$return = $this->translate_field( $value, $lang, $field );
				break;
		}

		return empty( $return ) ? $value : $return;
	}

	/**
	 * Recursively translates the references in value for repeaters and flexible content
	 *
	 * @since 2.2
	 *
	 * @param array $value      Reference to a custom field value
	 * @param array $references List of custom fields references with source as key and translation as value
	 */
	protected function translate_references_in_value( &$value, $references ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $row => $sub_fields ) {
				if ( is_array( $sub_fields ) ) {
					foreach ( $sub_fields as $id => $sub_value ) {
						if ( is_array( $sub_value ) ) {
							$this->translate_references_in_value( $sub_value, $references );
						}
						if ( isset( $references[ $id ] ) ) {
							$value[ $row ][ $references[ $id ] ] = $sub_value;
							unset( $value[ $row ][ $id ] );
						}
					}
				}
			}
		}
	}

	/**
	 * Searches for fields having the same name in translated posts
	 *
	 * @since 2.2
	 *
	 * @param int|string $from Source post id
	 * @param string     $lang Target language code
	 * @return array
	 */
	protected function translate_fields_references( $from, $lang ) {
		$keys   = array();
		$fields = get_field_objects( $from );

		if ( is_array( $fields ) ) {
			foreach ( $fields as $field ) {
				if ( $tr_group = pll_get_post( $field['parent'], $lang ) ) {
					$tr_fields = acf_get_fields( $tr_group );
					$this->translate_field_references( $keys, $field, $tr_fields );
				}
			}
		}

		return $keys;
	}

	/**
	 * Loops through sub fields in the recursive search for fields
	 * having the same name among translated fields groups
	 *
	 * @since 2.2
	 *
	 * @param array $keys
	 * @param array $fields
	 * @param array $tr_fields
	 */
	protected function translate_sub_fields_references( &$keys, $fields, $tr_fields ) {
		foreach ( $fields as $field ) {
			$this->translate_field_references( $keys, $field, $tr_fields );
		}
	}

	/**
	 * Recursively searches for fields having the same name among translated fields groups
	 *
	 * @since 2.2
	 *
	 * @param array $keys
	 * @param array $field
	 * @param array $tr_fields
	 */
	protected function translate_field_references( &$keys, $field, $tr_fields ) {
		$k = array_search( $field['name'], wp_list_pluck( $tr_fields, 'name' ) );
		if ( false !== $k ) {
			$keys[ $field['key'] ] = $tr_fields[ $k ]['key'];
			if ( ! empty( $field['sub_fields'] ) ) {
				$this->translate_sub_fields_references( $keys, $field['sub_fields'], $tr_fields[ $k ]['sub_fields'] );
			}

			if ( ! empty( $field['layouts'] ) ) {
				foreach ( $field['layouts'] as $row => $layout ) {
					if ( ! empty( $layout['sub_fields'] ) ) {
						$this->translate_sub_fields_references( $keys, $layout['sub_fields'], $tr_fields[ $k ]['layouts'][ $row ]['sub_fields'] );
					}
				}
			}
		}
	}
}
