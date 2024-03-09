<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles file verifications.
 * Instantiates the right import classes according to the file type.
 *
 * @since 2.7
 * @since 3.1 Renamed from PLL_Import_File
 */
class PLL_Import_Uploader {
	/**
	 * Stores the properties of the uploaded file
	 *
	 * @since 2.7
	 *
	 * @var array {
	 *   string $file Path to the current location of the file.
	 *   string $type MIME type of the uploaded file.
	 *   string $error Message for errors having occurred during file upload.
	 * }
	 */
	private $upload;

	/**
	 * @var PLL_File_Format_Factory
	 */
	private $file_format_factory;

	/**
	 * PLL_Import_Uploader constructor.
	 */
	public function __construct() {
		$this->file_format_factory = new PLL_File_Format_Factory();
	}

	/**
	 * Deletes the file when no longer needed.
	 *
	 * @since 2.7
	 */
	public function __destruct() {
		if ( isset( $this->upload['file'] ) ) {
			wp_delete_file( $this->upload['file'] );
		}
	}


	/**
	 * Handles uploading a file.
	 * Returns an import class instance according to the upload file type.
	 *
	 * @since 2.7
	 *
	 * @param string[] $file Reference to a single element contained in $_FILE superglobal, passed to {@see wp_handle_upload()}.
	 * @return PLL_Import_File_Interface|WP_Error
	 */
	public function load( $file ) {
		add_filter( 'upload_mimes', array( $this, 'allowed_mimes' ) ); // phpcs:ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes

		$overrides = array(
			'test_form' => false,
		);

		$this->upload = wp_handle_upload( $file, $overrides );

		remove_filter( 'upload_mimes', array( $this, 'allowed_mimes' ) );

		if ( isset( $this->upload['error'] ) ) {
			return new WP_Error( 'pll_import_error', esc_html( $this->upload['error'] ) );
		}

		$file_format = $this->file_format_factory->from_mime_type( $this->upload['type'] );

		if ( is_wp_error( $file_format ) ) {
			return $file_format;
		}

		$import_file = $file_format->get_import();
		$result = $import_file->import_from_file( $this->upload['file'] );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return $import_file;
	}

	/**
	 * Adds translation files formats to the list of allowed mime types
	 *
	 * @since 2.7
	 *
	 * @param array $mimes List of allowed mime types.
	 * @return array Modified list of allowed mime types.
	 */
	public function allowed_mimes( $mimes ) {
		foreach ( $this->file_format_factory->get_supported_formats() as $format ) {
			$mimes = array_merge( $mimes, $format->mime_type );
		}
		return $mimes;
	}
}
