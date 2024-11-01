<?php
/**
 * WC Sell To Continents
 *
 * @package wc_sell_to_continents
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Woo Sell To Continents Class.
 *
 * @class WC_Sell_To_Continents
 */
class WC_Sell_To_Continents {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Return the plugin url
	 *
	 * @return string
	 */
	public function get_url() {
		return untrailingslashit( plugins_url( '/', WCSTC_PLUGIN_FILE ) );
	}


	/**
	 * Constructor
	 */
	private function __construct() {
		$this->includes();
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}


	/**
	 * Load any additional php files into the class
	 */
	private function includes() {
		require_once dirname( WCSTC_PLUGIN_FILE ) . '/includes/class-wcstc-selling-locations.php';
		$this->selling_locations = new WCSTC_Selling_Locations();
	}


	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'woo-sell-to-continents', false, WCSTC_PLUGIN_FILE . '/languages/' );
	}

}
