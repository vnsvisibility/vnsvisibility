<?php
function bc_shopcozi_customizer_header( $wp_customize ){

	$option = shopcozi_default_options();

	// Header Above Section
	$wp_customize->add_section( 'header_above',
		array(
			'priority'    => 2,
			'title'       => esc_html__('Header Topbar','shopcozi'),
			'panel'       => 'shopcozi_header',
		)
	);
		// shopcozi_topbar_show
		$wp_customize->add_setting('shopcozi_topbar_show',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_checkbox',
					'default'           => $option['shopcozi_topbar_show'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('shopcozi_topbar_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show header topbar?', 'shopcozi'),
				'section'     => 'header_above',
			)
		);

		// shopcozi_topbar_content
		$wp_customize->add_setting('shopcozi_topbar_content',array(
				'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 2,
				'default'           => $option['shopcozi_topbar_content'],
			) );

		$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_topbar_content',
				array(
					'label'         => esc_html__('Header Text','shopcozi'),
					'section'       => 'header_above',
					'live_title_id' => 'text', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','shopcozi'), // [live_title]
					'max_item'      => 2,
					'limited_msg' 	=> shopcozi_upgrade_pro_msg(),
					'fields'    => array(
						'icon_type'  => array(
							'title' => esc_html__('Custom icon','shopcozi'),
							'type'  =>'select',
							'options' => array(
								'icon' => esc_html__('Icon', 'shopcozi'),
								//'image' => esc_html__('image','shopcozi'),
							),
						),
						'icon'  => array(
							'title' => esc_html__('Icon','shopcozi'),
							'type'  =>'icon',
							'required' => array('icon_type','=','icon'),
						),
						'text' => array(
							'title' => esc_html__('Text','shopcozi'),
							'type'  =>'text',
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

		// shopcozi_topbar_icons
		$wp_customize->add_setting('shopcozi_topbar_icons',array(
			'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
			'transport' => 'refresh', // refresh or postMessage
			'priority'  => 3,
			'default' => $option['shopcozi_topbar_icons'],
		) );

		$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_topbar_icons',
				array(
					'label'         => esc_html__('Social Icons','shopcozi'),
					'section'       => 'header_above',
					'live_title_id' => 'icon', // apply for unput text and textarea only
					'title_format'  => esc_html__('[live_title]','shopcozi'), // [live_title]
					'max_item'      => 4,
					'limited_msg' 	=> shopcozi_upgrade_pro_msg(),
					'fields'    => array(
						'icon_type'  => array(
							'title' => esc_html__('Custom icon','shopcozi'),
							'type'  =>'select',
							'options' => array(
								'icon' => esc_html__('Icon', 'shopcozi'),
								//'image' => esc_html__('image','shopcozi'),
							),
						),
						'icon'  => array(
							'title' => esc_html__('Icon','shopcozi'),
							'type'  =>'icon',
							'required' => array('icon_type','=','icon'),
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

		// shopcozi_topbar_icons_target
		$wp_customize->add_setting('shopcozi_topbar_icons_target',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_checkbox',
					'default'           => $option['shopcozi_topbar_icons_target'],
					'priority'          => 4,
				)
			);
		$wp_customize->add_control('shopcozi_topbar_icons_target',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Social icons open in new tab?', 'shopcozi'),
				'section'     => 'header_above',
			)
		);
}
add_action('customize_register','bc_shopcozi_customizer_header');