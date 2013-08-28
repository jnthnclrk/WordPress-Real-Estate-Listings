<?php
/*
Plugin Name: Real Estate Listings
Description: Real Estate Listings Plugin
Version: 0.1
Author: lesslazy
*/

require_once( dirname( __FILE__ ) . '/inc/cpt.php' );
require_once( dirname( __FILE__ ) . '/inc/tax.php' );

if ( is_admin() ) {
	require_once( dirname( __FILE__ ) . '/inc/meta.php' );
	require_once( dirname( __FILE__ ) . '/inc/cols.php' );
} else {
}

register_activation_hook( __FILE__, 'rel_activate' );
function rel_activate() {
}

register_deactivation_hook( __FILE__, 'rel_deactivate' );
function rel_deactivate() {
}
