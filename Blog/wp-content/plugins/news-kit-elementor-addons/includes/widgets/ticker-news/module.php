<?php
/**
 * Ticker News Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Ticker_News_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab'   =>    \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://forum.blazethemes.com/news-elementor/#ticker-news-'.$this::$widget_count.'" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
        
        if( $this::$widget_count == 'one' ):
            $this->add_control(
                'ticker_news_layout',
                [
                    'label' =>  esc_html__( 'Widget Layouts', 'news-kit-elementor-addons' ),
                    'label_block'   =>  true,
                    'type'  =>   ( version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' ) ? \Elementor\Controls_Manager::VISUAL_CHOICE : 'nekit-radio-image-control' ),
                    'default'	=>  'one',
                    'options'	=>  apply_filters( 'nekit_radio_image_control_options_filter', array(
                        'one'	=>  array(
                            'label' =>  esc_html__( 'Layout One', 'news-kit-elementor-addons' ),
                            'image'	=>  NEKIT_URL . 'admin/assets/images/layouts/ticker-marquee/one.jpg'
                        ),
                        'two'	=>  array(
                            'label' =>  esc_html__( 'Layout Two', 'news-kit-elementor-addons' ),
                            'image'	=>  NEKIT_URL . 'admin/assets/images/layouts/ticker-marquee/two.jpg'
                        )
                    )),
                    'columns'   =>  2
                ]
            );
        endif;

        $this->add_control(
            'show_ticker_news_title',
            [
                'label' =>  esc_html__( 'Show Widget Title', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>    'yes'
            ]
        );

        if( $this::$widget_count == 'one' ) :
            $this->add_control(
                'ticker_news_title_icon',
                [
                    'label' =>  esc_html__( 'Title Icon', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::ICONS,
                    'label_block'   =>  false,
                    'skin'  =>  'inline',
                    'recommended'   => [
                        'fa-solid'  => ['bolt','highlighter','ticket-alt','fire','fire-alt','burn']
                    ],
                    'exclude_inline_options'    =>  'svg',
                    'default'   =>    [
                        'value' =>  'fas fa-burn',
                        'library'   =>  'fa-solid'
                    ]
                ]
            );
        endif;

        $this->add_control(
            'ticker_news_title',
            [
                'label' =>  esc_html__( 'Widget Title', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Trending', 'news-kit-elementor-addons' ),
                'placeholder'   =>  esc_html__( 'Enter widget title here . . ', 'news-kit-elementor-addons' )
            ]
        );

        if( $this::$widget_count == 'one' ) :
            $this->add_control(
                'ticker_news_duration',
                [
                    'label' =>  esc_html__( 'Marquee duration', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>    100,
                    'max'   =>  150000,
                    'step'  =>   100,
                    'default'   =>  15000
                ]
            );
        endif;

        if( $this::$widget_count == 'two'  ):
            $this->insert_divider();
            $this->add_control(
                'content_type',
                [
                    'label' =>  esc_html__( 'Content Type', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SELECT,
                    'default'   =>  'posts',
                    'options'   =>  [
                        'posts' =>  esc_html__( 'Posts', 'news-kit-elementor-addons' ),
                        'custom' =>  esc_html__( 'Custom', 'news-kit-elementor-addons' )
                    ]
                ]
            );

            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'custom_title',
                [
                    'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::TEXT,
                    'default'   =>  esc_html__( 'Lorem Ipsum is simply dummy text of the printing', 'news-kit-elementor-addons' )
                ]
            );

            $repeater->add_control(
                'custom_url',
                [
                    'label' =>  esc_html__( 'Url', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::TEXT,
                    'label_block'   =>  true,
                    'placeholder'   =>  esc_html__( 'Place custom url here', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'repeater_field',
                [
                    'label' =>  esc_html__( 'Custom', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::REPEATER,
                    'fields'    =>  $repeater->get_controls(),
                    'default'   =>  [
                        [
                            'custom_title'    =>  esc_html__( 'Lorem Ipsum is simply dummy text of the printing', 'news-kit-elementor-addons' )
                        ]
                    ],
                    'title_field'   =>  '{{{ custom_title }}}',
                    'condition' =>  [
                        'content_type'  =>  'custom'
                    ]
                ]
            );
    
            $this->add_control(
                'links_target',
                [
                    'label' =>  esc_html__( 'Links Open In', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SELECT,
                    'default'   =>  '_self',
                    'options'   =>  [
                        '_self' =>  esc_html__( 'Open in same tab', 'news-kit-elementor-addons' ),
                        '_blank' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' )
                    ],
                    'condition' => apply_filters( 'nekit_ticker_news_control_condition_filter', [
                        'content_type' => 'pro'
                    ])
                ]
            );
        endif;
		$this->end_controls_section();

		$this->start_controls_section(
			'posts_query_section',
			[
				'label' =>  esc_html__( 'Posts Query', 'news-kit-elementor-addons' ),
				'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
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
				'type'  =>   \Elementor\Controls_Manager::SELECT,
				'default'   =>  'date-desc',
				'label_block'   =>  true,
				'options'   =>    nekit_get_widgets_post_order_options_array()
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' =>  esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::NUMBER,
				'min'   =>  1,
				'max'   =>  nekit_get_widgets_post_count_max( $this->widget_name ),
				'step'  =>  1,
				'default'   => 6
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
		$post_tag_terms = [
			[
				'name'	=>	'post_custom_post_types',
				'operator'	=>	'contains',
				'value'	=>	'post'
			]
		];
		$post_tag_filter = [
			'name'	=>	'post_order',
			'operator'	=>	'==',
			'value'	=>	'random'
		];
		$post_tag_condition	= apply_filters( 'nekit_query_control_condition_filter', $post_tag_filter );
		if( ! empty( $post_tag_condition ) ) array_push( $post_tag_terms, $post_tag_condition );
		$this->add_tags_select_control( 'post_tags', [
			'conditions'	=>	[
				'terms'	=>	$post_tag_terms
			]
		]);

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
				'label' =>  esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description'   =>  esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::NUMBER,
				'min'   =>  0,
				'max'   =>    200,
				'step'  =>  1,
				'default'   =>  0
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
			'name'	=>	'post_order',
			'operator'	=>	'==',
			'value'	=>	'random'
		];
		$post_to_exclude_condition	= apply_filters( 'nekit_query_control_condition_filter', $post_to_exclude_filter );
		if( ! empty( $post_to_exclude_condition ) ) array_push( $post_to_exclude_terms, $post_to_exclude_condition );
		$this->add_posts_exclude_select_control( 'post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	$post_to_exclude_terms
			]
		]);
		$this->add_control(
			'post_hide_post_without_thumbnail',
			[
				'label' =>  esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SWITCHER,
				'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  =>  'yes',
				'default'   =>    'no',
                'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();

        if( $this::$widget_count == 'one' ):
            $this->start_controls_section(
                'posts_elements_settings_section',
                [
                    'label' =>  esc_html__( 'Post Elements Settings', 'news-kit-elementor-addons' ),
                    'tab'   =>    \Elementor\Controls_Manager::TAB_CONTENT
                ]
            );

            $this->add_control(
                'show_post_thumbnail',
                [
                    'label' =>  esc_html__( 'Show Post Thumbnail', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                    'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>    'yes'
                ]
            );

            $this->add_control(
                'show_post_title',
                [
                    'label' =>  esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                    'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>    'yes'
                ]
            );

            $this->add_post_element_date_control();

            $this->add_control(
                'ticker_news_slider_controller',
                [
                    'label' =>  esc_html__( 'Show ticker controller', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                    'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>    'yes'
                ]
            );
            
            $this->add_control(
                'posts_structure_sorting_heading',
                [
                    'label' =>  esc_html__( 'Thumbnail & Meta Sorting', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::HEADING,
                    'separator' =>  'before'
                ]
            );

            $this->add_control(
                'posts_structure_sorting',
                [
                    'label' =>  esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
                    'label_block'   =>  true,
                    'type'  =>   'sortable-control',
                    'default'	=>  ['post-thumbnail', 'post-meta'],
                    'options'	=>  array(
                        'post-thumbnail'	=>  array(
                            'label' =>  esc_html__( 'Post Thumbnail', 'news-kit-elementor-addons' )
                        ),
                        'post-meta' =>  array(
                            'label'	=>  esc_html__( 'Post Meta / Title', 'news-kit-elementor-addons' )
                        )
                    )
                ]
            );

            $this->add_control(
                'posts_elements_sorting',
                [
                    'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				    'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
                    'label_block'   =>  true,
                    'type'  =>   'sortable-control',
                    'default'	=>  ['post-title', 'post-date'],
                    'options'	=>  array(
                        'post-title'	=>  array(
                            'label'	=>  esc_html__( 'Post Title', 'news-kit-elementor-addons' )
                        ),
                        'post-date'	=>  array(
                            'label'	=>  esc_html__( 'Date', 'news-kit-elementor-addons' )
                        )
                    )
                ]
            );
            $this->end_controls_section();
        endif;

        if( $this::$widget_count == 'two' ):
            $this->start_controls_section(
                'slider_settings',
                [
                    'label' =>  esc_html__( 'Slider Settings','news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
                ]
            );
    
            $this->add_control(
                'slider_vertical',
                [
                    'label' =>  esc_html__( 'Vertical','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show','news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide','news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>  'no'
                ]
            );
    
            $this->add_control(
                'slider_settings_autoplay',
                [
                    'label' =>  esc_html__( 'Autoplay','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show','news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide','news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>  'no',
                    'condition' => apply_filters( 'nekit_ticker_news_two_slider_control_condition_filter', [
                        'slider_vertical'   => 'pro'
                    ])
                ]
            );
    
            $this->add_control(
                'slider_settings_autoplay_speed',
                [
                    'label' =>  esc_html__( 'Autoplay Speed','news-kit-elementor-addons' ),
                    'description'   =>  esc_html__( 'Speed of Autoplay in milliseconds','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  1000,
                    'max'   =>  50000,
                    'step'  =>  100,
                    'default'   =>  3000,
                    'condition' => apply_filters( 'nekit_ticker_news_two_slider_control_condition_filter', [
                        'slider_vertical'   => 'pro'
                    ])
                ]
            );
    
            $this->add_control(
                'slider_settings_speed',
                [
                    'label' =>  esc_html__( 'Speed','news-kit-elementor-addons' ),
                    'description'   =>  esc_html__( 'Slide / Fade animation speed','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  100,
                    'max'   =>  10000,
                    'step'  =>  100,
                    'default'   =>  500,
                    'condition' => apply_filters( 'nekit_ticker_news_two_slider_control_condition_filter', [
                        'slider_vertical'   => 'pro'
                    ])
                ]
            );
    
            $this->add_control(
                'slider_settings_fade',
                [
                    'label' =>  esc_html__( 'Fade','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show','news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide','news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>  'no',
                    'condition' => apply_filters( 'nekit_ticker_news_two_slider_control_condition_filter', [
                        'slider_vertical'   => 'pro'
                    ])
                ]
            );
    
            $this->add_control(
                'slider_settings_infinite',
                [
                    'label' =>  esc_html__( 'Infinite Loop','news-kit-elementor-addons' ),
                    'description'   =>  esc_html__( 'Repeat the slider without','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show','news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide','news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>  'no',
                    'condition' => apply_filters( 'nekit_ticker_news_two_slider_control_condition_filter', [
                        'slider_vertical'   => 'pro'
                    ])
                ]
            );
    
            $this->add_control(
                'slider_settings_arrows',
                [
                    'label' =>  esc_html__( 'Arrows','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show','news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide','news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default'   =>  'yes'
                ]
            );
    
            $this->add_control(
                'slider_next_arrow',
                [
                    'label' =>  esc_html__( 'Next Arrow', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'label_block'  =>  false,
                    'skin'  =>  'inline',
                    'recommended'   => [
                        'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
                        'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
                    ],
                    'exclude_inline_options'    =>  ['svg'],
                    'default'   =>  [
                        'library'   =>  'fa-solid',
                        'value' =>  'fas fa-angle-right'
                    ]
                ]
            );
    
            $this->add_control(
                'slider_previous_arrow',
                [
                    'label' =>  esc_html__( 'Previous Arrow', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'label_block'  =>  false,
                    'skin'  =>  'inline',
                    'recommended'   => [
                        'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
                        'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
                    ],
                    'exclude_inline_options'    =>  ['svg'],
                    'default'   =>  [
                        'library'   =>  'fa-solid',
                        'value' =>  'fas fa-angle-left'
                    ]
                ]
            );
    
            $this->add_control(
                'add_separator',
                [
                    'label' =>  esc_html__( 'Separator', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::TEXT,
                    'selectors' => [
                        '{{WRAPPER}} .slick-prev:after' => 'content: "{{VALUE}}"'
                    ]
                ]
            );
    
            $this->end_controls_section();
        endif;

		$this->start_controls_section(
			'animation_settings_section',
			[
				'label' =>  esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab'   =>    \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->post_title_animation_type_control();

        if( $this::$widget_count == 'one' ):
            $this->add_control(
                'image_hover_animation',
                [
                    'label' =>  esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::HOVER_ANIMATION
                ]
            );
        endif;
		$this->end_controls_section();

        if( $this::$widget_count == 'one' ):
            $this->start_controls_section(
                'posts_image_settings_section',
                [
                    'label' =>  esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
                    'tab'   =>    \Elementor\Controls_Manager::TAB_CONTENT
                ]
            );

            $this->add_control(
                'image_size',
                [
                    'label' =>  esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::SELECT,
                    'default'   =>  'medium',
                    'label_block'   =>  true,
                    'options' =>    $this->get_image_sizes()
                ]
            );
            $this->insert_divider();
            $this->add_responsive_control(
                'image_distance',
                [
                    'label' =>  esc_html__( 'Image Distance', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::SLIDER,
                    'size_units'    =>  ['px'],
                    'range' =>  [
                        'px'    =>  [
                            'min'   =>  0,
                            'max'   =>  100
                        ]
                    ],
                    'default'   =>    [
                        'unit'  =>  'px',
                        'size'  =>   10
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .ticker-item' => 'gap: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'image_border',
                    'selector'  =>  '{{WRAPPER}} .feature_image'
                ]
            );

            $this->add_responsive_control(
                'image_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .feature_image'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'image_box_shadow',
                    'selector'=> '{{WRAPPER}} .feature_image'
                ]
            );
            $this->end_controls_section();
        endif;

        $this->start_controls_section(
            'widget_general_section_typography',
            [
                'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->general_styles_primary_color_control();

        if( $this::$widget_count == 'one' ):
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>	esc_html__( 'title_background_color', 'news-kit-elementor-addons' ),
                    'types' =>	['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>	'{{WRAPPER}} .nekit-ticker-controls button, {{WRAPPER}} .ticker_label_title'
                ]
            );

            $this->add_control(
                'ticker_controller_color',
                [
                    'label' =>  esc_html__( 'Ticker Controller', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-ticker-controls button' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'icon_styles_section',
                [
                    'label'	=> esc_html__( 'Icon Styles', 'news-kit-elementor-addons' ),
                    'tab'	=> \Elementor\Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_control(
                'icon_animation',
                [
                    'label'	=>  esc_html__( 'Show Icon Animation', 'news-kit-elementor-addons' ),
                    'type'	=>  \Elementor\Controls_Manager::SWITCHER ,
                    'label_on'	=>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                    'label_off'	=>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                    'return_value'	=>  'yes',
                    'default'	=>  'yes'
                ]
            );

            $this->add_responsive_control(
                'icon_size',
                [
                    'label'	=>	esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SLIDER,
                    'range'	=>	[
                        'px'	=>	[
                            'min'	=>	0,
                            'max'	=>	1000,
                            'step'	=>	1
                        ]
                    ],
                    'default'	=>	[
                        'unit'	=>	'px',
                        'size'	=>	12
                    ],
                    'selectors'	=>	[
                        '{{WRAPPER}} .ticker_label_title .icon i'	=>	'font-size: {{SIZE}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ticker_label_title .icon i' => 'color: {{VALUE}}'
                    ]
                ]
            );
        endif;
        $this->end_controls_section();

        $this->start_controls_section(
            'widget_title_section_typography',
            [
                'label' =>  esc_html__( 'Widget Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'name'  =>   'title_typography',
                'selector'  =>  '{{WRAPPER}} .ticker_label_title .ticker_label_title_string'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' =>  esc_html__( 'Title Color', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .ticker_label_title .ticker_label_title_string' => 'color: {{VALUE}}'
                ]
            ]
        );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'name'  =>   'title_background',
                    'selector'  =>  '{{WRAPPER}} .ticker_label_title',
                    'exclude'   =>  ['image']
                ]
            );

            $this->insert_divider();

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'title_border',
                    'selector' =>  '{{WRAPPER}} .ticker_label_title'
                ]
            );

            $this->add_control(
                'title_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  1000,
                    'step'  =>  1,
                    'default'   =>  0,
                    'selectors' =>  [
                        '{{WRAPPER}} .ticker_label_title'    =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

            $this->add_responsive_control(
                'title_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>   [
                        '{{WRAPPER}} .ticker_label_title'    =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
        $this->end_controls_section();

		$this->start_controls_section(
			'post_title_section_typography',
			[
				'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
				'tab'   =>    \Elementor\Controls_Manager::TAB_STYLE
			]
		);

        if( $this::$widget_count == 'one' ):
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
                    'name'  =>   'post_title_typography',
                    'selector'  =>  '{{WRAPPER}} .post-title a'
                ]
            );

            $this->start_controls_tabs(
                'post_title_style_tabs'
            );
            $this->start_controls_tab(
                'post_title_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_title_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a' => 'color: {{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();

            $this->start_controls_tab(
                'post_title_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_title_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}}'
                    ]
                ]
            );
            
            $this->end_controls_tab();
            $this->end_controls_tabs();
        endif;

        if( $this::$widget_count == 'two' ):
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
                    'name'  =>   'post_title_typography',
                    'selector'  =>  '{{WRAPPER}} .post-title'
                ]
            );
    
            $this->start_controls_tabs(
                'post_title_style_tabs'
            );
            $this->start_controls_tab(
                'post_title_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_title_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a' =>  'color: {{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();
    
            $this->start_controls_tab(
                'post_title_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_title_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}}'
                    ]
                ]
            );
            
            $this->end_controls_tab();
            $this->end_controls_tabs();
        endif;
		$this->end_controls_section();

        if( $this::$widget_count == 'one' ):
            $this->start_controls_section(
                'post_date_section_typography',
                [
                    'label' =>  esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
                ]
            );
            
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' =>  esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
                    'name'  =>   'post_date_typography',
                    'selector'  =>  '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date'
                ]
            );
            
            $this->start_controls_tabs(
                'post_date_style_tabs'
            );
            $this->start_controls_tab(
                'post_date_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_date_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#8A8A8C',
                    'selectors' =>  [
                        '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date' => 'color: {{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'post_date_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );
            
            $this->add_control(
                'post_date_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}'
                    ]
                ]
            );
            
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();
        endif;

        if( $this::$widget_count == 'two' ) :
            $this->start_controls_section(
                'slider_styles',
                [
                    'label' =>  esc_html__( 'Slider Styles', 'news-kit-elementor-addons'),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
                ]
            );
    
                $this->start_controls_tabs(
                    'slider_tabs'
                );
                    $this->start_controls_tab(
                        'slider_initial_tab',
                        [
                            'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                        ]
                    );
    
                    $this->add_control(
                        'slider_icon_color',
                        [
                            'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                            'type'  =>  \Elementor\Controls_Manager::COLOR,
                            'selectors' =>  [
                                '{{WRAPPER}} .slick-arrow:hover.slick-prev:after' =>  'color: {{VALUE}}',
                                '{{WRAPPER}} .slick-arrow' =>  'color: {{VALUE}}'
                            ]
                        ]
                    );
            
                    $this->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'  =>  'slider_icon_background',
                            'selector'  =>  '{{WRAPPER}} .slick-arrow',
                            'exclude'   =>  ['image']
                        ]
                    );
    
                    $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name'  =>  'slider_icon_box_shadow',
                            'selector'  =>  '{{WRAPPER}} .slick-arrow'
                        ]
                    );
    
                    $this->end_controls_tab();
                    $this->start_controls_tab(
                        'slider_hover_tab',
                        [
                            'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                        ]
                    );
    
                    $this->add_control(
                        'slider_icon_color_hover',
                        [
                            'label' =>  esc_html__( 'Icon Hover Color', 'news-kit-elementor-addons' ),
                            'type'  =>  \Elementor\Controls_Manager::COLOR,
                            'selectors' =>  [
                                '{{WRAPPER}} .slick-arrow:hover' =>  'color: {{VALUE}}'
                            ]
                        ]
                    );
            
                    $this->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'  =>  'slider_icon_background_hover',
                            'selector'  =>  '{{WRAPPER}} .slick-arrow:hover',
                            'exclude'   =>  ['image']
                        ]
                    );
    
                    $this->add_group_control(
                        \Elementor\Group_Control_Box_shadow::get_type(),
                        [
                            'name'  =>  'slider_icon_box_shadow_hover',
                            'selector'  =>  '{{WRAPPER}} .slick-arrow:hover'
                        ]
                    );
    
                    $this->end_controls_tab();
                $this->end_controls_tabs();
    
            $this->insert_divider();
            
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'slider_border',
                    'selector'  =>  '{{WRAPPER}} .slick-arrow'
                ]
            );
    
            $this->add_control(
                'slider_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  10000,
                    'step'  =>  1,
                    'default'   =>  0,
                    'selectors' =>  [
                        '{{WRAPPER}} .slick-arrow'  =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

            $this->add_responsive_control(
                'slider_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>   [
                        '{{WRAPPER}} .slick-arrow'    =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
    
            $this->end_controls_section();
        endif;

        if( $this::$widget_count == 'one' ) $this->add_image_overlay_section();
	}
 }