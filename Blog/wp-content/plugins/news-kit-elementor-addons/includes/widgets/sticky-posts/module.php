<?php
/**
 * Social Share Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Sticky_Posts_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls(){
        /* General */
        $this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
            'sticky_posts_label',
            [
                'label' => esc_html__( 'Label', 'news-kit-elementor-addons' ),
                'label_block'   => false,
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'Popular Now', 'news-kit-elementor-addons' ),
                'placeholder' => esc_html__( 'Label', 'news-kit-elementor-addons' )
            ]
        );

		$this->add_control(
            'sticky_posts_icon',
            [
                'label' => esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid' => [ 'long-arrow-alt-down', 'arrow-down' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-long-arrow-alt-down',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_control(
			'posts_to_show',
			[
				'label' => esc_html__( 'Posts to Append', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3
			]
		);

		$this->add_control(
			'positioning_heading',
			[
				'label' => esc_html__( 'Positioning', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'fixed_position',
			[
				'label'	=>	esc_html__( 'Fixed Position', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::CHOOSE,
				'options'	=>	[
					'left'	=>	[
						'title'	=>	esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-h-align-left'
					],
					'right'	=>	 [
						'title'	=>	esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-h-align-right'
					]
				],
				'default'	=>	'left',
				'toggle'	=>	false
			]
		);

		$this->add_responsive_control(
			'horizontal_position',
			[
				'label' => esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	10
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts' => 'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'vertical_position',
			[
				'label' => esc_html__( 'Distance Bottom', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	10
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts' => 'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'more_less_icons_settings_heading',
			[
				'label' => esc_html__( 'More / Less Icon Settings', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'show_more_icon',
            [
                'label' => esc_html__( 'Show More Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid' => [ 'plus' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-plus',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_control(
            'show_less_icon',
            [
                'label' => esc_html__( 'Show Less Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid' => [ 'minus' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-minus',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_responsive_control(
			'show_more_icon_size',
			[
				'label' => esc_html__( 'Show More / Less Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	10
				],
				'selectors' => [
					'{{WRAPPER}} .more-less-indicator .indicator.more i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .more-less-indicator .indicator.less i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'	=>	'after'
			]
		);

		$this->add_control(
			'show_in_desktop',
			[
				'label' => esc_html__( 'Show in Desktop', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_in_tablet',
			[
				'label' => esc_html__( 'Show in Tablet', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_in_smartphone',
			[
				'label' => esc_html__( 'Show in Smartphone', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();

        /* Posts Query */
        $this->start_controls_section(
			'posts_query_section',
			[
				'label' => esc_html__( 'Posts Query', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_post_type_select_control();
		$this->add_taxonomy_select_control( 'post_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);

		$this->add_control(
			'post_order',
			[
				'label'	=> esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default' => 'date-desc',
				'label_block'   => true,
				'options' => nekit_get_widgets_post_order_options_array()
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Total Number of posts to display', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => nekit_get_widgets_post_count_max( $this->widget_name ),
				'step' => 1,
				'default' => 8,
			]
		);
		$this->add_authors_select_control();
		
		$this->add_categories_select_control( 'post_categories', [
			'dependency'	=>	'post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'post_tags', [
			'dependency'	=>	'post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'post_to_include', 'post', 'Posts', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);

		$this->add_control(
			'post_offset',
			[
				'label' => esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0,
			]
		);
		$this->add_posts_exclude_select_control( 'post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_control(
			'post_hide_post_without_thumbnail',
			[
				'label' => esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);

        $this->end_controls_section();

		/* Content => Post Element Settings */
		$this->start_controls_section(
			'post_element_settings_section',
			[
				'label' => esc_html__( 'Post Element Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'show_post_author',
			[
				'label' => esc_html__( 'Show Post Author', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'post_author_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
			]
		);
		
		$this->add_control(
            'post_author_icon',
            [
                'label' =>  esc_html__( 'Author Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['users','user','users-cog','user-tie','user-tag','user-shield','user-secret','user-plus','user-nurse','user-md','user-graduate','user-friends','user-edit','user-cog','user-circle','user-check','user-astronaut','user-alt','feather','highlighter','pen'],
					'fa-regular'	=> ['user','user-circle']
				],
                'default'   =>  [
                    'value' =>  'far fa-user-circle',
                    'library'   =>  'fa-regular'
				],
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
            ]
        );

		$this->add_responsive_control(
			'author_icon_size',
			[
				'label' => esc_html__( 'Author Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	10
				],
				'selectors' => [
					'{{WRAPPER}} article.post .author-context i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				]),
				'separator'	=> 'after'
			]
		);

		$this->add_post_element_date_control();

		$this->add_responsive_control(
			'date_icon_size',
			[
				'label' => esc_html__( 'Date Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	10
				],
				'selectors' => [
					'{{WRAPPER}} .article.post .published-date-context i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
				'condition'	=> apply_filters( 'nekit_widget_post_date_condition_filter', [
					'show_post_date'	=> 'pro'
				])
			]
		);

		$this->end_controls_section();

		/* Styles => General */
		$this->start_controls_section(
			'styles_general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts .label' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts .icon i' => 'color: {{VALUE}}',
				]
			]
		);

		$this->start_controls_tabs(
			'color_tabs'
		);

			$this->start_controls_tab(
				'colors_initial_tab',
				[
					'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'post_title_color',
					[
						'label' => esc_html__( 'Post Title Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-sticky-posts .post-title' => 'color: {{VALUE}}',
						]
					]
				);

				$this->add_control(
					'more_less_indicator_color',
					[
						'label' => esc_html__( 'Show More / Less Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .more-less-indicator .indicator.more i' => 'color: {{VALUE}}',
							'{{WRAPPER}} .more-less-indicator .indicator.less i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'more_less_indicator_background',
						'label'	=>	esc_html__( 'Show More / Less Background', 'news-kit-elementor-addons' ),
						'selector' => '{{WRAPPER}} .more-less-indicator',
						'fields'	=>	[
							'background'	=>	[
								'label'	=>	esc_html__( 'Initial Background', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ]
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'colors_hover_tab',
				[
					'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'post_title_hover_color',
					[
						'label' => esc_html__( 'Post Title Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-sticky-posts .post-title:hover' => 'color: {{VALUE}}',
						]
					]
				);

				$this->add_control(
					'more_less_indicator_hover_color',
					[
						'label' => esc_html__( 'Show More / Less Icon Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .more-less-indicator .indicator.more:hover i' => 'color: {{VALUE}}',
							'{{WRAPPER}} .more-less-indicator .indicator.less:hover i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'more_less_indicator_background_hover',
						'label'	=>	esc_html__( 'Show More / Less Background Hover', 'news-kit-elementor-addons' ),
						'selector' => '{{WRAPPER}} .more-less-indicator:hover',
						'fields_options'	=>	[
							'background'	=>	[
								'label'	=>	esc_html__( 'Hover Background', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ]
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->insert_divider();

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts article.post span.post-number' => 'background: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'article_background_color',
			[
				'label' => esc_html__( 'Article Background Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nekit-sticky-posts article.post' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nekit-sticky-posts article.post .post-content:before'  =>    'border-color: transparent {{VALUE}} transparent transparent'
				]
			]
		);

		$this->add_control(
			'post_background',
			[
				'label' => esc_html__( 'Background', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-content' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nekit-sticky-posts article.post .post-content:before'  =>    'border-color: transparent {{VALUE}} transparent transparent'
				]
			]
		);

		$this->insert_divider();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_item_border',
				'selector' => '{{WRAPPER}} .post'
			]
		);

		$this->add_control(
			'post_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	100
				],
				'selectors' => [
					'{{WRAPPER}} .post, {{WRAPPER}} .post .post-thumb, {{WRAPPER}} .post .post-number' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		/* Styles => Typography */
		$this->start_controls_section(
			'styles_typography_section',
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Label', 'news-kit-elementor-addons' ),
				'name' => 'label_typgoraphy',
				'fields_options' => [
					'typography' => [
						'default' => 'classic'
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => 17
						]
					]
				],
				'selector' => '{{WRAPPER}} .label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
				'name' => 'post_title_typgoraphy',
				'fields_options' => [
					'typography' => [
						'default' => 'classic'
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => 17
						]
					]
				],
				'selector' => '{{WRAPPER}} .post-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Author', 'news-kit-elementor-addons' ),
				'name' => 'author_typgoraphy',
				'fields_options' => [
					'typography' => [
						'default' => 'classic'
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => 13
						]
					]
				],
				'selector' => '{{WRAPPER}} .post-author',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Date', 'news-kit-elementor-addons' ),
				'name' => 'date_typgoraphy',
				'fields_options' => [
					'typography' => [
						'default' => 'classic'
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => 13
						]
					]
				],
				'selector' => '{{WRAPPER}} .post-published-date',
			]
		);

		$this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
		$posts_args = $this->get_posts_args_for_query();
		$posts_to_show = $settings[ 'posts_to_show' ];
		$total_post_count = $settings[ 'post_count' ];
		$elementClass = 'nekit-sticky-posts';
		$show_in_desktop = $settings[ 'show_in_desktop' ];
		$show_in_tablet = $settings[ 'show_in_tablet' ];
		$show_in_smartphone = $settings[ 'show_in_smartphone' ];
		if( $show_in_desktop ) $elementClass .= ' desktop--on';
		if( $show_in_tablet ) $elementClass .= ' tablet--on';
		if( $show_in_smartphone ) $elementClass .= ' smartphone--on';
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
				<div class="label-wrapper">
					<h2 class="label"><?php echo esc_html( $settings[ 'sticky_posts_label' ] ); ?></h2>
					<?php
						if( nekit_get_base_value([ 'icon' => $settings[ 'sticky_posts_icon' ] ]) ) echo '<span class="icon">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'sticky_posts_icon' ] ]) ). '</span>';
					?>
				</div>
				<div class="post-list">
					<?php
						$query_instance = new \WP_Query( $posts_args );
						if( $query_instance->have_posts() ) :
							$count = 0;
							while( ( $query_instance->have_posts() ) ) :
								$query_instance->the_post();
								$count++;
								$articalPost = 'post';
								if( $count > ( $total_post_count - $posts_to_show ) ) $articalPost .= ' hide';
								?>
									<article class="<?php echo esc_attr( $articalPost ); ?>">
										<?php
											/* Image */
											$has_post_thumb = has_post_thumbnail();
											$figureClass = 'post-thumb';
											if( ! $has_post_thumb ) $figureClass .= ' no-post-thumb';
											echo '<figure class="'. esc_attr( $figureClass ) .'">';
												if( $has_post_thumb ) the_post_thumbnail();
												echo '<span class="post-number">'. esc_html( $count ) .'</span>';
											echo '</figure>';

											echo '<div class="post-content">';

												/* Title */
												the_title( '<h2 class="post-title"><a href="'. get_the_permalink() .'">', '</a></h2>' );

												echo '<div class="post-meta">';
													/* Author */
													if( $settings[ 'show_post_author' ] == 'yes' ) echo wp_kses_post( nekit_get_posts_author([
														'base'	=>	isset( $settings[ 'post_author_icon_position' ] ) ? $settings[ 'post_author_icon_position' ] : 'prefix',
														'icon'	=>	isset( $settings[ 'post_author_icon' ] ) ? $settings[ 'post_author_icon' ] : [
															'value' =>  'far fa-user-circle',
															'library'   =>  'fa-regular'
														],
														'url'	=>	'yes'
													]));

													/* Date */
													if( $settings[ 'show_post_date' ] == 'yes' ) echo wp_kses_post( nekit_get_posts_date([
														'base'  =>  isset( $settings[ 'post_date_icon_position' ] ) ? $settings[ 'post_date_icon_position' ] : 'prefix',
														'icon'  =>  isset( $settings[ 'post_date_icon' ] ) ? $settings[ 'post_date_icon' ] : [
															'value' =>  'fas fa-calendar',
															'library'   =>  'fa-solid'
														],
														'url'	=>	'yes'
													]));
												echo '</div>';
											echo '</div>';
										?>
									</article>
								<?php
							endwhile;
						endif;
					?>
					<div class="more-less-indicator">
						<?php
							if( nekit_get_base_value([ 'icon' => $settings[ 'show_more_icon' ] ]) ) echo '<span class="indicator more active">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'show_more_icon' ] ]) ). '</span>';
							if( nekit_get_base_value([ 'icon' => $settings[ 'show_less_icon' ] ]) ) echo '<span class="indicator less">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'show_less_icon' ] ]) ). '</span>';
						?>
					</div>
				</div>
			</div><!-- .nekit-sticky-posts -->
		<?php
	}
 }