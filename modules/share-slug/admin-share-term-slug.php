<?php

/**
 * Manages shared slugs for taxonomy terms on admin side
 *
 * @since 1.9
 */
class PLL_Admin_Share_Term_Slug extends PLL_Share_Term_Slug {

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
			if ( isset( $_POST['term_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$slug .= '___' . $this->model->get_language( sanitize_key( $_POST['term_lang_choice'] ) )->slug; // phpcs:ignore WordPress.Security.NonceVerification
			}

			elseif ( isset( $_POST['inline_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$slug .= '___' . $this->model->get_language( sanitize_key( $_POST['inline_lang_choice'] ) )->slug; // phpcs:ignore WordPress.Security.NonceVerification
			}

			// *Post* bulk edit, in case a new term is created.
			elseif ( isset( $_GET['bulk_edit'], $_GET['inline_lang_choice'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				// Bulk edit does not modify the language.
				if ( -1 == $_GET['inline_lang_choice'] ) { // phpcs:ignore WordPress.Security.NonceVerification
					$slug .= '___' . $this->model->post->get_language( $this->post_id )->slug;
				} else {
					$slug .= '___' . $this->model->get_language( sanitize_key( $_GET['inline_lang_choice'] ) )->slug; // phpcs:ignore WordPress.Security.NonceVerification
				}
			}

			// Special cases for default categories as the select is disabled.
			elseif ( ! empty( $_POST['tag_ID'] ) && in_array( get_option( 'default_category' ), $this->model->term->get_translations( (int) $_POST['tag_ID'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$slug .= '___' . $this->model->term->get_language( (int) $_POST['tag_ID'] )->slug; // phpcs:ignore WordPress.Security.NonceVerification
			}

			elseif ( ! empty( $_POST['tax_ID'] ) && in_array( get_option( 'default_category' ), $this->model->term->get_translations( (int) $_POST['tax_ID'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				$slug .= '___' . $this->model->term->get_language( (int) $_POST['tax_ID'] )->slug; // phpcs:ignore WordPress.Security.NonceVerification
			}
		}

		return $slug;
	}
}
