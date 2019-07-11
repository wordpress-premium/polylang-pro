<?php

/**
 * A class to bulk translate posts
 * Currently only support duplicate and synchronization
 *
 * @since 2.4
 */
class PLL_Bulk_Translate {

	/**
	 * Constructor
	 *
	 * @since 2.4
	 *
	 * @param object $polylang
	 */
	public function __construct( &$polylang ) {
		$this->model     = &$polylang->model;
		$this->sync_post = &$polylang->sync_post;
		$this->posts     = &$polylang->posts;
	}

	/**
	 * Add actions and filters
	 *
	 * @since 2.4
	 */
	public function init() {
		$screen = get_current_screen();

		/**
		 * Filter the list of post types enabling the bulk translate
		 *
		 * @since 2.4
		 *
		 * @param array $post_types List of post types
		 */
		$post_types = apply_filters( 'pll_bulk_translate_post_types', $this->model->get_translated_post_types() );

		if ( in_array( $screen->base, array( 'edit', 'upload' ) ) && in_array( $screen->post_type, $post_types ) ) {
			$id = 'attachment' === $screen->post_type ? 'upload' : "edit-{$screen->post_type}";
			add_filter( "bulk_actions-{$id}", array( $this, 'add_bulk_action' ) );
			add_filter( "handle_bulk_actions-{$id}", array( $this, 'handle_bulk_action' ), 10, 3 );
			add_action( 'admin_footer', array( $this, 'display_form' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}
	}

	/**
	 * Add a bulk action
	 *
	 * @since 2.4
	 *
	 * @param array $actions List of bulk actions
	 */
	public function add_bulk_action( $actions ) {
		$actions['pll_translate'] = __( 'Translate', 'polylang-pro' );
		return $actions;
	}

	/**
	 * Handle the Translate bulk action
	 *
	 * @since 2.4
	 *
	 * @param string $sendback The redirect URL.
	 * @param string $action   The action being taken.
	 * @param array  $post_ids The items to take the action on.
	 * @return string The redirect URL.
	 */
	public function handle_bulk_action( $sendback, $action, $post_ids ) {
		if ( 'pll_translate' === $action ) {
			// Nonce check already done in edit.php or upload.php
			$posts = $this->translate( $_GET ); // phpcs:ignore WordPress.Security.NonceVerification
			$sendback = add_query_arg( array_merge( array( 'translated' => 1 ), $posts ), $sendback );
		}
		return $sendback;
	}

	/**
	 * Displays the Bulk translate form
	 *
	 * @since 2.4
	 */
	public function display_form() {
		global $post_type;
		include 'view-bulk-translate.php';
	}

	/**
	 * Handle the Translate bulk action
	 *
	 * @since 2.4
	 *
	 * @param array $data Data passed to the form
	 */
	protected function translate( $data ) {
		if ( empty( $data['post_type'] ) ) {
			$data['post_type'] = 'post';
		}

		$post_type = get_post_type_object( $data['post_type'] );

		if ( ! current_user_can( $post_type->cap->edit_posts ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to create posts.', 'polylang-pro' ) );
		}

		$done = $missed = 0;

		if ( ! empty( $data['pll-translate-lang'] ) ) {
			// Posts
			if ( ! empty( $data['post'] ) ) {
				$post_ids = array_map( 'intval', (array) $data['post'] );

				if ( ! empty( $post_ids ) ) {
					foreach ( $post_ids as $post_id ) {
						foreach ( $data['pll-translate-lang'] as $lang ) {
							if ( 'sync' !== $data['translate'] ) {
								$this->sync_post->sync_model->save_group( $post_id, array() );
							}

							if ( ! $this->model->post->get_translation( $post_id, $lang ) ) {
								$this->sync_post->sync_model->copy_post( $post_id, $lang, 'sync' === $data['translate'] );
								$done++;
							} else {
								$missed++;
							}
						}
					}
				}
			}

			// Medias
			if ( ! empty( $data['media'] ) ) {
				$post_ids = array_map( 'intval', (array) $data['media'] );

				if ( ! empty( $post_ids ) ) {
					foreach ( $post_ids as $post_id ) {
						foreach ( $data['pll-translate-lang'] as $lang ) {
							if ( ! $this->model->post->get_translation( $post_id, $lang ) ) {
								$this->posts->create_media_translation( $post_id, $lang );
								$done++;
							} else {
								$missed++;
							}
						}
					}
				}
			}
		}

		return compact( 'done', 'missed' );
	}

	/**
	 * Displays the result of the bulk translate action as notice(s)
	 *
	 * @since 2.4
	 */
	public function admin_notices() {
		if ( isset( $_GET['translated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			if ( isset( $_GET['done'] ) && $done = (int) $_GET['done'] ) { // phpcs:ignore WordPress.Security.NonceVerification
				add_settings_error(
					'general',
					'settings-updated',
					sprintf(
						/* translators: %d is a number of posts */
						_n( '%d translation created.', '%d translations created.', $done, 'polylang-pro' ),
						$done
					),
					'updated'
				);
			}

			if ( isset( $_GET['missed'] ) && $missed = (int) $_GET['missed'] ) { // phpcs:ignore WordPress.Security.NonceVerification
				add_settings_error(
					'general',
					'settings-updated',
					sprintf(
						/* translators: %d is a number of posts */
						_n( 'To avoid overwriting content, %d translation was not created.', 'To avoid overwriting content, %d translations were not created.', $missed, 'polylang-pro' ),
						$missed
					),
					'notice-warning'
				);
			}

			settings_errors();
		}
	}
}
