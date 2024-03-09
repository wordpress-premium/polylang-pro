<?php
/**
 * @package Polylang-Pro
 *
 * @since 3.1
 */

/**
 * Class PLL_Import_Xliff_Iterator
 *
 * @since 3.1
 */
class PLL_Import_Xliff_Iterator implements RecursiveIterator {

	/**
	 * The node.
	 *
	 * @var DOMNodeList.
	 */
	private $nodes;

	/**
	 * The offset.
	 *
	 * @var int.
	 */
	private $offset = 0;

	/**
	 * PLL_Import_Xliff_Iterator constructor.
	 *
	 * @since 3.1
	 *
	 * @param DOMNodeList $nodes Nodes.
	 */
	public function __construct( $nodes ) {
		$this->nodes = $nodes;
	}

	/**
	 * Replace the cursor at position 0.
	 *
	 * @since 3.1
	 *
	 * @return int|void offset.
	 */
	#[\ReturnTypeWillChange]
	public function rewind() {
		$this->offset = 0;
		return $this->offset;
	}

	/**
	 * Get the current element.
	 *
	 * @since 3.1
	 *
	 * @return DOMNode|null
	 */
	#[\ReturnTypeWillChange]
	public function current() {
		return $this->nodes->item( $this->offset );
	}

	/**
	 * Get the key.
	 *
	 * @since 3.1
	 *
	 * @return mixed|string
	 */
	#[\ReturnTypeWillChange]
	public function key() {
		if ( $this->current() ) {
			return $this->current()->nodeName;
		}
		return '';
	}

	/**
	 * Place the cursor to the next element.
	 *
	 * @since 3.1
	 *
	 * @return int|void
	 */
	#[\ReturnTypeWillChange]
	public function next() {
		return $this->offset++;
	}

	/**
	 * Check the node validity.
	 *
	 * @since 3.1
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function valid() {
		return $this->offset < $this->nodes->length;
	}

	/**
	 * Check if the node has children.
	 *
	 * @since 3.1
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function hasChildren() {
		return isset( $this->current()->childNodes->length ) && $this->current()->childNodes->length > 0;
	}

	/**
	 * Get the node's children
	 *
	 * @since 3.1
	 *
	 * @return RecursiveIterator
	 */
	#[\ReturnTypeWillChange]
	public function getChildren() {
		if ( $this->current() ) {
			return new self( $this->current()->childNodes );
		}
		return new self( new DOMNodeList() );
	}
}
