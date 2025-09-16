<?php
function bc_shop2u_customizer_general( $wp_customize ){

	global $shop2u_options;
	
		// shop2u_breadcrumb_bg_image
		$wp_customize->add_setting('shop2u_breadcrumb_bg_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => $shop2u_options['shop2u_breadcrumb_bg_image'],
					'priority'          => 5,
				)
			);
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'shop2u_breadcrumb_bg_image',
			array(
				'label' 		=> esc_html__('Background Image', 'shop2u'),
				'section' 		=> 'section_breadcrumb',
			)
		) );

		// shop2u_breadcrumb_attachment
		$wp_customize->add_setting('shop2u_breadcrumb_attachment',
				array(
					'sanitize_callback' => 'shop2u_sanitize_select',
					'default'           => $shop2u_options['shop2u_breadcrumb_attachment'],
					'priority'          => 6,
				)
			);
		$wp_customize->add_control('shop2u_breadcrumb_attachment',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Background Attachment', 'shop2u'),
				'section'     => 'section_breadcrumb',
				'choices'     => array(
					'scroll' => __('Scroll','shop2u'),
					'fixed' => __('Fixed','shop2u'),
				),
			)
		);
}
add_action('customize_register','bc_shop2u_customizer_general');