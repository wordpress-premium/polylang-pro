<?php

/**
 * Expose terms language and translations in the REST API
 *
 * @since 2.2
 */
class PLL_REST_Post extends PLL_REST_Translated_Object {

	/**
	 * Constructor
	 *
	 * @since 2.2
	 *
	 * @param object $rest_api      Instance of PLL_REST_API
	 * @param array  $content_types Array of arrays with post types as keys and options as values
	 */
	public function __construct( &$rest_api, $content_types ) {
		parent::__construct( $rest_api, $content_types );

		$this->type = 'post';
		$this->id   = 'ID';

		foreach ( array_keys( $content_types ) as $post_type ) {
			add_filter( "rest_prepare_{$post_type}", array( $this, 'prepare_response' ), 10, 3 );
		}

		// Use rest_pre_dispatch_filter to be sure to get translations_table parameter in time
		add_filter( 'rest_pre_dispatch', array( $this, 'get_rest_query_params' ), 10, 3 );

		add_filter( 'rest_post_search_query', array( $this, 'query' ), 10, 2 ); // For search requests, since WP 5.1.0
	}

	/**
	 * Allows to share the post slug across languages
	 * Modifies the REST response accordingly
	 *
	 * @since 2.3
	 *
	 * @param object $response The response object.
	 * @param object $post     Post object.
	 * @param object $request  Request object.
	 */
	public function prepare_response( $response, $post, $request ) {
		global $wpdb;
		$data = $response->get_data();

		if ( ! empty( $data['slug'] ) && in_array( $request->get_method(), array( 'POST', 'PUT' ) ) ) {
			$params     = $request->get_params();
			$attributes = $request->get_attributes();

			if ( ! empty( $params['slug'] ) ) {
				$requested_slug = $params['slug'];
			} elseif ( is_array( $attributes['callback'] ) && 'create_item' === $attributes['callback'][1] ) {
				// Allow sharing slug by default when creating a new post
				$requested_slug = sanitize_title( $post->post_title );
			}

			if ( isset( $requested_slug ) && $post->post_name !== $requested_slug ) {
				$slug = wp_unique_post_slug( $requested_slug, $post->ID, $post->post_status, $post->post_type, $post->post_parent );
				if ( $slug !== $data['slug'] && $wpdb->update( $wpdb->posts, array( 'post_name' => $slug ), array( 'ID' => $post->ID ) ) ) {
					$data['slug'] = $slug;
					$response->set_data( $data );
				}
			}
		}
		return $response;
	}

	/**
	 * Add the translations_table REST field only when the request is called for the block editor
	 *
	 * @see WP_REST_Server::dispatch()
	 *
	 * @since 2.6
	 *
	 * @param mixed           $result  Response to replace the requested version with. Can be anything
	 *                                 a normal endpoint can return, or null to not hijack the request.
	 * @param WP_REST_Server  $server  Server instance.
	 * @param WP_REST_Request $request Request used to generate the response.
	 */
	public function get_rest_query_params( $result, $server, $request ) {
		if ( current_user_can( 'edit_posts' ) && null !== $request->get_param( 'is_block_editor' ) ) {
			foreach ( array_keys( $this->content_types ) as $post_type ) {
				register_rest_field(
					$this->get_rest_field_type( $post_type ),
					'translations_table',
					array(
						'get_callback'    => array( $this, 'get_translations_table' ),
						'schema'          => array(
							'translations_table' => __( 'Translations table', 'polylang-pro' ),
							'type'               => 'object',
						),
					)
				);
			}
		}

		return $result;
	}

	/**
	 * Returns the post translations table
	 *
	 * @since 2.6
	 *
	 * @param array $object Post array
	 * @return array
	 */
	public function get_translations_table( $object ) {
		$return = array();

		// When we come from a post new creation
		$from_post_id = isset( $_GET['from_post'] ) ? (int) $_GET['from_post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification

		$lang = $this->model->post->get_language( $object['id'] );
		foreach ( $this->model->get_languages_list() as $language ) {
			$return[ $language->slug ]['lang'] = $language;

			$value = $this->model->post->get_translation( $object['id'], $language );

			if ( ! empty( $from_post_id ) ) {
				$value = $this->model->post->get( $from_post_id, $language );
			}

			$link = $add_link = $this->links->get_new_post_translation_link( $object['id'], $language, 'keep ampersand' );
			$return[ $language->slug ]['links']['add_link'] = $link;

			if ( $value ) {
				$translated_post = get_post( $value, 'ARRAY_A' );
				$return[ $language->slug ]['links']['edit_link'] = get_edit_post_link( $value, 'keep ampersand' );
				$return[ $language->slug ]['translated_post'] = array(
					'id'    => $translated_post['ID'],
					'title' => $translated_post['post_title'],
				);
			}

			/**
			 * Filters the REST translations table
			 *
			 * @since 2.6
			 *
			 * @param array  $row      Datas in a translations table row
			 * @param int    $id       Source post id.
			 * @param object $language Translation language
			 */
			$return = apply_filters( 'pll_rest_translations_table', $return, $object['id'], $language );
		}

		return $return;
	}
}
