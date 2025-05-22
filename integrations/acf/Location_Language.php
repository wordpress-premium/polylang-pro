<?php
/**
 * @package Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF;

use ACF_Location;

/**
 * This class is part of the ACF compatibility.
 * Adds a Language ACF location allowing to display a field group only for one language.
 *
 * @since 3.7
 */
class Location_Language extends ACF_Location {

	/**
	 * Initializes props.
	 *
	 * @since 3.7
	 *
	 * @return void
	 */
	public function initialize() {
		$this->name     = 'language';
		$this->label    = __( 'Language', 'polylang-pro' );
		$this->category = $this->label; // Create a new category with the same name.
	}

	/**
	 * Matches the provided rule against the screen args returning a bool result.
	 *
	 * @since 3.7
	 *
	 * @param array $rule        The location rule.
	 * @param array $screen      The screen args.
	 * @param array $field_group The field group settings.
	 * @return  bool
	 */
	public function match( $rule, $screen, $field_group ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$language = pll_current_language();
		return empty( $language ) || $this->compare_to_rule( $language, $rule );
	}

	/**
	 * Returns an array of possible values for this rule type.
	 *
	 * @since 3.7
	 *
	 * @param array $rule A location rule.
	 * @return array
	 */
	public function get_values( $rule ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return array_combine( pll_languages_list(), pll_languages_list( array( 'fields' => 'name' ) ) );
	}

	/**
	 * Checks if the field group has a language location rule.
	 *
	 * @since 3.7.1
	 *
	 * @param string $selector The selector of the field group.
	 * @return bool True if the field group has a language location rule, false otherwise.
	 */
	public static function has_language_location_rule( $selector ): bool {
		$field_group = acf_get_field_group( $selector );

		if ( empty( $field_group ) ) {
			return false;
		}

		if ( empty( $field_group['location'] ) ) {
			return false;
		}

		foreach ( $field_group['location'] as $location ) {
			foreach ( $location as $rule ) {
				if ( 'language' === $rule['param'] ) {
					return true;
				}
			}
		}

		return false;
	}
}
