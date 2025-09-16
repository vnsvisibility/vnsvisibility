<?php 
/**
 * Theme mode Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Theme_Mode_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
        $this->start_controls_section(
            'theme_mode_general_section',
            [
                'label'=>esc_html__('General','news-kit-elementor-addons'),
                'tab'=>\Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/theme-mode" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_responsive_control(
            'theme_mode_alignment',
            [
                'label' => esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'default'   => 'left',
                'toggle'    => false,
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'theme_mode_orientation',
            [
                'label' => esc_html__('Item Orientation','news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'default'   => 'horizontal',
                'options'   => [
                    'horizontal'    => [
                        'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-navigation-horizontal'
                    ],
                    'vertical'  => [
                        'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-navigation-vertical'
                    ]
                ],
                'toggle'    => false,
            ]
        );

        $this->add_control(
            'theme_mode_position',
            [
                'label' => esc_html__( 'Position', 'news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'default'   => 'initial',
                'options'   => [
                    'initial'   => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                    'fixed'     => esc_html__( 'Fixed', 'news-kit-elementor-addons' )
                ]
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
					'right'	=>	[
						'title'	=>	esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-h-align-right'
					]
				],
                'condition'	=>	[
                    'theme_mode_position'	=>	'fixed'
				],
				'default'	=>	'left',
				'toggle'	=>	false
			]
		);

        $this->add_responsive_control(
			'distance_left',
			[
				'label'	=>	esc_html__( 'Distance Left', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	5
					]
				],
				'default'	=> 	[
					'unit'	=>	'px',
					'size'	=>	40
				],
                'condition'	 =>	[
					'fixed_position'	=>	'left',
                    'theme_mode_position'	=>	'fixed'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-theme-mode-position--fixed.nekit-theme-mode'	=>	'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'distance_right',
			[
				'label'	=>	esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	5
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	350
				],
                'condition'	=>	[
					'fixed_position'	=>	'right',
                    'theme_mode_position'   =>	'fixed'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-theme-mode-position--fixed.nekit-theme-mode' => 'right: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'distance_bottom',
			[
				'label'	=>	esc_html__( 'Distance Bottom', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	5
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	350
				],
                'condition'	=>	[
                    'theme_mode_position'	=>	'fixed'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-theme-mode-position--fixed.nekit-theme-mode'	=>	'bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'theme_mode_light_icon_section',
            [
                'label' => esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'light_icon_heading',
            [
                'label' => esc_html__( 'Light Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'theme_mode_show_light_icon',
            [
                'label'=>esc_html__('Show Icon','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::SWITCHER,
                'label_on'=>esc_html__('Show','news-kit-elementor-addons'),
                'label_off'=>esc_html__('Hide','news-kit-elementor-addons'),
                'return_value'=>'yes',
                'default'=>'yes'
            ]
        );

        $this->add_control(
            'theme_mode_light_icon',
            [
                'label' => esc_html__('Choose Icon','news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'label_block'  => false,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid'  => ['sun','lightbulb'],
                    'fa-regular'  => ['sun','lightbulb']
                ],
                'default'   => [
                    'value' => 'far fa-sun',
                    'library'   => 'fa-regular'
                ]
            ]
        );

        $this->add_control(
            'icon_section_divider',
            [
                'type'=>\Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'theme_mode_dark_icon_section',
            [
                'label'=>esc_html__('Dark Icon','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'theme_mode_show_dark_icon',
            [
                'label'=>esc_html__('Show Icon','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::SWITCHER,
                'label_on'=>esc_html__('Show','news-kit-elementor-addons'),
                'label_off'=>esc_html__('Hide','news-kit-elementor-addons'),
                'return_value'=>'yes',
                'default'=>'yes'
            ]
        );

        $this->add_control(
            'theme_mode_dark_icon',
            [
                'label' => esc_html__('Choose Icon','news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'label_block'   => false,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid'  => ['moon','lightbulb'],
                    'fa-regular'  => ['moon','lightbulb']
                ],
                'default'   => [
                    'value' => 'far fa-moon',
                    'library'   => 'fa-regular'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_responsive_control(
            'theme_mode_light_icon_font_size',
            [
                'label'=>esc_html__('Icon Size','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::SLIDER,
                'range'=>[
                    'px'=>[
                        'min'=>8,
                        'max'=>20,
                        'step'=>1
                    ]
                ],
                'default'=>[
                    'unit'=>'px',
                    'size'=>12
                ],
                'selectors'=>[
                    '{{WRAPPER}} .theme-mode-dark-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .theme-mode-light-icon' => 'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'theme_mode_light_title_section',
            [
                'label'=>esc_html__('Title','news-kit-elementor-addons'),
                'tab'=>\Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'light_and_dark_title',
            [
                'label' => esc_html__( 'Position', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'default'   => 'after',
                'options'   => [
                    'before'    => esc_html__( 'Before', 'news-kit-elementor-addons' ),
                    'after' => esc_html__( 'After', 'news-kit-elementor-addons' ),
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'theme_mode_title_heading',
            [
                'label' => esc_html__( 'Light Title', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'theme_mode_light_title_text',
            [
                'label'=>esc_html__('Header','news-kit-elementor-addons'), 
                'label_block'=>true,
                'type'=>\Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'theme_mode_title_divider',
            [
                'type'=>\Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'theme_mode_dark_title_section',
            [
                'label'=>esc_html__('Dark Title','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'theme_mode_dark_title_text',
            [
                'label'=>esc_html__('Header','news-kit-elementor-addons'), 
                'label_block'=>true,
                'type'=>\Elementor\Controls_Manager::TEXT
            ]

        );
        $this->end_controls_section();

        $this->start_controls_section(
            'general_styles_section',
            [
                'label' =>  esc_html__('General','news-kit-elementor-addons'),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'theme_mode_light_show_bg_color',
            [
                'label'         =>  esc_html__('Show Light Background color','news-kit-elementor-addons'),
                'type'          =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'      =>  esc_html__('Show','news-kit-elementor-addons'),
                'label_off'     =>   esc_html__('Hide','news-kit-elementor-addons'),
                'return_value'  =>    'yes',
                'default'       =>  'no'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' 		=> esc_html__( 'theme_mode_light_background_color', 'news-kit-elementor-addons' ),
                'types'  =>  ['classic', 'gradient'],
                'selector' 	=> '{{WRAPPER}} .nekit-theme-mode.light-mode--on',
                'condition' =>  [
                    'theme_mode_light_show_bg_color'  =>  'yes'
                ]
            ]
        );
        
        $this->add_control(
            'theme_mode_dark_show_bg_color',
            [
                'label'         =>  esc_html__('Show Dark Background color','news-kit-elementor-addons'),
                'type'          =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'      =>  esc_html__('Show','news-kit-elementor-addons'),
                'label_off'     =>  esc_html__('Hide','news-kit-elementor-addons'),
                'return_value'  =>  'yes',
                'default'       =>  'no'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' 		=> 'theme_mode_dark_background_color',
                'types'  =>  ['classic', 'gradient'],
                'selector' 	=> '{{WRAPPER}} .nekit-theme-mode.dark-mode--on',
                'condition'=>[
                    'theme_mode_dark_show_bg_color'  =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'theme_mode_padding',
            [
                'label' => esc_html__('Padding','news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em', 'custom' ],
                'default'   => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   =>'px',
                    'isLinked' => true
                ],
                'selectors'=>[
                    '{{WRAPPER}} .nekit-theme-mode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'theme_mode_margin',
            [
                'label'=>esc_html__('Margin','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::DIMENSIONS,
                'size_units'=>[ 'px', '%', 'em', 'custom' ],
                'default'=>[
                    'top'=>0,
                    'right'=>0,
                    'bottom'=>0,
                    'left'=>0,
                    'unit'=>'px',
                    'isLinked'=>true
                ],
                'selectors'=>[
                    '{{WRAPPER}} .theme-mode-light-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'widget_styles_divider_one',
            [
                'type'  =>  \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->start_controls_tabs(
            'widget_styles_tab'
        );
            $this->start_controls_tab(
                'widget_styles_lights_tabs',
                [
                    'label' =>  esc_html__( 'Light','news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'widget_styles_light_box_shadow_heading',
                [
                    'label' =>  esc_html__( 'Box Shadow','news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::HEADING
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'widget_light_box_shadow',
                    'selector' => '{{WRAPPER}} .nekit-theme-mode'
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'widget_styles_border_radius',
            [
                'label'     =>  esc_html__( 'Border Radius','news-kit-elementor-addons' ),
                'type'      =>  \Elementor\Controls_Manager::NUMBER,
                'min'       =>  0,
                'max'       =>  500,
                'step'      => 1,
                'default'   => 35,
                'selectors'  =>  [
                    '{{WRAPPER}} .nekit-theme-mode'  => 'border-radius: {{VALUE}}px;'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_light_icon_section',
            [
                'label' =>  esc_html__('Icon','news-kit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'styles_light_icon_heading',
            [
                'label' =>  esc_html__('Light Icon','news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'styles_light_icon_color',
            [
                'label'     =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'      =>  \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .theme-mode-light-icon i' => 'color: {{VALUE}}!important;'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' 		=> 'styles_light_icon_bg_color',
                'types'  =>  ['classic', 'gradient'],
                'exclude'   => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#fff'
                    ]
                ],
                'selector' 	=> '{{WRAPPER}} .theme-mode-light-icon'
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'styles_dark_icon_section',
            [
                'label' =>  esc_html__('Dark Icon','news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'styles_dark_icon_color',
            [
                'label'     =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'      =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#ffffff',
                'selectors' =>  [
                    '{{WRAPPER}} .theme-mode-dark-icon i' => 'color: {{VALUE}}!important;'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' 		=> 'styles_dark_icon_bg_color',
                'types'  =>  ['classic', 'gradient'],
                'exclude'   => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#000000'
                    ]
                ],
                'selector' 	=> '{{WRAPPER}} .theme-mode-dark-icon'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_light_title_section',
            [
                'label' => esc_html__( 'Title', 'news-kit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE   
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'selectors' =>  [
                    '{{WRAPPER}} .theme-mode-title',
                    '{{WRAPPER}} .theme-mode-dark-title'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'styles_light_title_heading',
            [
                'label'=>esc_html__('Light Title','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'styles_light_title',
            [
                'label'=>esc_html__( 'Text Color','news-kit-elementor-addons'),
                'type'=>\Elementor\Controls_Manager::COLOR,
                'default'=>'#000000',
                'selectors'=>[
                    '{{WRAPPER}} .theme-mode-light-section .theme-mode-title' => 'color: {{VALUE}}!important;'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'styles_dark_title_section',
            [
                'label' => esc_html__( 'Dark Title', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::HEADING
            ]
        );
        $this->add_control(
            'styles_dark_title',
            [
                'label'     =>  esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                'type'      =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000',
                'selectors' => [
                    '{{WRAPPER}} .theme-mode-dark-section .theme-mode-title' => 'color: {{VALUE}}!important;'
                ]
            ]
        );
        $this->end_controls_section();
    }
 }