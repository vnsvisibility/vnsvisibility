<?php

if( ! function_exists('blogone_header_section_topbar') ){
	function blogone_header_section_topbar(){
		bc_blogone_get_template_part('template-parts/header/section','topbar');
	}
	add_action('blogone_header_inner_before','blogone_header_section_topbar', 5);
}

if( ! function_exists('blogone_header_section_topbar_canvas') ){
	function blogone_header_section_topbar_canvas(){
		bc_blogone_get_template_part('template-parts/header/section','topbar-canvas');
	}
	add_action('blogone_topbar_area','blogone_header_section_topbar_canvas', 10);
}