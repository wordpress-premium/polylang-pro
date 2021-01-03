<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles file verifications.
 * Instantiates the right import classes according to the file type.
 *
 * @since 2.7
 */
class PLL_Import_File {
	/**
	 * Used to set supported file formats.
	 *
	 * @var string
	 */
	const SUPPORTED_FORMATS = array(
		'po' => 'text/x-po',
	);

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
	 * @param string $filepath Path to the current location of the uploaded file.
	 * @return PLL_Import_File_Interface|WP_Error
	 */
	public function load( $filepath ) {
		add_filter( 'upload_mimes', array( $this, 'allowed_mimes' ) ); // phpcs:ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes

		$overrides = array(
			'test_form' => false,
		);

		$this->upload = wp_handle_upload( $filepath, $overrides );

		if ( isset( $this->upload['error'] ) ) {
			return new WP_Error( 'pll_import_upload_error', esc_html( $this->upload['error'] ) );
		}

		switch ( $this->upload['type'] ) {
			case 'text/x-po':
				$import = new PLL_PO_Import();
				$error = $import->import_from_file( $this->upload['file'] );
				return is_wp_error( $error ) ? $error : $import;
			default:
				return new WP_Error(
					'pll_import_wrong_format',
					sprintf(
						/* translators: %s is a suite of comma separate file formats */
						esc_html__( 'Error: Wrong file format. The supported file formats are: %s.', 'polylang-pro' ),
						strtoupper( implode( ', ', array_keys( self::SUPPORTED_FORMATS ) ) )
					)
				);
		}
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
		return array_merge( $mimes, self::SUPPORTED_FORMATS );
	}
}
