<?php
/**
 * @package Polylang-Pro
 */

/**
 * Copy the title, content and excerpt from the source when creating a new post translation
 * in the classic editor.
 * Exposes pll_duplicate_content user meta in the REST API
 *
 * @since 2.6
 */
class PLL_Duplicate_REST {
	use PLL_Duplicate_Trait;

	/**
	 * Constructor
	 *
	 * @since 2.6
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->options      = &$polylang->options;
		$this->sync_content = &$polylang->sync_content;

		add_filter( 'block_editor_preload_paths', array( $this, 'block_editor_preload_paths' ) );

		register_rest_field(
			'user',
			'pll_duplicate_content',
			array(
				'get_callback'    => array( $this, 'get_duplicate_content_meta' ),
				'update_callback' => array( $this, 'udpate_duplicate_content_meta' ),
			)
		);
	}

	/**
	 * Get the duplicate content user meta value.
	 *
	 * @since 2.6
	 *
	 * @return bool[]
	 */
	public function get_duplicate_content_meta() {
		return get_user_meta( get_current_user_id(), 'pll_duplicate_content', true );
	}

	/**
	 * Update the duplicate content user meta.
	 *
	 * @since 2.6
	 *
	 * @param bool[]  $options An array with post type as key and boolean as value.
	 * @param WP_User $user    An instance of WP_User.
	 * @return bool
	 */
	public function udpate_duplicate_content_meta( $options, $user ) {
		return update_user_meta( $user->ID, 'pll_duplicate_content', $options );
	}

	/**
	 * Fires the content copy by hooking to the filter 'block_editor_preload_paths'.
	 *
	 * @since 2.9
	 *
	 * @param string[] $preload_paths Array of paths to preload, not used.
	 * @return string[]
	 */
	public function block_editor_preload_paths( $preload_paths ) {
		$this->new_post_translation();
		return $preload_paths;
	}
}
