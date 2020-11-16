<?php
/**
 *Plugin Name: Hi Contour Pro
 *Description: Pro
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0.1
 **/


function pluginprefix_function_to_run()
{
    $labels = array(
        'name' => _x('Movies', 'Post Type General Name', 'twentytwenty'),
        'singular_name' => _x('Movie', 'Post Type Singular Name', 'twentytwenty'),
        'menu_name' => __('Movies', 'twentytwenty'),

        'parent_item_colon' => __('Parent Movie', 'twentytwenty'),
        'all_items' => __('All Movies', 'twentytwenty'),
        'view_item' => __('View Movie', 'twentytwenty'),
        'add_new_item' => __('Add New Movie', 'twentytwenty'),
        'add_new' => __('Add New', 'twentytwenty'),
        'edit_item' => __('Edit Movie', 'twentytwenty'),
        'update_item' => __('Update Movie', 'twentytwenty'),
        'search_items' => __('Search Movie', 'twentytwenty'),
        'not_found' => __('Not Found', 'twentytwenty'),
        'not_found_in_trash' => __('Not found in Trash', 'twentytwenty'),
    );

// Set other options for Custom Post Type

    $args = array(
        'label' => __('movies', 'twentytwenty'),
        'description' => __('Movie news and reviews', 'twentytwenty'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies' => array('genres'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'menu_icon' => 'dashicons-download',
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,

    );
    register_post_type( 'movies', $args );
}

add_action('init','pluginprefix_function_to_run');
//register_activation_hook( __FILE__, 'pluginprefix_function_to_run' );
