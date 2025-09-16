<?php 
/**
 * News Timeline Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class News_Timeline_Module extends \Nekit_Widget_Base\Base {
    public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}
    
    protected function register_controls() {
        $this->start_controls_section(
            'general_section',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/news-timeline" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'content_type',
            [
                'label' =>  esc_html__( 'Content Type', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'posts',
                'options'   =>  apply_filters( 'nekit_timeline_content_type_options_array_filter', [
                    'posts' =>  esc_html__( 'Posts', 'news-kit-elementor-addons' ),
                    'pages-pro' =>  esc_html__( 'Pages ( in pro )', 'news-kit-elementor-addons' ),
                    'custom-pro' =>  esc_html__( 'Custom ( in pro )', 'news-kit-elementor-addons' )
                ])
            ]
        );

        $this->add_control(
            'general_divider_one',
            [
                'type'  =>  \Elementor\Controls_Manager::DIVIDER,
                'condition' =>  [
                    'content_type'  =>  'custom'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'custom_post_title',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Hola !', 'news-kit-elementor-addons' )
            ]
        );

        $repeater->add_control(
            'custom_post_excerpt',
            [
                'label' =>  esc_html__( 'Decription', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXTAREA,
                'default'   =>  esc_html__( 'Hola! Add timeline description.', 'news-kit-elementor-addons' )
            ]
        );

        $repeater->add_control(
            'custom_url',
            [
                'label' =>  esc_html__( 'Custom Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::URL,
                'options'   =>  ['url','is_external'],
                'default'   =>  [
                    'url'   =>  '',
                    'is_external'   =>  true
                ],
                'label_block'   =>  true
            ]
        );

        $repeater->add_control(
            'date_and_time',
            [
                'label' =>  esc_html__( 'Choose Date', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DATE_TIME
            ]
        );

        $repeater->add_control(
            'custom_icon',
            [
                'label' =>  esc_html__( 'Choose Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['rocket','heart','smile','grin','laugh','calendar','check','check-circle'],
                    'fa-regular'  => ['heart','smile','grin','laugh','calendar','check-circle']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-rocket',
                    'library'   =>  'fa-solid'
                ]
            ]
        );

        $this->add_control(
            'custom_repeater',
            [
                'label' =>  esc_html__( 'Post List', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::REPEATER,
                'fields'   =>  $repeater->get_controls(),
                'title_field'  =>  '{{{ custom_post_title }}}',
                'condition' =>  [
                    'content_type'  =>  'custom'
                ],
                'default'   =>  [
                    [
                        'custom_post_title' =>  esc_html__( 'Hola !', 'news-kit-elementor-addons' ),
                        'custom_post_excerpt'   =>  esc_html__( 'Hola! Add timline description.', 'news-kit-elementor-addons' )
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'post_query',
            [
                'label' =>  esc_html__( 'Post Query', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' =>  [
                    'content_type'  =>  'posts'
                ]
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
                'label' =>  esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'date-desc',
                'options'   =>  nekit_get_widgets_post_order_options_array(),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'posts_to_display',
            [
                'label' =>  esc_html__( 'Number of Posts to Display', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  apply_filters( 'nekit_timeline_posts_number_filter', 4 ),
                'step'  =>  1,
                'default'   =>  4
            ]
        );

        $this->add_control(
			'post_authors',
			[
				'label' =>  esc_html__( 'Post authors', 'news-kit-elementor-addons' ),
				'label_block'   =>  true,
				'multiple'	=>  true,
				'type'  =>   'nekit-select2-extend',
				'options'   =>  'select2extend/get_users',
                'condition' => apply_filters( 'nekit_timeline_post_authors_condition_filter', [
                    'content_type'  => 'pro'
                ])
			]
		);
        
        $this->add_control(
			'post_categories',
			[
				'label' =>  esc_html__( 'Post categories', 'news-kit-elementor-addons' ),
				'label_block'   =>  true,
				'multiple'  =>  true,
				'type'  =>   'nekit-select2-extend',
				'options'   =>  'select2extend/get_taxonomies',
				'query_slug'    =>  'category',
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
			]
		);

        $post_tag_terms = [
			[
				'name'	=>	'post_custom_post_types',
				'operator'	=>	'contains',
				'value'	=>	'post'
			]
		];
		$post_tag_filter = [
			'name'	=>	'content_type',
            'operator'	=>	'===',
            'value'	=>	'pro'
		];
		$post_tag_condition	= apply_filters( 'nekit_timeline_post_authors_condition_filter', $post_tag_filter );
		if( ! empty( $post_tag_condition ) ) array_push( $post_tag_terms, $post_tag_condition );
		$this->add_control(
			'post_tags',
			[
				'label' =>  esc_html__( 'Post tags', 'news-kit-elementor-addons' ),
				'label_block'   =>  true,
				'multiple'  =>  true,
				'type'  =>   'nekit-select2-extend',
				'options'   =>  'select2extend/get_taxonomies',
				'query_slug'    =>  'post_tag',
                'conditions' => [
                    'terms' =>  $post_tag_terms
                ]
			]
		);
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
            'offset',
            [
                'label' =>  esc_html__( 'Offset', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  20,
                'step'  =>  1,
                'default'   =>  0,
                'description'   =>  esc_html__( 'Number of posts to displace or pass over', 'news-kit-elementor-addons' )
            ]
        );

        $post_to_exclude_terms = [
			[
				'name'	=>	'post_custom_post_types',
				'operator'	=>	'!=',
				'value'	=>	''
			]
		];
		$post_to_exclude_filter = [
			'name'	=>	'content_type',
            'operator'	=>	'==',
            'value'	=>	'pro'
		];
		$post_to_exclude_condition	= apply_filters( 'nekit_timeline_post_authors_condition_filter', $post_to_exclude_filter );
		if( ! empty( $post_to_exclude_condition ) ) array_push( $post_to_exclude_terms, $post_to_exclude_condition );
        $this->add_control(
			'post_exclude',
			[
				'label' =>  esc_html__( 'Posts to Exclude', 'news-kit-elementor-addons' ),
				'label_block'   =>  true,
				'multiple'  =>  true,
				'type'  =>   'nekit-select2-extend',
				'options'   =>  'select2extend/get_posts_by_post_type',
				'query_slug'    =>  'post',
                'conditions' => [
                    'terms' =>  $post_to_exclude_terms
                ]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'page_query',
            [
                'label' =>  esc_html__( 'Page Query', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' =>  [
                    'content_type'  =>  'pages'
                ]
            ]
        );



        $this->add_control(
            'pages_order',
            [
                'label' =>  esc_html__( 'Page Order', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'date-desc',
                'options'   =>  nekit_get_widgets_post_order_options_array(),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'pages_to_display',
            [
                'label' =>  esc_html__( 'Number of pages to display', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  20,
                'step'  =>  1,
                'default'   =>  5
            ]
        );

        $this->add_control(
			'page_authors',
			[
				'label'	=> esc_html__( 'Page authors', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_users',
				'default'	=> ['']
			]
		);

        $this->add_posts_include_select_control( $name = 'pages_to_include', $query_slug = 'page', $label = 'Pages' );

        $this->add_control(
            'pages_offset',
            [
                'label' =>  esc_html__( 'Offset', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  20,
                'step'  =>  1,
                'default'   =>  0,
                'description'   =>  esc_html__( 'Number of pages to displace or pass over', 'news-kit-elementor-addons' )
            ]
        );

        $this->add_control(
            'pages_to_exclude',
            [
                'label' =>  esc_html__( 'Pages to Exclude', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'description'   =>  esc_html__( 'Pages IDs are seperated with "," commas', 'news-kit-elementor-addons' ),
                'placeholder'   =>  esc_html__( '20,30.....', 'news-kit-elementor-addons' )
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'timeline_section',
            [
                'label' =>  esc_html__( 'Timeline', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'polyline_icon',
            [
                'label' =>  esc_html__( 'Choose Icon','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['rocket','heart','smile','grin','laugh','calendar','check','check-circle'],
                    'fa-regular'  => ['heart','smile','grin','laugh','calendar','check-circle']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-rocket',
                    'library'   =>  'fa-solid'
                ],
                'condition' =>  [
                    'content_type!'  =>  'custom'
                ]
            ]
        );

        $this->add_responsive_control(
            'polyline_icon_size',
            [
                'label' =>  esc_html__( 'Icon Size','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  16,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .polyline-icon'    =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'polyline_width',
            [
                'label' =>  esc_html__( 'Polyline Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    '%' =>  [
                        'min'   =>  1,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  4,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .timeline-fixed-bar'   =>  'width:{{SIZE}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'events_elements',
            [
                'label' =>  esc_html__( 'Events Elements Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' =>  esc_html__( 'Show Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' =>  esc_html__( 'Show Date', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' =>  esc_html__( 'Show Excerpt', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' =>  esc_html__( 'Excerpt Length', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  5,
                'max'   =>  100,
                'step'  =>  1,
                'default'   =>  10,
                'separator' => 'after'
            ]
        );

        $this->add_responsive_control(
            'element_alignment',
            [
                'label'         =>  esc_html__( 'Aligntment', 'news-kit-elementor-addons' ),
                'type'          =>  \Elementor\Controls_Manager::CHOOSE,
                'default'       =>  'left',
                'options'       =>  [
                    'left'      =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'toggle'        =>  false,
                'frontend_available' => true,
                'selectors'     =>  [
                    '{{WRAPPER}} .post-item'  =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'hover_animation',
            [
                'label' =>  esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->post_title_animation_type_control();

        $this->end_controls_section();

        $this->start_controls_section(
            'timeline_styles',
            [
                'label' =>  esc_html__( 'Timeline Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->general_styles_primary_color_control();

        $this->add_control(
            'polyline_color',
            [
                'label' =>  esc_html__( 'Polyline Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#E4E4E4',
                'selectors' =>  [
                    '{{WRAPPER}} .timeline-fixed-bar' =>  'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'polyline_animation_color',
            [
                'label' =>  esc_html__( 'Polyline Animation Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .progress-bar' =>  'background-color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'card_styles',
            [
                'label' =>  esc_html__( 'Card Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'post_background_color',
            [
                'label' =>  esc_html__( 'Background', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors'  =>  [
                    '{{WRAPPER}} .post-item-inner-wrap' =>  'background: {{VALUE}}', 
                    '{{WRAPPER}} .nekit-news-timeline-wrap .post-odd .post-item-inner-wrap:after'   =>    'border-color: transparent transparent transparent {{VALUE}}',
                    '{{WRAPPER}} .nekit-news-timeline-wrap .post-even .post-item-inner-wrap:after'  =>    'border-color: transparent {{VALUE}} transparent transparent'  
                ]
            ]
        );
        $this->insert_divider();

        $this->start_controls_tabs(
            'card_box_shadow_tabs'
        );

            $this->start_controls_tab(
                'card_box_shadow_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_initial_box_shadow',
                    'selector'=> '{{WRAPPER}} .post-item-inner-wrap'
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'card_box_shadow_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_hover_box_shadow',
                    'selector'=> '{{WRAPPER}} .post-item-inner-wrap:hover'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-item-inner-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  30,
                    'right' =>  30,
                    'bottom'    =>  30,
                    'left'  =>  30,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-item-inner-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'event_title',
            [
                'label' =>  esc_html__( 'Event Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'event_title_typography',
                'fields_options'  => [
                    'typography'  => [
                        'default'  => 'custom'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18
                        ]
                    ],
                    'font_family' => [
                        'default' => 'Rubik'
                    ],
                    'font_weight' => [
                        'default' => 500
                    ]
                ],
                'selector'  =>  '{{WRAPPER}} .post-title'
            ]
        );

        $this->start_controls_tabs(
            'event_title_tabs'
        );
            $this->start_controls_tab(
                'event_title_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'title_initial_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'event_title_background',
                    'types'  =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .post-title a'
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'event_title_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'title_hover_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a:hover'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'event_title_hover_background',
                    'types'  =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .post-title a:hover'
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
            'title_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-title a'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'=>  [ 'px', '%', 'em', 'cusotm' ],
                'default'   =>  [
                    'top'   =>  0,
                    'right' =>  0,
                    'bottom'    =>  10,
                    'left'  =>  0,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-title'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();
        
        //Event Date
        $this->start_controls_section(
            'event_date',
            [
                'label' =>  esc_html__( 'Event Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'event_date_typography_for_post',
                'fields_options' => [
                    'typography' => [
                        'default' => 'custom'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14
                        ]
                    ],
                    'font_family' => [
                        'default' => 'Jost'
                    ],
                    'font_weight' => [
                        'default' => 500
                    ]
                ],
                'selector'  =>  '{{WRAPPER}} .post-date'
            ]
        );

        $this->start_controls_tabs(
            'event_date_tabs'
        );
            $this->start_controls_tab(
                'event_date_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'date_initial_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-date'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'event_date_background',
                    'types'  =>  ['classic', 'gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .post-date'
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'event_date_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'date_hover_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-date:hover'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'event_date_hover_background',
                    'types'  =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .post-date:hover'
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
            'event_date_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-date'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'event_date_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'=>  [ 'px', '%', 'em', 'cusotm' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-date'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        //Event Description
        $this->start_controls_section(
            'event_description',
            [
                'label' =>  esc_html__( 'Event Description', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'event_description_typography',
                'fields_options' => [
                    'typography' => [
                        'default' => 'custom'
                    ],
                    'font_family' => [
                        'default' => 'Lexend'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14
                        ]
                    ]
                ],
                'selector'  =>  '{{WRAPPER}} .post-excerpt'
            ]
        );

        $this->add_control(
            'description_initial_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#4E4E4E',
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt'    =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'event_description_background',
                'types'  =>  ['classic', 'gradient'],
                'exclude'   =>  ['image'],
                'selector'  =>  '{{WRAPPER}} .post-excerpt'
            ]
        );

        $this->insert_divider();

        $this->add_responsive_control(
            'event_description_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'event_description_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'=>  [ 'px', '%', 'em', 'cusotm' ],
                'default' => [
                    'top'    => 7,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px',
                    'isLinked' => true
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'event_icon',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

            $this->add_control(
                'icon_initial_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .polyline-icon'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'event_icon_background',
                    'types'  =>  ['classic', 'gradient'],
                    'fields_options' => [
                        'background' => [
                            'default' => 'classic'   
                        ],
                        'color'  => [
                            'default'  => '#ECB12B'
                        ]
                    ],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .polyline-icon'
                ]
            );
        $this->end_controls_section();
    }

    function get_timeline_html( $args ) { ?>
        <div class="post-item <?php echo esc_attr( $args['class_alter']); ?>">
            <div class="post-item-inner-wrap">
                <?php 
                    if( $args['show_title'] == 'yes' ) :
                    ?>
                        <h2 <?php echo wp_kses_post($args['hover_animation']); ?>>
                                <a href="<?php echo esc_attr( $args['link_url'] ); ?>">
                                        <?php echo esc_html( $args['title'] ); ?>
                                </a>
                        </h2>
                    <?php
                    endif;
                    if( $args['content_type'] == 'posts' || $args['content_type'] == 'pages' ) {
                        if( $args['show_date'] == 'yes' ) echo '<a href="' .esc_url(get_the_permalink()). '"><span class="post-date">' .esc_html( get_the_date() ). '</span></a>';
                    } else { 
                        $date = strtotime( $args['date_and_time'] );
                        if( $args['show_date'] == 'yes' ):
                            if( ! empty( $args['url_only'] ) ) :
                                echo '<a '. esc_url( $args['link_url'] ) .'><span class="post-date">' . esc_html( date( "Y F d H:i", $date ) ) . '</span></a>';
                            else:
                                echo '<span class="post-date">' . esc_html( date( "Y F d H:i", $date ) ) . '</span>';
                            endif;
                        endif;
                    }
                    
                    if( $args['content_type'] == 'pages' || $args['content_type'] == 'posts' ) {
                        if( $args['show_excerpt'] == 'yes' ) 
                            echo '<div class="post-excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), $args['excerpt_length'] ) ) . '</div>';
                    }else{
                        if( $args['show_excerpt'] == 'yes' ) echo '<div class="post-excerpt">' . esc_html($args['description']) . '</div>';
                    }

                    if( $args['content_type'] == 'custom' ):
                        echo '<span class="polyline-icon">' .wp_kses_post(nekit_get_base_value([ 'icon' => $args['icon'] ] )). '</span>';
                    else:
                        $this->get_timeline_polyline();
                    endif;
                ?>
            </div>
        </div>
   <?php 
   }

   function get_timeline_polyline() {
    if( $this->polyline_icon )  echo '<span class="polyline-icon">' .wp_kses_post( $this->polyline_icon ). '</span>';
   }

   /**
	 * Custom post type support
	 * MARK: Post Type
	 */
	public function timeline_post_type_support( $tab ) {
		$settings = $this->get_settings_for_display();
		if( ! $tab ) return;
		$custom_taxonomies = $post_categories = '';
		switch( $tab ) :
			case 'latest':
				$custom_taxonomies = is_array( $settings['latest_tab_custom_taxonomies'] ) ? $settings['latest_tab_custom_taxonomies'] : [];		
				$post_categories = is_array( $settings['latest_tab_post_categories'] ) ? $settings['latest_tab_post_categories'] : [];		
				break;
			case 'popular':
				$custom_taxonomies = is_array( $settings['popular_tab_custom_taxonomies'] ) ? $settings['popular_tab_custom_taxonomies'] : [];		
				$post_categories = is_array( $settings['popular_tab_post_categories'] ) ? $settings['popular_tab_post_categories'] : [];		
				break;
		endswitch;
		if( count( $custom_taxonomies ) > 0 ) :
			$tax_query = [
				'relation'	=>	"OR"
			];
			foreach( $custom_taxonomies as $tax ) :
				$tax_query[] = [
					'taxonomy'	=>	$tax,
					'terms'	=>	$post_categories,
					'operator'	=>	( count( $post_categories ) > 0 ) ? 'IN' : 'EXISTS'
				];
			endforeach;
			return $tax_query;
		else :
			return;
		endif;
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-news-timeline-wrap';
        $titleClass = 'post-title';
        $content_type = ( isset( $settings['content_type'] ) && ! strpos( $settings['content_type'], 'pro' ) ) ? $settings['content_type']: 'posts';
        if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );
        if( $content_type != 'custom' ) $this->polyline_icon = nekit_get_base_value( [ 'icon' => $settings['polyline_icon'] ] );
        $polyline_animation_color = isset( $settings['polyline_animation_color'] ) ? $settings['polyline_animation_color']: '#000000';
        $icon_initial_color = isset( $settings['icon_initial_color'] ) ? $settings['icon_initial_color']: '#ffffff';
        $this->add_render_attribute( 'wrapper','class',$elementClass );
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-color="<?php echo esc_attr( $polyline_animation_color ); ?>" data-defaultColor="<?php echo esc_attr( $icon_initial_color ); ?>">
            <div class="timeline-fixed-bar">
                <div class="progress-bar"></div>
            </div>
            <?php
                switch( $content_type ) {
                    case 'custom':
                                foreach( $settings['custom_repeater'] as $custom_key => $custom ):
                                    $class_alter = ( $custom_key % 2 == 0 ) ? 'post-odd' : 'post-even';
                                    if( ! empty( $custom['custom_url']['url'] ) ) $this->add_link_attributes( 'custom_url', $custom['custom_url'] );
                                    $url = empty( array_column( $custom,'url' ) ) ? "" : array_column( $custom,'url' ); 
                                    $this->get_timeline_html([
                                        'url_only'  =>  $url[0],
                                        'title' =>  $custom['custom_post_title'],
                                        'link_url'  =>  $this->get_render_attribute_string( 'custom_url' ),
                                        'hover_animation'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                        'show_excerpt'  =>  $settings['show_excerpt'],
                                        'show_date' =>  $settings['show_date'],
                                        'excerpt_length'    =>  $settings['excerpt_length'],
                                        'show_title'    =>  $settings['show_title'],
                                        'content_type'  =>  $content_type,
                                        'description'   =>  $custom['custom_post_excerpt'],
                                        'date_and_time' =>  $custom['date_and_time'],
                                        'class_alter'   =>  $class_alter,
                                        'icon'  =>  $custom['custom_icon']
                                    ]);
                                endforeach;
                            break;
                    case 'pages': 
                                $pages_order = explode( "-",$settings['pages_order'] );
                                $pages_exclude = count( explode( ",",$settings['pages_to_exclude'] ) ) > 0 ? explode( ",",$settings['pages_to_exclude'] ) : "";
                                $page_args = [
                                    'post_type' =>  'page',
                                    'post_status'   =>  'publish',
                                    'posts_per_page'    =>  absint( $settings['pages_to_display'] ),
                                    'offset'    =>  abs( $settings['pages_offset'] ),
                                    'author'    => implode( "-",$settings['page_authors'] ),
                                    'order' =>  esc_attr( $pages_order[1] ),
                                    'orderby'   =>  esc_attr( $pages_order[0] ),
                                    'post__not_in'  =>  $pages_exclude
                                ];
                                if( $settings['pages_to_include'] ) $page_args['post__in'] = $settings['pages_to_include'];
                                $page_query = new \WP_Query( $page_args );
                                if( $page_query->have_posts() ) :
                                    while( $page_query->have_posts() ) :
                                        $page_query->the_post(); 
                                        $class_alter = ( $page_query->current_post % 2 == 0 ) ? 'post-odd': 'post-even'; 
                                        $this->get_timeline_html([
                                            'title' =>  get_the_title(),
                                            'link_url'   =>  get_the_permalink(),
                                            'hover_animation'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                            'show_excerpt'  =>  $settings['show_excerpt'],
                                            'show_date' =>  $settings['show_date'],
                                            'excerpt_length'    =>  $settings['excerpt_length'],
                                            'show_title'    =>  $settings['show_title'],
                                            'content_type'  =>  $content_type,
                                            'description'   =>  get_the_excerpt(),
                                            'class_alter'   =>  $class_alter
                                        ]);
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                        break;
                    default : 
                            $custom_post_types = is_array( $settings['post_custom_post_types'] ) ? $settings['post_custom_post_types'] : 'post';
                            $post_order = explode( "-",$settings['post_order'] );
                            $posts_args = [
                                'post_type' =>  $custom_post_types,
                                'post_status'   =>  'publish',
                                'posts_per_page'    =>  absint( $settings['posts_to_display'] ),
                                'offset'    =>  absint( $settings['offset'] ),
                                'order' =>  esc_attr( $post_order[1] ),
                                'orderby'   =>  esc_attr( $post_order[0] )
                            ];
                            if( isset( $settings['post_authors'] ) && $settings['post_authors'] ) $posts_args['author'] = implode( ",", $settings['post_authors'] );
                            // if( $settings['post_categories'] ) $posts_args['cat'] = implode( ",", $settings['post_categories'] );
                            if( isset( $settings['post_tags'] ) && $settings['post_tags'] ) $posts_args['tag__in'] = $settings['post_tags'];
                            if( isset( $settings['post_exclude'] ) && $settings['post_exclude'] ) $posts_args['post__not_in'] = $settings['post_exclude'];
                            if( $settings['post_to_include'] ) $posts_args['post__in'] = $settings['post_to_include'];
                            $post_tax_query = [];
                            $post_categories = is_array( $settings['post_categories'] ) ? $settings['post_categories'] : [];
                            $custom_taxonomies = is_array( $settings['post_custom_taxonomies'] ) ? $settings['post_custom_taxonomies'] : [];
                            if( count( $custom_taxonomies ) > 0 ) :
                                $post_tax_query = [
                                    'relation'	=>	"OR"
                                ];
                                foreach( $custom_taxonomies as $tax ) :
                                    $post_tax_query[] = [
                                        'taxonomy'	=>	$tax,
                                        'terms'	=>	$post_categories,
                                        'operator'	=>	( count( $post_categories ) > 0 ) ? 'IN' : 'EXISTS'
                                    ];
                                endforeach;
                            endif;
                            if( ! empty( $post_tax_query ) ) $posts_args['tax_query'] = $post_tax_query;
                            $post_query = new \WP_Query( $posts_args );
                            if( $post_query->have_posts() ) :
                                while( $post_query->have_posts() ) :
                                    $post_query->the_post();
                                    $class_alter = ( $post_query->current_post % 2 == 0 ) ? 'post-odd': 'post-even'; 
                                    $this->get_timeline_html([
                                        'title' =>  get_the_title(),
                                        'link_url'   =>  get_the_permalink(),
                                        'hover_animation'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                        'show_excerpt'  =>  $settings['show_excerpt'],
                                        'show_date' =>  $settings['show_date'],
                                        'excerpt_length'    =>  $settings['excerpt_length'],
                                        'show_title'    =>  $settings['show_title'],
                                        'content_type'  =>  $content_type,
                                        'description'   =>  get_the_excerpt(),
                                        'class_alter'   =>  $class_alter
                                    ]);
                                endwhile;
                                wp_reset_postdata();
                            endif;
                }
            ?>
        </div>
    <?php 
    }
 }