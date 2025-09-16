<?php

if( ! function_exists('shop2u_header_topbar_section') ){
	function shop2u_header_topbar_section(){
		get_template_part('template-parts/header/section','topbar');
	}
	add_action('shop2u_header_area','shop2u_header_topbar_section', 5);
}