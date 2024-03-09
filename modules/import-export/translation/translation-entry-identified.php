<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_Translation_Entry_Identified
 *
 * Extends Translation_Entry to allow the identification of the entry through the 'id' property.
 */
class PLL_Translation_Entry_Identified extends Translation_Entry {
	/**
	 * Uniquely identifies the translation, whether its string has changed or not.
	 *
	 * @var string $id
	 */
	protected $id;

	/**
	 * PLL_Translation_Entry_Identified constructor.
	 * Identify the translation entry automatically.
	 *
	 * @see https://developer.wordpress.org/reference/classes/translation_entry/
	 *
	 * @since 3.3
	 *
	 * @param array $entry A translation entry arguments. Default: empty array.
	 */
	public function __construct( $entry = array() ) {
		parent::__construct( $entry );

		if ( isset( $entry['id'] ) && ! empty( $entry['id'] ) ) {
			$this->id = $entry['id'];
		} elseif ( isset( $this->singular ) ) {
			$hash = md5( $this->singular );

			// Trim the hash to keep only the first height characters.
			$this->id = substr( $hash, 0, 8 );
		} else {
			$this->id = '';
		}
	}

	/**
	 * Returns the identifier of the entry.
	 *
	 * @since 3.3
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}
}
