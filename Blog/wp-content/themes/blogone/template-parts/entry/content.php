<?php 
$option = blogone_theme_options();

$category_show = $option['blogone_archive_category_show'];
$title_show = $option['blogone_archive_title_show'];
$date_show = $option['blogone_archive_date_show'];
$excerpt_show = $option['blogone_archive_excerpt_show'];

if( is_single() ){
	$category_show = $option['blogone_single_category_show'];
	$title_show = $option['blogone_single_title_show'];
	$date_show = $option['blogone_single_date_show'];
	$excerpt_show = true;
}
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item post-grid-layout'); ?>>

	<?php get_template_part('template-parts/entry/media/entry','media'); ?>

	<div class="blog_content">
		<?php

		if($category_show==true){ 
			get_template_part('template-parts/entry/meta','category'); 
		}

		if($title_show==true){
			get_template_part('template-parts/entry/entry','title');
		}

		if($date_show==true){
			get_template_part('template-parts/entry/meta','date'); 
		}
		
		if($excerpt_show==true){
			get_template_part('template-parts/entry/entry','content'); 
		}

		if( is_archive() && !is_single() ){
			get_template_part('template-parts/entry/meta','author'); 
		}

		if( is_single() ){
			get_template_part('template-parts/entry/meta','tags'); 
		}
		?>
	</div>		
</div><!-- #post-<?php the_ID(); ?> -->
