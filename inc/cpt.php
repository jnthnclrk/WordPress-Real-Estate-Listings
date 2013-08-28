<?php
add_action( 'init', 'register_cpt_listings' );

function register_cpt_listings() {

    $labels = array( 
        'name' => _x( 'Listings', 'listings' ),
        'singular_name' => _x( 'Listing', 'listings' ),
        'add_new' => _x( 'Add New', 'listings' ),
        'add_new_item' => _x( 'Add New Listing', 'listings' ),
        'edit_item' => _x( 'Edit Listing', 'listings' ),
        'new_item' => _x( 'New Listing', 'listings' ),
        'view_item' => _x( 'View Listing', 'listings' ),
        'search_items' => _x( 'Search Listings', 'listings' ),
        'not_found' => _x( 'No listings found', 'listings' ),
        'not_found_in_trash' => _x( 'No listings found in Trash', 'listings' ),
        'parent_item_colon' => _x( 'Parent Listing:', 'listings' ),
        'menu_name' => _x( 'Listings', 'listings' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Real Estate Listings',
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
        'taxonomies' => array( ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'listings', $args );
}
?>
