<?php
/**
 * Single Date Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Date extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-date';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-date';
    }

    public function get_keywords() {
        return ['sinlge', 'date', 'post-date'];
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-date" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'link_url',
            [
                'label' =>  esc_html__( 'Link Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );

        $this->get_open_in_new_tab_control( 'single_date_open_in_new_tab' );

        $this->add_control(
            'alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
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
                    '{{WRAPPER}} .nekit-single-date'    =>  'text-align: {{VALUE}}'
                ],
                'separator' =>  'after'
            ]
        );

        $this->add_control(
            'date_context',
            [
                'label' =>  esc_html__( 'Date Context', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'icon',
                'options'   =>  [
                    'icon'  =>  [
                        'title' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-calendar'
                    ],
                    'text'  =>  [
                        'title' =>  esc_html__( 'Text', 'news-kit-elementor-addons' ),
                        'icon' =>  'eicon-t-letter-bold'
                    ]
                ],
                'label_block'   =>  true,
                'toggle'    =>  false
            ]
        );

        $this->add_control(
            'date_icon',
            [
                'label' =>  esc_html__( 'Date Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'	=> [
					'fa-solid'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass'],
					'fa-regular'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass']
				],
                'exclude_inline_options'    =>  ['svg'],
                'default'   =>  [
                    'value' =>  'far fa-calendar',
                    'library'   =>  'fa-solid'
                ],
                'condition' =>  [
                    'date_context'  =>  'icon'
                ]
            ]
        );

        $this->add_control(
            'date_text',
            [
                'label' =>  esc_html__( 'Date Text', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Posted on', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'date_context'  =>  'text'
                ]
            ]
        );
        $this->insert_divider();

        $this->add_control(
            'icon_text_size',
            [
                'label' =>  esc_html__( 'Icon / Text Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-meta-wrap .published-date-context'   =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'icon_distance',
            [
                'label' =>  esc_html__( 'Icon / Text Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  6,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-published-date-suffix' =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .post-published-date-prefix' =>  'margin-right: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        $this->add_control(
            'icon_position',
            [
                'label' =>  esc_html__( 'Icon / Text Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'prefix',
                'options'   =>  [
                    'suffix'    =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'prefix'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' )
                ],
                'label_block'   =>  false
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'date_styles',
            [
                'label' =>  esc_html__( 'Date Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'date_typographpy',
                'selector' =>  '{{WRAPPER}} .post-published-date',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  15
                        ]
                    ]
                ]
            ]
        );
        
            $this->start_controls_tabs(
                'date_styles_tabs'
            );
                $this->start_controls_tab(
                    'date_style_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'date_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#8A8A8C',
                        'selectors' =>  [
                            '{{WRAPPER}} .date-meta-wrap'  =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .date-meta-wrap a'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
                
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'date_background',
                        'selector' =>  '{{WRAPPER}} .date-meta-wrap',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'date_box_shadow',
                        'selector' =>  '{{WRAPPER}} .date-meta-wrap',
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'date_style_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'date_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .date-meta-wrap:hover'  =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .date-meta-wrap:hover a'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
                
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'date_background_hover',
                        'selector' =>  '{{WRAPPER}} .date-meta-wrap:hover',
                        'exclude'   =>  ['image']
                    ]
                );
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'date_box_shadow_hover',
                        'selector' =>  '{{WRAPPER}} .date-meta-wrap:hover'
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->insert_divider();

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'date_border',
                    'selector' =>  '{{WRAPPER}} .date-meta-wrap'
                ]
            );

            $this->add_control(
                'date_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  1000,
                    'step'   =>  1,
                    'default'   =>  0,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap'   =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

            $this->get_spacing_control( 'date_padding', 'Padding', '.date-meta-wrap', 'padding' );

            $this->get_spacing_control( 'date_margin', 'Margin', '.date-meta-wrap', 'margin' );

            $this->insert_divider();

            $this->add_control(
                'single_date_context_heading',
                [
                    'label' =>  esc_html__( 'Context Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::HEADING
                ]
            );

            $this->add_control(
                'context_color',
                [
                    'label' =>  esc_html__( 'Context Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#8A8A8C',
                    'selectors' =>  [
                        '{{WRAPPER}} .published-date-context'   =>  'color: {{VALUE}}'
                    ]
                ]
            );

        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display(); ?>
            <div class="nekit-single-date">
                <?php
                    $date_args = [
                        'base'  =>  $settings['icon_position'],
                        'url'   =>  $settings['link_url'],
                        'target'   =>  $settings['single_date_open_in_new_tab']
                    ];
                    if( $settings['date_context'] == 'icon') $date_args['icon'] = $settings['date_icon'];
                    if( $settings['date_context'] == 'text') $date_args['text'] = $settings['date_text'];
                    echo wp_kses_post(nekit_get_posts_date( $date_args ));
                ?>
            </div>
    <?php
    }
 }