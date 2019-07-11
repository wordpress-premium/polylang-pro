<?php

/**
 * Abstract class to expose posts (or terms) language and translations in the REST API
 *
 * @since 2.2
 */
abstract class PLL_REST_Translated_Object {
	public $model, $links;
	protected $type, $id, $content_types;

	/**
	 * Constructor
	 *
	 * @since 2.2
	 * @since 2.2.1 $content_types is an array of arrays
	 * @since 2.6   The first parameter is an instance of PLL_REST_API instead of PLL_Model
	 *
	 * @param object $rest_api      Instance of PLL_REST_API
	 * @param array  $content_types Array of arrays with post types or taxonomies as keys and options as values
	 *                              The possible options are:
	 *                              filters:      whether to filter queries, defaults to true
	 *                              lang:         whether to return the language in the response, defaults to true
	 *                              translations: whether to return the translations in the response, defaults to true
	 */
	public function __construct( &$rest_api, $content_types ) {
		$this->model = &$rest_api->model;
		$this->links = &$rest_api->links;

		$this->content_types = $content_types;

		foreach ( $content_types as $type => $args ) {

			$args = wp_parse_args( $args, array_fill_keys( array( 'filters', 'lang', 'translations' ), true ) );

			if ( $args['filters'] ) {
				add_filter( "rest_{$type}_query", array( $this, 'query' ), 10, 2 );
				add_filter( "rest_{$type}_collection_params", array( $this, 'collection_params' ) );
			}

			if ( $args['lang'] ) {
				register_rest_field(
					$this->get_rest_field_type( $type ),
					'lang',
					array(
						'get_callback'    => array( $this, 'get_language' ),
						'update_callback' => array( $this, 'set_language' ),
						'schema'          => array(
							'lang' => __( 'Language', 'polylang' ),
							'type' => 'string',
						),
					)
				);
			}

			if ( $args['translations'] ) {
				register_rest_field(
					$this->get_rest_field_type( $type ),
					'translations',
					array(
						'get_callback'    => array( $this, 'get_translations' ),
						'update_callback' => array( $this, 'save_translations' ),
						'schema'          => array(
							'translations' => __( 'Translations', 'polylang' ),
							'type' => 'object',
						),
					)
				);
			}
		}
	}

	/**
	 * Get the rest field type for a content type
	 *
	 * @since 2.3.11
	 *
	 * @param string $type Post type or taxonomy name
	 * @return string REST API field type
	 */
	protected function get_rest_field_type( $type ) {
		return $type;
	}

	/**
	 * Filters the query per language according to the 'lang' parameter
	 *
	 * @since 2.2
	 *
	 * @param array $args    Query args
	 * @param array $request REST API request args
	 * @return array
	 */
	public function query( $args, $request ) {
		$args['lang'] = isset( $request['lang'] ) && in_array( $request['lang'], $this->model->get_languages_list( array( 'fields' => 'slug' ) ) ) ? $request['lang'] : '';
		return $args;
	}

	/**
	 * Exposes the 'lang' param for posts and terms
	 *
	 * @since 2.2
	 *
	 * @param array $query_params JSON Schema-formatted collection parameters.
	 * @return array
	 */
	public function collection_params( $query_params ) {
		$query_params['lang'] = array(
			'description' => __( 'Limit results to a specific language.', 'polylang-pro' ),
			'type'        => 'string',
			'enum'        => $this->model->get_languages_list( array( 'fields' => 'slug' ) ),
		);
		return $query_params;
	}

	/**
	 * Returns the object language
	 *
	 * @since 2.2
	 *
	 * @param array $object Post or Term array
	 * @return string
	 */
	public function get_language( $object ) {
		$language = $this->model->{$this->type}->get_language( $object['id'] );
		return empty( $language ) ? false : $language->slug;
	}

	/**
	 * Sets the object language
	 *
	 * @since 2.2
	 *
	 * @param string $lang   Language code
	 * @param object $object Instance of WP_Post or WP_Term
	 * @return bool
	 */
	public function set_language( $lang, $object ) {
		if ( isset( $object->{$this->id} ) ) { // Test to avoid a warning with WooCommerce
			$this->model->{$this->type}->set_language( $object->{$this->id}, $lang );
		}
		return true;
	}

	/**
	 * Returns the object translations
	 *
	 * @since 2.2
	 *
	 * @param array $object Post or Term array
	 * @return array
	 */
	public function get_translations( $object ) {
		return $this->model->{$this->type}->get_translations( $object['id'] );
	}

	/**
	 * Save translations
	 *
	 * @since 2.2
	 *
	 * @param array  $translations Array of translations with language codes as keys and object ids as values
	 * @param object $object       Instance of WP_Post or WP_Term
	 * @return bool
	 */
	public function save_translations( $translations, $object ) {
		if ( isset( $object->{$this->id} ) ) { // Test to avoid a warning with WooCommerce
			$this->model->{$this->type}->save_translations( $object->{$this->id}, $translations );
		}
		return true;
	}
}
