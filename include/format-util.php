<?php
/**
 * @package Polylang
 */

/**
 * A class to match values against a given format.
 *
 * @since 3.6
 */
class PLL_Format_Util {
	/**
	 * Cache for regex patterns.
	 * Useful when using `filter_list()` for example.
	 *
	 * @var string[] Formats as array keys, patterns as array values.
	 *
	 * @phpstan-var array<non-empty-string, non-empty-string>
	 */
	private $patterns = array();

	/**
	 * Filters the given list to return only the values whose the key or value matches the given format.
	 *
	 * @since 3.6
	 *
	 * @param array|Traversable $list   An list with keys or values to match against `$format`.
	 * @param string            $format A format, where `*` means "any characters" (`.*`), unless escaped.
	 * @param string            $mode   Optional. Tell if we should filter the keys or values from `$list`.
	 *                                  Possible values are `'use_keys'` and `'use_values'`. Default is `'use_keys'`.
	 * @return array
	 *
	 * @template TArrayValue
	 * @phpstan-param ($mode is 'use_keys' ? array<string, TArrayValue>|Traversable<string, TArrayValue> : array<string>|Traversable<string>) $list
	 * @phpstan-param 'use_keys'|'values' $mode
	 * @phpstan-return ($mode is 'use_keys' ? array<string, TArrayValue> : array<string>)
	 */
	public function filter_list( $list, string $format, string $mode = 'use_keys' ): array {
		$filter = function ( $key ) use ( $format ) {
			return $this->matches( (string) $key, $format );
		};

		if ( ! is_array( $list ) ) {
			$list = iterator_to_array( $list );
		}

		if ( 'use_values' === $mode ) {
			return array_filter( $list, $filter );
		}

		return array_filter( $list, $filter, ARRAY_FILTER_USE_KEY );
	}

	/**
	 * Tells if the given string matches the given format.
	 *
	 * @since 3.6
	 *
	 * @param string $key    A string to test.
	 * @param string $format A format, where `*` means "any characters" (`.*`), unless escaped.
	 * @return bool
	 */
	public function matches( string $key, string $format ): bool {
		if ( strpos( $format, '*' ) === false ) {
			return $key === $format;
		}

		if ( '*' === $format ) {
			return true;
		}

		if ( empty( $this->patterns[ $format ] ) ) {
			$pattern = addcslashes( $format, '.+?[^]$(){}=!<>|:-#/' ); // Escape regular expression characters (list from `preg_quote()` but `*` and `\` are ignored).
			$pattern = preg_replace(
				array(
					'/\\\(?!\*)/', // Escape `\` characters except if followed by `*`.
					'/(?<!\\\)\*/', // Replace `*` characters by `.*` except if preceded by `\`.
				),
				array( '\\', '.*' ),
				$pattern
			);

			if ( empty( $pattern ) ) {
				// Error.
				return false;
			}

			$this->patterns[ $format ] = $pattern;
		} else {
			$pattern = $this->patterns[ $format ];
		}

		return (bool) preg_match( "/^{$pattern}$/", $key );
	}
}
