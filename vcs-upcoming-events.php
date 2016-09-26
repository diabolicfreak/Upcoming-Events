<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              lordvcs.com
 * @since             1.0.0
 * @package           Vcs_Upcoming_Events
 *
 * @wordpress-plugin
 * Plugin Name:       Upcoming Events
 * Plugin URI:        lordvcs.com/wp-upcoming-events
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Vivek C S
 * Author URI:        lordvcs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vcs-upcoming-events
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vcs-upcoming-events-activator.php
 */
function activate_vcs_upcoming_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vcs-upcoming-events-activator.php';
	Vcs_Upcoming_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vcs-upcoming-events-deactivator.php
 */
function deactivate_vcs_upcoming_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vcs-upcoming-events-deactivator.php';
	Vcs_Upcoming_Events_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vcs_upcoming_events' );
register_deactivation_hook( __FILE__, 'deactivate_vcs_upcoming_events' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vcs-upcoming-events.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vcs_upcoming_events() {

	$plugin = new Vcs_Upcoming_Events();
	$plugin->run();

}
run_vcs_upcoming_events();
