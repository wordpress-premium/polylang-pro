<?php
/**
 * Export actions class file
 *
 * @package Polylang-Pro
 */

/**
 * A class that handles export actions
 *
 * @file
 *
 * @since 3.3
 */
class PLL_Export_Bulk_Option extends PLL_Bulk_Translate_Option {

	/**
	 * Represents the current file or multiple files to export.
	 *
	 * @var PLL_Export_Multi_Files
	 */
	protected $export;

	/**
	 * Allows to add post data to exported file.
	 *
	 * @var PLL_Export_Post
	 */
	protected $post;

	/**
	 * Allows to add term data to exported file.
	 *
	 * @var PLL_Export_Terms
	 */
	protected $term;

	/**
	 * PLL_Export_Bulk_Option constructor.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Model $model Used to query languages and post translations.
	 */
	public function __construct( $model ) {
		parent::__construct(
			array(
				'name'        => 'export',
				'description' => __( 'Export selected content into a file', 'polylang-pro' ),
				'priority'    => 15,
			),
			$model
		);
	}

	/**
	 * Defines wether the export Bulk Translate option is available given the admin panel and user logged.
	 * Do not add the 'export' bulk translate option if LIBXML extension is not loaded, no matter the screen.
	 *
	 * @since 3.3
	 *
	 * @return bool
	 */
	public function is_available() {
		if ( ! extension_loaded( 'libxml' ) ) {
			return false;
		}

		$screen = get_current_screen();

		if ( empty( $screen ) ) {
			return false;
		}

		switch ( $screen->base ) {
			case 'edit':
			case 'upload':
				$post_type_object = get_post_type_object( $screen->post_type );

				if ( empty( $post_type_object ) ) {
					return false;
				}

				$capability = $post_type_object->cap->edit_posts;
				break;
			default:
				return false;
		}

		return current_user_can( $capability );
	}


	/**
	 *
	 * Export post content for converter.
	 *
	 * @since 3.3
	 *
	 * @param int[]    $post_ids         The ids of the posts selected for export.
	 * @param string[] $target_languages The target languages.
	 *
	 * @throws Exception Exception.
	 *
	 * @return void|array {
	 *     array PLL_Bulk_Translate::ERROR Error notices to be displayed to the user when something wrong occurs when exporting.
	 * }
	 *
	 * @phpstan-param non-empty-array<int<1,max>> $post_ids
	 * @phpstan-param non-empty-array<string> $target_languages
	 * @phpstan-return void|array{
	 *     error: non-empty-array<0,string>
	 * }
	 */
	public function do_bulk_action( $post_ids, $target_languages ) {
		/** @var array<PLL_Language|false> */
		$target_languages = array_combine(
			$target_languages,
			array_map( array( $this->model, 'get_language' ), $target_languages )
		);
		$target_languages = array_filter( $target_languages );

		if ( empty( $target_languages ) ) {
			return array(
				PLL_Bulk_Translate::ERROR => array( esc_html__( 'Invalid target languages.', 'polylang-pro' ) ),
			);
		}

		$posts = get_posts(
			array(
				'post__in'               => $post_ids,
				'posts_per_page'         => count( $post_ids ),
				'orderby'                => 'post__in',
				'ignore_sticky_posts'    => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'post_type'              => $this->model->get_translated_post_types(),
				'post_status'            => 'any',
			)
		);

		if ( empty( $posts ) ) {
			return array(
				PLL_Bulk_Translate::ERROR => array( esc_html__( 'The posts selected for translation could not be found.', 'polylang-pro' ) ),
			);
		}

		$is_ambiguous = $this->is_ambiguous( $posts );

		if ( is_wp_error( $is_ambiguous ) ) {
			return array(
				PLL_Bulk_Translate::ERROR => array( $is_ambiguous->get_error_message() ),
			);
		}

		$posts_keyed_with_source_lang = $this->get_posts_by_language( $posts );
		if ( empty( $posts_keyed_with_source_lang ) ) {
			return array(
				PLL_Bulk_Translate::ERROR => array( esc_html__( 'The posts selected for translation have no language.', 'polylang-pro' ) ),
			);
		}

		$posts_by_lang = $this->get_posts_by_target_language( $posts_keyed_with_source_lang, array_keys( $target_languages ) );
		if ( empty( $posts_by_lang ) ) {
			return array(
				PLL_Bulk_Translate::ERROR => array( esc_html__( 'The posts are already in the target language. Please select a different language for the translation.', 'polylang-pro' ) ),
			);
		}

		// Instantiates the required properties for the later posts export.
		$this->export = new PLL_Export_Multi_Files( new PLL_Xliff_Export() );
		$this->post   = new PLL_Export_Post( $this->model );
		$this->term   = new PLL_Export_Terms( $this->model );

		$this->export( new PLL_Export_Download_Zip(), $posts_by_lang );
	}

	/**
	 * Exports the posts with their related items and creates the files before redirecting.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Export_Download_Zip $downloader       Handles the creation of a zip file containing the export.
	 * @param WP_Post[][]             $posts_by_lang    An array, keyed with lang slugs, and containing arrays of `WP_Post` objects.
	 * @param array                   $args             {
	 *     Optional. A list of optional arguments.
	 *
	 *     @type bool $include_translated_items Tells if items that are already translated in the target languages must
	 *                                          also be exported. This applies only to linked items (like assigned
	 *                                          terms, items from reusable blocks, etc). Default is false.
	 * }
	 * @return void
	 *
	 * @phpstan-param array{include_translated_items?:bool} $args
	 */
	protected function export( PLL_Export_Download_Zip $downloader, array $posts_by_lang, array $args = array() ) {
		$include_translated_items = ! empty( $args['include_translated_items'] );
		$taxonomies               = $this->model->get_translated_taxonomies();
		$post_types               = $this->model->get_translated_post_types();
		$collect_posts            = new PLL_Collect_Linked_Posts( $this->model->options );
		$collect_terms            = new PLL_Collect_Linked_Terms();

		foreach ( $posts_by_lang as $lang_slug => $posts ) {
			$lang = $this->model->get_language( $lang_slug );

			if ( empty( $lang ) ) {
				continue;
			}

			$linked_posts = $collect_posts->get_linked_posts( $posts, $post_types );

			if ( ! $include_translated_items ) {
				// Remove items that are already translated in this language.
				foreach ( $linked_posts as $i => $linked_post ) {
					if ( $this->model->post->get_translation( $linked_post->ID, $lang_slug ) ) {
						// A translation already exists.
						unset( $linked_posts[ $i ] );
					}
				}
			}

			$posts_to_export = array_merge( $posts, $linked_posts );

			// Export posts, and posts collected in them.
			foreach ( $posts_to_export as $post ) {
				$this->translate( $post->ID, $lang_slug );
			}

			// Get terms assigned to linked posts.
			$post_ids   = wp_list_pluck( $posts, 'ID' );
			$post_terms = wp_get_object_terms( $post_ids, $taxonomies );
			$post_terms = is_array( $post_terms ) ? $post_terms : array();

			// Collect terms in posts.
			$collected_terms = $collect_terms->get_linked_terms( $posts, $taxonomies );

			if ( ! $include_translated_items ) {
				// Remove items that are already translated in this language.
				foreach ( $collected_terms as $i => $term ) {
					if ( $this->model->term->get_translation( $term->term_id, $lang_slug ) ) {
						// A translation already exists.
						unset( $collected_terms[ $i ] );
					}
				}
			}

			// Merge terms and remove duplicates.
			$all_terms = array();

			foreach ( array_merge( $post_terms, $collected_terms ) as $term ) {
				if ( ! isset( $all_terms[ $term->term_id ] ) ) {
					$all_terms[ $term->term_id ] = $term;
				}
			}

			// Export all terms.
			$this->export = $this->term->export( $this->export, $all_terms, $lang );
		}

		$downloader->create( $this->export );
		add_action( 'wp_redirect', array( $downloader, 'send_response' ) );
	}

	/**
	 * Get post data from id
	 *
	 * @since 3.3
	 *
	 * @param int    $post_id         The ID of the post to export.
	 * @param string $target_language Targeted languages.
	 *
	 * @throws Exception Exception.
	 */
	public function translate( $post_id, $target_language ) {
		$this->export = $this->post->export( $this->export, $post_id, $target_language );
	}

	/**
	 * Groups `WP_Post` objects by their source language.
	 *
	 * @since 3.4
	 *
	 * @param WP_Post[] $posts An array of `WP_Post` objects to translate.
	 * @return WP_Post[][]     An array, keyed with lang slugs, and containing arrays of `WP_Post` objects.
	 *
	 * @phpstan-return array<non-empty-string, non-empty-list<WP_Post>>
	 */
	protected function get_posts_by_language( array $posts ) {
		$posts_keyed_with_source_lang = array();

		// Set the posts to translate for each source language.
		foreach ( $posts as $post ) {
			$post_lang = $this->model->post->get_language( $post->ID );
			if ( empty( $post_lang ) ) {
				continue;
			}
			/** @phpstan-var array<non-empty-string, non-empty-list<WP_Post>> $posts_keyed_with_source_lang */
			$posts_keyed_with_source_lang[ $post_lang->slug ][] = $post;
		}

		return $posts_keyed_with_source_lang;
	}

	/**
	 * Groups `WP_Post` objects by their target language.
	 *
	 * @since 3.4
	 *
	 * @param WP_Post[][] $posts            An array of `WP_Post` objects to translate.
	 * @param string[]    $target_languages The target language slugs for translation.
	 * @return WP_Post[][]                  An array, keyed with lang slugs, and containing arrays of `WP_Post` objects.
	 *
	 * @phpstan-return array<non-empty-string, non-empty-list<WP_Post>>
	 */
	protected function get_posts_by_target_language( array $posts, array $target_languages ) {
		if ( empty( $posts ) || empty( $target_languages ) ) {
			return array();
		}

		$translation_matrix = array();

		// Set the posts to translate for each target language.
		foreach ( $target_languages as $target_language ) {
			$_posts = array_values( array_diff_key( $posts, array( $target_language => 1 ) ) );
			if ( ! empty( $_posts ) ) {
				/** @phpstan-var array<non-empty-string, non-empty-list<WP_Post>> $translation_matrix */
				$translation_matrix[ $target_language ] = array_merge( ... $_posts );
			}
		}

		return $translation_matrix;
	}

	/**
	 * Checks there is no ambiguity in the selected posts to export.
	 * Ambiguity happens when 2 posts that are translations of each other are selected to be translated.
	 *
	 * @since 3.3
	 * @since 3.4 Parameter changed from int[] to WP_Post[]
	 *
	 * @param WP_Post[] $posts The posts selected for export.
	 * @return WP_Error|false An error if an ambiguity is found, false otherwise. The error message should not be
	 *                        escaped: it contains `<br>` tags and the texts are already escaped.
	 */
	protected function is_ambiguous( array $posts ) {
		$duplicates = $this->find_duplicate_translations( wp_list_pluck( $posts, 'ID' ) );

		if ( empty( $duplicates ) ) {
			return false;
		}

		$post_titles = wp_list_pluck( $posts, 'post_title', 'ID' ); // List of post titles keyed by post ID.

		if ( empty( $post_titles ) ) {
			// Uh?
			return false;
		}

		// Wrap post titles into quotes.
		$post_titles = array_map(
			function ( $post_title ) {
				// translators: %s is a post title.
				return sprintf( _x( '"%s"', 'quoted post title', 'polylang-pro' ), $post_title );
			},
			$post_titles
		);

		$message = esc_html__( 'Ambiguous choice of contents to export. Please do not select contents that are translations of each other.', 'polylang-pro' );

		foreach ( $duplicates as $duplicate ) {
			$duplicate_titles = array_intersect_key( $post_titles, array_flip( $duplicate ) );

			$message .= '<br/>' . esc_html(
				sprintf(
					// translators: %s is a list of post titles.
					_x( '- %s.', 'ambiguous posts list', 'polylang-pro' ),
					wp_sprintf_l( '%l', $duplicate_titles )
				)
			);
		}

		return new WP_Error( 'pll_export_target_source_language', $message );
	}

	/**
	 * Find duplicate translations among the given list of post IDs.
	 *
	 * @since 3.3
	 *
	 * @param int[] $post_ids The ids of the posts selected for export.
	 * @return int[][] A list of arrays of post IDs.
	 *
	 * @phpstan-param array<int<1,max>> $post_ids
	 * @phpstan-return array<non-empty-array<int<1,max>>>
	 */
	protected function find_duplicate_translations( array $post_ids ) {
		$return  = array();
		$all_ids = array();

		foreach ( $post_ids as $post_id ) {
			if ( in_array( $post_id, $all_ids, true ) ) {
				// Already processed this case (already met one of this post's translations).
				continue;
			}

			/** @var array<int<1,max>> $translation_ids */
			$translation_ids = $this->model->post->get_translations( $post_id );

			// Look for this post's translations in the list of posts to translate.
			$common_post_ids = array_intersect( $post_ids, $translation_ids );

			if ( count( $common_post_ids ) <= 1 ) {
				// No translations found except this post.
				continue;
			}

			// Ambiguity found.
			$return[] = $common_post_ids;
			$all_ids  = array_merge( $all_ids, $common_post_ids );
		}

		return $return;
	}
}
