<?php
/**
 * @package Polylang-Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * A class that filters blocks in a Site Editor context.
 *
 * @since 3.2.2
 */
class PLL_FSE_Filter_Block_Types extends PLL_FSE_Abstract_Module implements PLL_Module_Interface {

	/**
	 * Returns the module's name.
	 *
	 * @since 3.2.2
	 *
	 * @return string
	 */
	public static function get_name() {
		return 'fse_manage_template_part_blocks';
	}

	/**
	 * Sub-module init.
	 *
	 * @since 3.2.2
	 *
	 * @return self
	 */
	public function init() {
		add_filter( 'block_type_metadata_settings', array( $this, 'remove_template_part_instance_variations' ), 10, 2 );

		return $this;
	}


	/**
	 * Filters out template part instances from block `core/template-part` variations.
	 * This avoids to display all translations of templates parts in the block selection list,
	 * otherwhise the confusing UI could allow a user to insert a template part in a wrong language.
	 *
	 * @since 3.2.2
	 *
	 * @param array $settings Array of determined settings for registering a block type.
	 * @param array $metadata Metadata provided for registering a block type..
	 * @return array Filtered array of settings with removed template part instances variations.
	 */
	public function remove_template_part_instance_variations( $settings, $metadata ) {
		if ( 'core/template-part' !== $metadata['name'] ) {
			return $settings;
		}

		if ( empty( $settings['variations'] ) || ! is_array( $settings['variations'] ) ) {
			return $settings;
		}

		foreach ( $settings['variations'] as $i => $variation ) {
			/*
			 * Check attributes specific to template part instances variations to keep area variations registered.
			 * See: {https://github.com/WordPress/wordpress-develop/blob/6.1.1/src/wp-includes/blocks/template-part.php#L186-L238}
			 * and {https://github.com/WordPress/wordpress-develop/blob/6.1.1/src/wp-includes/blocks/template-part.php#L161-L184}.
			 */
			if ( ! isset( $variation['attributes']['slug'], $variation['attributes']['theme'] ) ) {
				continue;
			}

			unset( $settings['variations'][ $i ] );
		}

		$settings['variations'] = array_values( $settings['variations'] ); // Re-index the array correctly.

		return $settings;
	}
}
