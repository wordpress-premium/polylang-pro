<?php
/**
 * @package Polylang-Pro
 */

/**
 * Initialize the Xliff Exporter Module
 *
 * @since 2.7
 */
class PLL_Import_Export {

	const TYPE_POST = 'post';
	const TYPE_TERM = 'term';

	const TERM_NAME = 'name';
	const TERM_DESCRIPTION = 'description';
	const TERM_META = 'termmeta';

	const POST_TITLE = 'post_title';
	const POST_CONTENT = 'post_content';
	const POST_EXCERPT = 'post_excerpt';
	const POST_META = 'postmeta';

	const STRINGS_TRANSLATIONS = 'strings-translations';

	/**
	 * Name of the app that generates the export files.
	 *
	 * @var string
	 */
	const APP_NAME = 'Polylang';

	/**
	 * @since 2.7
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Reference to the instance of PLL_Bulk_Translate
	 *
	 * @var PLL_Bulk_Translate
	 */
	private $bulk_translate;

	/**
	 * The class that handles user's import actions.
	 *
	 * @var PLL_Import_Action
	 */
	private $import_action;

	/**
	 * Constructor
	 * Registers the hooks
	 *
	 * @since 2.7
	 *
	 * @param PLL_Base $polylang Current instance of the Polylang context.
	 */
	public function __construct( &$polylang ) {
		$this->model = &$polylang->model;
		$this->bulk_translate = &$polylang->bulk_translate;
		$this->import_action = new PLL_Import_Action(
			$this->model,
			array(
				self::TYPE_POST            => new PLL_Import_Posts( new PLL_Translation_Post_Model( $polylang ) ),
				self::TYPE_TERM            => new PLL_Import_Terms( new PLL_Translation_Term_Model( $polylang ) ),
				self::STRINGS_TRANSLATIONS => new PLL_Import_Strings(),
			)
		);

		if ( $polylang instanceof PLL_Admin && class_exists( 'PLL_Export_Bulk_Option' ) ) {
			add_action( 'admin_init', array( $this, 'add_bulk_export' ) );
		}
		if ( $polylang instanceof PLL_Settings ) {
			add_action( 'load-languages_page_mlang_strings', array( $this, 'add_meta_boxes' ) );
			add_action( 'mlang_action_import-translations', array( $this, 'import_action' ) );
			add_action( 'admin_init', array( $this, 'export_strings_translations' ), 99 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_style' ) );
		}
	}

	/**
	 * Adds 'export' bulk option in Translate bulk action {@see PLL_Bulk_Translate::register_options()}
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function add_bulk_export() {

		$this->bulk_translate->register_options(
			array(
				new PLL_Export_Bulk_Option(
					$this->model
				),
			)
		);
	}

	/**
	 * Add Metaboxes, shown only if there is more than one language registered.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		if ( 1 < count( $this->model->get_languages_list() ) ) {
			add_meta_box(
				'pll-export-strings-box',
				__( 'Export string translations', 'polylang-pro' ),
				array( $this, 'metabox_export_strings' ),
				'languages_page_mlang_strings',
				'normal'
			);

			add_meta_box(
				'pll-import-translations-box',
				__( 'Import translations', 'polylang-pro' ),
				array( $this, 'metabox_import_translation' ),
				'languages_page_mlang_strings',
				'normal'
			);
		}
	}

	/**
	 * Metabox export strings.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function metabox_export_strings() {
		include POLYLANG_PRO_DIR . '/modules/import-export/export/view-tab-export-strings.php';
	}

	/**
	 * Metabox import translations.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function metabox_import_translation() {
		include POLYLANG_PRO_DIR . '/modules/import-export/import/view-tab-import-translations.php';
	}

	/**
	 * Launch the import action.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function import_action() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to manage options for this site.', 'polylang-pro' ) );
		}

		check_admin_referer( PLL_Import_Action::ACTION_NAME, PLL_Import_Action::NONCE_NAME );
		$this->trigger_import();
	}

	/**
	 * Handles the triggering of the import class.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	protected function trigger_import() {
		$this->import_action->import();
	}

	/**
	 * Launch the strings translation export.
	 *
	 * @since 2.7
	 * @since 3.1 Renamed from 'export_string_translation'
	 *
	 * @return void
	 */
	public function export_strings_translations() {
		if ( isset( $_POST['export'] ) && 'string-translation' === $_POST['export'] ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'Sorry, you are not allowed to manage options for this site.', 'polylang-pro' ) );
			}

			check_admin_referer( PLL_Export_Strings_Translations::ACTION_NAME, PLL_Export_Strings_Translations::NONCE_NAME );

			if ( ! isset( $_POST['group'], $_POST['filetype'] ) ) {
				return;
			}

			$target_languages = $this->get_sanitized_target_languages( $_POST );
			if ( ! $target_languages ) {
				add_settings_error(
					'export',
					'no-target-language',
					esc_html__( "Error: you haven't selected any target language to be exported.", 'polylang-pro' )
				);
				return;
			}


			$export_strings_translation = new PLL_Export_Strings_Translations( sanitize_key( $_POST['filetype'] ), $this->model );
			$export_strings_translation->send_strings_translation_to_export(
				$target_languages,
				sanitize_text_field( wp_unslash( $_POST['group'] ) )
			);
		}
	}

	/**
	 * Enqueue stylesheet for import/export on admin side.
	 *
	 * @since 3.1
	 *
	 * @return void
	 */
	public function admin_enqueue_style() {
		$screen = get_current_screen();
		if ( $screen && 'languages_page_mlang_strings' === $screen->base ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_style( 'pll-admin-export-import', plugins_url( '/css/build/admin-export-import' . $suffix . '.css', POLYLANG_ROOT_FILE ), array(), POLYLANG_VERSION );
		}
	}

	/**
	 * Sanitizes and validates the target languages.
	 *
	 * @since 3.3
	 *
	 * @param array $export_form An array of $_POST values, including the target languages slug.
	 * @return PLL_Language[]|false An array of PLL_Language, or false if there is no valid target languages.
	 */
	private function get_sanitized_target_languages( $export_form ) {
		if ( ! isset( $export_form['target-lang'] ) ) {
			return false;
		}

		// Sanitize and validate languages.
		$target_languages = array_map( 'sanitize_key', $export_form['target-lang'] );
		$target_languages = array_map( array( $this->model, 'get_language' ), $target_languages );
		$target_languages = array_filter( $target_languages );

		if ( empty( $target_languages ) ) {
			return false;
		}

		return $target_languages;
	}
}
