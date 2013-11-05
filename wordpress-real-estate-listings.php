<?php

/*
Plugin Name: WordPress Real Estate Listings
Description: A Real Estate Listings plugin for WordPress
Version: 0.2
Author: lesslazy
*/

require_once( dirname( __FILE__ ) . '/inc/cpt.php' );
require_once( dirname( __FILE__ ) . '/inc/tax.php' );

if ( is_admin() ) {
	require_once( dirname( __FILE__ ) . '/inc/meta.php' );
	require_once( dirname( __FILE__ ) . '/inc/ui.php' );
}

?>
