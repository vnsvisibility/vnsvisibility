<?php
/**
 * Categories Collection Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Categories_Collection_Module extends \Nekit_Widget_Base\Base {
    public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/categories-collection" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_responsive_control(
            'widget_column',
            [
                'label' =>  esc_html__( 'No of columns', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'default'   =>  3,
                'max'   =>  nekit_get_widgets_column_max(),
                'step'  =>  1,
                'frontend_available'    => true
            ]
        );

        $this->add_control(
            'widget_skin',
            [
                'label' =>  esc_html__( 'Skin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'classic',
                'options'   =>  [
                    'classic'   =>  esc_html__( 'Classic', 'news-kit-elementor-addons' ),
                    'card'   =>  esc_html__( 'Card', 'news-kit-elementor-addons' )
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'categories_query_setting',
            [
                'label' =>  esc_html__( 'Categories Query', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

		$this->add_taxonomy_select_control( 'post_custom_taxonomies', 'Select Taxonomies', [
            'query_slug'	=>	'any'
        ]);

        $this->add_control(
			'categories_include',
			[
				'label'	=> esc_html__( 'Categories to Include (Terms to Include)', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_taxonomies',
				'query_slug'	=> 'category',
                'dependency'	=>	'post_custom_taxonomies',
                'conditions'	=>	[
                    'terms'	=>	[
                        [
                            'name'	=>	'post_custom_taxonomies',
                            'operator'	=>	'!=',
                            'value'	=>	''
                        ],
                    ]
                ]
			]
		);

        $this->add_control(
            'categories_hide_empty',
            [
                'label' =>  esc_html__( 'Hide Empty', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'categories_elements_settings',
            [
                'label' =>  esc_html__( 'Categories Elements', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' =>  esc_html__( 'Show title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label' =>  esc_html__( 'Html Tag', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'h2',
                'options'   =>  $this->get_html_tags(),
                'condition' =>  [
                    'show_title'    =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'title_before_after',
            [
                'label' =>  esc_html__( 'Title Sorting', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'before',
                'options'   =>  [
                    'after' =>  
                          esc_html__( 'After', 'news-kit-elementor-addons' ),
                    
                    'before'    =>  
                        esc_html__( 'Before', 'news-kit-elementor-addons' ),
                
                ],
                'condition' =>  [
                    'show_title'    =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' =>  esc_html__( 'Show post thumbnail', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' =>  esc_html__( 'Show posts count', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );
        $this->add_control(
            'show_description',
            [
                'label' =>  esc_html__( 'Show description', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->add_control(
            'description_length',
            [
                'label' =>  esc_html__( 'Description length', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'  =>   10,
                'condition' => apply_filters( 'nekit_categories_collection_description_condition_filter', [
                    'show_description'  => 'pro'
                ])
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'categories_elements_alignment',
            [
                'label' =>  esc_html__( 'Elements Alignment','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'center',
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
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .content-wrap' =>  'text-align:{{VALUE}};'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'elements_sorting',
            [
                'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
                'type'  =>  'sortable-control',
                'label_block'   =>  true,
                'default'   =>  [ 'title-meta', 'description' ],
                'options'   =>  [
                    'title-meta' =>  [
                        'label' =>  esc_html__( 'Category Title / Meta', 'news-kit-elementor-addons' )
                    ],
                    'description'   =>  [
                        'label' =>  esc_html__( 'Category Description', 'news-kit-elementor-addons' )
                    ]
                ],
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'categories_elements_alignment' => 'pro'
                ])
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'badge_settings',
            [
                'label' =>  esc_html__( 'Badge Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_badges',
            [
                'label' =>  esc_html__( 'Show Badge', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'description'   =>  esc_html__( 'Badges appears over the image', 'news-kit-elementor-addons' ),
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'badges_items',
            [
                'label' =>  esc_html__( 'Badges Items', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT2,
                'multiple'  =>  true,
                'label_block'   =>  true,
                'default'   =>  ['title'],
                'options'   =>  [
                    'title'    =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                    'count'    =>  esc_html__( 'Count', 'news-kit-elementor-addons' )
                ],
                'condition' =>  [
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'badges_position',
            [
                'label' =>  esc_html__( 'Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
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
                        'icon'  =>  'eicon-h-align-left'
                    ],
                ],
                'toggle'    =>  false,
                'condition' =>  [
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'x_axis_distance',
            [
                'label' =>  esc_html__( 'X Axis Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  50
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--center'    =>  'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'badges_position'   =>  'center',
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'y_axis_distance',
            [
                'label' =>  esc_html__( 'Y Axis Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  50
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--center'    =>  'top: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'badges_position'   =>  'center',
                    'show_badges'   =>  'yes'
                ]
            ]
        );


        $this->add_responsive_control(
            'distance_left',
            [
                'label' =>  esc_html__( 'Distance Left', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  2
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--left'    =>  'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'badges_position'   =>  'left',
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'distance_right',
            [
                'label' =>  esc_html__( 'Distance Right', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  2
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--right'    =>  'right: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'badges_position'   =>  'right',
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'distance_bottom',
            [
                'label' =>  esc_html__( 'Distance Bottom', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  2
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--right'    =>  'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .sole-category .badges-wrap.badge-position--left'    =>  'bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' =>  [
                    'badges_position!'   =>  'center',
                    'show_badges'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'badge_before_after',
            [
                'label' =>  esc_html__( 'Title Sorting', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'before',
                'options'   =>  [
                    'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' ),
                ],
                'condition' =>  [
                    'show_badges'    =>  'yes'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_settings',
            [
                'label' =>  esc_html__( 'Carousel Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => apply_filters( 'nekit_category_collection_carousel_setting_condition_filter', [
                    'widget_skin'   => 'pro'
                ])
            ]
        );
        $this->add_control(
            'show_carousel',
            [
                'label' =>  esc_html__( 'Enable carousel', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' =>  esc_html__( 'Show arrows', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes',
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_autoplay',
            [
                'label' =>  esc_html__( 'Enable autoplay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' =>  esc_html__( 'Autoplay speed', 'news-kit-elementor-addons' ),
                'description'   =>  esc_html__( 'Autoplay speed in milliseconds', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  100,
                'max'   =>  10000,
                'step'  =>  100,
                'default'   =>  300,
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes',
                    'enable_autoplay' =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'show_fade',
            [
                'label' =>  esc_html__( 'Enable fade animation', 'news-kit-elementor-addons' ),
                'description'   =>  esc_html__( 'Fade animation only works when no of columns is set 1', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'show_infinite',
            [
                'label' =>  esc_html__( 'Enable infinite loop', 'news-kit-elementor-addons' ),
                'description'   =>  esc_html__( 'Repeats the previous carousel item once it reaches to the end of the carousel', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
			'show_slider_arrow_on_hover',
			[
				'label'	=>	esc_html__( 'Show slider arrow on hover', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'default'	=>	'yes',
				'return_value'	=>	'yes',
                'condition' =>  [
                    'show_carousel' =>  'yes'
                ]
			]
		);

        $this->add_control(
            'carousel_speed',
            [
                'label' =>  esc_html__( 'Speed', 'news-kit-elementor-addons' ),
                'description'   =>  esc_html__( 'Slide / Fade animation speed', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  100,
                'max'   =>  10000,
                'step'  =>  100,
                'default'   =>  1500,
                'frontend_available'    => true,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'slider_prev_icon',
            [
                'label' =>  esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
                    'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-chevron-left',
                    'library'   =>  'fa-solid'
                ]
            ]
        );

        $this->add_control(
            'slider_next_icon',
            [
                'label' =>  esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
                    'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
                ],
                'default'   =>  [
                    'value' =>  'fas fa-chevron-right',
                    'library'   =>  'fa-solid'
                ]
            ]
        );
        $this->add_responsive_control(
			'slider_icon_size',
			[
				'label' => esc_html__( 'Icon size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'hover_settings',
            [
                'label' =>  esc_html__( 'Hover Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'image_hover_animation',
            [
                'label' =>  esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'image_settings',
            [
                'label' =>  esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' =>  esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'large',
                'label_block'   =>  true,
                'options'   =>  $this->get_image_sizes()
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
                    'size' => .5
				],
				'selectors' => [
					'{{WRAPPER}} .sole-category .category-thumb' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .sole-category .category-thumb'
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
                    '{{WRAPPER}} .sole-category .category-thumb'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .sole-category .category-thumb'
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

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => nekit_get_widgets_column_gap_max(),
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-categories-collection-wrap.carousel-disabled' => 'column-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-categories-collection-wrap .slick-slide' => 'padding-right: calc({{SIZE}}{{UNIT}}/2); padding-left: calc({{SIZE}}{{UNIT}}/2);'
				]
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
						'max' => nekit_get_widgets_row_gap_max(),
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-categories-collection-wrap.carousel-disabled' => 'row-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'card_skin_styles',
            [
                'label' =>  esc_html__( 'Card Skin Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'post_background_color',
                'selector'  =>  '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap, {{WRAPPER}} .skin--card.carousel-active .sole-category',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#ffffff'
                    ]
                ],
                'exclude'   =>  ['image']
            ]
        );

        $this->add_control(
			'card_hover_effects_dropdown',
			[
				'label'	=>	esc_html__( 'Hover Effects', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'options'	=>	nekit_get_card_skin_effects_array(),
				'default'	=>	'none'
			]
		);
        $this->insert_divider();

        $this->start_controls_tabs(
            'card_skin_box_shadow_tabs'
        );

            $this->start_controls_tab(
                'card_skin_box_shadow_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  => 'card_initial_background_color',
                    'selector'=> '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap, {{WRAPPER}} .skin--card.carousel-active .sole-category',
					'exclude'	=>	['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_initial_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap, {{WRAPPER}} .skin--card.carousel-active .sole-category'
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'card_skin_box_shadow_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  => 'card_hover_background_color',
                    'selector'=> '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap:hover, {{WRAPPER}} .skin--card.carousel-active .sole-category:hover',
					'exclude'	=>	['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_hover_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap:hover, {{WRAPPER}} .skin--card.carousel-active .sole-category:hover'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'	=>	'card_border',
				'selector'	=>	'{{WRAPPER}} .skin--card .nekit-item-box-wrap'
			]
		);		

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .skin--card.carousel-active .sole-category'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  7,
                    'right' =>  7,
                    'bottom'    =>  7,
                    'left'  =>  7,
                    'unit'  =>  'px',
                    'isLinked'  =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .skin--card.carousel-disabled .nekit-item-box-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .skin--card.carousel-active .sole-category'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'category_title_controls',
            [
                'label' =>  esc_html__( 'Category Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'category_title_typography',
                'selector'  =>  '{{WRAPPER}} .category-title',
                'fields_options'  => [
                    'typography'  => [
                        'default' => 'custom',
                    ],
                    'font_size'   =>  [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16
                        ]
                    ],
                    'text_transform' => [
                        'default' => 'uppercase'
                    ]
                ]
            ]
        );

        $this->start_controls_tabs(
            'category_title'
        );
            $this->start_controls_tab(
                'category_title_initial',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );


            $this->add_control(
                'category_title_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .category-title a'  =>  'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'category_title_background_color',
                    'selector'  =>  '{{WRAPPER}} .category-title',
                    'exclude'   =>  ['image']
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'category_title_hover',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'category_title_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .category-title:hover a'   =>  'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'category_title_hover_background_color',
                    'selector'  =>  '{{WRAPPER}} .category-title:hover',
                    'exclude'   => ['image']
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_responsive_control(
            'category_title_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-title a'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'category_title_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  8,
                    'right' =>  0,
                    'bottom'    =>  0,
                    'left'  =>  0,
                    'unit'  =>  'px',
                    'isLinked'  =>  true,
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-title'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'category_count_controls',
            [
                'label' =>  esc_html__( 'Category Count', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'category_count_typography',
                'selector'  =>  '{{WRAPPER}} .category-count'
            ]
        );

        $this->add_control(
            'category_count_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .category-count'   =>  'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'category_count_background_color',
                'selector'  =>    '{{WRAPPER}} .category-count',
                'exclude'   =>  ['image']
            ]
        );
        $this->insert_divider();
        $this->add_responsive_control(
            'category_count_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .category-title-count-wrap .category-count'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'category_count_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-count'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} '
                ]
            ]
        );

        $this->add_responsive_control(
            'category_count_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 8,
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-count'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'category_description_controls',
            [
                'label' =>  esc_html__( 'Category Description', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'category_description_typography',
                'selector'  =>  '{{WRAPPER}} .category-description',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'size'  =>  13,
                            'unit'  =>  'px'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'category_description_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .category-description'   =>  'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'category_description_background_color',
                'selector'  =>    '{{WRAPPER}} .category-description',
                'exclude'   =>  ['image']
            ]
        );
        $this->insert_divider();
        $this->add_responsive_control(
            'category_description_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-description'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} '
                ]
            ]
        );

        $this->add_responsive_control(
            'category_description_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .category-description'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} '
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'badge_control_section',
            [
                'label' =>  esc_html__( 'Badge Controls', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs(
            'slider_control_individual_settings'
        );
            $this->start_controls_tab(
                'badge_title_individual_settings',
                [
                    'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' )
                ]
            );

            
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'  =>  'badge_control_typography',
                    'selector'  =>  '{{WRAPPER}} .badges-wrap .badge-title',
                    'fields_options'  =>  [
                        'typography'  =>  [
                            'default' => 'custom'
                        ],
                        'font_size'   => [
                            'default' => [
                                'unit' => 'px',
                                'size' => 14
                            ]
                        ],
                        'text_transform' => [
                            'default'  => 'uppercase'
                        ],
                        'letter_spacing' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => 1
                            ]
                        ]
                    ]
                ]
            );

            $this->add_control(
                'badge_title_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-title a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'badge_title_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-title:hover a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'badge_title_background_color',
                    'types'  =>  ['classic', 'gradient'],
                    'fields_options' => [
                        'background' => [
                            'default'  => 'classic'
                        ],
                        'color'  => [
                            'default' => '#ffffffd9'
                        ]
                    ],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .badges-wrap .badge-title a'
                ]
            );

            $this->add_responsive_control(
                'badge_title_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-title a'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'badge_title_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px', '%', 'em', 'cusotm' ],
                    'default'   =>  [
                        'top'   =>  7,
                        'right'   =>  18,
                        'bottom'   =>  7,
                        'left'   =>  18,
                        'unit'   =>  'px',
                        'isLinked'   =>  true,
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-title a'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'badge_title_margin',
                [
                    'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px', '%', 'em', 'cusotm' ],
                    'default'   =>  [
                        'top'   =>  0,
                        'right'   =>  0,
                        'bottom'   =>  0,
                        'left'   =>  0,
                        'unit'   =>  'px',
                        'isLinked'   =>  true,
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-title'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'badge_count_individual_settings',
                [
                    'label' =>  esc_html__( 'Count', 'news-kit-elementor-addons' )
                ]
            );

            
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'  =>  'badge_control_count_typography',
                    'selector'  =>  '{{WRAPPER}} .badges-wrap .badge-count'
                ]
            );

            $this->add_control(
                'badge_count_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-count' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'badge_count_background_color',
                    'types'  =>  ['classic', 'gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .badges-wrap .badge-count'
                ]
            );

            $this->add_responsive_control(
                'badge_count_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-count'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'badge_count_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px', '%', 'em', 'cusotm' ],
                    'default'   =>  [
                        'top'   =>  0,
                        'right' =>  0,
                        'bottom'=>  0,
                        'left'  =>  0,
                        'unit'  =>  'px',
                        'isLinked'   =>  true
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-count'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'badge_count_margin',
                [
                    'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px', '%', 'em', 'cusotm' ],
                    'default'   =>  [
                        'top'   =>  0,
                        'right'   =>  0,
                        'bottom'   =>  0,
                        'left'   =>  8,
                        'unit'   =>  'px',
                        'isLinked'   =>  true,
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .badges-wrap .badge-count'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_controls',
            [
                'label' =>  esc_html__( 'Carousel Controls', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                'condition' =>  [
                    'show_carousel'   =>  'yes'
                ]
            ]
        );
        
        $this->add_control(
            'carousel_controls_color_heading',
            [
                'label' =>  esc_html__( 'Colors', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->start_controls_tabs(
            'carousel_tabs'
        );
            $this->start_controls_tab(
                'carousel_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'carousel_arrow_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .slick-arrow i' => 'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'carousel_initial_background_color',
                    'selector'  =>  '{{WRAPPER}} .slick-arrow',
                    'exclude'   =>  ['image'],
                    'fields_options'    =>  [
                        'background'    =>  [
                            'default'   => 'classic',
                        ],
                        'color' =>  [
                            'default'   =>  '#ffffff'
                        ]
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'carousel_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'carousel_arrows_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .slick-arrow:hover i' => 'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'carousel_arrows_hover_background_color',
                    'selector'  =>  '{{WRAPPER}} .slick-arrow:hover',
                    'exclude'   =>  ['image'],
                    'fields_options'    =>  [
                        'background'    =>  [
                            'default'   => 'classic',
                        ],
                        'color' =>  [
                            'default'   =>  '#ffffffd9'
                        ]
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_control(
            'slider_control_box_shadow_heading',
            [
                'label' =>  esc_html__( 'Box Shadow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slider_control_box_shadow',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);
        $this->insert_divider();
        $this->add_control(
            'slider_border_settings_heading',
            [
                'label' =>  esc_html__( 'Border Settings', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'slider_control_width',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);

        $this->add_control(
            'slider_control_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .slick-arrow'   =>  'border-radius:{{VALUE}}px'
                ]
            ]
        );

        $this->insert_divider();
        
        $this->add_control(
            'carousel_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  8,
                    'right' =>  12,
                    'bottom'    =>  8,
                    'left'  =>  12,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ] 
            ]
        );
        $this->end_controls_section();
        $this->add_image_overlay_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass   = 'nekit-categories-collection-wrap';
        $elementClass   .= esc_attr(" skin--" . $settings['widget_skin']);
        $widget_column = ( isset( $settings['widget_column'] ) ) ? $settings['widget_column']: 4;
		$widget_column_tablet = ( isset( $settings['widget_column_tablet'] ) ) ? $settings['widget_column_tablet']: 3;
		$widget_column_mobile = ( isset( $settings['widget_column_mobile'] ) ) ? $settings['widget_column_mobile']: 1;
        $elementClass .= ' desktop-column--' . nekit_convert_number_to_numeric_string($widget_column);
        $elementClass .= ' tablet-column--' . nekit_convert_number_to_numeric_string($widget_column_tablet);
        $elementClass .= ' mobile-column--' . nekit_convert_number_to_numeric_string($widget_column_mobile);
        $elementClass .= ( $settings['show_carousel'] == 'yes' ) ? " carousel-active" : " carousel-disabled";
        $elementClass .= ( $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( ' arrow-on-hover--on' ) : esc_attr( ' arrow-on-hover--off' );
        $elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
        $image_hover_animation = '';
        if( $settings['image_hover_animation'] ) $image_hover_animation = 'elementor-animation-' . $settings['image_hover_animation'];
        $this->add_render_attribute( 'image_hover', 'class', $image_hover_animation );
        $badge_classes = esc_attr( " badge-position--" . $settings['badges_position'] );
        $badges_items = $settings['badges_items'];
        $prev_arrow = isset($settings['slider_prev_icon'] ) ? ($settings['slider_prev_icon'])['value'] : '';
        $next_arrow = isset($settings['slider_next_icon'] ) ? ($settings['slider_next_icon'])['value'] : '';
        if($settings['badge_before_after'] == 'after'):
            if( isset( $badges_items[1] ) ) {
                $temp = $badges_items[0];
                $badges_items[0] = $badges_items[1];
                $badges_items[1]= $temp;
            }
        endif;
        $custom_taxonomies = is_array( $settings['post_custom_taxonomies'] ) ? $settings['post_custom_taxonomies'] : [];
        $categories_include = is_array( $settings['categories_include'] ) ? $settings['categories_include'] : [];

        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-arrows="<?php echo esc_attr( wp_json_encode( $settings['show_arrows'] == 'yes' ) ); ?>" data-autoplay="<?php echo esc_attr( wp_json_encode( $settings['enable_autoplay'] == 'yes' ) ); ?>" data-autoplayspeed="<?php echo esc_attr( wp_json_encode( $settings['autoplay_speed'] == 'yes' ) ); ?>" data-fade="<?php echo esc_attr( wp_json_encode( $settings['show_fade'] == 'yes' ) ); ?>" data-infinite="<?php echo esc_attr( wp_json_encode( $settings['show_infinite'] == 'yes' ) ); ?>" data-speed="<?php echo esc_attr( $settings['carousel_speed'] ); ?>" data-slidestoshow = "<?php echo absint($widget_column); ?>" data-prev="<?php echo esc_attr( $prev_arrow ); ?>" data-next="<?php echo esc_attr( $next_arrow )?>" data-mobile="<?php echo esc_attr( $widget_column_mobile ); ?>" data-tablet="<?php echo esc_attr( $widget_column_tablet ); ?>">
            <?php
                $cc_args = [
                    'taxonomy'  => $custom_taxonomies
                ];
                if( empty( $categories_include ) ) $cc_args['number'] = 3;
                if( $categories_include ) $cc_args['include'] = $categories_include;
                if( $settings['categories_hide_empty'] != 'yes' ) $cc_args['hide_empty'] = ( $settings['categories_hide_empty'] == 'yes' );
                $cc_query = get_terms($cc_args);
                foreach( $cc_query as $category ):
                    $cc_post_query = new \WP_Query([
                        'cat'   =>  absint( $category->term_id ),
                        'posts_per_page'    => 1,
                        'orderby'   => 'rand',
                        'meta_query'    => [
                            [
                                'key' => '_thumbnail_id',
                                'compare' => 'EXISTS'
                            ]
                        ],
                        'ignore_sticky_posts'   => true
                    ]);
                    if( $cc_post_query->have_posts() ) $thumbnail_post_id = $cc_post_query->posts[0]->ID;
                ?>
                    <div class="nekit-item-box-wrap post-item">
                        <div class="sole-category">
                                <?php if( $settings['show_thumbnail'] == 'yes' ): ?>
                                    <figure class="category-thumb">
                                        <a href="<?php echo esc_url( get_term_link($category->term_id) ); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?>>
                                            <div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                                <?php
                                                    if( isset( $thumbnail_post_id ) ) :
                                                        echo get_the_post_thumbnail( $thumbnail_post_id, esc_html( $settings['image_size'] ), [
                                                            'title' => esc_attr($category->name)
                                                        ]);
                                                    endif;
                                                ?>
                                            </div>
                                        </a>
                                        <?php
                                            if( $settings['show_badges'] == 'yes' && count($badges_items) > 0 ):
                                        ?>
                                                <div class="badges-wrap <?php echo esc_attr( $badge_classes ); ?>">
                                                    <?php
                                                        foreach( $badges_items as $badges ):
                                                            switch( $badges ): 
                                                                case 'title': ?>
                                                                    <h2 class="badge-item badge-title">
                                                                        <a href="<?php echo esc_url( get_term_link($category->term_id) ); ?>"><?php echo esc_html( $category->name ); ?></a>
                                                                    </h2>
                                                                <?php break;
                                                                case 'count': ?>
                                                                    <span class="badge-item badge-count"><?php echo absint( $category->count ); ?></span>
                                                                <?php break;
                                                            endswitch;
                                                        endforeach;
                                                    ?>
                                                </div>
                                        <?php
                                            endif;
                                        ?>
                                    </figure>
                                <?php endif; ?>
                                <div class="content-wrap">
                                    <?php
                                        $elements_sorting = isset( $settings['elements_sorting'] ) ? $settings['elements_sorting'] : [ 'title-meta', 'description' ];
                                        foreach( $elements_sorting as $sorting ) :
                                            switch( $sorting ): 
                                                case 'title-meta': ?>
                                                    <div class="category-title-count-wrap">
                                                    <?php
                                                        if( $settings['show_title'] == 'yes' && ( $settings['title_before_after'] == 'before' ) ) :
                                                                echo "<" .esc_html( $settings['title_html_tag'] ). ' class="category-title" title=' . esc_attr( $category->name ) . '>';
                                                            ?>
                                                                    <a href="<?php echo esc_url( get_term_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
                                                            <?php
                                                                echo "</" . esc_html( $settings['title_html_tag'] ) . ">";
                                                        endif; 

                                                        if( $settings['show_count'] == 'yes' ):
                                                    ?>
                                                            <span class="category-count"><?php echo absint( $category->count ); ?></span>
                                                    <?php
                                                        endif; 

                                                        if( $settings['show_title'] == 'yes' && $settings['title_before_after'] == 'after'):
                                                            echo "<" .esc_html( $settings['title_html_tag'] ). ' class="category-title" title=' . esc_attr($category->name) . '>';
                                                    ?>
                                                                <a href="<?php echo esc_url( get_term_link($category->term_id) ); ?>"><?php echo esc_html($category->name); ?></a>
                                                    <?php 
                                                            echo "</" . esc_html( $settings['title_html_tag'] ) . ">";
                                                        endif;
                                                    ?>
                                                    </div>
                                                <?php break; 
                                                case 'description': 
                                                    if( $settings['show_description'] == 'yes' ): ?>
                                                        <div class="category-description">
                                                            <?php
                                                                if( ! empty( $category->description ) && isset( $settings['description_length'] ) ) {
                                                                    echo esc_html( wp_trim_words($category->description, $settings['description_length']) );
                                                                } else {
                                                                    echo esc_html( $category->description );
                                                                }
                                                            ?>
                                                        </div>
                                                    <?php endif;
                                                break;
                                            endswitch;
                                        endforeach;
                                    ?>
                                </div>
                        </div>
                    </div>
                <?php  endforeach;
            ?>
        </div>
    <?php }
}