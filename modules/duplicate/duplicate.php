<?php
/**
 * @package Polylang-Pro
 */

/**
 * Copy the title, content and excerpt from the source when creating a new post translation
 * in the classic editor.
 *
 * @since 1.9
 */
class PLL_Duplicate extends PLL_Metabox_Button {
	use PLL_Duplicate_Trait;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$args = array(
			'position'   => 'before_post_translations',
			'activate'   => __( 'Activate content duplication', 'polylang-pro' ),
			'deactivate' => __( 'Deactivate content duplication', 'polylang-pro' ),
			'class'      => 'dashicons-before dashicons-admin-page',
		);

		parent::__construct( 'pll-duplicate', $args );

		$this->options      = &$polylang->options;
		$this->sync_content = &$polylang->sync_content;

		add_filter( 'use_block_editor_for_post', array( $this, 'new_post_translation' ), 2000 ); // After class instanciation and before terms and post metas are copied in Polylang.
	}
}
