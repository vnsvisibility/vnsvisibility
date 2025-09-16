<?php
/**
 * News Carousel Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Carousel_Module extends \Nekit_Widget_Base\Base {
    public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}
	
    public function get_keywords() {
		return [ 'news', 'carousel' ];
	}

    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/news-carousel-'.$this::$widget_count.'" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
		$this->insert_divider();
		$this->add_layouts_skin_control();
		$this->add_responsive_control(
			'widget_column',
			[
				'label'	=> esc_html__( 'No of columns', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::NUMBER,
				'min'	=> 1,
				'max'	=> nekit_get_widgets_column_max(),
				'step'	=> 1,
				'default'	=> 3
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'posts_query_section',
			[
				'label' => esc_html__( 'Posts Query', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'post_order',
			[
				'label'	=> esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default' => 'date-desc',
				'label_block'   => true,
				'options' => nekit_get_widgets_post_order_options_array()
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => nekit_get_widgets_post_count_max( $this->widget_name ),
				'step' => 1,
				'default' => 6,
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
			'dependency'	=>	'post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'post_custom_post_types',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
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
				'label' => esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0,
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
				'label' => esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'posts_elements_settings_section',
			[
				'label' => esc_html__( 'Post Elements Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		if( $this::$widget_count != 'two' ):
			$this->add_control(
				'show_post_thumbnail',
				[
					'label' => esc_html__( 'Show Post Thumbnail Image', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
					'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
					'return_value' => 'yes',
					'default' => 'yes'
				]
			);
		endif;
		
		$this->add_control(
			'show_post_categories',
			[
				'label' => esc_html__( 'Show Post Categories', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_post_title',
			[
				'label' => esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_post_element_date_control();
		$this->add_post_element_author_control();
		$this->add_post_element_comments_control();
		
		$this->add_control(
			'post_elements_align_heading',
			[
				'label' => esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_elements_align',
			[
				'label' => esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
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
				'toggle' => false,
				'default'	=>	'left',
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .post-element' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'posts_elements_sorting',
			[
				'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'sortable-control',
				'default'	=> ['post-categories', 'post-title', 'post-meta'],
				'options'	=> array(
					'post-categories'	=> array(
						'label'	=> esc_html__( 'Post Categories', 'news-kit-elementor-addons' )
					),
					'post-title'	=> array(
						'label'	=> esc_html__( 'Post Title', 'news-kit-elementor-addons' )
					),
					'post-meta'	=> array(
						'label'	=> esc_html__( 'Author / Date / Comments', 'news-kit-elementor-addons' )
					)
				),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'post_elements_align' => 'pro'
                ])
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'carousel_settings_section',
			[
				'label' => esc_html__( 'Carousel Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'carousel_auto',
			[
				'label' => esc_html__( 'Enable carousel to auto slide', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'carousel_arrows',
			[
				'label' => esc_html__( 'Show carousel arrow', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'carousel_loop',
			[
				'label' => esc_html__( 'Enable carousel loop', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'carousel_speed',
			[
				'label' => esc_html__( 'Carousel speed', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 50000,
				'step' => 100,
				'default' => 300
			]
		);
		$this->add_control(
			'carousel_fade',
			[
				'label' => esc_html__( 'Enable carousel Fade', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'description'	=>	esc_html__( 'Effect is seen only when no of columns is 1', 'news-kit-elementor-addons' )
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
				'return_value'	=>	'yes'
			]
		);
		$this->insert_divider();

		$this->add_control(
            'controller_prev_icon',
            [
                'label' =>  esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
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
            'controller_next_icon',
            [
                'label' =>  esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
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
			'carousel_icon_size',
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
			'animation_settings_section',
			[
				'label' => esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->post_title_animation_type_control();

		$this->add_control(
			'image_hover_animation',
			[
				'label' => esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'posts_image_settings_section',
			[
				'label' => esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
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
					'{{WRAPPER}} .news-carousel .post-thumb-wrap' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				]
			]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-thumb-wrap, {{WRAPPER}} .post-thumb'
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
                    '{{WRAPPER}} .post-thumb-wrap, {{WRAPPER}} .post-thumb'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
            'general_styles',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->general_styles_primary_color_control();

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
				'selectors' => [
					'{{WRAPPER}} .nekit-carousel-widget .slick-list' => 'margin-inline: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-carousel-widget .post-item' => 'padding: 2px {{SIZE}}{{UNIT}} 2px {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

		$this->add_card_skin_style_control();
		$this->start_controls_section(
			'post_title_section_typography',
			[
				'label' => esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
					'name' => 'post_title_typography',
					'fields_options' => [
						'typography' => [
							'default' => 'classic'
						],
						'font_size' => [
							'default' => [
								'unit' => 'px',
								'size' => 17
							]
						]
					],
					'selector' => '{{WRAPPER}} .post-title',
				]
			);

			$this->start_controls_tabs(
				'post_title_style_tabs'
			);
			$this->start_controls_tab(
				'post_title_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_title_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-title a' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_title_background_color',
					'selector'  =>  '{{WRAPPER}} .post-title a',
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
						'{{WRAPPER}} .post-title a'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_title_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .post-title'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_category_section_typography',
			[
				'label' => esc_html__( 'Post Categories', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_category_typography',
					'selector' => '{{WRAPPER}} .post-categories li a',
				]
			);

			$this->start_controls_tabs(
				'post_category_style_tabs'
			);
			$this->start_controls_tab(
				'post_category_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_category_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-categories li a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_category_background_color',
					'selector'  =>  '{{WRAPPER}} .post-categories li a',
					'exclude'   =>  ['image']
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
				'post_category_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_category_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-categories li a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_category_background_color_hover',
					'selector'  =>  '{{WRAPPER}} .post-categories li a:hover',
					'exclude'   =>  ['image']
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
				'post_category_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .post-categories li a'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_category_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'default' => [
						'top' => '0',
						'right' => '10',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => true
					],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .post-categories li'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_author_section_typography',
			[
				'label' => esc_html__( 'Post Author', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Post Author', 'news-kit-elementor-addons' ),
					'name' => 'post_author_typography',
					'selector' => '{{WRAPPER}} .author-context, {{WRAPPER}} .post-author',
				]
			);

			$this->start_controls_tabs(
				'post_author_style_tabs'
			);
			$this->start_controls_tab(
				'post_author_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_author_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .author-meta-wrap .author-context, {{WRAPPER}} .author-meta-wrap .post-author' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_author_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_author_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .author-meta-wrap:hover .author-context, {{WRAPPER}} .author-meta-wrap:hover .post-author' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_author_background_color',
					'selector'  =>  '{{WRAPPER}} .author-meta-wrap',
					'exclude'   =>  ['image']
				]
			);

			$this->add_responsive_control(
				'post_author_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .author-meta-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_author_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'default' => [
						'top' => '0',
						'right' => '15',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => true
					],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .author-meta-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_date_section_typography',
			[
				'label' => esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
					'name' => 'post_date_typography',
					'selector' => '{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date',
				]
			);

			$this->start_controls_tabs(
				'post_date_style_tabs'
			);
			$this->start_controls_tab(
				'post_date_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_date_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .date-meta-wrap .published-date-context, {{WRAPPER}} .date-meta-wrap .post-published-date' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_date_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_date_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}',
					],
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

		$this->start_controls_section(
			'post_comment_section_typography',
			[
				'label' => esc_html__( 'Post Comments', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Post Comments', 'news-kit-elementor-addons' ),
					'name' => 'post_comment_typography',
					'selector' => '{{WRAPPER}} .post-comments-context, {{WRAPPER}} .post-comments',
				]
			);

			$this->start_controls_tabs(
				'post_comment_style_tabs'
			);
			$this->start_controls_tab(
				'post_comment_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_comment_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comments-meta-wrap .post-comments-context, {{WRAPPER}} .comments-meta-wrap .post-comments' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_comment_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_comment_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comments-meta-wrap:hover .post-comments-context, {{WRAPPER}} .comments-meta-wrap:hover .post-comments' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_comment_background_color',
					'selector'  =>  '{{WRAPPER}} .comments-meta-wrap',
					'exclude'   =>  ['image']
				]
			);

			$this->add_responsive_control(
				'post_comment_padding',
				[
					'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .comments-meta-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'post_comment_margin',
				[
					'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .comments-meta-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'carousel_controls',
            [
                'label' =>  esc_html__( 'Carousel Controls', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

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
        $this->insert_divider();
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
            'carousel_control_box_shadow_heading',
            [
                'label' =>  esc_html__( 'Box Shadow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'carousel_control_box_shadow',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);
        $this->insert_divider();
        $this->add_control(
            'carousel_border_settings_heading',
            [
                'label' =>  esc_html__( 'Border Settings', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'carousel_control_width',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);

        $this->add_control(
            'carousel_control_radius',
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

    protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'nekit-news-carousel-' .esc_attr( $this::$widget_count ). '-posts-wrap nekit-carousel-widget nekit-widget-section';
		$elementClass .= ' skin--' . $settings['widget_skin'];
		if( isset( $settings['post_elements_align'] ) ) {
			$elementClass .= ' alignment--' . $settings['post_elements_align'];
		}
		$elementClass .= ( $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( ' arrow-on-hover--on' ) : esc_attr( ' arrow-on-hover--off' );
		$elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
		$this->add_render_attribute( 'title_hover', 'class', $titleClass );
		$this->add_render_attribute( 'image_hover', 'class', $imageClass );
		$widget_column = ( isset( $settings['widget_column'] ) ) ? $settings['widget_column']: 3;
		$widget_column_tablet = ( isset( $settings['widget_column_tablet'] ) ) ? $settings['widget_column_tablet']: 3;
		$widget_column_mobile = ( isset( $settings['widget_column_mobile'] ) ) ? $settings['widget_column_mobile']: 1;
		?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
                <div class="news-carousel layout--<?php echo esc_attr( $this::$widget_count ); ?><?php if( $settings['show_post_thumbnail'] != 'yes' ) echo ' section-no-thumbnail'; ?>">
                    <div class="news-carousel-post-wrap" data-loop="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_loop'] == 'yes' ) ); ?>" data-arrows="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_arrows'] == 'yes' ) ); ?>" data-auto="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_auto'] == 'yes' ) ); ?>" data-columns="<?php echo absint( $widget_column ); ?>" data-columns-tablet="<?php echo absint( $widget_column_tablet ); ?>" data-columns-mobile="<?php echo absint( $widget_column_mobile ); ?>" data-speed="<?php echo esc_attr( $settings['carousel_speed'] ); ?>" data-prev-icon="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon'	=> $settings['controller_prev_icon'] ]) ); ?>" data-next-icon="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon'	=> $settings['controller_next_icon'] ]) ); ?>" data-fade="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_fade'] == 'yes' ) ); ?>">
                        <?php
							$posts_args = $this->get_posts_args_for_query();
                            $post_query = new \WP_Query($posts_args);
                            if( $post_query->have_posts() ) :
                                while( $post_query->have_posts() ) : $post_query->the_post();
                                    ?>
                                        <article class="post-item carousel-item <?php if( ! has_post_thumbnail() ) { echo esc_attr('no-feat-img'); } ?>">
                                            <div class="nekit-item-box-wrap">
                                                <?php if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
                                                    <figure class="post-thumb-wrap">
                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?>>
															<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																<?php
																	if( has_post_thumbnail() ) { 
																		the_post_thumbnail($settings['image_size'], array(
																			'title' => the_title_attribute(array(
																				'echo'  => false
																			))
																		));
																	}
																?>
															</div>
                                                        </a>
                                                        <?php if( $settings['show_post_categories'] == 'yes' && $this::$widget_count == 'one' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
                                                    </figure>
                                                <?php endif; ?>
                                                <div class="post-element">
													<?php
														$posts_elements_sorting = isset( $settings['posts_elements_sorting'] ) ? $settings['posts_elements_sorting']: ['post-categories', 'post-title', 'post-meta'];
                                                        foreach( $posts_elements_sorting as $posts_element ) :
                                                            switch( $posts_element ) {
                                                                case 'post-title' : 
                                                                                    if( $settings['show_post_title'] == 'yes' ) :
                                                                                        ?>
                                                                                            <h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                                                                        <?php
                                                                                    endif;
                                                                                break;
                                                                case 'post-meta' : ?>
                                                                                    <div class="post-meta">
                                                                                        <?php
																							if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																								'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																								'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																									'value' =>  'far fa-user-circle',
																									'library'   =>  'fa-regular'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																								'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																									'value' =>  'fas fa-calendar',
																									'library'   =>  'fa-solid'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																								'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																									'value' =>  'far fa-comment',
																									'library'   =>  'fa-regular'
																								]
																							]));
																						?>
                                                                                    </div>
                                                                                    <?php
                                                                                break;
																case 'post-categories' : if( $settings['show_post_categories'] == 'yes' && $this::$widget_count == 'three' ) nekit_get_post_categories( get_the_ID(), 2 );
                                                            }
                                                        endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                        </article>
                                    <?php
                                endwhile;
								wp_reset_postdata();
                            endif;
                        ?>
                    </div>
                </div>
            </div>
		<?php
	}
}