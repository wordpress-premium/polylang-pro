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
			return '';
		} else {
			return sprintf( $wrap_tag, $switcher_output );
		}
	}

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
				'editor_script'   => $script_handle,
				'attributes'      => $attributes,
				'render_callback' => array( $this, 'render_block_polylang_language_switcher' ),
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
}
