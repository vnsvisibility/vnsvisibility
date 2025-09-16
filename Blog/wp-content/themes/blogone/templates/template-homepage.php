<?php 
/**
 * Template Name: Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Blogone
 * 
 * @since Blogone 0.1
 */
if ( is_page_template() ) {
	get_header();
		do_action('blogone_sections',false);
	get_footer();
}
?>