<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang->model->get_languages_list() ) {
	add_filter(
		'pll_settings_modules',
		function( $modules ) {
			$k = array_search( 'PLL_Settings_Preview_Share_Slug', $modules );
			if ( $k ) {
				$modules[ $k ] = 'PLL_Settings_Share_Slug';
			}
			return $modules;
		},
		20 // After Polylang.
	);

	if ( get_option( 'permalink_structure' ) && $polylang->options['force_lang'] ) {
		// Share post slugs.
		$polylang->share_post_slug = new PLL_Share_Post_Slug( $polylang );

		// Share term slugs.
		if ( $polylang instanceof PLL_Admin ) {
			$polylang->share_term_slug = new PLL_Admin_Share_Term_Slug( $polylang );
		} else {
			$polylang->share_term_slug = new PLL_Share_Term_Slug( $polylang );
		}
	}
}
