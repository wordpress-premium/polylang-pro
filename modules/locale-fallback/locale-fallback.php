<?php
/**
 * @package Polylang-Pro
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

		add_filter( 'pll_language_metas', array( $this, 'add_locale_fallback_to_language_metas' ), 10, 2 );

		// Updates plugins and themes translations files.
		add_filter( 'themes_update_check_locales', array( $this, 'update_check_locales' ) );
		add_filter( 'plugins_update_check_locales', array( $this, 'update_check_locales' ) );
	}

	/**
	 * Adds the locale fallbacks to the language data.
	 *
	 * @since 3.4
	 *
	 * @param mixed[] $add_data Data to add.
	 * @param mixed[] $args     {
	 *     Arguments used to create the language.
	 *
	 *     @type string $name       Language name (used only for display).
	 *     @type string $slug       Language code (ideally 2-letters ISO 639-1 language code).
	 *     @type string $locale     WordPress locale. If something wrong is used for the locale, the .mo files will
	 *                              not be loaded...
	 *     @type int    $rtl        1 if rtl language, 0 otherwise.
	 *     @type int    $term_group Language order when displayed.
	 *     @type int    $lang_id    Optional, ID of the language to modify. An empty value means the language is
	 *                              being created.
	 *     @type string $flag       Optional, country code, {@see settings/flags.php}.
	 * }
	 * @return mixed[]
	 */
	public function add_locale_fallback_to_language_metas( $add_data, $args ) {
		if ( empty( $args['fallback'] ) || ! is_string( $args['fallback'] ) ) {
			// Empty new fallbacks.
			$new_fallbacks = array();
		} else {
			$new_fallbacks = array_unique( array_map( 'trim', explode( ',', $args['fallback'] ) ) );
		}

		$add_data['fallbacks'] = array();

		foreach ( $new_fallbacks as $fallback ) {
			// Keep only valid locales.
			// @TODO Display an error message.
			if ( ! preg_match( '#^[a-z]{2,3}(?:_[A-Z]{2})?(?:_[a-z0-9]+)?$#', $fallback ) ) {
				continue;
			}

			/** @var non-empty-string $fallback */
			$add_data['fallbacks'][] = $fallback;

			if ( current_user_can( 'install_languages' ) ) {
				require_once ABSPATH . 'wp-admin/includes/translation-install.php';
				wp_download_language_pack( $fallback );
			}
		}

		return $add_data;
	}

	/**
	 * Attempts to load the translation in the fallback locale if it doesn't exist in the current locale.
	 *
	 * @since 2.9
	 *
	 * @param  string|false $file Translation file name.
	 * @return string|false
	 */
	public function load_file( $file ) {
		if ( empty( $file ) || ! is_string( $file ) ) {
			return $file;
		}

		$locale = is_admin() ? get_user_locale() : get_locale();

		if ( empty( $locale ) ) {
			return $file;
		}

		$language = $this->model->get_language( $locale );

		if ( empty( $language ) || empty( $language->fallbacks ) ) {
			return $file;
		}

		if ( is_readable( $file ) ) {
			return $file;
		}

		$parts = pathinfo( $file );

		if ( empty( $parts['extension'] ) || ( 'mo' !== $parts['extension'] && 'json' !== $parts['extension'] ) ) {
			return $file;
		}

		$locale = preg_quote( $locale, '@' );

		foreach ( $language->fallbacks as $fallback ) {
			if ( empty( $fallback ) || ! is_string( $fallback ) ) {
				continue;
			}

			if ( 'mo' === $parts['extension'] ) {
				// Matches "fr_FR.mo" and "foobar-fr_FR.mo".
				$pattern = "@^(.+-)?{$locale}(\.mo)$@";
			} else {
				// Matches "fr_FR-md5hash.json" and "foobar-fr_FR-md5hash.json".
				$pattern = "@^(.+-)?{$locale}(-[0-9a-f]{32}\.json)$@";
			}

			$_file = $parts['dirname'] . '/' . preg_replace( $pattern, "\$1{$fallback}\$2", $parts['basename'] );

			if ( is_readable( $_file ) ) {
				return $_file;
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

