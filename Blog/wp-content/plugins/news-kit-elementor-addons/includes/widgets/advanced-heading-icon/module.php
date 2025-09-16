<?php
/**
 * Advanced Heading Icon Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Advanced_Heading_Icon_Module extends \Nekit_Widget_Base\Base {
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/advanced-heading-icon" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
        
        $this->add_control(
            'widget_layouts',
            [
                'label' =>  esc_html__( 'Widget Layouts', 'news-kit-elementor-addons' ),
                'type'  =>  ( version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' ) ? \Elementor\Controls_Manager::VISUAL_CHOICE : 'nekit-radio-image-control' ),
                'default'   =>  'one',
                'label_block'   =>  true,
                'options'   =>  apply_filters( 'nekit_radio_image_control_options_filter', nekit_get_advanced_heading_layouts_array() ),
                'columns'   =>  2
            ]
        );
        $this->insert_divider();
        $this->get_item_orientation_control();
        $this->add_control(
            'heading_text',
            [
                'label' =>  esc_html__( 'Heading', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'placeholder'   =>  esc_html__( 'Add text here . .', 'news-kit-elementor-addons' ),
                'default'   =>  esc_html__( 'Recent News', 'news-kit-elementor-addons' ),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' =>  esc_html__( 'Html Tags', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'h2',
                'options'   =>  $this->get_html_tags()
            ]
        );
        $this->add_responsive_control(
            'alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left','news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center','news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right','news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap'  =>  'text-align:{{VALUE}}'
                ],
                'toggle'    =>  false
            ]
        );

        $this->add_control(
            'drop_cap',
            [
                'label' =>  esc_html__( 'Drop Cap', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'condition' => array_merge(apply_filters( 'nekit_pro_advanced_heading_drop_cap_condition_filter', [
                    'widget_layouts'    => 'pro'
                ]), [
                    'text_style'    => 'normal'
                ])
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_section',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => apply_filters( 'nekit_pro_advanced_heading_drop_cap_condition_filter', [
                    'widget_layouts'    => 'pro'
                ])
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' =>  esc_html__( 'Show Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );
        
        $this->add_control(
            'heading_icon',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  =>  'inline',
                'recommended' => [
                    'fa-solid'  => ['list','list-ul','list-alt','th-list','clipboard-list','stream','headphones','headset','newspaper','signature'],
                    'fa-regular'  => ['list-alt','newspaper']
                ],
                'default' => [
                    'value' => 'far fa-list-alt',
                    'library' => 'fa-regular'
                ],
                'description'   =>  esc_html__( 'The icon before the title', 'news-kit-elementor-addons' ),
                'separator' =>  'after',
                'exclude_inline_options'    =>  'svg'
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
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  20,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .heading-icon' =>  'font-size: {{SIZE}}{{UNIT}}'
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
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  12,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .items-orientation--horizontal.icon-position--before .heading-icon'    =>  'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .items-orientation--vertical.icon-position--before .heading-icon'  =>  'margin-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .items-orientation--horizontal.icon-position--after .heading-icon' =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .items-orientation--vertical.icon-position--after .heading-icon'   =>  'margin-top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'before',
				'options' => [
                    'after'  => esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'  => esc_html__( 'Before', 'news-kit-elementor-addons' )
                ]
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .heading-icon' =>  'color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'animation_section',
            [
                'label' =>  esc_html__( 'Animation Effects', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'text_style',
            [
                'label' =>  esc_html__( 'Style','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'normal',
                'options'   =>  nekit_get_advanced_heading_text_style_options_array()
            ]
        );

        $this->add_control(
            'animated',
            [
                'label' =>   esc_html__( 'Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'slide_up',
                'options'   =>  nekit_get_advanced_heading_animation_options_array(),
                'condition'  =>  [
                    'text_style'    =>  'animated'
                ]
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' =>  esc_html__( 'Shape', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'circle',
                'options'   =>  nekit_get_advanced_heading_animation_shape_options_array(),
                'condition'  =>  [
                    'text_style'    =>  'highlighted'
                ]
            ]
        );

        $this->add_control(
            'highlight_animation_duration',
            [
                'label' =>  esc_html__( 'Animation Duration', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  100,
                'step'  =>  1,
                'default'   =>  4,
                'selectors' =>  [
                    '{{WRAPPER}} .animation-style--highlighted svg path' =>  'animation-duration:{{VALUE}}s',
                    '{{WRAPPER}} .heading' =>  'animation-duration:{{VALUE}}s'
                ],
                'condition'  =>  [
                    'text_style'    =>  ['highlighted','animated']
                ]
            ]
        );

        $this->add_control(
            'highlight_animation_iteration_count',
            [
                'label' =>  esc_html__( 'Animation Iteration', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'infinite',
                'options'   =>  [
                    '1'  =>  esc_html__( 'Once', 'news-kit-elementor-addons' ),
                    'infinite'  =>  esc_html__( 'Infinite', 'news-kit-elementor-addons' )
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .animation-style--highlighted svg path'  =>  'animation-iteration-count: {{VALUE}}',
                    '{{WRAPPER}} .animation-style--animated .heading'  =>  'animation-iteration-count: {{VALUE}}'
                ],
                'condition' =>  [
                    'text_style'    =>  ['highlighted','animated']
                ]
            ]
        );

        $this->add_control(
            'highlight_animnation_stroke',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .animation-style--highlighted svg path'  =>  'stroke:{{VALUE}}'
                ],
                'condition' =>  [
                    'text_style'    =>  'highlighted'
                ]
            ]
        );

        $this->add_control(
            'highlight_animation_delay',
            [
                'label' =>  esc_html__( 'Animation Delay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  100,
                'step'  =>  0.1,
                'default'   =>  0.2,
                'selectors' =>  [
                    '{{WRAPPER}} .animation-style--highlighted svg path'  =>  'animation-delay:{{VALUE}}s',
                    '{{WRAPPER}} .animation-style--highlighted svg path:last-child'  =>  'animation-delay:calc( {{VALUE}}s + 0.6s)'
                ],
                'condition' =>  [
                    'text_style'    =>  ['highlighted','animated']
                ]
            ]
        );

        $this->add_responsive_control(
            'highlight_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .highlighted-wrap svg' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
                'condition' =>  [
                    'text_style'    =>  'highlighted'
                ]
            ]
        );

        $this->add_control(
            'text_curve',
            [
                'label' =>  esc_html__( 'Text Curve', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'curve_style_one',
                'options'   =>  [
                    'curve_style_one'   =>  esc_html__( 'Curve 1', 'news-kit-elementor-addons' ),
                    'curve_style_two'   =>  esc_html__( 'Wave 1', 'news-kit-elementor-addons' ),
                    'curve_style_three' =>  esc_html__( 'Curve 2', 'news-kit-elementor-addons' ),
                    'curve_style_four'  =>  esc_html__( 'Wave 2', 'news-kit-elementor-addons' ),
                ],
                'condition' =>  [
                    'text_style'   =>  'curve'
                ]
            ]
        );

        $this->add_control(
            'text_path_startoffset',
            [
                'label' =>  esc_html__( 'Starting Point', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    '%'    =>  [
                        'min'   => 0, 
                        'max'   => 100, 
                        'step'   => 1 
                    ]
                ],
                'default'   =>  [
                    'size' =>   50,
                    'unit'  =>  '%'
                ],
                'condition' =>  [
                    'text_style'   =>  'curve'
                ]
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
            'primary_color',
            [
                'label' =>  esc_html__( 'Primary Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .widget-layout--two .heading, {{WRAPPER}} .widget-layout--nine, {{WRAPPER}} .widget-layout--twelve .heading-inner-wrap:before, {{WRAPPER}} .widget-layout--twelve .heading-inner-wrap:after'  =>  'border-color: {{VALUE}}',
                    '{{WRAPPER}} .widget-layout--three .heading-inner-wrap .heading, {{WRAPPER}} .widget-layout--four .heading-inner-wrap:after, {{WRAPPER}} .widget-layout--five .heading, {{WRAPPER}} .widget-layout--six .heading-inner-wrap:after, {{WRAPPER}} .widget-layout--eight .heading-inner-wrap:after, {{WRAPPER}} .widget-layout--ten .heading, {{WRAPPER}} .widget-layout--eleven .heading:after, {{WRAPPER}} .widget-layout--eleven .heading:before, {{WRAPPER}} .widget-layout--thirteen .heading,
                    {{WRAPPER}} .widget-layout--fourteen .heading:before'  =>  'background: {{VALUE}}',
                    '{{WRAPPER}} .widget-layout--seven .heading:after'  =>  'background: linear-gradient(176deg,{{VALUE}},transparent)',
                    '{{WRAPPER}} .widget-layout--seven.alignment--center .heading:after'  =>  'background: linear-gradient(176deg,transparent,{{VALUE}},transparent)',
                    '{{WRAPPER}} .widget-layout--seven.alignment--right .heading:after'  =>  'background: linear-gradient(176deg,transparent,{{VALUE}})'
                ]
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' =>  esc_html__( 'Secondary Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .widget-layout--two, {{WRAPPER}} .widget-layout--three, {{WRAPPER}} .widget-layout--seven'  =>  'border-color: {{VALUE}}',
                    '{{WRAPPER}} .widget-layout--five'  =>  'background: {{VALUE}}',
                    '{{WRAPPER}} .widget-layout--thirteen .heading:after'  =>  'border-bottom-color: {{VALUE}}'
                ]
            ]
        );
        $this->insert_divider();

        $this->add_responsive_control(
            'widget_height',
            [
                'label' =>  esc_html__( 'Height', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  45,
                    'unit'  =>  'px'
                ],
                'condition'  =>  [
                    'text_style'    =>  'curve'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap.animation--curve_style_one' =>  'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' =>   'heading_text_shadow',
                'selector'  =>  '{{WRAPPER}} .heading, {{WRAPPER}} .animation-style--curve text',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();
        
        $this->add_responsive_control(
            'widget_styles_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  0,
                    'right'   =>  0,
                    'bottom'   =>  0,
                    'left'   =>  0,
                    'unit'   =>  'px',
                    'isLinked'   =>  true
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'widget_styles_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','%','em','custom' ],
                'default'   =>  [
                    'top'   =>  0,
                    'right'   =>  0,
                    'bottom'   =>  0,
                    'left'   =>  0,
                    'unit'   =>  'px',
                    'isLinked'   =>  true
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'heading_styles_section',
            [
                'label' =>  esc_html__( 'Heading','news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'heading_typography',
                'selector'  =>  '{{WRAPPER}} .heading, {{WRAPPER}} textpath, {{WRAPPER}} .animation--typing .typed-cursor, {{WRAPPER}} .animation-style--normal',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  20
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' =>  esc_html__( 'Heading Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap .heading, {{WRAPPER}} .animation--typing .typed-cursor'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} textpath'  =>  'fill: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'heading_background_color',
            [
                'label' =>  esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap span.heading'  =>  'background-color: {{VALUE}}',
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap svg'  =>  'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' =>   'heading_text_stroke',
                'selector'  =>  '{{WRAPPER}} .heading, {{WRAPPER}} textpath',
                'separator' =>  'before'
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'spacing_header',
            [
                'label' =>  esc_html__( 'Spacing', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap span.heading'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap svg'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap .heading'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .nekit-advanced-heading-icon-wrap svg'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'transform_one',
            [
                'label' =>  esc_html__( 'Transform', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'deg'   =>  [
                        'min'   =>  -100,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  0,
                    'unit'  =>  'deg'
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .heading, {{WRAPPER}} .animation-style--curve text'  =>  'transform: skewX({{SIZE}}{{UNIT}})'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'drop_cap_section',
            [
                'label' =>  esc_html__( 'Drop Cap', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array_merge(apply_filters( 'nekit_pro_advanced_heading_drop_cap_condition_filter', [
                    'widget_layouts'    => 'pro'
                ]), [
                    'text_style'    => 'normal'
                ])
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'drop_cap_typography',
                'selector'  =>  '{{WRAPPER}} .drop-cap'
            ]
        );

        $this->add_control(
            'drop_cap_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .drop-cap' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'drop_cap_background_color',
                'selector'  =>  '{{WRAPPER}} .drop-cap',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'  =>  'drop_cap_text_shadow',
                'selector'  =>  '{{WRAPPER}} .drop-cap'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'drop_cap_border',
                'selector'  =>  '{{WRAPPER}} .drop-cap'
            ]
        );

        $this->add_control(
            'drop_cap_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  0,
                    'unit'  =>  'px '
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .drop-cap' =>  'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'drop_cap_gap',
            [
                'label' =>  esc_html__( 'Gap', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  0,
                    'unit'  =>  'px '
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .drop-cap' =>  'margin-right: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
			'drop_cap_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'selectors'	=>	[
					'{{WRAPPER}} .drop-cap' =>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
        $this->end_controls_section();
    }

    public function text_curve( $args ) {
        $curve_paths = [
            'curve_style_one'   =>  ['M-0.000,37.000 C27.629,12.853 63.300,-0.138 100.000,1.000 C133.604,2.042 165.714,14.859 191.000,37.000'],
            'curve_style_two'   =>  ['M0.000,27.000 C21.045,7.509 41.200,-2.055 60.000,1.000 C90.812,6.007 99.585,41.981 131.000,49.000 C151.118,53.495 173.334,45.279 197.000,27.000'],
            'curve_style_three'   =>  ['M0.000,0.000 C26.962,18.873 59.089,29.000 92.000,29.000 C124.911,29.000 157.038,18.873 184.000,0.000'],
            'curve_style_four'   =>  ['M-0.000,23.000 C19.502,39.110 39.828,48.194 61.000,49.000 C113.784,51.011 140.177,0.302 194.000,-0.000 C216.165,-0.124 237.840,7.938 259.000,23.000']
        ]; ?>
        <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="500px" height="0.819in" viewBox="0 0 250 42.4994"
            class="styled-heading"
            fill="color">
            
            <?php foreach( $curve_paths[$args['text_curve']] as $curve_path ) : ?>
                    <path id="styled-heading" fill="transparent"
                        d="<?php echo esc_attr($curve_path); ?>">
                    </path>
            <?php endforeach; ?>

            <text>
                <textPath xlink:href="#styled-heading" text-anchor="middle" startOffset="<?php echo esc_attr( $args['text_path_startoffset'] . "%" ); ?>"><?php echo esc_html( $args['heading_text'] ); ?>
                </textPath>
            </text>
        </svg>

    <?php 
    }

    public function text_highlight( $args ) {
        $highlight_paths = [
                'circle'    =>  [ 'M350,12C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,15' ],
                'curly' =>  [ 'M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6' ],
                'underline' => [ 'M7.7,130.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,15' ],
                'double'    =>  [ 'M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2','M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8' ],
                'double_underline'  =>  [ 'M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6','M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4' ],
                'underline_zigzag'  =>  [ 'M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9' ],
                'cross_x' =>   [ 'M490.4,23.9C261.6,40,155.9,80.6,4,140','M14.1,27.6c254.5,20.3,393.8,74,467.3,111.7' ],
                'diagonal'  =>  [ 'M20.5,15.5c160,13.7,295.3,55.5,475,130' ],
                'linethrough'   =>  [ 'M6,75h493.5' ]
            ];
    ?>
        <span class="highlighted-wrap">
            <span class="heading" id="styled-heading"><?php echo esc_html( $args['heading_text'] ); ?></span>
            <svg 
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 500 150"
                preserveAspectRatio="none"
                class="<?php echo "animation-iteration--" .esc_attr($args['animation_iteration']); ?>">
                <?php foreach( $highlight_paths[ $args['shape'] ] as $highlight_path_key => $highlight_path ) : ?>
                        <path id="styled-heading" fill="transparent" d="<?php echo esc_attr( $highlight_path ); ?>">
                        </path>
                <?php endforeach; ?>
            </svg>
        </span>
    <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-advanced-heading-icon-wrap';
        $elementClass .= esc_attr(" widget-layout--" . $settings['widget_layouts']);
        $elementClass .= esc_attr(" items-orientation--" . $settings['items_orientation']);
        $elementClass .= esc_attr(" animation-style--" . $settings['text_style'] );
        $alignment = isset( $settings['alignment'] ) ? $settings['alignment']: 'left';
        $elementClass .= esc_attr(" alignment--" . $alignment );
        if( $settings['text_style'] == 'animated' ){
            $elementClass .= esc_attr(" animation--".$settings['animated']);
        }
        
        if( $settings['text_style'] == 'highlighted' ) {
            $elementClass .= esc_attr(" animation--".$settings['shape']);
        }
        if( $settings['text_style'] == 'curve' ) {
            $elementClass .= esc_attr(" animation--".$settings['text_curve']);
        }
        if( $settings['show_icon'] == 'yes' ) {
            $elementClass .= esc_attr(" icon-position--".$settings['icon_position']);
        }
        $wrapper_attributes = [
            'class' => esc_attr($elementClass),
            'id' => esc_attr( 'nekit-advanced-heading-icon-wrap--' . $this->get_id())
        ];
        if( $settings['text_style'] == 'animated' ) {
            if( $settings['animated'] == 'typing' ) {
                $wrapper_attributes['data-animation-iteration'] = ( isset( $settings['highlight_animation_iteration_count'] ) ? $settings['highlight_animation_iteration_count'] : 'infinite' );
                $wrapper_attributes['data-animation-duration'] = ( isset( $settings['highlight_animation_duration'] ) ? $settings['highlight_animation_duration'] : 4 );
                $wrapper_attributes['data-animation-delay'] = ( isset( $settings['highlight_animation_delay'] ) ? $settings['highlight_animation_delay'] : 0.2 );
            }
        }
        $this->add_render_attribute( 'wrapper', $wrapper_attributes );
    ?>

        <<?php echo esc_html($settings['html_tag']); ?> <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
            <span class="heading-inner-wrap">
                <?php
                    do_action( 'nekit_pro_advanced_heading_before', [
                        'option'    => ( $settings['show_icon'] == 'yes' ),
                        'position'  => $settings['icon_position'],
                        'icon' => $settings['heading_icon']
                    ]);
                    do_action( 'nekit_pro_advanced_heading_drop_cap_action', [
                        'option'    => ( $settings['drop_cap'] == 'yes' ),
                        'heading'    => $settings['heading_text']
                    ]);
                    // normal heading
                    if( $settings['text_style'] == 'normal' ) :
                        if( $settings['drop_cap'] != 'yes' ) :
                            echo '<span class="heading">' . esc_html( $settings['heading_text'] ). '</span>';
                        endif;
                    else:
                        // for curved text 
                        if( $settings['text_style'] == 'curve' ) :
                            $text_curve_args = [
                                'text_curve'    =>  $settings['text_curve'],
                                'heading_text'  =>  $settings['heading_text'],
                                'text_path_startoffset' =>  $settings['text_path_startoffset']['size'],
                            ];
                            $this->text_curve( $text_curve_args );

                        elseif( $settings['text_style'] == 'highlighted' ) :
                            $text_hightlight_args = [
                                'shape'  =>  $settings['shape'],
                                'heading_text'  =>  $settings['heading_text'],
                                'animation_iteration'   =>  ( isset( $settings['highlight_animation_iteration_count'] ) ? $settings['highlight_animation_iteration_count'] : 'infinite' )
                            ];
                            $this->text_highlight( $text_hightlight_args );
                        elseif( $settings['text_style'] == 'animated' ) :
                            if( $settings['animated'] == 'typing' ) echo '<span class="heading-read">' . esc_html( $settings['heading_text'] ). '</span>';
                            if( $settings['animated'] == 'typing' ) echo '<span class="animated-text"><h2 class="heading"></h2></span>';
                            if( $settings['animated'] != 'typing' ) echo '<span class="animated-text"><h2 class="heading">' . esc_html( $settings['heading_text'] ). '</h2></span>';
                        endif;
                    endif;

                    do_action( 'nekit_pro_advanced_heading_after', [
                        'option'    => ( $settings['show_icon'] == 'yes' ),
                        'position'  => $settings['icon_position'],
                        'icon' => $settings['heading_icon']
                    ]);
                ?>
            </span>
        </<?php echo esc_html($settings['html_tag']); ?>>
    <?php
    }
 }