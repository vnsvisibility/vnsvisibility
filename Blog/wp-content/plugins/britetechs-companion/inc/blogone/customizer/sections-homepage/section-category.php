<?php
function blogone_customizer_category_section( $wp_customize ){

	$blogone_options = blogone_default_options();

	// Category
	$wp_customize->add_section( 'post_category_section',
		array(
			'priority'    => 2,
			'title'       => esc_html__('Section Category','blogone'),
			'panel'       => 'blogone_frontpage',
		)
	);

		// blogone_category_show
		$wp_customize->add_setting('blogone_category_show',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_category_show'],
					'priority'          => 1,
				)
			);
		$wp_customize->add_control('blogone_category_show',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show this section?', 'blogone'),
				'section'     => 'post_category_section',
			)
		);

		// blogone_category_style
        $wp_customize->add_setting( 'blogone_category_style',
            array(
                'sanitize_callback' => 'blogone_sanitize_select',
                'default'           => $blogone_options['blogone_category_style'],
                'priority'          => 2,
            )
        );
        $wp_customize->add_control( 'blogone_category_style',
            array(
                'type'        => 'select',
                'label'       => esc_html__('Category Display', 'blogone'),
                'section'     => 'post_category_section',
                'choices' => array(
                	'slider' => esc_html__('Slider', 'blogone'),				
                	),
            )
        );

		// blogone_category_orderby
        $wp_customize->add_setting( 'blogone_category_orderby',
            array(
                'sanitize_callback' => 'blogone_sanitize_select',
                'default'           => $blogone_options['blogone_category_orderby'],
                'priority'          => 2,
            )
        );
        $wp_customize->add_control( 'blogone_category_orderby',
            array(
                'type'        => 'select',
                'label'       => esc_html__('Order by', 'blogone'),
                'section'     => 'post_category_section',
                'choices' => array(
                	'name' => esc_html__('Name', 'blogone'),
					'slug'      => esc_html__('Slug', 'blogone'),
					'term_group'  => esc_html__('Term Group', 'blogone'),
					'term_id'   => esc_html__('Term ID', 'blogone'),
					'id'    => esc_html__('ID', 'blogone'),
					'description' => esc_html__('Description', 'blogone'),
					'parent'    => esc_html__('Parent', 'blogone'),
					'term_order'          => esc_html__('Term Order', 'blogone'),
                	),
            )
        );

        // blogone_category_order
        $wp_customize->add_setting( 'blogone_category_order',
            array(
                'sanitize_callback' => 'blogone_sanitize_select',
                'default'           => $blogone_options['blogone_category_order'],
                'priority'          => 3,
            )
        );
        $wp_customize->add_control( 'blogone_category_order',
            array(
                'type'        => 'select',
                'label'       => esc_html__('Order', 'blogone'),
                'section'     => 'post_category_section',
                'choices' => array(
                	'asc' => esc_html__('ASC', 'blogone'),
					'desc'=> esc_html__('DESC', 'blogone'),					
                	),
            )
        );

        // blogone_category_hide_empty
		$wp_customize->add_setting('blogone_category_hide_empty',
				array(
					'sanitize_callback' => 'blogone_sanitize_checkbox',
					'default'           => $blogone_options['blogone_category_hide_empty'],
					'priority'          => 4,
				)
			);
		$wp_customize->add_control('blogone_category_hide_empty',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide/Show empty category? If not assign to posts.', 'blogone'),
				'section'     => 'post_category_section',
			)
		);
}
add_action('customize_register','blogone_customizer_category_section');