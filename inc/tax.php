<?php

/*
 * State taxonomy
 */

function register_taxonomy_state() {
    $labels = array( 
        'name' => _x( 'States', 'state' ),
        'singular_name' => _x( 'State', 'state' ),
        'search_items' => _x( 'Search States', 'state' ),
        'popular_items' => _x( 'Popular States', 'state' ),
        'all_items' => _x( 'All States', 'state' ),
        'parent_item' => _x( 'Parent State', 'state' ),
        'parent_item_colon' => _x( 'Parent State:', 'state' ),
        'edit_item' => _x( 'Edit State', 'state' ),
        'update_item' => _x( 'Update State', 'state' ),
        'add_new_item' => _x( 'Add New State', 'state' ),
        'new_item_name' => _x( 'New State', 'state' ),
        'separate_items_with_commas' => _x( 'Separate states with commas', 'state' ),
        'add_or_remove_items' => _x( 'Add or remove States', 'state' ),
        'choose_from_most_used' => _x( 'Choose from most used States', 'state' ),
        'menu_name' => _x( 'State', 'state' ),
    );
    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'query_var' => true
    );
    register_taxonomy( 'state', array('listings'), $args );
}
add_action( 'init', 'register_taxonomy_state' );
?>
