<?php

if( ! function_exists('blogone_footer_section') ){
	function blogone_footer_section(){
		get_template_part('template-parts/footer/section','footer');
	}
	add_action('blogone_footer','blogone_footer_section');
}

if( ! function_exists('blogone_footer_section_widgets') ){
	function blogone_footer_section_widgets(){
		get_template_part('template-parts/footer/section','footer-widgets');
	}
	add_action('blogone_footer_area','blogone_footer_section_widgets');
}

if( ! function_exists('blogone_footer_section_copyright') ){
	function blogone_footer_section_copyright(){
		get_template_part('template-parts/footer/section','footer-copyright');
	}
	add_action('blogone_footer_area','blogone_footer_section_copyright');
}

if( ! function_exists('blogone_footer_section_backtotop') ){
	function blogone_footer_section_backtotop(){
		get_template_part('template-parts/footer/section','backToTop');
	}
	add_action('blogone_site_inner_after','blogone_footer_section_backtotop');
}