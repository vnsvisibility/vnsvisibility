<?php
/**
 * Social Share Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Social_Share_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls(){
        $this->start_controls_section(
            'general_section',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->get_item_orientation_control();

        $this->add_control(
            'alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'center',
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'    =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right' =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-wrap a'    =>  'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .social-share-wrap a'    =>  '-webkit-justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'widget_position',
            [
                'label' =>  esc_html__( 'Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  [
                    'initial'    =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                    'fixed' =>  esc_html__( 'Fixed', 'news-kit-elementor-addons' )
                ],
                'default'   =>  'initial',
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-social-share'    =>  'position: {{VALUE}}'
                ],
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_responsive_control(
            'no_of_columns',
            [
                'label' =>  esc_html__( 'No of Columns', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  5,
                'step'  =>  1,
                'default'   =>  4
            ]
        );

        $this->add_control(
            'open_link_in_same_tab',
            [
                'label' =>  esc_html__( 'Open Link in', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  [
                    '_self'  =>  esc_html__( 'Same Tab', 'news-kit-elementor-addons' ),
                    '_blank'  =>  esc_html__( 'New Tab', 'news-kit-elementor-addons' )
                ],
                'default'   =>  '_self',
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'widget_position_divider',
            [
                'type'  =>  \Elementor\Controls_Manager::DIVIDER,
                'condition' =>  [
                    'widget_position'   =>  'fixed'
                ]
            ]
        );

        $this->add_control(
            'fixed_position',
            [
                'label' =>  esc_html__( 'Fixed Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-left'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-right'
                    ]
                ],
                'default'   =>  'left',
                'condition' =>  [
                    'widget_position'    =>  'fixed'
                ]
            ]
        );

        $this->add_responsive_control(
            'distance_right',
            [
                'label' =>  esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
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
                    'size'  =>  0
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-social-share'    =>  'right: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'widget_position'  =>  'fixed',
                    'fixed_position'    =>  'right'
                ]
            ]
        );

        $this->add_responsive_control(
            'distance_left',
            [
                'label' =>  esc_html__( 'Distance Left', 'news-kit-elementor-addons' ),
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
                    'size'  =>  0
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-social-share'    =>  'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'widget_position'  =>  'fixed',
                    'fixed_position'    =>  'left'
                ]
            ]
        );

        $this->add_responsive_control(
            'distance_bottom',
            [
                'label' =>  esc_html__( 'Distance Bottom', 'news-kit-elementor-addons' ),
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
                    'size'  =>  500
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-social-share'    =>  'bottom: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'widget_position'  =>  'fixed'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'social_share_prefix_section',
            [
                'label' =>  esc_html__( 'Social Share Prefix', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_prefix',
            [
                'label' =>  esc_html__( 'Show Prefix', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_prefix_text',
            [
                'label' =>  esc_html__( 'Show Prefix Text', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes',
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'prefix_text',
            [
                'label' =>  esc_html__( 'Prefix Text', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Share :', 'news-kit-elementor-addons' ),
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'prefix_icon',
            [
                'label' =>  esc_html__( 'Prefix Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['share-alt','share','share-square','share-alt-square'],
                    'fa-regular'  => ['share-square']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-share-alt',
                    'library'   =>  'fa-solid'
                ],
                'label_block'   =>  false
            ]
        );

        $this->add_control(
            'prefix_title_position',
            [
                'label' =>  esc_html__( 'Title Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  [
                    'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' ),
                    'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                ],
                'default'   =>  'after',
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        ); 

        $this->add_control(
            'prefix_icon_size',
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
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-prefix .prefix-icon'    =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'prefix_icon_distance',
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
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-prefix'    =>  'gap: {{SIZE}}{{UNIT}}'
                ],
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'show_social_share_on_click',
            [
                'label' =>  esc_html__( 'Show Social Share on Click', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'social_share_section',
            [
                'label' =>  esc_html__( 'Social Share', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'social_share_icon',
            [
                'label' =>  esc_html__( 'Social Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'default'   =>  [
                    'value' =>  'fab fa-facebook-f',
                    'library'   =>  'fa-brands'
                ],
                'skin'  =>  'inline',
                'label_block'   =>  false
            ]
        );

        $repeater->add_control(
            'social_share_title',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $repeater->add_control(
            'social_share_link_to',
            [
                'label' =>  esc_html__( 'Link to: ', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT2,
                'multiple'  =>  false,
                'options'   =>  apply_filters( 'nekit_social_share_link_to_options_array_filter', [
                    'facebook'  =>  esc_html__( 'Facebook', 'news-kit-elementor-addons' ),
                    'twitter'  =>  esc_html__( 'Twitter', 'news-kit-elementor-addons' ),
                    'linkedin'  =>  esc_html__( 'LinkedIn', 'news-kit-elementor-addons' ),
                    'email'  =>  esc_html__( 'Email', 'news-kit-elementor-addons' ),
                    'gmail'  =>  esc_html__( 'Gmail', 'news-kit-elementor-addons' ),
                    'whatsapp'  =>  esc_html__( 'WhatsApp', 'news-kit-elementor-addons' )
                ]),
                'default'   =>  'facebook'
            ]
        );

        $repeater->add_control(
            'social_share_divider',
            [
                'type'  =>  \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $repeater->start_controls_tabs(
            'social_share_tabs'
        );
            $repeater->start_controls_tab(
                'initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $repeater->add_control(
                'initial_icon_color',
                [
                    'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#fff',
                    'selectors' =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .social-share-icon'  =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $repeater->add_control(
                'initial_title_color',
                [
                    'label' =>  esc_html__( 'Title Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#fff',
                    'separator' =>  'after',
                    'selectors' =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .social-share-title'  =>  'color: {{VALUE}}'
                    ],
                    'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                        'alignment' => 'pro'
                    ])
                ]
            );

            $repeater->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'initial_background_color',
                    'selector' =>   '{{WRAPPER}} .nekit-social-share:not(.official-color--on) {{CURRENT_ITEM}}.social-share a',
                    'exclude'   =>  [ 'image' ]
                ]
            );

            $repeater->add_control(
                'initial_border_color',
                [
                    'label' =>  esc_html__( 'Border Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.social-share a'  =>  'border-color: {{VALUE}}'
                    ]
                ]
            );
            $repeater->end_controls_tab();

            $repeater->start_controls_tab(
                'hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $repeater->add_control(
                'hover_icon_color',
                [
                    'label' =>  esc_html__( 'Hover Icon Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#fff',
                    'selectors'  =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.social-share:hover .social-share-icon i'  =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $repeater->add_control(
                'hover_title_color',
                [
                    'label' =>  esc_html__( 'Hover Title Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#fff',
                    'selectors' =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.social-share:hover .social-share-title'  =>  'color: {{VALUE}}'
                    ],
                    'separator' =>  'after',
                    'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                        'alignment' => 'pro'
                    ])
                ]
            );

            $repeater->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'hover_background_color',
                    'selector' =>   '{{WRAPPER}} .nekit-social-share:not(.official-color--on) {{CURRENT_ITEM}}.social-share a:hover',
                    'exclude'   =>  [ 'image' ]
                ]
            );

            $repeater->add_control(
                'hover_border_color',
                [
                    'label' =>  esc_html__( 'Hover Border Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.social-share a:hover'  =>  'color: {{VALUE}}'
                    ]
                ]
            );
            $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'social_share_repeater',
            [
                'label' =>  esc_html__( 'Social Share List', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::REPEATER,
                'fields'    =>  $repeater->get_controls(),
                'default'   =>  [
                    [
                        'social_share_title' =>  esc_html__( 'Facebook', 'news-kit-elementor-addons' ),
                        'social_share_icon' =>  [
                            'value' =>  'fab fa-facebook-f',
                            'library'   =>  'fa-brands'
                        ],
                        'social_share_link_to'  =>  'facebook'
                    ],
                    [
                        'social_share_title' =>  esc_html__( 'Twitter', 'news-kit-elementor-addons' ),
                        'social_share_icon' =>  [
                            'value' =>  'fab fa-twitter',
                            'library'   =>  'fa-brands'
                        ],
                        'social_share_link_to'  =>  'twitter'
                    ]
                ],
                'title_field'   =>  '{{{ social_share_title }}}'
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_title',
            [
                'label' =>  esc_html__( 'Show Social Share Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_official_color',
            [
                'label' =>  esc_html__( 'Show Official Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );
    
        $this->add_control(
            'title_position',
            [
                'label' =>  esc_html__( 'Title Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  [
                    'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' ),
                    'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                ],
                'default'   =>  'after',
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'icon_size',
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
                    '{{WRAPPER}} .social-share-icon'    =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'icon_distance',
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
                'selectors' =>  [
                    '{{WRAPPER}} .social-share a'    =>  'gap: {{SIZE}}{{UNIT}}'
                ],
                'condition' => apply_filters( 'nekit_social_share_position_condition_filter', [
                    'alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
			'card_hover_effects_dropdown',
			[
				'label'	=>	esc_html__( 'Hover Effects', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'options'	=>	apply_filters( 'nekit_social_share_hover_effects_options_array_filter', [
                    'none'	=>	esc_html__( 'None', 'news-kit-elementor-addons' ),
					'one'	=>	esc_html__( 'Effect 1', 'news-kit-elementor-addons' )
				]),
				'default'	=>	'none'
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

        $this->add_control(
            'row_gap',
            [
                'label' =>  esc_html__( 'Row Gap', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'default' => [
					'unit' => 'px',
					'size' => 4,
				],
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  nekit_get_widgets_row_gap_max(),
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-wrap' =>  'row-gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label' =>  esc_html__( 'Column Gap', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'default' => [
					'unit' => 'px',
					'size' => 4,
				],
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  nekit_get_widgets_column_gap_max(),
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-wrap' =>  'column-gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'social_share_prefix_typography',
            [
                'label' =>  esc_html__( 'Social Share Prefix Typography', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'social_share_prefix_typography',
                'selector' =>  '{{WRAPPER}} .prefix-text'
            ]
        );

        $this->add_control(
            'social_share_prefix_icon_color',
            [
                'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .prefix-icon'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'social_share_prefix_title_color',
            [
                'label' =>  esc_html__( 'Title Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .prefix-text'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'social_share_prefix_background_color',
                'selector' =>   '{{WRAPPER}} .social-share-prefix',
                'exclude'   =>  [ 'image' ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'social_share_prefix_box_shadow',
                'selector'  =>  '{{WRAPPER}} .social-share-prefix'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'social_share_prefix_border',
                'selector'  =>  '{{WRAPPER}} .social-share-prefix'
            ]
        );

        $this->add_control(
            'social_share_prefix_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-prefix' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'social_share_prefix_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-prefix' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'social_share_prefix_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share-prefix' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'social_share_typography',
            [
                'label' =>  esc_html__( 'Social Share Typography', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'social_share_typography',
                'selector' =>  '{{WRAPPER}} .social-share-title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'social_share_box_shadow',
                'selector'  =>  '{{WRAPPER}} .social-share a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'label' =>  esc_html__( 'Box Shadow Hover', 'news-kit-elementor-addons' ),
                'name'  =>  'social_share_box_shadow_hover',
                'selector'  =>  '{{WRAPPER}} .social-share a:hover'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'social_share_border',
                'selector'  =>  '{{WRAPPER}} {{CURRENT_ITEM}}.social-share a'                
            ]
        );

        $this->add_responsive_control(
            'social_share_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share a' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->add_responsive_control(
            'social_share_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .social-share a' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-social-share';
        $elementClass .= ' items-orientation--' . $settings['items_orientation'];
        $elementClass .= esc_attr( " column--" . nekit_convert_number_to_numeric_string( $settings['no_of_columns'] ) );        
		$widget_column_tablet = ( isset( $settings['no_of_columns_tablet'] ) && is_int( $settings['no_of_columns_tablet'] ) ) ? $settings['no_of_columns_tablet']: 3;
		$widget_column_mobile = ( isset( $settings['no_of_columns_mobile'] ) && is_int( $settings['no_of_columns_mobile'] ) ) ? $settings['no_of_columns_mobile']: 1;        
        $elementClass .= ' tablet-column--' . nekit_convert_number_to_numeric_string($widget_column_tablet);
        $elementClass .= ' mobile-column--' . nekit_convert_number_to_numeric_string($widget_column_mobile);
        $item_title_position = isset( $settings['title_position'] ) ? $settings['title_position']: 'after';
        $elementClass .= esc_attr( " label-position--" . $item_title_position );
        $prefix_title_position = isset( $settings['prefix_title_position'] ) ? $settings['prefix_title_position']: 'after';
        $elementClass .= esc_attr( " prefix-position--" . $prefix_title_position );
        $elementClass .= ' social-hover-effect--' . $settings['card_hover_effects_dropdown'];
        $elementClass .= ( $settings['show_social_share_on_click'] == 'yes' ) ? ' social-share--on' : ' social-share--off';
        $elementClass .= ( $settings['show_official_color'] ) ? ' official-color--on' : ' official-color--off';
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        $link_target = isset( $settings['open_link_in_same_tab'] ) ? $settings['open_link_in_same_tab'] : '_self';
        $postUrl = 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) . sanitize_url(wp_unslash($_SERVER['REQUEST_URI'] ));
        $social_share_url_args = nekit_get_social_share_url_options_array();
        $social_share_url_args_key = array_keys( $social_share_url_args );
        ?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
                <?php if( $settings['show_prefix'] == 'yes' ) :?>
                    <div class="social-share-prefix">
                        <?php 
                            $prefix_text = ( isset( $settings['show_prefix_text'] ) && $settings['show_prefix_text'] == 'yes' ) ? '<h2 class="prefix-text">' . $settings['prefix_text'] . '</h2>' : '';
                            if( $prefix_text && $prefix_title_position == 'before' ) echo wp_kses_post( $prefix_text );
                            if( nekit_get_base_value( [ 'icon' => $settings['prefix_icon'] ] ) ) echo '<span class="prefix-icon">' .wp_kses_post(nekit_get_base_value( [ 'icon' => $settings['prefix_icon'] ] )). '</span>';
                            if( $prefix_text && $prefix_title_position == 'after' ) echo wp_kses_post( $prefix_text );
                        ?>
                    </div>
                <?php endif; ?>
                <ul class="social-share-wrap">
                    <?php
                        foreach( $settings['social_share_repeater'] as $social_share ) :
                            $social_share_title = ( $settings['show_title'] == 'yes' ) ? '<span class="social-share-title">' . esc_html( $social_share['social_share_title'] ) . '</span>' : '';
                            if( in_array( $social_share['social_share_link_to'], $social_share_url_args_key ) ) :
                                $social_share_url = ( $social_share['social_share_link_to'] != 'copy_link' ) ? $social_share_url_args[ $social_share['social_share_link_to'] ] . $postUrl : $postUrl;
                                ?>
                                    <li class="social-share<?php echo esc_attr(  ' elementor-repeater-item-' . $social_share['_id'] ); echo esc_attr( ' '.$social_share['social_share_link_to'] );?>">
                                        <a href="<?php echo esc_attr( $social_share_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" title="<?php echo esc_attr( $social_share['social_share_title'] )?>">
                                            <?php 
                                                if( $settings['title_position'] == 'before' ) echo wp_kses_post($social_share_title);

                                                if( nekit_get_base_value( ['icon'  =>  $social_share['social_share_icon'] ] ) ) echo '<span class="social-share-icon">' .wp_kses_post(nekit_get_base_value( ['icon'  =>  $social_share['social_share_icon'] ] )). '</span>' ;

                                                if( $settings['title_position'] == 'after' ) echo wp_kses_post($social_share_title);
                                            ?>
                                        </a>
                                    </li>
                                <?php
                            endif;
                        endforeach;
                    ?>
                </ul>
            </div>
        <?php
    }
 }