<?php
/**
 * Tags Cloud Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 Class Tags_Cloud_Module extends \Nekit_Widget_Base\Base {
    public function get_spacing_control( $id = '', $label = '', $class = '', $css_property = '', $default = [0, 0, 0, 0] ) {
        $label_or_css_property = ( $css_property ) ? $css_property : strtolower( $label ) ;
        $this->add_responsive_control(
            $id,
            [
                'label'	=>	esc_html( $label ),
                'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'default'	=>	[
                	'top'	=>	$default[0],
                	'right'	=>	$default[1],
                	'bottom'	=>	$default[2],
                	'left'	=>	$default[3],
                	'unit'	=>	'px',
                	'isLinked'	=>	true
                ],
                'label_block'	=>	true,
                'selectors'	=>	[
                    '{{WRAPPER}} ' . $class =>	$label_or_css_property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'tag_section',
            [
                'label' =>  esc_html__( 'Tag', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/tag-cloud" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'number_of_tags',
            [
                'label' =>  esc_html__( 'Number of tags to show', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  5
            ]
        );

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
                    '{{WRAPPER}} .nekit-tags-cloud' =>  'text-align: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control(
            'open_in_new_tab',
            [
                'label' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Yes', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'No', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );

        $this->insert_divider();
            $this->add_control(
                'icon_section_heading',
                [
                    'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::HEADING
                ]
            );

            $this->add_control(
                'show_icon',
                [
                    'label' =>  esc_html__( 'Show Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                    'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                    'return_value'  =>  'yes',
                    'default' => 'yes'
                ]
            );

            $this->add_control(
                'tag_icon',
                [
                    'label' =>  esc_html__( 'Tag Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'label_block'  =>  false,
                    'skin'  =>  'inline',
                    'recommended'   => [
                        'fa-solid'  => ['hashtag','percentage','tags','tag','user-tag']
                    ],
                    'default'   =>  [
                        'library'   =>  'fa-solid',
                        'value' =>  'fas fa-hashtag'
                    ],
                    'exclude_inline_options' => ['svg'],
                    'condition' =>  [
                        'show_icon' =>  'yes'
                    ]
                ]
            );

            
            $this->add_control(
                'tag_icon_position',
                [
                    'label' =>  esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SELECT,
                    'default'   =>  'before',
                    'options'   =>  [
                        'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                        'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' )
                    ],
                    'separator' =>  'after'
                ]
            );

            $this->add_responsive_control(
                'icon_size',
                [
                    'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SLIDER,
                    'range' =>  [
                        'px'    =>  [
                            'min'   =>  0,
                            'max'   =>  1000,
                            'step'   =>  1
                        ]
                    ],
                    'default'   =>  [
                        'unit'  =>  'px',
                        'size'  =>  12
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .tag-icon' =>  'font-size: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_responsive_control(
                'icon_distance',
                [
                    'label' =>  esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SLIDER,
                    'range' =>  [
                        'px'    =>  [
                            'min'   =>   0,
                            'max'   =>  1000,
                            'step'  =>  1
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 3
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .icon-position--before .tag-icon'  =>  'margin-right: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .icon-position--after .tag-icon'   =>  'margin-left: {{SIZE}}{{UNIT}}'
                    ]
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
            'tab_styles_section',
            [
                'label' =>  esc_html__( 'Tag Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>   'tag_typography',
                'selector'  =>  '{{WRAPPER}} .post-tag',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'size'  =>  12,
                            'unit'  =>  'px'
                        ]
                    ],
                    'font_family' => [
                        'default' => 'Lexend'
                    ]
                ]
            ]
        );

            $this->start_controls_tabs(
                'tab_styles_tabs'
            );
                $this->start_controls_tab(
                    'tab_styles_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'tag_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#888',
                        'selectors' =>  [
                            '{{WRAPPER}} .post-tag-icon-wrap'   =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .post-tag-icon-wrap a' =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'tag_background',
                        'selector'  =>  '{{WRAPPER}} .post-tag-icon-wrap',
                        'fields_options' => [
                            'background' => [
                                'default' => 'classic'
                            ],
                            'color' => [
                                'default' => '#efefef'
                            ]
                        ],
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'tag_box_shadow',
                        'selector'  =>  '{{WRAPPER}} .post-tag-icon-wrap'
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'tab_styles_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'tag_hover_color',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .post-tag-icon-wrap:hover' =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .post-tag-icon-wrap:hover a'   =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'tag_background_hover',
                        'selector'  =>  '{{WRAPPER}} .post-tag-icon-wrap:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'tag_box_shadow_hover',
                        'selector'  =>  '{{WRAPPER}} .post-tag-icon-wrap:hover'
                    ]
                );
                $this->end_controls_tab();
            $this->end_controls_tabs();
        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'tab_border',
                'selector'  =>  '{{WRAPPER}} .post-tag-icon-wrap'
            ]
        );
        
        $this->add_control(
            'tag_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  500,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .post-tag-icon-wrap'   =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );
        
        $this->get_spacing_control( 'tab_styles_padding', 'Padding', '.post-tag-icon-wrap', 'padding', [ 0, 12, 4, 12 ] );

        $this->get_spacing_control( 'tab_styles_margin', 'Margin', '.post-tag-icon-wrap', 'margin', [ 0, 10, 6, 0 ] );

        $this->insert_divider();

        $this->add_control(
            'tags_context_heading',
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
                    '{{WRAPPER}} .tag-icon'   =>  'color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();
    }
 }