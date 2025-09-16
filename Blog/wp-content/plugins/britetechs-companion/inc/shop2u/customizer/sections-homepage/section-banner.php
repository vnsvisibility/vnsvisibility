<?php
function bc_shop2u_customizer_banner_section( $wp_customize ){

	global $shop2u_options;

		// Homepage Funfect
		$wp_customize->add_section( 'banner_section',
			array(
				'priority'    => 4,
				'title'       => esc_html__('Section Banner','shop2u'),
				'panel'       => 'shop2u_frontpage',
			)
		);

			// shop2u_banner_disable
			$wp_customize->add_setting('shop2u_banner_disable',
					array(
						'sanitize_callback' => 'shop2u_sanitize_checkbox',
						'default'           => $shop2u_options['shop2u_banner_disable'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('shop2u_banner_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'shop2u'),
					'section'     => 'banner_section',
				)
			);

			// shop2u_banner_subtitle
			$wp_customize->add_setting('shop2u_banner_subtitle',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_banner_subtitle'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('shop2u_banner_subtitle',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Subtitle', 'shop2u'),
					'section'     => 'banner_section',
				)
			);

			// shop2u_banner_title
			$wp_customize->add_setting('shop2u_banner_title',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_banner_title'],
						'priority'          => 3,
					)
				);
			$wp_customize->add_control('shop2u_banner_title',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'shop2u'),
					'section'     => 'banner_section',
				)
			);

			// shop2u_banner_desc
			$wp_customize->add_setting('shop2u_banner_desc',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $shop2u_options['shop2u_banner_desc'],
						'priority'          => 4,
					)
				);
			$wp_customize->add_control('shop2u_banner_desc',
				array(
					'type'        => 'textarea',
					'label'       => esc_html__('Description', 'shop2u'),
					'section'     => 'banner_section',
				)
			);

			// shop2u_banner_content
			$wp_customize->add_setting('shop2u_banner_content',array(
					'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
					'transport'         => 'refresh', // refresh or postMessage
					'priority'          => 5,
					'default'           => $shop2u_options['shop2u_banner_content'],
				) );

			$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_banner_content',
					array(
						'label'         => esc_html__('Funfect Content','shop2u'),
						'section'       => 'banner_section',
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
							'subtitle' => array(
								'title' => esc_html__('Subtitle','shop2u'),
								'type'  =>'text',
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
							'align' => array(
								'title' => esc_html__('Text Align','shop2u'),
								'type'  =>'select',
								'desc'  => '',
								'options'  => array(
									'left' => __('Left','shop2u'),
									'center' => __('Center','shop2u'),
									'right' => __('Right','shop2u'),
								),
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
								'title' => esc_html__('Open in new tab','shop2u'),
								'type'  =>'checkbox',
								'desc'  => '',
							),
						),
					)
				)
			);
}
add_action('customize_register','bc_shop2u_customizer_banner_section');