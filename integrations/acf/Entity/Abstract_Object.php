<?php
/**
 * @package  Polylang-Pro
 */

namespace WP_Syntex\Polylang_Pro\Integrations\ACF\Entity;

use Translations;
use PLL_Language;
use PLL_Export_Data;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Dispatcher;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Copy;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Export;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Import;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Synchronize;
use WP_Syntex\Polylang_Pro\Integrations\ACF\Strategy\Abstract_Strategy;

/**
 * This class is part of the ACF compatibility.
 * Abstract class to handle objects such posts and terms.
 *
 * @since 3.7
 */
abstract class Abstract_Object implements Translatable_Entity_Interface {
	/**
	 * Stores fields to avoid reverse synchronization.
	 *
	 * @var string[]
	 */
	private static $updated = array();

	/**
	 * Object ID, could be a source or target.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Constructor
	 *
	 * @since 3.7
	 *
	 * @param int $id The object ID, default to 0.
	 */
	public function __construct( int $id = 0 ) {
		$this->id = $id;
	}

	/**
	 * Filters the field about to be rendered.
	 *
	 * @since 3.7
	 *
	 * @param array $field Custom field definition.
	 * @return array Custom field of the target object with a value.
	 */
	public function render_field( $field ) {
		if ( empty( $_GET['new_lang'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return $field;
		}

		$lang = PLL()->model->get_language( sanitize_key( $_GET['new_lang'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $lang ) ) {
			return $field;
		}

		$from_id = $this->get_from_id_in_request();
		if ( empty( $from_id ) || $from_id === $this->get_id() ) {
			return $field;
		}

		$from_value     = acf_get_value( static::acf_id( $from_id ), $field );
		$original_value = $field['value'] ?? ( $field['default_value'] ?? null );
		$field['value'] = ( new Copy() )->execute(
			$this,
			$from_value,
			$field,
			array(
				'target_language' => $lang,
				'source_language' => PLL()->model->{$this->get_type()}->get_language( $from_id ),
				'original_value'  => $original_value,
			)
		);
		return $field;
	}

	/**
	 * Updates the custom field value of the current object.
	 *
	 * @since 3.7
	 *
	 * @param mixed $value Custom field value of the source object.
	 * @param array $field Custom field definition.
	 * @return mixed Custom field value of the target object.
	 */
	public function update( $value, $field ) {
		// Avoid reverse sync.
		if ( in_array( $this->get_storage_key( $this->get_id(), $field['key'] ), self::$updated, true ) ) {
			return $value;
		}

		$strategy = new Synchronize( new Copy() );


		if ( ! $strategy->can_execute( $field ) ) {
			return $value;
		}

		$translations = PLL()->model->{$this->get_type()}->get_translations( $this->get_id() );
		foreach ( $translations as $lang => $tr_id ) {
			if ( $this->get_id() === $tr_id ) {
				continue;
			}

			/** @var PLL_Language */
			$lang = PLL()->model->get_language( $lang );

			self::$updated[] = $this->get_storage_key( $tr_id, $field['key'] );

			$acf_id   = static::acf_id( $tr_id );
			$tr_value = acf_get_value( $acf_id, $field );
			$tr_value = $strategy->execute(
				$this,
				$value,
				$field,
				array(
					'target_language' => $lang,
					'original_value'  => $tr_value,
					'target_id'       => $tr_id,
				)
			);

			if ( ! empty( $field['sub_fields'] ) && is_array( $tr_value ) && empty( $tr_value ) ) {
				/*
				 * The fields has subfields but they have been removed
				 * by `Abstract_Strategy::apply_on_subfield()`
				 * as they cannot be synchronized, so do not update.

				 */
				continue;
			}

			acf_update_value( $tr_value, $acf_id, $field );
		}

		return $value;
	}

	/**
	 * Executes a strategy on fields from the current object to a target object.
	 *
	 * @since 3.7
	 *
	 * @param Abstract_Strategy $strategy Strategy to execute.
	 * @param int               $to       ID of the target object.
	 * @param array             $args     {
	 *      Array of arguments.
	 *
	 *      @type mixed  $original_value Optional. The translated value of the field, if any.
	 *      @type bool   $update         Optional. Tells if we can update the target ID fields, default `true`.
	 * }
	 * @return void
	 */
	public function apply_to_all_fields( Abstract_Strategy $strategy, int $to = 0, array $args = array() ) {
		// Removes filters on `Dispatcher::update()` to avoid unnecessary operations on `acf_update_value`.
		remove_filter( 'acf/update_value', array( Dispatcher::class, 'update' ), 5 );

		$fields = get_field_objects( static::acf_id( $this->get_id() ), false );

		if ( empty( $fields ) ) {
			$fields = array();
		}

		$args['update'] = ! isset( $args['update'] ) || (bool) $args['update'];

		foreach ( $fields as $field ) {
			if ( empty( $field['value'] ) && ! is_string( $field['value'] ) ) {
				continue;
			}

			$args['original_value'] = acf_get_value( static::acf_id( $to ), $field );
			if ( empty( $args['original_value'] ) ) {
				$args['original_value'] = $field['default_value'] ?? null;
			}

			$tr_value = $strategy->execute(
				$this,
				$field['value'],
				$field,
				$args
			);

			if ( 0 < $to && ! empty( $args['update'] ) ) {
				acf_update_value(
					$tr_value,
					static::acf_id( $to ),
					$field
				);
			}
		}

		// Reset filter for `Dispatcher::update` so our integration works for later operations.
		add_filter( 'acf/update_value', array( Dispatcher::class, 'update' ), 5, 3 );
	}

	/**
	 * Exports custom fields.
	 *
	 * @param PLL_Export_Data $export The export object.
	 * @param object|null     $to     The translated object if it exists, `null` otherwise.
	 * @return void
	 * @since 3.7
	 */
	public function export( PLL_Export_Data $export, ?object $to ) {
		$this->apply_to_all_fields(
			new Export( $export ),
			empty( $to ) ? 0 : $this->get_object_id( $to ),
			array(
				'target_language' => $export->get_target_language(),
				'update'          => false,
			)
		);
	}

	/**
	 * Translates the custom fields from the current object.
	 *
	 * @since 3.7
	 *
	 * @param object       $to           The target object.
	 * @param PLL_Language $target_lang  Target language object.
	 * @param Translations $translations A set of translations to search the custom fields translations in.
	 * @return object The translated object.
	 */
	public function translate( object $to, PLL_Language $target_lang, Translations $translations ): object {
		$this->apply_to_all_fields(
			new Import( $translations ),
			$this->get_object_id( $to ),
			array( 'target_language' => $target_lang )
		);

		return $to;
	}

	/**
	 * Removes ACF metas from metas to be synchronized by Polylang.
	 * To use only the ACF integration synchronization mechanism.
	 *
	 * @since 3.7
	 *
	 * @param string[]   $metas List of custom fields names.
	 * @param bool       $sync  True if it is synchronization, false if it is a copy.
	 * @param int|string $from  ID of the object from which we copy information.
	 * @param int|string $to    ID of the object to which we copy information.
	 * @return string[]
	 */
	public static function remove_acf_metas_from_pll_sync( $metas, $sync, $from, $to ) {
		if ( ! is_array( $metas ) ) {
			return $metas;
		}

		$from = static::acf_id( (int) $from );
		$to   = static::acf_id( (int) $to );

		$acf_metas = array_merge( (array) acf_get_meta( $from ), (array) acf_get_meta( $to ) );
		$acf_metas = array_keys( $acf_metas );

		return array_diff( $metas, $acf_metas );
	}

	/**
	 * Returns current object ID.
	 *
	 * @since 3.7
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->id;
	}

	/**
	 * Gets the ACF field key to store.
	 *
	 * @since 3.7
	 *
	 * @param int    $id  Object ID.
	 * @param string $key The custom field key.
	 * @return string
	 */
	protected function get_storage_key( $id, $key ) {
		return static::acf_id( $id ) . '|' . $key;
	}

	/**
	 * Returns the object ID.
	 *
	 * @since 3.7
	 *
	 * @param object $object The object.
	 * @return int
	 */
	abstract protected function get_object_id( $object ): int;

	/**
	 * Transforms an object ID to the corresponding ACF post ID.
	 *
	 * @since 3.7
	 *
	 * @param int $id Object ID.
	 * @return int|string ACF post ID.
	 */
	abstract protected static function acf_id( $id );

	/**
	 * Returns source object ID passed in the main request if exists.
	 *
	 * @since 3.7
	 *
	 * @return int
	 */
	abstract protected function get_from_id_in_request(): int;

	/**
	 * Returns current object type.
	 *
	 * The returned value must match:
	 * - the name of the property storing the corresponding model (`PLL()->model->{type}`).
	 * - the `object_type` from `PLL_Export_Data::add_translation_entry()`.
	 *
	 * @since 3.7
	 *
	 * @return string
	 * @phpstan-return non-falsy-string
	 */
	abstract public function get_type(): string;
}
