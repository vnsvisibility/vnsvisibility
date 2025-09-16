<?php

if( ! function_exists('blogone_header_section') ){
	function blogone_header_section(){
		get_template_part('template-parts/header/section','header');
	}
	add_action('blogone_header','blogone_header_section', 1);
}

if( ! function_exists('blogone_header_section_navigation') ){
	function blogone_header_section_navigation(){
		get_template_part('template-parts/header/section','navigation');
	}
	add_action('blogone_header_area','blogone_header_section_navigation', 15);
}