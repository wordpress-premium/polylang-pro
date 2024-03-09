<?php
/**
 * @package Polylang-Pro
 */

/**
 * Abstract class to manage the export of metas.
 *
 * @since 3.3
 */
abstract class PLL_Export_Metas {
	/**
	 * Meta type. Typically 'post' or 'term' and must be filled by the child class.
	 *
	 * @var string
	 */
	protected $meta_type;

	/**
	 * Import/Export meta type. {@see PLL_Import_Export::POST_META} or {@see PLL_Import_Export::POST_META} and must be filled by the child class.
	 *
	 * @var string
	 */
	protected $import_export_meta_type;

	/**
	 * Get the meta names to export.
	 *
	 * @since 3.3
	 *
	 * @param int $from ID of the source object.
	 * @param int $to   ID of the target object.
	 * @return array List of custom fields names.
	 */
	protected function get_meta_names_to_export( $from, $to ) {
		/**
		 * Filters the meta names to export.
		 *
		 * @since 3.3
		 *
		 * @param array $keys A recursive array containing nested meta sub keys to translate.
		 *     @example array(
		 *      'meta_to_translate_1' => 1,
		 *      'meta_to_translate_2' => 1,
		 *      'meta_to_translate_3' => array(
		 *        'sub_key_to_translate_1' => 1,
		 *        'sub_key_to_translate_2' => array(
		 *             'sub_sub_key_to_translate_1' => 1,
		 *         ),
		 *        'sub_key_is_an_array_with_all_values_to_translate' => 1,
		 *      ),
		 *    )
		 * @param int $from ID of the source object.
		 * @param int $to   ID of the target object.
		 */
		return (array) apply_filters( "pll_{$this->meta_type}_metas_to_export", array(), $from, $to );
	}

	/**
	 * Export metas to translate, along their translated values if possible.
	 *
	 * @since 3.3
	 *
	 * @param PLL_Export_Multi_Files $export The export file.
	 * @param int                    $from   ID of the source object.
	 * @param int                    $to     ID of the target object.
	 * @return PLL_Export_Multi_Files Export file with corresponding metas added.
	 */
	public function export( $export, $from, $to = 0 ) {
		$meta_names_to_export = $this->get_meta_names_to_export( $from, $to );

		if ( empty( $meta_names_to_export ) ) {
			return $export;
		}

		$source_metas = get_metadata( $this->meta_type, $from );

		if ( empty( $source_metas ) || ! is_array( $source_metas ) ) {
			return $export;
		}

		$tr_metas = get_metadata( $this->meta_type, $to );
		$tr_metas = is_array( $tr_metas ) ? $tr_metas : array();

		foreach ( $meta_names_to_export as $meta_name => $meta_subfield ) {
			if ( empty( $source_metas[ $meta_name ] ) ) {
				// The current meta shouldn't be exported.
				continue;
			}

			$tr_meta_values = isset( $tr_metas[ $meta_name ] ) ? $tr_metas[ $meta_name ] : array();
			$index          = 0;
			foreach ( $source_metas[ $meta_name ] as $value_index => $meta_value ) {
				$meta_value    = is_string( $meta_value ) ? maybe_unserialize( $meta_value ) : $meta_value;
				$meta_subfield = is_array( $meta_subfield ) ? $meta_subfield : array();
				$tr_value      = isset( $tr_meta_values[ $value_index ] ) ? $tr_meta_values[ $value_index ] : array();
				$tr_value      = is_string( $tr_value ) ? maybe_unserialize( $tr_value ) : $tr_value;
				$is_exported   = $this->maybe_export_metas_sub_fields(
					$meta_subfield,
					addcslashes( $meta_name, '\\|' ),
					$index,
					$meta_value,
					$tr_value,
					$export
				);
				if ( $is_exported ) {
					$index++;
				}
			}
		}


		return $export;
	}

	/**
	 * Maybe exports metas sub fields recursively if the given meta values is contained in the fields to export.
	 *
	 * @since 3.3
	 *
	 * @param array                  $fields_to_export  A recursive array containing nested meta sub keys to translate.
	 *     @example array(
	 *        'sub_key_to_translate_1' => 1,
	 *        'sub_key_to_translate_2' => array(
	 *             'sub_sub_key_to_translate_1' => 1,
	 *         ),
	 *      ),
	 *    )
	 * @param string                 $parent_key_string A string containing parent keys separated with pipes. Each pipe
	 *                                                  in key should be escaped to avoid conflicts.
	 * @param int                    $index             Index of the current meta value. Usefull when a meta has several
	 *                                                  values.
	 * @param array|string           $source_metas      The source post metas.
	 * @param array|string           $tr_metas          The translated post metas.
	 * @param PLL_Export_Multi_Files $export            Represents the export file.
	 * @return bool True if the meta value has been exported, false otherwise.
	 */
	protected function maybe_export_metas_sub_fields( array $fields_to_export, $parent_key_string, $index, $source_metas, $tr_metas, PLL_Export_Multi_Files $export ) {
		$is_exported = false;

		if ( ! empty( $fields_to_export ) ) {
			foreach ( $fields_to_export as $key => $field_value ) {
				if ( ! isset( $source_metas[ $key ] ) ) {
					continue;
				}
				$escaped_key = addcslashes( (string) $key, '\\|' );
				$key_string  = "$parent_key_string|$escaped_key";
				$sub_field   = is_array( $field_value ) ? $field_value : array();

				$is_exported = $this->maybe_export_metas_sub_fields(
					$sub_field,
					$key_string,
					$index,
					$source_metas[ $key ],
					isset( $tr_metas[ $key ] ) ? $tr_metas[ $key ] : array(),
					$export
				) || $is_exported;
			}

			return $is_exported;
		}

		if ( empty( $source_metas ) ) {
			return false;
		}

		$id_suffix = 0 < $index ? ":{$index}" : '';

		if ( is_string( $source_metas ) ) {
			// Single value to export doesn't require any index.
			$export->add_translation_entry(
				$this->import_export_meta_type,
				$source_metas,
				is_string( $tr_metas ) ? $tr_metas : '',
				array( 'id' => $parent_key_string . $id_suffix )
			);
			return true;
		}

		$tr_metas = (array) $tr_metas;
		foreach ( $source_metas as $sub_field_index => $source_value ) {
			if ( empty( $source_value ) ) {
				continue;
			}
			$escaped_key = addcslashes( (string) $sub_field_index, '\\|' );
			$tr_values   = isset( $tr_metas[ $sub_field_index ] ) ? $tr_metas[ $sub_field_index ] : '';
			$export->add_translation_entry(
				$this->import_export_meta_type,
				$source_value,
				$tr_values,
				array( 'id' => $parent_key_string . '|' . $escaped_key . $id_suffix )
			);
			$is_exported = true;
		}

		return $is_exported;
	}
}
