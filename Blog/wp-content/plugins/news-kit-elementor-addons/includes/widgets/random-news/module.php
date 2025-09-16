<?php
/**
 * Random News Module 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Random_News_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/random-news" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
			'widget_link_target',
			[
				'label' => esc_html__( 'Open Random News Link On', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block'	=> true,
                'default'   => '_blank',
				'options' => [
                    '_blank'  => esc_html__( 'New Tab', 'news-kit-elementor-addons' ),
                    '_self'  => esc_html__( 'Same Tab', 'news-kit-elementor-addons' )
                ]
			]
		);

		$this->add_control(
			'items_orientation',
			[
				'label' => esc_html__( 'Items Orientation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal',
					],
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-vertical',
					]
				],
				'default' => 'horizontal',
				'toggle' => false
			]
		);
		
        $this->add_control(
			'widget_position',
			[
				'label' => esc_html__( 'Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'initial',
				'options' => [
                    'initial'  => esc_html__( 'Inline', 'news-kit-elementor-addons' ),
                    'fixed'  => esc_html__( 'Fixed', 'news-kit-elementor-addons' )
                ],
                'selectors' => [
					'{{WRAPPER}} .random-news-wrap' => 'position: {{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'elements_align',
			[
				'label' => esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .news-elementor-random-news' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_distance',
			[
				'label' => esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .news-elementor-random-news.widget-orientation--horizontal.label-position--after .random-news-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .news-elementor-random-news.widget-orientation--horizontal.label-position--before .random-news-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .news-elementor-random-news.widget-orientation--vertical.label-position--after .random-news-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .news-elementor-random-news.widget-orientation--vertical.label-position--before .random-news-icon' => 'margin-top: {{SIZE}}{{UNIT}};'
				],
			]
		);
        $this->add_control(
			'divider_one',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
			'fixed_position',
			[
				'label' => esc_html__( 'Fixed Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
                'condition' => [
                    'widget_position'   => 'fixed'
				],
				'default' => 'left',
				'toggle' => false
			]
		);

        $this->add_responsive_control(
			'distance_left',
			[
				'label' => esc_html__( 'Distance Left', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
                'condition' => [
					'fixed_position' => 'left',
                    'widget_position'   => 'fixed'
				],
				'selectors' => [
					'{{WRAPPER}} .news-elementor-random-news' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'distance_right',
			[
				'label' => esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
                'condition' => [
					'fixed_position' => 'right',
                    'widget_position'   => 'fixed'
				],
				'selectors' => [
					'{{WRAPPER}} .news-elementor-random-news' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'distance_bottom',
			[
				'label' => esc_html__( 'Distance Bottom', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
                'condition' => [
                    'widget_position'   => 'fixed'
				],
				'selectors' => [
					'{{WRAPPER}} .news-elementor-random-news' => 'bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_control(
			'divider_two',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
			'random_news_icon_option',
			[
				'label' => esc_html__( 'Show random news icon', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'random_news_icon',
			[
				'label' => esc_html__( 'Random News Icon', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'	=> [
					'fa-solid'	=> ['random','registered','newspaper'],
					'fa-regular'	=> ['newspaper']
				],
				'default' => [
					'value' => 'fas fa-random',
					'library' => 'fa-solid',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'random_news_title_section',
			[
				'label' => esc_html__( 'Random News Title', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'random_news_title_option',
			[
				'label' => esc_html__( 'Show random news title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

        $this->add_control(
			'random_news_title',
			[
				'label' => esc_html__( 'Random News Title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Random News', 'news-kit-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your title here', 'news-kit-elementor-addons' ),
				'condition' => [
					'random_news_title_option' => 'yes',
				]
			]
		);

        $this->add_control(
			'random_news_title_position',
			[
				'label' => esc_html__( 'Random News Title Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'after',
				'options' => [
                    'after'  => esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'  => esc_html__( 'Before', 'news-kit-elementor-addons' )
                ]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'hover_animation_tab',
			[
				'label' => esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'widget_hover_animation',
				[
					'label' => esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				]
			);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'general_styles_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->start_controls_tabs(
				'widget_style_tabs'
			);
				$this->start_controls_tab(
					'widget_initial_style_tab',
					[
						'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' 		=> esc_html__( 'background_color', 'news-kit-elementor-addons' ),
						'types'		=> ['classic','gradient'],
						'exclude'   => ['image'],
						'selector' 	=> '{{WRAPPER}} .news-elementor-random-news',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'widget_box_shadow',
						'selector' => '{{WRAPPER}} .news-elementor-random-news.random-news-wrap'
					]
				);

				$this->add_control(
					'border_radius',
					[
						'label' => esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 500,
						'step' => 1,
						'selectors' => [
							'{{WRAPPER}} .news-elementor-random-news' => 'border-radius: {{VALUE}}px',
						]
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'widget_hover_style_tab',
					[
						'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' 		=> esc_html__( 'background_hover_color', 'news-kit-elementor-addons' ),
						'types'		=> ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .news-elementor-random-news:hover',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'widget_hover_box_shadow',
						'selector' => '{{WRAPPER}} .news-elementor-random-news:hover'
					]
				);

				$this->add_control(
					'hover_border_radius',
					[
						'label' => esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 500,
						'step' => 1,
						'selectors' => [
							'{{WRAPPER}} .news-elementor-random-news:hover' => 'border-radius: {{VALUE}}px',
						]
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'divider_style_two',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'widget_border',
					'selector' => '{{WRAPPER}} .news-elementor-random-news',
				]
			);

			$this->add_responsive_control(
				'widget_padding',
				[
					'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default' => [ 
						'top'   => '0',
						'right' => '0',
						'bottom'=> '0',
						'left'  => '0',
						'unit'  => 'px',
						'isLinked ' => true
					],
					'selectors' => [
						'{{WRAPPER}} .news-elementor-random-news' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'widget_margin',
				[
					'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default' => [ 
						'top'   => '0',
						'right' => '0',
						'bottom'=> '0',
						'left'  => '0',
						'unit'  => 'px',
						'isLinked ' => true
					],
					'selectors' => [
						'{{WRAPPER}} .news-elementor-random-news' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'widget_random_news_icon_style_section',
			[
				'label' => esc_html__( 'Random News Icon', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'random_news_icon_color',
				[
					'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .random-news-icon' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'random_news_icon_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .random-news-wrap:hover .random-news-icon' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 14,
					],
					'selectors' => [
						'{{WRAPPER}} .random-news-icon' => 'font-size: {{SIZE}}{{UNIT}};'
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'widget_random_news_title_style_section',
			[
				'label' => esc_html__( 'Random News Title', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'random_news_title_typography',
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
					'selector' => '{{WRAPPER}} .random-news-title',
				]
			);

			$this->add_control(
				'random_news_title_color',
				[
					'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .random-news-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'random_news_title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .random-news-wrap:hover .random-news-title' => 'color: {{VALUE}}',
					]
				]
			);
		$this->end_controls_section();
	}
 }