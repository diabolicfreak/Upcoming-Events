<?php

function register_post_type_external()
{
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
