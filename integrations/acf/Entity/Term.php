<?php
/**
 * @package  Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF\Entity;

use WP_Term;

/**
 * This class is part of the ACF compatibility.
 * Handles terms.
 *
 * @since 3.7
 */
class Term extends Abstract_Object {
	/**
	 * Returns the object ID.
	 *
	 * @since 3.7
	 *
	 * @param WP_Term $object The object.
	 * @return int
	 */
	protected function get_object_id( $object ): int {
		return $object->term_id;
	}

	/**
	 * Transforms a term ID to the corresponding ACF post ID.
	 *
	 * @since 3.7
	 *
	 * @param int $id Term ID.
	 * @return string ACF post ID.
	 */
	protected static function acf_id( $id ) {
		return 'term_' . $id;
	}

	/**
	 * Returns source object ID passed in the main request if exists.
	 *
	 * @since 3.7
	 *
	 * @return int
	 */
	protected function get_from_id_in_request(): int {
		if ( isset( $_GET['taxonomy'], $_GET['from_tag'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return (int) $_GET['from_tag']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		return 0;
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
		return 'term';
	}
}
