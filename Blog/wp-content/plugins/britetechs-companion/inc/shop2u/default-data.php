<?php

if( ! function_exists('bc_shop2u_theme_default_data') ){
	function bc_shop2u_theme_default_data( $old_data ){
		$data = array(
        'shop2u_topbar_disable' => false,
        'shop2u_topbar_left_content' => shop2u_above_left_default_data(),            
        'shop2u_topbar_right_content' => shop2u_above_right_default_data(),
        'shop2u_bottom_r_icon' => 'fas fa-headphones',      
        'shop2u_bottom_r_title' => __('Callus Now:','shop2u'),      
        'shop2u_bottom_r_desc' => sprintf(__('<a href="tel:+22 060 712 34">+22 060 712 34</a>','shop2u')),
        'shop2u_breadcrumb_bg_image' => bc_plugin_url.'inc/shop2u/img/sub_header.jpg',

        'shop2u_slider_content' => shop2u_homepage_slider_default_data(),
        'shop2u_slider_left_content' => shop2u_homepage_slider_left_content_default_data(),
        'shop2u_prod_recent_subtitle'=> __('New','shop2u'),
        'shop2u_prod_recent_title'=> __('Latest Products','shop2u'),
        'shop2u_banner_content' => shop2u_homepage_banner_default_data(),
        'shop2u_testimonial_subtitle'=> __('Feedback','shop2u'),
        'shop2u_testimonial_title'=> __('Customers Reviews','shop2u'),
        'shop2u_testimonial_content' => shop2u_homepage_testimonial_default_data(),
        'shop2u_blog_subtitle'=> __('News','shop2u'),
        'shop2u_blog_title'=> __('Latest News','shop2u'),
        'shop2u_footer_above_content' => shop2u_footer_above_default_data(),
        'shop2u_footer_copyright' => '%copy% %current_year%, All Rights Reserved.',
        'shop2u_footer_bg_image' => bc_plugin_url.'inc/shop2u/img/footer/footer_bg.jpg',
		);

        $data = array_merge( $old_data, $data );
		return $data;
	}
    add_filter('shop2u_default_data','bc_shop2u_theme_default_data', 20);
}

function shop2u_above_left_default_data(){
    return  array(
                array(
                    'title' => '15% off on your first order!',
                ),
                array(
                    'title' => 'free standard shipping on orders over $200',
                ),
            );
}

function shop2u_above_right_default_data(){
    return  array(
                array(
                    'icon' => 'fa fa-phone',
                    'title' => '+22 060 712 34',
                ),
                array(
                    'icon' => 'fa fa-envelope',
                    'title' => 'info@example.com',
                ),
            );
}

function shop2u_homepage_slider_default_data(){
    return  array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/slider/slide-01.png',
                    ),
                    'subtitle' => '30% off all order',
                    'title' => 'Spring Collections',
                    'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elited do niam.',
                    'button1_label' => 'Order Now',
                    'button1_link' => '#',
                    'button1_target' => false,
                    'button2_label' => 'Read More',
                    'button2_link' => '#',
                    'button2_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/slider/slide-02.png',
                    ),
                    'subtitle' => 'Must - Have Style',
                    'title' => 'Winter Collections',
                    'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elited do niam.',
                    'button1_label' => 'Shop Now',
                    'button1_link' => '#',
                    'button1_target' => false,
                    'button2_label' => 'Discover Now',
                    'button2_link' => '#',
                    'button2_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/slider/slide-03.png',
                    ),
                    'subtitle' => '25% Flat Discount',
                    'title' => 'Cameras Callections',
                    'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elited do niam.',
                    'button1_label' => 'Shop Now',
                    'button1_link' => '#',
                    'button1_target' => false,
                    'button2_label' => 'Details',
                    'button2_link' => '#',
                    'button2_target' => false,
                ),
            );
}

function shop2u_homepage_slider_left_content_default_data(){
    return  array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/slider/slide-04.png',
                    ),
                    'subtitle' => 'Styles For Women',
                    'title' => 'Women Collections',
                    'desc' => 'Up to 60% off',
                    'button_label' => 'See More',
                    'button_link' => '#',
                    'button_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/slider/slide-05.png',
                    ),
                    'subtitle' => 'Bag Collections',
                    'title' => 'Bags For Womens',
                    'desc' => 'Up to 75% off',
                    'button_label' => 'See More',
                    'button_link' => '#',
                    'button_target' => false,
                ),
            );
}

function shop2u_homepage_banner_default_data(){
    return  array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/banner/banner-01.jpg',
                    ),
                    'subtitle' => 'In A Cotton And Linen',
                    'title' => 'Womens Bras',
                    'desc' => 'Upto 50% off',
                    'align' => 'left',
                    'button_label' => 'Shop Now',
                    'button_link' => '#',
                    'button_target' => false,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/banner/banner-02.jpg',
                    ),
                    'subtitle' => 'An Airy Cotton T-shirt',
                    'title' => 'Mens Collections',
                    'desc' => 'Upto 25% off',
                    'align' => 'right',
                    'button_label' => 'Shop Now',
                    'button_link' => '#',
                    'button_target' => false,
                ),
            );
}

function shop2u_homepage_testimonial_default_data(){
    return  array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/testimonial/testi-01.png',
                    ),
                    'title' => 'Andrew Cameron',
                    'position' => 'Director',
                    'desc' => 'Love the conience of Shop2u and the uber friendly service. The produce is always fresh and the meat department is first class.Until recently.',
                    'rating' => 5,
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/testimonial/testi-02.png',
                    ),
                    'title' => 'Amelia Margrate',
                    'position' => 'Team Leader',
                    'desc' => 'Love the conience of Shop2u and the uber friendly service. The produce is always fresh and the meat department is first class.Until recently.',
                    'rating' => 4,
                ),
            );
}

function shop2u_footer_above_default_data(){
    return  array(
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/footer/delivery-truck.png',
                    ),
                    'title' => 'Free Shipping',
                    'desc' => 'On all US order or order above $99',
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/footer/support.png',
                    ),
                    'title' => 'Online Support',
                    'desc' => 'Contact us 24 hours a day 7 days a week',
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/footer/product-return.png',
                    ),
                    'title' => 'Easy Return',
                    'desc' => 'Simple return within 30 days for an exchange.',
                ),
                array(
                    'image' => array(
                        'url'=>bc_plugin_url.'inc/shop2u/img/footer/verified.png',
                    ),
                    'title' => 'Secure payment',
                    'desc' => 'Contact us 24 hours a day 7 days a week',
                ),
            );
}