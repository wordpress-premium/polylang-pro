<?php
/**
 * @package Polylang-Pro
 *
 * @since 3.1
 */

/**
 * Xliff file, generated from exporting Polylang translations
 *
 * Use set_source_reference before settings adding translations entries for that reference
 *
 * @since 2.7
 */
class PLL_Xliff_Export extends PLL_Export_File {

	/**
	 * @var DOMAttr
	 */
	protected $source_language;

	/**
	 * @var DOMAttr
	 */
	protected $target_language;

	/**
	 * The root element of the XML tree.
	 *
	 * @var DOMDocument The root element of the XML tree
	 */
	private $document;

	/**
	 * The file element in the XML tree.
	 *
	 * @var DOMElement The <file> element in the XML tree
	 */
	private $file;

	/**
	 * The body element in the Xliff structure, this is where groups of translation are added
	 *
	 * @var DOMElement
	 */
	private $body;

	/**
	 * This represents the different sources that can be added into an export
	 *
	 * @var DOMElement[]
	 */
	private $translation_groups = array();


	/**
	 * Each group will reference a source
	 *
	 * @var DOMElement A group of translations pertaining to the same WP data object.
	 */
	private $current_group;

	/**
	 * Holds the reference towards each of the translations units, mainly for counting their number
	 *
	 * @var DOMElement[]
	 */
	private $translation_units = array();

	/**
	 * Declares xml version
	 *
	 * @since 3.1
	 *
	 * Creates the root element for the document
	 *
	 * @return void
	 */
	public function __construct() {
		$this->document = new DOMDocument( '1.0', 'UTF-8' );

		$xliff = $this->add_child_element(
			$this->document,
			'xliff',
			array(
				'version' => '1.2',
				'xmlns'   => 'urn:oasis:names:tc:xliff:document:1.2',
			)
		);

		$this->file = $this->add_child_element(
			$xliff,
			'file',
			array(
				'datatype' => 'plaintext',
			)
		);

		$this->file->setAttribute( 'original', get_site_url() );
		$this->file->setAttribute( 'product-name', PLL_Import_Export::APP_NAME );
		$this->file->setAttribute( 'product-version', POLYLANG_VERSION );

		$this->body = $this->add_child_element( $this->file, 'body' );
	}

	/**
	 * Helper function to insert new elements in our DOMDocument
	 *
	 * @since 3.1
	 *
	 * @see https://www.php.net/manual/fr/domdocument.createcdatasection.php
	 *
	 * @param DOMNode $parent     Could be a DOMDocument or a DOMElement.
	 * @param string  $tag_name   Name of the attribute to set.
	 * @param array   $attributes {
	 *   Optional attributes.
	 *
	 *   @type string $name  The name of an attribute to set
	 *   @type string $value The value to set the attribute to
	 * }
	 * @param string  $content    Optional. Could specify some text content to insert into the new node
	 *                            /!\ This works only for text content, CDATA section has to be created with DOMDocument::createCDATASection() and appended.
	 * @return DOMElement         The newly created DOMElement
	 */
	private function add_child_element( $parent, $tag_name, $attributes = array(), $content = '' ) {
		$new_element = $this->document->createElement( $tag_name, $content );

		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $name => $value ) {
				$new_element->setAttribute( $name, $value );
			}
		}

		$parent->appendChild( $new_element );

		return $new_element;
	}

	/**
	 * Set a source language to the file
	 *
	 * @since 3.1
	 *
	 * @param string $source_language A valid W3C locale.
	 */
	public function set_source_language( $source_language ) {
		$this->source_language = $this->file->setAttribute( 'source-language', $source_language );
	}

	/**
	 * Retrieves the file's source language
	 *
	 * @since 3.1
	 *
	 * @return string A language locale.
	 */
	public function get_source_language() {
		return $this->source_language->textContent;
	}

	/**
	 * Set one target languages to the file
	 *
	 * @since 3.1
	 *
	 * @param string $target_language A valid W3C locale.
	 */
	public function set_target_language( $target_language ) {
		$this->target_language = $this->file->setAttribute( 'target-language', $target_language );
	}

	/**
	 * Retrieves the file's target language
	 *
	 * @since 3.1
	 *
	 * @return string A language locales.
	 */
	public function get_target_language() {
		return $this->target_language->textContent;
	}

	/**
	 * Add a translation unit to the current translation group
	 *
	 * @since 3.1
	 *
	 * First verifies that the passed parameter are correct.
	 *
	 * @throws LogicException If no source object is referenced before hand, @see PLL_Xliff_Export::set_source_reference() .
	 * @throws InvalidArgumentException If no source data is passed to the function, it cannot translate anything.
	 * @param string $type Additional info to help the translation.
	 * @param string $source Translation source.
	 * @param string $target Translation target.
	 * @param array  $args Extra data for the context.
	 * @return DOMElement The trans-unit node created
	 */
	public function add_translation_entry( $type, $source, $target = '', $args = array() ) {
		if ( null === $this->current_group ) {
			throw new LogicException( 'A source material needs to be referenced before adding translations.' );
		}

		if ( empty( $source ) ) {
			throw new InvalidArgumentException( 'A source translation should be provided in order to be exported.' );
		}

		if ( empty( $type ) ) {
			throw new InvalidArgumentException( 'A type of content should be defined in order to be exported.' );
		}

		$translation_unit_tag = $this->document->createElement( 'trans-unit' );
		$translation_unit_tag->setAttribute( 'id', strval( count( $this->translation_units ) ) );
		$this->current_group->appendChild( $translation_unit_tag );
		$this->translation_units[] = $translation_unit_tag;

		$translation_source_tag = $this->document->createElement( 'source' );
		$translation_unit_tag->appendChild( $translation_source_tag );

		$translation_target_tag = $this->document->createElement( 'target' );
		$translation_unit_tag->appendChild( $translation_target_tag );

		$translation_unit_tag->setAttribute( 'restype', 'x-' . $type );
		if ( isset( $args['id'] ) ) {
			$translation_unit_tag->setAttribute( 'resname', $args['id'] );
		}

		$translation_source_tag->appendChild( $this->document->createCDATASection( $source ) );
		if ( $target ) {
			$translation_target_tag->appendChild( $this->document->createCDATASection( $target ) );
		}

		return $translation_unit_tag;
	}

	/**
	 * Assign a reference to the resource used to create the translation group
	 *
	 * @since 3.1
	 *
	 * A new translation group is then created each time this function is called
	 *
	 * @throws InvalidArgumentException Exception.
	 * @param string $type The type of WordPress objects used.
	 * @param string $id (optional) An id used to identify the object / row in database.
	 * @return void
	 */
	public function set_source_reference( $type, $id = '' ) {
		$group_name = $type . ( empty( $id ) ? '' : '_' . $id );
		if ( array_key_exists( $group_name, $this->translation_groups ) ) {
			throw new InvalidArgumentException( 'A translation export file should not reference the same source twice.' );
		}

		$this->current_group = $this->document->createElement( 'group' );
		$this->current_group->setAttribute( 'resname', $id );
		$this->current_group->setAttribute( 'restype', 'x-' . $type );

		$this->translation_groups[ $group_name ] = $this->current_group;
		$this->body->appendChild( $this->current_group );
	}

	/**
	 * Writes the document into a file
	 *
	 * @since 3.1
	 *
	 * @throws Exception When no document has previously been created, throws an exception.
	 * @return string|false An XML formatted string.
	 */
	public function export() {
		$this->document->preserveWhiteSpace = false;
		$this->document->formatOutput = true;
		return $this->document->saveXML( null, LIBXML_NOEMPTYTAG );
	}

	/**
	 * @since 3.1
	 *
	 * @return string
	 */
	public function get_extension() {
		return 'xliff';
	}
}
