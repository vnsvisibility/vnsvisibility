<?php
if( ! function_exists('shopcozi_header_topbar_section') ){
	function shopcozi_header_topbar_section(){
		bc_shopcozi_get_template_part('template-parts/header/section','topbar');
	}
	add_action('shopcozi_header_area','shopcozi_header_topbar_section', 1);
}