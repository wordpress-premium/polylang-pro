<?php
/**
 * @package Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy;

use Translations;
use WP_Syntex\Polylang_Pro\Modules\Import_Export\Services\Context;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Entity\Abstract_Object;
/**
 * This class is part of the ACF compatibility.
 * Import strategy.
 * Saves the custom fields value from translated data objects (e.g. DeepL or XLIFF).

 * @since 3.7
 */
class Import extends Copy {

	/**
	 * Translations set where to look for the post custom fields translations.
	 *
	 * @var Translations
	 */
	protected $translations;

	/**
	 * Constructor.
	 *
	 * @since 3.7
	 *
	 * @param Translations $translations A set of translations to search the custom fields translations in.
	 * @return void
	 */
	public function __construct( Translations $translations ) {
		$this->translations = $translations;
	}

	/**
	 * Applies the translation strategy.
	 *
	 * Depending on the type of fields, this will copy a layout and
	 * auto-translate object ids and translated custom fields.
	 *
	 * @since 3.7
	 *
	 * @param Abstract_Object $object ACF object.
	 * @param mixed           $value  Custom field value of the source object.
	 * @param array           $field  Custom field definition.
	 * @param array           $args   {
	 *     Array of arguments.
	 *
	 *     @type mixed $original_value Optional. The translated value of the field, if any.
	 * }
	 * @return mixed Custom field value of the target object.
	 */
	public function execute( Abstract_Object $object, $value, array $field, array $args = array() ) {
		$args = wp_parse_args( $args, array( 'original_value' => null ) );

		if ( ! $this->can_execute( $field ) ) {
			return $args['original_value'];
		}

		if ( empty( $value ) ) {
			return $value;
		}

		if ( ! is_string( $value ) ) {
			return parent::execute( $object, $value, $field, $args );
		}

		$args['original_value'] = is_string( $args['original_value'] ) ? $args['original_value'] : '';

		/*
		 * If the field has already been translated, don't pass it to `translate()` which
		 * would overwrite the current translated value by the source value as no translation can be found.
		*/
		if ( 'translate_once' === $field['translations'] && ! empty( $args['original_value'] ) ) {
			return $args['original_value'];
		}

		$value = $this->translations->translate(
			$value,
			Context::to_string(
				array(
					Context::FIELD => 'acf',
					Context::ID    => $this->get_field_key( $field ),
				)
			)
		);

		return parent::execute(
			$object,
			$value,
			$field,
			$args
		);
	}
}
