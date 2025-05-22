<?php
/**
 * @package Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF;

use WP_Syntex\Polylang_Pro\Integrations\ACF\Location_Language;

/**
 * This class is part of the ACF compatibility.
 * Adds a field setting to decide if the field must be copied, translated or synchronized.
 *
 * @since 3.7
 */
class Field_Settings {

	/**
	 * Setups actions.
	 *
	 * @since 3.7
	 *
	 * @return void
	 */
	public function on_acf_init() {
		// Adds the field setting, except for fields of type layout.
		foreach ( acf_get_field_types() as $type ) { // Since ACF 5.6.0.
			if ( 'layout' !== $type->category ) {
				switch ( $type->name ) {
					case 'text':
					case 'textarea':
					case 'wysiwyg':
						add_action( "acf/render_field_settings/type={$type->name}", array( $this, 'render_field_settings_text' ) );
						break;
					default:
						add_action( "acf/render_field_settings/type={$type->name}", array( $this, 'render_field_settings_default' ) );
						break;
				}
			}
		}
	}

	/**
	 * Renders translations setting for fields with text (includes the translate options)
	 *
	 * @since 2.7
	 * @since 3.7 Added `translate_once` option.
	 *
	 * @param array $field Custom field definition.
	 * @return void
	 */
	public function render_field_settings_text( $field ) {
		if ( Location_Language::has_language_location_rule( $field['parent'] ) ) {
			return;
		}

		$choices = array(
			'ignore'         => __( 'Ignore', 'polylang-pro' ),
			'copy_once'      => __( 'Copy once', 'polylang-pro' ),
			'translate'      => __( 'Translate', 'polylang-pro' ),
			'translate_once' => __( 'Translate once', 'polylang-pro' ),
			'sync'           => __( 'Synchronize', 'polylang-pro' ),
		);
		$default = 'translate';
		$this->render_field_setting( $field, $choices, $default );
	}

	/**
	 * Renders a default translations setting (without translate options).
	 *
	 * @since 2.7
	 *
	 * @param array $field Custom field definition.
	 * @return void
	 */
	public function render_field_settings_default( $field ) {
		$choices = array(
			'ignore'    => __( 'Ignore', 'polylang-pro' ),
			'copy_once' => __( 'Copy once', 'polylang-pro' ),
			'sync'      => __( 'Synchronize', 'polylang-pro' ),
		);
		$default = in_array( 'post_meta', PLL()->options['sync'], true ) ? 'sync' : 'copy_once';
		$this->render_field_setting( $field, $choices, $default );
	}

	/**
	 * Renders the translations setting.
	 *
	 * @since 2.7
	 *
	 * @param array  $field   Custom field definition.
	 * @param array  $choices An array of choices for the select (value as key and label as value).
	 * @param string $default Default value for the select.
	 * @return void
	 */
	protected function render_field_setting( $field, $choices, $default ) {
		acf_render_field_setting( // Since ACF 5.7.10.
			$field,
			array(
				'label'         => __( 'Translations', 'polylang-pro' ),
				'instructions'  => '',
				'name'          => 'translations',
				'type'          => 'select',
				'choices'       => $choices,
				'default_value' => $default,
			),
			false // The setting is depending on the type of field.
		);
	}
}
