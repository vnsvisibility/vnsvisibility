<?php
// Slider
if( ! function_exists('shopcozi_slider_section') ){
	function shopcozi_slider_section(){
		bc_shopcozi_get_template_part('template-parts/sections-homepage/section','slider');
	}

	$section_priority = apply_filters( 'shopcozi_section_priority', 5, 'shopcozi_slider_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shopcozi_sections','shopcozi_slider_section', absint($section_priority));
	}
}

// Service
if( ! function_exists('shopcozi_service_section') ){
	function shopcozi_service_section(){
		bc_shopcozi_get_template_part('template-parts/sections-homepage/section','service');
	}

	$section_priority = apply_filters( 'shopcozi_section_priority', 10, 'shopcozi_service_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shopcozi_sections','shopcozi_service_section', absint($section_priority));
	}
}

// Banner
if( ! function_exists('shopcozi_banner_section') ){
	function shopcozi_banner_section(){
		bc_shopcozi_get_template_part('template-parts/sections-homepage/section','banner');
	}

	$section_priority = apply_filters( 'shopcozi_section_priority', 25, 'shopcozi_banner_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shopcozi_sections','shopcozi_banner_section', absint($section_priority));
	}
}

// Testimonial
if( ! function_exists('shopcozi_testimonial_section') ){
	function shopcozi_testimonial_section(){
		bc_shopcozi_get_template_part('template-parts/sections-homepage/section','testimonial');
	}

	$section_priority = apply_filters( 'shopcozi_section_priority', 30, 'shopcozi_testimonial_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shopcozi_sections','shopcozi_testimonial_section', absint($section_priority));
	}
}