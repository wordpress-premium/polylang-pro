<?php
/**
 * @package Polylang-Pro
 */

/**
 * A class that handle the import action.
 *
 * @since 2.7
 *
 * Class PLL_Import_Action
 */
class PLL_Import_Action {

	/**
	 * Used to set import action name in forms.
	 *
	 * @var string
	 */
	const ACTION_NAME = 'pll_import';

	/**
	 * Used to create nonce for this action.
	 *
	 * @var string
	 */
	const NONCE_NAME = '_pll_import_nonce';

	/**
	 * Used to query languages and translations.
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Instance of PLL_Import_File_Interface.
	 *
	 * @var PLL_Import_File
	 */
	private $import_factory;

	/**
	 * PLL_Import_Action constructor.
	 *
	 * @since 2.7
	 *
	 * @param PLL_Model $model Polylang model, used to query languages and translations.
	 */
	public function __construct( $model ) {
		$this->model = $model;
		$this->import_factory = new PLL_Import_File();
	}

	/**
	 * Processes the import and redirects.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function import() {
		$error = $this->_import();

		if ( is_wp_error( $error ) ) {
			add_settings_error(
				'import-action',
				'settings_updated',
				$error->get_error_message() // Expects that the message is already escaped.
			);
		}

		PLL_Settings::redirect();
	}

	/**
	 * Processes the imported objects retrieved in an import file.
	 *
	 * @since 2.7
	 *
	 * @return WP_Error|true
	 */
	protected function _import() {
		if ( empty( $_FILES['importFileToUpload']['name'] ) ) {
			return new WP_Error( 'pll_import_no_file', esc_html__( "Error: You haven't selected a file to be uploaded.", 'polylang-pro' ) );
		}

		$import = $this->import_factory->load( $_FILES['importFileToUpload'] ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( is_wp_error( $import ) ) {
			return $import;
		}

		$error = $this->is_data_valid_for_import( $import );
		if ( is_wp_error( $error ) ) {
			return $error;
		}

		$entry = $import->get_next_entry();

		if ( PLL_Import_Export::STRINGS_TRANSLATION === $entry['type'] ) {
			$updated = $this->create_string_translations_on_import( $entry['data'], $this->model->get_language( $import->get_target_language() ) );

			if ( is_wp_error( $updated ) ) {
				return $updated;
			}

			if ( 0 === $updated ) {
				return new WP_Error( 'pll_import_no_translations', esc_html__( 'Error: No translations have been imported.', 'polylang-pro' ) );
			}

			add_settings_error(
				'import-action',
				'settings_updated',
				esc_html(
					sprintf(
						/* translators: %d is a number of strings translations */
						_n( '%d string translation updated.', '%d string translations updated.', $updated, 'polylang-pro' ),
						$updated
					)
				),
				'updated'
			);
		}

		return true;
	}

	/**
	 * Check the data's validity for the import.
	 *
	 * @since 2.7
	 *
	 * @param PLL_Import_File_Interface $import Import file.
	 * @return bool|WP_Error
	 */
	public function is_data_valid_for_import( $import ) {
		if ( $import->get_site_reference() !== get_site_url() ) {
			return new WP_Error( 'pll_import_wrong_site', esc_html__( 'Error: The site targeted in the imported file does not match the current site.', 'polylang-pro' ) );
		}

		$locale = $import->get_target_language();

		if ( false === $locale ) {
			return new WP_Error( 'pll_import_no_language', esc_html__( 'Error: No target languages have been provided in the imported file.', 'polylang-pro' ) );
		}

		if ( ! in_array( $locale, $this->model->get_languages_list( array( 'fields' => 'w3c' ) ) ) ) {
			return new WP_Error( 'pll_import_wrong_language', esc_html__( "Error: You are trying to import a file in a language which doesn't exist on your site.", 'polylang-pro' ) );
		}

		return true;
	}

	/**
	 * Handles the strings translations saving in the database.
	 *
	 * @since 2.7
	 *
	 * @param PO           $translations Contains all translations entries.
	 * @param PLL_Language $language     Target Language.
	 * @return int|WP_Error The number of updated strings.
	 */
	public function create_string_translations_on_import( $translations, $language ) {
		$pll_mo = new PLL_MO();
		$pll_mo->import_from_db( $language );
		$updated = 0;
		$errors = array();
		$strings = '';

		foreach ( $translations->entries as $entry ) {
			if ( empty( $entry->translations ) ) {
				$entry->translations[0] = '';
			}

			/** This filter is documented in /polylang/settings/table-string.php */
			$sanitized_translation = apply_filters( 'pll_sanitize_string_translation', $entry->translations[0], $entry->extracted_comments, $entry->context );
			$security_check = wp_kses_post( $sanitized_translation );
			if ( $security_check === $sanitized_translation ) {
				$pll_mo->add_entry( $pll_mo->make_entry( $entry->singular, $sanitized_translation ) );
				$updated++;
			} else {
				$errors[] = $entry->singular;
			}
		}

		if ( $updated ) {
			$pll_mo->export_to_db( $language );
		}

		if ( ! empty( $errors ) ) {
			$message = esc_html(
				_n(
					'The translation of the following string was not imported for security reasons:',
					'The translation of the following strings were not imported for security reasons:',
					count( $errors ),
					'polylang-pro'
				)
			);
			foreach ( $errors as $error ) {
				$strings .= sprintf( '<br /><span class="pll-icon pll-circle" ></span>%s', esc_html( $error ) );
			}
			$message = sprintf( '%s<br/>%s', $message, $strings );
			return new WP_Error( 'pll_import_security', $message );
		}

		return $updated;
	}
}
