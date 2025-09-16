<?php
function blogone_customizer_general( $wp_customize ){
	
	$blogone_options = blogone_default_options();

	// Blogone General Panel
	$wp_customize->add_panel( 'blogone_general',
		array(
			'priority'       => 31,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Blogone Global','blogone'),
		)
	);

		// Header Breadcrumb
		$wp_customize->add_section( 'section_breadcrumb',
			array(
				'priority'    => 2,
				'title'       => esc_html__('Breadcrumbs','blogone'),
				'panel'       => 'blogone_general',
			)
		);

			// blogone_breadcrumb_show
			$wp_customize->add_setting('blogone_breadcrumb_show',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_breadcrumb_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_breadcrumb_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show breadcrumb section?', 'blogone'),
					'section'     => 'section_breadcrumb',
				)
			);

			$wp_customize->add_setting('blogone_breadcrumb_bg_color', 
				array(
				'default'    => $blogone_options['blogone_breadcrumb_bg_color'],
				'sanitize_callback' => 'sanitize_text_field',
				'priority'          => 4,
				)
			);
			$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'blogone_breadcrumb_bg_color', 
				array(
				'label' => __('Background Color','blogone'),
				'section' => 'section_breadcrumb',
				'settings'=>'blogone_breadcrumb_bg_color'
			) ) );

		// BackTotop Button
		$wp_customize->add_section( 'section_backtotop',
			array(
				'priority'    => 3,
				'title'       => esc_html__('Back To Top','blogone'),
				'panel'       => 'blogone_general',
			)
		);

			// blogone_footer_backtotop
			$wp_customize->add_setting('blogone_footer_backtotop',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_footer_backtotop'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_footer_backtotop',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show back to top button?', 'blogone'),
					'section'     => 'section_backtotop',
				)
			);

}
add_action('customize_register','blogone_customizer_general');