<?php
function bc_shopcozi_customizer_banner_settings( $wp_customize ){

	$option = shopcozi_default_options();

		// Banner Section
		$wp_customize->add_section( 'section_banner',
			array(
				'priority'    => 25,
				'title'       => esc_html__('Section Banner','shopcozi'),
				'panel'       => 'shopcozi_homepage',
			)
		);

			// shopcozi_banner_show
			$wp_customize->add_setting('shopcozi_banner_show',
					array(
						'sanitize_callback' => 'shopcozi_sanitize_checkbox',
						'default'           => $option['shopcozi_banner_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shopcozi_banner_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'shopcozi'),
					'section'     => 'section_banner',
				)
			);

			// shopcozi_banner_title
			$wp_customize->add_setting('shopcozi_banner_title',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $option['shopcozi_banner_title'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('shopcozi_banner_title',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'shopcozi'),
					'section'     => 'section_banner',
				)
			);

			// shopcozi_banner_content
			$wp_customize->add_setting('shopcozi_banner_content',array(
					'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 3,
					'default'           => $option['shopcozi_banner_content'],
				) );

			$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_banner_content',
					array(
						'label'         => esc_html__('Banner Content','shopcozi'),
						'section'       => 'section_banner',
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
							// 	//'required' => array('icon_type','=','icon'),
							// ),
							'image'  => array(
								'title' => esc_html__('Image','shopcozi'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),
							'subtitle' => array(
								'title' => esc_html__('Subtitle','shopcozi'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'title' => array(
								'title' => esc_html__('Title','shopcozi'),
								'type'  =>'textarea',
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
add_action('customize_register','bc_shopcozi_customizer_banner_settings');