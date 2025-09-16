<?php
/**
 * Full Width Banner Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Full_Width_Banner_Module extends \Nekit_Widget_Base\Base {
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/full-width-banner" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'content_type',
            [
                'label' =>  esc_html__( 'Content Type', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'posts',
                'options'   =>  [
                    'posts'  =>  [
                        'title' =>  esc_html__( 'Posts', 'news-kit-elementor-addons' ),
                    ],
                    'pages'  =>  [
                        'title' =>  esc_html__( 'Pages', 'news-kit-elementor-addons' ),
                    ],
                    'custom'  =>  [
                        'title' =>  esc_html__( 'Custom', 'news-kit-elementor-addons' )
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label' =>  esc_html__( 'Content Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  [ '%', 'px' ],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  100
                ],
                'tablet_default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  100
                ],
                'mobile_default'   =>  [
                    'unit'  =>  '%',
                    'size'  =>  100
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap .post-elements'  =>  'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'content_type_text_field',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT                    
            ]
        );

        $repeater->add_control(
            'content_type_custom_image_field',
            [
                'label' =>  esc_html__( 'Image', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::MEDIA,
                'default'   =>  [
                    'url'   =>  \Elementor\Utils::get_placeholder_image_src()
                ]
            ]
        );

        $repeater->add_control(
            'content_type_custom_description_field',
            [
                'label' =>  esc_html__( 'Description', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXTAREA,
                'rows'  =>  10,
                'placeholder'   =>  esc_html__( 'Type your description here', 'news-kit-elementor-addons' )
            ]
        );

        $repeater->add_control(
            'content_type_custom_url',
            [
                'label' =>  esc_html__( 'Custom Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::URL,
                'options'   =>  [ 'url','is_external' ],
                'default'   =>  [
                    'url'   =>  '',
                    'is_external'   =>  true
                ],
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'content_type_custom_repeater',
            [
                'label' =>  esc_html__( 'list', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::REPEATER,
                'fields'    =>  $repeater->get_controls(),
                'title_field'  =>  '{{{content_type_text_field}}}',
                'condition' =>  [
                    'content_type'  => 'custom'
                ],
                'default'   =>  [
                    [
                        'content_type_text_field'   =>  esc_html__( 'Banner One', 'news-kit-elementor-addons' )
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'slider_post_query',
            [
                'label' =>  esc_html__( 'Slider Post Query', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' =>  [
                    'content_type'  =>  'posts'
                ]
            ]
        );

        $this->add_post_type_select_control();
		$this->add_taxonomy_select_control( 'post_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
        
        $this->add_post_order_select_control();
        $this->add_control(
            'post_count',
            [
                'label' =>  esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  nekit_get_widgets_post_count_max( $this->widget_name ),
                'step'  =>  1,
                'default'   =>  4
            ]
        );
        $this->add_authors_select_control();
        $this->add_categories_select_control( 'post_categories', [
			'dependency'	=>	'post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'post_tags', [
			'conditions'	=>	[
				'terms'	=>	[
                    [
                        'name'	=>	'post_custom_post_types',
                        'operator'	=>	'contains',
                        'value'	=>	'post'
                    ]
                ]
			]
		]);
        $this->add_posts_include_select_control( 'post_to_include', 'post', 'Posts', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
        $this->add_control(
            'post_offset',
            [
                'label' =>  esc_html__( 'Offset', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  100,
                'step'  =>  1,
                'default'   =>  0,
                'description'   =>  esc_html__( 'Number of posts to displace or pass over.', 'news-kit-elementor-addons' )
            ]
        );
		$this->add_posts_exclude_select_control( 'post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
                    [
                        'name'	=>	'post_custom_post_types',
                        'operator'	=>	'!=',
                        'value'	=>	''
                    ]
                ]
			]
		]);
        $this->add_control(
            'post_hide_post_without_thumbnail',
            [
                'label' =>  esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'page_query',
            [
                'label' =>  esc_html__( 'Slider Page Query', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' =>  [
                    'content_type'  =>  'pages'
                ]
            ]
        );

        $this->add_control(
            'pages_post_order',
            [
                'label' =>  esc_html__( 'Pages Order', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'date-desc',
                'options'   =>  nekit_get_widgets_post_order_options_array(),
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'pages_per_post',
            [
                'label' =>  esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  20,
                'step'  =>  1,
                'default'   =>  5
            ]
        );

        $this->add_authors_select_control( $name = 'pages_author', $label = 'Page');

        $this->add_posts_include_select_control( $name = 'pages_to_include', $query_slug = 'page', $label = esc_html__( 'Pages', 'news-kit-elementor-addons' ) );

        $this->add_control(
            'pages_offset',
            [
                'label' =>  esc_html__( 'Offset', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  20,
                'step'  =>  1,
                'default'   =>  0
            ]
        );
        
        $this->add_posts_exclude_select_control( $name = 'pages_to_exclude', $query_slug = 'page', $label = esc_html__( 'Pages', 'news-kit-elementor-addons' ) );

        $this->add_control(
            'page_hide_featured_image',
            [
                'label' =>  esc_html__( 'Hide Pages with no Featured Image', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),  
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),  
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_post_elements_settings',
            [
                'label' =>  esc_html__( 'Slider Post Elements Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_post_title',
            [
                'label' =>  esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_post_categories',
            [
                'label' =>  esc_html__( 'Show Post Categories', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes',
                'condition' =>  [
                    'content_type'  =>  'posts'
                ]
            ]
        );

        $this->add_post_element_date_control();

        $this->add_control(
            'show_post_excerpt',
            [
                'label' =>  esc_html__( 'Show Post Excerpt', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'slider_excerpt_length',
            [
                'label' =>  esc_html__( 'Excerpt Length', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  5,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  10,
                'description'   =>  esc_html__( 'It counts the number of words', 'news-kit-elementor-addons' ),
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'position',
            [
                'label' =>  esc_html__( 'Vertical Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'center',
                'options'   =>  [
                    'right'  =>  [
                        'title' =>  esc_html__( 'Top', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-top'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Middle', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-middle'
                    ],
                    'left'  =>  [
                        'title' =>  esc_html__( 'bottom', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-bottom'
                    ]
                ],
                'toggle'    =>  false,
            ]
        );

        $this->add_responsive_control(
            'horizontal_distance',
            [
                'label' =>  esc_html__( 'Horizontal Distance', 'news-kit-elementor-addons' ),
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
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--center .post-elements'  =>  'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'position'   =>  'center',
                ]
            ]
        );

        $this->add_responsive_control(
            'vertical_distance',
            [
                'label' =>  esc_html__( 'Vertical Distance', 'news-kit-elementor-addons' ),
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
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--center .post-elements'    =>  'top: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'position'   =>  'center',
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
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--left .post-elements'    =>  'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'position'   =>  'left',
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
                    'size' => 0
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--right .post-elements'    =>  'right: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'position'   =>  'right',
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
                    'size'  =>  0
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--right .post-item .post-elements'    =>  'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .nekit-full-width-banner-wrap.position--left .post-item .post-elements'    =>  'bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' =>  [
                    'position!'   =>  'center',
                ]
            ]
        );

        $this->add_control(
            'slider_elements_alignment',
            [
                'label' =>  esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
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
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap .post-elements' =>  'text-align:{{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'slider_post_elements_sorting',
            [
                'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
                'type'  =>  'sortable-control',
                'default'   =>  [ 'post-meta','post-title','post-excerpt' ],
                'options'   =>  [
                    'post-title'    =>  [
                        'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
                    ],
                    'post-meta'    =>  [
                        'label' =>  esc_html__( 'Categories / Date', 'news-kit-elementor-addons' ),
                    ],
                    'post-excerpt'    =>  [
                        'label' =>  esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' ),
                    ]
                ],
                'label_block'   =>  true,
                'separator' => 'before',
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_settings',
            [
                'label' =>  esc_html__( 'Slider Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'slider_settings_arrows',
            [
                'label' =>  esc_html__( 'Arrows', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'previous_arrow',
            [
                'label' =>  esc_html__( 'Previous Arrow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'default'   =>  [
                    'value' =>  'fas fa-angle-left',
                    'library'   =>  'fa-solid'
                ],
                'recommended'   => [
                    'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
                    'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
                ],
                'label_block'   =>  false,
                'condition' =>  [
                    'slider_settings_arrows'    =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'next_arrow',
            [
                'label' =>  esc_html__( 'Next Arrow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'skin'  =>  'inline',
                'default'   =>  [
                    'value' =>  'fas fa-angle-right',
                    'library'   =>  'fa-solid'
                ],
                'recommended'   => [
                    'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
                    'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
                ],
                'label_block'   =>  false,
                'condition' =>  [
                    'slider_settings_arrows'    =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'slider_settings_autoplay',
            [
                'label' =>  esc_html__( 'Autoplay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'slider_settings_autoplay_speed',
            [
                'label' =>  esc_html__( 'Autoplay Speed', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1000,
                'max'   =>  50000,
                'step'  =>  100,
                'default'   =>  3000,
                'description'   =>  esc_html__( 'Speed of Autoplay in milliseconds', 'news-kit-elementor-addons' ),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'slider_settings_speed',
            [
                'label' =>  esc_html__( 'Speed', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  100,
                'max'   =>  10000,
                'step'  =>  100,
                'default'   =>  500,
                'description'   =>  esc_html__( 'Slide / Fade animation speed', 'news-kit-elementor-addons' ),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'slider_settings_fade',
            [
                'label' =>  esc_html__( 'Fade', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );

        $this->add_control(
            'slider_settings_infinite',
            [
                'label' =>  esc_html__( 'Infinite Loop', 'news-kit-elementor-addons' ),
                'description'   =>  esc_html__( 'Repeats the slide items', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes',
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
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
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
			]
		);
        $this->insert_divider();
        $this->add_control(
            'slider_settings_centermode',
            [
                'label' =>  esc_html__( 'Center Mode', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'ON', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'OFF', 'news-kit-elementor-addons' ),
                'default'   =>  'no',
                'return_value'  =>  'yes',
                'description'   =>  esc_html__( 'Enables centered view with partial prev/next slides.', 'news-kit-elementor-addons' ),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_elements_alignment' => 'pro'
                ])
            ]
        );

        $this->add_responsive_control(
            'slider_settings_center_padding',
            [
                'label' =>  esc_html__( 'Center Padding(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  100,
                'condition' =>  [
                    'slider_settings_centermode'    =>  'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_settings_item_gap',
            [
                'label' =>  esc_html__( 'Item Gap', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .slick-track'  =>  'gap: {{VALUE}}px'
                ],
                'description'   =>  esc_html__( 'Gap between two slides in center mode', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'slider_settings_centermode'    =>  'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'animation_section',
            [
                'label' =>  esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->post_title_animation_type_control();
        $this->add_control(
            'image_hover_animation',
            [
                'label' =>  esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HOVER_ANIMATION
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'image_size_settings',
            [
                'label' =>  esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'slider_image_sizes',
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
                    'size' => 0.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap .post-featured-image' => 'padding-bottom: calc( {{SIZE}} * 100% );',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-item'
            ]
        );

        $this->add_responsive_control(
            'slider_image_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-item'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .post-item'
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
        $this->general_styles_primary_color_control();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_post_title',
            [
                'label' =>  esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'style_post_title_typography',
                'selector' =>  '{{WRAPPER}} .post-title'
            ]
        );

        $this->start_controls_tabs(
            'post_title_tabs'
        );
            $this->start_controls_tab(
                'post_title_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'post_title_initial_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title a' =>  'color:{{VALUE}}'
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'post_title_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'post_title_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-title:hover a' =>  'color:{{VALUE}}'
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
                'types'  =>  ['classic','gradient'],
                'exclude'  => ['image'],
                'selector' =>  '{{WRAPPER}} .post-title a'
            ]
        );
        $this->add_responsive_control(
            'post_title_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-title a'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );
        
        $this->add_responsive_control(
            'post_title_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  20,
                    'right'   =>  0,
                    'bottom'   =>  0,
                    'left'   =>  0,
                    'unit'   =>  'px',
                    'isLinked'   =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-title'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'html_tags',
            [
                'label' =>  esc_html__( 'Title Html Tags', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'h2',
                'options'   =>  $this->get_html_tags(),
                'separator' => 'before'
            ]
        );
        $this->end_controls_section();
		
        $this->start_controls_section(
            'style_post_categories',
            [
                'label' =>  esc_html__( 'Post Cagetories', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                'condition' =>  [
                    'content_type'  =>  'posts'
                ]
            ]
        );
        
        $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'  =>  'style_post_categories_typography',
                    'selector' =>  '{{WRAPPER}} .post-categories li a'
                ]
        );

        $this->start_controls_tabs(
            'style_post_categories_tab'
        );
            $this->start_controls_tab(
                'style_post_categories_initial_tabs',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'post_categories_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories li a' =>  'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'style_post_categories_background_color',
                    'types'      =>  ['classic','gradient'],
                    'fields_options' => [
                        'background' => [
                            'default' => 'classic'
                        ],
                        'color' => [
                            'default' => '#333'
                        ]
                    ],
                    'exclude'   =>  ['image'],
                    'selector' =>  '{{WRAPPER}} .post-categories li a'
                ]
            );

            $this->add_control(
                'post_categories_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories li a' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'style_post_categories_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'style_post_categories_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories li a:hover' =>  'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'style_post_categories_background_hover_color',
                    'types'      =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector' =>  '{{WRAPPER}} .post-categories li a:hover'
                ]
            );

            $this->add_control(
                'post_categories_border_radius_hover',
                [
                    'label' =>  esc_html__( 'Hover Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-categories li a:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_responsive_control(
            'post_categories_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  3,
                    'right'   =>  7,
                    'bottom'   =>  3,
                    'left'   =>  7,
                    'unit'   =>  'px',
                    'isLinked'   =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-categories li a'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'post_categories_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  0,
                    'right'   =>  10,
                    'bottom'   =>  0,
                    'left'   =>  0,
                    'unit'   =>  'px',
                    'isLinked'   =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-categories li'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_post_date',
            [
                'label' =>  esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'style_post_date_typography_custom',
                'selector'  =>  '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date',
            ]
        );

        $this->start_controls_tabs(
            'post_date'
        );
            $this->start_controls_tab(
                'post_date_initial',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'post_date_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#ffffff',
                    'selectors' =>  [
                        '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date' =>  'color:{{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'full_width_banner_date_hover',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'post_date_color_hover_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .date-meta-wrap:hover .post-published-date'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_responsive_control(
                'post_date_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  ['px','%','em','custom'],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .date-meta-wrap'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

        $this->add_responsive_control(
            'post_date_margin',
            [
                'label' =>  esc_html__( 'Margin','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  0,
                    'right' =>  15,
                    'bottom'    =>   0,
                    'left'  =>  0,
                    'unit'  => 'px',
                    'isLinked'  =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .date-meta-wrap'    =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_post_excerpt',
            [
                'label' =>  esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'style_post_excerpt_typography',
                'selector'  =>  '{{WRAPPER}} .nekit-full-width-banner-wrap .post-excerpt span'
            ]
        );

        $this->add_control(
            'style_post_excerpt_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#ffffff',
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-full-width-banner-wrap .post-excerpt span' =>  'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'post_excerpt_background_color',
            [
                'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
                'type'=>\Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-excerpt' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->insert_divider();

        $this->add_responsive_control(
            'post_excerpt_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-excerpt'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'post_excerpt_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  15,
                    'right'   =>  0,
                    'bottom'   =>  0,
                    'left'   =>  0,
                    'unit'   =>  'px',
                    'isLinked'   =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-elements .post-excerpt'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_controls',
            [
                'label' =>  esc_html__( 'Slider Controls', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'slider_controls_padding',
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
                    '{{WRAPPER}} .slick-arrow' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ] 
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'slider_controls_color_heading',
            [
                'label' =>  esc_html__( 'Colors', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->start_controls_tabs(
            'slider_controls_tabs'
        );
            $this->start_controls_tab(
                'slider_controls_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'slider_controls_arrow_color',
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
                    'name'  =>  'slider_controls_initial_background_color',
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
                'slider_controls_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'slider_controls_arrows_hover_color',
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
                    'name'  =>  'slider_controls_arrows_hover_background_color',
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
            'slider_controls_box_shadow_heading',
            [
                'label' =>  esc_html__( 'Box Shadow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slider_controls_box_shadow',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);
        $this->insert_divider();
        $this->add_control(
            'slider_controls_border_settings_heading',
            [
                'label' =>  esc_html__( 'Border Settings', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'slider_controls_width',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);

        $this->add_control(
            'slider_controls_radius',
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
        $this->end_controls_section();
        $this->add_image_overlay_section();
    }

    function get_full_width_banner_html( $args ) {
    ?>
        <div class="post-item <?php echo esc_attr( $args['image_class'] ); if( ! $args['image_exists'] ) echo esc_attr( ' no-feat-img' ); ?>">            
            <figure class="post-featured-image post-thumb-wrap">
                <a href="<?php echo esc_attr( $args['link_url'] ); ?>" <?php echo wp_kses_post($args['image_class']); ?>>
                    <div class="post-thumb-parent<?php if( $args['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                        <?php 
                            if( $args['content_type'] == 'posts' || $args['content_type'] == 'pages' ):
                                if( $args['image_exists'] ):
                                    the_post_thumbnail( $args['slider_image_sizes'] );
                                endif;
                            else:
                                if( ! empty( $list_id ) ) :
                                    echo wp_get_attachment_image( $args['list_id'], $args['slider_image_sizes'], [
                                        'class' =>  esc_attr( $args['image_class'] )
                                    ]);
                                else: ?>
                                    <img src="<?php echo esc_url($args['post_thumb']); ?>">
                            <?php
                                endif;
                            endif;
                        ?>
                    </div>
                </a>
            </figure>
            <div class="post-elements">
                <?php
                    if( $args['slider_post_elements_sorting'] ) :
                        foreach( $args['slider_post_elements_sorting'] as $elements_sorting ) :
                            switch( $elements_sorting ) :
                                case "post-title" :
                                    if( $args['show_post_title'] == 'yes' ): 
                                        echo '<' . esc_html( $args['html_tags'] ) . ' ' . wp_kses_post( $args['title_class'] ) . '>'; ?>
                                            <a href="<?php echo esc_attr( $args['link_url'] ); ?>">
                                                <?php echo esc_html( $args['title'] ); ?>
                                            </a>
                                        <?php echo "</" . esc_html( $args['html_tags'] ) . ">";
                                    endif;
                                break; 
                                case "post-meta" :
                                ?>
                                    <div class="post-meta">
                                        <?php 
                                            if( $args['show_post_categories'] == 'yes' && ($args['content_type'] == 'posts') ) :
                                                nekit_get_post_categories(get_the_ID(),2);
                                            endif;
                                            if( $args['show_post_date'] == 'yes' ):
                                                echo wp_kses_post(nekit_get_posts_date([
                                                    'base'  =>  isset( $args['post_date_icon_position'] ) ? $args['post_date_icon_position'] : 'prefix',
                                                    'icon'  =>  isset( $args['post_date_icon'] ) ? $args['post_date_icon'] : [
                                                        'value' =>  'fas fa-calendar',
                                                        'library'   =>  'fa-solid'
                                                    ],
                                                    'url'   =>  'yes'
                                                ]));
                                            endif;
                                        ?>
                                    </div>
                            <?php 
                                break;
                                case "post-excerpt" :
                                    if( $args['show_post_excerpt'] == 'yes' && ! empty( $args['description'] ) ) :
                            ?>
                                        <div class="post-excerpt">
                                            <span class="excerpt-content">
                                                <?php echo esc_html(wp_trim_words($args['description'], $args['slider_excerpt_length']));?>
                                            </span>
                                        </div>
                            <?php
                                    endif;
                                break;
                            endswitch;
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-full-width-banner-wrap';
        $elementClass .= esc_attr(" position--".$settings['position']);
        $elementClass .= esc_attr(" position--".$settings['position']);
        $elementClass .= ( isset( $settings['slider_settings_centermode'] ) && $settings['slider_settings_centermode'] == 'yes' ) ? esc_attr( " center-mode--on" ) : esc_attr( " center-mode--off" ) ;
        $elementClass .= ( isset( $settings['show_slider_arrow_on_hover'] ) && $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( ' arrow-on-hover--on' ) : esc_attr( ' arrow-on-hover--off' );
        $autoplay = isset( $settings['slider_settings_autoplay'] ) ? $settings['slider_settings_autoplay'] : 'show';
        $fade = isset( $settings['slider_settings_fade'] ) ? $settings['slider_settings_fade']: 'no';
        $infinite = isset( $settings['slider_settings_infinite'] ) ? $settings['slider_settings_infinite']: 'no';
        $speed = isset( $settings['slider_settings_speed'] ) ? $settings['slider_settings_speed']: 500;
        $autoplaySpeed = isset( $settings['slider_settings_autoplay_speed'] ) ? $settings['slider_settings_autoplay_speed']: 3000;
        $imageClass = '';
        $titleClass = 'post-title';
        if( $settings['image_hover_animation'] ) $imageClass = esc_attr( "elementor-animation-" . $settings['image_hover_animation'] );
        $this->add_render_attribute( 'image_hover', 'class', $imageClass );
        if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );
        $this->add_render_attribute( 'wrapper','class',$elementClass );
    ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>
            data-arrow="<?php echo esc_attr(wp_json_encode($settings['slider_settings_arrows'] == 'yes')); ?>"
            data-autoplay = "<?php echo esc_attr(wp_json_encode($autoplay == 'yes')); ?>" 
            data-fade = "<?php echo esc_attr(wp_json_encode( $fade == 'yes' )); ?>" 
            data-infinite = "<?php echo esc_attr(wp_json_encode( $infinite == 'yes' )); ?>" 
            data-speed = "<?php echo esc_attr(absint($speed)); ?>" 
            data-autoplayspeed = "<?php echo esc_attr(absint($autoplaySpeed)); ?>"
            data-centermode = "<?php echo esc_attr( wp_json_encode( $settings['slider_settings_centermode'] == 'yes' ) ); ?>"
            data-centerpadding = "<?php echo esc_attr( absint( $settings['slider_settings_center_padding'] ) ); ?>"
            data-prevarrow = "<?php echo esc_attr( nekit_get_base_attribute_value( [ 'icon' => $settings['previous_arrow'] ] ) ); ?>"
            data-nextarrow = "<?php echo esc_attr( nekit_get_base_attribute_value( [ 'icon' => $settings['next_arrow'] ] ) ); ?>"
            >
            <?php
                if( $settings['content_type'] == 'posts' ) :
                    $posts_args = $this->get_posts_args_for_query();
                    $post_args = new \WP_Query( $posts_args );
                    if( $post_args->have_posts() ) :
                        while( $post_args->have_posts() ) :
                            $post_args->the_post(); 
                            $this->get_full_width_banner_html([
                                'image_class'   =>  $this->get_render_attribute_string( 'image_hover' ),
                                'link_url'  =>  get_the_permalink(),
                                'image_exists'  =>  has_post_thumbnail(),
                                'post_thumb'    =>  'the_post_thumbnail',  
                                'slider_image_sizes'    =>  $settings['slider_image_sizes'],
                                'slider_post_elements_sorting'  =>  isset( $settings['slider_post_elements_sorting'] ) ? $settings['slider_post_elements_sorting']: [ 'post-meta','post-title','post-excerpt' ],
                                'show_post_title'   => $settings['show_post_title'],
                                'html_tags' =>  $settings['html_tags'],
                                'title_class'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                'show_post_date'    =>  $settings['show_post_date'],
                                'show_post_categories'  =>  $settings['show_post_categories'],
                                'show_post_excerpt' =>   $settings['show_post_excerpt'],
                                'slider_excerpt_length' =>  $settings['slider_excerpt_length'],
                                'content_type'  =>  'posts',
                                'title' =>  get_the_title(),
                                'description'   =>  get_the_excerpt(),
                                'list_id'   =>  get_the_ID(),
                                'image_overlay_option'  =>  $settings['image_overlay_option'],
                                'post_date_icon_position'  =>  $settings['post_date_icon_position'],
                                'post_date_icon'  =>  $settings['post_date_icon']
                            ]);
                        endwhile;
                        wp_reset_postdata();
                    endif;
                endif;

                if( $settings['content_type'] == 'custom' ) :
                    if( $settings['content_type_custom_repeater'] ) :
                        foreach( $settings['content_type_custom_repeater'] as $repeater) :
                            $this->get_full_width_banner_html([
                                'image_class'   =>  $this->get_render_attribute_string( 'image_hover' ),
                                'link_url'  =>  $repeater['content_type_custom_url']['url'],
                                'image_exists'  =>  $repeater['content_type_custom_image_field'],
                                'post_thumb'    =>  $repeater['content_type_custom_image_field']['url'], 
                                'slider_image_sizes'    =>  $settings['slider_image_sizes'],
                                'slider_post_elements_sorting'  =>  isset( $settings['slider_post_elements_sorting'] ) ? $settings['slider_post_elements_sorting']: [ 'post-meta','post-title','post-excerpt' ],
                                'show_post_title'   => $settings['show_post_title'],
                                'html_tags' =>  $settings['html_tags'],
                                'title_class'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                'show_post_date'    =>  $settings['show_post_date'],
                                'show_post_categories'  =>  $settings['show_post_categories'],
                                'show_post_excerpt' =>   $settings['show_post_excerpt'],
                                'slider_excerpt_length' =>  $settings['slider_excerpt_length'],
                                'content_type'  =>  'custom',
                                'description'   =>  $repeater['content_type_custom_description_field'],
                                'title' =>  $repeater['content_type_text_field'],
                                'list_id'   =>  $repeater['content_type_custom_image_field']['id'],
                                'image_overlay_option'  =>  $settings['image_overlay_option'],
                                'post_date_icon_position'  =>  $settings['post_date_icon_position'],
                                'post_date_icon'  =>  $settings['post_date_icon']
                            ]);
                        endforeach;
                    endif;
                endif;

                if( $settings['content_type'] == 'pages' ) :
                    $slider_page_order_args =   explode( "-", $settings['pages_post_order']);
                    $slider_pages_args = [
                        'post_type' =>  'page',
                        'posts_per_page'    =>  absint( $settings['pages_per_post'] )
                    ];
                    if( $settings['pages_author'] ) $slider_pages_args['author'] = $settings['pages_author'];
                    if( $settings['pages_offset'] ) $slider_pages_args['offset'] = absint( $settings['pages_offset'] );
                    if( isset( $slider_page_order_args[1] ) ) $slider_pages_args['order'] = $slider_page_order_args[1];
                    if( isset( $slider_page_order_args[0] ) ) $slider_pages_args['order_by'] = $slider_page_order_args[0];
                    if( $settings['page_hide_featured_image'] == 'yes' ) {
                        $slider_pages_args['meta_query'] = [
                            [
                                'key'   =>  '_thumbnail_id',
                                'compare'   =>  'EXISTS'
                            ]
                        ];
                    }
                    if( $settings['pages_to_include'] ) $slider_pages_args['post__in'] = $settings['pages_to_include'];
                    if( $settings['pages_to_exclude'] ) $slider_pages_args['post__not_in'] = $settings['pages_to_exclude'];
                    $slider_pages = new \WP_Query( $slider_pages_args );
                    wp_reset_postdata();
                    if( $slider_pages->have_posts() ) :
                        while( $slider_pages->have_posts() ) :
                            $slider_pages->the_post();
                            $this->get_full_width_banner_html([
                                'image_class'   =>  $this->get_render_attribute_string( 'image_hover' ),
                                'link_url'  =>  get_the_permalink(),
                                'image_exists'  =>  has_post_thumbnail(),
                                'post_thumb'    =>  'the_post_thumbnail', 
                                'slider_image_sizes'    =>  $settings['slider_image_sizes'],
                                'slider_post_elements_sorting'  =>  isset( $settings['slider_post_elements_sorting'] ) ? $settings['slider_post_elements_sorting']: [ 'post-meta','post-title','post-excerpt' ],
                                'show_post_title'   => $settings['show_post_title'],
                                'html_tags' =>  $settings['html_tags'],
                                'title_class'   =>  $this->get_render_attribute_string( 'title_hover' ),
                                'show_post_date'    =>  $settings['show_post_date'],
                                'show_post_categories'  =>  $settings['show_post_categories'],
                                'show_post_excerpt' =>  $settings['show_post_excerpt'],
                                'slider_excerpt_length' =>  $settings['slider_excerpt_length'],
                                'content_type'  =>  'pages',
                                'title' =>  get_the_title(),
                                'description'   =>  get_the_excerpt(),
                                'list_id'   =>  get_the_ID(),
                                'image_overlay_option'  =>  $settings['image_overlay_option'],
                                'post_date_icon_position'  =>  $settings['post_date_icon_position'],
                                'post_date_icon'  =>  $settings['post_date_icon']
                            ]);                            
                        endwhile;
                        wp_reset_postdata();
                    endif;
                endif;
            ?>
        </div>
<?php
    }
}