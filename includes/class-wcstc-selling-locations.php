<?php
/**
 * WCSTL_Selling_Locations
 *
 * @package wc_sell_to_continents
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class that adds and handles the extra options to the Selling Locations
 *
 * @class WCSTC_Selling_Locations
 */
class WCSTC_Selling_Locations {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_countries', array( $this, 'get_countries' ), 5, 1 );
		add_filter( 'pre_update_option_woocommerce_specific_allowed_countries', array( $this, 'get_allowed_countries' ), 5, 1 );
		add_filter( 'pre_update_option_woocommerce_specific_ship_to_countries', array( $this, 'get_allowed_countries' ), 5, 1 );
	}

	/**
	 * Appends continents onto the countries list
	 *
	 * @param array $locations the array of set locations.
	 * @return array
	 */
	public function get_countries( $locations ) {
		if ( is_admin() ) {

			$orginal_continents = WC()->countries->get_continents();
			$orginal_continents = array_filter( array_combine( array_keys( $orginal_continents ), array_column( $orginal_continents, 'name' ) ) );
			$continents         = array();

			foreach ( $orginal_continents as $key => $name ) {
				$continents[ 'c_' . $key ] = $name;
			}

			$locations = array_merge( $locations, $continents );
		}
		return $locations;
	}

	/**
	 * Replaces countinents with their internal countries.
	 *
	 * @param array $locations the allowed countries as saved.
	 * @return array
	 */
	public function get_allowed_countries( $locations ) {

		if ( empty( $locations ) || ! is_array( $locations ) ) {
			return $locations;
		}

		$selected_continents = array_filter(
			$locations,
			function( $key ) {
				return fnmatch( 'c_*', $key );
			}
		);

		if ( ! empty( $selected_continents ) ) :

			$deafult_continents = WC()->countries->get_continents();

			foreach ( $selected_continents as $key => $value ) {
				unset( $locations[ $key ] );
				$current             = str_replace( 'c_', '', $value );
				$continent_countries = $deafult_continents[ $current ];

				if ( empty( $continent_countries['countries'] ) ) {
					continue;
				}

				$locations = array_merge( $locations, $continent_countries['countries'] );
			}

		endif;

		return $locations;
	}

}
