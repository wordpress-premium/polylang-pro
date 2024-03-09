<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_Export_File
 *
 * @since 3.1
 */
abstract class PLL_Export_File implements PLL_Export_File_Interface {

	/**
	 * Returns the name of the file to export.
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	public function get_filename() {
		$source_language = $this->get_source_language();
		$target_language = $this->get_target_language();
		$datenow = gmdate( 'Y-m-d-G:i:s' );
		$extension = $this->get_extension();

		return "{$source_language}_{$target_language}_{$datenow}.{$extension}";
	}
}
