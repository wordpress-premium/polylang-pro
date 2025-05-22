<?php
/**
 * @package Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy;

use PLL_Export_Data;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Entity\Abstract_Object;

/**
 * This class is part of the ACF compatibility.
 * Export strategy.
 * Adds custom fields value to data export object.
 *
 * @since 3.7
 */
class Export extends Abstract_Strategy {

	/**
	 * @var PLL_Export_Data The export object.
	 */
	protected $export;

	/**
	 * Constructor.
	 *
	 * @since 3.7
	 *
	 * @param PLL_Export_Data $export The export object.
	 * @return void
	 */
	public function __construct( PLL_Export_Data $export ) {
		$this->export = $export;
	}

	/**
	 * Executes the strategy on a given field.
	 * Depending on the type of fields, this will add the fields with the translate option to the fields to export.
	 *
	 * @since 3.7
	 *
	 * @param Abstract_Object $object ACF object.
	 * @param mixed           $value  Custom field value of the source object.
	 * @param array           $field  Custom field definition.
	 * @param array           $args   {
	 *     Array of arguments.
	 *
	 *     @type mixed $original_value The translated value of the field, if any.
	 * }
	 * @return mixed The original value, so the strategy behaves like others.
	 */
	protected function apply( Abstract_Object $object, $value, array $field, array $args = array() ) {
		if ( ! is_string( $value ) || empty( $value ) ) {
			return $value;
		}

		$original_value = is_string( $args['original_value'] ) ? $args['original_value'] : '';

		if ( isset( $field['translations'] ) && 'translate_once' === $field['translations'] && ! empty( $original_value ) ) {
			// The field has already been translated once, skip the export.
			return $value;
		}

		$this->export->add_translation_entry(
			array(
				'object_type' => $object->get_type(),
				'field_type'  => 'acf',
				'field_id'    => $this->get_field_key( $field ),
				'object_id'   => $object->get_id(),
			),
			$value,
			$original_value
		);

		return $value;
	}

	/**
	 * Recursively checks if a field can be copied.
	 *
	 * @since 3.7
	 *
	 * @param array $field Custom field definition.
	 * @return bool
	 */
	protected function can_execute_recursive( array $field ): bool {
		if ( isset( $field['translations'] ) && in_array( $field['translations'], array( 'translate', 'translate_once' ), true ) ) {
			return true;
		}

		return parent::can_execute_recursive( $field );
	}
}
