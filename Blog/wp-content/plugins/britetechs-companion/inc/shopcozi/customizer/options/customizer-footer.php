<?php
function bc_shopcozi_customizer_footer( $wp_customize ){

	$option = shopcozi_default_options();

	// Footer Above Section
	$wp_customize->add_section( 'footer_above',
		array(
			'priority'    => 1,
			'title'       => esc_html__('Footer Info','shopcozi'),
			'panel'       => 'shopcozi_footer',
		)
	);

		// shopcozi_footer_above_show
		$wp_customize->add_setting('shopcozi_footer_above_show',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_checkbox',
					'default'           => $option['shopcozi_footer_above_show'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('shopcozi_footer_above_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show above footer?', 'shopcozi'),
				'section'     => 'footer_above',
			)
		);

		// shopcozi_footer_above_content
		$wp_customize->add_setting('shopcozi_footer_above_content',array(
				'sanitize_callback' => 'shopcozi_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 2,
				'default'           => $option['shopcozi_footer_above_content'],
			) );

		$wp_customize->add_control(new Shopcozi_Repeatable_Control($wp_customize,'shopcozi_footer_above_content',
				array(
					'label'         => esc_html__('Info Content','shopcozi'),
					'section'       => 'footer_above',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','shopcozi'), // [live_title]
					'max_item'      => 3,
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
						'title' => array(
							'title' => esc_html__('Title','shopcozi'),
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

		// shopcozi_footer_bg_image
		$wp_customize->add_setting('shopcozi_footer_bg_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => $option['shopcozi_footer_bg_image'],
					'priority'          => 2,
				)
			);
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'shopcozi_footer_bg_image',
			array(
				'label' 		=> esc_html__('Background Image', 'shopcozi'),
				'section' 		=> 'footer_background',
			)
		) );			

		// shopcozi_footer_bg_attachment
		$wp_customize->add_setting('shopcozi_footer_bg_attachment',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_select',
					'default'           => $option['shopcozi_footer_bg_attachment'],
					'priority'          => 3,
				)
			);
		$wp_customize->add_control('shopcozi_footer_bg_attachment',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Background Attachment', 'shopcozi'),
				'section'     => 'footer_background',
				'choices'     => array(
					'fixed' => __('Fixed','shopcozi'),
					'local' => __('Local','shopcozi'),
					'scroll' => __('Scroll','shopcozi'),						
					'inherit' => __('Inherit','shopcozi'),						
					'initail' => __('Initial','shopcozi'),						
					'revert' => __('Revert','shopcozi'),						
					'revert-layer' => __('Revert Layer','shopcozi'),						
					'unset' => __('Unset','shopcozi'),						
				),
			)
		);
}
add_action('customize_register','bc_shopcozi_customizer_footer');