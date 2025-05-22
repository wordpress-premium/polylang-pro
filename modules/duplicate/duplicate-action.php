<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class to manage duplication action.
 *
 * @since 3.6
 */
class PLL_Duplicate_Action {
	/**
	 * Duplicate user meta name.
	 *
	 * @var string
	 * @phpstan-var non-falsy-string
	 */
	const META_NAME = 'pll_duplicate_content';

	/**
	 * Reference to the plugin options.
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Reference to the PLL_Sync_Content instance.
	 *
	 * @var PLL_Sync_Content
	 */
	protected $sync_content;

	/**
	 * @var PLL_Admin_Links|null
	 */
	protected $links;

	/**
	 * Used to manage user meta.
	 *
	 * @var PLL_Toggle_User_Meta
	 */
	protected $user_meta;

	/**
	 * Constructor
	 *
	 * @since 3.6
	 *
	 * @param PLL_Admin $polylang Polylang object.
	 */
	public function __construct( PLL_Admin &$polylang ) {
		$this->options      = &$polylang->options;
		$this->sync_content = &$polylang->sync_content;
		$this->links        = &$polylang->links;
		$this->user_meta    = new PLL_Toggle_User_Meta( static::META_NAME );

		/*
		 * After class instantiation and before terms and post metas are copied in Polylang.
		 */
		add_filter( 'use_block_editor_for_post', array( $this, 'new_post_translation' ), 2000 );
	}

	/**
	 * Fires the content copy
	 *
	 * @since 2.5
	 * @since 3.1 Add $is_block_editor param as the method is now hooked to the filter use_block_editor_for_post.
	 *
	 * @param bool $is_block_editor Whether the post can be edited or not.
	 * @return bool
	 */
	public function new_post_translation( $is_block_editor ) {
		global $post;
		static $done = array();

		if ( empty( $post ) || in_array( $post->ID, $done, true ) || empty( $this->links ) ) {
			return $is_block_editor;
		}

		// Capability check already done in post-new.php.
		$data = $this->links->get_data_from_new_post_translation_request( $post->post_type );

		if ( empty( $data['from_post'] ) || empty( $data['new_lang'] ) || ! $this->user_meta->is_active() ) {
			return $is_block_editor;
		}

		if ( ! current_user_can( 'read_post', $data['from_post'] ) ) {
			wp_die(
				esc_html__( 'Sorry, you are not allowed to read this item.', 'polylang-pro' ),
				403
			);
		}

		$done[] = $post->ID; // Avoid a second duplication in the block editor.

		$this->sync_content->copy_content( $data['from_post'], $post, $data['new_lang'] );

		// Maybe duplicates the featured image.
		if ( $this->options['media_support'] ) {
			add_filter( 'pll_translate_post_meta', array( $this->sync_content, 'duplicate_thumbnail' ), 10, 3 );
		}

		// Maybe duplicate terms.
		add_filter( 'pll_maybe_translate_term', array( $this->sync_content, 'duplicate_term' ), 10, 3 );

		return $is_block_editor;
	}
}
