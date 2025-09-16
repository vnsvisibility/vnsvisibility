<?php
function blogone_customizer_slider_section( $wp_customize ){

	$blogone_options = blogone_default_options();

	// Frontpage Sections Panel
	$wp_customize->add_panel( 'blogone_frontpage',
		array(
			'priority'       => 33,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Blogone Homepage Sections','blogone'),
		)
	);

		// Homepage Slider
		$wp_customize->add_section( 'slider_section',
			array(
				'priority'    => 1,
				'title'       => esc_html__('Section Slider','blogone'),
				'panel'       => 'blogone_frontpage',
			)
		);

			// blogone_slider_show
			$wp_customize->add_setting('blogone_slider_show',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_slider_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_slider_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'blogone'),
					'section'     => 'slider_section',
				)
			);

			// blogone_slider_style
	        $wp_customize->add_setting( 'blogone_slider_style',
	            array(
	                'sanitize_callback' => 'blogone_sanitize_select',
	                'default'           => $blogone_options['blogone_slider_style'],
	                'priority'          => 2,
	            )
	        );
	        $wp_customize->add_control( 'blogone_slider_style',
	            array(
	                'type'        => 'select',
	                'label'       => esc_html__('Slider Display', 'blogone'),
	                'section'     => 'slider_section',
	                'choices' => array(
	                	'one' => esc_html__('One', 'blogone'),											
	                	),
	            )
	        );

			// blogone_slider_category
			$wp_customize->add_setting('blogone_slider_category',
					array(
						'sanitize_callback' => 'blogone_sanitize_array',
						'default'           => $blogone_options['blogone_slider_category'],
						'priority'          => 7,
					)
				);
			$wp_customize->add_control(new Blogone_Multiselect_Control($wp_customize,'blogone_slider_category',
				array(
					'label'       => esc_html__('Select Categories', 'blogone'),
					'section'     => 'slider_section',
					'choices' => blogone_categories(),
				)
			) );

			// blogone_slider_orderby
            $wp_customize->add_setting( 'blogone_slider_orderby',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_slider_orderby'],
                    'priority'          => 8,
                )
            );
            $wp_customize->add_control( 'blogone_slider_orderby',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Order by', 'blogone'),
                    'section'     => 'slider_section',
                    'choices' => array(
                    	'default' => esc_html__('Default', 'blogone'),
						'id'      => esc_html__('ID', 'blogone'),
						'author'  => esc_html__('Author', 'blogone'),
						'title'   => esc_html__('Title', 'blogone'),
						'date'    => esc_html__('Date', 'blogone'),
						'comment_count' => esc_html__('Comment Count', 'blogone'),
						'menu_order'    => esc_html__('Order by Page Order', 'blogone'),
						'rand'          => esc_html__('Random order', 'blogone'),
                    	),
                )
            );

            // blogone_slider_order
            $wp_customize->add_setting( 'blogone_slider_order',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_slider_order'],
                    'priority'          => 9,
                )
            );
            $wp_customize->add_control( 'blogone_slider_order',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Order', 'blogone'),
                    'section'     => 'slider_section',
                    'choices' => array(
                    	'desc' => esc_html__('Descending', 'blogone'),
						'asc'      => esc_html__('Ascending', 'blogone'),
                    	),
                )
            );

			// blogone_slider_posts_per_page
			$wp_customize->add_setting('blogone_slider_posts_per_page',
					array(
						'sanitize_callback' => 'blogone_sanitize_number',
						'default'           => $blogone_options['blogone_slider_posts_per_page'],
						'priority'          => 15,
					)
				);
			$wp_customize->add_control('blogone_slider_posts_per_page',
				array(
					'type'        => 'number',
					'label'       => esc_html__('No. of blogs to show', 'blogone'),
					'section'     => 'slider_section',
					'input_attrs' => array(
									    'min' => 1,
									    'max' => 100
									),
				)
			);

			// blogone_slider_readmore
			$wp_customize->add_setting('blogone_slider_readmore',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'default'           => $blogone_options['blogone_slider_readmore'],
						'priority'          => 15,
					)
				);
			$wp_customize->add_control('blogone_slider_readmore',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Slider Read More Label', 'blogone'),
					'section'     => 'slider_section',
				)
			);
}
add_action('customize_register','blogone_customizer_slider_section');