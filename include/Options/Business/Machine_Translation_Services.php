<?php
/**
 * @package Polylang
 */

namespace WP_Syntex\Polylang_Pro\Options\Business;

use WP_Syntex\Polylang\Options\Abstract_Option;
use WP_Syntex\Polylang_Pro\Modules\Machine_Translation\Factory;

defined( 'ABSPATH' ) || exit;

/**
 * Class defining machine translation services array option.
 *
 * @since 3.7
 */
class Machine_Translation_Services extends Abstract_Option {
	/**
	 * Returns option key.
	 *
	 * @since 3.7
	 *
	 * @return string
	 *
	 * @phpstan-return 'machine_translation_services'
	 */
	public static function key(): string {
		return 'machine_translation_services';
	}

	/**
	 * Returns the default value.
	 *
	 * @since 3.7
	 *
	 * @return array
	 */
	protected function get_default() {
		$services = array();

		foreach ( Factory::get_classnames() as $service ) {
			$services[ $service::get_slug() ] = array();
		}

		return $services;
	}

	/**
	 * Returns the JSON schema part specific to this option.
	 *
	 * @since 3.7
	 *
	 * @return array Partial schema.
	 *
	 * @phpstan-return array{
	 *     type: 'object',
	 *     properties: array<
	 *         non-falsy-string,
	 *         array{
	 *             type: 'object',
	 *             properties: array,
	 *             additionalProperties: false
	 *         }
	 *     >,
	 *     additionalProperties: false
	 * }
	 */
	protected function get_data_structure(): array {
		$structure = array(
			'type'                 => 'object', // Correspond to associative array in PHP, @see{https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#primitive-types}.
			'properties'           => array(),
			'additionalProperties' => false,
		);

		foreach ( Factory::get_classnames() as $service ) {
			$structure['properties'][ $service::get_slug() ] = array(
				'type'                 => 'object',
				'properties'           => $service::get_option_schema(),
				'additionalProperties' => false,
			);
		}

		return $structure;
	}

	/**
	 * Returns the description used in the JSON schema.
	 *
	 * @since 3.7
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Settings for machine translation services: DeepL\'s API key and formality for now.', 'polylang-pro' );
	}
}
