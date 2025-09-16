<?php
function bc_shop2u_customizer_footer( $wp_customize ){

	global $shop2u_options;
	
		// shop2u_footer_above_content
		$wp_customize->add_setting('shop2u_footer_above_content',array(
				'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 2,
				'default'           => $shop2u_options['shop2u_footer_above_content'],
			) );

		$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_footer_above_content',
				array(
					'label'         => esc_html__('Above Content','shop2u'),
					'section'       => 'footer_above',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
					'max_item'      => 4,
					'limited_msg' 	=> shop2u_upgrade_pro_msg(),
					'fields'    => array(
						'image'  => array(
							'title' => esc_html__('Image','shop2u'),
							'type'  =>'media',
							//'required' => array('icon_type','=','image'),
						),
						'title' => array(
							'title' => esc_html__('Title','shop2u'),
							'type'  =>'textarea',
							'desc'  => '',
						),
						'desc' => array(
							'title' => esc_html__('Description','shop2u'),
							'type'  =>'textarea',
							'desc'  => '',
						),							
					),
				)
			)
		);

		// shop2u_footer_bg_image
		$wp_customize->add_setting('shop2u_footer_bg_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => $shop2u_options['shop2u_footer_bg_image'],
					'priority'          => 2,
				)
			);
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'shop2u_footer_bg_image',
			array(
				'label' 		=> esc_html__('Background Image', 'shop2u'),
				'section' 		=> 'footer_background',
			)
		) );			

		// shop2u_footer_bg_attachment
		$wp_customize->add_setting('shop2u_footer_bg_attachment',
				array(
					'sanitize_callback' => 'shop2u_sanitize_select',
					'default'           => $shop2u_options['shop2u_footer_bg_attachment'],
					'priority'          => 3,
				)
			);
		$wp_customize->add_control('shop2u_footer_bg_attachment',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Background Attachment', 'shop2u'),
				'section'     => 'footer_background',
				'choices'     => array(
					'scroll' => __('Scroll','shop2u'),
					'fixed' => __('Fixed','shop2u'),
				),
			)
		);
}
add_action('customize_register','bc_shop2u_customizer_footer');