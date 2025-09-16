<?php

// Slider
if( ! function_exists('blogone_slider_section') ){
	function blogone_slider_section(){
		bc_blogone_get_template_part('template-parts/sections-homepage/section', 'slider');
	}

	$section_priority = apply_filters( 'blogone_section_priority', 5, 'blogone_slider_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('blogone_sections','blogone_slider_section', absint($section_priority));
	}
}

// Category
if( ! function_exists('blogone_category_section') ){
	function blogone_category_section(){
		bc_blogone_get_template_part('template-parts/sections-homepage/section','category');
	}

	$section_priority = apply_filters( 'blogone_section_priority', 10, 'blogone_category_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('blogone_sections','blogone_category_section', absint($section_priority));
	}
}