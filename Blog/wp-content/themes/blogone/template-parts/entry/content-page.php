<?php 
$option = blogone_theme_options();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item post-grid-layout'); ?>>

	<?php get_template_part('template-parts/entry/media/entry','media'); ?>

	<div class="blog_content">
		<?php 
		if( $option['blogone_page_title_show'] == true ){
			get_template_part('template-parts/entry/entry','title'); 
		}
		
		get_template_part('template-parts/entry/entry','content'); 
		?>
	</div>		
</div><!-- #post-<?php the_ID(); ?> -->