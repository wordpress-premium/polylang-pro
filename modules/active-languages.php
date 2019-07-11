<?php

/**
 * Manages the ability to enable or disable a language
 *
 * @since 1.9
 */
class PLL_Active_Languages {
	public $options, $model, $curlang;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->options = &$polylang->options;
		$this->model   = &$polylang->model;
		$this->curlang = &$polylang->curlang;

		// Admin.
		if ( $polylang instanceof PLL_Settings && ( empty( $_GET['page'] ) || 'mlang' == $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			add_filter( 'pll_languages_row_classes', array( $this, 'row_classes' ), 10, 2 );
			add_filter( 'pll_default_lang_row_action', array( $this, 'remove_default_lang_action' ), 10, 2 );
			add_filter( 'pll_languages_row_actions', array( $this, 'row_actions' ), 10, 2 );
			add_action( 'mlang_action_enable', array( $this, 'enable' ) );
			add_action( 'mlang_action_disable', array( $this, 'disable' ) );
			add_action( 'admin_print_styles', array( $this, 'print_css' ) );
		}

		// Frontend.
		if ( $polylang instanceof PLL_Frontend ) {
			add_action( 'wp', array( $this, 'init' ) );
			add_action( 'rest_api_init', array( $this, 'init' ) );
			add_filter( 'pll_languages_for_browser_preferences', array( $this, 'remove_inactive_languages' ) );
		}
	}

	/**
	 * Adds class inactive / active class
	 *
	 * @since 1.9
	 *
	 * @param array  $classes  CSS classes applied to a row in the languages list table.
	 * @param object $language The language.
	 * @return array Modified list of classes.
	 */
	public function row_classes( $classes, $language ) {
		return isset( $language->active ) && false === $language->active ? array( 'inactive' ) : array();
	}

	/**
	 * Remove the default lang action for disabled languages
	 *
	 * @since 1.9
	 *
	 * @param string $action   HTML markup of the action to define the default language.
	 * @param object $language The Language.
	 * @return array Modified row action.
	 */
	public function remove_default_lang_action( $action, $language ) {
		if ( isset( $language->active ) && false === $language->active ) {
			return '';
		}

		return $action;
	}

	/**
	 * Adds disable/enable links to row actions in the languages list table
	 *
	 * @since 1.9
	 *
	 * @param array  $actions  The list of the HTML markup of row actions.
	 * @param object $language The language.
	 * @return array Modified list of row actions.
	 */
	public function row_actions( $actions, $language ) {
		if ( $language->slug == $this->options['default_lang'] ) {
			return $actions;
		}

		$active_action = isset( $language->active ) && false === $language->active ?
			array(
				'enable' => sprintf(
					'<a title="%s" href="%s">%s</a>',
					esc_attr__( 'Activate this language', 'polylang-pro' ),
					wp_nonce_url( '?page=mlang&amp;pll_action=enable&amp;noheader=true&amp;lang=' . $language->term_id, 'enable-lang' ),
					esc_html__( 'Activate', 'polylang' )
				),
			) :
			array(
				'disable' => sprintf(
					'<a title="%s" href="%s">%s</a>',
					esc_attr__( 'Deactivate this language', 'polylang-pro' ),
					wp_nonce_url( '?page=mlang&amp;pll_action=disable&amp;noheader=true&amp;lang=' . $language->term_id, 'disable-lang' ),
					esc_html__( 'Deactivate', 'polylang' )
				),
			);

		return array_merge( $active_action, $actions );
	}

	/**
	 * Enables or disables a language
	 *
	 * @since 1.9
	 *
	 * @param int  $lang_id The language term id.
	 * @param bool $enable  True to enable, false to disable.
	 */
	public function _enable( $lang_id, $enable ) {
		$lang_id     = (int) $lang_id;
		$language    = get_term( $lang_id, 'language' );
		$description = maybe_unserialize( $language->description );

		$description['active'] = $enable;

		wp_update_term( $lang_id, 'language', array( 'description' => maybe_serialize( $description ) ) );
		$this->model->clean_languages_cache();
	}

	/**
	 * Enables a language
	 *
	 * @since 1.9
	 */
	public function enable() {
		check_admin_referer( 'enable-lang' );
		if ( isset( $_GET['lang'] ) ) {
			$this->_enable( (int) $_GET['lang'], true );
		}
		PLL_Settings::redirect();
	}

	/**
	 * Disables a language
	 *
	 * @since 1.9
	 */
	public function disable() {
		check_admin_referer( 'disable-lang' );
		if ( isset( $_GET['lang'] ) ) {
			$this->_enable( (int) $_GET['lang'], false );
		}
		PLL_Settings::redirect();
	}

	/**
	 * Sets error 404 if the requested language is not active
	 *
	 * @since 1.9
	 */
	public function maybe_set_404() {
		if ( isset( $this->curlang->active ) && false === $this->curlang->active ) {
			$GLOBALS['wp_query']->set_404();
		}
	}

	/**
	 * Styles the border
	 *
	 * @since 1.9
	 */
	public function print_css() {
		?>
		<style type="text/css">
			#the-list .name {
				padding-left: 14px;
			}

			#the-list .inactive .name {
				padding-left: 10px;
				border-left: 4px solid #d54e21;
			}

			#the-list .inactive {
				background-color: #fef7f1;
			}
		</style>
		<?php
	}

	/**
	 * Removes inactive languages from the list of languages for users who can't edit posts
	 *
	 * @since 1.9
	 */
	public function init() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			$languages = $this->remove_inactive_languages( $this->model->get_languages_list() );
			$this->model->cache->set( 'languages', $languages ); // FIXME access to $this->model->cache which I would prefer to keep protected.
			$this->maybe_set_404();
		}
	}

	/**
	 * Removes inactive languages from the list of languages
	 *
	 * @since 1.9.3
	 *
	 * @param array $languages Array of PLL_Language objects.
	 * @return array
	 */
	public function remove_inactive_languages( $languages ) {
		foreach ( $languages as $k => $lang ) {
			if ( isset( $lang->active ) && false === $lang->active ) {
				unset( $languages[ $k ] );
			}
		}
		return $languages;
	}
}
