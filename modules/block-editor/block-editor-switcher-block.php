<?php
/**
 * @package Polylang-Pro
 */

/**
 * Language switcher block
 *
 * @since 2.8
 */
class PLL_Block_Editor_Switcher_Block {
	/**
	 * @var PLL_Links
	 */
	protected $links;

	/**
	 * @var PLL_Model
	 */
	protected $model;

	/**
	 * Current lang to render the language switcher block in an admin context
	 *
	 * @since 2.8
	 *
	 * @var string
	 */
	public $admin_current_lang;

	/**
	 * Is the context block editor?
	 *
	 * @since 2.8
	 *
	 * @var bool
	 */
	public $is_block_editor = false;

	/**
	 * Constructor
	 *
	 * @since 2.8
	 *
	 * @param PLL_Frontend|PLL_Admin|PLL_Settings|PLL_REST_Request $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->model = &$polylang->model;
		$this->links = &$polylang->links;

		// Use rest_pre_dispatch_filter to get additionnal parameters for language switcher block.
		add_filter( 'rest_pre_dispatch', array( $this, 'get_rest_query_params' ), 10, 3 );
		// Register language switcher block.
		add_action( 'init', array( $this, 'register_block_polylang_language_switcher' ) );

		add_filter( 'widget_types_to_hide_from_legacy_widget_block', array( $this, 'hide_legacy_widget' ) );
	}

	/**
	 * Renders the `polylang/language-switcher` block on server.
	 *
	 * @since 2.8
	 *
	 * @param array $attributes The block attributes.
	 * @return string Returns the language switcher.
	 */
	public function render_block_polylang_language_switcher( $attributes = array() ) {
		$attributes['echo'] = 0;
		if ( $this->is_block_editor ) {
			$attributes['admin_render'] = 1;
			$attributes['admin_current_lang'] = $this->admin_current_lang;
			$attributes['hide_if_empty'] = 0;
			$attributes['hide_if_no_translation'] = 0; // Force not to hide the language for the block preview even if the option is checked.
		}

		$switcher = new PLL_Switcher();
		$switcher_output = $switcher->the_languages( $this->links, $attributes );

		$wrap_tag = '<ul class="pll-switcher">%s</ul>';
		if ( $attributes['dropdown'] ) {
			$wrap_tag = '<div class="pll-switcher">%s</div>';
		}

		if ( empty( $switcher_output ) ) {
			$render_language_switcher = '';
		} else {
			$render_language_switcher = sprintf( $wrap_tag, $switcher_output );
		}
		return $render_language_switcher;
	}

	/**
	 * Renders the `polylang/language-switcher-inner-block` on server.
	 *
	 * Adds CSS classes specific to the `core/navigation` children on top of the Language Switcher HTML.
	 *
	 * @since 3.1
	 *
	 * @param array $attributes Block attributes, also contains CSS classes.
	 * @return string
	 */
	public function render_block_polylang_inner_language_switcher( $attributes = array() ) {
		$attributes['echo'] = 0;
		if ( $this->is_block_editor ) {
			$attributes['admin_render'] = 1;
			$attributes['admin_current_lang'] = $this->admin_current_lang;
			$attributes['hide_if_empty'] = 0;
			$attributes['hide_if_no_translation'] = 0; // Force not to hide the language for the block preview even if the option is checked.
		}

		$attributes['classes'] = array( 'wp-block-navigation-link' );
		$attributes['link_classes'] = array( 'wp-block-navigation-link__content' );

		$switcher = new PLL_Switcher();
		// We want a list to display on the frontend.
		$switcher_output = $switcher->the_languages( $this->links, array_merge( $attributes, array( 'dropdown' => false ) ) );

		$wrap_tag = '%s';
		if ( $attributes['dropdown'] && ! $this->is_block_editor ) {
			// Wrap output in HTML similar to what Gutenberg generates from our legacy Language Switcher when theme supports the 'block-nav-menus' option {@see https://github.com/WordPress/gutenberg/blob/f2a2a6885dbeeecda5e7ae00437ff3d72e53c2f3/lib/navigation.php#L180 gutenberg_convert_menu_items_to_blocks()}.

			$args = array_merge_recursive(
				$attributes,
				array(
					'classes' => array( 'has-child' ),
					'raw' => true,
				)
			);

			$current_lang = array_filter(
				$switcher->the_languages( $this->links, $args ),
				function( $element ) {
					return true === $element['current_lang'];
				}
			);
			$current_lang = array_pop( $current_lang );
			// $args['raw'] will try to display our flag url {@see PLL_Switcher::get_elements()}.
			$current_lang['flag'] = $args['show_flags'] ? $this->model->get_language( PLL()->curlang )->get_display_flag() : '';
			// Default args are processed inside {@see PLL_Switcher::the_languages()}.
			$args = wp_parse_args( $args, PLL_Switcher::DEFAULTS );

			$wrap_tag = '';
			$walker = new PLL_Walker_List();
			$walker->start_el( $wrap_tag, (object) $current_lang, 1, $args );

			$wrap_tag = str_replace( '<li', '<li id="#pll-switcher"', $wrap_tag );
			$wrap_tag = str_replace(
				'</li>',
				'<span class="wp-block-navigation-link__submenu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" role="img" aria-hidden="true" focusable="false"><path d="M1.50002 4L6.00002 8L10.5 4" stroke-width="1.5"></path></svg></span><ul class="submenu-container">%s</ul></li>',
				$wrap_tag
			);
		}

		if ( empty( $switcher_output ) ) {
			$render_language_switcher = '';
		} else {
			$render_language_switcher = sprintf( $wrap_tag, $switcher_output );
		}
		return $render_language_switcher;
	}

	/**
	 * Renders the language switcher with the given attributes.
	 *
	 * @since 3.1
	 *
	 * @param array  $attributes Array of arguments to pass to {@see PLL_Switcher::the_languages()}.
	 * @param string $wrap_tag   Optional HTML elements to wrap the switcher in. Should include the '%s' replacement character at the place the switcher elements are expected.
	 * @return string
	 */
	/**
	 * Registers the `polylang/language-switcher` block.
	 *
	 * @since 2.8
	 *
	 * @return void
	 */
	public function register_block_polylang_language_switcher() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$script_filename = 'js/build/blocks' . $suffix . '.js';
		$script_handle = 'pll_blocks';
		wp_register_script(
			$script_handle,
			plugins_url( $script_filename, POLYLANG_ROOT_FILE ),
			array(
				'wp-block-editor',
				'wp-blocks',
				'wp-components',
				'wp-element',
				'wp-i18n',
				'wp-server-side-render',
			),
			POLYLANG_VERSION,
			true
		);

		wp_localize_script( $script_handle, 'pll_block_editor_blocks_settings', PLL_Switcher::get_switcher_options( 'block', 'string' ) );

		$attributes = array(
			'align'       => array(
				'type' => 'string',
				'enum' => array(
					'left',
					'center',
					'right',
					'wide',
					'full',
				),
			),
			'className'   => array(
				'type' => 'string',
			),
		);
		foreach ( PLL_Switcher::get_switcher_options( 'block', 'default' ) as $option => $default ) {
			$attributes[ $option ] = array(
				'type'    => 'boolean',
				'default' => $default,
			);
		};

		register_block_type(
			'polylang/language-switcher',
			array(
				'editor_script' => $script_handle,
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_block_polylang_language_switcher' ),
			)
		);

		register_block_type(
			'polylang/language-switcher-inner-block',
			array(
				'editor_script' => $script_handle,
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_block_polylang_inner_language_switcher' ),
			)
		);

		// Translated strings used in JS code
		wp_set_script_translations( $script_handle, 'polylang-pro' );
	}

	/**
	 * Get REST parameters for language switcher block
	 *
	 * @see WP_REST_Server::dispatch()
	 *
	 * @since 2.8
	 *
	 * @param mixed           $result  Response to replace the requested version with. Can be anything
	 *                                 a normal endpoint can return, or null to not hijack the request.
	 * @param WP_REST_Server  $server  Server instance.
	 * @param WP_REST_Request $request Request used to generate the response.
	 * @return mixed
	 */
	public function get_rest_query_params( $result, $server, $request ) {
		if ( ! empty( $request->get_param( 'is_block_editor' ) ) ) {
			$this->is_block_editor = $request->get_param( 'is_block_editor' );
			$this->admin_current_lang = $request->get_param( 'lang' );
		}
		return $result;
	}

	/**
	 * Unoffers the language switcher from the legacy widget block.
	 *
	 * @since 3.1
	 *
	 * @param string[] $widgets An array of excluded widget-type IDs.
	 * @return string[]
	 */
	public function hide_legacy_widget( $widgets ) {
		return array_merge( $widgets, array( 'polylang' ) );
	}
}
