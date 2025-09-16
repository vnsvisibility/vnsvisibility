<?php
function bc_shopcozi_customizer_slider_settings( $wp_customize ){

	$option = shopcozi_default_options();

	// Homepage
	$wp_customize->add_panel( 'shopcozi_homepage',
		array(
			'priority'       => 33,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Shopcozi Homepage Sections','shopcozi'),
		)
	);

		// Slider Section
		$wp_customize->add_section( 'section_slider',
			array(
				'priority'    => 1,
				'title'       => esc_html__('Section Slider','shopcozi'),
				'panel'       => 'shopcozi_homepage',
			)
		);

			// shopcozi_slider_show
			$wp_customize->add_setting('shopcozi_slider_show',
					array(
						'sanitize_callback' => 'shopcozi_sanitize_checkbox',
						'default'           => $option['shopcozi_slider_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shopcozi_slider_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'shopcozi'),
					'section'     => 'section_slider',
				)
			);

			// shopcozi_slider_content
			$wp_customize->add_setting('shopcozi_slider_content',array(
					'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 7,
					'default'           => $option['shopcozi_slider_content'],
				) );

			$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_slider_content',
					array(
						'label'         => esc_html__('Slider Content','shopcozi'),
						'section'       => 'section_slider',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shopcozi'), // [live_title]
						'max_item'      => 2,
						'limited_msg' 	=> shopcozi_upgrade_pro_msg(),
						'fields'    => array(
							// 'icon_type'  => array(
							// 	'title' => esc_html__('Custom icon','shopcozi'),
							// 	'type'  =>'select',
							// 	'options' => array(
							// 		'icon' => esc_html__('Icon', 'shopcozi'),
							// 		'image' => esc_html__('image','shopcozi'),
							// 	),
							// ),
							// 'icon'  => array(
							// 	'title' => esc_html__('Icon','shopcozi'),
							// 	'type'  =>'icon',
							// 	'required' => array('icon_type','=','icon'),
							// ),
							'image'  => array(
								'title' => esc_html__('Background Image','shopcozi'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),
							'bg_overlay' => array(
								'title' => esc_html__('Background Overlay Color','shopcozi'),
								'type'  =>'coloralpha',
								'desc'  => '',
							),
							'subtitle' => array(
								'title' => esc_html__('Subtitle','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'title' => array(
								'title' => esc_html__('Title','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'desc' => array(
								'title' => esc_html__('Description','shopcozi'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'button1_label' => array(
								'title' => esc_html__('Button1 Label','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button1_link' => array(
								'title' => esc_html__('Button1 Link','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button1_target' => array(
								'title' => esc_html__('Button1 open in new tab?','shopcozi'),
								'type'  =>'checkbox',
								'desc'  => '',
							),
							'right_image'  => array(
								'title' => esc_html__('Featured Image','shopcozi'),
								'type'  =>'media',
							),
						),
					)
				)
			);

			// shopcozi_slider_r_content_show
			$wp_customize->add_setting('shopcozi_slider_r_content_show',
					array(
						'sanitize_callback' => 'shopcozi_sanitize_checkbox',
						'default'           => $option['shopcozi_slider_r_content_show'],
						'priority'          => 8,
					)
				);
			$wp_customize->add_control('shopcozi_slider_r_content_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show right banner section?', 'shopcozi'),
					'section'     => 'section_slider',
				)
			);

			// shopcozi_slider_r_content
			$wp_customize->add_setting('shopcozi_slider_r_content',array(
					'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 9,
					'default'           => $option['shopcozi_slider_r_content'],
				) );

			$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_slider_r_content',
					array(
						'label'         => esc_html__('Slider Right Banner Content','shopcozi'),
						'section'       => 'section_slider',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shopcozi'), // [live_title]
						'max_item'      => 3,
						'limited_msg' 	=> shopcozi_upgrade_pro_msg(),
						'fields'    => array(
							// 'icon_type'  => array(
							// 	'title' => esc_html__('Custom icon','shopcozi'),
							// 	'type'  =>'select',
							// 	'options' => array(
							// 		'icon' => esc_html__('Icon', 'shopcozi'),
							// 		'image' => esc_html__('image','shopcozi'),
							// 	),
							// ),
							// 'icon'  => array(
							// 	'title' => esc_html__('Icon','shopcozi'),
							// 	'type'  =>'icon',
							// 	'required' => array('icon_type','=','icon'),
							// ),
							'image'  => array(
								'title' => esc_html__('Image','shopcozi'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),							
							'title' => array(
								'title' => esc_html__('Title','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'desc' => array(
								'title' => esc_html__('Description','shopcozi'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'button_label' => array(
								'title' => esc_html__('Button Label','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button_link' => array(
								'title' => esc_html__('Button Link','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							'button_target' => array(
								'title' => esc_html__('Button open in new tab?','shopcozi'),
								'type'  =>'checkbox',
								'desc'  => '',
							),							
						),
					)
				)
			);
}
add_action('customize_register','bc_shopcozi_customizer_slider_settings');