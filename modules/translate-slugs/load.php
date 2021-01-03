<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang->model->get_languages_list() && get_option( 'permalink_structure' ) ) {
	$slugs_model = new PLL_Translate_Slugs_Model( $polylang );

	if ( $polylang instanceof PLL_Frontend ) {
		$polylang->translate_slugs = new PLL_Frontend_Translate_Slugs( $slugs_model, $polylang->curlang );
	} else {
		$curlang = isset( $polylang->curlang ) ? $polylang->curlang : null;
		$polylang->translate_slugs = new PLL_Translate_Slugs( $slugs_model, $curlang );
	}
}
