<?php

/**
 * A class to manage integration with the Event Calendar
 * Version tested: 4.5.8.1
 *
 * @since 2.2
 */
class PLL_TEC {
	protected static $metas, $slugs, $options;

	/**
	 * Initializes filters and actions
	 *
	 * @since 2.2
	 */
	public function init() {
		add_filter( 'pll_get_taxonomies', array( $this, 'translate_taxonomies' ), 10, 2 );
		add_filter( 'pll_get_post_types', array( $this, 'translate_types' ), 10, 2 );

		add_action( 'save_post_tribe_venue', array( $this, 'set_language' ), 10, 3 );
		add_action( 'save_post_tribe_organizer', array( $this, 'set_language' ), 10, 3 );

		$tec = Tribe__Events__Main::instance();

		// PHPCS:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		self::$metas = array_merge( $tec->metaTags, $tec->venueTags, $tec->organizerTags, array( '_VenueShowMap', '_VenueShowMapLink' ) );

		if ( 'post-new.php' === $GLOBALS['pagenow'] && isset( $_GET['from_post'], $_GET['new_lang'] ) ) {
			check_admin_referer( 'new-post-translation' );

			// Defaults values for events
			foreach ( self::$metas as $meta ) {
				$filter = str_replace( array( '_Event', '_Organizer', '_Venue' ), array( '', 'Organizer', 'Venue' ), $meta );
				add_filter( 'tribe_get_meta_default_value_' . $filter, array( $this, 'copy_event_meta' ), 10, 4 ); // Since TEC 4.0.7
			}

			add_filter( 'tribe_display_event_linked_post_dropdown_id', array( $this, 'translate_linked_post' ), 10, 2 );
		}

		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ), 60 ); // After TEC

		add_filter( 'pll_copy_post_metas', array( $this, 'copy_post_metas' ) );
		add_filter( 'pll_translate_post_meta', array( $this, 'translate_meta' ), 10, 3 );

		// Translate links with translated slugs
		add_action( 'init', array( $this, 'reset_slugs' ), 11 ); // Just after TEC
		add_filter( 'register_taxonomy_args', array( $this, 'register_taxonomy_args' ), 10, 2 );
		add_filter( 'tribe_events_get_link', array( $this, 'get_link' ) );
		add_filter( 'pll_get_archive_url', array( $this, 'pll_get_archive_url' ), 10, 2 );
		add_filter( 'pll_translated_slugs', array( $this, 'pll_translated_slugs' ), 10, 3 );
		add_filter( 'pll_sanitize_string_translation', array( $this, 'sanitize_string_translation' ), 10, 3 );
		add_filter( 'tribe_events_rewrite_i18n_slugs_raw', array( $this, 'rewrite_slugs' ) );

		// Options to translate
		self::$options = array(
			'dateWithYearFormat'    => array( 'name' => __( 'Date with year', 'polylang-pro' ) ),
			'dateWithoutYearFormat' => array( 'name' => __( 'Date without year', 'polylang-pro' ) ),
			'monthAndYearFormat'    => array( 'name' => __( 'Month and year format', 'polylang-pro' ) ),
			'dateTimeSeparator'     => array( 'name' => __( 'Date time separator', 'polylang-pro' ) ),
			'timeRangeSeparator'    => array( 'name' => __( 'Time range separator', 'polylang-pro' ) ),
			'tribeEventsBeforeHTML' => array( 'name' => __( 'Add HTML before event content', 'polylang-pro' ), 'multiline' => true ),
			'tribeEventsAfterHTML'  => array( 'name' => __( 'Add HTML after event content', 'polylang-pro' ), 'multiline' => true ),
		);

		// Register strings
		if ( PLL() instanceof PLL_Settings ) {
			add_action( 'init', array( $this, 'register_strings' ), 1 );
			add_filter( 'pll_sanitize_string_translation', array( $this, 'sanitize_strings' ), 10, 3 );
		}

		// Translate strings on frontend
		if ( PLL() instanceof PLL_Frontend ) {
			add_action( 'option_tribe_events_calendar_options', array( $this, 'translate_strings' ) );
		}

		add_filter( 'pll_filter_query_excluded_query_vars', array( $this, 'fix_events_query' ), 10, 2 );
	}

	/**
	 * Language and translation management for taxonomies
	 *
	 * @since 2.2
	 *
	 * @param array $taxonomies List of taxonomy names for which Polylang manages language and translations
	 * @param bool  $hide       True when displaying the list in Polylang settings
	 * @return array List of taxonomy names for which Polylang manages language and translations
	 */
	public function translate_taxonomies( $taxonomies, $hide ) {
		// Hide from Polylang settings
		return $hide ? array_diff( $taxonomies, array( 'tribe_events_cat' ) ) : array_merge( $taxonomies, array( 'tribe_events_cat' ) );
	}

	/**
	 * Language and translation management for custom post types
	 *
	 * @since 2.2
	 *
	 * @param array $types List of post type names for which Polylang manages language and translations
	 * @param bool  $hide  True when displaying the list in Polylang settings
	 * @return array List of post type names for which Polylang manages language and translations
	 */
	public function translate_types( $types, $hide ) {
		$tec_types = array( 'tribe_events', 'tribe_venue', 'tribe_organizer' );
		return $hide ? array_diff( $types, $tec_types ) : array_merge( $types, $tec_types );
	}

	/**
	 * Save the language of Venues and Organizers
	 * Needed when they are created from the Event form
	 *
	 * @since 2.2
	 *
	 * @param int    $post_id
	 * @param object $post
	 * @param bool   $update  Whether it is an update or not
	 */
	public function set_language( $post_id, $post, $update ) {
		$post_type_object = get_post_type_object( $post->post_type );

		if ( ! $update && current_user_can( $post_type_object->cap->create_posts ) && isset( $_POST['post_lang_choice'] ) ) {
			check_admin_referer( 'pll_language', '_pll_nonce' );
			PLL()->model->post->set_language( $post_id, PLL()->model->get_language( sanitize_key( $_POST['post_lang_choice'] ) ) );
		}
	}

	/**
	 * Populates default event metas for a newly created event translation
	 *
	 * @since 2.2
	 *
	 * @param mixed  $value
	 * @param int    $id     Post id
	 * @param string $meta   Meta key
	 * @param bool   $single
	 * @return mixed
	 */
	public function copy_event_meta( $value, $id, $meta, $single ) {
		if ( ! empty( $_GET['from_post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$value = get_post_meta( (int) $_GET['from_post'], $meta, $single ); // phpcs:ignore WordPress.Security.NonceVerification
		}
		return $value;
	}

	/**
	 * Populates default values for venues and organizers for a newly created event translation
	 *
	 * @since 2.2
	 *
	 * @param array $posts Array of linked posts
	 * @return array
	 */
	public function translate_linked_post( $posts ) {
		if ( ! empty( $posts ) && isset( $_GET['new_lang'] ) ) {
			check_admin_referer( 'new-post-translation' );

			$lang = PLL()->model->get_language( sanitize_key( $_GET['new_lang'] ) )->slug; // Make sure this is a valid language

			foreach ( $posts as $key => $post_id ) {
				$tr_id = pll_get_post( $post_id, $lang );

				// If the translated venue or organizer doesn't exist, create it
				if ( empty( $tr_id ) ) {
					$translations = pll_get_post_translations( $post_id );
					$post = get_post( $post_id );
					$post->ID = null;
					$translations[ $lang ] = $tr_id = wp_insert_post( $post );
					pll_set_post_language( $tr_id, $lang );
					pll_save_post_translations( $translations );
					PLL()->sync->post_metas->copy( $post_id, $tr_id, $lang );
				}
				$posts[ $key ] = $tr_id;
			}
		}
		return $posts;
	}

	/**
	 * Filters the default values when creating a new translation
	 *
	 * @since 2.2
	 *
	 * @param object $strategy
	 * @return $strategy
	 */
	public function default_value_strategy( $strategy ) {
		return new PLL_TEC_Default_Values();
	}

	/**
	 * Removes date filters when searching for untranslated events in the metabox autocomplete field
	 *
	 * @since 2.2.8
	 *
	 * @param object $query WP_Query object
	 */
	public function pre_get_posts( $query ) {
		if ( wp_doing_ajax() && isset( $_GET['action'] ) && 'pll_posts_not_translated' === $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification
			// See Tribe__Events__Query::pre_get_posts() when should_remove_date_filters() returns true
			remove_filter( 'posts_where', array( 'Tribe__Events__Query', 'posts_where' ), 10, 2 );
			remove_filter( 'posts_fields', array( 'Tribe__Events__Query', 'posts_fields' ) );
			remove_filter( 'posts_orderby', array( 'Tribe__Events__Query', 'posts_orderby' ), 10, 2 );
		}
	}

	/**
	 * Synchronize event metas
	 *
	 * @since 2.2
	 *
	 * @param array $metas Custom fields to copy or synchronize
	 * @return array
	 */
	public function copy_post_metas( $metas ) {
		return array_merge( $metas, self::$metas );
	}

	/**
	 * Translate venues and organizers before they are copied or synchronized
	 *
	 * @since 2.3
	 *
	 * @param mixed  $value Meta value
	 * @param string $key   Meta key
	 * @param string $lang  Language of target
	 * @return mixed
	 */
	public function translate_meta( $value, $key, $lang ) {
		if ( ( '_EventVenueID' === $key || '_EventOrganizerID' === $key ) && $tr_value = pll_get_post( $value, $lang ) ) {
			$value = $tr_value;
		}
		return $value;
	}

	/**
	 * Reset all TEC translated slugs to an English value as the TEC slug translation system does not work in a multilingual context (TEC 4.4.5 + WP 4.7.3)
	 *
	 * @since 2.2
	 */
	public function reset_slugs() {
		$tec = Tribe__Events__Main::instance();

		self::$slugs = array(
			'category_slug'  => 'category',
			'tag_slug'       => 'tag',
			'taxRewriteSlug' => $tec->rewriteSlug . '/category', // PHPCS:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			'tagRewriteSlug' => $tec->rewriteSlug . '/tag', // PHPCS:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			'monthSlug'      => 'month',
			'listSlug'       => 'list',
			'upcomingSlug'   => 'upcoming',
			'pastSlug'       => 'past',
			'daySlug'        => 'day',
			'todaySlug'      => 'today',
			'featured_slug'  => 'featured',
			'all_slug'       => 'all',
		);

		foreach ( self::$slugs as $key => $slug ) {
			$tec->$key = $slug;
		}
	}

	/**
	 * Resets the category base rewrite slug in taxonomy
	 *
	 * @since 2.2
	 *
	 * @param array  $args     Array of arguments for registering a taxonomy.
	 * @param string $taxonomy Taxonomy key.
	 */
	public function register_taxonomy_args( $args, $taxonomy ) {
		if ( 'tribe_events_cat' === $taxonomy ) {
			$args['rewrite']['slug'] = Tribe__Events__Main::instance()->rewriteSlug . '/category';
		}

		return $args;
	}

	/**
	 * Filters the links to add the language code
	 *
	 * @since 2.2
	 *
	 * @param string $link
	 * @return string
	 */
	public function get_link( $link ) {
		if ( ! empty( PLL()->curlang ) && ! empty( self::$slugs ) ) {
			$link = PLL()->links_model->add_language_to_link( $link, PLL()->curlang );
			$link = PLL()->translate_slugs->slugs_model->translate_slug( $link, PLL()->curlang, 'archive_tribe_events' );

			foreach ( self::$slugs as $slug ) {
				$link = PLL()->translate_slugs->slugs_model->translate_slug( $link, PLL()->curlang, 'tribe_' . $slug );
			}
		}
		return $link;
	}

	/**
	 * Translate slugs in the language switcher
	 *
	 * @since 2.2
	 *
	 * @param string $url
	 * @param object $language
	 * @return string modified url
	 */
	public function pll_get_archive_url( $url, $language ) {
		if ( is_post_type_archive( 'tribe_events' ) ) {
			foreach ( self::$slugs as $slug ) {
				$url = PLL()->translate_slugs->slugs_model->switch_translated_slug( $url, $language, 'tribe_' . $slug );
			}
		}
		return $url;
	}

	/**
	 * Fix the events slug in translatable slugs
	 * Translate other TEC slugs
	 *
	 * @since 2.2
	 *
	 * @param array  $slugs
	 * @param object $language
	 * @param object $mo
	 * @return array
	 */
	public function pll_translated_slugs( $slugs, $language, &$mo ) {
		unset( $slugs['archive_tribe_events']['hide'] );
		$slugs['archive_tribe_events']['slug'] = $slug = Tribe__Events__Main::instance()->getRewriteSlug();
		$tr_slug = $mo->translate( $slug );
		$slugs['archive_tribe_events']['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;

		foreach ( self::$slugs as $slug ) {
			$slugs[ 'tribe_' . $slug ]['slug'] = $slug;
			$tr_slug = $mo->translate( $slug );
			$slugs[ 'tribe_' . $slug ]['translations'][ $language->slug ] = empty( $tr_slug ) ? $slug : $tr_slug;
		}

		return $slugs;
	}

	/**
	 * Performs the sanitization ( before saving in DB ) of slugs translations
	 * The Events Calendar does not accept accents, but let's accept slashes for the event category slug
	 *
	 * @since 1.9
	 *
	 * @param string $translation Translation to sanitize
	 * @param string $name        Unique name for the string, not used
	 * @param string $context     The group in which the string is registered
	 * @return string
	 */
	public function sanitize_string_translation( $translation, $name, $context ) {
		if ( 'slug_archive_tribe_events' === $name || 0 === strpos( $name, 'slug_tribe_' ) ) {
			$slugs = explode( '/', $translation );
			$slugs = array_map( 'sanitize_title', $slugs );
			return implode( '/', $slugs );
		}
		return $translation;
	}

	/**
	 * Add translated slugs to specific TEC rewrite rules
	 *
	 * @since 2.2
	 *
	 * @param array $bases Array of arrays of rewrite base slugs
	 * @return array
	 */
	public function rewrite_slugs( $bases ) {
		foreach ( $bases as $type => $base ) {
			$default_slug = reset( $base );

			foreach ( PLL()->translate_slugs->slugs_model->get_translatable_slugs() as $slugs ) {
				if ( $slugs['slug'] === $default_slug ) {
					$bases[ $type ] = array_unique( array_merge( $base, $slugs['translations'] ) );
				}
			}
		}

		return $bases;
	}

	/**
	 * Register strings
	 *
	 * @since 2.2
	 */
	public function register_strings() {

		$option = get_option( 'tribe_events_calendar_options' );

		foreach ( self::$options as $string => $arr ) {
			if ( ! empty( $option[ $string ] ) ) {
				pll_register_string( $arr['name'], $option[ $string ], 'The Events Calendar', ! empty( $arr['multiline'] ) );
			}
		}

	}

	/**
	 * Translated strings must be sanitized the same way The Events Calendar does before they are saved
	 * All are of validation_type 'html'
	 *
	 * @since 2.2
	 *
	 * @param string $translation
	 * @param string $name
	 * @param string $context
	 * @return string sanitized translation
	 */
	public function sanitize_strings( $translation, $name, $context ) {
		if ( 'The Events Calendar' === $context ) {
			$translation = balanceTags( $translation );
		}

		return $translation;
	}

	/**
	 * Translate strings in options
	 *
	 * @since 2.2
	 *
	 * @param array $options
	 * @return array
	 */
	public function translate_strings( $options ) {
		foreach ( array_intersect( array_keys( $options ), array_keys( self::$options ) ) as $key ) {
			$options[ $key ] = pll__( $options[ $key ] );
		}
		return $options;
	}

	/**
	 * Fix events query when events are not translated
	 *
	 * @since 2.3.7
	 *
	 * @param array  $excludes Query vars excluded from the language filter
	 * @param object $query    WP Query
	 * @return array
	 */
	public function fix_events_query( $excludes, $query ) {
		if ( ! empty( $query->query['post_type'] ) && 'tribe_events' === $query->query['post_type'] ) {
			$excludes = array_diff( $excludes, array( 'post__in' ) );
		}
		return $excludes;
	}
}
