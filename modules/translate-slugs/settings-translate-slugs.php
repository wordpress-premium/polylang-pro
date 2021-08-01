<?php
/**
 * @package Polylang-Pro
 */

/**
 * Settings class to display information for the Translate slugs module.
 *
 * @since 3.1
 */
class PLL_Settings_Translate_Slugs extends PLL_Settings_Preview_Translate_Slugs {
	/**
	 * Returns the module description.
	 *
	 * @since 3.1
	 *
	 * @return string
	 */
	protected function get_description() {
		return parent::get_description() . ' ' . __( 'The module is automatically deactivated when using plain permalinks.', 'polylang-pro' );
	}

	/**
	 * Tells if the module is active.
	 *
	 * @since 1.9
	 *
	 * @return bool
	 */
	public function is_active() {
		return get_option( 'permalink_structure' );
	}

	/**
	 * Avoid displaying the upgrade message.
	 *
	 * @since 1.9
	 *
	 * @return string
	 */
	public function get_upgrade_message() {
		return '';
	}
}
