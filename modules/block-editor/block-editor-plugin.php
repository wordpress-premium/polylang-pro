<?php

/**
 * Setup the block editor plugin
 *
 * @since 2.6
 */
class PLL_Block_Editor_Plugin {
	protected $model, $posts;

	/**
	 * Constructor
	 *
	 * @since 2.6
	 *
	 * @param object $polylang
	 */
	public function __construct( &$polylang ) {
		$this->model = &$polylang->model;
		$this->posts = &$polylang->posts;

		add_filter( 'block_editor_preload_paths', array( $this, 'preload_paths' ), 50, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}
	/**
	 * Filters the preload REST requests by the current language of the post
	 * Necessary otherwise subsequent REST requests filtered by the language
	 * would not hit the preloaded requests
	 *
	 * @since 2.6
	 *
	 * @param array  $preload_paths Array of paths to preload.
	 * @param object $post          The post resource data.
	 * @return array
	 */
	public function preload_paths( $preload_paths, $post ) {
		if ( ! $this->model->is_translated_post_type( $post->post_type ) ) {
			return $preload_paths;
		}

		// Set default language according to the context if no language is defined yet
		$this->posts->set_default_language( $post->ID );
		$lang = $this->model->post->get_language( $post->ID );

		$preload_paths = array_merge(
			$preload_paths,
			array(
				'/wp/v2/users/me', // Add users/me without post_type parameter for core data preloading.
			)
		);

		foreach ( $preload_paths as $k => $path ) {
			$query_params = array();

			// If the method request is OPTIONS, $path is an array and the first element is the path
			if ( is_array( $path ) && ! empty( $path ) ) {
				$temp_path = $path[0];
			} else {
				$temp_path = $path;
			}

			$path_parts = wp_parse_url( $temp_path );

			if ( ! empty( $path_parts['query'] ) ) {
				parse_str( $path_parts['query'], $query_params );
			}

			// We need to add translations_table parameter only for the post request
			// to be able to retrieve these datas only for posts and in a block editor context only
			// Therefore, if the path matches to the correct path we add the parameter
			if ( $this->is_post_request( $post, $path_parts['path'] ) ) {
				// Add is_block_editor in query params
				$query_params['is_block_editor'] = 'true';
			}

			// Add language in query params
			$query_params['lang'] = $lang->slug;

			// Sort query params to put it in the same order as the preloading middleware does
			ksort( $query_params );

			// Replace the key by the correct path with query params reordered
			$sorted_path = add_query_arg( urlencode_deep( $query_params ), $path_parts['path'] );

			if ( is_array( $path ) && ! empty( $path ) ) {
				$preload_paths[ $k ][0] = $sorted_path;
			} else {
				$preload_paths[ $k ] = $sorted_path;
			}
		}

		// Paths added here are not filtered by language.
		return array_merge(
			$preload_paths,
			array(
				'/pll/v1/languages', // Add endpoint for languages to also preload languages data.
			)
		);
	}

	/**
	 * Check if an url path is a REST API post request
	 *
	 * @since 2.6
	 *
	 * @param WP_Post $post An instance of WP_Post.
	 * @param string  $path URL path. Only the path part of the URL is used for easier comparison.
	 * @return boolean True if the path corresponds to a REST API post request.
	 */
	public function is_post_request( $post, $path ) {
		// Set rest_base for the post type.
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$rest_base        = ! empty( $post_type_object->rest_base ) ? $post_type_object->rest_base : $post_type_object->name;

		$path_parts = wp_parse_url( $path );

		return sprintf( '/wp/v2/%s/%s', $rest_base, $post->ID ) === $path_parts['path'];
	}

	/**
	 * Enqueue scripts for the block editor plugin.
	 *
	 * @since 2.6
	 */
	public function admin_enqueue_scripts() {
		global $post;

		$screen = get_current_screen();
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Only enqueue scripts for post screen and in block editor context
		if ( 'post' !== $screen->base || ! $this->model->is_translated_post_type( $screen->post_type ) || ! method_exists( $screen, 'is_block_editor' ) || ! $screen->is_block_editor() ) {
			return;
		}

		// Enqueue specific styles for block editor UI
		wp_enqueue_style(
			'polylang-block-editor-css',
			plugins_url( '/modules/block-editor/build/style.css', POLYLANG_FILE ),
			array( 'wp-components' ),
			filemtime( POLYLANG_DIR . '/modules/block-editor/build/style.css' )
		);

		$script_filename = '/modules/block-editor/build/block-editor-plugin' . $suffix . '.js';
		$script_handle = PLL_PREFIX . 'block-editor-plugin';
		wp_register_script(
			$script_handle,
			plugins_url( $script_filename, POLYLANG_FILE ),
			array(
				'wp-api-fetch',
				'wp-data',
				'lodash',
			),
			filemtime( POLYLANG_DIR . $script_filename ),
			true
		);
		// Set default language according to the context if no language is defined yet
		$this->posts->set_default_language( $post->ID );
		$lang = $this->model->post->get_language( $post->ID );
		$pll_settings = array(
			'lang' => $this->model->post->get_language( $post->ID ),
		);
		wp_localize_script( $script_handle, PLL_PREFIX . 'block_editor_plugin_settings', $pll_settings );
		wp_enqueue_script( $script_handle );

		$script_filename = '/modules/block-editor/build/sidebar' . $suffix . '.js';
		wp_enqueue_script(
			PLL_PREFIX . 'sidebar',
			plugins_url( $script_filename, POLYLANG_FILE ),
			array(
				'wp-api-fetch',
				'wp-data',
				'lodash',
			),
			filemtime( POLYLANG_DIR . $script_filename ),
			true
		);

		// Translated strings used in JS code
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations(
				PLL_PREFIX . 'sidebar',
				'polylang-pro',
				POLYLANG_DIR . '/languages'
			);
		}
	}
}
