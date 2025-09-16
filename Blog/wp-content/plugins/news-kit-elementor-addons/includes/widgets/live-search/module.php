<?php
/**
 * Live Search Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Live_Search_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label'	=>	esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/live-search" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
			'input_field_display',
			[
				'label'	=>	esc_html__( 'Input field display on', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'initial',
				'options'	=>	[
                    'initial'	=>	esc_html__( 'Initially', 'news-kit-elementor-addons' ),
                    'click'	=>	esc_html__( 'On Icon Click', 'news-kit-elementor-addons' )
                ]
			]
		);

		$this->add_control(
			'input_field_search_type',
			[
				'label'	=>	esc_html__( 'Search Type', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'default',
				'options'	=>	[
                    'default'	=>	esc_html__( 'Default', 'news-kit-elementor-addons' ),
                    'live-search'	=>	esc_html__( 'Live Search', 'news-kit-elementor-addons' )
                ]
			]
		);
		
		$this->add_control(
			'search_icon',
			[
				'label'	=>	esc_html__( 'Search Icon', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::ICONS,
				'label_block'	=>	false,
				'skin'	=>	'inline',
				'recommended'	=> [
					'fa-solid'	=> ['search','search-plus','search-minus','search-location','search-dollar','searchengin']
				],
				'default'	=>	[
					'value'	=>	'fas fa-search',
					'library'	=>	'fa-solid'
				],
				'condition'	=>	[
					'input_field_display'	=>	'click'
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'	=>	esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	100,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	18
				],
				'condition'	=>	[
					'input_field_display'	=>	'click'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-trigger i'	=>	'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'search_icon_alignment',
			[
				'label'	=>	esc_html__( 'Search Icon Alignment', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::CHOOSE,
				'default'	=>	'left',
				'options'	=>	[
					'left'	=>	[
						'title'	=>	esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-left'
					],
					'center'	=>	[
						'title'	=>	esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-center'
					],
					'right'	=>	[
						'title'	=>	esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-right'
					]
				],
				'frontend_available' => true,
				'condition'	=>	[
					'input_field_display'	=>	'click'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-trigger'	=>	'text-align: {{VALUE}}'
				]
			]
		);
		$this->insert_divider();
		$this->add_control(
			'popup_type',
			[
				'label'	=>	esc_html__( 'Popup Type', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'absolute',
				'options'	=>	apply_filters( 'nekit_live_search_popup_type_array_options_filter', [
                    'absolute'	=>	esc_html__( 'Absolute', 'news-kit-elementor-addons' ),
                    'modal-box-pro'	=>	esc_html__( 'Modal Box ( in pro )', 'news-kit-elementor-addons' )
                ]),
                'condition'	=>	[
					'input_field_display'	=>	'click'
				]
			]
		);

		$this->add_responsive_control(
			'popup_type_absolute_spacing',
			[
				'label' =>  esc_html__( 'Spacing', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'default'	=>	[
					'top'	=>	20,
					'right'	=>	0,
					'bottom'	=>	0,
					'left'	=>	0,
					'unit'	=>	'px',
					'isLinked'	=>	true
				],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .nekit-search-form-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				],
				'condition' => [
					'popup_type' => ['absolute','modal-box-pro'],
					'input_field_display' => 'click'
				]
			]
		);

		$this->add_responsive_control(
			'popup_type_modal_width',
			[
				'label'	=>	esc_html__( 'Width', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	250,
						'max'	=>	1120,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	1120
				],
				'condition'	=>	[
					'popup_type'	=>	'modal-box'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-search-form-wrap .search-results-popup-wrap' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'popup_type_modal_height',
			[
				'label'	=>	esc_html__( 'Height', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'auto',
				'options'	=>	[
                    'auto'	=>	esc_html__( 'Auto', 'news-kit-elementor-addons' ),
                    'custom'	=>	esc_html__( 'Custom', 'news-kit-elementor-addons' )
                ],
				'condition'	=>	[
					'popup_type'	=>	'modal-box'
				]
			]
		);
		$this->add_responsive_control(
			'popup_type_modal_custom_height',
			[
				'label'	=>	esc_html__( 'Custom Height', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	1
					]
				],
				'condition'	=>	[
					'popup_type'	=>	'modal-box',
					'popup_type_modal_height'	=>	'custom'
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-search-form-wrap .search-results-popup-wrap' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
            'popup_type_modal_horizontal_alignment',
            [
                'label' =>  esc_html__( 'Horizontal Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'center',
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-right'
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .popup-wrapper'  =>  'justify-content:{{VALUE}}'
                ],
				'frontend_available' => true,
                'toggle'    =>  false,
				'condition' => [
					'popup_type' => 'modal-box'
				]
            ]
        );

		$this->add_responsive_control(
            'popup_type_modal_vertical_alignment',
            [
                'label' =>  esc_html__( 'Vertical Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'middle',
                'options'   =>  [
                    'top'  =>  [
                        'title' =>  esc_html__( 'Top', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-top'
                    ],
                    'middle'  =>  [
                        'title' =>  esc_html__( 'Middle', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-middle'
                    ],
                    'bottom'  =>  [
                        'title' =>  esc_html__( 'Bottom', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-bottom'
                    ],
                ],
				'frontend_available' => true,
                'toggle'    =>  false,
				'condition' => [
					'popup_type' => 'modal-box'
				]
            ]
        );
        $this->end_controls_section();

		$this->start_controls_section(
			'search_results_section',
			[
				'label' =>	esc_html__( 'Search Results', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'no_of_search_results',
			[
				'label'	=>	esc_html__( 'No of search results to show', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Set value to show number of posts to show on popup.', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	1,
				'max'	=>	10000,
				'step'	=>	1,
				'default'	=> 	4
			]
		);

		$this->add_control(
			'no_of_search_results_link_target',
			[
				'label'	=>	esc_html__( 'Open search results in', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'_self',
				'options'	=>	[
                    '_self'	=>	esc_html__( 'Same tab', 'news-kit-elementor-addons' ),
                    '_blank'	=>	esc_html__( 'New tab', 'news-kit-elementor-addons' )
                ]
			]
		);

		$this->add_control(
			'thumbnail_option',
			[
				'label'	=>	esc_html__( 'Show thumbnail image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_post_element_date_control();
		$this->end_controls_section();

		$this->start_controls_section(
			'view_all_results_button_section',
			[
				'label'	=>	esc_html__( 'View All Button  / Not results found', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'view_all_results_button_option',
			[
				'label'	=>	esc_html__( 'Show button', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);

		$this->add_control(
			'view_all_results_button_label',
			[
				'label'	=>	esc_html__( 'Button label', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'default'	=>	esc_html__( 'View all results', 'news-kit-elementor-addons' ),
				'placeholder'	=>	esc_html__( 'Type button label here', 'news-kit-elementor-addons' )
			]
		);
		$this->insert_divider();
		$this->add_control(
			'no_results_heading',
			[
				'label'	=>	esc_html__( 'No results found', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'no_results_title',
			[
				'label'	=>	esc_html__( 'Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'default'	=>	esc_html__( 'Could not find what you are looking for', 'news-kit-elementor-addons' ),
				'placeholder'	=>	esc_html__( 'Add title . .', 'news-kit-elementor-addons' )
			]
		);

		$this->add_control(
			'no_results_description',
			[
				'label'	=>	esc_html__( 'Description', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXTAREA,
				'default'	=>	esc_html__( 'Try another search ?', 'news-kit-elementor-addons' ),
				'placeholder'	=>	esc_html__( 'Add description . .', 'news-kit-elementor-addons' )
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'posts_image_settings_section',
			[
				'label'	=>	esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'	=>	esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'medium',
				'label_block'	=>	true,
				'options'	=>	$this->get_image_sizes()
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'	=>	esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	[ '%' ],
				'range'	=>	[
					'%'	=>	[
						'min'	=>	5,
						'max'	=>	100,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'%',
					'size'	=>	15
				],
				'selectors'	=>	[
					'{{WRAPPER}} .post-thumb-wrap'	=>	'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label'	=>	esc_html__( 'Image Ratio', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	[ 'px' ],
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	2,
						'step'	=>	.1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	.1
				],
				'selectors'	=>	[
					'{{WRAPPER}} .post-thumb-wrap'	=>	'padding-bottom: calc( {{SIZE}} * 100% );'
				]
			]
		);
		
		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-thumb-wrap'
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
                    '{{WRAPPER}} .post-thumb-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .post-thumb-wrap'
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'general_styles_section',
			[
				'label'	=>	esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs(
            'widget_styles_initial_hover_tab'
        );
            $this->start_controls_tab(
                'widget_style_initial_tab',
                [
                    'label' =>   esc_html__('Initial','news-kit-elementor-addons')
                ]
            );

            $this->add_control(
                'icon_color', [
                    'label' => esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-icon-wrap' => 'color:{{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'background_color',
                    'types'  =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .search-icon-wrap'
                ]
            );

            $this->add_group_control(
	            \Elementor\Group_Control_Border::get_type(),
	            [
	                'name' => 'icon_initial_border',
	                'selector' => '{{WRAPPER}} .search-icon-wrap'
	            ]
	        );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'icon_initial_box_shadow',
                    'selector' => '{{WRAPPER}} .search-icon-wrap'
                ]
            );

            $this->add_responsive_control(
                'icon_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .search-icon-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'widget_style_hover_tab',
                [
                    'label' =>  esc_html__('Hover', 'news-kit-elementor-addons')
                ]
            );

            $this->add_control(
                'icon_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-icon-wrap:hover'   => 'color:{{VALUE}};'
                    ]
                ]
            );
            
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'      =>  'background_hover_color',
                    'types'      =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .search-icon-wrap:hover'
                ]
            );

            $this->add_group_control(
	            \Elementor\Group_Control_Border::get_type(),
	            [
	                'name' => 'icon_hover_border',
	                'selector' => '{{WRAPPER}} .search-icon-wrap:hover'
	            ]
	        );
            
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'icon_hover_box_shadow',
                    'selector' => '{{WRAPPER}} .search-icon-wrap:hover'
                ]
            );

            $this->add_responsive_control(
                'icon_hover_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .search-icon-wrap:hover'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

		$this->add_responsive_control(
			'search_icon_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'default'	=>	[
					'top'	=>	0,
					'right'	=>	0,
					'bottom'	=>	0,
					'left'	=>	0,
					'unit'	=>	'px',
					'isLinked'	=>	true
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-trigger .search-icon-wrap'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->add_responsive_control(
			'search_icon_margin',
			[
				'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'default'	=>	[
					'top'	=>	0,
					'right'	=>	0,
					'bottom'	=>	0,
					'left'	=>	0,
					'unit'	=>	'px',
					'isLinked'	=>	true
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-trigger .search-icon-wrap'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'search_form_styles_section',
			[
				'label'	=>	esc_html__( 'Search Form Styles', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);
		$this->add_control(
			'search_field_styles_heading',
			[
				'label'	=>	esc_html__( 'Search Field', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING,
				'separator'	=>	'none'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'search_field_typography',
				'fields_options'	=>	[
					'typography'	=>	[
						'default'	=>	'custom'
					],
					'font_family'	=>	[
						'default'	=>	'Rubik'
					]
				],
				'selector'	=>	'{{WRAPPER}} .search-field, {{WRAPPER}} input.search-field:focus::placeholder'
			]
		);

		$this->add_control(
			'search_field_color',
			[
				'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .search-field, {{WRAPPER}} input.search-field:focus::placeholder, .search-field::placeholder'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'search_field_background_color',
				'selector'  =>  '{{WRAPPER}} .search-field',
				'exclude'   =>  ['image']
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'	=>	'search_field_border',
				'selector'	=>	'{{WRAPPER}} .search-field'
			]
		);

		$this->add_control(
			'search_field_border_radius',
			[
				'label'	=>	esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	0,
				'max'	=>	500,
				'step'	=>	1,
				'default'	=>	0,
				'selectors'	=>	[
					'{{WRAPPER}} .search-field'	=>	'border-radius: {{VALUE}}px'
				]
			]
		);
		$this->insert_divider();
		$this->add_responsive_control(
			'search_field_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .search-field'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'search_field_margin',
			[
				'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .search-form label'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->insert_divider();
		$this->add_control(
			'search_button_styles_heading',
			[
				'label'	=>	esc_html__( 'Search Button', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING,
				'separator'	=>	'none'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'search_buton_typography',
				'selector'	=>	'{{WRAPPER}} .search-submit'
			]
		);

		$this->start_controls_tabs(
			'search_button_style_tabs'
		);
		$this->start_controls_tab(
			'search_button_initial_tab',
			[
				'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
			]
		);
		
		$this->add_control(
			'search_button_color',
			[
				'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .search-submit'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'search_button_background_color',
				'selector'  =>  '{{WRAPPER}} .search-submit',
				'exclude'   =>  ['image']
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'search_button_hover_tab',
			[
				'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
			]
		);
		
		$this->add_control(
			'search_button_hover_color',
			[
				'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .search-submit:hover'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'search_button_background_hover_color',
				'selector'  =>  '{{WRAPPER}} .search-submit:hover',
				'exclude'   =>  ['image']
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'	=>	'search_button_border',
				'selector'	=>	'{{WRAPPER}} .search-submit'
			]
		);

		$this->add_control(
			'search_button_border_radius',
			[
				'label'	=>	esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	[ 'px' ],
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	0
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-submit'	=>	'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'	=>	'search_button_box_shadow',
				'selector'	=>	'{{WRAPPER}} .search-submit'
			]
		);
		$this->insert_divider();
		$this->add_responsive_control(
			'search_button_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .search-submit'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'search_button_margin',
			[
				'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .search-submit'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'results_popup_styles_section',
			[
				'label'	=>	esc_html__( 'Search Results Popup', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'results_popup_background',
				'selector'  =>  '{{WRAPPER}} .search-results-wrap, {{WRAPPER}} .trigger-form-onclick .nekit-search-form-wrap .search-form',
				'exclude'   =>  ['image']
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'	=>	'results_popup_border',
				'selector'	=>	'{{WRAPPER}} .search-results-wrap, {{WRAPPER}} .trigger-form-onclick .nekit-search-form-wrap .search-form'
			]
		);

		$this->add_control(
			'results_popup_border_radius',
			[
				'label'	=>	esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	[ 'px' ],
				'range'	=>	[
					'px'	=>	[
						'min'	=>	0,
						'max'	=>	1000,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	0
				],
				'selectors'	=>	[
					'{{WRAPPER}} .search-results-wrap, {{WRAPPER}} .trigger-form-onclick .nekit-search-form-wrap .search-form' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'	=>	'results_popup_box_shadow',
				'selector'	=>	'{{WRAPPER}} .search-results-wrap, {{WRAPPER}} .trigger-form-onclick .nekit-search-form-wrap .search-form'
			]
		);

		$this->add_responsive_control(
			'results_popup_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'	=>	true,
				'selectors'	=>	[
					'{{WRAPPER}} .search-results-wrap, {{WRAPPER}} .trigger-form-onclick .nekit-search-form-wrap .search-form'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'results_popup_margin',
			[
				'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'default' => [
					'top'	=>	20,
					'right'	=>	0,
					'bottom'	=>	0,
					'left'	=>	0,
					'unit'	=>	'px',
					'isLinked'	=>	true
				],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .search-results-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->insert_divider();
		$this->add_control(
			'search_results_view_all_button_styles_settings_header',
			[
				'label'	=>	esc_html__( 'View All Button Style', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING
				]
			);
		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'search_results_view_all_button_typography',
				'selector'	=>	'{{WRAPPER}} .view-all-search-button'
			]
		);
		$this->start_controls_tabs(
			'search_results_view_all_button_styles_tab'
		);
		$this->start_controls_tab(
			'search_results_view_all_button_styles_initial_tab',
			[
				'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
			]
		);
		
		$this->add_control(
			'search_results_view_all_button_color',
			[
				'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'default'	=>	'#000',
				'selectors'	=>	[
					'{{WRAPPER}} .view-all-search-button'	=>	'color: {{VALUE}}'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'search_results_view_all_button_background_color',
				'selector'  =>  '{{WRAPPER}} .view-all-search-button',
				'exclude'   =>  ['image']
			]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'search_results_view_all_button_box_shadow',
                'selector'=> '{{WRAPPER}} .view-all-search-button'
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'search_results_view_all_button_styles_hover_tab',
			[
				'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
			]
		);
		
		$this->add_control(
			'search_results_view_all_button_hover_color',
			[
				'label'	=> 	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .view-all-search-button:hover' => 'color: {{VALUE}}'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'search_results_view_all_button_background_hover_color',
				'selector'  =>  '{{WRAPPER}} .view-all-search-button:hover',
				'exclude'   =>  ['image']
			]
		);
		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'search_results_view_all_button_hover_box_shadow',
                'selector'=> '{{WRAPPER}} .view-all-search-button:hover'
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->insert_divider();
		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'search_results_view_all_button_border',
                'selector'  =>  '{{WRAPPER}} .view-all-search-button'
            ]
        );

		$this->add_responsive_control(
            'search_results_view_all_button_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .view-all-search-button'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->add_responsive_control(
			'search_results_view_all_button_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .view-all-search-button'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'search_results_view_all_button_margin',
			[
				'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'default'	=>	[
					'top'	=>	0,
					'right'	=>	0,
					'bottom'	=>	6,
					'left'	=>	0,
					'unit'	=>	'px',
					'isLinked'	=>	true
				],
				'label_block'	=>	true,
				'selectors' =>  [
					'{{WRAPPER}} .view-all-search-button'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_title_section_typography',
			[
				'label'	=>	esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
				'tab' 	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'post_title_typography',
					'fields_options'	=>	[
						'typography'	=>	[
							'default'	=>	'custom'
						],
						'font_family'	=>	[
							'default'	=>	'Rubik'
						],
						'font_size'	=>	[
							'default'	=>	[
								'unit'	=>	'px',
								'size'	=>	17
							]
						],
						'font_weight'	=>	[
							'default'	=>	500
						]
					],
					'selector'	=>	'{{WRAPPER}} .post-title'
				]
			);

			$this->start_controls_tabs(
				'post_title_style_tabs'
			);
			$this->start_controls_tab(
				'post_title_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_title_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#000',
					'selectors'	=>	[
						'{{WRAPPER}} .post-title a'	=>	'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_title_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_title_hover_color',
				[
					'label'	=> 	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_title_background_color',
					'selector'  =>  '{{WRAPPER}} .post-title',
					'exclude'   =>  ['image']
				]
			);

			$this->add_responsive_control(
				'post_title_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .post-title'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_title_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'default'	=>	[
						'top'	=>	0,
						'right'	=>	0,
						'bottom'	=>	6,
						'left'	=>	0,
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'label_block'	=>	true,
					'selectors' =>  [
						'{{WRAPPER}} .post-title'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_date_section_typography',
			[
				'label'	=>	esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'post_date_typography',
					'selector'	=>	'{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date'
				]
			);

			$this->start_controls_tabs(
				'post_date_style_tabs'
			);
			$this->start_controls_tab(
				'post_date_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_date_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#8A8A8C',
					'selectors'	=>	[
						'{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_date_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_date_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_date_background_color',
					'selector'  =>  '{{WRAPPER}} .date-meta-wrap',
					'exclude'   =>  ['image']
				]
			);

			$this->add_responsive_control(
				'post_date_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .date-meta-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_date_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .date-meta-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();
    }

    protected function render() {
		$settings = $this->get_settings_for_display();
		$to_json = [
			'count'	=> $settings['no_of_search_results'],
			'link_target'	=> $settings['no_of_search_results_link_target'],
			'button_option'	=> $settings['view_all_results_button_option'],
			'button_label'	=> $settings['view_all_results_button_label'],
			'no_results_title'	=> $settings['no_results_title'],
			'no_results_description'	=> $settings['no_results_description'],
			'thumbnail_option'	=> $settings['thumbnail_option'],
			'show_post_date'	=> $settings['show_post_date'],
			'post_date_icon_position'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
			'post_date_icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
				'value' =>  'fas fa-calendar',
				'library'   =>  'fa-solid'
			]
		];
		$popup_type = ( isset( $settings['popup_type'] ) && ! strpos( $settings['popup_type'], 'pro' ) ) ? $settings['popup_type']: 'absolute';
		$widget_container_class[] = 'nekit-live-search-widget live-search-wrap';
		if( $settings['input_field_display'] == 'click' ) $widget_container_class[] = 'trigger-form-onclick';
		if( $settings['input_field_search_type'] == 'live-search' ) $widget_container_class[] = 'search-type--live-search';
		$widget_container_class[] = 'popup-type--' . esc_html( $popup_type );
		if( isset( $settings['popup_type_modal_vertical_alignment'] ) ) $widget_container_class[] = 'popup-modal-vertical-align--' . esc_html($settings['popup_type_modal_vertical_alignment']);
		if( isset( $settings['search_icon_alignment'] ) ) $widget_container_class[] = 'social-icon-align--' . esc_html($settings['search_icon_alignment']);
		?>
			<div class="<?php echo esc_attr( implode( ' ', $widget_container_class ) ); ?>">
				<?php
					if( $settings['input_field_display'] == 'click' ) :
						echo '<div class="search-trigger"><span class="search-icon-wrap">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['search_icon']])). '</span></div>';
					endif;
			  	?>
			  	
				<div class="nekit-search-form-wrap">
					<span class="close-modal"><i class="fas fa-times"></i></span>
					<?php
						if( 'modal-box' == $settings['popup_type'] ) :
					?>
							<div class="popup-wrapper">
								<div class="search-results-popup-wrap">
					<?php
						endif;
							echo get_search_form();
						if( 'modal-box' == $settings['popup_type'] ) :
					?>
								</div>
							</div>
					<?php
						endif;
					?>
				</div>
				<input type="hidden" name="nekit_search_widget_settings[<?php echo esc_attr($this->get_id()); ?>]" value="<?php echo esc_attr( wp_json_encode($to_json) ); ?>">
				<script>
					nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode($to_json); ?>;
				</script>
			</div>
		<?php
	}
}