<?php
/**
 * @package  Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF\Entity;

use WP_Post;
use PLL_Admin_Links;
use PLL_Sync_Post_Model;
use PLL_Language;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Copy;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Copy_All;

/**
 * This class is part of the ACF compatibility.
 * Handles posts.
 *
 * @since 3.7
 */
class Post extends Abstract_Object {

	/**
	 * The previous language slug of the target post.
	 *
	 * @var string
	 */
	protected static $previous_lang = '';

	/**
	 * Returns the object ID.
	 *
	 * @since 3.7
	 *
	 * @param WP_Post $object The object.
	 * @return int
	 */
	protected function get_object_id( $object ): int {
		return $object->ID;
	}

	/**
	 * Transforms a post ID to the corresponding ACF post ID.
	 *
	 * @since 3.7
	 *
	 * @param int $id Post ID.
	 * @return int ACF post ID.
	 */
	protected static function acf_id( $id ) {
		return $id;
	}

	/**
	 * Returns source object ID passed in the main request if exists.
	 *
	 * @since 3.7
	 *
	 * @return int
	 */
	protected function get_from_id_in_request(): int {
		if ( ! PLL()->links instanceof PLL_Admin_Links ) {
			return 0;
		}

		$data = PLL()->links->get_data_from_new_post_translation_request(
			(string) get_post_type( $this->get_id() )
		);

		return ! empty( $data['from_post'] ) ? $data['from_post']->ID : 0;
	}

	/**
	 * Returns current object type.
	 *
	 * @since 3.7
	 *
	 * @return string
	 * @phpstan-return non-falsy-string
	 */
	public function get_type(): string {
		return 'post';
	}

	/**
	 * Copies or synchronizes ACF custom fields when using Polylang's copy post function (and not the post-new.php where ACF filters are applied).
	 * (e.g. using bulk translate, creating a synchronized post).
	 *
	 * @since 3.7
	 *
	 * @param int    $tr_post_id ID of the target post.
	 * @param string $lang       Language of the target post.
	 * @param string $sync      `sync` if doing synchro, `copy` otherwise.
	 * @return void
	 *
	 * @phpstan-param 'sync'|'copy' $sync
	 */
	public function on_post_synchronized( $tr_post_id, $lang, $sync ) {
		$lang = PLL()->model->get_language( $lang );
		if ( empty( $lang ) ) {
			return;
		}

		$this->maybe_reset_fields_store( $lang );

		if ( PLL_Sync_Post_Model::COPY === $sync ) {
			$this->apply_to_all_fields( new Copy(), $tr_post_id, array( 'target_language' => $lang ) );
			return;
		}

		// Sync all custom fields between synchronized posts.
		$post_id = $this->get_id();
		foreach ( pll_get_post_translations( $post_id ) as $tr_lang => $tr_id ) {
			if ( $tr_id === $post_id || ! PLL()->sync_post_model->are_synchronized( $post_id, $tr_id ) ) {
				continue;
			}
			/** @var PLL_Language */
			$tr_lang = PLL()->model->get_language( $tr_lang );

			$this->apply_to_all_fields( new Copy_All(), $tr_id, array( 'target_language' => $tr_lang ) );
		}
	}

	/**
	 * Resets the `fields` store to translate the default values in the correct language.
	 * Only if the current target language has been changed.
	 *
	 * @since 3.7
	 *
	 * @param PLL_Language $lang Language of the target post.
	 * @return void
	 */
	protected function maybe_reset_fields_store( PLL_Language $lang ) {
		if ( self::$previous_lang !== $lang->slug ) {
			$store = acf_get_store( 'fields' );
			$store->reset();
			self::$previous_lang = $lang->slug;
		}
	}
}
