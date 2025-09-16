<?php

// Blog
if( ! function_exists('blogone_blog_section') ){
	function blogone_blog_section(){
		get_template_part('template-parts/sections-homepage/section','blog');
	}

	$section_priority = apply_filters( 'blogone_section_priority', 15, 'blogone_blog_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('blogone_sections','blogone_blog_section', absint($section_priority));
	}
}