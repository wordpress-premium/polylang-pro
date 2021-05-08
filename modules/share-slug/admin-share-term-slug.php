<?php
/**
 * @package Polylang-Pro
 */

/**
 * Manages shared slugs for taxonomy terms on admin side
 *
 * @since 1.9
 */
class PLL_Admin_Share_Term_Slug extends PLL_Share_Term_Slug {
	/**
	 * Stores the name of a term being saved.
	 *
	 * @var string
	 */
	protected $pre_term_name;

	/**
	 * The id of the current post being updated.
	 *
	 * @var int
	 */
	protected $post_id;

	/**
	 * Constructor
	 *
	 * @since 1.9
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		parent::__construct( $polylang );

		add_action( 'pre_post_update', array( $this, 'pre_post_update' ), 5 );
		add_filter( 'pre_term_name', array( $this, 'pre_term_name' ), 5 );
		add_filter( 'pre_term_slug', array( $this, 'pre_term_slug' ), 5, 2 );
	}

	/**
	 * Stores the name of a term being saved, for use in the filter pre_term_slug
	 *
	 * @since 1.9
	 *
	 * @param string $name The term name to store.
	 * @return string Unmodified term name.
	 */
	public function pre_term_name( $name ) {
		return $this->pre_term_name = $name;
	}

	/**
	 * Stores the current post_id when bulk editing posts for use in save_language and pre_term_slug
	 *
	 * @since 1.9
	 *
	 * @param int $post_id The id of the current post being updated.
	 * @return void
	 */
	public function pre_post_update( $post_id ) {
		if ( isset( $_GET['bulk_edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$this->post_id = $post_id;
		}
	}

	/**
	 * Creates the term slug in case the term already exists in another language
	 *
	 * @since 1.9
	 *
	 * @param string $slug     The inputed slug of the term being saved, may be empty.
	 * @param string $taxonomy The term taxonomy.
	 * @return string
	 */
	public function pre_term_slug( $slug, $taxonomy ) {
		if ( ! $slug ) {
			$slug = sanitize_title( $this->pre_term_name );
		}

		if ( $this->model->is_translated_taxonomy( $taxonomy ) && term_exists( $slug, $taxonomy ) ) {
			$parent = 0;

			if ( isset( $_POST['term_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$lang = $this->model->get_language( sanitize_key( $_POST['term_lang_choice'] ) ); // phpcs:ignore WordPress.Security.NonceVerification

				if ( isset( $_POST['parent'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$parent = intval( $_POST['parent'] ); // phpcs:ignore WordPress.Security.NonceVerification
				} elseif ( isset( $_POST[ "new{$taxonomy}_parent" ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$parent = intval( $_POST[ "new{$taxonomy}_parent" ] ); // phpcs:ignore WordPress.Security.NonceVerification
				}
			}

			elseif ( isset( $_POST['inline_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$lang = $this->model->get_language( sanitize_key( $_POST['inline_lang_choice'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			}

			// *Post* bulk edit, in case a new term is created.
			elseif ( isset( $_GET['bulk_edit'], $_GET['inline_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				// Bulk edit does not modify the language.
				if ( -1 == $_GET['inline_lang_choice'] ) { // phpcs:ignore WordPress.Security.NonceVerification
					$lang = $this->model->post->get_language( $this->post_id );
				} else {
					$lang = $this->model->get_language( sanitize_key( $_GET['inline_lang_choice'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
				}
			}

			// Special cases for default categories as the select is disabled.
			elseif ( ! empty( $_POST['tag_ID'] ) && in_array( get_option( 'default_category' ), $this->model->term->get_translations( (int) $_POST['tag_ID'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$lang = $this->model->term->get_language( (int) $_POST['tag_ID'] ); // phpcs:ignore WordPress.Security.NonceVerification
			}

			elseif ( ! empty( $_POST['tax_ID'] ) && in_array( get_option( 'default_category' ), $this->model->term->get_translations( (int) $_POST['tax_ID'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$lang = $this->model->term->get_language( (int) $_POST['tax_ID'] ); // phpcs:ignore WordPress.Security.NonceVerification
			}

			if ( ! empty( $lang ) ) {
				$term_id = $this->model->term_exists_by_slug( $slug, $lang, $taxonomy, $parent );

				// If no term exists or if we are editing the existing term, trick WP to allow shared slugs.
				if ( ! $term_id || ( ! empty( $_POST['tag_ID'] ) && $_POST['tag_ID'] == $term_id ) || ( ! empty( $_POST['tax_ID'] ) && $_POST['tax_ID'] == $term_id ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$slug .= '___' . $lang->slug;
				}
			}
		}

		return $slug;
	}
}
