<?php
function bc_blogone_customizer_header( $wp_customize ){
	$blogone_options = blogone_default_options();

	// Header Above Section
	$wp_customize->add_section( 'header_above',
		array(
			'priority'    => 2,
			'title'       => esc_html__('Header Above','blogone'),
			'panel'       => 'blogone_header',
		)
	);
		// blogone_topbar_show
		$wp_customize->add_setting('blogone_topbar_show',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_topbar_show'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('blogone_topbar_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show Header Topbar?', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_social_content
		$wp_customize->add_setting('blogone_topbar_social_content',array(
				'sanitize_callback' => 'blogone_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 2,
				'default'           => $blogone_options['blogone_topbar_social_content'],
			) );

		$wp_customize->add_control(new Blogone_Repeatable_Control($wp_customize,'blogone_topbar_social_content',
				array(
					'label'         => esc_html__('Social Icons','blogone'),
					'section'       => 'header_above',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','blogone'), // [live_title]
					'max_item'      => 3,
					'limited_msg' 	=> blogone_upgrade_pro_msg(),
					'fields'    => array(
						'icon' => array(
							'title' => esc_html__('Icon','blogone'),
							'type'  =>'icon',
							'desc'  => '',
						),
						'link' => array(
							'title' => esc_html__('Link','blogone'),
							'type'  =>'text',
							'desc'  => '',
						),
					),
				)
			)
		);

		// blogone_topbar_social_target
		$wp_customize->add_setting('blogone_topbar_social_target',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_topbar_social_target'],
					'priority'          => 3,
				)
			);
		$wp_customize->add_control('blogone_topbar_social_target',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Social icons open in new tab?', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_search_show
		$wp_customize->add_setting('blogone_topbar_search_show',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_topbar_search_show'],
					'priority'          => 4,
				)
			);
		$wp_customize->add_control('blogone_topbar_search_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show search form?', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_search_label
		$wp_customize->add_setting('blogone_topbar_search_label',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $blogone_options['blogone_topbar_search_label'],
					'priority'          => 5,
				)
			);
		$wp_customize->add_control('blogone_topbar_search_label',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Search form label', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_canvas_show
		$wp_customize->add_setting('blogone_topbar_canvas_show',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_topbar_canvas_show'],
					'priority'          => 6,
				)
			);
		$wp_customize->add_control('blogone_topbar_canvas_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show Canvas Sidebar Icon?', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_canvas_logo
		$wp_customize->add_setting('blogone_topbar_canvas_logo',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => $blogone_options['blogone_topbar_canvas_logo'],
					'priority'          => 7,
				)
			);
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'blogone_topbar_canvas_logo',
			array(
				'label' 		=> esc_html__('Canvas Sidebar Logo', 'blogone'),
				'section' 		=> 'header_above',
			)
		) );

		// blogone_topbar_canvas_desc
		$wp_customize->add_setting('blogone_topbar_canvas_desc',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $blogone_options['blogone_topbar_canvas_desc'],
					'priority'          => 8,
				)
			);
		$wp_customize->add_control('blogone_topbar_canvas_desc',
			array(
				'type'        => 'textarea',
				'label'       => esc_html__('Canvas Sidebar Description', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_canvas_search_show
		$wp_customize->add_setting('blogone_topbar_canvas_search_show',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_topbar_canvas_search_show'],
					'priority'          => 12,
				)
			);
		$wp_customize->add_control('blogone_topbar_canvas_search_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show Canvas Search Form?', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_canvas_search_title
		$wp_customize->add_setting('blogone_topbar_canvas_search_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $blogone_options['blogone_topbar_canvas_search_title'],
					'priority'          => 13,
				)
			);
		$wp_customize->add_control('blogone_topbar_canvas_search_title',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Canvas Search Form Title', 'blogone'),
				'section'     => 'header_above',
			)
		);

		// blogone_topbar_canvas_search_label
		$wp_customize->add_setting('blogone_topbar_canvas_search_label',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $blogone_options['blogone_topbar_canvas_search_label'],
					'priority'          => 14,
				)
			);
		$wp_customize->add_control('blogone_topbar_canvas_search_label',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Canvas Search Form Label', 'blogone'),
				'section'     => 'header_above',
			)
		);
}
add_action('customize_register','bc_blogone_customizer_header');