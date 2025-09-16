<?php
function bc_shop2u_customizer_typography( $wp_customize ){
	global $shop2u_options;

		// Shop2u Typography Panel
		$wp_customize->add_panel( 'shop2u_typography',
			array(
				'priority'       => 41,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__('Shop2u Typography','shop2u'),
			)
		);

		$sections = array(
			'body',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
		);

		foreach( $sections as $key => $section ){

			// Sections
		    $wp_customize->add_section('shop2u_'.$section.'_section',
		        array(
		            'priority'     => $key,
		            'title'        => sprintf(__('%s','shop2u'),ucfirst($section)),
		            'panel'        => 'shop2u_typography',
		        )
		    );

				// font size
				$wp_customize->add_setting('shop2u_'.$section.'_fontsize',
					array(
						'sanitize_callback' => 'shop2u_sanitize_range_value',
						'priority'          => 2,
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control(new Shop2u_Range_Control($wp_customize,'shop2u_'.$section.'_fontsize',
					array(
						'label' 		=> esc_html__('Font Size', 'shop2u'),
						'section' 		=> 'shop2u_'.$section.'_section',
						'type'          => 'range-value',
						'media_query'   => true,
	                    'input_attr' => array(
	                        'mobile' => array(
	                            'min' => 6,
	                            'max' => 50,
	                            'step' => 1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_fontsize'],
	                        ),
	                        'tablet' => array(
	                            'min' => 6,
	                            'max' => 50,
	                            'step' => 1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_fontsize'],
	                        ),
	                        'desktop' => array(
	                            'min' => 6,
	                            'max' => 50,
	                            'step' => 1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_fontsize'],
	                        ),
	                    ),
					)
				) );

				// line height
				$wp_customize->add_setting('shop2u_'.$section.'_lineheight',
					array(
						'sanitize_callback' => 'shop2u_sanitize_range_value',
						'priority'          => 3,
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control(new Shop2u_Range_Control($wp_customize,'shop2u_'.$section.'_lineheight',
					array(
						'label' 		=> esc_html__('Line Height', 'shop2u'),
						'section' 		=> 'shop2u_'.$section.'_section',
						'type'          => 'range-value',
						'media_query'   => true,
	                    'input_attr' => array(
	                        'mobile' => array(
	                            'min' => 0.1,
	                            'max' => 3,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_lineheight'],
	                        ),
	                        'tablet' => array(
	                            'min' => 0.1,
	                            'max' => 3,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_lineheight'],
	                        ),
	                        'desktop' => array(
	                            'min' => 0.1,
	                            'max' => 3,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_lineheight'],
	                        ),
	                    ),
					)
				) );

				// letter spacing
				$wp_customize->add_setting('shop2u_'.$section.'_letterspace',
					array(
						'sanitize_callback' => 'shop2u_sanitize_range_value',
						'priority'          => 4,
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control(new Shop2u_Range_Control($wp_customize,'shop2u_'.$section.'_letterspace',
					array(
						'label' 		=> esc_html__('Letter Spacing', 'shop2u'),
						'section' 		=> 'shop2u_'.$section.'_section',
						'type'          => 'range-value',
						'media_query'   => true,
	                    'input_attr' => array(
	                        'mobile' => array(
	                            'min' => 0.1,
	                            'max' => 10,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_letterspace'],
	                        ),
	                        'tablet' => array(
	                            'min' => 0.1,
	                            'max' => 10,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_letterspace'],
	                        ),
	                        'desktop' => array(
	                            'min' => 0.1,
	                            'max' => 10,
	                            'step' => 0.1,
	                            'default_value' => $shop2u_options['shop2u_'.$section.'_letterspace'],
	                        ),
	                    ),
					)
				) );

				// font weight
		    	$wp_customize->add_setting('shop2u_'.$section.'_fontweight',
					array(
						'sanitize_callback' => 'shop2u_sanitize_select',
						'default'           => $shop2u_options['shop2u_'.$section.'_fontweight'],
						'priority'          => 5,
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control('shop2u_'.$section.'_fontweight',
					array(
						'type'        => 'select',
						'label'       => esc_html__('Font Weight', 'shop2u'),
						'section'     => 'shop2u_'.$section.'_section',
						'choices'     => shop2u_font_weight(),
					)
				);

				// text transform
		    	$wp_customize->add_setting('shop2u_'.$section.'_texttransform',
					array(
						'sanitize_callback' => 'shop2u_sanitize_select',
						'default'           => $shop2u_options['shop2u_'.$section.'_texttransform'],
						'priority'          => 6,
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control('shop2u_'.$section.'_texttransform',
					array(
						'type'        => 'select',
						'label'       => esc_html__('Text Transform', 'shop2u'),
						'section'     => 'shop2u_'.$section.'_section',
						'choices'     => shop2u_text_transform(),
					)
				);

		}
}
add_action('customize_register','bc_shop2u_customizer_typography');