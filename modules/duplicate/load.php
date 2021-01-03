<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang->model->get_languages_list() ) {
	if ( $polylang instanceof PLL_Admin ) {
		new PLL_Admin_Loader( $polylang, 'duplicate' );
	} elseif ( $polylang instanceof PLL_REST_Request ) {
		$polylang->duplicate = new PLL_Duplicate_REST( $polylang );
	}
}
