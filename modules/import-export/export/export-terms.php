<?php
/**
 * @package Polylang-Pro
 */

/**
 *
 * Class that send the taxonomies that will be exported.
 *
 * @since 3.3
 */
class PLL_Export_Terms {

	/**
	 * Used to query languages and translations.
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Term Metas
	 *
	 * @var PLL_Export_Term_Metas
	 */
	private $term_metas;

	/**
	 * Constructor.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Model $model Needed to access the translated taxonomies list.
	 */
	public function __construct( $model ) {
		$this->model      = $model;
		$this->term_metas = new PLL_Export_Term_Metas();
	}

	/**
	 *
	 * Export taxonomy terms.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Export_Multi_Files $export          Represent export file.
	 * @param WP_Term[]              $terms           A list of term objects.
	 * @param PLL_Language           $target_language Language of the translated post.
	 * @return PLL_Export_Multi_Files
	 */
	public function export( PLL_Export_Multi_Files $export, array $terms, PLL_Language $target_language ) {
		$terms_by_lang = array_fill_keys( $this->model->get_languages_list( array( 'fields' => 'slug' ) ), array() );
		$tr_ids        = array();

		// Arrange terms by language so they are added to the right file.
		foreach ( $terms as $term ) {
			$term_lang = $this->model->term->get_language( $term->term_id );

			if ( empty( $term_lang ) ) {
				// Terms and posts without language are not exported.
				continue;
			}

			$terms_by_lang[ $term_lang->slug ][ $term->term_taxonomy_id ] = $term;

			$tr_ids[] = $this->model->term->get( $term->term_id, $target_language->slug );
		}

		$terms_by_lang = array_filter( $terms_by_lang );

		if ( empty( $terms_by_lang ) ) {
			return $export;
		}

		$tr_ids = array_filter( $tr_ids );

		if ( ! empty( $tr_ids ) ) {
			// Query all the translated terms outside the loop to avoid multiple SQL queries with get_term() call.
			get_terms( array( 'include' => $tr_ids ) );
		}

		foreach ( $terms_by_lang as $lang_slug => $terms ) {
			/** @var PLL_Language $source_language This cannot be false. */
			$source_language = $this->model->get_language( $lang_slug );
			$export->set_source_language( $source_language->get_locale( 'display' ) );
			$export->set_target_language( $target_language->get_locale( 'display' ) );

			foreach ( $terms as $term ) {
				$export->set_source_reference( PLL_Import_Export::TYPE_TERM, (string) $term->term_id );

				$tr_id   = $this->model->term->get( $term->term_id, $target_language->slug );
				$tr_term = null;

				if ( ! empty( $tr_id ) ) {
					$tr_term = get_term( $tr_id );
					$tr_term = $tr_term instanceof WP_Term ? $tr_term : null;
				}

				$export->add_translation_entry( PLL_Import_Export::TERM_NAME, $term->name, ! empty( $tr_term ) ? $tr_term->name : '' );

				if ( ! empty( $term->description ) ) {
					$export->add_translation_entry( PLL_Import_Export::TERM_DESCRIPTION, $term->description, ! empty( $tr_term ) ? $tr_term->description : '' );
				}

				// Term Metas handling.
				$export = $this->term_metas->export( $export, $term->term_id, ! empty( $tr_term ) ? $tr_term->term_id : 0 );
			}
		}

		return $export;
	}
}
