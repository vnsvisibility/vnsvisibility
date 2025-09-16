<?php 
/**
 * This is the 404 template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Blogone
 * 
 * @since Blogone 1.0.0
 */

get_header();
get_template_part('template-parts/section-breadcrumbs');

$option = blogone_theme_options();
?>
<section class="bs-section section-404">
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-10 col-md-12 col-12 m-auto">
				<div class="bs-card-404">
					<?php if( $option['blogone_error_subtitle'] != '' ){ ?>
					<h3 class="bs-error"><?php echo esc_html($option['blogone_error_subtitle']); ?></h3>
					<?php } ?>
	    			
	    			<?php if( $option['blogone_error_code'] != '' ){ ?>
	    			<h2 class="bs-404-title"><?php echo wp_kses_post($option['blogone_error_code']); ?></h2>
	    			<?php } ?>
	    			
	    			<?php if( $option['blogone_error_title'] != '' ){ ?>
	    			<h4><?php echo esc_html($option['blogone_error_title']); ?></h4>
	    			<?php } ?>

	    			<?php if( $option['blogone_error_desc'] != '' ){ ?>
	    			<p><?php echo wp_kses_post($option['blogone_error_desc']); ?></p>
	    			<?php } ?>

	    			<div class="bs-404-btn mt-4">
	    				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bs-book_btn"><?php echo esc_html($option['blogone_error_btn_label']); ?> <span></span><span></span><span></span><span></span></a>
	    			</div>
	    		</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>