<?php
/**
 * Site Nav Mega Menu Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Site_Nav_Mega_Menu_Widget_Module extends \Nekit_Widget_Base\Base {
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/site-nav-mega-menu" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
			'nav_menu_display',
			[
				'label'	=> esc_html__( 'Select nav menu', 'news-kit-elementor-addons' ),
				'default' => 'none',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_nav_menus_options_array()
			]
		);

		$this->add_control(
			'menu_orientation',
			[
				'label' => esc_html__( 'Orientation', 'news-kit-elementor-addons' ),
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
					'{{WRAPPER}} .nekit-nav-mega-menu-container' => 'text-align: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'menu_items_section',
			[
				'label' => esc_html__( 'Menu Items', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'parent_sub_menu_dropdown_icon',
			[
				'label'	=> esc_html__( 'Menu Icon - on submenu closed', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up','angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up','hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'default' => [
					'value' => 'fas fa-chevron-down',
					'library' => 'fa-solid'
				]
			]
		);

		$this->add_control(
			'parent_sub_menu_upside_icon',
			[
				'label'	=> esc_html__( 'Menu Icon - on submenu opened', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up','angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up','hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'default' => [
					'value'	=> 'fas fa-chevron-up',
					'library' => 'fa-solid'
				]
			]
		);

		$this->add_control(
			'sub_menu_dropdown_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'after',
				'options' => [
                    'after'		=> esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'	=> esc_html__( 'Before', 'news-kit-elementor-addons' )
                ],
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'submenu_items_section',
			[
				'label' => esc_html__( 'Sub Menu Items', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

        $this->add_control(
			'sub_menu_dropdown_icon',
			[
				'label' => esc_html__( 'Menu Icon - on submenu closed', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up','angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up','hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid'
				]
			]
		);

		$this->add_control(
			'sub_menu_upside_icon',
			[
				'label' => esc_html__( 'Menu Icon - on submenu opened', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up','angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up','hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'default' => [
					'value' => 'fas fa-chevron-down',
					'library' => 'fa-solid'
				]
			]
		);

		$this->add_control(
            'icon_distance',
            [
                'label'	=> esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                'type'	=> \Elementor\Controls_Manager::SLIDER,
                'range'	=> [
                    'px'	=> [
                        'min'	=> 2,
                        'max'	=> 20,
                        'step'	=> 0
                    ]
                ],
                'default'	=> [
                    'unit'	=> 'px',
                    'size'	=> 6
                ],
                'selectors'	=> [
                    '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.icon-position--before li.nekit-has-sub-menu > a i.nekit-indicator-menu-icon' => 'margin-right: {{SIZE}}{{UNIT}};', 
                    '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.icon-position--after li.nekit-has-sub-menu > a i.nekit-indicator-menu-icon' => 'margin-left: {{SIZE}}{{UNIT}};',

                    '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.icon-position--before li.nekit-has-mega-menu > a i.nekit-indicator-menu-icon' => 'margin-right: {{SIZE}}{{UNIT}};', 
                    '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.icon-position--after li.nekit-has-mega-menu > a i.nekit-indicator-menu-icon' => 'margin-left: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'submenu_elements_align',
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
					'{{WRAPPER}} .nekit-nav-mega-menu-container ul.sub-menu li a' => 'text-align: {{VALUE}};'
				],
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);
		$this->insert_divider();
        $this->add_control(
			'sub_menu_item_transition',
			[
				'label' => esc_html__( 'Sub Menu Transition Duration', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 0.3,
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container ul.nekit-sub-menu' => 'animation-duration: {{VALUE}}s',
					'{{WRAPPER}} .nekit-nav-mega-menu-container ul.nekit-sub-menu' => '-webkit-animation-duration: {{VALUE}}s',
				],
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

        $this->add_control(
			'sub_menu_display_type',
			[
				'label' => esc_html__( 'Sub Menu Display', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'submenu-onmouse-hover',
				'options' => [
                    'submenu-onmouse-hover'		=> esc_html__( 'On Mouse Over', 'news-kit-elementor-addons' ),
                    'submenu-onmouse-click'	=> esc_html__( 'On Mouse Click', 'news-kit-elementor-addons' )
                ],
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'sub_menu_display_appear_direction',
			[
				'label' => esc_html__( 'Sub Menu Appear Direction', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'submenu-direction-top',
				'options' => apply_filters( 'nekit_sub_menu_item_display_appear_direction_options_filter', [
					'submenu-direction-none'		=> esc_html__( 'None', 'news-kit-elementor-addons' ),
                    'submenu-direction-top'		=> esc_html__( 'Top', 'news-kit-elementor-addons' ),
                    'submenu-direction-bottom'	=> esc_html__( 'Bottom', 'news-kit-elementor-addons' )
                ])
			]
		);
		$this->add_control(
			'sub_menu_display_appear_animation',
			[
				'label' => esc_html__( 'Sub Menu Appear Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'submenu-animation-fade',
				'options' => apply_filters( 'nekit_sub_menu_item_display_appear_animation_options_filter', [
					'submenu-animation-none'		=> esc_html__( 'None', 'news-kit-elementor-addons' ),
                    'submenu-animation-fade'		=> esc_html__( 'Fade', 'news-kit-elementor-addons' )
                ])
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_menu_section',
			[
				'label' => esc_html__( 'Mobile Menu / Off Canvas Menu', 'news-kit-elementor-addons' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mobile_menu_breakdown',
			[
				'label' => esc_html__( 'Mobile Menu Breakdown', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 1,
				'default' => 768,
			]
		);

		$this->add_control(
			'mobile_hamburger_style',
			[
				'label' => esc_html__( 'Hamburger Style', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'one',
				'options' => apply_filters( 'nekit_nav_menu_mobile_hamburger_style_options_array_filter', [
					'one'	=> esc_html__( 'Style One', 'news-kit-elementor-addons' )
				]),
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'mobile_hamburger_menu_animation_style',
			[
				'label' => esc_html__( 'Hamburger Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'hamburger-1',
				'options' => apply_filters( 'nekit_nav_menu_mobile_hamburger_menu_animation_style_options_array_filter', [
					'hamburger-0'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
					'hamburger-1'	=> esc_html__( 'Style One', 'news-kit-elementor-addons' ),
					'hamburger-2'	=> esc_html__( 'Style Two', 'news-kit-elementor-addons' )
				])
			]
		);

		$this->add_control(
			'mobile_hamburger_menu_type_text_open',
			[
				'label' => esc_html__( 'Open text', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'mobile_hamburger_menu_type_text_close',
			[
				'label' => esc_html__( 'Close text', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'burger_menu_align',
			[
				'label' => esc_html__( 'Burger Menu Align', 'news-kit-elementor-addons' ),
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
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .isResponsiveMenu' => 'text-align: {{VALUE}};'
				],
			]
		);
		$this->insert_divider();
		$this->add_control(
			'dropdown_settings_header',
			[
				'label' => esc_html__( 'Dropdown Settings', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);
		$this->insert_divider();

		$this->add_control(
			'dropdown_header_icon',
			[
				'label'	=> esc_html__( 'Header Icon', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-down','angle-up','angle-double-down','angle-double-up','caret-down','caret-up','chevron-down','chevron-up','hand-point-down','hand-point-up','arrow-down','arrow-up','arrow-circle-down','arrow-alt-circle-down','arrow-circle-up','arrow-alt-circle-up','angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-down','hand-point-up','arrow-alt-circle-down','arrow-alt-circle-up','hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'exclude_inline_options'	=> ['svg'],
				'default'	=> [
					'value'	=> 'fas fa-chevron-left',
					'library'	=> 'fa-solid'
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_header_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .current-responsive-active-menu-content .header i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_header_icon_distance',
			[
				'label' => esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .current-responsive-active-menu-content .header i' => 'margin-right: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->insert_divider();
		$this->add_control(
			'dropdown_menu_stretch',
			[
				'label' => esc_html__( 'Dropdown stretch', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'full-width',
				'options' => [
					'none'	=> esc_html__( 'Default', 'news-kit-elementor-addons' ),
					'full-width'	=> esc_html__( 'Canvas', 'news-kit-elementor-addons' ),
					'custom-width'	=> esc_html__( 'Custom Width', 'news-kit-elementor-addons' )
				]
			]
		);


		$this->add_responsive_control(
            'dropdown_menu_custom_width',
            [
                'label' =>  esc_html__( 'Dropdown width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'	=>	['px','%'],
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'	=> [
                    'unit'	=> '%',
                    'size'	=> 70
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' =>  'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .isResponsiveMenu.mobile-menu-dropdown-width--full-width nav.isShow.nekit-nav-mega-menu-container' =>  'width: {{SIZE}}{{UNIT}}'
				],
				'condition'	=> [
					'dropdown_menu_stretch'	=> ['custom-width','full-width']
				]

            ]
        );


		$this->add_control(
			'mobile_dropdown_menu_section_align',
			[
				'label' => esc_html__( 'Dropdown Section Align', 'news-kit-elementor-addons' ),
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
				'condition'	=> [
					'dropdown_menu_stretch'	=> ['custom-width','full-width']
				]
			]
		);

		$this->add_control(
			'mobile_dropdown_menu_align',
			[
				'label' => esc_html__( 'Dropdown Text Align', 'news-kit-elementor-addons' ),
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
				'selectors' => [
					'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'dropdown_menu_item_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 0.3,
				'selectors' => [
					'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' => '-webkit-animation-duration: {{VALUE}}s',
					'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' => 'animation-duration: {{VALUE}}s',
				],
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'dropdown_menu_appear_direction',
			[
				'label' => esc_html__( 'Dropdown Appear Direction', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'left',
				'options' => apply_filters( 'nekit_nav_menu_dropdown_menu_appear_direction_options_array_filter', [
					'none'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
					'left'	=> esc_html__( 'Left', 'news-kit-elementor-addons' ),
					'right'	=> esc_html__( 'Right', 'news-kit-elementor-addons' )
				])
			]
		);

		$this->add_control(
			'dropdown_menu_appear_animation',
			[
				'label' => esc_html__( 'Dropdown Appear Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'slide',
				'options' => [
					'none'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
					'fade'	=> esc_html__( 'Fade', 'news-kit-elementor-addons' ),
					'slide'	=> esc_html__( 'Slide', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'dropdown_menu_sub_menu_display_type',
			[
				'label' => esc_html__( 'Sub Menu Display Type', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'default',
				'options' => [
					'default'	=> esc_html__( 'Default', 'news-kit-elementor-addons' ),
					'cover'	=> esc_html__( 'Cover', 'news-kit-elementor-addons' )
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'menu_description_section',
			[
				'label' => esc_html__( 'Menu Description', 'news-kit-elementor-addons' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'show_menu_description',
			[
				'label'	=>	esc_html__( 'Show Menu Description', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'default'	=>	'yes',
				'return_value'	=>	'yes'
			]
		);

		$this->add_control(
			'menu_description_position',
			[
				'label' => esc_html__( 'Menu Description Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'menu-desc-absolute',
				'options' => [
					'menu-desc-absolute'	=> esc_html__( 'Absolute', 'news-kit-elementor-addons' ),
					'menu-desc-relative'	=> esc_html__( 'Relative', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'menu_description_motion_effect',
			[
				'label'	=> esc_html__( 'Motion Effect', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default'	=> 'none',
				'options'	=> [
					'none'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
					'fade-in-fade-out'	=> esc_html__( 'Fade In - Fade Out', 'news-kit-elementor-addons' ),
					'bounce'	=> esc_html__( 'Bounce', 'news-kit-elementor-addons' )
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'animation_settings_section',
			[
				'label' => esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_control(
			'menu_item_hover_effect',
			[
				'label' => esc_html__( 'Hover Effect', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'underline',
				'options' => apply_filters( 'nekit_menu_item_hover_effect_options_array_filter', [
                    'none'		=> esc_html__( 'None', 'news-kit-elementor-addons' ),
                    'underline'	=> esc_html__( 'Underline', 'news-kit-elementor-addons' )
                ])
			]
		);

		$this->add_control(
			'menu_item_hover_animate',
			[
				'label' => esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => 'animate-fade',
				'options' => apply_filters( 'nekit_menu_item_hover_animation_type_options_array_filter', [
                    'animate-none'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
                    'animate-fade'	=> esc_html__( 'Fade', 'news-kit-elementor-addons' )
                ])
			]
		);

		$this->add_control(
			'menu_item_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 0.3,
				'condition'	=> [
					'menu_item_hover_animate!'	=> 'animate-none'
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:before' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:after' => 'transition-duration: {{VALUE}}s',
				]
			]
		);
		$this->insert_divider();

		$this->add_control(
			'menu_animation_color_heading',
			[
				'label' => esc_html__( 'Menu Animation Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'      =>  'menu_animation_color',
				'types'      =>  ['classic','gradient'],
				'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li > a:before , {{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li > a:after',
				'exclude'   =>  ['image']
			]
		);
		
		$this->add_control(
			'menu_item_hover_effect_type_height',
			[
				'label' => esc_html__( 'Hover effect border height', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 2,
				'condition'	=> [
					'menu_item_hover_effect!'	=> 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:before' => 'height: {{VALUE}}px',
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:after' => 'height: {{VALUE}}px',
				]
			]
		);

		$this->add_control(
			'menu_item_hover_effect_type_width',
			[
				'label' => esc_html__( 'Hover effect border width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'condition'	=> [
					'menu_item_hover_effect'	=> ['underline','overline','doubleline','border'],
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li:hover > a:before' => 'width: {{VALUE}}px',
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li:hover > a:after' => 'width: {{VALUE}}px',
					'{{WRAPPER}} .nekit-pointer-animate-fade .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li > a:before' => 'width: {{VALUE}}px',
					'{{WRAPPER}} .nekit-pointer-animate-fade .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li > a:after' => 'width: {{VALUE}}px',
				]
			]
		);

		$this->add_control(
			'menu_item_hover_effect_type_vertical_gap',
			[
				'label' => esc_html__( 'Hover effect border vertical gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -20,
				'max' => 30,
				'step' => 1,
				'default' => -2,
				'condition'	=> [
					'menu_item_hover_effect'	=> ['underline','overline','doubleline','border'],
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:before' => 'top: {{VALUE}}px',
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li a:after' => 'bottom: {{VALUE}}px',
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'menu_section',
			[
				'label' => esc_html__( 'Menu Section', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'      =>  'menu_background_color',
				'types'      =>  ['classic','gradient'],
				'selector' 	=> '{{WRAPPER}} .news-elementor-nav-mega-menu'
			]
		);

		$this->insert_divider();
		$this->add_responsive_control(
			'menu_section_padding',
			[
				'label'	=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
				'selectors' => [
					'{{WRAPPER}} .news-elementor-nav-mega-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_section_margin',
			[
				'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .news-elementor-nav-mega-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'menu_section_border',
				'selector' => '{{WRAPPER}} .news-elementor-nav-mega-menu',
			]
		);

		$this->add_responsive_control(
            'menu_section_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .news-elementor-nav-mega-menu' =>  'border-radius: {{SIZE}}{{UNIT}}'
				]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'menu_section_box_shadow',
				'selector' => '{{WRAPPER}} .news-elementor-nav-mega-menu'
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'nav_menu_parent_item_typography_section',
			[
				'label' => esc_html__( 'Menu Items', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'nav_menu_parent_item_typography',
					'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a',
				]
			);
			$this->start_controls_tabs(
				'nav_menu_parent_item_style_tabs'
			);
				$this->start_controls_tab(
					'nav_menu_parent_item_style_initial_tab',
					[
						'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
					]
				);
					$this->add_control(
						'nav_menu_parent_item_color',
						[
							'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a' => 'color: {{VALUE}}'

							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name'      =>  'nav_menu_parent_item_background_color',
							'types'      =>  ['classic','gradient'],
							'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a',
							'exclude'	=> ['image']
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'nav_menu_parent_item_style_hover_tab',
					[
						'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
					]
				);
					$this->add_control(
						'nav_menu_parent_item_hover_color',
						[
							'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}  .nekit-nav-mega-menu-list-wrap > .menu-item > a:hover' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name'      =>  'nav_menu_parent_item_hover_background_color',
							'types'      =>  ['classic','gradient'],
							'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item:hover > a ',
							'exclude'	=> ['image']
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_responsive_control(
				'nav_menu_parent_item_padding',
				[
					'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default'=>[
							'top'    => 10,
							'right'  => 0,
							'bottom' => 10,
							'left'   => 0,
							'unit'   =>'px'
						],
					'selectors' => [
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap .menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'menu_item_horizontal_gap',
				[
					'label' =>  esc_html__( 'Horizontal Gap', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  -100,
							'max'   =>  100,
							'step'  =>  1
						]
					],
					'default'   =>  [
	                    'size'  =>  30,
	                    'unit'  =>  'px'
                	],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--horizontal > .menu-item:first-child > a' =>  'margin-left: 0',
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--horizontal > .menu-item:last-child > a' =>  'margin-right: 0',
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--horizontal > .menu-item > a' =>  'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 )'
					]
				]
			);

			$this->add_responsive_control(
				'menu_item_vertical_gap',
				[
					'label' =>  esc_html__( 'Vertical Gap', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  -100,
							'max'   =>  100,
							'step'  =>  1
						]
					],
					'default'   =>  [
	                    'size'  =>  0,
	                    'unit'  =>  'px'
                	],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--vertical > .menu-item:first-child > a' =>  'margin-top: 0',
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--vertical > .menu-item:last-child > a' =>  'margin-bottom: 0',
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap.orientation--vertical > .menu-item > a' =>  'margin-top: calc( {{SIZE}}{{UNIT}}/2 );margin-bottom: calc( {{SIZE}}{{UNIT}}/2 ); margin-left:0; margin-right:0;',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap > .menu-item:first-child > a' =>  'margin-top: 0;',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap > .menu-item:last-child > a' =>  'margin-bottom: 0',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap > .menu-item > a' =>  'margin-top: calc( {{SIZE}}{{UNIT}}/2 );margin-bottom: calc( {{SIZE}}{{UNIT}}/2 ); margin-left:0; margin-right:0;',
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'menu_item_border',
					'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a',
				]
			);

			$this->add_responsive_control(
				'menu_item_border_radius',
				[
					'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  1000,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a' =>  'border-radius: {{SIZE}}{{UNIT}}'
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'menu_item_box_shadow',
					'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap > .menu-item > a'
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'menu_active_section',
			[
				'label' => esc_html__( 'Active Menu', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs(
            'active_menu_style_tabs'
        );
            $this->start_controls_tab(
                'active_menu_style_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'menu_active_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.current_page_item > a' => 'color: {{VALUE}}',
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.current-menu-item > a' => 'color: {{VALUE}}'
						],
					]
				);
				
				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'menu_active_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a,
						{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current-menu-item > a',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
                'active_menu_style_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'menu_active_hover_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.current_page_item a:hover' => 'color: {{VALUE}}',
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.current-menu-item a:hover' => 'color: {{VALUE}}'
						],
					]
				);
				
				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'menu_active_hover_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a:hover',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_responsive_control(
				'menu_active_padding',
				[
					'label'	=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' => [
						'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'menu_active_margin',
				[
					'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} > .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'menu_active_border',
					'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a',
				]
			);

			$this->add_responsive_control(
				'menu_active_border_radius',
				[
					'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  1000,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.current_page_item > a' =>  'border-radius: {{SIZE}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'nav_submenu_section_typography_section',
			[
				'label' => esc_html__( 'Sub Menu Section', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'nav_submenu_section_padding',
			[
				'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);



		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'      =>  'nav_submenu_section_background',
				'types'      =>  ['classic','gradient'],
				'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu',
				'exclude'	=> ['image']
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nav_submenu_section_border',
				'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu',
			]
		);

		$this->add_responsive_control(
            'nav_submenu_section_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  50,
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu' =>  'border-radius: {{SIZE}}{{UNIT}}'
				]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submenu_section_box_shadow',
				'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu'
			]
		);

		$this->add_responsive_control(
            'nav_submenu_section_width',
            [
                'label' =>  esc_html__( 'Sub Menu Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  100,
                        'max'   =>  300,
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu' =>  'width: {{SIZE}}{{UNIT}}'
				]
            ]
        );

        $this->insert_divider();
			$this->add_responsive_control(
				'sub_menu_section_offset_top',
				[
					'label' =>  esc_html__( '1st Level Offset (Top)', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  150,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap.orientation--horizontal > .menu-item.nekit-has-sub-menu > a' =>  'margin-bottom: {{SIZE}}{{UNIT}};',
					]
				]
			);

			$this->add_responsive_control(
				'sub_menu_section_offset_left',
				[
					'label' =>  esc_html__( '1st Level Offset (Left)', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  150,
							'step'  =>  1
						]
					],
					'default'	=> [
	                    'unit'	=> 'px',
	                    'size'	=> 15
	                ],
					'selectors' =>  [
						'{{WRAPPER}} .nav-mega-menu-wrap:not(.isResponsiveMenu) .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > .menu-item > .nekit-sub-menu' =>  'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .nav-mega-menu-wrap:not(.isResponsiveMenu) .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .nekit-has-mega-menu .nekit-mega-menu-container.relative' =>  'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .nav-mega-menu-wrap:not(.isResponsiveMenu) .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > .menu-item:first-child > .nekit-sub-menu' =>  'margin-left: 0;',
						'{{WRAPPER}} .nav-mega-menu-wrap:not(.isResponsiveMenu) .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .nekit-has-mega-menu:first-child .nekit-mega-menu-container.relative' =>  'margin-left: 0;'
					]
				]
			);
			$this->insert_divider();
			$this->add_responsive_control(
				'sub_menu_section_offset_left_inner',
				[
					'label' =>  esc_html__( '2nd Level Offset (Left)', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  150,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > .menu-item > .nekit-sub-menu .nekit-sub-menu' =>  'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .nekit-has-mega-menu.appear-event--hover:hover .nekit-mega-menu-container' =>  'margin-left: {{SIZE}}{{UNIT}};'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'nav_submenu_item_typography_section',
			[
				'label' => esc_html__( 'Sub Menu Items', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name' => 'nav_submenu_item_typography',
				'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a',
			]
		);

		$this->start_controls_tabs(
            'nav_submenu_item_style_tabs'
        );
            $this->start_controls_tab(
                'nav_submenu_item_style_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'nav_submenu_item_color',
					[
						'label' => esc_html__( 'Color - ', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#000000',
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'nav_submenu_item_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
                'nav_submenu_item_style_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'nav_submenu_item_hover_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#000000',
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a:hover' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'nav_submenu_item_hover_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a:hover',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->insert_divider();
		$this->add_responsive_control(
			'nav_submenu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'default'=>[
                        'top'    => 12,
                        'right'  => 12,
                        'bottom' => 12,
                        'left'   => 12,
                        'unit'   =>'px'
                    ],
				'selectors' => [
					'{{WRAPPER}} .nav-mega-menu-wrap .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nav_submenu_item_border',
				'selector' => '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a',
			]
		);

		$this->add_responsive_control(
            'nav_submenu_item_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  50,
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li ul.nekit-sub-menu li a' =>  'border-radius: {{SIZE}}{{UNIT}}'
				]
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
				'sub_mobile_menu_section',
				[
					'label' => esc_html__( 'Mobile Menu Section', 'news-kit-elementor-addons' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE
				]
			);
			$this->add_control(
				'dropdown_settings_canvas_styles_header',
				[
					'label'	=> esc_html__( 'Canvas Menu Header', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::HEADING,
					'separator'	=> 'after'
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Canvas Header Typography', 'news-kit-elementor-addons' ),
					'name' => 'dropdown_header_typography',
					'selector' => '{{WRAPPER}} .current-responsive-active-menu-content .header, {{WRAPPER}} .news-elementor-nav-mega-menu.isResponsiveMenu .nekit-nav-mega-menu-container.isShow li.menu-item .header .header-label',
				]
			);

			$this->add_control(
				'dropdown_header_font_color',
				[
					'label'	=> esc_html__( 'Font Color', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::COLOR,
					'default'	=> '#000000',
					'selectors' => [
						'{{WRAPPER}} .news-elementor-nav-mega-menu.isResponsiveMenu .nekit-nav-mega-menu-container.isShow li.menu-item .header .header-label, {{WRAPPER}} .news-elementor-nav-mega-menu.isResponsiveMenu .nekit-nav-mega-menu-container.isShow li.menu-item .header i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'      =>  'dropdown_header_background_color',
					'types'      =>  ['classic','gradient'],
					'selector' 	=> '{{WRAPPER}} .current-responsive-active-menu-content .header'
				]
			);
			
			$this->add_responsive_control(
				'dropdown_header_padding',
				[
					'label'	=> esc_html__( 'Canvas Header Padding', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default'=>[
	                        'top'    => 20,
	                        'right'  => 20,
	                        'bottom' => 20,
	                        'left'   => 20,
	                        'unit'   =>'px'
	                    ],
					'label_block'   =>  true,
					'selectors' => [
						'{{WRAPPER}} .news-elementor-nav-mega-menu.isResponsiveMenu .nekit-nav-mega-menu-container.isShow li.menu-item .header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
				]
			);
			$this->insert_divider();
			$this->add_control(
				'dropdown_settings_section_styles_header',
				[
					'label'	=> esc_html__( 'Section Style Setting', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::HEADING
				]
			);
			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'      =>  'sub_mobile_menu_background_color',
					'types'      =>  ['classic','gradient'],
					'selector' 	=> '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container, {{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container li ul.sub-menu'
				]
			);
			$this->add_responsive_control(
				'sub_mobile_menu_section_padding',
				[
					'label'	=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default'=>[
	                        'top'    => 5,
	                        'right'  => 5,
	                        'bottom' => 5,
	                        'left'   => 10,
	                        'unit'   =>'px'
	                    ],
					'label_block'   =>  true,
					'selectors' => [
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container ul.sub-menu.current-responsive-active-menu-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'sub_mobile_menu_section_margin',
				[
					'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'sub_mobile_menu_section_border',
					'selector' => '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container',
				]
			);

			$this->add_responsive_control(
				'sub_mobile_menu_section_border_radius',
				[
					'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  1000,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container' =>  'border-radius: {{SIZE}}{{UNIT}}'
					]
				]
			);
			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sub_menu_section_box_shadow',
					'selector' => '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container'
				]
			);
			$this->end_controls_section();



		/* mobile menu */
		$this->start_controls_section(
			'mobile_menu_item_typography_section',
			[
				'label' => esc_html__( 'Mobile Menu Items', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_control(
				'mobile_menu_item_color',
				[
					'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item a i' => 'color: {{VALUE}}',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item ul.nekit-sub-menu li.menu-item a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item ul.nekit-sub-menu li.menu-item a i' => 'color: {{VALUE}}'
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'      =>  'mobile_menu_item_background_color',
					'types'      =>  ['classic','gradient'],
					'selector' 	=> '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.menu-item > a, {{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap li.menu-item ul.nekit-sub-menu li.menu-item a',
					'exclude'	=> ['image']
				]
			);

		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name' => 'mobile_menu_item_typography',
				'selector' => '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item a','{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item ul.nekit-sub-menu li.menu-item a'
			]
		);
		$this->insert_divider();

		$this->add_responsive_control(
				'responsive_menu_item_padding',
				[
					'label'	=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' => [
						'{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap > li.menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mobile_menu_item_border',
				'selector' => '{{WRAPPER}} .isResponsiveMenu .nekit-nav-mega-menu-list-wrap li.menu-item ul.nekit-sub-menu li.menu-item a',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'toggle_menu_typography_section',
			[
				'label' => esc_html__( 'Toggle Menu (Hamburger)', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->start_controls_tabs(
				'toggle_menu_item_style_tabs'
			);
				$this->start_controls_tab(
					'toggle_menu_item_style_initial_tab',
					[
						'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
					]
				);
					$this->add_control(
						'toggle_menu_item_color',
						[
							'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-icon .line' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-menu-text' => 'color: {{VALUE}}'
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name'      =>  'toggle_menu_item_background_color',
							'type'      =>  ['classical','gradient'],
							'selector' 	=> '{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-icon',
							'exclude'	=> ['image']
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'toggle_menu_item_style_hover_tab',
					[
						'label' =>  esc_html__( 'Active', 'news-kit-elementor-addons' ),
					]
				);
					$this->add_control(
						'toggle_menu_item_hover_color',
						[
							'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .responsive-menu-trigger.nekit-hamburger-open .nekit-hamburger-icon .line' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .responsive-menu-trigger.nekit-hamburger-open .nekit-hamburger-menu-text' => 'color: {{VALUE}}',
								'{{WRAPPER}} .responsive-menu-trigger.nekit-hamburger-open .nekit-hamburger-icon' => 'border-color: {{VALUE}}'
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name'      =>  'toggle_menu_item_hover_background_color',
							'type'      =>  ['classical','gradient'],
							'selector' 	=> '{{WRAPPER}} .responsive-menu-trigger.nekit-hamburger-open .nekit-hamburger-icon',
							'exclude'	=> ['image']
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'toggle_menu_item_typography',
					'selector' => '{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-menu-text'
				]
			);
			$this->insert_divider();

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'toggle_menu_item_border',
					'selector' => '{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-icon',
				]
			);

			$this->add_responsive_control(
				'toggle_menu_section_border_radius',
				[
					'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::SLIDER,
					'range' =>  [
						'px'    =>  [
							'min'   =>  0,
							'max'   =>  100,
							'step'  =>  1
						]
					],
					'selectors' =>  [
						'{{WRAPPER}} .responsive-menu-trigger .nekit-hamburger-icon' =>  'border-radius: {{SIZE}}{{UNIT}}'
					]
				]
			);


			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'      =>  'toggle_menu_whole_background_color',
					'type'      =>  ['classical','gradient'],
					'selector' 	=> '{{WRAPPER}} .isResponsiveMenu',
					'exclude'	=> ['image']
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'menu_description_typography_section',
			[
				'label' => esc_html__( 'Menu Description', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition'	=> apply_filters( 'nekit_nav_menu_display_condition_filter', [
					'nav_menu_display'	=> 'pro'
				])
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name' => 'menu_description_typography',
				'selector' => '{{WRAPPER}} .menu-item-description','{{WRAPPER}} .menu-item-description'
			]
		);

		$this->start_controls_tabs(
            'menu_description_style_tabs'
        );
            $this->start_controls_tab(
                'menu_description_style_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'menu_description_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .menu-item-description' => 'color: {{VALUE}}',
							'{{WRAPPER}} .menu-item-description' => 'color: {{VALUE}}',
							'{{WRAPPER}} .menu-item-description' => 'color: {{VALUE}}',
							'{{WRAPPER}} .menu-item-description' => 'color: {{VALUE}}'
						],
					]
				);

				$this->add_control(
					'menu_description_arrow_color',
					[
						'label' => esc_html__( 'Arrow Background Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-menu-desc-absolute .menu-item-description:after' => 'border-top: 5px solid {{VALUE}}'
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'menu_description_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .menu-item-description',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
                'menu_description_style_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );
				$this->add_control(
					'menu_description_hover_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap li.menu-item a:hover .menu-item-description' => 'color: {{VALUE}}'
						],
					]
				);

				$this->add_control(
					'menu_description_arrow_hover_color',
					[
						'label' => esc_html__( 'Arrow Background Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .nekit-nav-mega-menu-list-wrap li.menu-item a:hover .menu-item-description:after' => 'border-top: 5px solid {{VALUE}}'
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'      =>  'menu_description_hover_background_color',
						'types'      =>  ['classic','gradient'],
						'selector' 	=> '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap li.menu-item a:hover .menu-item-description', '{{WRAPPER}} .nekit-nav-mega-menu-list-wrap li.menu-item a:hover .menu-item-description',
						'exclude'	=> ['image']
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_responsive_control(
				'menu_description_padding',
				[
					'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default'=>[
	                        'top'    => 2,
	                        'right'  => 4,
	                        'bottom' => 2,
	                        'left'   => 4,
	                        'unit'   =>'px'
	                    ],
					'selectors' => [
						'{{WRAPPER}} .menu-item-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .menu-item-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
				]
			);
			
			$this->add_responsive_control(
				'menu_description_margin',
				[
					'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'custom' ],
					'default'=>[
	                        'top'    => 0,
	                        'right'  => 3,
	                        'bottom' => 0,
	                        'left'   => 3,
	                        'unit'   =>'px'
	                    ],
					'selectors' => [
						'{{WRAPPER}} .menu-item-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .menu-item-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'menu_description_border',
					'selector' => '{{WRAPPER}} .menu-item-description',
				]
			);

			$this->add_responsive_control(
            'menu_description_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .menu-item-description' =>  'border-radius: {{SIZE}}{{UNIT}}'
				]
            ]
        );
		$this->end_controls_section();
	}  
 }