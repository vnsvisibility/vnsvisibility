<?php
function bc_shop2u_customizer_testimonial_section( $wp_customize ){

	global $shop2u_options;

		// Homepage Funfect
		$wp_customize->add_section( 'testimonial_section',
			array(
				'priority'    => 8,
				'title'       => esc_html__('Section Testimonial','shop2u'),
				'panel'       => 'shop2u_frontpage',
			)
		);

			// shop2u_testimonial_disable
			$wp_customize->add_setting('shop2u_testimonial_disable',
					array(
						'sanitize_callback' => 'shop2u_sanitize_checkbox',
						'default'           => $shop2u_options['shop2u_testimonial_disable'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shop2u_testimonial_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'shop2u'),
					'section'     => 'testimonial_section',
				)
			);

			// shop2u_testimonial_subtitle
			$wp_customize->add_setting('shop2u_testimonial_subtitle',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_testimonial_subtitle'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('shop2u_testimonial_subtitle',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Subtitle', 'shop2u'),
					'section'     => 'testimonial_section',
				)
			);

			// shop2u_testimonial_title
			$wp_customize->add_setting('shop2u_testimonial_title',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_testimonial_title'],
						'priority'          => 3,
					)
				);
			$wp_customize->add_control('shop2u_testimonial_title',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'shop2u'),
					'section'     => 'testimonial_section',
				)
			);

			// shop2u_testimonial_desc
			$wp_customize->add_setting('shop2u_testimonial_desc',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_testimonial_desc'],
						'priority'          => 4,
					)
				);
			$wp_customize->add_control('shop2u_testimonial_desc',
				array(
					'type'        => 'textarea',
					'label'       => esc_html__('Description', 'shop2u'),
					'section'     => 'testimonial_section',
				)
			);

			// shop2u_testimonial_content
			$wp_customize->add_setting('shop2u_testimonial_content',array(
					'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 5,
					'default'           => $shop2u_options['shop2u_testimonial_content'],
				) );

			$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_testimonial_content',
					array(
						'label'         => esc_html__('Testimonial Content','shop2u'),
						'section'       => 'testimonial_section',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
						'max_item'      => 2,
						'limited_msg' 	=> shop2u_upgrade_pro_msg(),
						'fields'    => array(
							'image'  => array(
								'title' => esc_html__('Image','shop2u'),
								'type'  =>'media',
								//'required' => array('icon_type','=','image'),
							),
							'title' => array(
								'title' => esc_html__('Title','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'position' => array(
								'title' => esc_html__('Position','shop2u'),
								'type'  =>'text',
								'desc'  => '',
							),
							'desc' => array(
								'title' => esc_html__('Description','shop2u'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'rating' => array(
								'title' => esc_html__('Rating','shop2u'),
								'type'  =>'select',
								'desc'  => '',
								'options'  => array(
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
								),
							),
						),
					)
				)
			);
}
add_action('customize_register','bc_shop2u_customizer_testimonial_section');