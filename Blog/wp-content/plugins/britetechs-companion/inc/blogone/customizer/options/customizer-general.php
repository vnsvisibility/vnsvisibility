<?php
function bc_blogone_customizer_general( $wp_customize ){
	$blogone_options = blogone_default_options();

	// Mode
	$wp_customize->add_section( 'section_mode',
		array(
			'priority'    => 1,
			'title'       => esc_html__('Side Mode','blogone'),
			'panel'       => 'blogone_general',
		)
	);

		// blogone_mode
		$wp_customize->add_setting('blogone_mode',
				array(
					'sanitize_callback' => 'blogone_sanitize_select',
					'default'           => $blogone_options['blogone_mode'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('blogone_mode',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Site Mode', 'blogone'),
				'section'     => 'section_mode',
				'choices'     => array(
					'light' => __('Light','blogone'),
				),
			)
		);


		// blogone_breadcrumb_bg_image
		$wp_customize->add_setting('blogone_breadcrumb_bg_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => $blogone_options['blogone_breadcrumb_bg_image'],
					'priority'          => 5,
				)
			);
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'blogone_breadcrumb_bg_image',
			array(
				'label' 		=> esc_html__('Background Image', 'blogone'),
				'section' 		=> 'section_breadcrumb',
			)
		) );

		// blogone_breadcrumb_attachment
		$wp_customize->add_setting('blogone_breadcrumb_attachment',
				array(
					'sanitize_callback' => 'blogone_sanitize_select',
					'default'           => $blogone_options['blogone_breadcrumb_attachment'],
					'priority'          => 6,
				)
			);
		$wp_customize->add_control('blogone_breadcrumb_attachment',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Background Attachment', 'blogone'),
				'section'     => 'section_breadcrumb',
				'choices'     => array(
					'scroll' => __('Scroll','blogone'),
					'fixed' => __('Fixed','blogone'),
				),
			)
		);

		// blogone_breadcrumb_overlay
		$wp_customize->add_setting('blogone_breadcrumb_overlay',
				array(
					'sanitize_callback' => 'blogone_sanitize_color_alpha',
					'default'           => $blogone_options['blogone_breadcrumb_overlay'],
					'priority'          => 10,
				)
			);
		$wp_customize->add_control(new Blogone_Alpha_Color_Control($wp_customize,'blogone_breadcrumb_overlay',
			array(
				'label' 		=> esc_html__('Overlay Color', 'blogone'),
				'section' 		=> 'section_breadcrumb',
			)
		) );

		// blogone_breadcrumb_height
		$wp_customize->add_setting('blogone_breadcrumb_height',
				array(
					'sanitize_callback' => 'blogone_sanitize_range_value',
					'priority'          => 11,
					'transport'         => 'postMessage',
				)
			);
		$wp_customize->add_control(new Blogone_Range_Control($wp_customize,'blogone_breadcrumb_height',
			array(
				'label' 		=> esc_html__('Breadcrumb Section Height', 'blogone'),
				'section' 		=> 'section_breadcrumb',
				'type'          => 'range-value',
				'media_query'   => true,
                'input_attr' => array(
                    'mobile' => array(
                        'min' => 100,
                        'max' => 1024,
                        'step' => 1,
                        'default_value' => $blogone_options['blogone_breadcrumb_height'],
                    ),
                    'tablet' => array(
                        'min' => 100,
                        'max' => 1024,
                        'step' => 1,
                        'default_value' => $blogone_options['blogone_breadcrumb_height'],
                    ),
                    'desktop' => array(
                        'min' => 100,
                        'max' => 1024,
                        'step' => 1,
                        'default_value' => $blogone_options['blogone_breadcrumb_height'],
                    ),
                ),
			)
		) );
}
add_action('customize_register','bc_blogone_customizer_general');