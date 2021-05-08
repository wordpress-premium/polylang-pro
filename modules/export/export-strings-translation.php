<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles the admin action of exporting strings translations.
 *
 * @since 2.7
 */
class PLL_Export_Strings_Translation {
	/**
	 * Used to set the action's name in forms.
	 *
	 * @var string
	 */
	const ACTION_NAME = 'pll_translate';

	/**
	 * Used to create nonces for the action.
	 *
	 * @var string
	 */
	const NONCE_NAME = '_pll_translate_nonce';

	/**
	 * A class to handle file download.
	 *
	 * @var PLL_Export_Download_Zip
	 */
	private $downloader;

	/**
	 * Represents an export file.
	 *
	 * @var PLL_Export_File_Interface
	 */
	private $export;

	/**
	 * Used to query languages and translations.
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Stores the plugin options.
	 *
	 * @var array
	 */
	private $options;

	/**
	 * PLL_Export_Strings_Translation constructor.
	 *
	 * @since 2.7
	 *
	 * @param PLL_Model $model            Polylang model.
	 * @param array     $polylang_options Polylang options.
	 */
	public function __construct( $model, $polylang_options ) {
		$this->options = $polylang_options;
		$this->model = $model;

		$this->export = new PLL_Export_Multi_Files( new PLL_PO_Export() );

		$this->downloader = new PLL_Export_Download_Zip();
	}

	/**
	 * Prepare and export the selected strings translations.
	 *
	 * @since 2.7
	 *
	 * @param array  $target_languages Array of languages slugs.
	 * @param string $group            String translation context to export.
	 * @return void
	 */
	public function send_strings_translation_to_export( $target_languages, $group ) {

		foreach ( $target_languages as $target_language ) {
			$lang = $this->model->get_language( $target_language );

			$this->export->set_source_language( $this->model->get_language( $this->options['default_lang'] )->get_locale( 'display' ) );
			$this->export->set_target_language( $lang->get_locale( 'display' ) );

			$this->export->set_site_reference( get_site_url() );

			$this->export->set_source_reference( PLL_Import_Export::STRINGS_TRANSLATION );

			$mo = new PLL_MO();
			$mo->import_from_db( $lang );

			foreach ( PLL_Admin_Strings::get_strings() as $string ) {
				if ( ( $group === $string['context'] ) || '-1' === $group ) {
					$mo_tr = $mo->translate( $string['string'] );
					$args = array(
						'id'      => $string['name'],
						'context' => $string['context'],
					);

					// Arrays use Windows line ending syntax. This is also performed in {@see Translation_Entry::key()}.
					$source_string = str_replace( array( "\r\n", "\r" ), "\n", $string['string'] );
					$mo_tr = str_replace( array( "\r\n", "\r" ), "\n", $mo_tr );
					$this->export->add_translation_entry( 'string_translation', $source_string, $mo_tr, $args );
				}
			}
		}

		if ( $this->downloader->create( $this->export ) ) {
			$this->downloader->send_response();
		} else {
			add_settings_error(
				'export-strings-translations',
				'settings_updated',
				esc_html__( 'Error: Impossible to create a zip file.', 'polylang-pro' )
			);
		}
	}
}
