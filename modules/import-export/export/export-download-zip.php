<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles file download.
 *
 * @since 2.7
 */
class PLL_Export_Download_Zip {

	/**
	 * Name of the zipped file.
	 *
	 * @var string
	 */
	private $zip_name;

	/**
	 * Size of the zipped file.
	 *
	 * @var int
	 */
	private $zip_size;

	/**
	 * The file path.
	 *
	 * @var string
	 */
	private $filepath;

	/**
	 * Creates a new zip containing several files
	 *
	 * @since 2.7
	 *
	 * @see https://www.php.net/manual/class.ziparchive.php PHP ZipArchive library
	 *
	 * @param PLL_Export_Multi_Files $export A collection of files to be exported as zip.
	 * @return bool true if file have been created.
	 */
	public function create( $export ) {
		$upload_dir = wp_upload_dir()['path'];

		if ( ! class_exists( 'ZipArchive' ) || ! is_writable( $upload_dir ) ) { // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_is_writable
			return false;
		}

		$zip = new ZipArchive();
		$this->zip_name = 'pll_export_' . time() . '.zip';
		$this->filepath = $upload_dir . '/' . $this->zip_name;

		if ( ! $zip->open( $this->filepath, ZipArchive::CREATE ) ) {
			return false;
		}

		foreach ( $export as $export_file ) {
			$export_file_content = $export_file->export();
			if ( ! $export_file_content ) {
				continue;
			}
			$zip->addFromString( $export_file->get_filename(), $export_file_content );
		}

		if ( ! $zip->close() ) {
			return false;
		}

		$filesize = filesize( $this->filepath );
		if ( ! $filesize ) {
			return false;
		}
		$this->zip_size = $filesize;
		return true;
	}

	/**
	 * Wrapper for {@see PLL_Export_Download_Zip::send_headers()} and {@see PLL_Export_Download_Zip::download()}
	 * Also exits the current script.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function send_response() {
		$this->send_headers();
		$this->download();
	}

	/**
	 * Set correct headers for downloading a file in the browser.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	private function send_headers() {
		header( 'Content-Disposition: attachment; filename=' . $this->zip_name );
		header( 'Content-Type: application/zip' );
		header( 'Content-Length: ' . $this->zip_size );
	}

	/**
	 * Outputs in the buffer the zipped file and delete the local zip.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	private function download() {
		if ( ob_get_length() > 0 ) {
			ob_clean();
		}

		readfile( $this->filepath ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_readfile
		wp_delete_file( $this->filepath );
		exit;
	}
}
