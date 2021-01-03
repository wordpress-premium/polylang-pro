<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang instanceof PLL_Admin && $polylang->model->get_languages_list() ) {
	$polylang->bulk_translate = new PLL_Bulk_Translate( $polylang->model );
	add_action( 'current_screen', array( $polylang->bulk_translate, 'init' ) );
}
