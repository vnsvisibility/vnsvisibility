<?php
function bc_shop2u_customizer_header( $wp_customize ){
	global $shop2u_options;

		// shop2u_topbar_left_content
		$wp_customize->add_setting('shop2u_topbar_left_content',array(
				'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 2,
				'default'           => $shop2u_options['shop2u_topbar_left_content'],
			) );

		$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_topbar_left_content',
				array(
					'label'         => esc_html__('Topbar left content','shop2u'),
					'section'       => 'header_above',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
					'max_item'      => 2,
					'limited_msg' 	=> shop2u_upgrade_pro_msg(),
					'fields'    => array(
						'title' => array(
							'title' => esc_html__('Title','shop2u'),
							'type'  =>'text',
							'desc'  => '',
						),
					),
				)
			)
		);

		// shop2u_topbar_right_content
		$wp_customize->add_setting('shop2u_topbar_right_content',array(
				'sanitize_callback' => 'shop2u_sanitize_repeatable_data_field',
				'transport'         => 'refresh', // refresh or postMessage
				'priority'          => 3,
				'default'           => $shop2u_options['shop2u_topbar_right_content'],
			) );

		$wp_customize->add_control(new Shop2u_Repeatable_Control($wp_customize,'shop2u_topbar_right_content',
				array(
					'label'         => esc_html__('Topbar right content','shop2u'),
					'section'       => 'header_above',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]','shop2u'), // [live_title]
					'max_item'      => 2,
					'limited_msg' 	=> shop2u_upgrade_pro_msg(),
					'fields'    => array(
						'icon'  => array(
							'title' => esc_html__('Icon','shop2u'),
							'type'  =>'icon',
						),
						'title' => array(
							'title' => esc_html__('Title','shop2u'),
							'type'  =>'text',
							'desc'  => '',
						),
					),
				)
			)
		);
}
add_action('customize_register','bc_shop2u_customizer_header');