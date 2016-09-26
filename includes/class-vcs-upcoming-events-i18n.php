<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       lordvcs.com
 * @since      1.0.0
 *
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/includes
 * @author     Vivek C S <diabolicfreak@gmail.com>
 */
class Vcs_Upcoming_Events_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vcs-upcoming-events',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
