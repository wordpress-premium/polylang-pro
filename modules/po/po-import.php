<?php
/**
 * @package Polylang-Pro
 */

/**
 * PO file, generated from importing translations
 *
 * Handles the reading of a PO file.
 *
 * @since 2.7
 */
class PLL_PO_Import implements  PLL_Import_File_Interface {

	/**
	 * Po object.
	 *
	 * @var PO
	 */
	private $po;

	/**
	 * PLL_Import_File_Interface constructor.
	 *
	 * Creates a PO object from an imported file.
	 *
	 * @since 2.7
	 */
	public function __construct() {
		require_once ABSPATH . '/wp-includes/pomo/po.php';
		$this->po = new PO();
	}

	/**
	 * Import the translations from a file.
	 *
	 * Relies on {@see PO::import_from_file()}
	 *
	 * @since 2.7
	 *
	 * @param string $filepath The path on the filesystem where the import file is located.
	 * @return WP_Error|true
	 */
	public function import_from_file( $filepath ) {
		// PO::import_from_file returns false in case it does not succeed to parse the file.
		if ( ! $this->po->import_from_file( $filepath ) ) {
			return new WP_Error( 'pll_import_wrong_po', esc_html__( 'Error: Invalid file.', 'polylang-pro' ) );
		}
		return true;
	}

	/**
	 * Get the source language
	 *
	 * @since 2.7
	 *
	 * @return string|false
	 */
	public function get_source_lang() {
		if ( ! empty( $this->po->headers['Language-Source'] ) ) {
			return $this->po->headers['Language-Source'];
		}
		return false;
	}

	/**
	 * Get the target language
	 *
	 * @since 2.7
	 *
	 * @return string|false
	 */
	public function get_target_language() {
		if ( ! empty( $this->po->headers['Language-Target'] ) ) {
			return $this->po->headers['Language-Target'];
		}
		return false;
	}

	/**
	 * Get the site reference.
	 *
	 * @since 2.7
	 *
	 * @return string|false
	 */
	public function get_site_reference() {
		if ( ! empty( $this->po->headers['Site-Reference'] ) ) {
			return $this->po->headers['Site-Reference'];
		}
		return false;
	}

	/**
	 * Get the next string translation to import.
	 *
	 * @since 2.7
	 *
	 * @return array
	 */
	public function get_next_entry() {
		return array(
			'id'   => null,
			'type' => PLL_Import_Export::STRINGS_TRANSLATION,
			'data' => $this->po,
		);
	}

}
