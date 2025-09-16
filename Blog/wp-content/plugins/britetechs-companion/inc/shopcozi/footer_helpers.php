<?php
if( ! function_exists('shopcozi_footer_above_section') ){
	function shopcozi_footer_above_section(){
		bc_shopcozi_get_template_part('template-parts/footer/section','above');
	}
	add_action('shopcozi_footer_area','shopcozi_footer_above_section', 1);
}