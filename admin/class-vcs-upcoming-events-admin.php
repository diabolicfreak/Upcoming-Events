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

require_once plugin_dir_path( __FILE__ ) . 'partials/vcs-upcoming-events-admin-register-post-type.php';

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
	public function enqueue_styles($hook) {

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
		if('post.php' == $hook || 'post-new.php' == $hook){
            wp_enqueue_style('jquery-ui-calendar', plugin_dir_url(__FILE__).'css/jquery-ui.min.css', array(), $this->version, 'all');
        }
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vcs-upcoming-events-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

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
		if('post.php'==$hook || 'post-new.php'==$hook){
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vcs-upcoming-events-admin.js', array( 'jquery', 'jquery-ui-datepicker' ), $this->version, false );
        }


	}

    /**
     * Register custom post type 'Event'
     */
     public function vcs_event_custom_post_type() {
         register_post_type_external();
     }

     /**
      * Add event info meta box
      */
     public function vcs_add_event_info_metabox()
     {
         add_meta_box(
             'vcs-event-info-metabox',
             __('Event Info', 'vcs-event'),
             array($this, 'vcs_render_event_info_metabox'),
             'event',
             'side',
             'core'
         );
     }

    //  Callback to display event info metabox
    public function vcs_render_event_info_metabox($post)
     {
         wp_nonce_field(basename(__FILE__), 'vcs-event-info-nonce');

         $event_start_date = get_post_meta($post->ID, 'event-start-date', true);
         $event_end_date = get_post_meta($post->ID, 'event-end-date', true);
         $event_venue = get_post_meta($post->ID, 'event-venue', true);

         $event_start_date = !empty($event_start_date) ? $event_start_date : time();
         $event_end_date = !empty($event_end_date) ? $event_end_date : $event_start_date;
         ?>
         <label for="vcs-event-start-date"><?php _e('Event Start Date:', 'vcs-event')?></label>
         <input type="text" class="widefat uep-event-date-input" id="vcs-event-start-date" name="vcs-event-start-date" placeholder="Format: February 18, 2014" value="<?php echo date('F, d, Y', $event_start_date);?>" />

         <label for="vcs-event-end-date"><?php _e('Event End Date:', 'vcs-event')?></label>
         <input type="text" class="widefat uep-event-date-input" id="vcs-event-end-date" name="vcs-event-end-date" placeholder="Format: February 18, 2014" value="<?php echo date('F, d, Y', $event_end_date);?>">

         <label for="vcs-event-venue"><?php _e('Event Venue:', 'vcs-event');?></label>
         <input type="text" class="widefat" id="vcs-event-venue" name="vcs-event-venue" placeholder="eg. Times Squrare" value="<?php echo $event_venue;?>">
         <?php
     }

    //  Callback to save event post
     public function vcs_save_event_info($post_id){
        //  Check if post is of type event
        //  if($_POST['post_type']) && 'event'!=$_POST['post_type']){
        //      return;
        //  }
         if(!is_singular( 'post_type' )){
             return;
         }


        //  Check save status and nonce validity
         $is_autosave = wp_is_post_autosave($post_id);
         $is_revision = wp_is_post_revision($post_id);
         $is_valid_nonce = ( isset($_POST['vcs-event-info-nonce']) && (wp_verify_nonce($_POST['vcs-event-info-nonce'], basename(__FILE__)))) ? true :false;

         if($is_autosave || $is_revision || !$is_valid_nonce){
             return;
         }

        //  Updating/saving post meta values
         if(isset($_POST['vcs-event-start-date'])){
             update_post_meta($post_id, 'event-start-date', strtotime($_POST['vcs-event-start-date']));
         }

         if(isset($_POST['vcs-event-end-date'])){
             update_post_meta($post_id, 'event-end-date', strtotime($_POST['vcs-event-end-date']));
         }

         if(isset($_POST['vcs-event-venue'])){
             update_post_meta($post_id, 'event-venue', sanitize_text_field($_POST['vcs-event-venue']));
         }
     }

     /**
      * Adding custom columsn to post admin
      */
    //  Set column headers
     public function vcs_custom_columns_head($defaults){
         unset($defaults['date']);

         $defaults['event_start_date'] = __('Start Date', 'vcs-event');
         $defaults['event_end_date'] = __('End Date', 'vcs-event');
         $defaults['event_venue'] = __('Venue', 'vcs-event');

         return $defaults;
     }

    // Set column values
    public function vcs_custom_columns_content($column_name, $post_id){
        if('event_start_date' == $column_name){
            $start_date = get_post_meta($post_id, 'event-start-date', true);
            echo date('F d, Y', $start_date);
        }

        if('event_end_date' == $column_name){
            $end_date = get_post_meta($post_id, 'event-start-date', true);
            echo date('F d, Y', $end_date);
        }

        if('event_venue' == $column_name){
            $event_venue = get_post_meta($post_id, 'event-venue', true);
            echo $event_venue;
        }
    }

    // Register events widget
    public function vcs_register_widget(){
        register_widget('Upcoming_widget');
    }

 }

/**
 * Upcoming Widgets class definition
 */
 class Upcoming_widget extends WP_Widget {
     public function __construct()
     {
         $widget_ops = array(
             'class' => 'vcs_upcoming_events',
             'description' => __('A widget to show all upcoming widgets', 'vcs-event')
         );

         parent::__construct(
             'vcs_upcoming_events',
             __('Upcoming events', 'vcs-event'),
             $widget_ops
         );
     }

     public function form($instance)
     {
         $widget_defaults = array(
                 'title' => 'Upcoming events',
                 'number_events' => 5
         );

         $instance = wp_parse_args((array) $instance, $widget_defaults);
         ?>
             <p>
                 <label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title', 'vcs-event')?></label>
                 <input type="text" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" class="widefat" value="<?php echo esc_attr($instance['title']);?>">
             </p>
             <p>
                 <label for="<?php echo $this->get_field_id('number_events')?>"><?php echo _e('Number of events to show', 'vcs-event')?></label>
                 <select class="widefat" name="<?php echo $this->get_field_name('number_events')?>">
                     <?php
                         for($i=1; $i<=10; $i++):?>
                             <option value="<?php echo $i;?>" <?php selected($i, $instance['number_events'], true);?>><?php echo $i;?></option>
                     <?php endfor;?>
                 </select>
             </p>
         <?php

     }

     public function update($new_instance, $old_instance)
     {
         $instance = $old_instance;

         $instance['title'] = $new_instance['title'];
         $instance['number_events'] = $new_instance['number_events'];

         return $instance;
     }

     public function widget($args, $instance)
     {
         extract($args);
         $title = apply_filters('widget_title', $instance['title']);

         // Query event post details
         $met_quer_args = array(
             'relation' => 'AND',
             array(
                 'key' => 'event-end-date',
                 'value' => time(),
                 'compare' => '>='
             )
         );

         $query_args = array(
             'post_type' => 'event',
             'posts_per_page' => $instance,
             'post_status' => 'publish',
             'ignore_sticky_posts' => true,
             'meta_key' => 'event-start-date',
             'orderby' => 'meta_value_num',
             'order' => 'ASC',
             'meta_query' => $met_quer_args
         );
         $upcoming_events = new WP_Query($query_args);

         // Output Widget
         echo $before_widget;
         if($title){
             echo $before_title.$title.$after_title;
         }
         ?>
         <ul>
             <?php
                 while ($upcoming_events->have_posts()): $upcoming_events->the_post();
                     $event_start_date = get_post_meta(get_the_ID(), 'event-start-date', true);
                     $event_end_date = get_post_meta(get_the_ID(), 'event-end-date', true);
                     $event_venue = get_post_meta(get_the_ID(), 'event-venue', true);
              ?>
              <li>
                  <h4><a href="<?php the_permalink()?>" class="vcs_event_title"><?php the_title();?></a><span class="event_venue">at <?php echo $event_venue; ?></span></h4>
                  <?php the_excerpt(); ?>
                  <time class="vcs_event_date"><?php echo date('F d, Y', $event_start_date); ?> &ndash; <?php echo date('F f, Y', $event_end_date); ?></time>
              </li>
          <?php endwhile; ?>
         </ul>

         <a href="<?php echo get_post_type_archive_link('event')?>">View All Events</a>

         <?php
         wp_reset_query();
         echo $after_widget;
     }
 }
