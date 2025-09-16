<?php
function bc_shop2u_customizer_slider_section( $wp_customize ){

	global $shop2u_options;

	// Frontpage Sections Panel
	$wp_customize->add_panel( 'shop2u_frontpage',
		array(
			'priority'       => 33,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Shop2u Homepage Sections','shop2u'),
		)
	);

		// Homepage Slider
		$wp_customize->add_section( 'slider_section',
			array(
				'priority'    => 1,
				'title'       => esc_html__('Section Slider','shop2u'),
				'panel'       => 'shop2u_frontpage',
			)
		);

			// shop2u_slider_disable
			$wp_customize->add_setting('shop2u_slider_disable',
					array(
						'sanitize_callback' => 'shop2u_sanitize_checkbox',
						'default'           => $shop2u_options['shop2u_slider_disable'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shop2u_slider_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'shop2u'),
					'section'     => 'slider_section',
				)
			);

			// shop2u_slider_content
			$wp_customize->add_setting('shop2u_slider_content',array(
					'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 2,
					'default'           => $shop2u_options['shop2u_slider_content'],
				) );

			$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_slider_content',
					array(
						'label'         => esc_html__('Slider Content','shop2u'),
						'section'       => 'slider_section',
						'live_title_id' => 'text', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
						'max_item'      => 3,
						'limited_msg' 	=> shop2u_upgrade_pro_msg(),
						'fields'    => array(
							'icon_type'  => array(
								'title' => esc_html__('Custom icon','shop2u'),
								'type'  =>'select',
								'options' => array(
									//'icon' => esc_html__('Icon', 'shop2u'),
									'image' => esc_html__('image','shop2u'),
								),
							),
							'icon'  => array(
								'title' => esc_html__('Icon','shop2u'),
								'type'  =>'icon',
								'required' => array('icon_type','=','icon'),
							),
							'image'  => array(
								'title' => esc_html__('Image','shop2u'),
								'type'  =>'media',
								'required' => array('icon_type','=','image'),
							),
							'subtitle' => array(
								'title' => esc_html__('Subtitle','shop2u'),
								'type'  =>'textarea',
								'desc'  => '',
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
							'button1_label' => array(
								'title' => esc_html__('Button1 Label','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button1_link' => array(
								'title' => esc_html__('Button1 Link','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button1_target' => array(
								'title' => esc_html__('Button1 open in new tab?','shop2u'),
								'type'  =>'checkbox',
								'desc'  => '',
							),							
						),
					)
				)
			);

			// shop2u_slider_left_disable
			$wp_customize->add_setting('shop2u_slider_left_disable',
					array(
						'sanitize_callback' => 'shop2u_sanitize_checkbox',
						'default'           => $shop2u_options['shop2u_slider_left_disable'],
						'priority'          => 7,
					)
				);
			$wp_customize->add_control('shop2u_slider_left_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide left info section?', 'shop2u'),
					'section'     => 'slider_section',
				)
			);

			// shop2u_slider_left_content
			$wp_customize->add_setting('shop2u_slider_left_content',array(
					'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 8,
					'default'           => $shop2u_options['shop2u_slider_left_content'],
				) );

			$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_slider_left_content',
					array(
						'label'         => esc_html__('Info Content','shop2u'),
						'section'       => 'slider_section',
						'live_title_id' => 'text', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
						'max_item'      => 2,
						'limited_msg' 	=> shop2u_upgrade_pro_msg(),
						'fields'    => array(
							'image'  => array(
								'title' => esc_html__('Image','shop2u'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),
							'subtitle' => array(
								'title' => esc_html__('Subtitle','shop2u'),
								'type'  =>'textarea',
								'desc'  => '',
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
							'button_label' => array(
								'title' => esc_html__('Button Label','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button_link' => array(
								'title' => esc_html__('Button Link','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button_target' => array(
								'title' => esc_html__('Button open in new tab?','shop2u'),
								'type'  =>'checkbox',
								'desc'  => '',
							),							
						),
					)
				)
			);
}
add_action('customize_register','bc_shop2u_customizer_slider_section');