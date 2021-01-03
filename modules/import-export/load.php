<?php
/**
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

if ( $polylang instanceof PLL_Settings && $polylang->model->get_languages_list() ) {
	$polylang->import_export = new PLL_Import_Export( $polylang );
}
