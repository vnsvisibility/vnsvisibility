<?php
if( ! function_exists('blogone_enqueue_scripts') ):
	function blogone_enqueue_scripts(){
		$theme = wp_get_theme();
	    $version = $theme->get('Version');
		wp_enqueue_style('blogone-fonts', blogone_fonts_url(), array(), $version);

		// CSS files		
		wp_enqueue_style('bootstrap-min',get_template_directory_uri().'/css/bootstrap.min.css');
		wp_enqueue_style('animate-min',get_template_directory_uri().'/css/animate.min.css');
		wp_enqueue_style('blogone-main',get_template_directory_uri().'/css/main.css');
		wp_enqueue_style('blogone-responsive',get_template_directory_uri().'/css/responsive.css');
		wp_enqueue_style('blogone-widget',get_template_directory_uri().'/css/widget.css');
		wp_enqueue_style('animation',get_template_directory_uri().'/css/animation.css');
		wp_enqueue_style('owl-carousel-min',get_template_directory_uri().'/css/owl.carousel.min.css');
		wp_enqueue_style('fontawesome-min',get_template_directory_uri().'/css/all.min.css');
		wp_enqueue_style('bootstrap-icons',get_template_directory_uri().'/css/bootstrap-icons/font/bootstrap-icons.css');
		wp_enqueue_style('blogone-style',get_stylesheet_uri());	

		// JS files
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap-bundle-min',get_template_directory_uri().'/js/bootstrap.bundle.min.js',array('jquery'),false,true);
		wp_enqueue_script('owl-carousel-min',get_template_directory_uri().'/js/owl.carousel.min.js','',false,true);
		wp_enqueue_script('wow-min',get_template_directory_uri().'/js/wow.min.js','',false,true);
		wp_enqueue_script('blogone-main',get_template_directory_uri().'/js/main.js','',false,true);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if( defined('ICL_LANGUAGE_CODE') ){
			$ajax_url = admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE, 'relative');
		}else{
			$ajax_url = admin_url('admin-ajax.php', 'relative');
		}

		$blogone_params = array(
			'ajax_url' => $ajax_url,
		);
		wp_localize_script('blogone-main', 'blogone_params', $blogone_params);
	}
	add_action( 'wp_enqueue_scripts', 'blogone_enqueue_scripts' );
endif;

if( ! function_exists('blogone_admin_enqueue_scripts') ):
	function blogone_admin_enqueue_scripts(){
		wp_enqueue_media();
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');

		wp_enqueue_style('blogone_admin_style',get_template_directory_uri().'/css/admin_style.css');
		wp_enqueue_script('blogone_admin_js',get_template_directory_uri().'/js/admin_main.js');

		$admin_texts = array(
			'select_images' 			=> esc_html__('Select Images', 'blogone')
			,'use_images' 				=> esc_html__('Use images', 'blogone')
			,'choose_an_image' 			=> esc_html__('Choose an image', 'blogone')
			,'use_image' 				=> esc_html__('Use image', 'blogone')
			,'delete_sidebar_confirm' 	=> esc_html__('Do you want to delete this sidebar?', 'blogone')
			,'delete_sidebar_failed' 	=> esc_html__('Cant delete the sidebar. Please try again!', 'blogone')
			,'view_posts_button_label' 	=> esc_html__('View Posts', 'blogone')
			,'edit_post_button_label' 	=> esc_html__('Edit Post', 'blogone')
		);

		$post_types = array('sc_custom_block');
		$edit_post_url_pattern = array();
		
		$elementor_cpt_support = get_option( 'elementor_cpt_support', array() );
		foreach( $post_types as $post_type ){
			$enabled_elementor = class_exists('Elementor\Plugin') && in_array( $post_type, $elementor_cpt_support );
			$edit_post_url_pattern[$post_type] = add_query_arg(
					array(
						'post' 		=> '[post_id]'
						,'action' 	=> $enabled_elementor ? 'elementor' : 'edit'
					),
					admin_url( 'post.php' )
				);
		}
		
		$admin_texts['edit_post_url_pattern'] = $edit_post_url_pattern;
		$admin_texts['view_posts_url_pattern'] = add_query_arg(
					array(
						'post_type' 		=> '[post_type]'
					),
					admin_url( 'edit.php' )
				);
		
		wp_localize_script('blogone_admin_js', 'blogone_admin_texts', $admin_texts);

		wp_localize_script( 'blogone_admin_js', 'blogone_ajax_object',
	        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	    );
	}
	add_action( 'admin_enqueue_scripts', 'blogone_admin_enqueue_scripts' );
endif;