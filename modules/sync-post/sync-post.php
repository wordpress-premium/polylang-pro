<?php

/**
 * Manages the synchronization of posts across languages
 *
 * @since 2.1
 */
class PLL_Sync_Post {
	public $sync_model, $buttons;

	/**
	 * Constructor
	 *
	 * @since 2.1
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->sync_model = new PLL_Sync_Post_Model( $polylang );

		// Create buttons.
		foreach ( $polylang->model->get_languages_list() as $language ) {
			$this->buttons[ $language->slug ] = new PLL_Sync_Post_Button( $this->sync_model, $language );
		}

		add_action( 'pll_save_post', array( $this, 'sync_posts' ), 5, 2 ); // Before PLL_Admin_Sync, Before PLL_ACF, Before PLLWC.
	}

	/**
	 * Duplicates the post and saves the synchronization group
	 *
	 * @since 2.1
	 *
	 * @param int    $post_id The post id.
	 * @param object $post    The post object.
	 */
	public function sync_posts( $post_id, $post ) {
		static $avoid_recursion = false;

		if ( $avoid_recursion ) {
			return;
		}

		if ( ! empty( $_POST['post_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			// We are editing the post from post.php (only place where we can change the option to sync).
			if ( ! empty( $_POST['pll_sync_post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$sync_post = array_intersect( array_map( 'sanitize_key', $_POST['pll_sync_post'] ), array( 'true' ) ); // phpcs:ignore WordPress.Security.NonceVerification
			}

			if ( empty( $sync_post ) ) {
				$this->sync_model->save_group( $post_id, array() );
				return;
			}
		} else {
			// Quick edit or bulk edit or any place where the Languages metabox is not displayed.
			$sync_post = array_diff( $this->sync_model->get( $post_id ), array( $post_id ) ); // Just remove this post from the list.
		}

		$avoid_recursion = true;

		$languages = array_keys( $sync_post );

		foreach ( $languages as $k => $lang ) {
			if ( $this->sync_model->current_user_can_synchronize( $post_id, $lang ) ) {
				$tr_id = $this->sync_model->copy_post( $post_id, $lang, false ); // Don't save the group inside the loop.

				// We need to proceed as is, as the 'save_post' action is fired before the sticky status is updated in DB.
				isset( $_REQUEST['sticky'] ) && 'sticky' === $_REQUEST['sticky'] ? stick_post( $tr_id ) : unstick_post( $tr_id ); // phpcs:ignore WordPress.Security.NonceVerification
			} else {
				unset( $languages[ $k ] );
			}
		}

		// Save group if the languages metabox is displayed.
		if ( ! empty( $_POST['post_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$this->sync_model->save_group( $post_id, $languages );
		}

		$avoid_recursion = false;
	}

	/**
	 * Some backward compatibility with Polylang < 2.6
	 * allows for example to call PLL()->sync_post->are_synchronized() used in Polylang for WooCommerce
	 *
	 * @since 2.6
	 *
	 * @param string $func Function name.
	 * @param array  $args Function arguments.
	 */
	public function __call( $func, $args ) {
		if ( method_exists( $this->sync_model, $func ) ) {
			if ( WP_DEBUG ) {
				$debug = debug_backtrace(); // phpcs:ignore WordPress.PHP.DevelopmentFunctions

				trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions
					sprintf(
						'%1$s() was called incorrectly in %2$s on line %3$s: the call to PLL()->sync_post->%1$s() has been deprecated in Polylang 2.6, use PLL()->sync_post->sync_model->%1$s() instead.' . "\nError handler",
						esc_html( $func ),
						esc_html( $debug[0]['file'] ),
						absint( $debug[0]['line'] )
					)
				);
			}
			return call_user_func_array( array( $this->sync_model, $func ), $args );
		}

		$debug = debug_backtrace(); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
		trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions
			sprintf(
				'Call to undefined function PLL()->sync_post->%1$s() in %2$s on line %3$s' . "\nError handler",
				esc_html( $func ),
				esc_html( $debug[0]['file'] ),
				absint( $debug[0]['line'] )
			),
			E_USER_ERROR
		);
	}
}
