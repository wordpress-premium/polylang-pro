<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

add_action(
	'after_setup_theme',
	function() {
		if ( defined( 'ACF_VERSION' ) && version_compare( ACF_VERSION, '5.7.11', '>=' ) ) {
			add_action( 'init', array( PLL_Integrations::instance()->acf = new PLL_ACF(), 'init' ) );
		}
	}
);
