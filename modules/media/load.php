<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

add_filter(
	'pll_settings_modules',
	function( $modules ) {
		$k = array_search( 'PLL_Settings_Media', $modules );
		$modules[ $k ] = 'PLL_Settings_Advanced_Media';
		return $modules;
	},
	0
);

add_action(
	'pll_init',
	function( $polylang ) {
		if ( $polylang->model->get_languages_list() && $polylang->options['media_support'] ) {
			if ( $polylang instanceof PLL_Admin ) {
				require_once POLYLANG_PRO_DIR . '/modules/bulk-translate/load.php';
			}

			if ( $polylang instanceof PLL_Admin || $polylang instanceof PLL_REST_Request ) {
				$polylang->advanced_media = new PLL_Admin_Advanced_Media( $polylang );
			}
		}
	}
);
