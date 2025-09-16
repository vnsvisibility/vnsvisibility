<?php
/**
 * Archive Posts Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets\Archive;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Posts extends \Nekit_Widget_Base\Base {
	protected $widget_name = 'nekit-archive-posts';

    public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#archive-posts';
	}

    public function get_categories() {
		return [ 'nekit-archive-templates-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'archive', 'title', 'archive title' ];
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/archive-posts" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'widget_layouts',
            [
                'label' =>  esc_html__( 'Widget Layouts', 'news-kit-elementor-addons' ),
                'type'  =>  ( version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' ) ? \Elementor\Controls_Manager::VISUAL_CHOICE : 'nekit-radio-image-control' ),
                'label_block'   =>  true,
                'default'   =>  'one',
                'options'   =>  apply_filters( 'nekit_radio_image_control_options_filter', [
                    'one'   =>  [
                        'title' =>  esc_html__( 'Layout One', 'news-kit-elementor-addons' ),
                        'image'   =>  NEKIT_URL . 'includes/assets/images/controls/grid-one-layout-one.jpg'
                    ],
                    'two'   =>  [
                        'title' =>  esc_html__( 'Layout Two', 'news-kit-elementor-addons' ),
                        'image'   =>  NEKIT_URL . 'includes/assets/images/controls/list-one-layout-one.jpg'
                    ],
                    'three' =>  [
                        'title' =>  esc_html__( 'Layout Three', 'news-kit-elementor-addons' ),
                        'image'   =>  NEKIT_URL . 'includes/assets/images/controls/grid-two-layout-two.jpg'
                    ],
                    'four'  =>  [
                        'title' =>  esc_html__( 'Layout Four', 'news-kit-elementor-addons' ),
                        'image'   =>  NEKIT_URL . 'includes/assets/images/controls/list-two-layout-two.jpg'
                    ]
                ]),
                'columns'   =>  2
            ]
        );
        $this->add_layouts_skin_control();
        $this->add_responsive_control(
			'widget_column',
			[
				'label' =>  esc_html__( 'No of columns', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::NUMBER,
				'min'   =>  1,
				'max'   =>  nekit_get_widgets_column_max(),
				'step'  =>  1,
				'default'   =>  3
			]
		);

        $this->add_control(
			'adjust_as_grid_on_smaller_screen',
			[
				'label'	=>	esc_html__( 'Adjust as grid on smaller screen', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'ON', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'OFF', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no',
                'condition' =>  [
                    'widget_layouts'    =>  [ 'two', 'four' ]
                ]
			]
		);

        $this->add_control(
			'link_target',
			[
				'label' =>  esc_html__( 'Open link in', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SELECT,
				'default'   =>  '_self',
				'label_block'   =>  true,
				'options'   =>    [
                    '_self' =>  esc_html__( 'Same tab', 'news-kit-elementor-addons' ),
                    '_blank'    =>  esc_html__( 'New tab', 'news-kit-elementor-addons' )
                ],
                'condition' => apply_filters( 'nekit_archive_posts_link_target_condition_filter', [
                    'widget_column' => 5
                ])
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'elements_setting_section',
			[
				'label' =>  esc_html__( 'Elements Settings', 'news-kit-elementor-addons' ),
				'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
        
        $this->add_control(
			'show_post_title',
			[
				'label' =>  esc_html__( 'Show post title', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SWITCHER,
				'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  =>  'yes',
				'default'   =>  'yes'
			]
		);

        $this->add_control(
            'title_html_tag',
            [
                'label' =>  esc_html__( 'HTML Tag', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'	=>  'h2',
                'options'	=>  $this->get_html_tags(),
                'condition' =>  apply_filters( 'nekit_archives_posts_title_tag_condition_filter', [
                    'show_post_title'   =>  'pro'
                ])
            ]   
        );

        $this->add_control(
			'show_post_categories',
			[
				'label' =>  esc_html__( 'Show post categories', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SWITCHER,
				'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  =>  'yes',
				'default'   =>  'yes'
			]
		);

        $this->add_post_element_author_control();

        $this->add_post_element_date_control();

        $this->add_post_element_comments_control();

        $this->add_control(
			'show_post_excerpt',
			[
				'label' =>  esc_html__( 'Show post excerpt', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  =>  'yes',
				'default'   =>  'yes'
			]
		);

        $this->add_control(
			'post_excerpt_length',
			[
				'label' =>  esc_html__( 'Excerpt length', 'news-kit-elementor-addons' ),
				'description'   =>  esc_html__( 'It counts the number of words', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::NUMBER,
				'min'   =>  0,
				'max'   =>  100,
				'step'  =>   1,
				'default'   =>  10,
                'condition' =>  apply_filters( 'nekit_widget_post_excerpt_condition_filter', [
                    'show_post_excerpt' =>  'pro'
                ])
			]
		);

        $this->add_control(
			'show_post_button',
			[
				'label' =>  esc_html__( 'Show Read More', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  =>  'yes',
				'default'   =>    'yes'
			]
		);

		$this->add_control(
			'post_button_text',
			[
				'label' =>  esc_html__( 'Button Text', 'news-kit-elementor-addons' ),
				'default'   =>    esc_html__( 'Read more', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::TEXT,
				'placeholder'   =>  esc_html__( 'Add read more button text . .', 'news-kit-elementor-addons' )
			]
		);

		$this->add_control(
			'post_button_icon',
			[
				'label' =>  esc_html__( 'Button Icon', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
				'skin'  =>  'inline',
                'exclude_inline_options'    =>  'svg',
                'recommended'   => [
                    'fa-solid'  => ['angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
                    'fa-regular'  => ['hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
                ],
				'default'   => [
					'value' => 'fas fa-angle-right',
					'library'   =>  'fa-solid'
				],
                'condition' =>  apply_filters( 'nekit_widget_post_button_condition_filter', [
                    'show_post_button' =>  'pro'
                ])
			]
		);

        $this->add_control(
			'post_elements_align_heading',
			[
				'label' =>  esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_control(
			'post_elements_align',
			[
				'label' =>  esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::CHOOSE,
				'options'   =>  [
					'left'  =>   [
						'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-left'
					],
					'center'    =>  [
						'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon'  =>  'eicon-text-align-center'
					],
					'right' =>  [
						'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-right'
					]
				],
				'default'   =>  'left',
				'toggle'    => false,
                'frontend_available' => true,
				'selectors' =>  [
					'{{WRAPPER}} .post-element' =>  'text-align: {{VALUE}};'
				]
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
			'pagination_setting_section',
			[
				'label' =>  esc_html__( 'Pagination', 'news-kit-elementor-addons' ),
				'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
        
        $this->add_control(
			'pagination_type',
			[
				'label' => esc_html__( 'Type', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => 'default',
				'label_block'   => true,
				'options'   => apply_filters( 'nekit_archive_posts_pagination_type_options_filter', [
                    'default'   => esc_html__( 'Default', 'news-kit-elementor-addons' ),
                    'number'    => esc_html__( 'Number', 'news-kit-elementor-addons' )
                ])
			]
		);

        $this->add_control(
			'default_pagination__prev_text',
			[
				'label' =>  esc_html__( 'Prev Text', 'news-kit-elementor-addons' ),
				'default'   =>    esc_html__( 'Older Posts', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::TEXT,
				'placeholder'   =>  esc_html__( 'Prev text . .', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'pagination_type'   =>  ['default','number']
                ]
			]
		);

        $this->add_control(
            'default_pagination__prev_icon',
            [
                'label' =>  esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'label_block'   => false,
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
                    'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-angle-left',
                    'library'   =>  'fa-solid'
				],
                'condition' => [
                    'pagination_type'   => ['default','number']
                ]
            ]
        );

        $this->add_control(
			'default_pagination__next_text',
			[
				'label' =>  esc_html__( 'Next Text', 'news-kit-elementor-addons' ),
				'default'   =>    esc_html__( 'Newer Posts', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::TEXT,
				'placeholder'   =>  esc_html__( 'Next text . .', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'pagination_type'   =>  ['default','number']
                ]
			]
		);

        $this->add_control(
            'default_pagination__next_icon',
            [
                'label' =>  esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'label_block'   => false,
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
                    'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-angle-right',
                    'library'   =>  'fa-solid'
				],
                'condition' => [
                    'pagination_type'   => ['default','number']
                ]
            ]
        );

        $this->add_control(
			'ajax_pagination_button_text',
			[
				'label' =>  esc_html__( 'Button Text', 'news-kit-elementor-addons' ),
				'default'   =>    esc_html__( 'Load More', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::TEXT,
				'placeholder'   =>  esc_html__( 'More more text . .', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'pagination_type'   =>  'ajax'
                ]
			]
		);

        $this->add_control(
            'ajax_pagination_button_icon',
            [
                'label' =>  esc_html__( 'Button Icon', 'news-kit-elementor-addons' ),
                'label_block'   => false,
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up'],
                    'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-angle-double-down',
                    'library'   =>  'fa-solid'
				],
                'condition' => [
                    'pagination_type'   => 'ajax'
                ]
            ]
        );

        $this->add_control(
            'default_pagination__alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'toggle'    =>  false,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .posts-pagination' =>  'text-align: {{VALUE}}'
                ],
                'condition' =>  [
                    'pagination_type'   =>  ['number', 'ajax']
                ]
            ]
        );

        $this->insert_divider();
        $this->add_control(
            'no_posts_found',
            [
                'label' =>  esc_html__( 'No Posts Found', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'No more posts to display', 'news-kit-elementor-addons' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'animation_settings_section',
			[
				'label' =>  esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->post_title_animation_type_control();

		$this->add_control(
			'image_hover_animation',
			[
				'label' =>  esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'posts_image_settings_section',
			[
				'label' => esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'label_block'   => true,
				'options' => $this->get_image_sizes()
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label' => esc_html__( 'Image Ratio', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2,
						'step' => .1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => .7,
				],
				'selectors' => [
					'{{WRAPPER}} .post-thumb' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				]
			]
		);

        $this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} article .post-thumb' => 'width: {{SIZE}}%;'
				]
			]
		);
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-thumb img'
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
                    '{{WRAPPER}} .post-thumb img, {{WRAPPER}} .post-thumb'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .post-thumb'
            ]
        );
		$this->end_controls_section();

        $this->start_controls_section(
            'general_styles',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->general_styles_primary_color_control();

        $this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => nekit_get_widgets_column_gap_max(),
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .posts-inner-wrap' => 'column-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => nekit_get_widgets_row_gap_max(),
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .posts-inner-wrap' => 'row-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

        $this->add_card_skin_style_control();
		$this->start_controls_section(
            'post_title_style',
            [
                'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_title_typography',
				'selector'  =>  '{{WRAPPER}} .post-title'
			]
		);

        $this->start_controls_tabs(
            'slider_post_title_style_tabs'
        );
            $this->start_controls_tab(
                'post_title_initial_tab',
                [
                    'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_title_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000',
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
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .post-title a:hover'   =>  'color: {{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->insert_divider();

        $this->add_control(
            'post_title_background_color',
            [
                'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .post-title a, {{WRAPPER}} .layout--four .post-title' =>  'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_title_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>
                    [
                    '{{WRAPPER}} .post-title a' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->add_responsive_control(
            'post_title_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>
                    [
                    '{{WRAPPER}} .post-title' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
		$this->end_controls_section();

        $this->start_controls_section(
            'post_categories_style',
            [
                'label' =>  esc_html__( 'Post Categories', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_categories_typography',
				'selector'  =>  '{{WRAPPER}} .post-categories .cat-item a'
			]
		);

        $this->start_controls_tabs(
            'post_categories_style_tabs'
        );
            $this->start_controls_tab(
                'post_categories_initial_tab',
                [
                    'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_categories_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories .cat-item a'  =>   'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_categories_background_color',
					'selector'  =>  '{{WRAPPER}} .post-categories .cat-item a',
					'exclude'   =>  ['image']
				]
			);

            $this->add_control(
                'post_categories_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories .cat-item a' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'post_categories_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_categories_hover_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories .cat-item a:hover' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_categories_background_hover_color',
					'selector'  =>  '{{WRAPPER}} .post-categories .cat-item a:hover',
					'exclude'   =>  ['image']
				]
			);
            
            $this->add_control(
                'post_categories_border_radius_hover',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories .cat-item a:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();
        
        $this->add_responsive_control(
            'post_categories_padding',[
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-categories .cat-item a'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_categories_margin',[
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'default'   => [
                    'top'   =>  '0',
                    'right' => '10',
                    'bottom'    =>  '0',
                    'left'  => '0',
                    'unit'  =>  'px',
                    'isLinked'  =>   true
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-categories .cat-item a'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'post_author_style',
            [
                'label' =>  esc_html__( 'Post Author', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_author_typography',
				'selector'  =>  '{{WRAPPER}} .author-context, {{WRAPPER}} .post-author'
			]
		);

        $this->start_controls_tabs(
            'post_author_style_tabs'
        );
            $this->start_controls_tab(
                'post_author_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'post_author_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .author-context, {{WRAPPER}} .post-author'  =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_author_background_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .author-meta-wrap'  =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'post_author_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_author_hover_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .author-meta-wrap:hover .author-context, {{WRAPPER}} .author-meta-wrap:hover .post-author'  => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_author_background_hover_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .author-meta-wrap:hover'    =>  'background-color: {{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
            'post_author_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .author-meta-wrap'  =>   'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_author_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'default'   => [
                    'top'   =>  '0',
                    'right' =>  '10',
                    'bottom'    =>  '0',
                    'left'  => '0',
                    'unit'  =>  'px',
                    'isLinked'  =>   true
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .author-meta-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
		$this->end_controls_section();

        $this->start_controls_section(
            'post_date_style',
            [
                'label' =>  esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_date_typography',
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
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date'   =>    'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_date_background_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap'   =>  'background-color: {{VALUE}}'
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
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .date-meta-wrap:hover .post-published-date' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_date_background_hover_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap:hover' =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
            'post_date_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-meta-wrap'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_date_margin',
            [
                'label' =>   esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-meta-wrap'   =>    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
		$this->end_controls_section();
        
        $this->start_controls_section(
            'post_comments_style',
            [
                'label' =>  esc_html__( 'Post Comments', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_comments_typography',
				'selector'  =>  '{{WRAPPER}} .post-meta .post-comments-context, {{WRAPPER}} .post-meta .post-comments'
			]
		);

        $this->start_controls_tabs(
            'post_comments_style_tabs'
        );
            $this->start_controls_tab(
                'post_comments_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_comments_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-meta .post-comments-context'   =>    'color: {{VALUE}}',
                        '{{WRAPPER}} .post-meta .post-comments'   =>    'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_comments_background_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .comments-meta-wrap'   =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'post_comments_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_comments_hover_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .comments-meta-wrap:hover .post-comments-prefix, {{WRAPPER}} .comments-meta-wrap:hover .post-comments' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_comments_background_hover_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .comments-meta-wrap:hover' =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
            'post_comments_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .comments-meta-wrap'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_comments_margin',
            [
                'label' =>   esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .comments-meta-wrap'   =>    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
		$this->end_controls_section();
        //test

        $this->start_controls_section(
            'post_excerpt_style',
            [
                'label' =>  esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_excerpt_typography',
				'selector'  =>  '{{WRAPPER}} .post-excerpt'
			]
		);

        $this->add_control(
            'post_excerpt_color',
            [
                'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'post_excerpt_background_color',
            [
                'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt' =>  'background-color: {{VALUE}}'
                ]
            ]
        );
        
        $this->insert_divider();
        
        $this->add_responsive_control(
            'post_excerpt_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_excerpt_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'post_link_button_style',
            [
                'label' =>  esc_html__( 'Read More Button', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'post_link_button_typography',
				'selector'  =>  '{{WRAPPER}} .post-link-button'
			]
		);

        $this->start_controls_tabs(
            'post_link_button_style_tabs'
        );
            $this->start_controls_tab(
                'post_link_button_initial_tab',
                [
                    'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_link_button_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-link-button' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_link_button_background_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>    \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-link-button' =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'post_link_button_border',
                    'selector'  =>  '{{WRAPPER}} .post-link-button'
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  =>  'post_link_button_box_shadow',
                    'selector'  =>  '{{WRAPPER}} .post-link-button'
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'post_link_button_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_link_button_hover_color',
                [
                    'label' =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  =>   \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-link-button:hover'   =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'post_link_button_background_hover_color',
                [
                    'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-link-button:hover'   =>  'background-color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'post_link_button_hover_border',
                    'selector'  =>  '{{WRAPPER}} .post-link-button:hover'
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  =>  'post_link_button_hover_box_shadow',
                    'selector'  =>  '{{WRAPPER}} .post-link-button:hover'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_control(
            'post_link_button_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .post-link-button' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->add_responsive_control(
            'post_link_button_padding',
            [
                'label' =>  esc_html__('Padding', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-link-button' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_link_button_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>    \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-link-button' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
		$this->end_controls_section();

        $this->start_controls_section(
            'pagintion_style',
            [
                'label' =>  esc_html__( 'Pagination', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'  =>  'default_pagination_typography',
				'fields_options' => [
					'typography' => [
						'default' => 'custom'
					],
					'font_family' => [
						'default' => 'Rubik'
					],
					'font_weight' => [
						'default' => 500
					]
				],
				'selector'  =>   '{{WRAPPER}} .posts-pagination .nav-links a, {{WRAPPER}} .posts-pagination .page-numbers, {{WRAPPER}} .nekit-load-more'
			]
		);

            $this->start_controls_tabs(
                'pagination_tabs'
            );
                $this->start_controls_tab(
                    'pagination_initial_tab',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'default_pagination_initial_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .posts-pagination .nav-links a'    =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .posts-pagination .page-numbers'   => 'color: {{VALUE}}',
                            '{{WRAPPER}} .nekit-load-more'  =>    'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'default_pagination_initial_background_color',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .nav-links a, {{WRAPPER}} .posts-pagination .page-numbers, {{WRAPPER}} .nekit-load-more',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'default_pagination_initial_box_shadow',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .nav-links a, {{WRAPPER}} .posts-pagination .page-numbers, {{WRAPPER}} .nekit-load-more'
                    ]
                );
                
                $this->end_controls_tab();
                $this->start_controls_tab(
                    'pagination_hover_tab',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'default_pagination_hover_color',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .posts-pagination .nav-links a:hover'  =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .posts-pagination .page-numbers:hover' =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .nekit-load-more:hover'    =>    'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'default_pagination_background_color_hover',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .nav-links a:hover, {{WRAPPER}} .posts-pagination .page-numbers:hover, {{WRAPPER}} .nekit-load-more:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'default_pagination_box_shadow_hover',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .nav-links a:hover, {{WRAPPER}} .posts-pagination .page-numbers:hover, {{WRAPPER}} .nekit-load-more:hover'
                    ]
                );
                
                $this->end_controls_tab();
                $this->start_controls_tab(
                    'pagination_active_tab',
                    [
                        'label' =>  esc_html__( 'Active', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'default_pagination_active_color',
                    [
                        'label' =>  esc_html__( 'Active Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .posts-pagination .current'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'default_pagination_background_color_active',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .current',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'default_pagination_box_shadow_active',
                        'selector'  =>  '{{WRAPPER}} .posts-pagination .current'
                    ]
                );
                
                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'default_pagination_border',
                'selector' => '{{WRAPPER}} .posts-pagination .nav-links a, {{WRAPPER}} .posts-pagination .page-numbers, {{WRAPPER}} .nekit-load-more'
            ]
        );

        $this->add_control(
            'default_pagination_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .posts-pagination .nav-links a'    =>  'border-radius: {{VALUE}}px',
                    '{{WRAPPER}} .posts-pagination .page-numbers'   => 'border-radius: {{VALUE}}px',
                    '{{WRAPPER}} .nekit-load-more'  =>    'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'default_pagination_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .posts-pagination .nav-links a'    =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .posts-pagination .page-numbers'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .nekit-load-more'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'default_pagination_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .posts-pagination .nav-links a, {{WRAPPER}} .posts-pagination .page-numbers, {{WRAPPER}} .nekit-load-more'    =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'no_posts_found_heading',
            [
                'label' =>  esc_html__( 'No Posts Found', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'no_posts_found_typography',
                'selector'  =>  '{{WRAPPER}} .no-posts-found'
            ]
        );

        $this->add_control(
            'no_posts_found_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .no-posts-found'   =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'no_posts_found_background',
                'selector'  =>  '{{WRAPPER}} .no-posts-found',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_control(
            'no_posts_found_alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'toggle'    =>  false,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .no-posts-found'   =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_responsive_control(
			'pagination_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	13
				],
				'selectors' => [
					'{{WRAPPER}} .posts-pagination i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
            'pagination_icon_distance',
            [
                'label' =>  esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  10
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nav-previous i'   =>  'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .nav-next i'   =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .prev.page-numbers i'   =>  'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .next.page-numbers i'   =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .nekit-load-more i'   =>  'margin-left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
        $this->add_image_overlay_section();
    }

    protected function render() {
        $elementClass[] = 'nekit-archive-posts-wrap';
        $query_parameters =  $GLOBALS['wp_query']->query_vars;
        $archive = '';
        $queried_object_id = '';
        if( is_category() || is_tag() || is_author() ) $queried_object_id = get_queried_object_id();
        if( is_category() ) $archive = 'category'; 
        if( is_tag() ) $archive = 'tag'; 
        if( is_author() ) $archive = 'author'; 
        if( is_date() ) :
            $archive = 'date';
            $date = $query_parameters['year'];
            $month_num = $query_parameters['monthnum'];
            $day = $query_parameters['day'];
            $queried_object_id = [
                'date'  =>  $date,
                'monthnum'  =>  $month_num,
                'day'   =>  $day
            ];
        endif;
        if( is_search() ) :
            $archive = 'search';
            $queried_object_id = $query_parameters['s'];
        endif;
        $settings = $this->get_settings_for_display();$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
        $this->add_render_attribute( 'image_hover', 'class', $imageClass );
        $titleClass = 'post-title';
        if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );
        $settings['check_archive'] = $archive;
        $settings['queried_object_id'] = $queried_object_id;
        $settings['imageClass'] = $this->get_render_attribute_string( 'image_hover' );
        $settings['titleClass'] = $this->get_render_attribute_string( 'title_hover' );
        ?>
            <script>
                nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode( $settings ); ?>
            </script>
        <?php
        $widget_column = isset( $settings['widget_column'] ) ? absint($settings['widget_column']): 4;
        $widget_column_tablet = isset( $settings['widget_column_tablet'] ) ? absint($settings['widget_column_tablet']): absint($widget_column);
        $widget_column_mobile = isset( $settings['widget_column_mobile'] ) ? absint($settings['widget_column_mobile']): absint($widget_column);
        $elementClass[] = 'layout--' . $settings['widget_layouts'];
        $elementClass[] = 'skin--' . $settings['widget_skin'];
        $elementClass[] = 'desktop-column--' . nekit_convert_number_to_numeric_string($widget_column);
        $elementClass[] = 'tablet-column--' . nekit_convert_number_to_numeric_string($widget_column_tablet);
        $elementClass[] = 'mobile-column--' . nekit_convert_number_to_numeric_string($widget_column_mobile);
        $elementClass[] = 'card-animation--' . $settings['card_hover_effects_dropdown'];
        if( in_array( $settings['widget_layouts'], [ 'two', 'four' ] ) ) $elementClass[] = ( $settings['adjust_as_grid_on_smaller_screen'] == 'yes' ) ? 'adjust-grid--on' : 'adjust-grid--off';
        $ajax_imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$ajax_imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        $count = $GLOBALS['wp_query']->max_num_pages;
        $prev_icon = nekit_get_base_value( [ 'icon' => $settings['default_pagination__prev_icon'] ] );
        $next_icon = nekit_get_base_value( [ 'icon' => $settings['default_pagination__next_icon'] ] );
        ?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-page="1" data-max-num-page="<?php echo esc_attr( $count ); ?>" data-no-posts-found = "<?php echo esc_attr( $settings['no_posts_found'] ); ?>">
                <?php
                    if( have_posts() ) :
                        echo '<div class="posts-inner-wrap">';
                            while( have_posts() ) : the_post();
                                $this->template_part();
                            endwhile;
                        echo '</div>';
                        echo '<div class="posts-pagination ' .esc_attr( 'type--' . $settings['pagination_type'] ). '">';
                            $pagination_type = $settings['pagination_type'];
                            switch( $pagination_type ) {
                                case 'number': if( paginate_links() ) {
                                                    echo wp_kses_post(paginate_links([
                                                        'prev_text' => $prev_icon . esc_html( $settings['default_pagination__prev_text'] ),
                                                        'next_text' => esc_html( $settings['default_pagination__next_text'] ) . $next_icon
                                                    ]));
                                                }
                                            break;
                                case 'ajax': $ajax_button_icon = nekit_get_base_value( [ 'icon' =>  $settings['ajax_pagination_button_icon'] ] );
                                    echo '<button class="nekit-load-more">' . esc_attr( $settings["ajax_pagination_button_text"] ) . wp_kses_post( $ajax_button_icon ) . '</button>';
                                        break;
                                default:  
                                the_posts_navigation([
                                                'prev_text' => $prev_icon . esc_html( $settings['default_pagination__prev_text'] ),
                                                'next_text' => esc_html( $settings['default_pagination__next_text'] ) . $next_icon
                                            ]);
                            }
                        echo '</div>';
                    else :
                        // get template part
                        $this->template_part( 'none' );
                    endif;
                ?>
            </div>
        <?php
    }

    /**
     * Generate the html template for widget
     * 
     * @since 1.0.0
     * @since News Kit Elementor Addons
     */
    public function template_part( $part = 'default' ) {
        $settings = $this->get_settings_for_display();
        $link_target = $settings['link_target'] ? $settings['link_target'] : '_self';
        $post_title_tag = $settings['title_html_tag'] ? $settings['title_html_tag'] : 'h2';
        switch( $part ) {
            case 'none': ?>
                            <div class="content-not-found">
                                <h2 class="posts-not-found"><?php echo esc_html__( 'No posts published yet!', 'news-kit-elementor-addons' ); ?>
                            </div>
                <?php
                    break;
           default : ?>
                        <article <?php post_class( 'post-item' ); ?>>
                            <div class="nekit-item-box-wrap">
                                <figure class="post-thumb">
                                    <?php
                                        if( has_post_thumbnail() ) :
                                    ?>
                                            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $link_target ); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?>>
                                                <div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                                    <?php
                                                        the_post_thumbnail( $settings['image_size'], [
                                                            'title' => the_title_attribute(array(
                                                                'echo'  => false
                                                            ))
                                                        ]);
                                                    ?>
                                                </div>
                                            </a>
                                            <?php
                                            if( $settings['show_post_categories'] == 'yes' ):
                                                if( $settings['widget_layouts'] != 'three' ) nekit_get_post_categories( get_the_ID(), 2 );
                                            endif;
                                        endif;
                                    ?>
                                </figure>
                                <div class="post-element">
                                    <?php
                                        if( $settings['show_post_categories'] == 'yes' ):
                                            if( $settings['widget_layouts'] == 'three' ) nekit_get_post_categories( get_the_ID(), 2 );
                                        endif;
                                        if( $settings['show_post_title'] == 'yes' ) :
                                            the_title('<' .esc_html( $post_title_tag ). ' '. $this->get_render_attribute_string( 'title_hover' ) .'><a href="' .esc_url( get_the_permalink() ). '" target="' .esc_attr( $link_target ). '">','</a></' .esc_html( $post_title_tag ). '>');
                                        endif;
                                    ?>
                                    <div class="post-meta">
                                        <?php
                                            if( $settings['show_post_author'] == 'yes' )
                                                echo wp_kses_post(nekit_get_posts_author([
                                                    'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
                                                    'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
                                                        'value' =>  'far fa-user-circle',
                                                        'library'   =>  'fa-regular'
                                                    ],
                                                    'url'   =>  'yes'
                                                ]));
                                            if( $settings['show_post_date'] == 'yes' ) 
                                                echo wp_kses_post(nekit_get_posts_date([
                                                    'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
                                                    'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
                                                        'value' =>  'fas fa-calendar',
                                                        'library'   =>  'fa-solid'
                                                    ],
                                                    'url'   =>  'yes'
                                                ]));
                                            if( $settings['show_post_comments'] == 'yes' )
                                                echo wp_kses_post(nekit_get_posts_comments([
                                                    'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
                                                    'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
                                                        'value' =>  'far fa-comment',
                                                        'library'   =>  'fa-regular'
                                                    ]
                                                ]));
                                        ?>
                                    </div>
                                    <?php
                                        if($settings['show_post_excerpt'] == 'yes' ) :
                                            nekit_get_post_excerpt_output($settings['post_excerpt_length'] ? $settings['post_excerpt_length']: 0);
                                        endif;
                                        
                                        if( $settings['show_post_button'] == 'yes' ) : ?>
                                            <a class="post-link-button" href="<?php the_permalink() ?>" target="<?php echo esc_attr( $link_target ); ?>">
                                                <?php echo esc_html( $settings['post_button_text'] ); ?>
                                                <?php
                                                    echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $settings['post_button_icon'] ) ? $settings['post_button_icon'] : [
                                                        'value' => 'fas fa-angle-right',
                                                        'library'   =>  'fa-solid'
                                                    ]));
                                                ?>
                                            </a>
                                        <?php
                                        endif;
                                    ?>
                                </div><!-- .post-element -->
                            </div><!-- .nekit-item-box-wrap -->
                        </article>
        <?php
        }
    }
}