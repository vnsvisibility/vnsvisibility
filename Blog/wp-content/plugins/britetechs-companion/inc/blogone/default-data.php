<?php

if( ! function_exists('bc_blogone_default_options') ){
    function bc_blogone_default_options( $old_data ){
        $data = array(
        'blogone_topbar_show' => true,
        'blogone_topbar_social_content' => blogone_topbar_social_default_data(),
        'blogone_topbar_social_target' => false,
        'blogone_topbar_search_show' => true,
        'blogone_topbar_search_label' => __('Search here...','blogone'),
        'blogone_topbar_canvas_show' => true,
        'blogone_topbar_canvas_logo' => bc_plugin_url.'inc/blogone/img/logo.png',
        'blogone_topbar_canvas_desc' => 'Mauris ut enim sit amet lacus ornare ullamcor. Praesent placerat nequ puru rhoncu tincidunt odio ultrices. Sed feugiat feugiat felis.',
        'blogone_topbar_canvas_search_show' => true,
        'blogone_topbar_canvas_search_title' => __('Search Form','blogone'),
        'blogone_topbar_canvas_search_label' => __('Search here...','blogone'),

        'blogone_breadcrumb_bg_image' => bc_plugin_url.'inc/blogone/img/sub-header.jpg',

        'blogone_slider_show' => true,
        'blogone_slider_style' => 'one',
        'blogone_slider_speed' => 3000,
        'blogone_slider_animation_start' => 'fadeIn',
        'blogone_slider_animation_end' => 'fadeOut',
        'blogone_slider_category' => '',
        'blogone_slider_tag' => '',
        'blogone_slider_exclude_ids' => '',
        'blogone_slider_orderby' => 'date',
        'blogone_slider_order' => 'desc',
        'blogone_slider_posts_per_page' => 5,
        'blogone_slider_readmore' => __('Read More','blogone'),
        'blogone_slider_category_show' => true,
        'blogone_slider_title_show' => true,
        'blogone_slider_date_show' => true,
        'blogone_slider_excerpt_show' => true,
        'blogone_slider_btn_show' => true,
        'blogone_slider_author_show' => true,

        'blogone_category_show' => true,
        'blogone_category_orderby' => 'name',
        'blogone_category_order' => 'ASC',
        'blogone_category_hide_empty' => false,
        'blogone_category_exclude_ids' => '',
        'blogone_category_style' => 'slider', // 'slider'
        'blogone_categirt_title_show' => true,

        'blogone_footer_copyright_content' => blogone_copyright_content_default_data(),
        'blogone_footer_bg_image' => bc_plugin_url.'inc/blogone/img/footer-bg.png',
        );

        $data = array_merge( $old_data, $data );
        return $data;
    }
    add_filter('blogone_default_options','bc_blogone_default_options', 20);
}

function blogone_topbar_social_default_data(){
	return  array(
                array(
                	'icon' => 'fab fa-facebook-f',
                    'link' => '#',
                ),
                array(
                	'icon' => 'fab fa-twitter',
                    'link' => '#',
                ),
                array(
                	'icon' => 'fab fa-linkedin-in',
                    'link' => '#',
                )
            );
}

function blogone_copyright_content_default_data(){
    return  array(
                array(
                    'text' => 'Terms & condition',
                    'link' => '#',
                ),
                array(
                    'text' => 'Privacy Policy',
                    'link' => '#',
                )                
            );
}

function blogone_topbar_social_data(){
    $items = get_theme_mod('blogone_topbar_social_content');

    if(is_string($items)){
        $items = json_decode($items);
    }

    if ( empty( $items ) || !is_array( $items ) ) {
        $items = array();
    }

    $val = array();
    if (!empty($items) && is_array($items)) {
        foreach ($items as $k => $v) {
            $val[] = wp_parse_args($v,array(
                        'icon' => 'fa fa-facebook',
                        'link' => '#',
                    ));
        }
    }else{
        $val = blogone_topbar_social_default_data();
    }

    return $val;
}

function blogone_copyright_content_data(){
    $items = get_theme_mod('blogone_footer_copyright_content');

    if(is_string($items)){
        $items = json_decode($items);
    }

    if ( empty( $items ) || !is_array( $items ) ) {
        $items = array();
    }

    $val = array();
    if (!empty($items) && is_array($items)) {
        foreach ($items as $k => $v) {
            $val[] = wp_parse_args($v,array(
                        'text' => 'Terms & condition',
                        'link' => '#',
                    ));
        }
    }else{
        $val = blogone_copyright_content_default_data();
    }

    return $val;
}