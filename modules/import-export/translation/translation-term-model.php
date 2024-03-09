<?php
/**
 * @package Polylang-Pro
 */

/**
 * Translate post taxonomies from a set of translation entries.
 *
 * @since 3.3
 */
class PLL_Translation_Term_Model {

	/**
	 * Translations set where to look for the post metas translations.
	 *
	 * @var Translations
	 */
	private $translations;

	/**
	 * Used to manage languages and translations.
	 *
	 * @var PLL_Model
	 */
	private $model;

	/**
	 * Used to translate term meta with a set an translation entries.
	 *
	 * @var PLL_Translation_Term_Metas
	 */
	private $translation_term_metas;

	/**
	 * Currently translated term language.
	 *
	 * @var PLL_Language|null
	 */
	private $target_language;

	/**
	 * Currently translated term taxonomy.
	 *
	 * @var string
	 */
	private $taxonomy;

	/**
	 * Used to set the term parent of an updated term.
	 *
	 * @var int
	 */
	private $inserted_term_parent = 0;

	/**
	 * PLL_Translation_Term_Model constructor.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Settings|PLL_Admin $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->model                  = &$polylang->model;
		$this->translation_term_metas = new PLL_Translation_Term_Metas( $polylang->sync->term_metas );
	}

	/**
	 * Setter for translations.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Translations_Identified $translations A set of translations to search the metas translations in.
	 * @return void
	 */
	public function set_translations( $translations ) {
		$this->translations = $translations;
		$this->translation_term_metas->set_translations( $translations );
	}

	/**
	 * Translates a term.
	 *
	 * @since 3.3
	 *
	 * @param array        $entry    Properties array of an entry.
	 * @param PLL_Language $language The target language.
	 * @return int The translated term id, 0 on failure.
	 */
	public function translate_term( $entry, $language ) {
		$this->set_translations( $entry['data'] );
		$this->target_language = $language;
		$source_term           = get_term( $entry['id'] );

		if ( ! $source_term instanceof WP_Term ) {
			// Something went wrong.
			return 0;
		}

		$this->taxonomy      = $source_term->taxonomy;
		$tr_term_name        = $this->get_translated_term_name( $source_term );
		$tr_term_description = $this->get_translated_term_description( $source_term );
		$tr_term_id          = $this->model->term->get( $entry['id'], $language );

		if ( $tr_term_id ) {
			// The translation already exists.
			$args = array();
			// Don't update name or description if not provided in translations.
			if ( $source_term->name !== $tr_term_name ) {
				$args['name'] = $tr_term_name;
			}
			if ( $source_term->description !== $tr_term_description ) {
				$args['description'] = $tr_term_description;
			}
			$tr_term = wp_update_term( $tr_term_id, $source_term->taxonomy, $args );
			if ( is_wp_error( $tr_term ) ) {
				// Something went wrong!
				return 0;
			}
		} else {
			add_filter( 'pll_inserted_term_language', array( $this, 'set_language_for_term_slug' ), 20, 2 ); // After Polylang's filter.
			$tr_term = wp_insert_term( $tr_term_name, $source_term->taxonomy, array( 'description' => $tr_term_description ) );
			remove_filter( 'pll_inserted_term_language', array( $this, 'set_language_for_term_slug' ), 20 );
			if ( is_wp_error( $tr_term ) ) {
				// Something went wrong!
				return 0;
			}
			$tr_term_id = (int) $tr_term['term_id'];
			$this->model->term->set_language( $tr_term_id, $language );
			$translations                    = $this->model->term->get_translations( $source_term->term_id );
			$translations[ $language->slug ] = $tr_term_id;
			$this->model->term->save_translations( $source_term->term_id, $translations );
		}


		return $tr_term_id;
	}

	/**
	 * Returns the translated term name if exists, the source name otherwise.
	 *
	 * @since 3.3
	 *
	 * @param WP_Term $source_term The source term object.
	 * @return string The translated name.
	 */
	private function get_translated_term_name( $source_term ) {
		$entry_to_translate = new PLL_Translation_Entry_Identified(
			array(
				'singular' => $source_term->name,
				'context'  => 'name',
			)
		);
		return $this->maybe_translate_term_entry( $entry_to_translate );
	}

	/**
	 * Returns the translated term description if exists, the source description otherwise.
	 *
	 * @since 3.3
	 *
	 * @param WP_Term $source_term The source term object.
	 * @return string The translated description.
	 */
	private function get_translated_term_description( $source_term ) {
		$entry_to_translate = new PLL_Translation_Entry_Identified(
			array(
				'singular' => $source_term->description,
				'context'  => 'description',
			)
		);
		return $this->maybe_translate_term_entry( $entry_to_translate );
	}

	/**
	 * Translates a given entry, returns the source string if no translation found.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Translation_Entry_Identified $entry The entry to translate.
	 * @return string The translated string from the entry.
	 */
	private function maybe_translate_term_entry( $entry ) {
		$translated_entry = $this->translations->translate_entry( $entry );
		return ( $translated_entry && ! empty( $translated_entry->translations ) && ! empty( $translated_entry->translations[0] ) ) ? $translated_entry->translations[0] : $entry->singular;
	}

	/**
	 * Translates term parent if there is one.
	 *
	 * @since 3.3
	 *
	 * @param int[]        $term_ids Array of source term ids.
	 * @param PLL_Language $language The target language.
	 * @return void
	 */
	public function translate_parent_for_terms( array $term_ids, PLL_Language $language ) {
		$term_ids = array_filter( $term_ids );

		if ( empty( $term_ids ) ) {
			// Invalid list of term IDs.
			return;
		}

		$term_ids = array_unique( $term_ids, SORT_NUMERIC );

		// Get the terms with their parents (or 0).
		$terms = get_terms(
			array(
				'include'    => $term_ids,
				'hide_empty' => false,
				'fields'     => 'id=>parent',
			)
		);

		if ( ! is_array( $terms ) ) {
			// No terms with parents.
			return;
		}

		// ‘id=>parent’ returns an array of numeric strings, so let's cast it into int.
		$terms = array_map( 'intval', array_filter( $terms, 'is_numeric' ) );

		// Keep only the terms that have a parent.
		$terms = array_filter( $terms );

		if ( empty( $terms ) ) {
			// No terms with parents.
			return;
		}

		$tr_ids = array();
		foreach ( $terms as $child => $term_id ) {
			$tr_ids[ $child ] = $this->model->term->get( $child, $language->slug );
		}
		$tr_ids = array_filter( $tr_ids );

		if ( empty( $tr_ids ) ) {
			// No translations.
			return;
		}

		foreach ( $terms as $child => $term_id ) {
			if ( empty( $tr_ids[ $child ] ) ) {
				// Not translated.
				continue;
			}

			$tr_parent_term = $this->model->term->get( $term_id, $language->slug );
			if ( empty( $tr_parent_term ) ) {
				// The parent term is not translated.
				continue;
			}

			$tr_term_id = $this->model->term->get( $tr_ids[ $child ], $language->slug );
			if ( empty( $tr_term_id ) ) {
				continue;
			}

			$tr_term = get_term( $tr_term_id );
			if ( ! $tr_term instanceof WP_Term ) {
				continue;
			}

			$this->taxonomy = $tr_term->taxonomy;

			// Set term parent and language for shared slugs.
			$this->target_language = $language;
			$this->inserted_term_parent = $tr_parent_term;
			add_filter( 'pll_inserted_term_language', array( $this, 'set_language_for_term_slug' ), 20, 2 ); // After Polylang's filter.
			add_filter( 'pll_inserted_term_parent', array( $this, 'get_inserted_term_parent' ) );
			wp_update_term( $tr_term->term_id, $tr_term->taxonomy, array( 'parent' => $tr_parent_term ) );

			// Clean up!
			remove_filter( 'pll_inserted_term_parent', array( $this, 'get_inserted_term_parent' ) );
			remove_filter( 'pll_inserted_term_language', array( $this, 'set_language_for_term_slug' ), 20 );
		}

	}

	/**
	 * Filters the currently inserted term language
	 * to allow sharing the same slug or to suffix it.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Language|null $language Already found language object, null in none was found.
	 * @param string            $taxonomy Currently inserted term taxonomy.
	 * @return PLL_Language|null Overridden language object.
	 */
	public function set_language_for_term_slug( $language, $taxonomy ) {
		if ( empty( $this->target_language ) || $this->taxonomy !== $taxonomy ) {
			return $language;
		}

		return $this->target_language;
	}

	/**
	 * Filters the inserted term ID parent during translation.
	 *
	 * @since 3.3
	 *
	 * @return int Term parent ID.
	 */
	public function get_inserted_term_parent() {
		return $this->inserted_term_parent ? $this->inserted_term_parent : 0;
	}
}
