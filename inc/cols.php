<?php

/*
 * Set up column headings
 */

function rel_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured_image' => 'Image',
    	'title' => 'Address',
    	'post_status' => 'Post Status',
    	'post_type' => 'Post Type',
    	'post_parent' => 'Post Ancestors',
		'price_sale' => 'Sale',
		'price_long_term' => 'Long Term',
		'price_short_term' => 'Short Term',
		'price_time_share' => 'Time Share',
		'comments' => '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
    	'state' => 'State',
    	'date' => 'Date'
	);
    return $columns;
}
add_filter('manage_listings_posts_columns' , 'rel_columns');

/*
 * Insert data in column data into rows
 */

function rel_custom_columns( $column, $post_id ) {
    switch ( $column ) {
		case 'post_status':
			echo get_post_status( $post_id );
			break;
		case 'post_type':
			echo get_post_type( $post_id );
			break;
		case 'post_parent':
			print_r ( get_post_ancestors( $post_id ) );
			break;
		case 'price_sale':
			echo get_post_meta( $post_id, 'rel_price_sale' , true ); 
			break;
		case 'price_long_term':
			echo get_post_meta( $post_id, 'rel_price_long_term' , true ); 
			break;
		case 'price_short_term':
			echo get_post_meta( $post_id, 'rel_price_short_term' , true ); 
			break;
		case 'featured_image':
			echo the_post_thumbnail( 'thumbnail' );
			break;
		case 'state':
			$rel_states = get_the_terms( $post_id, 'state' );
			if ( !empty( $rel_states ) ) {
				$out = array();
				foreach ( $rel_states as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => 'listings', 'state' => $term->term_id ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'state', 'display' ) )
					);
				}
				echo join( ', ', $out );
			}
			else {
				echo 'No State';
			}
			break;
    }
}
add_action( 'manage_posts_custom_column' , 'rel_custom_columns', 10, 2 );

/*
 * Make columns sortable ( https://gist.github.com/906872 )
 */

function rel_custom_sort( $columns ) {
	$custom = array(
		'price_sale' => 'Sale',
		'price_long_term' => 'Long Term',
		'price_short_term' => 'Short Term',
		'price_time_share' => 'Time Share',
		'state' => 'State'
	);
	return wp_parse_args($custom, $columns);
}
add_filter("manage_edit-listings_sortable_columns", 'rel_custom_sort');

/*
 * Add taxonomy filter to list
 */
// Filter the request to just give posts for the given taxonomy, if applicable.
function taxonomy_filter_restrict_manage_posts() {
    global $typenow;

    // If you only want this to work for your specific post type,
    // check for that $type here and then return.
    // This function, if unmodified, will add the dropdown for each
    // post type / taxonomy combination.

    $post_types = get_post_types( array( '_builtin' => false ) );

    if ( in_array( $typenow, $post_types ) ) {
    	$filters = get_object_taxonomies( $typenow );

        foreach ( $filters as $tax_slug ) {
            $tax_obj = get_taxonomy( $tax_slug );
            wp_dropdown_categories( array(
                'show_option_all' => __('Show All '.$tax_obj->label ),
                'taxonomy' 	  => $tax_slug,
                'name' 		  => $tax_obj->name,
                'orderby' 	  => 'name',
                'selected' 	  => $_GET[$tax_slug],
                'hierarchical' 	  => $tax_obj->hierarchical,
                'show_count' 	  => false,
                'hide_empty' 	  => true
            ) );
        }
    }
}
add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );

/*
 * Make the above taxonomy filters work
 */

function taxonomy_filter_post_type_request( $query ) {
  global $pagenow, $typenow;

  if ( 'edit.php' == $pagenow ) {
    $filters = get_object_taxonomies( $typenow );
    foreach ( $filters as $tax_slug ) {
      $var = &$query->query_vars[$tax_slug];
      if ( isset( $var ) ) {
        $term = get_term_by( 'id', $var, $tax_slug );
        $var = $term->slug;
      }
    }
  }
}
add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );

/*
 * Search custom fields from admin keyword searches
 */

function rel_search_join( $join ) {
	global $pagenow, $wpdb;
	if ( is_admin() && $pagenow == 'edit.php' && $_GET['post_type'] == 'listings' && $_GET['s'] != '') {    
		$join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}
	return $join;
}
add_filter('posts_join', 'rel_search_join' );

function rel_search_where( $where ) {
	global $pagenow, $wpdb;
	if ( is_admin() && $pagenow == 'edit.php' && $_GET['post_type']=='listings' && $_GET['s'] != '' ) {
		$where = preg_replace( "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/", "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
	}
	return $where;
}
add_filter( 'posts_where', 'rel_search_where' );

function rel_post_limits( $groupby ) {
    global $pagenow, $wpdb;
    if ( is_admin() && $pagenow == 'edit.php' && $_GET['post_type']=='listings' && $_GET['s'] != '' ) {
        $groupby = "$wpdb->posts.ID";
    }
    return $groupby;
}
add_filter( 'posts_groupby', 'rel_post_limits' );

?>