<?php
/**
 * @package Polylang-Pro
 */

/**
 * Interface PLL_Import_File_Interface
 *
 * Each class implementing this interface shall be the representation of a single file to be imported
 *
 * @since 2.7
 * @since 3.1 Renamed from PLL_Import_File_Interface
 */
abstract class PLL_Import_File {
	/**
	 * Import the translations from a file.
	 *
	 * @since 2.7
	 *
	 * @param string $filepath The path on the filesystem where the import file is located.
	 * @return WP_Error|true
	 */
	abstract public function import_from_file( $filepath );

	/**
	 *
	 * Get the language of the source
	 *
	 * @since 2.7
	 * @since 3.1 Renamed from PLL_Import_File_Interface::get_source_lang()
	 *
	 * @return string|false
	 */
	abstract public function get_source_language();

	/**
	 * Get the target language
	 *
	 * @since 2.7
	 *
	 * @return string|false
	 */
	abstract public function get_target_language();

	/**
	 * Get the next content to import.
	 *
	 * @since 2.7
	 *
	 * @return array
	 */
	abstract public function get_next_entry();

	/**
	 * Get the site reference
	 *
	 * @since 2.7
	 *
	 * @return string|false
	 */
	abstract public function get_site_reference();
}
