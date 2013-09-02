<?php

/*
 * Register taxonomies
 */

class rel_taxonomy {
	public function make ( $singular, $plural, $slug, $cpt) {
		$labels = array( 
			'name' => _x( $plural, $slug ),
			'singular_name' => _x( "$singular", $slug ),
			'search_items' => _x( "Search $plural", $slug ),
			'popular_items' => _x( "Popular $plural", $slug ),
			'all_items' => _x( "All $plural", $slug ),
			'parent_item' => _x( "Parent $singular", $slug ),
			'parent_item_colon' => _x( "Parent $singular:", $slug ),
			'edit_item' => _x( "Edit $singular", $slug ),
			'update_item' => _x( "Update $singular", $slug ),
			'add_new_item' => _x( "Add New $singular", $slug ),
			'new_item_name' => _x( "New $singular", $slug ),
			'separate_items_with_commas' => _x( "Separate $plural with commas", $slug ),
			'add_or_remove_items' => _x( "Add or remove $plural", $slug ),
			'choose_from_most_used' => _x( "Choose from most used $plural", $slug ),
			'menu_name' => _x( "$plural", $slug ),
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
		register_taxonomy( $slug, array( $cpt ), $args );
	}
}

function rel_register_taxonomies () {
    $rel_taxonomy = new rel_taxonomy ();
    $rel_taxonomy -> make ( 'State', 'States', 'state', 'listings' );
    $rel_taxonomy -> make ( 'Agent', 'Agents', 'agent', 'listings' );
    $rel_taxonomy -> make ( 'Type', 'Types', 'type', 'listings' );
    $rel_taxonomy -> make ( 'Offer', 'Offers', 'offer', 'listings' );
    $rel_taxonomy -> make ( 'Development', 'Developments', 'development', 'listings' );
    $rel_taxonomy -> make ( 'Feature', 'Features', 'features', 'listings' );
    $rel_taxonomy -> make ( 'Furnishing', 'Furnishings', 'furnishings', 'listings' );
    $rel_taxonomy -> make ( 'Location', 'Locations', 'location', 'listings' );
    $rel_taxonomy -> make ( 'Nearest popular beach', 'Nearest popular beaches', 'nearest-beach', 'listings' );
    $rel_taxonomy -> make ( 'Neighbourhood', 'Neighbourhoods', 'neighbourhood', 'listings' );
}
add_action('init', 'rel_register_taxonomies');

?>
