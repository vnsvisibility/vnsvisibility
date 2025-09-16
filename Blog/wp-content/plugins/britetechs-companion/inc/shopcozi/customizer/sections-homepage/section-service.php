<?php
function bc_shopcozi_customizer_service_settings( $wp_customize ){

	$option = shopcozi_default_options();

		// Service Section
		$wp_customize->add_section( 'section_service',
			array(
				'priority'    => 5,
				'title'       => esc_html__('Section Service','shopcozi'),
				'panel'       => 'shopcozi_homepage',
			)
		);

			// shopcozi_service_show
			$wp_customize->add_setting('shopcozi_service_show',
					array(
						'sanitize_callback' => 'shopcozi_sanitize_checkbox',
						'default'           => $option['shopcozi_service_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shopcozi_service_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'shopcozi'),
					'section'     => 'section_service',
				)
			);

			// shopcozi_service_title
			$wp_customize->add_setting('shopcozi_service_title',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $option['shopcozi_service_title'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('shopcozi_service_title',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'shopcozi'),
					'section'     => 'section_service',
				)
			);

			// shopcozi_service_content
			$wp_customize->add_setting('shopcozi_service_content',array(
					'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 3,
					'default'           => $option['shopcozi_service_content'],
				) );

			$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_service_content',
					array(
						'label'         => esc_html__('Service Content','shopcozi'),
						'section'       => 'section_service',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shopcozi'), // [live_title]
						'max_item'      => 4,
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
							'icon'  => array(
								'title' => esc_html__('Icon','shopcozi'),
								'type'  =>'icon',
								//'required' => array('icon_type','=','icon'),
							),
							// 'image'  => array(
							// 	'title' => esc_html__('Image','shopcozi'),
							// 	'type'  =>'media',
							// 	//'required' => array('icon_type','=','image'),
							// ),
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
							'link' => array(
								'title' => esc_html__('Link','shopcozi'),
								'type'  =>'text',
								'desc'  => '',
							),
							
						),
					)
				)
			);
}
add_action('customize_register','bc_shopcozi_customizer_service_settings');