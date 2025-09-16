<?php
function bc_blogone_customizer_footer( $wp_customize ){
	$blogone_options = blogone_default_options();

	// blogone_footer_copyright_content
	$wp_customize->add_setting('blogone_footer_copyright_content',array(
			'sanitize_callback' => 'blogone_sanitize_repeatable_data_field',
			'transport'         => 'refresh', // refresh or postMessage
			'priority'          => 3,
			'default'           => $blogone_options['blogone_footer_copyright_content'],
		) );

	$wp_customize->add_control(new Blogone_Repeatable_Control($wp_customize,'blogone_footer_copyright_content',
			array(
				'label'         => esc_html__('Footer Links','blogone'),
				'section'       => 'footer_copyright',
				'live_title_id' => 'title', // apply for unput text and textarea only
				'title_format'  => esc_html__( '[live_title]','blogone'), // [live_title]
				'max_item'      => 2,
				'limited_msg' 	=> blogone_upgrade_pro_msg(),
				'fields'    => array(
					'text' => array(
						'title' => esc_html__('Title','blogone'),
						'type'  =>'text',
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

	// blogone_footer_bg_image
	$wp_customize->add_setting('blogone_footer_bg_image',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $blogone_options['blogone_footer_bg_image'],
				'priority'          => 2,
			)
		);
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'blogone_footer_bg_image',
		array(
			'label' 		=> esc_html__('Background Image', 'blogone'),
			'section' 		=> 'footer_background',
		)
	) );			

	// blogone_footer_bg_attachment
	$wp_customize->add_setting('blogone_footer_bg_attachment',
			array(
				'sanitize_callback' => 'blogone_sanitize_select',
				'default'           => $blogone_options['blogone_footer_bg_attachment'],
				'priority'          => 3,
			)
		);
	$wp_customize->add_control('blogone_footer_bg_attachment',
		array(
			'type'        => 'select',
			'label'       => esc_html__('Background Attachment', 'blogone'),
			'section'     => 'footer_background',
			'choices'     => array(
				'scroll' => __('Scroll','blogone'),
				'fixed' => __('Fixed','blogone'),
			),
		)
	);

	// blogone_footer_overlay
	$wp_customize->add_setting('blogone_footer_overlay',
			array(
				'sanitize_callback' => 'blogone_sanitize_color_alpha',
				'default'           => $blogone_options['blogone_footer_overlay'],
				'priority'          => 7,
			)
		);
	$wp_customize->add_control(new Blogone_Alpha_Color_Control($wp_customize,'blogone_footer_overlay',
		array(
			'label' 		=> esc_html__('Overlay Color', 'blogone'),
			'section' 		=> 'footer_background',
		)
	) );
}
add_action('customize_register','bc_blogone_customizer_footer');