<?php
/**
 * @package polylang-pro
 */

/**
 * Allows to load a fallback translation file if a translation doesn't exist in the current locale.
 *
 * @since 2.9
 */
class PLL_Locale_Fallback {
	/**
	 * @var PLL_Model
	 */
	public $model;

	/**
	 * Setups actions and filters
	 *
	 * @since 2.9
	 *
	 * @param object $polylang Polylang object.
	 * @return void
	 */
	public function init( &$polylang ) {
		$this->model = &$polylang->model;

		add_filter( 'load_textdomain_mofile', array( $this, 'load_file' ) );
		add_filter( 'load_script_translation_file', array( $this, 'load_file' ) );

		add_action( 'pll_language_add_form_fields', array( $this, 'add_language_form_fields' ) );
		add_action( 'pll_language_edit_form_fields', array( $this, 'edit_language_form_fields' ) );
		add_action( 'pll_add_language', array( $this, 'save_language' ) );
		add_action( 'pll_update_language', array( $this, 'save_language' ) );

		// Updates plugins and themes translations files.
		add_filter( 'themes_update_check_locales', array( $this, 'update_check_locales' ) );
		add_filter( 'plugins_update_check_locales', array( $this, 'update_check_locales' ) );
	}

	/**
	 * Adds the fallback locale to each language object.
	 *
	 * @since 2.9
	 *
	 * @param PLL_Language[] $languages The list of language objects.
	 * @return PLL_Language[]
	 */
	public static function pll_languages_list( $languages ) {
		foreach ( $languages as $language ) {
			$fallbacks = get_term_meta( $language->term_id, 'fallback', true );
			$language->fallbacks = empty( $fallbacks ) ? array() : $fallbacks;
		}
		return $languages;
	}

	/**
	 * Attempts to load the translation in the fallback locale if it doesn't exist in the current locale.
	 *
	 * @since 2.9
	 *
	 * @param string $file Translation file name.
	 * @return string
	 */
	public function load_file( $file ) {
		if ( ! is_readable( $file ) ) {
			$locale = is_admin() ? get_user_locale() : get_locale();
			$language = $this->model->get_language( $locale );

			if ( ! empty( $language ) && ! empty( $language->fallbacks ) ) {
				foreach ( $language->fallbacks as $fallback ) {
					$_file = str_replace( $locale, $fallback, $file );
					if ( is_readable( $_file ) ) {
						$file = $_file;
						continue;
					}
				}
			}
		}
		return $file;
	}

	/**
	 * Outputs the locale fallbacks when editing a language.
	 *
	 * @since 2.9
	 *
	 * @param PLL_Language $edit_lang Language being edited.
	 * @return void
	 */
	public function edit_language_form_fields( $edit_lang ) {
		// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$fallbacks_list = empty( $edit_lang->fallbacks ) ? '' : implode( ',', $edit_lang->fallbacks );
		include __DIR__ . '/view-locale-fallback.php';
	}

	/**
	 * Outputs an empty locale fallbacks field when adding a language.
	 *
	 * @since 2.9
	 *
	 * @return void
	 */
	public function add_language_form_fields() {
		// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$fallbacks_list = '';
		include __DIR__ . '/view-locale-fallback.php';
	}

	/**
	 * Saves the language fallback.
	 *
	 * @since 2.9
	 *
	 * @param array $args Arguments used to create or edit the language.
	 * @return void
	 */
	public function save_language( $args ) {
		$language = $this->model->get_language( $args['slug'] );

		if ( $language ) {
			if ( ! empty( $args['fallback'] ) ) {
				$fallbacks = array_map( 'trim', explode( ',', $args['fallback'] ) );

				foreach ( $fallbacks as $k => $fallback ) {
					// Keep only valid locales.
					// @TODO Display an error message.
					if ( ! preg_match( '#^[a-z]{2,3}(?:_[A-Z]{2})?(?:_[a-z0-9]+)?$#', $fallback ) ) {
						unset( $fallbacks[ $k ] );
					}

					if ( current_user_can( 'install_languages' ) ) {
						require_once ABSPATH . 'wp-admin/includes/translation-install.php';
						wp_download_language_pack( $fallback );
					}
				}

				update_term_meta( $language->term_id, 'fallback', $fallbacks );
			} else {
				delete_term_meta( $language->term_id, 'fallback' );
			}

			$this->model->clean_languages_cache();
		}
	}

	/**
	 * Allows to update translations files for plugins and themes.
	 *
	 * @since 2.9
	 *
	 * @param string[] $locales List of locales to update.
	 * @return string[]
	 */
	public function update_check_locales( $locales ) {
		foreach ( $this->model->get_languages_list() as $language ) {
			if ( ! empty( $language->fallbacks ) ) {
				$locales = array_merge( $locales, $language->fallbacks );
			}
		}
		return array_unique( $locales );
	}
}

