<?php
/**
 * @package Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF;

use WP_Syntex\Polylang_Pro\Integrations\ACF\Entity\Post;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Copy;

/**
 * This class is part of the ACF compatibility.
 * Handles response to language change in post metabox in editors.
 *
 * @since 3.7
 */
class Ajax_Lang_Choice {
	/**
	 * Setups actions.
	 *
	 * @since 3.7
	 *
	 * @return void
	 */
	public function on_acf_init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_acf_post_lang_choice', array( $this, 'acf_post_lang_choice' ) );
		add_filter( 'acf/fields/relationship/query', array( Dispatcher::class, 'add_language_to_query' ), 10, 3 );
	}

	/**
	 * Enqueues javascript to react to a language change in the post metabox.
	 *
	 * @since 2.0
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		global $pagenow, $typenow;

		if (
			in_array( $pagenow, array( 'post.php', 'post-new.php' ), true )
			&& PLL()->model->is_translated_post_type( $typenow )
		) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script( 'pll_acf', plugins_url( '/js/build/integrations/acf' . $suffix . '.js', POLYLANG_ROOT_FILE ), array( 'wp-api-fetch', 'acf-input' ), POLYLANG_VERSION );
		}
	}

	/**
	 * Ajax response for changing the language in the post metabox.
	 *
	 * @since 2.0
	 *
	 * @return void
	 */
	public function acf_post_lang_choice() {
		check_ajax_referer( 'pll_language', '_pll_nonce' );

		if ( ! isset( $_POST['fields'], $_POST['lang'], $_POST['post_id'] ) ) {
			wp_die( 0 );
		}

		$post_id = (int) $_POST['post_id'];
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( -1 );
		}

		$language = PLL()->model->languages->get( sanitize_key( $_POST['lang'] ) );
		if ( ! $language ) {
			wp_die( 0 );
		}

		$response = array();

		$fields = explode( ',', sanitize_text_field( wp_unslash( $_POST['fields'] ) ) );
		foreach ( $fields as $field ) {
			$field_array = acf_get_field( $field );

			if ( false === $field_array ) {
				continue;
			}

			$from_value           = acf_get_value( $post_id, $field_array );
			$field_array['value'] = ( new Copy() )->execute(
				new Post( $post_id ),
				$from_value,
				$field_array,
				array(
					'target_language' => $language,
					'original_value'  => $from_value,
				)
			);
			acf_update_value( $field_array['value'], $post_id, $field_array );

			ob_start();
			acf_render_fields( array( $field_array ) );
			$field_wrap = ob_get_clean();

			$response[] = array(
				'field_key'  => str_replace( '_', '-', $field ),
				'field_data' => false !== $field_wrap ? $field_wrap : '',
			);
		}

		wp_send_json( $response );
	}
}
