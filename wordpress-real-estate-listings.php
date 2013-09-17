<?php

/*
Plugin Name: WordPress Real Estate Listings
Description: A Real Estate Listings plugin for WordPress
Version: 0.1
Author: lesslazy
*/

require_once( dirname( __FILE__ ) . '/inc/cpt.php' );
require_once( dirname( __FILE__ ) . '/inc/tax.php' );

if ( is_admin() ) {
	require_once( dirname( __FILE__ ) . '/inc/meta.php' );
	require_once( dirname( __FILE__ ) . '/inc/ui.php' );
	require_once( dirname( __FILE__ ) . '/inc/updater.php' );

	function github_plugin_updater() {
		include_once 'updater.php';
		define( 'WP_GITHUB_FORCE_UPDATE', true );
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'WordPress-Real-Estate-Listings',
			'api_url' => 'https://api.github.com/repos/jnthnclrk/WordPress-Real-Estate-Listings',
			'raw_url' => 'https://raw.github.com/jnthnclrk/WordPress-Real-Estate-Listings/master',
			'github_url' => 'https://github.com/jnthnclrk/WordPress-Real-Estate-Listings',
			'zip_url' => 'https://github.com/jnthnclrk/WordPress-Real-Estate-Listings/archive/master.zip',
			'sslverify' => true,
			'requires' => '3.6.1',
			'tested' => '3.6.1',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}
	add_action( 'init', 'github_plugin_updater' );
}

?>
