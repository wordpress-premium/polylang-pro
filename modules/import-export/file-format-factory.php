<?php
/**
 * @package Polylang-Pro
 */

/**
 * Class PLL_File_Format_Factory
 *
 * @since 3.1
 *
 * Generates file formats to use for the import / export feature.
 */
class PLL_File_Format_Factory {
	/**
	 * Names of child classes of {@see PLL_File_Format}.
	 *
	 * @var string[]
	 */
	protected $base_formats = array(
		PLL_PO_Format::class,
		PLL_Xliff_Format::class,
	);

	/**
	 * Cache the supported file formats.
	 *
	 * @var PLL_File_Format[]
	 */
	protected $supported_formats = array();

	/**
	 * Returns all the formats supported by the environment.
	 *
	 * @since 3.1
	 *
	 * @return PLL_File_Format[]
	 */
	public function get_supported_formats() {
		if ( empty( $this->supported_formats ) ) {
			$this->supported_formats = array_filter(
				array_map(
					function( $class ) {
						return new $class();
					},
					$this->base_formats
				),
				function( $format ) {
					return true === $format->is_supported();
				}
			);
		}
		return $this->supported_formats;
	}

	/**
	 * Get the format that matches the given extension.
	 *
	 * @since 3.1
	 *
	 * @param string $extension The extension of the file format to retrieve.
	 * @return PLL_File_Format|WP_Error
	 */
	public function from_extension( $extension ) {
		return $this->from( 'extension', $extension );
	}

	/**
	 * Get the format that matches the given mime type.
	 *
	 * @since 3.1
	 *
	 * @param string $mime_type The mime type of the file format to retrieve.
	 * @return PLL_File_Format|WP_Error
	 */
	public function from_mime_type( $mime_type ) {
		return $this->from( 'mime_type', $mime_type );
	}

	/**
	 * Matches a supported format to a given property name and value. Internal use.
	 *
	 * @since 3.1
	 *
	 * @param string $property Property of the {@see PLL_File_Format} class to compare.
	 * @param string $value    Expected value of the selected property.
	 * @return PLL_File_Format|WP_Error
	 */
	protected function from( $property, $value ) {
		$supported_formats = $this->get_supported_formats();
		$matching_formats = array_values(
			array_filter(
				$supported_formats,
				function ( $format ) use ( $property, $value ) {
					return $format->$property === $value;
				}
			)
		);

		if ( count( $matching_formats ) > 0 ) {
			return $matching_formats[0];
		}

		$formats = array_map( 'strtoupper', wp_list_pluck( $supported_formats, 'extension' ) );
		$list = wp_sprintf_l( '%l', $formats );

		if ( count( $supported_formats ) === 1 ) {
			/* translators: %s is a file format, for example PO */
			$message = sprintf( esc_html__( 'Error: Wrong file format. The only supported file format is %s.', 'polylang-pro' ), $list );
		} else {
			/* translators: %s is a suite of comma separate file formats, for example: PO, XLIFF */
			$message = sprintf( esc_html__( 'Error: Wrong file format. The supported file formats are: %s.', 'polylang-pro' ), $list );
		}

		return new WP_Error( 'pll_import_wrong_format', $message );
	}
}
