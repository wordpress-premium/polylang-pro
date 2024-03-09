<?php
/**
 * @package Polylang-Pro
 */

/**
 * Handles the logic for generating translations files and assigning values to those.
 *
 * @since 2.7
 */
class PLL_Export_Multi_Files implements Iterator {
	/**
	 * Contains all the different files to export
	 *
	 * Each file is referenced with a key composed of its source and target languages
	 *
	 * @var array Associative array of PLL_Export_File_Interface
	 */
	private $export_files = array();

	/**
	 * Contains the names of the different files to export.
	 *
	 * FIXME: This only serves to know if a file for a certain source and target language pair exists. This could if we choose to name export files for any reason.
	 *
	 * @var string[]
	 */
	private $export_filenames;

	/**
	 * Index of the PLL_Export_File_Interface instance being currently processed. This instance is stored in {@see PLL_Export_Multi_Files::$export_files}.
	 *
	 * @var int
	 */
	private $current_index;

	/**
	 * The export file currently in use to add translations into.
	 *
	 * @var PLL_Export_File_Interface
	 */
	private $current_file;

	/**
	 * The selected language to be the source for the translation.
	 *
	 * @var string
	 */
	private $source_language;

	/**
	 * An instance of the class defining an individual export file.
	 *
	 * FIXME: At this point, only the class matters, as a new instance will be generated for each new target language, {@see PLL_Export_Multi_Files::set_target_language()}.
	 *
	 * @var PLL_Export_File_Interface
	 */
	private $base_instance;

	/**
	 * Constructor.
	 *
	 * @since 2.7
	 *
	 * @param PLL_Export_File_Interface $base_instance An instance of the class that defines an individual export file.
	 */
	public function __construct( $base_instance ) {
		$this->base_instance = $base_instance;
		$this->current_index = 0;
	}

	/**
	 * Set the current file source language
	 *
	 * @since 2.7
	 *
	 * @param string $source_language A language locale formatted string.
	 * @return void
	 */
	public function set_source_language( $source_language ) {
		$this->source_language = $source_language;
	}

	/**
	 * Set the target language for the current file
	 *
	 * If an export with a matching target language already exists, use this export instead.
	 *
	 * @since 2.7
	 *
	 * @param string $target_language A language locale formatted string.
	 * @return void
	 */
	public function set_target_language( $target_language ) {
		$file_key = $this->source_language . '-' . $target_language;
		if ( array_key_exists( $file_key, $this->export_files ) ) {
			$this->current_file = $this->export_files[ $file_key ];
			$current_index = array_search( $file_key, $this->export_filenames );
			if ( false !== $current_index ) {
				$this->current_index = (int) $current_index;
			}
		} else {
			$class_name = get_class( $this->base_instance );
			$this->current_file = new $class_name();
			$this->export_files[ $file_key ] = $this->current_file;
			$this->export_filenames[] = $file_key;
			$this->current_file->set_source_language( $this->source_language );
		}
		$this->current_file->set_target_language( $target_language );
	}

	/**
	 * Add a translation source and target to the current translation file.
	 *
	 * @since 2.7
	 *
	 * @param string $type   Describe what does this data corresponds to, such as a post title, a meta reference etc...
	 * @param string $source The source to be translated.
	 * @param string $target Optional, a preexisting translation, if any.
	 * @param array  $args   Optional, an array of additional arguments, like an identifier for the string, its context, comments for translators, etc.
	 * @return void
	 */
	public function add_translation_entry( $type, $source, $target = '', $args = array() ) {
		$this->current_file->add_translation_entry( $type, $source, $target, $args );
	}

	/**
	 * Adds a reference to a source of translations entries.
	 *
	 * @since 2.7
	 *
	 * @param string $type Type of data to be exported.
	 * @param string $id   Optional, a unique identifier to retrieve the data in the database.
	 * @return void
	 */
	public function set_source_reference( $type, $id = '' ) {
		$this->current_file->set_source_reference( $type, $id );
	}

	/**
	 * Returns the content of the file
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	public function export() {
		return $this->current_file->export();
	}

	/**
	 * From {@see Iterator}. Returns the current instance of the export file abstraction.
	 *
	 * @since 2.7
	 *
	 * @return PLL_Export_File_Interface
	 */
	#[\ReturnTypeWillChange]
	public function current() {
		return $this->export_files[ $this->export_filenames[ $this->current_index ] ];
	}

	/**
	 *
	 * From {@see Iterator}.
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	public function next() {
		$this->current_index++;
	}

	/**
	 *
	 * From {@see Iterator}.
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	#[\ReturnTypeWillChange]
	public function key() {
		return $this->export_filenames[ $this->current_index ];
	}

	/**
	 * From {@see Iterator}.
	 *
	 * @since 2.7
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function valid() {
		return $this->current_index >= 0 && $this->current_index < count( $this->export_files );
	}

	/**
	 * From {@see Iterator}
	 *
	 * @since 2.7
	 *
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	public function rewind() {
		$this->current_index = 0;
		$this->current_file = $this->export_files[ $this->export_filenames[0] ];
	}
}
