<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       lordvcs.com
 * @since      1.0.0
 *
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vcs_Upcoming_Events
 * @subpackage Vcs_Upcoming_Events/admin
 * @author     Vivek C S <diabolicfreak@gmail.com>
 */
class Vcs_Upcoming_Events_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        define( 'ROOT', plugins_url( '', __FILE__ ) );
        define( 'IMAGES', ROOT . '/img/' );
        define( 'STYLES', ROOT . '/css/' );
        define( 'SCRIPTS', ROOT . '/js/' );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vcs_Upcoming_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vcs_Upcoming_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vcs-upcoming-events-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vcs_Upcoming_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vcs_Upcoming_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vcs-upcoming-events-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register custom post type 'Event'
     */

     public function vcs_event_custom_post_type() {
         $labels = array(
             'name'                  =>   __( 'Events', 'vcs-event' ),
             'singular_name'         =>   __( 'Event', 'vcs-event' ),
             'add_new_item'          =>   __( 'Add New Event', 'vcs-event' ),
             'all_items'             =>   __( 'All Events', 'vcs-event' ),
             'edit_item'             =>   __( 'Edit Event', 'vcs-event' ),
             'new_item'              =>   __( 'New Event', 'vcs-event' ),
             'view_item'             =>   __( 'View Event', 'vcs-event' ),
             'not_found'             =>   __( 'No Events Found', 'vcs-event' ),
             'not_found_in_trash'    =>   __( 'No Events Found in Trash', 'vcs-event' )
         );

         $supports = array(
             'title',
             'editor',
             'excerpt'
         );

         $args = array(
             'label'         =>   __( 'Events', 'vcs-event' ),
             'labels'        =>   $labels,
             'description'   =>   __( 'A list of upcoming events', 'vcs-event' ),
             'public'        =>   true,
             'show_in_menu'  =>   true,
             'menu_icon'     =>   'dashicons-book',
             'has_archive'   =>   true,
             'rewrite'       =>   true,
             'supports'      =>   $supports
         );

         register_post_type( 'event', $args );
     }
 }
