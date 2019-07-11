<?php

/**
 * Expose terms language and translations in the REST API
 *
 * @since 2.2
 */
class PLL_REST_Term extends PLL_REST_Translated_Object {

	/**
	 * Constructor
	 *
	 * @since 2.2
	 *
	 * @param object $rest_api      Instance of PLL_REST_API
	 * @param array  $content_types Array of arrays with taxonomies as keys and options as values
	 */
	public function __construct( &$rest_api, $content_types ) {
		parent::__construct( $rest_api, $content_types );

		$this->type = 'term';
		$this->id   = 'term_id';

		foreach ( array_keys( $content_types ) as $taxonomy ) {
			add_filter( "rest_pre_insert_{$taxonomy}", array( $this, 'pre_insert_term' ), 10, 2 );
		}
	}

	/**
	 * Get the rest field type for a content type
	 *
	 * @since 2.3.11
	 *
	 * @param string $type Taxonomy name
	 * @return string REST API field type
	 */
	protected function get_rest_field_type( $type ) {
		// Handles the specific case for tags
		return 'post_tag' === $type ? 'tag' : $type;
	}

	/**
	 * Creates the term slug in case the term already exists in another language
	 * to allow it to share the same slugs as terms in other languages
	 *
	 * @since 2.3
	 *
	 * @param object $prepared_term Term object.
	 * @param object $request       Request object.
	 */
	public function pre_insert_term( $prepared_term, $request ) {
		$params = $request->get_params();

		if ( ! empty( $params['lang'] ) ) {
			$lang = $params['lang'];
		} elseif ( ! empty( $params['id'] ) && $language = $this->model->term->get_language( $params['id'] ) ) { // Update
			$lang = $language->slug;
		}

		if ( ! empty( $lang ) ) {
			if ( empty( $params['slug'] ) && empty( $params['id'] ) && ! empty( $params['name'] ) ) {
				// The term is created without specifying the slug
				$prepared_term->slug = sanitize_title( $params['name'] . '___' . $lang );
			} elseif ( ! empty( $params['slug'] ) && false === strpos( '___', $params['slug'] ) ) {
				// The term is created or updated and the slug is specified
				$prepared_term->slug = sanitize_title( $params['slug'] . '___' . $lang );
			}
		}

		return $prepared_term;
	}
}
