<?php
/**
 * @package Polylang-Pro
 */

/**
 * Loads the correct class depending on the context.
 *
 * @since 2.8
 */
class PLL_Admin_Loader {
	/**
	 * Reference to the Polylang object.
	 *
	 * @var object
	 */
	protected $polylang;

	/**
	 * Name of the property to create.
	 *
	 * @var string
	 */
	protected $property;

	/**
	 * Constructor
	 *
	 * @since 2.8
	 *
	 * @param object $polylang Polylang object.
	 * @param string $property Name of the property to add to $polylang.
	 */
	public function __construct( &$polylang, $property ) {
		$this->polylang = &$polylang;
		$this->property = $property;

		add_action( 'admin_init', array( $this, 'load' ), 20 ); // After fusion Builder.
	}

	/**
	 * Finds out if the block editor is in use and loads the correct class accordingly.
	 *
	 * @since 2.8
	 *
	 * @return void
	 */
	public function load() {
		if ( 'post-new.php' === $GLOBALS['pagenow'] ) {
			// We need to wait until we know which editor is in use
			add_filter( 'use_block_editor_for_post', array( $this, '_load' ), 999 ); // After the plugin Classic Editor
		} elseif ( 'post.php' === $GLOBALS['pagenow'] && isset( $_GET['action'], $_GET['post'] ) && 'edit' === $_GET['action'] && empty( $_GET['meta-box-loader'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$this->_load( use_block_editor_for_post( (int) $_GET['post'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		} else {
			$this->_load( false );
		}
	}

	/**
	 * Loads the correct class, depending on the editor in use.
	 *
	 * We must make sure to instantiate the class only once, as the function may be called from a filter,
	 *
	 * @since 2.8
	 *
	 * @param bool $is_block_editor Whether to use the block editor or not.
	 * @return bool
	 */
	public function _load( $is_block_editor ) {
		$prop = $this->property;

		if ( ! isset( $this->polylang->$prop ) ) {
			// Determines the class name based on the property name and context.
			$uc = ucwords( $prop, '_' );
			if ( pll_use_block_editor_plugin() && $is_block_editor ) {
				$classname = "PLL_{$uc}_REST";
			} else {
				$classname = "PLL_{$uc}";
			}
			$this->polylang->$prop = new $classname( $this->polylang );
		}

		return $is_block_editor;
	}
}
