<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang->model->get_languages_list() ) {
	$polylang->active_languages = new PLL_Active_Languages( $polylang );
}
