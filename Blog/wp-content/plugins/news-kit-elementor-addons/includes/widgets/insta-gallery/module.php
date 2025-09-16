<?php
/**
 * Social Share Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Insta_Gallery_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls(){
        /* General */
        $this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

        $this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show Title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_responsive_control(
			'number_of_columns',
			[
				'label' => esc_html__( 'No. of columns', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 5
			]
		);

		$this->add_control(
			'stories',
			[
				'label' => esc_html__( 'Stories', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'story_title',
						'label' => esc_html__( 'Title', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => esc_html__( 'What is Lorem Ipsum?' , 'news-kit-elementor-addons' ),
						'label_block' => true,
					],
					[
						'name' => 'story_thumb',
						'label' => esc_html__( 'Thumbnail', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src()
                        ],
						'description'	=>	esc_html__( 'If not set first image from story gallery will be used instead.', 'news-kit-elementor-addons' )
					],
					[
						'name' => 'story_gallery',
						'label' => esc_html__( 'Story Gallery', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::GALLERY,
						'default' => []
					]
				],
				'default' => [
					[
						'story_title' => esc_html__( 'What is Lorem Ipsum?', 'news-kit-elementor-addons' )
					],
					[
						'story_title' => esc_html__( 'Why do we use it?', 'news-kit-elementor-addons' )
					],
					[
						'story_title' => esc_html__( 'Where does it come from?', 'news-kit-elementor-addons' )
					],
					[
						'story_title' => esc_html__( 'Where can I get some?', 'news-kit-elementor-addons' )
					],
					[
						'story_title' => esc_html__( 'Who do we get it from?', 'news-kit-elementor-addons' )
					],
				],
				'title_field' => '{{{ story_title }}}',
			]
		);

		$this->end_controls_section();

        /* Modal Settings */
        $this->start_controls_section(
			'modal_settings_section',
			[
				'label' => esc_html__( 'Modal Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'show_ambient',
			[
				'label' => esc_html__( 'Show Ambient', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
            'close_modal_icon',
            [
                'label' => esc_html__( 'Close Modal Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid' => [ 'window-close', 'times-circle', 'times' ],
                    'fa-regular' => [ 'window-close', 'times-circle' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-times',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_responsive_control(
			'close_modal_icon_size',
			[
				'label' => esc_html__( 'Close Modal Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	20
				],
				'selectors' => [
					'{{WRAPPER}} .close-modal' => 'font-size: {{SIZE}}{{UNIT}};'
				],
				'separator'	=>	'after'
			]
		);

		$this->add_control(
			'play_pause_icon_settings_heading',
			[
				'label' => esc_html__( 'Play / Pause Icon Settings', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'play_icon',
            [
                'label' => esc_html__( 'Play Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid'  => [ 'play', 'play-circle' ],
                    'fa-regular'  => [ 'play-circle' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-play',
                    'library'   => 'fa-solid'
				]
            ]
        );

		$this->add_control(
            'pause_icon',
            [
                'label' => esc_html__( 'Pause Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid'  => [ 'pause', 'pause-circle' ],
                    'fa-regular'  => [ 'pause-circle' ]
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-pause',
                    'library'   => 'fa-solid'
				]
            ]
        );

		$this->add_responsive_control(
			'play_pause_icon_size',
			[
				'label' => esc_html__( 'Play / Pause Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	20
				],
				'selectors' => [
					'{{WRAPPER}} .pause-story' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->end_controls_section();

		/* Parent Slider Settings */
		$this->start_controls_section(
			'parent_slider_settings_section',
			[
				'label' => esc_html__( 'Parent Slider Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'main_slides_speed', 
			[
				'label' => esc_html__( 'Speed', 'news-kit-elementor-addons' ),
				'description'   =>  esc_html__( 'Slide / Fade animation speed', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 10000,
				'step' => 1000,
				'default' => 1000
			]
		);

		$this->add_control(
			'main_slides_effect',
			[
				'label' => esc_html__( 'Effect', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'cube',
				'options' => [
					'fade'	=>	esc_html__( 'Fade', 'news-kit-elementor-addons' ),
					'coverflow'	=>	esc_html__( 'Coverflow', 'news-kit-elementor-addons' ),
					'flip'	=>	esc_html__( 'Flip', 'news-kit-elementor-addons' ),
					'cube'	=>	esc_html__( 'Cube', 'news-kit-elementor-addons' ),
					'cards'	=>	esc_html__( 'Cards', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
            'next_story_icon',
            [
                'label' => esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
					'fa-solid'  => [ 'angle-right', 'angle-double-right', 'caret-right', 'chevron-right', 'hand-point-right', 'arrow-right', 'arrow-circle-right', 'arrow-alt-circle-right' ],
					'fa-regular'  => [ 'hand-point-right','arrow-alt-circle-right' ]
				],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-step-forward',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_control(
            'prev_story_icon',
            [
                'label' => esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
					'fa-solid'  => [ 'angle-left', 'angle-double-left', 'caret-left', 'chevron-left', 'hand-point-left', 'arrow-left', 'arrow-circle-left', 'arrow-alt-circle-left' ],
					'fa-regular'  => [ 'hand-point-left', 'arrow-alt-circle-left' ]
				],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-step-backward',
                    'library'   => 'fa-solid'
				],
				'separator'	=>	'after'
            ]
        );

		$this->end_controls_section();

		/* Modal Slider Settings */
		$this->start_controls_section(
			'modal_slider_settings_section',
			[
				'label' => esc_html__( 'Child Slider Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'inner_slides_autoplay_speed', 
			[
				'label' => esc_html__( 'Autoplay Speed', 'news-kit-elementor-addons' ),
				'description'   =>  esc_html__( 'Autoplay speed in milliseconds', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 10000,
				'step' => 1000,
				'default' => 2000
			]
		);

		$this->add_control(
			'inner_slides_speed', 
			[
				'label' => esc_html__( 'Speed', 'news-kit-elementor-addons' ),
				'description'   =>  esc_html__( 'Slide / Fade animation speed', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 100,
				'default' => 300
			]
		);

		$this->add_control(
			'inner_slides_direction',
			[
				'label' => esc_html__( 'Direction', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'vertical'	=>	esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
					'horizontal'	=>	esc_html__( 'Horizontal', 'news-kit-elementor-addons' )
				],
				'description'	=>	esc_html__( 'When vertical is selected, effect will be disabled.' )
			]
		);

		$this->add_control(
			'inner_slides_effect',
			[
				'label' => esc_html__( 'Effect', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade'	=>	esc_html__( 'Fade', 'news-kit-elementor-addons' ),
					'coverflow'	=>	esc_html__( 'Coverflow', 'news-kit-elementor-addons' )
				],
				'condition'	=>	[
					'inner_slides_direction'	=>	'horizontal'
				]
			]
		);

		$this->add_control(
            'next_icon',
            [
                'label' => esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
					'fa-solid'  => [ 'angle-right', 'angle-double-right', 'caret-right', 'chevron-right', 'hand-point-right', 'arrow-right', 'arrow-circle-right', 'arrow-alt-circle-right' ],
					'fa-regular'  => [ 'hand-point-right','arrow-alt-circle-right' ]
				],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-chevron-right',
                    'library'   => 'fa-solid'
                ]
            ]
        );

		$this->add_control(
            'prev_icon',
            [
                'label' => esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
					'fa-solid'  => [ 'angle-left', 'angle-double-left', 'caret-left', 'chevron-left', 'hand-point-left', 'arrow-left', 'arrow-circle-left', 'arrow-alt-circle-left' ],
					'fa-regular'  => [ 'hand-point-left', 'arrow-alt-circle-left' ]
				],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-chevron-left',
                    'library'   => 'fa-solid'
				]
            ]
        );

		$this->end_controls_section();

		
		/* Modal Slider Settings */
		$this->start_controls_section(
			'image_settings_section',
			[
				'label' => esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'large',
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
					'{{WRAPPER}} .story-thumb:before' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'image_overlay',
                'fields_options'    =>  [
                    'background'    =>  [
                        'label' =>  esc_html__( 'Image Overlay', 'news-kit-elementor-addons' )
                    ]
                ],
                'exclude'   =>  [ 'image' ],
				'selector' => '{{WRAPPER}} .nekit-stories figure.story-thumb:after'
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'story_border',
				'selector' => '{{WRAPPER}} .stories .story-thumb img',
                'exclude'   =>  [ 'color' ],
				'fields_options'	=>	[
					'width'	=>	[
						'selectors' => [
							'{{SELECTOR}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				]
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'story_border_color',
                'fields_options'    =>  [
                    'background'    =>  [
                        'label' =>  esc_html__( 'Border Color', 'news-kit-elementor-addons' )
                    ]
                ],
                'exclude'   =>  [ 'image' ],
				'selector' => '{{WRAPPER}} .stories .story-thumb img',
                'condition' => [
					'story_border_border!' => [ '', 'none' ]
				]
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
                    '{{WRAPPER}} .nekit-stories figure.story-thumb, {{WRAPPER}} .nekit-stories figure.story-thumb img'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .nekit-stories figure.story-thumb'
            ]
        );

		$this->end_controls_section();

        /* Styles => General */
        $this->start_controls_section(
			'styles_general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
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
						'max' => 200,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	15
				],
				'selectors' => [
					'{{WRAPPER}} .stories' => 'row-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	15
				],
				'selectors' => [
					'{{WRAPPER}} .stories' => 'column-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->end_controls_section();
		
        /* Typography Section */
        $this->start_controls_section(
			'typography_section',
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .story-title',
				'fields_options'	=>	[
					'typography'	=>	[
						'default'	=>	'custom',
						'label'	=>	esc_html__( 'Title Typography', 'news-kit-elementor-addons' )
					],
					'font_size'	=>	[
						'default'	=>	[
							'size'	=>	18,
							'unit'	=>	'px'
						],
						'tablet_default'	=>	[
							'size'	=>	15,
							'unit'	=>	'px'
						],
						'mobile_default'	=>	[
							'size'	=>	12,
							'unit'	=>	'px'
						]
					],
					'font_family'	=>	[
						'default'	=>	'Jost'
					]
				]
			]
		);

		$this->add_control(
			'title_typography_toggle',
			[
				'label' => esc_html__( 'Title Settings', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'news-kit-elementor-addons' ),
				'label_on' => esc_html__( 'Custom', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->start_popover();

		$this->start_controls_tabs(
			'color_tabs'
		);

			$this->start_controls_tab(
				'colors_initial_tab',
				[
					'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'title_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .story-title' => 'color: {{VALUE}}'
						]
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'colors_hover_tab',
				[
					'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'title_hover_color',
					[
						'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .story-title:hover' => 'color: {{VALUE}}'
						]
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->insert_divider();

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'title_background_color',
				'selector' => '{{WRAPPER}} .story-title',
				'exclude'	=>	[ 'image' ]
			]
		);

		$this->add_responsive_control(
            'title_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .story-title'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
            'title_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .story-title'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_popover();

		$this->insert_divider();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .image-caption',
				'fields_options'	=>	[
					'typography'	=>	[
						'default'	=>	'custom',
						'label'	=>	esc_html__( 'Image Caption Typography', 'news-kit-elementor-addons' )
					],
					'font_size'	=>	[
						'default'	=>	[
							'size'	=>	16,
							'unit'	=>	'px'
						],
						'tablet_default'	=>	[
							'size'	=>	16,
							'unit'	=>	'px'
						],
						'mobile_default'	=>	[
							'size'	=>	16,
							'unit'	=>	'px'
						]
					],
					'font_family'	=>	[
						'default'	=>	'Jost'
					]
				],
				'separator'	=>	'before'
			]
		);

		$this->add_control(
			'caption_typography_toggle',
			[
				'label' => esc_html__( 'Image Caption Settings', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'news-kit-elementor-addons' ),
				'label_on' => esc_html__( 'Custom', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->start_popover();

		$this->start_controls_tabs(
			'caption_color_tabs'
		);

			$this->start_controls_tab(
				'caption_colors_initial_tab',
				[
					'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'caption_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .image-caption' => 'color: {{VALUE}}'
						]
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'caption_colors_hover_tab',
				[
					'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'caption_hover_color',
					[
						'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .image-caption-wrapper .image-caption:hover' => 'color: {{VALUE}}'
						]
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->insert_divider();

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'caption_background_color',
				'selector' => '{{WRAPPER}} .image-caption-wrapper .image-caption',
				'exclude'	=>	[ 'image' ]
			]
		);

		$this->add_responsive_control(
            'caption_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .image-caption-wrapper .image-caption'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
            'caption_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .image-caption-wrapper .image-caption'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_popover();

        $this->end_controls_section();

		/* Styles => Modal Settings Section */
        $this->start_controls_section(
			'styles_modal_settings_section',
			[
				'label' => esc_html__( 'Modal Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs(
			'modal_settings_tabs'
		);

			$this->start_controls_tab(
				'modal_settings_initial_tab',
				[
					'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'close_modal_icon_settings_heading_initial',
					[
						'label' => esc_html__( 'Close Modal', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'close_modal_icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .close-modal i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'close_modal_icon_background',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Icon Background', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ],
						'selector' =>	'{{WRAPPER}} .close-modal'
					]
				);

				$this->add_control(
					'play_pause_icons_settings_heading_initial',
					[
						'label' => esc_html__( 'Play / Pause Icons', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'play_pause_icons_color',
					[
						'label' => esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pause-story i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'play_pause_icons_background',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Icon Background', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ],
						'selector' =>	'{{WRAPPER}} .pause-story'
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'modal_settings_hover_tab',
				[
					'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'close_modal_icon_settings_heading_hover',
					[
						'label' => esc_html__( 'Close Modal', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'close_modal_icon_hover_color',
					[
						'label' => esc_html__( 'Hover Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .close-modal:hover i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'close_modal_icon_background_hover',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Icon Background Hover', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ],
						'selector'	=>	'{{WRAPPER}} .close-modal:hover'
					]
				);

				$this->add_control(
					'play_pause_icons_settings_heading_hover',
					[
						'label' => esc_html__( 'Play / Pause Icons', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'play_pause_icons_hover_color',
					[
						'label' => esc_html__( 'Icon Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pause-story:hover i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'play_pause_icons_background_hover',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Icon Background Hover', 'news-kit-elementor-addons' )
							]
						],
						'exclude'	=>	[ 'image' ],
						'selector' =>	'{{WRAPPER}} .pause-story:hover'
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->end_controls_section();

		/* Styles => Modal Slider Settings Section */
        $this->start_controls_section(
			'styles_modal_slider_settings_section',
			[
				'label' => esc_html__( 'Slider Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs(
			'modal_slider_settings_tabs'
		);

			$this->start_controls_tab(
				'modal_slider_settings_initial_tab',
				[
					'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'styles_slider_settings_initial_child_slider_heading',
					[
						'label' => esc_html__( 'Child Slider', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'next_and_prev_icon_color',
					[
						'label' => esc_html__( 'Next / Prev Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .inner-swiper-arrow i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'next_and_prev_icon_background',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Next / Prev Icon Background', 'news-kit-elementor-addons' )
							]
						],
						'selector' =>	'{{WRAPPER}} .inner-swiper-arrow'
					]
				);

				$this->add_control(
					'styles_slider_settings_initial_parent_slider_heading',
					[
						'label' => esc_html__( 'Parent Slider', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'story_next_and_prev_icon_color',
					[
						'label' => esc_html__( 'Next / Prev Icon Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-arrow i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'story_next_and_prev_icon_background',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Next / Prev Icon Background', 'news-kit-elementor-addons' )
							]
						],
						'selector' =>	'{{WRAPPER}} .swiper-arrow'
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'modal_slider_settings_hover_tab',
				[
					'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);

				$this->add_control(
					'styles_slider_settings_hover_child_slider_heading',
					[
						'label' => esc_html__( 'Child Slider', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'next_and_prev_icon_hover_color',
					[
						'label' => esc_html__( 'Next / Prev Icon Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .inner-swiper-arrow:hover i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'next_and_prev_icon_background_hover',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Next / Prev Icon Background Hover', 'news-kit-elementor-addons' )
							]
							],
						'selector'	=>	'{{WRAPPER}} .inner-swiper-arrow:hover'
					]
				);

				$this->add_control(
					'styles_slider_settings_hover_parent_slider_heading',
					[
						'label' => esc_html__( 'Parent Slider', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before'
					]
				);

				$this->add_control(
					'story_next_and_prev_icon_hover_color',
					[
						'label' => esc_html__( 'Next / Prev Icon Hover Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-arrow:hover i' => 'color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'	=>	'story_next_and_prev_icon_background_hover',
						'fields_options'	=>	[
							'background'	=>	[
								'label' => esc_html__( 'Next / Prev Icon Background Hover', 'news-kit-elementor-addons' )
							]
						],
						'selector' =>	'{{WRAPPER}} .swiper-arrow:hover'
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'nekit-stories';
        $stories = $settings[ 'stories' ];
        $number_of_columns = ( isset( $settings['number_of_columns'] ) ) ? $settings['number_of_columns']: 3;
		$number_of_columns_tablet = ( isset( $settings['number_of_columns_tablet'] ) ) ? $settings['number_of_columns_tablet']: 3;
		$number_of_columns_mobile = ( isset( $settings['number_of_columns_mobile'] ) ) ? $settings['number_of_columns_mobile']: 1;
        $elementClass .= ' column--' . $number_of_columns;
        $elementClass .= ' tablet-column--' . $number_of_columns_tablet;
        $elementClass .= ' smartphone-column--' . $number_of_columns_mobile;
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
                <div class="stories">
                    <?php
                        if( ! empty( $stories ) && is_array( $stories ) ) :
                            foreach( $stories as $story ) :
                                $story_title = $story[ 'story_title' ];
                                $has_story_thumb = empty( $story[ 'story_thumb' ][ 'url' ] );
                                $is_gallery_empty = empty( $story[ 'story_gallery' ][ 0 ][ 'url' ] );
								$story_gallery = array_key_exists( 'story_gallery', $story ) ? $story[ 'story_gallery' ] : [];
								$storyClass = 'story';
								if( empty( $story_gallery ) ) $storyClass .= ' no-gallery';
                                echo '<div class="', esc_attr( $storyClass ), '">';
                                    if( ! $has_story_thumb || ! $is_gallery_empty ) :
                                        echo '<figure class="story-thumb">';
											echo '<div class="story-thumbnail">';
												if( ! $has_story_thumb ) echo '<img src="'.  esc_url( $story[ 'story_thumb' ][ 'url' ] ) . '" loading="lazy">';
												if( ! $is_gallery_empty && $has_story_thumb ) echo '<img src="'.  esc_url( $story[ 'story_gallery' ][ 0 ][ 'url' ] ) . '" loading="lazy">';
											echo '</div>';
                                        echo '</figure>';
                                    endif;
                                    if( $settings[ 'show_title' ] ) echo '<h2 class="story-title">'. esc_html( $story_title ) .'</h2>';
                                echo '</div>';
                            endforeach;
                        endif;
                    ?>
                </div>
                <div class="stories-modal">
                    <div class="modal-content">
                        <div class="stories-slider">
                            <div class="swiper main-swiper">
                                <div class="swiper-wrapper">
                                    <?php
                                        if( ! empty( $stories ) && is_array( $stories ) ) :
                                            foreach( $stories as $inner_story ) :
                                                $gallery = array_key_exists( 'story_gallery', $inner_story ) ? $inner_story[ 'story_gallery' ] : [];
                                                if( ! empty( $gallery ) && is_array( $gallery ) ) :
                                                    ?>
                                                        <div class="swiper-slide">
                                                            <div class="swiper inner-swiper">
																<div class="button-wrapper">
																	<?php
																		if( nekit_get_base_value([ 'icon' => $settings[ 'close_modal_icon' ] ]) ) echo '<span class="close-modal">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'close_modal_icon' ] ]) ). '</span>';
																		if( nekit_get_base_value([ 'icon' => $settings[ 'pause_icon' ] ]) ) echo '<span class="pause-story playing">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'pause_icon' ] ]) ). '</span>';
																	?>
																</div>
                                                                <div class="swiper-wrapper">
                                                                    <?php
                                                                        foreach( $gallery as $media ) :
                                                                            ?>
                                                                                <figure class="swiper-slide">
                                                                                    <img src="<?php echo esc_attr( $media['url'] ); ?>" class="story-image" loading="lazy">
                                                                                    <span class="image-caption-wrapper">
																						<span class="image-caption">
																							<?php if( wp_get_attachment_caption( $media['id'] ) ) echo wp_get_attachment_caption( $media['id'] ); ?>
																						</span>
                                                                                    </span>
                                                                                </figure>
                                                                            <?php
                                                                        endforeach;
                                                                    ?>
                                                                </div>
                                                                <div class="swiper-pagination"></div>
                                                            </div>
															<?php
																if( nekit_get_base_value([ 'icon' => $settings[ 'prev_icon' ] ]) ) echo '<span class="inner-swiper-arrow prev">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'prev_icon' ] ]) ). '</span>';
																if( nekit_get_base_value([ 'icon' => $settings[ 'next_icon' ] ]) ) echo '<span class="inner-swiper-arrow next">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'next_icon' ] ]) ). '</span>';
															?>
                                                        </div>
                                                    <?php
                                                endif;
                                            endforeach;
                                        endif;
                                    ?>
                                </div>

								<?php
									if( nekit_get_base_value([ 'icon' => $settings[ 'prev_story_icon' ] ]) ) echo '<span class="swiper-arrow prev">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'prev_story_icon' ] ]) ). '</span>';
									if( nekit_get_base_value([ 'icon' => $settings[ 'next_story_icon' ] ]) ) echo '<span class="swiper-arrow next">' .wp_kses_post( nekit_get_base_value([ 'icon' => $settings[ 'next_story_icon' ] ]) ). '</span>';
								?>
                            </div>
                        </div>
                    </div>
					<?php if( $settings[ 'show_ambient' ] ) echo '<div class="ambient-wrapper"></div>'; ?>
                </div>
				<script>
					nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode([ 
						'main_swiper_settings'	=>	[
							'effect'	=>	$settings[ 'main_slides_effect' ],
							'speed'	=>	$settings[ 'main_slides_speed' ]
						],
						'inner_swiper_settings'	=>	[
							'effect'	=>	$settings[ 'inner_slides_effect' ],
							'direction'	=>	$settings[ 'inner_slides_direction' ],
							'speed'	=>	$settings[ 'inner_slides_speed' ],
							'autoplay_speed'	=>	$settings[ 'inner_slides_autoplay_speed' ]
						],
						'play_icon' => $settings[ 'play_icon' ],
						'pause_icon'	=>	$settings[ 'pause_icon' ] 
					]); ?>;
				</script>
			</div><!-- .nekit-stories -->
		<?php
	}
 }