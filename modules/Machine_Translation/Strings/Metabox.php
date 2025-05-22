<?php
/**
 * @package Polylang Pro
 */

namespace WP_Syntex\Polylang_Pro\Modules\Machine_Translation\Strings;

use PLL_Model;
use PLL_Settings;
use WP_Syntex\Polylang_Pro\Modules\Machine_Translation\Strings\Action;
use WP_Syntex\Polylang_Pro\Modules\Machine_Translation\Services\Service_Interface;

/**
 * Class to manage machine translation metabox for strings translations.
 *
 * @since 3.7
 */
class Metabox {
	/**
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * @var Action
	 */
	private $action;

	/**
	 * Constructor
	 *
	 * @since 3.7
	 *
	 * @param PLL_Settings      $polylang Instance of Polylang main object for settings page.
	 * @param Service_Interface $service  Instance of the machine translation service.
	 */
	public function __construct( PLL_Settings $polylang, Service_Interface $service ) {
		$this->model  = $polylang->model;
		$this->action = new Action( $polylang, $service );
	}

	/**
	 * Initializes the machine translations metabox.
	 *
	 * @since 3.7
	 *
	 * @return self Instance of the current class.
	 */
	public function init(): self {
		add_action( 'load-languages_page_mlang_strings', array( $this, 'add' ) );

		/*
		 * See the hook `mlang_action_{$action}` in `PLL_Settings::handle_actions()`.
		 */
		add_action(
			'mlang_action_machine-translations',
			array( $this->action, 'validate_form' )
		);

		return $this;
	}

	/**
	 * Adds the machine translation metabox.
	 *
	 * @since 3.7
	 *
	 * @return void
	 */
	public function add() {
		add_meta_box(
			'pll-machine-strings-translations',
			__( 'Machine translations', 'polylang-pro' ),
			array( $this, 'render' ),
			'languages_page_mlang_strings',
			'normal'
		);
	}

	/**
	 * Renders the machine translation metabox.
	 *
	 * @since 3.7
	 *
	 * @return void
	 */
	public function render() {
		$model = $this->model;
		include POLYLANG_PRO_DIR . '/modules/Machine_Translation/Views/string-form.php';
	}
}
