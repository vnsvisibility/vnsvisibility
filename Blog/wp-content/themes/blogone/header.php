<?php 
/**
 * The header for the blogone theme
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Blogone
 * 
 * @since Blogone 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php 
	    if ( function_exists('wp_body_open') ) {
	      wp_body_open();
	    }else{
	      do_action('wp_body_open');
	    }
  	?>
  	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content','blogone'); ?></a>

  	<?php do_action( 'blogone_site_before' ); ?>

	<div class="bs-page_wrapper">

		<?php do_action( 'blogone_site_inner_before' ); ?>

		<?php do_action('blogone_header'); ?>

		<div id="content" class="content">