<?php
/**
 * @package Polylang-Pro
 */

/**
 * The export interface file which implement the interface.
 *
 * Each class implementing this interface shall be the representation of a single file to be exported
 *
 * @since 2.7
 * @since 3.1 Renamed from 'PLL_Export_File_Interface'
 */
abstract class PLL_Export_File {
	/**
	 * @since 3.1
	 *
	 * @return string
	 */
	abstract public function get_extension();

	/**
	 * @since 3.1
	 *
	 * @return string
	 */
	abstract public function get_source_language();

	/**
	 *
	 * Set source language to export
	 *
	 * @since 2.7
	 *
	 * @param string $source_language Locale.
	 * @return void
	 */
	abstract public function set_source_language( $source_language );

	/**
	 * @since 3.1
	 *
	 * @return string
	 */
	abstract public function get_target_language();

	/**
	 *
	 * Set target languages to export
	 *
	 * @since 2.7
	 *
	 * @param string $target_language Target language.
	 * @return void
	 */
	abstract public function set_target_language( $target_language );

	/**
	 *
	 * Add a translation source and target to the current translation file.
	 *
	 * @since 2.7
	 *
	 * @param string $type   Describe what does this data corresponds to, such as a post title, a meta reference etc...
	 * @param string $source The source to be translated.
	 * @param string $target Optional, a preexisting translation, if any.
	 * @param array  $args   Optional, an array of additional arguments, like an identifier for the string, its context, comments for translators, etc.
	 * @return void
	 */
	abstract public function add_translation_entry( $type, $source, $target = '', $args = array() );

	/**
	 * Adds a reference to a source of translations entries.
	 *
	 * @since 2.7
	 *
	 * @param string $type Type of data to be exported.
	 * @param string $id   Optional, a unique identifier to retrieve the data in the database.
	 * @return void
	 */
	abstract public function set_source_reference( $type, $id = '' );

	/**
	 * Adds a reference to the site from which the file has been exported.
	 *
	 * @since 2.7
	 *
	 * @param string $url Absolute URL of the current site exporting content.
	 * @return void
	 */
	abstract public function set_site_reference( $url );

	/**
	 * Returns the content of the file
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	abstract public function export();

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
