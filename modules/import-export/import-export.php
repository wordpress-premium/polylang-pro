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
	 * @since 2.7
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Reference to Polylang options array
	 *
	 * @since 2.7
	 *
	 * @var array
	 */
	private $options;

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
		$this->options = &$polylang->options;

		add_action( 'load-languages_page_mlang_strings', array( $this, 'add_meta_boxes' ) );
		add_action( 'mlang_action_import-translations', array( $this, 'import_action' ) );
		add_action( 'admin_init', array( $this, 'export_strings_translations' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_style' ) );
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
				'bottom'
			);

			add_meta_box(
				'pll-import-translations-box',
				__( 'Import string translations', 'polylang-pro' ),
				array( $this, 'metabox_import_translation' ),
				'languages_page_mlang_strings',
				'bottom'
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
		include POLYLANG_PRO_DIR . '/modules/export/view-tab-export-strings.php';
	}

	/**
	 * Metabox import translations.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	public function metabox_import_translation() {
		include POLYLANG_PRO_DIR . '/modules/import/view-tab-import-translations.php';
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
		$import = new PLL_Import_Action( $this->model );
		$import->import();
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

			if ( ! isset( $_POST['target-lang'] ) ) {
				add_settings_error(
					'export',
					'no-target-language',
					esc_html__( "Error: you haven't selected any target language to be exported.", 'polylang-pro' )
				);
			}

			if ( isset( $_POST['target-lang'], $_POST['group'], $_POST['filetype'] ) ) {
				$export_strings_translation = new PLL_Export_Strings_Translations( sanitize_key( $_POST['filetype'] ), $this->model, $this->options );

				$export_strings_translation->send_strings_translation_to_export(
					array_map( 'sanitize_key', $_POST['target-lang'] ),
					sanitize_text_field( wp_unslash( $_POST['group'] ) )
				);
			}
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
}
