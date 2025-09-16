<?php
function blogone_customizer_header( $wp_customize ){

	$blogone_options = blogone_default_options();

	// Blogone Header Panel
	$wp_customize->add_panel( 'blogone_header',
		array(
			'priority'       => 30,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Blogone Header','blogone'),
		)
	);
		// Site identity
        $wp_customize->add_section('title_tagline',
            array(
                'priority'     => 1,
                'title'        => __('Site Identity','blogone'),
                'panel'        => 'blogone_header',
            )
        );

        	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

        	// blogone_h_logo_width
			$wp_customize->add_setting('blogone_h_logo_width',
					array(
						'sanitize_callback' => 'blogone_sanitize_range_value',
						'priority'          => 6,
						'transport'         => 'postMessage',
					)
				);
			$wp_customize->add_control(new Blogone_Range_Control($wp_customize,'blogone_h_logo_width',
				array(
					'label' 		=> esc_html__('Logo Width', 'blogone'),
					'section' 		=> 'title_tagline',
					'type'          => 'range-value',
					'media_query'   => true,
                    'input_attr' => array(
                        'mobile' => array(
                            'min' => 10,
                            'max' => 300,
                            'step' => 1,
                            'default_value' => $blogone_options['blogone_h_logo_width'],
                        ),
                        'tablet' => array(
                            'min' => 10,
                            'max' => 300,
                            'step' => 1,
                            'default_value' => $blogone_options['blogone_h_logo_width'],
                        ),
                        'desktop' => array(
                            'min' => 10,
                            'max' => 300,
                            'step' => 1,
                            'default_value' => $blogone_options['blogone_h_logo_width'],
                        ),
                    ),
				)
			) );			

		// Header Sticky
		$wp_customize->add_section( 'header_sticky',
			array(
				'priority'    => 5,
				'title'       => esc_html__('Header Sticky','blogone'),
				'panel'       => 'blogone_header',
			)
		);

			// blogone_h_sticky_show
			$wp_customize->add_setting('blogone_h_sticky_show',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_h_sticky_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_h_sticky_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show sticky header?','blogone'),
					'section'     => 'header_sticky',
				)
			);
}
add_action('customize_register','blogone_customizer_header');