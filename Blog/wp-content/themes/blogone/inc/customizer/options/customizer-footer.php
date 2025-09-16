<?php
function blogone_customizer_footer( $wp_customize ){

	$blogone_options = blogone_default_options();

	// Blogone Footer Panel
	$wp_customize->add_panel( 'blogone_footer',
		array(
			'priority'       => 32,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Blogone Footer','blogone'),
		)
	);

		// Widget
		$wp_customize->add_section( 'footer_widget',
			array(
				'priority'    => 2,
				'title'       => esc_html__('Footer Widgets','blogone'),
				'panel'       => 'blogone_footer',
			)
		);

			// blogone_footer_widget_column
			$wp_customize->add_setting('blogone_footer_widget_column',
					array(
						'sanitize_callback' => 'blogone_sanitize_select',
						'default'           => $blogone_options['blogone_footer_widget_column'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_footer_widget_column',
				array(
					'type'        => 'select',
					'label'       => esc_html__('Widgets Column Layout', 'blogone'),
					'section'     => 'footer_widget',
					'choices' => array(
						'4' => 4,
						'3' => 3,
						'2' => 2,
						'1' => 1,
						'0' => esc_html__('Disable footer widgets', 'blogone'),
					),
				)
			);

			for ( $i = 1; $i<=4; $i ++ ) {
				$df = 12;
				if ( $i > 1 ) {
					$_n = 12/$i;
					$df = array();
					for ( $j = 0; $j < $i; $j++ ) {
						$df[ $j ] = $_n;
					}
					$df = join( '+', $df );
				}
				$wp_customize->add_setting('footer_custom_'.$i.'_columns',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'default' => $df,
						'transport' => 'postMessage',
					)
				);
				$wp_customize->add_control('footer_custom_'.$i.'_columns',
					array(
						'label' => $i == 1 ? __('Custom footer 1 column width', 'blogone') : sprintf( __('Custom footer %s columns width', 'blogone'), $i ),
						'section' => 'footer_widget',
						'description' => esc_html__('Enter int numbers and sum of them must smaller or equal 12, separated by "+"', 'blogone'),
					)
				);
			}	

		// Copyright
		$wp_customize->add_section( 'footer_copyright',
			array(
				'priority'    => 4,
				'title'       => esc_html__('Footer Copyright','blogone'),
				'panel'       => 'blogone_footer',
			)
		);

			// blogone_footer_copyright_show
			$wp_customize->add_setting('blogone_footer_copyright_show',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_footer_copyright_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_footer_copyright_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show bottom footer?', 'blogone'),
					'section'     => 'footer_copyright',
				)
			);

			// blogone_footer_copyright
			$wp_customize->add_setting('blogone_footer_copyright',
					array(
						'sanitize_callback' => 'wp_kses_post',
						'default'           => $blogone_options['blogone_footer_copyright'],
						'priority'          => 2,
					)
				);
			$wp_customize->add_control('blogone_footer_copyright',
				array(
					'type'        => 'textarea',
					'label'       => esc_html__('Copyright Text', 'blogone'),
					'description' => __('<code>%current_year%</code> to update the year automatically.<br/><code>%copy%</code> to include the copyright symbol.<br/>HTML is allowed.', 'blogone'),
					'section'     => 'footer_copyright',
				)
			);				

		// Background
		$wp_customize->add_section( 'footer_background',
			array(
				'priority'    => 5,
				'title'       => esc_html__('Footer Background','blogone'),
				'panel'       => 'blogone_footer',
			)
		);

			// blogone_footer_bg_color
			$wp_customize->add_setting('blogone_footer_bg_color',
					array(
						'sanitize_callback' => 'blogone_sanitize_hex_color',
						'default'           => $blogone_options['blogone_footer_bg_color'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'blogone_footer_bg_color',
				array(
					'label' 		=> esc_html__('Background Color', 'blogone'),
					'section' 		=> 'footer_background',
				)
			) );
}
add_action('customize_register','blogone_customizer_footer');