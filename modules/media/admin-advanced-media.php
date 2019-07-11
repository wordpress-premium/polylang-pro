<?php

/**
 * Advanced media functionalities
 *
 * @since 1.9
 */
class PLL_Admin_Advanced_Media {
	/**
	 * Constructor: setups filters and actions
	 *
	 * @since 1.9
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->options = &$polylang->options;
		$this->model   = &$polylang->model;
		$this->posts   = &$polylang->posts;

		if ( ! empty( $this->options['media']['duplicate'] ) ) {
			add_action( 'add_attachment', array( $this, 'duplicate_media' ), 20 ); // After Polylang.
		}
	}

	/**
	 * Creates media translations each time a new media is uploaded
	 *
	 * @since 1.9
	 *
	 * @param int $post_id The id of the attachment to duplicate.
	 */
	public function duplicate_media( $post_id ) {
		static $avoid_recursion = false;

		// Avoid recursion and bails if adding a translation from PLL_Admin_Filters_Media::translate_media().
		if ( $avoid_recursion || doing_action( 'admin_init' ) ) {
			return;
		}

		/**
		 * Filters whether to enable the media duplication
		 *
		 * @since 2.1.1
		 *
		 * @param bool $enable  Whether to enable the media duplication. Defaults to true.
		 * @param int  $post_id Media id.
		 */
		if ( ! apply_filters( 'pll_enable_duplicate_media', true, $post_id ) ) {
			return;
		}

		require_once ABSPATH . 'wp-admin/includes/media.php'; // Needed when uploading audio or video files from the block editor.
		$avoid_recursion = true;

		$src_language = $this->model->post->get_language( $post_id );

		if ( ! empty( $src_language ) ) {
			// Don't attempt to create already existing translations (useful in case the function is reused).
			$languages = array_diff( $this->model->get_languages_list( array( 'fields' => 'slug' ) ), array_keys( $this->model->post->get_translations( $post_id ) ) );

			foreach ( $languages as $lang ) {
				$tr_id = $this->posts->create_media_translation( $post_id, $lang );

				if ( ! empty( $tr_id ) ) {
					$post = get_post( $tr_id );
					wp_maybe_generate_attachment_metadata( $post );
				}
			}
		}

		$avoid_recursion = false;
	}
}
