<?php

// Slider
if( ! function_exists('shop2u_slider_section') ){
	function shop2u_slider_section(){
		bc_shop2u_get_template_part('template-parts/sections-homepage/section','slider');
	}

	$section_priority = apply_filters( 'shop2u_section_priority', 5, 'shop2u_slider_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shop2u_sections','shop2u_slider_section', absint($section_priority));
	}
}

// Recent Product
if( ! function_exists('shop2u_recent_product_section') ){
	function shop2u_recent_product_section(){
		bc_shop2u_get_template_part('template-parts/sections-homepage/section','recent-product');
	}

	$section_priority = apply_filters( 'shop2u_section_priority', 15, 'shop2u_recent_product_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shop2u_sections','shop2u_recent_product_section', absint($section_priority));
	}
}

// Banner
if( ! function_exists('shop2u_banner_section') ){
	function shop2u_banner_section(){
		bc_shop2u_get_template_part('template-parts/sections-homepage/section','banner');
	}

	$section_priority = apply_filters( 'shop2u_section_priority', 20, 'shop2u_banner_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shop2u_sections','shop2u_banner_section', absint($section_priority));
	}
}

// Testimonial
if( ! function_exists('shop2u_testimonial_section') ){
	function shop2u_testimonial_section(){
		bc_shop2u_get_template_part('template-parts/sections-homepage/section','testimonial');
	}

	$section_priority = apply_filters( 'shop2u_section_priority', 40, 'shop2u_testimonial_section' );
	if(isset($section_priority) && $section_priority != '' ){
		add_action('shop2u_sections','shop2u_testimonial_section', absint($section_priority));
	}
}