<?php

/**
 * Setup the REST API endpoints and filters
 *
 * @since 2.2
 */
class PLL_REST_API {
	public $links, $model;

	/**
	 * Constructor
	 *
	 * @since 2.2
	 *
	 * @param object $polylang Instance of PLL_REST_Request
	 */
	public function __construct( &$polylang ) {
		$this->links = &$polylang->links;
		$this->model = &$polylang->model;
		add_action( 'rest_api_init', array( $this, 'init' ) );
	}

	/**
	 * Init filters and new endpoints
	 *
	 * @since 2.2
	 */
	public function init() {
		$post_types = array_fill_keys( $this->model->get_translated_post_types(), array() );

		/**
		 * Filter post types and their options passed to PLL_Rest_Post contructor
		 *
		 * @since 2.2.1
		 *
		 * @param array $post_types An array of arrays with post types as keys and options as values
		 */
		$post_types = apply_filters( 'pll_rest_api_post_types', $post_types );
		$this->post = new PLL_REST_Post( $this, $post_types );

		$taxonomies = array_fill_keys( $this->model->get_translated_taxonomies(), array() );

		/**
		 * Filter post types and their options passed to PLL_Rest_Term constructor
		 *
		 * @since 2.2.1
		 *
		 * @param array $taxonomies An array of arrays with taxonomies as keys and options as values
		 */
		$taxonomies = apply_filters( 'pll_rest_api_taxonomies', $taxonomies );
		$this->term = new PLL_REST_Term( $this, $taxonomies );

		register_rest_route(
			'pll/v1',
			'/languages',
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this->model, 'get_languages_list' ),
			)
		);

		register_rest_route(
			'pll/v1',
			'/untranslated-posts',
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_untranslated_posts' ),
				'args' => $this->get_untranslated_posts_collection_params(),
			)
		);
	}

	/**
	 * Retrieves the query params for the untranslated posts collection.
	 *
	 * @since 2.6.0
	 *
	 * @return array Collection parameters.
	 */
	public function get_untranslated_posts_collection_params() {
		$language_slugs = $this->model->get_languages_list( array( 'fields' => 'slug' ) );
		return array(
			'type' => array(
				'description'       => __( 'Limit results to items of an object type.', 'polylang-pro' ),
				'type'              => 'string',
				'required'          => true,
				'enum'              => get_post_types(
					array(
						'public'       => true,
						'show_in_rest' => true,
					),
					'names'
				),
			),
			'untranslated_in' => array(
				'description'       => __( 'Limit results to untranslated items in a language.', 'polylang-pro' ),
				'type'              => 'string',
				'required'          => true,
				'enum'              => $language_slugs,
			),
			'lang' => array(
				'description'       => __( 'Limit results to items in a language.', 'polylang-pro' ),
				'type'              => 'string',
				'required'          => true,
				'enum'              => $language_slugs,
			),
			'search' => array(
				'description'       => __( 'Limit results to those matching a string.', 'polylang-pro' ),
				'type'              => 'string',
			),
			'include' => array(
				'description'       => __( 'Add this post\'s translation to results.', 'polylang-pro' ),
				'type'              => 'integer',
				'sanitize_callback' => 'absint',
			),
			'is_block_editor' => array(
				'description'       => __( 'Are we in a block editor context?', 'polylang-pro' ),
				'type'              => 'boolean',
				'default' => false,
			),
		);
	}

	/**
	 * Returns a list of posts not translated in a language
	 *
	 * @since 2.6.0
	 *
	 * @param WP_REST_Request $request REST API request
	 * @return array
	 */
	public function get_untranslated_posts( WP_REST_Request $request ) {
		$return = array();

		$type = $request->get_param( 'type' );
		$search = $request->get_param( 'search' );
		$untranslated_in = $this->model->get_language( $request->get_param( 'untranslated_in' ) );
		$lang = $this->model->get_language( $request->get_param( 'lang' ) );

		$untranslated_posts = $this->model->post->get_untranslated( $type, $untranslated_in, $lang, $search );

		// Add current translation in list
		if ( $post_id = $this->model->post->get_translation( $request->get_param( 'include' ), $lang ) ) {
			$post = get_post( $post_id );
			array_unshift( $untranslated_posts, $post );
		}

		// Format output
		foreach ( $untranslated_posts as $post ) {
			$values = array(
				'id'         => $post->ID,
				'title'      => array(
					'raw'      => $post->post_title,
					'rendered' => get_the_title( $post->ID ),
				),
			);
			if ( $request->get_param( 'is_block_editor' ) ) {
				$values['edit_link'] = get_edit_post_link( $post, 'keep ampersand' );
			}
			$return[] = $values;
		}

		return $return;
	}
}
