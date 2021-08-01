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
	private $offset;

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
	public function rewind() {
		$this->offset = 0;
		return $this->offset;
	}

	/**
	 * Get the current element.
	 *
	 * @since 3.1
	 *
	 * @return DOMNode|mixed|null
	 */
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
	public function key() {
		return $this->current()->nodeName;
	}

	/**
	 * Place the cursor to the next element.
	 *
	 * @since 3.1
	 *
	 * @return int|void
	 */
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
	public function getChildren() {
		return new self( $this->current()->childNodes );
	}
}
