<?php
/**
 * @package Polylang-Pro
 */

/**
 * This class is part of the ACF compatibility.
 * Adds a field setting to decide if the field must be copied, translated or synchronized.
 * And handles the list of metas to copy.
 *
 * @since 2.7
 */
class PLL_ACF_Sync_Metas {

	/**
	 * Constructor.
	 * Setups actions and filters.
	 *
	 * @since 2.7
	 */
	public function __construct() {
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

		// Get the metas to copy or synchronize.
		add_filter( 'pll_copy_post_metas', array( $this, 'copy_metas' ), 1, 4 );
		add_filter( 'pll_copy_term_metas', array( $this, 'copy_term_metas' ), 1, 4 );

		// Get the private metas to synchronize. Very late to wait for the complete list.
		add_filter( 'pll_copy_post_metas', array( $this, 'copy_private_metas' ), 999, 3 );
		add_filter( 'pll_copy_term_metas', array( $this, 'copy_private_metas' ), 998, 3 );
	}

	/**
	 * Renders the translations setting.
	 *
	 * @since 2.7
	 *
	 * @param array  $field   ACF field.
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

	/**
	 * Renders translations setting for fields with text (includes the translate option)
	 *
	 * @since 2.7
	 *
	 * @param array $field ACF field.
	 * @return void
	 */
	public function render_field_settings_text( $field ) {
		$choices = array(
			'ignore'    => __( 'Ignore', 'polylang-pro' ),
			'copy_once' => __( 'Copy once', 'polylang-pro' ),
			'translate' => __( 'Translate', 'polylang-pro' ),
			'sync'      => __( 'Synchronize', 'polylang-pro' ),
		);
		$default = 'translate';
		$this->render_field_setting( $field, $choices, $default );
	}

	/**
	 * Renders a default translations setting (no translate option).
	 *
	 * @since 2.7
	 *
	 * @param array $field ACF field.
	 * @return void
	 */
	public function render_field_settings_default( $field ) {
		$choices = array(
			'ignore'    => __( 'Ignore', 'polylang-pro' ),
			'copy_once' => __( 'Copy once', 'polylang-pro' ),
			'sync'      => __( 'Synchronize', 'polylang-pro' ),
		);
		$default = in_array( 'post_meta', PLL()->options['sync'] ) ? 'sync' : 'copy_once';
		$this->render_field_setting( $field, $choices, $default );
	}

	/**
	 * Recursively constructs the map of translations properties for all metas.
	 *
	 * @since 2.7
	 *
	 * @param array  $translations Reference to an array of meta keys.
	 * @param string $name         Meta key.
	 * @param array  $value        ACF field value.
	 * @param array  $field        ACF field.
	 * @return void
	 */
	protected function get_translations( &$translations, $name, $value, $field ) {
		switch ( $field['type'] ) {
			case 'group':
				foreach ( $field['sub_fields'] as $sub_field ) {
					if ( isset( $value[ $sub_field['name'] ] ) ) {
						$this->get_translations( $translations, "{$name}_{$sub_field['name']}", $value[ $sub_field['name'] ], $sub_field );
					}
				}
				break;

			case 'repeater':
				if ( is_array( $value ) ) {
					foreach ( array_keys( $value ) as $row ) {
						foreach ( $field['sub_fields'] as $sub_field ) {
							if ( is_array( $value[ $row ] ) && isset( $value[ $row ][ $sub_field['name'] ] ) ) {
								$this->get_translations( $translations, "{$name}_{$row}_{$sub_field['name']}", $value[ $row ][ $sub_field['name'] ], $sub_field );
							}
						}
					}
				}
				break;

			case 'flexible_content':
				if ( is_array( $value ) ) {
					foreach ( array_keys( $value ) as $row ) {
						foreach ( $field['layouts'] as $layout ) {
							foreach ( $layout['sub_fields'] as $sub_field ) {
								if ( is_array( $value[ $row ] ) && isset( $value[ $row ][ $sub_field['name'] ] ) ) {
									$this->get_translations( $translations, "{$name}_{$row}_{$sub_field['name']}", $value[ $row ][ $sub_field['name'] ], $sub_field );
								}
							}
						}
					}
				}
				break;

			default:
				if ( isset( $field['translations'] ) ) {
					$translations[ $field['translations'] ][] = $name;
				}
				break;
		}
	}

	/**
	 * Selects the metas to be copied or synchronized.
	 *
	 * @since 2.7
	 *
	 * @param string[]   $metas List of custom fields names.
	 * @param bool       $sync  True if it is synchronization, false if it is a copy.
	 * @param string|int $from  Id of the object from which we copy informations.
	 * @param string|int $to    Id of the object to which we copy informations.
	 * @return string[]
	 */
	public function copy_metas( $metas, $sync, $from, $to ) {
		// Init the translations array.
		$translations = array_fill_keys(
			array(
				'ignore',
				'copy_once',
				'translate',
				'sync',
			),
			array()
		);

		$objects = get_field_objects( $from );

		if ( $sync && empty( $objects ) ) {
			// When saving a translation for the first, we don't have any field objects, so let's try to use fields of the target instead.
			$objects = get_field_objects( $to );
		}

		// Get the metas sorted by their translations setting.
		if ( is_array( $objects ) ) {
			foreach ( $objects as $name => $object ) {
				if ( ! empty( $object['value'] ) ) {
					$this->get_translations( $translations, $name, $object['value'], $object );
				}
			}
		}

		if ( $sync ) {
			$metas = array_diff( $metas, $translations['ignore'], $translations['copy_once'], $translations['translate'] );
			$metas = array_merge( $metas, $translations['sync'] );
		} else {
			$metas = array_diff( $metas, $translations['ignore'] );
			$metas = array_merge( $metas, $translations['sync'], $translations['copy_once'], $translations['translate'] );
		}

		return $metas;
	}

	/**
	 * Selects the term metas to be copied or synchronized.
	 *
	 * @since 2.7.4
	 *
	 * @param string[] $metas List of custom fields names.
	 * @param bool     $sync  True if it is synchronization, false if it is a copy.
	 * @param int      $from  Id of the object from which we copy informations.
	 * @param int      $to    Id of the object to which we copy informations.
	 * @return string[]
	 */
	public function copy_term_metas( $metas, $sync, $from, $to ) {
		return $this->copy_metas( $metas, $sync, 'term_' . $from, 'term_' . $to );
	}

	/**
	 * Selects the private ACF metas to be synchronized.
	 *
	 * @since 2.7
	 *
	 * @param string[] $metas List of custom fields names.
	 * @param bool     $sync  True if it is synchronization, false if it is a copy.
	 * @param int      $from  Id of the object from which we copy informations.
	 * @return string[]
	 */
	public function copy_private_metas( $metas, $sync, $from ) {
		if ( $sync ) {
			$meta_type = substr( current_filter(), 9, 4 );

			foreach ( get_metadata( $meta_type, $from ) as $key => $value ) {
				$value = reset( $value );
				if ( is_string( $value ) && acf_is_field_key( $value ) && array_search( substr( $key, 1 ), $metas ) ) {
					$metas[] = $key; // Private keys added to non private.
				}
			}
		}

		return $metas;
	}
}
