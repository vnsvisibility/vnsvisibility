<?php 
/**
 * This is the default page template file
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
?>
<section class="bs-section bs-blog_section">
	<div class="container">
		<div class="row bs-g-5">
			<div class="col-xl-8 col-lg-8 col-md-12 col-12">
				<?php
            	// Check if posts exist
				if ( have_posts() ) :

					// loop
					while ( have_posts() ) : the_post();

						get_template_part('template-parts/entry/content', 'page');

					endwhile;

					// If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

				else:

					get_template_part('template-parts/entry/content','none');

				endif;
            	?>				
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	</div>
</section>
<?php get_footer(); ?>