<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

add_action(
	'pll_init',
	function( $polylang ) {
		// Testing register_block_type to ensure backward compatibility with WP < 5.0
		if ( function_exists( 'register_block_type' ) && $polylang->model->get_languages_list() && pll_use_block_editor_plugin() ) {
			if ( $polylang instanceof PLL_Admin ) {
				$polylang->block_editor_plugin = new PLL_Block_Editor_Plugin( $polylang );
			}

			$polylang->switcher_block = new PLL_Block_Editor_Switcher_Block( $polylang );
		}
	}
);
