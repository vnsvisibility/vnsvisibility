<?php

if( ! function_exists('shop2u_footer_above_section') ){
	function shop2u_footer_above_section(){
		get_template_part('template-parts/footer/section','above');
	}
	add_action('shop2u_footer_area','shop2u_footer_above_section', 5);
}