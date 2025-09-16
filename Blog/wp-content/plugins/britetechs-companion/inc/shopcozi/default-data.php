<?php

if( ! function_exists('bc_shopcozi_default_options') ){
    function bc_shopcozi_default_options( $old_data ){
        $data = array(
            'shopcozi_nav_wishlist_title' => __('Wishlist','shopcozi'),
            'shopcozi_nav_compare_title' => __('Compare','shopcozi'),
            'shopcozi_nav_btn_label' => __('Shop Now','shopcozi'),
            'shopcozi_nav_btn_link' => '#',
            'shopcozi_browse_cat_title' => __('All Categories','shopcozi'), 
            'shopcozi_browse_cat_more_title' => __('More Category','shopcozi'), 
            'shopcozi_browse_cat_nomore_title' => __('No More','shopcozi'),
            'shopcozi_browse_form_field' => __('Search Product...','shopcozi'),     
            'shopcozi_browse_form_dropdown' => __('Select Category', 'shopcozi'),
            'shopcozi_breadcrumb_bg_image' => bc_plugin_url.'inc/shopcozi/img/sub-header.jpg',
            'shopcozi_footer_above_show' => true,
            'shopcozi_footer_above_content' => shopcozi_footer_above_content_default_data(),
            'shopcozi_footer_copyright' => __('Copyright %copy% %current_year%, All Rights Reserved.','shopcozi'),
            'shopcozi_footer_bg_image' => bc_plugin_url.'inc/shopcozi/img/footer_bg.jpg',

        	'shopcozi_topbar_show' => true,
            'shopcozi_topbar_content' => shopcozi_header_topbar_default_data(),
            'shopcozi_topbar_icons' => shopcozi_header_topbar_icons_default_data(),
            'shopcozi_topbar_icons_target' => true,

            'shopcozi_slider_show' => true,
            'shopcozi_slider_container_width' => 'container',
            'shopcozi_slider_content' => shopcozi_homepage_slider_default_data(),
            'shopcozi_slider_animation_start' => 'fadeIn',
            'shopcozi_slider_animation_end' => 'fadeIn',
            'shopcozi_slider_speed' => 5000,
            'shopcozi_slider_r_content_show' => true,
            'shopcozi_slider_r_content' => shopcozi_homepage_slider_r_content_default_data(),
            'shopcozi_slider_r_height' => 166,

            'shopcozi_service_show' => true,
            'shopcozi_service_title' => '',
            'shopcozi_service_content' => shopcozi_homepage_service_default_data(),
            'shopcozi_service_style' => 'two',
            'shopcozi_service_column' => 4,

            'shopcozi_p_recent_title' => __('Latest Products','shopcozi'),

            'shopcozi_banner_show' => true,
            'shopcozi_banner_title' => __('Trending Products Offers','shopcozi'),
            'shopcozi_banner_slider_show' => true,
            'shopcozi_banner_slider_nav_show' => true,
            'shopcozi_banner_slider_nav_position' => 'default', // style1
            'shopcozi_banner_slider_dots_show' => true,
            'shopcozi_banner_content' => shopcozi_homepage_banner_default_data(),

            'shopcozi_testimonial_show' => true,
            'shopcozi_testimonial_title' => __('Our Customer Reviews','shopcozi'),
            'shopcozi_testimonial_slider_show' => true,
            'shopcozi_testimonial_slider_nav_show' => true,
            'shopcozi_testimonial_slider_nav_position' => 'default', // style1
            'shopcozi_testimonial_slider_dots_show' => true,
            'shopcozi_testimonial_content' => shopcozi_homepage_testimonial_default_data(),

            'shopcozi_news_title' => __('Latest News and Events','shopcozi'),
        );

        $data = array_merge( $old_data, $data );
        return $data;
    }
    add_filter('shopcozi_default_options','bc_shopcozi_default_options', 20);
}

function shopcozi_header_topbar_default_data(){
    return  array(
                array(
                    'icon' => 'fa-solid fa-envelope',
                    'text' => __('info@example.com','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-solid fa-location-dot',
                    'text' => __('29 SE Florida 33131, United States','shopcozi'),
                    'link' => '#',
                )
            );
}

function shopcozi_header_topbar_data(){
    $items = get_theme_mod('shopcozi_topbar_content');

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
                        'icon' => 'fa-solid fa-envelope',
                        'text' => 'info@example.com',
                        'link' => '#',
                    ));
        }
    }else{
        $val = shopcozi_header_topbar_default_data();
    }

    return $val;
}

function shopcozi_header_topbar_icons_default_data(){
    return  array(
                array(
                    'icon' => 'fab fa-facebook-f',
                    'link' => '#'
                ),
                array(
                    'icon' => 'fab fa-twitter',
                    'link' => '#'
                ),
                array(
                    'icon' => 'fab fa-instagram',
                    'link' => '#'
                ),
                array(
                    'icon' => 'fab fa-linkedin-in',
                    'link' => '#'
                )
            );
}

function shopcozi_header_topbar_icons_data(){
    $items = get_theme_mod('shopcozi_topbar_icons');

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
                        'icon' => 'fab fa-facebook-f',
                        'link' => '#'
                    ));
        }
    }else{
        $val = shopcozi_header_topbar_icons_default_data();
    }

    return $val;
}

function shopcozi_homepage_slider_default_data(){
    $slider_data = array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slide-1.jpg',
                    ),
                    'bg_overlay' => '',
                    'subtitle' => __('Summer Sale 50% OFF','shopcozi'),
                    'subtitle_color' => '1b2942',
                    'title' => __('Mens Business Collection','shopcozi'),
                    'title_color' => '1b2942',
                    'desc' => __('Lorem ipsum dolor sit amet consectetur adipiscing elited do amet dolor sit niam...','shopcozi'),
                    'desc_color' => '1b2942',
                    'button1_label' => __('Shop Now','shopcozi'),
                    'button1_link' => '#',
                    'button1_target' => false,
                    'right_image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slide-1-1.png',
                    ),
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slide-2.jpg',
                    ),
                    'bg_overlay' => '',
                    'subtitle' => __('Winter Sale 35% OFF','shopcozi'),
                    'subtitle_color' => 'ffffff',
                    'title' => __('New Fall/Winter Collection','shopcozi'),
                    'title_color' => 'ffffff',
                    'desc' => __('Lorem ipsum dolor sit amet consectetur adipiscing elited do amet dolor sit niam...','shopcozi'),
                    'desc_color' => 'ffffff',
                    'button1_label' => __('Shop Now','shopcozi'),
                    'button1_link' => '#',
                    'button1_target' => false,
                    'right_image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slide-2-1.png',
                    ),
                ),
            );

    return  apply_filters('shopcozi_slider_default_data', $slider_data);
}

function shopcozi_homepage_slider_data(){
    $items = get_theme_mod('shopcozi_slider_content');

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
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slide-1.jpg',
                        'id'=>51
                    ),
                    'bg_overlay' => '',
                    'subtitle' => 'Summer Sale 70% OFF',
                    'title' => 'Iphone',
                    'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elited do niam.',
                    'align' => 'start',
                    'button1_label' => 'Shop Now',
                    'button1_link' => '#',
                    'button1_target' => false,
                    'right_image' => '',
                    ));
        }
    }else{
        $val = shopcozi_homepage_slider_default_data();
    }

    return $val;
}

function shopcozi_homepage_slider_r_content_default_data(){

    $slider_right_data = array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slider-right-1.jpg',
                    ),
                    'title' => __('Trending Women Clothing','shopcozi'),
                    'desc' => __('Start price at $249','shopcozi'),
                    'button_label' => __('Shop Now','shopcozi'),
                    'button_link' => '#',
                    'button_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slider-right-2.jpg',
                    ),
                    'title' => __('New Winter Collection','shopcozi'),
                    'desc' => __('Start price at $199','shopcozi'),
                    'button_label' => __('Shop Now','shopcozi'),
                    'button_link' => '#',
                    'button_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slider-right-3.jpg',
                    ),
                    'title' => __('New Summer Collection','shopcozi'),
                    'desc' => __('Start price at $349','shopcozi'),
                    'button_label' => __('Shop Now','shopcozi'),
                    'button_link' => '#',
                    'button_target' => false,
                ),
            );

    return  apply_filters('shopcozi_slider_right_default_data', $slider_right_data);
}

function shopcozi_homepage_slider_r_content_data(){
    $items = get_theme_mod('shopcozi_slider_r_content');

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
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/slider-right-1.jpg',
                        'id'=>54
                    ),
                    'title' => 'Amazing Fashion Style',
                    'desc' => 'Start from $149',
                    'align' => 'start',
                    'button_label' => 'Shop Now',
                    'button_link' => '#',
                    'button_target' => false,
                    ));
        }
    }else{
        $val = shopcozi_homepage_slider_r_content_default_data();
    }

    return $val;
}

function shopcozi_homepage_service_default_data(){
    return  array(
                array(
                    'icon' => 'fa-solid fa-phone',
                    'title' => __('Fast & Free Shipping','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-regular fa-clock',
                    'title' => __('Expert Customer Service','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-regular fa-clock',
                    'title' => __('Free gift wrapping','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-regular fa-clock',
                    'title' => __('24x7 Support','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet','shopcozi'),
                    'link' => '#',
                ),
            );
}


function shopcozi_homepage_service_data(){
    $items = get_theme_mod('shopcozi_service_content');

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
                    'icon' => 'fa-solid fa-phone',
                    'title' => 'Free Shipping',
                    'desc' => 'Lorem ipsum dolor sit amet',
                    'link' => '#',
                    ));
        }
    }else{
        $val = shopcozi_homepage_service_default_data();
    }

    return $val;
}

function shopcozi_homepage_banner_default_data(){
    $banner_data = array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/banner-1.png',
                    ),
                    'subtitle' => __('Up To 20% Off','shopcozi'),
                    'title' => __('New Apple Smart Watch','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet consectetur adipiscing elited do amet dolor sit niam ipsum dolor sit amet...','shopcozi'),
                    'button_label' => __('Shop Now','shopcozi'),
                    'button_link' => '#',
                    'button_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/banner-2.png',
                    ),
                    'subtitle' => __('Up To 35% Off','shopcozi'),
                    'title' => __('New Mackbook Pro','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet consectetur adipiscing elited do amet dolor sit niam ipsum dolor sit amet...','shopcozi'),
                    'button_label' => __('Shop Now','shopcozi'),
                    'button_link' => '#',
                    'button_target' => false,
                ),
            );

    return  apply_filters('shopcozi_banner_default_data', $banner_data);
}

function shopcozi_homepage_banner_data(){
    $items = get_theme_mod('shopcozi_banner_content');

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
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/banner-1.png',
                        'id'=>61
                    ),
                    'subtitle' => 'Up To 30% Off',
                    'title' => 'New Apple Watch',
                    'desc' => 'New Collection 2022',
                    'button_label' => 'Shop Now',
                    'button_link' => '#',
                    'button_target' => false,
                    ));
        }
    }else{
        $val = shopcozi_homepage_banner_default_data();
    }

    return $val;
}

function shopcozi_homepage_testimonial_default_data(){
    $testimonial_data = array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/testi1.png',
                    ),
                    'title' => __('Marc Cuban','shopcozi'),
                    'designation' => __('CEO','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/testi2.png',
                    ),
                    'title' => __('Anna Domovnicka','shopcozi'),
                    'designation' => __('Manager','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/testi3.png',
                    ),
                    'title' => __('Monica Amster','shopcozi'),
                    'designation' => __('CEO','shopcozi'),
                    'desc' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','shopcozi'),
                    'link' => '#',
                ),
            );

    return  apply_filters('shopcozi_testimonial_default_data', $testimonial_data);
}

function shopcozi_homepage_testimonial_data(){
    $items = get_theme_mod('shopcozi_testimonial_content');

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
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shopcozi/img/testi-1.png',
                        'id'=>63
                    ),
                    'title' => 'Eileen Arcilla',
                    'designation' => 'Co-founder',
                    'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'link' => '#',
                    ));
        }
    }else{
        $val = shopcozi_homepage_testimonial_default_data();
    }

    return $val;
}

function shopcozi_footer_above_content_default_data(){
    return  array(
                array(
                    'icon' => 'fa-solid fa-synagogue',
                    'title' => __('Everyday fresh products','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-solid fa-taxi',
                    'title' => __('Free delivery for order over $70','shopcozi'),
                    'link' => '#',
                ),
                array(
                    'icon' => 'fa-solid fa-percent',
                    'title' => __('Daily Mega Discounts','shopcozi'),
                    'link' => '#',
                ),
               
            );
}

function shopcozi_footer_above_content_data(){
    $items = get_theme_mod('shopcozi_footer_above_content');

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
                    'icon' => 'fa-solid fa-synagogue',
                    'title' => 'Everyday fresh products',
                    'link' => '#',
                    ));
        }
    }else{
        $val = shopcozi_footer_above_content_default_data();
    }

    return $val;
}