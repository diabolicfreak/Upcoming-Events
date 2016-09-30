<?php

/**
 * Fired during plugin activation
 *
 * @link       lordvcs.com
 * @since      1.0.0
 *
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/includes
 * @author     Vivek C S <diabolicfreak@gmail.com>
 */
class Vcs_Upcoming_Events_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once plugin_dir_path( __FILE__ ) . '../admin/partials/vcs-upcoming-events-admin-register-post-type.php';
        register_post_type_external();
        flush_rewrite_rules();
	}

}
