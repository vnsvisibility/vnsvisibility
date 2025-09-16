<?php
/*
Plugin Name: Britetechs Companion
Plugin URI: 
Description: Enhance britetechs WordPress Themes additional functionality in the homepage.
Version: 3.1.8
Requires at least: 5.8
Requires PHP: 7.0
Author: Britetechs
Author URI: https://Britetechs.com
Text Domain: britetechs-companion
*/

if(!define('bc_plugin_url', plugin_dir_url( __FILE__ ))){
	define( 'bc_plugin_url', plugin_dir_url( __FILE__ ) );
}

if(!define('bc_plugin_dir', plugin_dir_path( __FILE__ ))){
	define( 'bc_plugin_dir', plugin_dir_path( __FILE__ ) );
}

if( !function_exists('bc_init') ){
	function bc_init(){
		 
		/* Connect with parent theme options */
		$theme_slug = get_template();
		
		if( file_exists( bc_plugin_dir . "inc/$theme_slug/init.php" ) ){

			require("inc/$theme_slug/init.php");

		}	
	}
}
bc_init();

function bc_install_theme_pages() {
    require_once bc_plugin_dir . 'inc/theme-pages-activator.php';
    BC_Theme_Pages_Activator::activate();
}
register_activation_hook( __FILE__, 'bc_install_theme_pages' );