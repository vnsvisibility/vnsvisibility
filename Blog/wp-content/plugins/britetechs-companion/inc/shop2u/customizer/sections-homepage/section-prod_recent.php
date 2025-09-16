<?php
function bc_shop2u_customizer_prod_recent_section( $wp_customize ){

	global $shop2u_options;

	// Category
	$wp_customize->add_section( 'prod_recent_section',
		array(
			'priority'    => 2,
			'title'       => esc_html__('Section Recent Product','shop2u'),
			'panel'       => 'shop2u_frontpage',
		)
	);

		// shop2u_prod_recent_disable
		$wp_customize->add_setting('shop2u_prod_recent_disable',
				array(
					'sanitize_callback' => 'shop2u_sanitize_checkbox',
					'default'           => $shop2u_options['shop2u_prod_recent_disable'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('shop2u_prod_recent_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'shop2u'),
				'section'     => 'prod_recent_section',
			)
		);

		// shop2u_prod_recent_subtitle
		$wp_customize->add_setting('shop2u_prod_recent_subtitle',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $shop2u_options['shop2u_prod_recent_subtitle'],
					'priority'          => 2,
				)
			);
		$wp_customize->add_control('shop2u_prod_recent_subtitle',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Subtitle', 'shop2u'),
				'section'     => 'prod_recent_section',
			)
		);

		// shop2u_prod_recent_title
		$wp_customize->add_setting('shop2u_prod_recent_title',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $shop2u_options['shop2u_prod_recent_title'],
					'priority'          => 3,
				)
			);
		$wp_customize->add_control('shop2u_prod_recent_title',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Title', 'shop2u'),
				'section'     => 'prod_recent_section',
			)
		);

		// shop2u_prod_recent_desc
		$wp_customize->add_setting('shop2u_prod_recent_desc',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $shop2u_options['shop2u_prod_recent_desc'],
					'priority'          => 4,
				)
			);
		$wp_customize->add_control('shop2u_prod_recent_desc',
			array(
				'type'        => 'textarea',
				'label'       => esc_html__('Description', 'shop2u'),
				'section'     => 'prod_recent_section',
			)
		);
}
add_action('customize_register','bc_shop2u_customizer_prod_recent_section');