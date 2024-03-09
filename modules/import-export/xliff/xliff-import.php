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
class PLL_Xliff_Import implements PLL_Import_File_Interface {
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
	 * The imported file name.
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * An array of XLIFF iterators.
	 *
	 * @var PLL_Import_Xliff_Iterator[]
	 */
	private $iterators = array();

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
				'pll_import_error',
				esc_html__( 'Your PHP installation appears to be missing the libxml extension which is required by the importer.', 'polylang-pro' )
			);
		}

		$this->filename = $filename;
		$this->ns = 'urn:oasis:names:tc:xliff:document:1.2';

		// phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$file_contents = file_get_contents( $this->filename );
		if ( false === $file_contents ) {
			return new WP_Error(
				'pll_import_error',
				esc_html__( 'Something went wrong during the file import.', 'polylang-pro' )
			);
		}

		$document = PLL_DOM_Document::from_xml( $file_contents );
		if ( $document->has_errors() || ! $this->parse_xml( $document ) ) {
			return new WP_Error(
				'pll_import_error',
				esc_html__( 'An error occurred during the import, please make sure your file is correctly formatted.', 'polylang-pro' )
			);
		}

		return true;
	}

	/**
	 * Parses an XML response body.
	 *
	 * @since 3.1
	 *
	 * @param DOMDocument $document A HTML document parsed by PHP DOMDocument.
	 * @return bool True if no problem occurs during the parsing, false otherwise.
	 */
	private function parse_xml( $document ) {

		$this->xpath = new DOMXPath( $document );
		$this->xpath->registerNamespace( 'ns', $this->ns );

		$types = array(
			PLL_Import_Export::TYPE_TERM,
			PLL_Import_Export::TYPE_POST,
			PLL_Import_Export::STRINGS_TRANSLATIONS,
		);

		foreach ( $types as $type ) {
			$item = $this->xpath->query( '//ns:group[@restype="x-' . $type . '"]' );
			if ( ! empty( $item ) && $item->length ) {
				$this->iterators[ $type ] = new PLL_Import_Xliff_Iterator( $item );
			}
		}

		return (bool) array_filter( $this->iterators );
	}

	/**
	 * Get target language
	 *
	 * @since 3.1
	 *
	 * @return string|false
	 */
	public function get_target_language() {
		$target_lang_list = $this->xpath->query( '//ns:file/@target-language' );
		if ( ! $target_lang_list ) {
			return false;
		}

		$target_lang = $target_lang_list->item( 0 );
		if ( ! $target_lang ) {
			return false;
		}

		if ( ! $target_lang->nodeValue ) {
			return false;
		}
		return $target_lang->nodeValue;
	}

	/**
	 * Get site reference
	 *
	 * @since 3.1
	 *
	 * @return string|false
	 */
	public function get_site_reference() {
		$site_reference_list = $this->xpath->query( '//ns:file/@original' );
		if ( ! $site_reference_list ) {
			return false;
		}

		$site_reference_item = $site_reference_list->item( 0 );
		if ( ! $site_reference_item ) {
			return false;
		}

		$site_reference = $site_reference_item->nodeValue;
		if ( ! $site_reference ) {
			return false;
		}

		// Backward compatibility with Polylang Pro < 3.3.
		$compat_reference = preg_replace( '/^\s*polylang\|/', '', $site_reference );

		return is_string( $compat_reference ) ? $compat_reference : $site_reference;
	}

	/**
	 * Returns the reference to the name of the application that generated the file.
	 *
	 * @since 3.3
	 *
	 * @return string The application name. An empty string if it couldn't be found.
	 */
	public function get_generator_name() {
		$product_names = $this->xpath->query( '//ns:file/@product-name' );

		if ( empty( $product_names ) ) {
			return $this->get_compat_generator_name();
		}

		$product_name = $product_names->item( 0 );

		if ( empty( $product_name ) ) {
			return $this->get_compat_generator_name();
		}

		$product_name = $product_name->nodeValue;
		$product_name = is_string( $product_name ) ? trim( $product_name ) : '';

		if ( empty( $product_name ) ) {
			return $this->get_compat_generator_name();
		}

		return $product_name;
	}

	/**
	 * Returns the reference to the version of the application that generated the file.
	 *
	 * @since 3.3
	 *
	 * @return string The application version. An empty string if it couldn't be found or the name of the application.
	 *                couldn't be found.
	 */
	public function get_generator_version() {
		$product_versions = $this->xpath->query( '//ns:file/@product-version' );

		if ( empty( $product_versions ) ) {
			return '';
		}

		$product_version = $product_versions->item( 0 );

		if ( empty( $product_version ) ) {
			return '';
		}

		return is_string( $product_version->nodeValue ) ? trim( $product_version->nodeValue ) : '';
	}

	/**
	 * Get the next term, post or string translations to import.
	 *
	 * @since 3.1
	 *
	 * @return array {
	 *     string       $type Either 'post', 'term' or 'string_translations'
	 *     int          $id   Id of the object in the database (if applicable)
	 *     Translations $data Objects holding all the retrieved Translations
	 * }
	 */
	public function get_next_entry() {
		if ( empty( $this->iterators ) ) {
			return array();
		}

		foreach ( $this->iterators as $iterator_type => $iterator ) {
			if ( $iterator->valid() ) {
				$item = $iterator->current();
				if ( empty( $item ) ) {
					return array();
				}

				$iterator->next();
				return $this->create_translation_entry( $item, $iterator_type );
			}
		}

		return array();
	}

	/**
	 * Creates the translation entry object.
	 * And then returns it in an array with additional data.
	 *
	 * @since 3.3
	 *
	 * @param DOMNode $item The current element.
	 * @param string  $type The object type.
	 * @return array {
	 *     string       $type Either 'post', 'term' or 'string_translations'
	 *     int          $id   Id of the object in the database (if applicable)
	 *     Translations $data Objects holding all the retrieved Translations
	 * }
	 */
	private function create_translation_entry( $item, $type ) {
		$translations = new PLL_Translations_Identified();

		if ( ! $item instanceof DOMElement ) {
			return array();
		}

		foreach ( $item->childNodes as $trans_unit ) {
			if ( ! $trans_unit instanceof DOMElement || 'trans-unit' !== $trans_unit->nodeName ) {
				continue;
			}

			$entry = array(
				'context' => null,
			);

			$entry['context'] = trim( $trans_unit->getAttribute( 'restype' ), 'x-' );
			if ( $trans_unit->hasAttribute( 'resname' ) ) {
				$entry['id'] = $trans_unit->getAttribute( 'resname' );
			}

			foreach ( $trans_unit->childNodes as $node ) {
				if ( ! $node instanceof DOMElement || empty( $node->nodeValue ) ) {
					continue;
				}

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
			'id'   => (int) $item->getAttribute( 'resname' ),
			'data' => $translations,
		);
	}

	/**
	 * Returns the reference to the name of the application that generated the file (back
	 * compatibility).
	 * Before PLL Pro 3.3, the `original` attribute was storing "polylang|{site_url}".
	 *
	 * @since 3.3
	 *
	 * @return string 'Polylang' or an empty string.
	 */
	private function get_compat_generator_name() {
		$site_references = $this->xpath->query( '//ns:file/@original' );

		if ( empty( $site_references ) ) {
			return '';
		}

		$site_reference = $site_references->item( 0 );

		if ( empty( $site_reference ) ) {
			return '';
		}

		$site_reference = $site_reference->nodeValue;
		$site_reference = is_string( $site_reference ) ? trim( $site_reference ) : '';

		if ( empty( $site_reference ) || ! preg_match( '/^\s*polylang\|/', $site_reference ) ) {
			return '';
		}

		return PLL_Import_Export::APP_NAME;
	}
}
