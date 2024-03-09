<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_Translations_Identified
 *
 * Extends a Translations object, and allows to add entries with the PLL_Translation_Entry_Identified class.
 *
 * @since 3.3
 */
class PLL_Translations_Identified extends Translations {

	/**
	 * Clone the parent method and use PLL_Translation_Entry_Identified instead of Translation_Entry.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/6.0/wp-includes/pomo/translations.php#L24
	 *
	 * @since 3.3
	 *
	 * @param array|PLL_Translation_Entry_Identified $entry An entry (or an array with entry's data)
	 *                                                      to add to the set of translations entries.
	 * @return bool true on success, false if the entry doesn't have a key
	 */
	public function add_entry( $entry ) {
		if ( is_array( $entry ) ) {
			$entry = new PLL_Translation_Entry_Identified( $entry );
		}

		return parent::add_entry( $entry );
	}

	/**
	 * Clone the parent method and use PLL_Translation_Entry_Identified instead of Translation_Entry.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/6.0/wp-includes/pomo/translations.php#L40
	 *
	 * @since 3.3
	 *
	 * @param array|PLL_Translation_Entry_Identified $entry An entry (or an array with entry's data)
	 *                                                      to add to the set of translations entries.
	 * @return bool
	 */
	public function add_entry_or_merge( $entry ) {
		if ( is_array( $entry ) ) {
			$entry = new PLL_Translation_Entry_Identified( $entry );
		}

		return parent::add_entry_or_merge( $entry );
	}
}
