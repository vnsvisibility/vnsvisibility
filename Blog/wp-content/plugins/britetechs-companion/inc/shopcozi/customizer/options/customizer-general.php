<?php
function bc_shopcozi_customizer_general( $wp_customize ){
	
	$option = shopcozi_default_options();

	// shopcozi_breadcrumb_bg_image
	$wp_customize->add_setting('shopcozi_breadcrumb_bg_image',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $option['shopcozi_breadcrumb_bg_image'],
				'priority'          => 4,
			)
		);
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'shopcozi_breadcrumb_bg_image',
		array(
			'label' 		=> esc_html__('Background Image', 'shopcozi'),
			'section' 		=> 'section_breadcrumb',
		)
	) );

	// shopcozi_breadcrumb_attachment
	$wp_customize->add_setting('shopcozi_breadcrumb_attachment',
			array(
				'sanitize_callback' => 'shopcozi_sanitize_select',
				'default'           => $option['shopcozi_breadcrumb_attachment'],
				'priority'          => 5,
			)
		);
	$wp_customize->add_control('shopcozi_breadcrumb_attachment',
		array(
			'type'        => 'select',
			'label'       => esc_html__('Background Attachment', 'shopcozi'),
			'section'     => 'section_breadcrumb',
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

	// shopcozi_breadcrumb_height
	$wp_customize->add_setting('shopcozi_breadcrumb_height',
			array(
				'sanitize_callback' => 'shopcozi_sanitize_range_value',
				'priority'          => 8,
				'transport'         => 'postMessage',
			)
		);
	$wp_customize->add_control(new Shopcozi_Range_Control($wp_customize,'shopcozi_breadcrumb_height',
		array(
			'label' 		=> esc_html__('Breadcrumb Section Height', 'shopcozi'),
			'section' 		=> 'section_breadcrumb',
			'type'          => 'range-value',
			'media_query'   => true,
            'input_attr' => array(
                'mobile' => array(
                    'min' => 1,
                    'max' => 320,
                    'step' => 1,
                    'default_value' => $option['shopcozi_breadcrumb_height'],
                ),
                'tablet' => array(
                    'min' => 1,
                    'max' => 320,
                    'step' => 1,
                    'default_value' => $option['shopcozi_breadcrumb_height'],
                ),
                'desktop' => array(
                    'min' => 1,
                    'max' => 320,
                    'step' => 1,
                    'default_value' => $option['shopcozi_breadcrumb_height'],
                ),
            ),
		)
	) );
}
add_action('customize_register','bc_shopcozi_customizer_general');