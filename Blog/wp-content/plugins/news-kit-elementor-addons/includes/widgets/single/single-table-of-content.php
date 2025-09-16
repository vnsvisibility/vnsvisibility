<?php
/**
 * Single Table of Content Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Table_Of_Content extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-table-of-content';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-table-of-content';
    }
     
    public function get_keywords() {
        return ['single','table','content'];
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-table-of-content" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'title',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Table of Content', 'news-kit-elementor-addons' ),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' =>  esc_html__( 'Title Tag', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'h2',
                'options'   =>  $this->get_html_tags()
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'anchor_by_tags',
            [
                'label' =>  esc_html__( 'Anchor By Tags', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT2,
                'default'   =>  ['h2', 'h3'],
                'multiple'  =>  true,
                'options'   =>  [
                    'h1'    =>  esc_html__( 'H1', 'news-kit-elementor-addons' ),
                    'h2'    =>  esc_html__( 'H2', 'news-kit-elementor-addons' ),
                    'h3'    =>  esc_html__( 'H3', 'news-kit-elementor-addons' ),
                    'h4'    =>  esc_html__( 'H4', 'news-kit-elementor-addons' ),
                    'h5'    =>  esc_html__( 'H5', 'news-kit-elementor-addons' ),
                    'h6'    =>  esc_html__( 'H6', 'news-kit-elementor-addons' )
                ],
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'list_view',
            [
                'label' =>  esc_html__( 'List View', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'flat',
                'multiple'  =>  true,
                'options'   =>  apply_filters( 'nekit_toc_list_view_options_array_filter', [
                    'flat'    =>  esc_html__( 'Flat View', 'news-kit-elementor-addons' )
                ])
            ]
        );

        $this->add_control(
            'marker',
            [
                'label' =>  esc_html__( 'Marker Type', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'bullets',
                'multiple'  =>  true,
                'options'   =>  apply_filters( 'nekit_toc_marker_type_options_array_filter', [
                    'bullets'    =>  esc_html__( 'Bullets', 'news-kit-elementor-addons' ),
                    'circle'    =>  esc_html__( 'Circle', 'news-kit-elementor-addons' )
                ])
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'additional_setting',
            [
                'label' =>  esc_html__( 'Additional Setting', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label' =>  esc_html__( 'Display As', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'toggle',
                'multiple'  =>  true,
                'options'   =>  apply_filters( 'nekit_toc_dispolay_type_options_array_filter', [
                    'normal'    =>  esc_html__( 'Normal', 'news-kit-elementor-addons' ),
                    'sticky-pro'    =>  esc_html__( 'Sticky / Toggle ( in pro )', 'news-kit-elementor-addons' ),
                    'toggle-pro'    =>  esc_html__( 'Toggle ( in pro )', 'news-kit-elementor-addons' )
                ]),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'display_type_sticky_show_icon',
            [
                'label' =>  esc_html__( 'Toggle Show Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up'],
                    'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-tasks'
                ],
                'exclude_inline_options'    =>  'svg',
                'condition' => [
                    'display_type'  => 'sticky'
                ]
            ]
        );

        $this->add_control(
            'display_type_sticky_hide_icon',
            [
                'label' =>  esc_html__( 'Toggle Hide Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up'],
                    'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-times'
                ],
                'exclude_inline_options'    =>  'svg',
                'condition' => [
                    'display_type'  => 'sticky'
                ]
            ]
        );

        $this->add_control(
            'display_type_toggle_maximized_icon',
            [
                'label' =>  esc_html__( 'Maximized Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up'],
                    'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-chevron-up'
                ],
                'exclude_inline_options'    =>  'svg',
                'condition' => [
                    'display_type'  => 'toggle'
                ]
            ]
        );

        $this->add_control(
            'display_type_toggle_minimized_icon',
            [
                'label' =>  esc_html__( 'Minimized Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up'],
                    'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-chevron-down'
                ],
                'exclude_inline_options'    =>  'svg',
                'condition' => [
                    'display_type'  => 'toggle'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'icon_font_size',
            [
                'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  16,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .toc-content-toggle-button'    =>  'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .toc-toggle-button'    =>  'font-size: {{SIZE}}{{UNIT}}'

                ],
                'condition' => [
                    'display_type!'  => 'normal'
                ]
            ]
        );

        $this->add_control(
			'icon_sticky_position',
			[
				'label' =>  esc_html__( 'Fixed Position', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::CHOOSE,
				'options'   =>  [
					'left'  =>   [
						'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'  =>  'eicon-h-align-left'
					],
					'right' =>  [
						'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-h-align-right'
					]
				],
                'condition' =>  [
                    'display_type'  =>  'sticky'
				],
				'default'   =>  'left',
				'toggle'    => false
			]
		);

        $this->add_responsive_control(
			'icon_distance_left',
			[
				'label' =>  esc_html__( 'Distance Left', 'news-kit-elementor-addons' ),
				'type'  =>   \Elementor\Controls_Manager::SLIDER,
				'range' =>  [
					'px'    => [
						'min'   =>  0,
						'max'   =>  1000,
						'step'  =>  1
					]
				],
				'default'   =>  [
					'unit'  =>  'px',
					'size'  =>  40
				],
                'condition' =>  [
                    'display_type'   => 'sticky',
                    'icon_sticky_position'   => 'left'
				],
				'selectors' =>  [
					'{{WRAPPER}} .toc-toggle-button'    =>  'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'icon_distance_right',
			[
				'label' =>  esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px'    =>  [
						'min'   =>  0,
						'max'   =>  1000,
						'step'  =>  1
					]
				],
				'default'   =>  [
					'unit'  =>  'px',
					'size'  =>  0
				],
                'condition' =>  [
					'display_type'  =>  'sticky',
                    'icon_sticky_position'  =>  'right'
				],
				'selectors' =>  [
					'{{WRAPPER}} .toc-toggle-button'    =>  'right: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'icon_distance_top',
			[
				'label' =>  esc_html__( 'Distance Top', 'news-kit-elementor-addons' ),
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
					'size'  =>  60
				],
                'condition' =>  [
                    'display_type'  =>  'sticky'
				],
				'selectors' => [
					'{{WRAPPER}} .toc-toggle-button'    =>  'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
            'no_heading_found_settings',
            [
                'label' =>  esc_html__( 'No Headings Found', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'toc_option',
			[
				'label' => esc_html__( 'Hide table of content', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'  => 'yes',
                'condition' => apply_filters( 'nekit_toc_option_condition_filter',[
                    'display_type'  => 'pro'
                ])
			]
		);

        $this->add_control(
            'no_heading_found_text',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'default'   =>  esc_html__( 'No headings found', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'label_block'   =>  true
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

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'widget_background',
                'selector'  =>  '{{WRAPPER}} .table-of-content-wrap',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'  =>  'widget_border',
				'selector'  =>  '{{WRAPPER}} .table-of-content-wrap',
			]
		);
        $this->add_responsive_control(
            'widget_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px' =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  0
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .table-of-content-wrap'  =>  'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'widget_box_shadow',
				'selector' => '{{WRAPPER}} .table-of-content-wrap',
			]
		);

        $this->insert_divider();

        $this->get_spacing_control( 'widget_padding', 'Padding', '.table-of-content-wrap', 'padding' );

        $this->get_spacing_control( 'widget_margin', 'Margin', '.table-of-content-wrap', 'margin' );

        $this->insert_divider();

        $this->add_control(
			'content_list_heading',
			[
				'label' =>  esc_html__( 'Content List', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::HEADING,
				'separator' =>  'after'
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'content_list_background',
                'selector'  =>  '{{WRAPPER}} .table-of-content-list-wrap',
                'exclude'   =>  ['image']
            ]
        );

        $this->get_spacing_control( 'content_list_padding', 'Padding', '.table-of-content-list-wrap', 'padding', [ 20, 0, 0, 0 ] );

        $this->get_spacing_control( 'content_list_margin', 'Margin', '.table-of-content-list-wrap', 'margin' );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_styles',
            [
                'label' =>  esc_html__( 'Title Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'title_typography',
                'selector'  =>  '{{WRAPPER}} .table-of-content-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#54595F',
                'selectors' =>  [
                    '{{WRAPPER}} .table-of-content-title' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'title_background',
                'selector'  =>  '{{WRAPPER}} .table-of-content-title-wrap',
                'exclude'   =>  ['image']
            ]
        );
        $this->insert_divider();

        $this->get_spacing_control( 'heading_padding', 'Padding', '.table-of-content-title-wrap', 'padding', [ 0, 0, 15, 0 ] );

        $this->get_spacing_control( 'heading_margin', 'Margin', '.table-of-content-title-wrap', 'margin' );

        $this->insert_divider();
        
        $this->add_control(
			'seperator_width',
			[
				'label' => esc_html__( 'Seperator Width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .table-of-content-title-wrap' => 'border-bottom: {{SIZE}}{{UNIT}} solid;'
				]
			]
		);
        $this->add_control(
            'seperator_color',
            [
                'label' =>  esc_html__( 'Seperator Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#E0E0E0',
                'selectors' =>  [
                    '{{WRAPPER}} .table-of-content-title-wrap' =>  'border-color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'parent_styles',
            [
                'label' =>  esc_html__( 'Parent Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'parent_typography',
                'selector'  =>  '{{WRAPPER}} .toc-list-item-wrap > .toc-list-item'
            ]
        );

        $this->add_control(
            'parent_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .toc-list-item-wrap > .toc-list-item a, {{WRAPPER}} .toc-list-item-wrap > li::marker' =>  'color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'children_styles',
            [
                'label' =>  esc_html__( 'Children', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'child_typography',
                'selector'  =>  '{{WRAPPER}} .toc-list-item .toc-list-item-wrap li'
            ]
        );

        $this->add_control(
            'child_color',
            [
                'label' =>  esc_html__( 'Color','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .toc-list-item .toc-list-item-wrap a, {{WRAPPER}} .toc-list-item .toc-list-item-wrap li::marker' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
			'child_indent',
			[
				'label' =>  esc_html__( 'Indent', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SLIDER,
				'size_units'    =>  [ 'px' ],
				'range' =>  [
					'px'    =>  [
						'min'   =>  0,
						'max'   =>  150,
						'step'  =>  1
					]
				],
				'selectors' => [
					'{{WRAPPER}} .toc-list-item .toc-list-item-wrap' => 'margin-left: {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
			'toggle_button_style_section',
			[
				'label' =>  esc_html__( 'Toggle Button', 'news-kit-elementor-addons' ),
				'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
			]
		);
			$this->start_controls_tabs(
				'widget_style_tabs'
			);
				$this->start_controls_tab(
					'toggle_button_initial_style_tab',
					[
						'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
					]
				);
				
                $this->add_control(
                    'icon_initial_color',
                    [
                        'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .toc-content-toggle-button' =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .toc-toggle-button' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'		=>	'toggle_button_background_color',
						'types'		=>	['classic','gradient'], 
						'selector'	=> '{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button',
						'exclude'   => ['image']
					]
				);

				$this->add_group_control(
	                \Elementor\Group_Control_Box_Shadow::get_type(),
	                [
	                    'name'  =>  'toggle_button_initial_box_shadow',
	                    'selector'  =>  '{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button'
	                ]
	            );
				$this->end_controls_tab();
				$this->start_controls_tab(
					'widget_hover_style_tab',
					[
						'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
					]
				);
				
                $this->add_control(
                    'icon_hover_color',
                    [
                        'label' =>  esc_html__( 'Icon Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .toc-content-toggle-button:hover' =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .toc-toggle-button:hover' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'toggle_button_background_hover_color',
						'types' => ['classical', 'gradient'],
						'exclude' => ['image'],
						'selector' => '{{WRAPPER}} .toc-toggle-button:hover, {{WRAPPER}} .toc-content-toggle-button:hover'
					]
				);

				$this->add_group_control(
	                \Elementor\Group_Control_Box_Shadow::get_type(),
	                [
	                    'name' => 'toggle_button_hover_box_shadow',
	                    'selector' => '{{WRAPPER}} .toc-toggle-button:hover, {{WRAPPER}} .toc-content-toggle-button:hover'
	                ]
	            );
				$this->end_controls_tab();
			$this->end_controls_tabs();
            $this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name'  =>  'toggle_button_border',
					'selector'  =>  '{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button'
				]
			);

            $this->add_control(
                'toggle_button_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  500,
                    'step'  =>  1,
                    'selectors' =>  [
                        '{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button'    =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

			$this->add_responsive_control(
				'toggle_button_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>   \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'default'   =>    [ 
						'top'   =>  '0',
						'right' =>  '0',
						'bottom'    =>  '0',
						'left'  =>  '0',
						'unit'  =>  'px',
						'isLinked'  =>  true
					],
					'selectors' => [
						'{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_responsive_control(
            'toggle_button_margin',
	            [
	                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
	                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'    =>  ['px', '%', 'em', 'custom'],
	                'default'   =>  [
	                    'top'   =>  0,
	                    'right' =>  0,
	                    'bottom'    =>  0,
	                    'left'  =>  0,
	                    'unit'  =>  'px',
	                    'isLinked'  =>  true
	                ],
	                'selectors'=>[
	                    '{{WRAPPER}} .toc-toggle-button, {{WRAPPER}} .toc-content-toggle-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
	                ]
	            ]
	        );
		$this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display();
        $display_type = ( isset( $settings['display_type'] ) && ! strpos( $settings['display_type'], '-pro' ) ) ? $settings['display_type']: 'normal';
        $elementClass = 'nekit-single-table-of-content';
        $elementClass .= ' toc-list-type--' . $settings['marker'];
        $elementClass .= ' toc-display-type--' . esc_attr( $display_type );
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        $anchors = implode( ",", $settings['anchor_by_tags'] );
        $toc_option = ( isset( $settings['toc_option'] ) && $settings['toc_option'] == 'yes' ) ? 'true': 'false';
    ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-anchor="<?php echo esc_html( $anchors ); ?>" data-marker="<?php echo esc_html( $settings['marker'] ); ?>" data-view="<?php echo esc_html( $settings['list_view'] ); ?>" data-hide="<?php echo esc_attr( $toc_option ); ?>" data-text="<?php echo esc_attr( $settings['no_heading_found_text'] ); ?>">
            <?php
                if( $display_type == 'sticky' ) :
            ?>
                    <button class="toc-toggle-button" data-maximized="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_sticky_show_icon'] ] ) ); ?>" data-minimized="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_sticky_hide_icon'] ] ) ); ?>"><i class="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_sticky_show_icon'] ] ) ); ?>"></i></button>
            <?php
                endif;
            ?>
            <div class="table-of-content-wrap" <?php if( $display_type == 'sticky' ) echo 'style="display: none;"'; ?>>
                <div class="table-of-content-title-wrap">
                    <?php
                        echo '<' . esc_html( $settings['title_tag'] ) . ' class="table-of-content-title">' .esc_html( $settings['title'] ).'</' . esc_html( $settings['title_tag'] ) . '>';
                        if( $display_type == 'toggle' ) :
                    ?>
                            <button class="toc-content-toggle-button" data-maximized="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_toggle_maximized_icon'] ] ) ); ?>" data-minimized="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_toggle_minimized_icon'] ] ) ); ?>"><i class="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon' => $settings['display_type_toggle_maximized_icon'] ] ) ); ?>"></i></button>
                    <?php
                        endif;
                    ?>
                </div>
                <div class="table-of-content-list-wrap"></div>
            </div>
        </div>
    <?php
    }
 }