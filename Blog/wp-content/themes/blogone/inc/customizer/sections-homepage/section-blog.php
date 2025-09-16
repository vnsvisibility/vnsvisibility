<?php
function blogone_customizer_blog_section( $wp_customize ){

	$blogone_options = blogone_default_options();

		// Homepage Blog
		$wp_customize->add_section( 'blog_section',
			array(
				'priority'    => 10,
				'title'       => esc_html__('Section Blog','blogone'),
				'panel'       => 'blogone_frontpage',
			)
		);

			// blogone_blog_show
			$wp_customize->add_setting('blogone_blog_show',
					array(
						'sanitize_callback' => 'blogone_sanitize_checkbox',
						'default'           => $blogone_options['blogone_blog_show'],
						'priority'          => 1,
					)
				);
			$wp_customize->add_control('blogone_blog_show',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide/Show this section?', 'blogone'),
					'section'     => 'blog_section',
				)
			);

			// blogone_blog_sidebar
            $wp_customize->add_setting( 'blogone_blog_sidebar',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_blog_sidebar'],
                    'priority'          => 1,
                )
            );
            $wp_customize->add_control( 'blogone_blog_sidebar',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Blog Sidebar Layout', 'blogone'),
                    'section'     => 'blog_section',
                    'choices' => array(
						'0-1-1' => esc_html__('Right Sidebar', 'blogone'),						
                    	),
                )
            );

			// blogone_blog_category
			$wp_customize->add_setting('blogone_blog_category',
					array(
						'sanitize_callback' => 'blogone_sanitize_array',
						'default'           => $blogone_options['blogone_blog_category'],
						'priority'          => 5,
					)
				);
			$wp_customize->add_control(new Blogone_Multiselect_Control($wp_customize,'blogone_blog_category',
				array(
					'label'       => esc_html__('Select Categories', 'blogone'),
					'section'     => 'blog_section',
					'choices' => blogone_categories(),
				)
			) );

			// blogone_blog_orderby
            $wp_customize->add_setting( 'blogone_blog_orderby',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_blog_orderby'],
                    'priority'          => 6,
                )
            );
            $wp_customize->add_control( 'blogone_blog_orderby',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Order by', 'blogone'),
                    'section'     => 'blog_section',
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

            // blogone_blog_order
            $wp_customize->add_setting( 'blogone_blog_order',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_blog_order'],
                    'priority'          => 7,
                )
            );
            $wp_customize->add_control( 'blogone_blog_order',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Order', 'blogone'),
                    'section'     => 'blog_section',
                    'choices' => array(
                    	'desc' => esc_html__('Descending', 'blogone'),
						'asc'      => esc_html__('Ascending', 'blogone'),
                    	),
                )
            );

			// blogone_blog_posts_per_page
			$wp_customize->add_setting('blogone_blog_posts_per_page',
					array(
						'sanitize_callback' => 'blogone_sanitize_number',
						'default'           => $blogone_options['blogone_blog_posts_per_page'],
						'priority'          => 8,
					)
				);
			$wp_customize->add_control('blogone_blog_posts_per_page',
				array(
					'type'        => 'number',
					'label'       => esc_html__('No. of blogs to show', 'blogone'),
					'section'     => 'blog_section',
					'input_attrs' => array(
									    'min' => 1,
									    'max' => 100
									),
				)
			);

			// blogone_blog_column
            $wp_customize->add_setting( 'blogone_blog_column',
                array(
                    'sanitize_callback' => 'blogone_sanitize_select',
                    'default'           => $blogone_options['blogone_blog_column'],
                    'priority'          => 8,
                )
            );
            $wp_customize->add_control( 'blogone_blog_column',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Column Layout', 'blogone'),
                    'section'     => 'blog_section',
                    'choices' => array(
                    	1 => esc_html__('1 Column', 'blogone'),						
                    	),
                )
            );

            // blogone_blog_readmore
			$wp_customize->add_setting('blogone_blog_readmore',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'default'           => $blogone_options['blogone_blog_readmore'],
						'priority'          => 8,
					)
				);
			$wp_customize->add_control('blogone_blog_readmore',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Blog Read More Label', 'blogone'),
					'section'     => 'blog_section',
				)
			);

}
add_action('customize_register','blogone_customizer_blog_section');