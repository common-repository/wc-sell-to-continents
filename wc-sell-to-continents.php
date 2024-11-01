<?php
/**
 * Sell To Continents for WooCommerce
 *
 * @link              https://thedigitalduck.co.uk
 * @since             1.0.1
 * @package           wc_sell_to_continents
 * Plugin Name:       Sell To Continents for WooCommerce
 * Plugin URI:        https://thedigitalduck.co.uk/plugins/wc-sell-to-continents
 * Description:       Adds the ability to effortlessly select all countries within a continent to sell or ship to.
 * Version:           1.0.1
 * Author:            Digital Duck
 * Author URI:        https://thedigitalduck.co.uk
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wc_sell_to_continents
 *
 * WC requires at least: 3.0
 * WC tested up to: 4.4.1
 */

defined( 'ABSPATH' ) || exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	if ( ! defined( 'WCSTC_PLUGIN_FILE' ) ) {
		define( 'WCSTC_PLUGIN_FILE', __FILE__ );
	}

	if ( ! class_exists( 'WC_Sell_To_Continents' ) ) {
		include_once dirname( WCSTC_PLUGIN_FILE ) . '/class-wc-sell-to-continents.php';
	}

	/**
	 * Returns the main instance of WC_Sell_To_Continents
	 */
	function WCSTC() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
		return WC_Sell_To_Continents::get_instance();
	}

	/**
	 * Initialise the plugin
	 */
	add_action(
		'woocommerce_loaded',
		function() {
			WC()->wcstc = WCSTC();
		}
	);

}
