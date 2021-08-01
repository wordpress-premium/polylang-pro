<?php
/**
 * @package Polylang-Pro
 *
 * @since 3.1
 */

/**
 * Class PLL_Xliff_Import
 *
 * @since 3.1
 *
 * This class uses PHP built in DOMDocument.
 *
 * @link https://www.php.net/manual/en/book.dom.php
 * @uses libxml
 */
class PLL_Xliff_Import extends PLL_Import_File {
	/**
	 * The Xpath object.
	 *
	 * @var DOMXPath The Xpath object.
	 */
	private $xpath;

	/**
	 * The XML namespace.
	 *
	 * @var string Namespace of the XML file.
	 */
	private $ns;

	/**
	 * The node list.
	 *
	 * @var PLL_Import_Xliff_Iterator
	 */
	private $string_translation_iterator;

	/**
	 * The imported file name.
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Imports translations from a file.
	 *
	 * @since 3.1
	 *
	 * @param string $filename The file's name.
	 *
	 * @return WP_Error|true True if no problem occurs during file import.
	 */
	public function import_from_file( $filename ) {

		if ( ! extension_loaded( 'libxml' ) ) {
			return new WP_Error(
				'pll_import_libxml_missing',
				esc_html__( 'Your PHP installation appears to be missing the libxml extension which is required by the importer.', 'polylang-pro' )
			);
		}

		$this->filename = $filename;
		$this->ns = 'urn:oasis:names:tc:xliff:document:1.2';

		// phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$file_contents = file_get_contents( $this->filename );
		if ( false === $file_contents ) {
			return new WP_Error(
				'pll_import_failed',
				esc_html__( 'Something went wrong during the file import.', 'polylang-pro' )
			);
		}

		$document = PLL_DOM_Document::from_xml( $file_contents );

		if ( $document->has_errors() ) {
			return new WP_Error(
				'pll_import_xml_parsing_errors',
				esc_html__( 'An error occurred during the import, please make sure your file is correctly formatted.', 'polylang-pro' )
			);
		} else {
			$this->parse_xml( $document );
			return true;
		}
	}

	/**
	 * Parses an XML response body.
	 *
	 * @since 3.1
	 *
	 * @param DOMDocument $document A HTML document parsed by PHP DOMDocument.
	 * @return void
	 */
	private function parse_xml( $document ) {

		$this->xpath = new DOMXPath( $document );
		$this->xpath->registerNamespace( 'ns', $this->ns );

		$strings_translation = $this->xpath->query( '//ns:group[@restype="x-strings-translations"]' );
		$this->string_translation_iterator = new PLL_Import_Xliff_Iterator( $strings_translation );

	}

	/**
	 * Get the language of the source
	 *
	 * @since 3.1
	 *
	 * @return string
	 */
	public function get_source_language() {
		$source_lang = $this->xpath->query( '//ns:file/@source-language' );
		return $source_lang->item( 0 )->nodeValue;
	}

	/**
	 * Get target language
	 *
	 * @since 3.1
	 *
	 * @return string
	 */
	public function get_target_language() {
		$target_lang = $this->xpath->query( '//ns:file/@target-language' );
		return $target_lang->item( 0 )->nodeValue;
	}

	/**
	 * Get site reference
	 *
	 * @since 3.1
	 *
	 * @return string|false
	 */
	public function get_site_reference() {
		$site_reference = $this->xpath->query( '//ns:file/@original' );
		$site_reference = $site_reference->item( 0 )->nodeValue;
		preg_match( '/polylang\|(.*?)$/', $site_reference, $matches );
		if ( isset( $matches[1] ) ) {
			return $matches[1];
		}
		return false;
	}

	/**
	 * Get the next term, post or string translations to import.
	 *
	 * @since 3.1
	 *
	 * @return false|array {
	 *     string       $type Either 'post', 'term' or 'string_translations'
	 *     int          $id   Id of the object in the database (if applicable)
	 *     Translations $data Objects holding all the retrieved Translations
	 * }
	 */
	public function get_next_entry() {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$item = null;
		if ( $this->string_translation_iterator->valid() ) {

			$item = $this->string_translation_iterator->current();
			$type = PLL_Import_Export::STRINGS_TRANSLATIONS;

			$this->string_translation_iterator->next();
		} else {
			return false;

		}

		$translations = new Translations();

		foreach ( $item->childNodes as $trans_unit ) {
			if ( 'trans-unit' !== $trans_unit->nodeName ) {
				continue;
			}

			$entry = array(
				'context' => null,
			);

			$entry['context'] = trim( $trans_unit->getAttribute( 'restype' ), 'x-' );

			foreach ( $trans_unit->childNodes as $node ) {
				if ( 'source' === $node->nodeName ) {
					$entry['singular'] = $node->nodeValue;
				} elseif ( 'target' === $node->nodeName ) {
					$entry['translations'] = array( $node->nodeValue );
				}
			}

			// need entry['id'] where id is the identifier.
			$translations->add_entry( $entry );
		}

		return array(
			'type' => $type,
			'id'   => $item->getAttribute( 'resname' ),
			'data' => $translations,
		);
		//phpcs:enable
	}
}
