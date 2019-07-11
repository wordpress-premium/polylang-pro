<?php

/**
 * Manages compatibility with Custom Post Type UI
 * Version tested: 1.5.4
 *
 * @since 2.1
 */
class PLL_CPTUI {

	/**
	 * Initializes filters and actions
	 *
	 * @since 2.1
	 */
	public function init() {
		add_filter( 'cptui_pre_register_post_type', array( $this, 'translate_strings' ) );
		add_filter( 'cptui_pre_register_taxonomy', array( $this, 'translate_strings' ) );

		if ( PLL() instanceof PLL_Frontend ) {
			if ( ! PLL()->options['force_lang'] ) {
				// Special case when the language is set from the content as CPT and taxonomies are registered before the language is defined
				add_action( 'pll_language_defined', array( $this, 'pll_language_defined' ) );
			}
		} else {
			// Register strings on admin
			$cptui_post_types = get_option( 'cptui_post_types' );
			$this->register_strings( $cptui_post_types );

			$cptui_taxonomies = get_option( 'cptui_taxonomies' );
			$this->register_strings( $cptui_taxonomies );

			// Add CPT UI post types and taxonomies to Polylang settings
			add_filter( 'pll_get_post_types', array( $this, 'pll_get_types' ), 10, 2 );
			add_filter( 'pll_get_taxonomies', array( $this, 'pll_get_types' ), 10, 2 );
		}
	}

	/**
	 * Translates custom post types and taxonomies labels
	 *
	 * @since 2.1
	 *
	 * @param array $args Array of post types or taxonomies arguments
	 * @return array
	 */
	public function translate_strings( $args ) {
		$args['description'] = pll__( $args['description'] );

		foreach ( $args['labels'] as $key => $label ) {
			$args['labels'][ $key ] = pll__( $label );
		}

		return $args;
	}

	/**
	 * Translates custom post types and taxonomies labels when the language is set from the content
	 *
	 * @since 2.1
	 *
	 * @param array $types       Array of registered post types or taxonomies
	 * @param array $cptui_types Array of CPT UI post types or taxonomies
	 */
	public function translate_registered_types( $types, $cptui_types ) {
		foreach ( $types as $name => $type ) {
			if ( in_array( $name, $cptui_types ) ) {
				$type->label       = pll__( $type->labels );
				$type->description = pll__( $type->description );

				foreach ( $type->labels as $key => $label ) {
					$type->labels->$key = pll__( $type->labels->$key );
				}
			}
		}
	}

	/**
	 * Translates custom post types and taxonomies labels when the language is set from the content
	 *
	 * @since 2.1
	 */
	public function pll_language_defined() {
		$this->translate_registered_types( $GLOBALS['wp_post_types'], array_keys( get_option( 'cptui_post_types', array() ) ) );
		$this->translate_registered_types( $GLOBALS['wp_taxonomies'], array_keys( get_option( 'cptui_taxonomies', array() ) ) );
	}

	/**
	 * Registers custom post types and taxonomies labels
	 *
	 * @since 2.1
	 *
	 * @param array $objects Array of CPT UI post types or taxonomies
	 */
	public function register_strings( $objects ) {
		if ( ! empty( $objects ) ) {
			foreach ( $objects as $name => $obj ) {
				pll_register_string( $name . '_label', $obj['label'], 'CPT UI' );
				pll_register_string( $name . '_singular_label', $obj['singular_label'], 'CPT UI' );
				pll_register_string( $name . '_description', $obj['description'], 'CPT UI' );

				foreach ( $obj['labels'] as $key => $label ) {
					pll_register_string( $name . '_' . $key, $label, 'CPT UI' );
				}
			}
		}
	}

	/**
	 * Add CPT UI post types and taxonomies to Polylang settings
	 *
	 * @since 2.1
	 *
	 * @param array $types       List of post type or taxonomy names
	 * @param bool  $is_settings True when displaying the list in Polylang settings
	 * @return array
	 */
	public function pll_get_types( $types, $is_settings ) {
		if ( $is_settings ) {
			$type        = substr( current_filter(), 8 );
			$cptui_types = get_option( "cptui_{$type}" );

			if ( is_array( $cptui_types ) ) {
				$types = array_merge( $types, array_keys( $cptui_types ) );
			}
		}
		return $types;
	}
}
