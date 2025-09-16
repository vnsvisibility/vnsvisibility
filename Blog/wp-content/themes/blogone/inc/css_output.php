<?php
if ( ! function_exists( 'blogone_get_dynamic_css' ) ) :
	function blogone_get_dynamic_css() {

		$option = blogone_theme_options();

		// Calling Shopcozi_CSS class for generate dynamic css
		$pro_css = new Blogone_CSS;

		$body_bg_color = get_background_color();
		if($body_bg_color==''){
		 	$body_bg_color = 'ffffff';
		}
		list($body_r, $body_g, $body_b) = sscanf( '#'.$body_bg_color, "#%02x%02x%02x" );

		$logo_width = json_decode($option['blogone_h_logo_width']);
		$site_title = json_decode($option['blogone_h_site_title_fontsize']);
		$site_desc = json_decode($option['blogone_h_site_desc_fontsize']);

		$breadcrumb_bg_color = $option['blogone_breadcrumb_bg_color'];
		$breadcrumb_bg_image = $option['blogone_breadcrumb_bg_image'];
		$breadcrumb_attachment = $option['blogone_breadcrumb_attachment'];
		$breadcrumb_repeat = $option['blogone_breadcrumb_repeat'];
		$breadcrumb_position = $option['blogone_breadcrumb_position'];
		$breadcrumb_size = $option['blogone_breadcrumb_size'];
		$breadcrumb_overlay = $option['blogone_breadcrumb_overlay'];
		$breadcrumb_height = json_decode($option['blogone_breadcrumb_height']);

		$footer_bg_color = $option['blogone_footer_bg_color'];
		$footer_bg_image = $option['blogone_footer_bg_image'];
		$footer_attachment = $option['blogone_footer_bg_attachment'];
		$footer_repeat = $option['blogone_footer_bg_repeat'];
		$footer_position = $option['blogone_footer_bg_position'];
		$footer_size = $option['blogone_footer_bg_size'];
		$footer_overlay = $option['blogone_footer_overlay'];

		// Accent color 1
		$accent_color = $option['blogone_accent_color'];
		list($r, $g, $b) = sscanf( $accent_color, "#%02x%02x%02x" );

		// Heading Color
		$heading_color = $option['blogone_heading_color'];

		// Text Color
		$text_color = $option['blogone_text_color'];
		
		// All Root Vaiables
		$pro_css->set_selector( ':root' );		
		$pro_css->add_property( '--bs-body-bg-color', esc_attr($body_bg_color));
		$pro_css->add_property( '--bs-primary', esc_attr($accent_color));
		$pro_css->add_property( '--bs-primary-r', esc_attr($r));
		$pro_css->add_property( '--bs-primary-g', esc_attr($g));
		$pro_css->add_property( '--bs-primary-b', esc_attr($b));
		$pro_css->add_property( '--bs-primary-lite', blogone_convertRGBAtoHEX6('rgba('.esc_attr($r).', '.esc_attr($g).', '.esc_attr($b).', .1)'));
		$pro_css->add_property( '--bs-primary-lite2', blogone_convertRGBAtoHEX6('rgba('.esc_attr($r).', '.esc_attr($g).', '.esc_attr($b).', .2)'));
		$pro_css->add_property( '--bs-heading', esc_attr($heading_color));
		$pro_css->add_property( '--bs-text', esc_attr($text_color));

		$pro_css->add_property( '--breadcrumb-bg-color', esc_attr($breadcrumb_bg_color));
		$pro_css->add_property( '--breadcrumb-bg-image', 'url('.esc_url($breadcrumb_bg_image).')');
		$pro_css->add_property( '--breadcrumb-bg-attachment', esc_attr($breadcrumb_attachment));
		$pro_css->add_property( '--breadcrumb-bg-repeat', esc_attr($breadcrumb_repeat));
		$pro_css->add_property( '--breadcrumb-bg-position', esc_attr($breadcrumb_position));
		$pro_css->add_property( '--breadcrumb-bg-size', esc_attr($breadcrumb_size));
		$pro_css->add_property( '--breadcrumb-bg-overlay', esc_attr($breadcrumb_overlay));

		$pro_css->add_property( '--footer-bg-color', esc_attr($footer_bg_color));
		$pro_css->add_property( '--footer-bg-image', 'url("'.esc_url($footer_bg_image).'")');
		$pro_css->add_property( '--footer-bg-attachment', esc_attr($footer_attachment));
		$pro_css->add_property( '--footer-bg-repeat', esc_attr($footer_repeat));
		$pro_css->add_property( '--footer-bg-position', esc_attr($footer_position));
		$pro_css->add_property( '--footer-bg-size', esc_attr($footer_size));
		$pro_css->add_property( '--footer-bg-overlay', esc_attr($footer_overlay));	
		$pro_css->add_property( '--footer-bg-overlay-primary', 'rgb('.esc_attr($r).' '.esc_attr($g).' '.esc_attr($b).' / 89%)');	

		// Desktop CSS
		$pro_css->start_media_query( apply_filters( 'blogone_desktop_media_query', '(min-width:991px)' ) );
			if(isset($logo_width->desktop)){
				$pro_css->set_selector('.bs-logo img');
				$pro_css->add_property('width', esc_attr($logo_width->desktop).'px');
			}

			if(isset($site_title->desktop)){
				$pro_css->set_selector('.site-title');
				$pro_css->add_property('font-size', esc_attr($site_title->desktop).'px');
			}

			if(isset($site_desc->desktop)){
				$pro_css->set_selector('.site-description');
				$pro_css->add_property('font-size', esc_attr($site_desc->desktop).'px');
			}

			if(isset($breadcrumb_height->desktop)){
				$pro_css->set_selector('.breadcrumb-area');
				$pro_css->add_property('min-height', esc_attr($breadcrumb_height->desktop).'px');
			}
		$pro_css->stop_media_query();

		// Tablet CSS
		$pro_css->start_media_query( apply_filters( 'blogone_tablet_media_query', '(min-width:768px) and (max-width:991px)' ) );
			if(isset($logo_width->tablet)){
				$pro_css->set_selector('.bs-logo img');
				$pro_css->add_property('width', esc_attr($logo_width->tablet).'px');
			}

			if(isset($site_title->tablet)){
				$pro_css->set_selector('.site-title');
				$pro_css->add_property('font-size', esc_attr($site_title->tablet).'px');
			}

			if(isset($site_desc->tablet)){
				$pro_css->set_selector('.site-description');
				$pro_css->add_property('font-size', esc_attr($site_desc->tablet).'px');
			}

			if(isset($breadcrumb_height->tablet)){
				$pro_css->set_selector('.breadcrumb-area');
				$pro_css->add_property('min-height', esc_attr($breadcrumb_height->tablet).'px');
			}
		$pro_css->stop_media_query();

		// Mobile CSS
		$pro_css->start_media_query( apply_filters( 'blogone_mobile_media_query', '(max-width:768px)' ) );
			if(isset($logo_width->mobile)){
				$pro_css->set_selector('.bs-logo img');
				$pro_css->add_property('width', esc_attr($logo_width->mobile).'px');
			}

			if(isset($site_title->mobile)){
				$pro_css->set_selector('.site-title');
				$pro_css->add_property('font-size', esc_attr($site_title->mobile).'px');
			}

			if(isset($site_desc->mobile)){
				$pro_css->set_selector('.site-description');
				$pro_css->add_property('font-size', esc_attr($site_desc->mobile).'px');
			}

			if(isset($breadcrumb_height->mobile)){
				$pro_css->set_selector('.breadcrumb-area');
				$pro_css->add_property('min-height', esc_attr($breadcrumb_height->mobile).'px');
			}
		$pro_css->stop_media_query();

		return apply_filters( 'blogone_pro_dynamic_css', wp_strip_all_tags( $pro_css->css_output() ) );
	}
endif;

if ( ! function_exists( 'blogone_enqueue_dynamic_css' ) ) :
	function blogone_enqueue_dynamic_css() {
		$css = blogone_get_dynamic_css();
		wp_add_inline_style( 'blogone-style', wp_strip_all_tags( $css ) );
	}
	add_action( 'wp_enqueue_scripts', 'blogone_enqueue_dynamic_css');
endif;