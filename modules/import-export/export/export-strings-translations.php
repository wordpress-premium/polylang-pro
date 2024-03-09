<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles the admin action of exporting strings translations.
 *
 * @since 2.7
 * @since 3.1 Renamed from 'PLL_Export_Strings_Translation'
 */
class PLL_Export_Strings_Translations {

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
	 * @var PLL_Export_Multi_Files
	 */
	private $export;

	/**
	 * Used to query languages and translations.
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * @var PLL_File_Format_Factory
	 */
	private $file_format_factory;

	/**
	 * PLL_Export_Strings_Translation constructor.
	 *
	 * @since 2.7
	 *
	 * @param string    $file_extension The file's extension, {@see PLL_File_Format_Factory::from_extension()}.
	 * @param PLL_Model $model          Polylang model.
	 * @return void
	 */
	public function __construct( $file_extension, $model ) {
		$this->model = $model;
		$this->file_format_factory = new PLL_File_Format_Factory();

		$file_format = $this->file_format_factory->from_extension( $file_extension );

		if ( ! $file_format instanceof PLL_File_Format ) {
			return;
		}

		$export_format = $file_format->get_export();

		$this->export = new PLL_Export_Multi_Files( $export_format );

		$this->downloader = new PLL_Export_Download_Zip();
	}

	/**
	 * Prepare and export the selected strings translations.
	 *
	 * @since 2.7
	 *
	 * @param PLL_Language[] $target_languages Array of PLL_Language.
	 * @param string         $group            String translation context to export.
	 * @return void
	 */
	public function send_strings_translation_to_export( $target_languages, $group ) {
		$source_language = $this->model->get_default_language();
		if ( ! $source_language ) {
			return;
		}

		foreach ( $target_languages as $target_language ) {
			$this->export->set_source_language( $source_language->get_locale( 'display' ) );
			$this->export->set_target_language( $target_language->get_locale( 'display' ) );
			$this->export->set_source_reference( PLL_Import_Export::STRINGS_TRANSLATIONS );

			$mo = new PLL_MO();
			$mo->import_from_db( $target_language );

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
