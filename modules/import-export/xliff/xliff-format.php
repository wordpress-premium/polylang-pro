<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_Xliff_Format
 *
 * @since 3.1
 *
 * Manage support for the xliff file format
 */
class PLL_Xliff_Format extends PLL_File_Format {
	/**
	 * @var string
	 */
	public $extension = 'xliff';

	/**
	 * @var string[]
	 */
	public $mime_type = array( 'xlf|xliff' => 'text/xml' );

	/**
	 * PLL_Xliff_Format constructor.
	 *
	 * @since 3.1
	 */
	public function __construct() {
		// MIME type does not use the same string for PHP versions < 7.2.
		if ( version_compare( phpversion(), '7.2', '<' ) ) {
			$this->mime_type = array( 'xlf|xliff' => 'application/xml' );
		}
	}

	/**
	 * Whether the xliff format is supported or not by the current environment.
	 *
	 * @since 3.1
	 *
	 * @return true|WP_Error
	 */
	public function is_supported() {
		if ( ! extension_loaded( 'libxml' ) ) {
			return new WP_Error( 'libxml_missing', 'Your PHP installation appears to be missing the libxml extension which is required by the importer.' );
		}

		return true;
	}

	/**
	 * Returns the associated import class.
	 *
	 * @since 3.1
	 *
	 * @return PLL_Xliff_Import
	 */
	public function get_import() {
		return new PLL_Xliff_Import();
	}

	/**
	 * Returns the associated export class.
	 *
	 * @since 3.1
	 *
	 * @return PLL_Xliff_Export
	 */
	public function get_export() {
		return new PLL_Xliff_Export();
	}

}
