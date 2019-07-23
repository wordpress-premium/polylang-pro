<?php

/**
 * A class to manage the Polylang Pro text domain and license key
 * Formerly managed in Polylang_Pro class
 *
 * @since 2.6
 */
class PLL_Pro {
	/**
	 * Constructor
	 *
	 * @since 2.6
	 */
	public function __construct() {
		load_plugin_textdomain( 'polylang-pro', false, basename( POLYLANG_DIR ) . '/languages' );
		new PLL_License( POLYLANG_FILE, 'Polylang Pro', POLYLANG_VERSION, 'WP SYNTEX' );
		new PLL_T15S( 'polylang-pro', 'https://s3.eu-central-1.amazonaws.com/api.translationspress.com/wp-syntex/polylang-pro/polylang-pro.json' );

		// Download Polylang language packs.
		add_filter( 'http_request_args', array( $this, 'http_request_args' ), 10, 2 );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'pre_set_site_transient_update_plugins' ) );
	}

	/**
	 * Hack to download Polylang languages packs
	 *
	 * @since 1.9
	 *
	 * @param array  $args HTTP request args.
	 * @param string $url  The url of the request.
	 * @return array
	 */
	public function http_request_args( $args, $url ) {
		if ( false !== strpos( $url, '//api.wordpress.org/plugins/update-check/' ) ) {
			$plugins = (array) json_decode( $args['body']['plugins'], true );
			if ( empty( $plugins['plugins']['polylang/polylang.php'] ) ) {
				$plugins['plugins']['polylang/polylang.php'] = array( 'Version' => POLYLANG_VERSION );
				$args['body']['plugins'] = wp_json_encode( $plugins );
			}
		}
		return $args;
	}

	/**
	 * Remove Polylang from the list of plugins to update if it is not installed
	 *
	 * @since 2.1.1
	 *
	 * @param array $value The value stored in the update_plugins site transient.
	 * @return array
	 */
	public function pre_set_site_transient_update_plugins( $value ) {
		$plugins = get_plugins();
		if ( isset( $value->response ) ) {
			if ( empty( $plugins['polylang/polylang.php'] ) ) {
				unset( $value->response['polylang/polylang.php'] );
			} elseif ( isset( $value->response['polylang/polylang.php']->new_version ) && $plugins['polylang/polylang.php']['Version'] == $value->response['polylang/polylang.php']->new_version ) {
				$value->no_update['polylang/polylang.php'] = $value->response['polylang/polylang.php'];
				unset( $value->response['polylang/polylang.php'] );
			}
		}
		return $value;
	}
}
