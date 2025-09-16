<?php
function bc_shopcozi_customizer_testimonial_settings( $wp_customize ){

	$option = shopcozi_theme_options();

		// Testimonial Section
		$wp_customize->add_section( 'section_testimonial',
			array(
				'priority'    => 30,
				'title'       => esc_html__('Section Testimonial','shopcozi'),
				'panel'       => 'shopcozi_homepage',
			)
		);

			// shopcozi_testimonial_show
			$wp_customize->add_setting('shopcozi_testimonial_show',
					array(
						'sanitize_callback' => 'shopcozi_sanitize_checkbox',
						'default'           => $option['shopcozi_testimonial_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shopcozi_testimonial_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'shopcozi'),
					'section'     => 'section_testimonial',
				)
			);

			// shopcozi_testimonial_title
			$wp_customize->add_setting('shopcozi_testimonial_title',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $option['shopcozi_testimonial_title'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('shopcozi_testimonial_title',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'shopcozi'),
					'section'     => 'section_testimonial',
				)
			);

			// shopcozi_testimonial_content
			$wp_customize->add_setting('shopcozi_testimonial_content',array(
					'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 3,
					'default'           => $option['shopcozi_testimonial_content'],
				) );

			$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_testimonial_content',
					array(
						'label'         => esc_html__('Testimonial Content','shopcozi'),
						'section'       => 'section_testimonial',
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
							// 	//'required' => array('icon_type','=','icon'),
							// ),
							'image'  => array(
								'title' => esc_html__('Photo','shopcozi'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),							
							'title' => array(
								'title' => esc_html__('Name','shopcozi'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'designation' => array(
								'title' => esc_html__('Designation','shopcozi'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'desc' => array(
								'title' => esc_html__('Review','shopcozi'),
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
add_action('customize_register','bc_shopcozi_customizer_testimonial_settings');