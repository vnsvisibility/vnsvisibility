<?php
/**
 * News List Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class List_Module extends \Nekit_Widget_Base\Base {
    public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}
	
    public function get_keywords() {
		return [ 'news', 'list' ];
	}

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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/news-list-'.$this::$widget_count.'" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
        $this->insert_divider();
		$this->add_layouts_skin_control();

		$this->add_responsive_control(
			'widget_column',
			[
				'label' => esc_html__( 'No of columns', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => nekit_get_widgets_column_max(),
				'step' => 1,
				'default' => 2
			]
		);

		$this->add_control(
			'adjust_as_grid_on_smaller_screen',
			[
				'label'	=>	esc_html__( 'Adjust as grid on smaller screen', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'ON', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'OFF', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no'
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
				'label' => esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
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
		
		$this->add_control(
			'show_post_thumbnail',
			[
				'label' => esc_html__( 'Show Post Thumbnail Image', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

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
			'show_post_excerpt',
			[
				'label' => esc_html__( 'Show Post Excerpt', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_post_excerpt_length',
			[
				'label' => esc_html__( 'Excerpt length', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'It counts the number of words', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'condition' =>  apply_filters( 'nekit_widget_post_excerpt_condition_filter', [
                    'show_post_excerpt' =>  'pro'
                ])
			]
		);

		$this->add_control(
			'show_post_button',
			[
				'label' => esc_html__( 'Show Read More', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'post_button_text',
			[
				'label' => esc_html__( 'Button Text', 'news-kit-elementor-addons' ),
				'default' => esc_html__( 'Read more', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add read more button text . .', 'news-kit-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block'	=> false,
				'skin'	=> 'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-right','angle-left','angle-double-right','angle-double-left','caret-right','caret-left','chevron-right','chevron-left','hand-point-right','hand-point-left','arrow-right','arrow-left','arrow-circle-right','arrow-alt-circle-right','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-right','hand-point-left','arrow-alt-circle-right','arrow-alt-circle-left']
				],
				'default' => [
					'value' => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
                'condition' =>  apply_filters( 'nekit_widget_post_button_condition_filter', [
                    'show_post_button' =>  'pro'
                ])
			]
		);
		
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
				'default' => 'left',
				'toggle' => false,
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .post-element' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->insert_divider();
		$this->add_control(
			'posts_elements_sorting',
			[
				'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'sortable-control',
				'default'	=> ['post-title', 'post-meta', 'post-excerpt', 'post-button'],
				'options'	=> array(
					'post-title'	=> array(
						'label'	=> esc_html__( 'Post Title', 'news-kit-elementor-addons' )
					),
					'post-meta'	=> array(
						'label'	=> esc_html__( 'Author / Date / Comments', 'news-kit-elementor-addons' )
					),
					'post-excerpt'	=> array(
						'label'	=> esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' )
					),
					'post-button'	=> array(
						'label'	=> esc_html__( 'Post Button', 'news-kit-elementor-addons' )
					)
				),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'post_elements_align' => 'pro'
                ])
			]
		);

		$this->insert_divider();
		$this->add_control(
			'posts_block_sorting_heading',
			[
				'label' => esc_html__( 'Block Sorting', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);
		
		$this->add_control(
			'posts_block_sorting',
			[
				'label' => esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'sortable-control',
				'default'	=> ['post-thumbnail', 'post-elements'],
				'options'	=> array(
					'post-thumbnail'	=> array(
						'label'	=> esc_html__( 'Thumbnail', 'news-kit-elementor-addons' )
					),
					'post-elements'	=> array(
						'label'	=> esc_html__( 'Post Elements', 'news-kit-elementor-addons' )
					)
				)
			]
		);
		$this->end_controls_section();
		apply_filters( 'nekit_widget_pagination_section_filter', $this );
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
			'image_width',
			[
				'label' => esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
						'step' => 1
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 30
				],
				'selectors' => [
					'{{WRAPPER}} article .post-thumb-wrap' => 'width: {{SIZE}}%;'
				]
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
					'size' => .2,
				],
				'selectors' => [
					'{{WRAPPER}} .post-thumb-wrap' => 'padding-bottom: calc( {{SIZE}} * 100% );',
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
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-list-widget .news-list-post-wrap' => 'column-gap: {{SIZE}}{{UNIT}};'
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
					'{{WRAPPER}} .nekit-list-widget .news-list-post-wrap' => 'row-gap: {{SIZE}}{{UNIT}};'
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
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_title_typography',
					'selector' => '{{WRAPPER}} .post-title',
				]
			);

			$this->start_controls_tabs(
				'post_title_style_tabs'
			);
			$this->start_controls_tab(
				'post_title_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_title_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'{{WRAPPER}} .post-title a' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
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
					'selector'  =>  '{{WRAPPER}} .post-title a, {{WRAPPER}} .nekit-news-list-two-posts-wrap .post-title',
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
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_category_typography',
					'selector' => '{{WRAPPER}} .post-categories li a'
				]
			);

			$this->start_controls_tabs(
				'post_category_style_tabs'
			);
			$this->start_controls_tab(
				'post_category_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_category_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-categories li a' => 'color: {{VALUE}}'
					]
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
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_category_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-categories li a:hover' => 'color: {{VALUE}}'
					]
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
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_author_typography',
					'selector' => '{{WRAPPER}} .author-context, {{WRAPPER}} .post-author'
				]
			);

			$this->start_controls_tabs(
				'post_author_style_tabs'
			);
			$this->start_controls_tab(
				'post_author_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'post_author_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .author-context, {{WRAPPER}} .post-author' => 'color: {{VALUE}}'
					]
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
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
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
						'{{WRAPPER}} .published-date-context, {{WRAPPER}} .post-published-date' => 'color: {{VALUE}}',
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
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
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
						'{{WRAPPER}} .post-comments-context, {{WRAPPER}} .post-comments' => 'color: {{VALUE}}',
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
			'post_excerpt_section_typography',
			[
				'label' => esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_excerpt_typography',
					'selector' => '{{WRAPPER}} .post-excerpt',
				]
			);
		
			$this->add_control(
				'post_excerpt_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-excerpt' => 'color: {{VALUE}}',
					],
				]
			);
			$this->insert_divider();

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'post_excerpt_background_color',
					'selector'  =>  '{{WRAPPER}} .post-excerpt',
					'exclude'   =>  ['image']
				]
			);

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
					'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
					'label_block'   =>  true,
					'selectors' =>  [
						'{{WRAPPER}} .post-excerpt'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_button_section_typography',
			[
				'label' => esc_html__( 'Post Button', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'post_button_typography',
					'selector' => '{{WRAPPER}} .post-link-button',
				]
			);

			$this->start_controls_tabs(
				'post_button_style_tabs'
			);
			$this->start_controls_tab(
				'post_button_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_button_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-link-button, {{WRAPPER}} .post-link-button i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'post_button_background',
					'selector' 	=> '{{WRAPPER}} .post-link-button',
					'exclude'   =>  ['image']
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'post_button_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'post_button_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-link-button:hover, {{WRAPPER}} .post-link-button:hover i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'post_button_background_hover',
					'selector' 	=> '{{WRAPPER}} .post-link-button:hover',
					'exclude'   =>  ['image']
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'post_button_border',
					'selector' => '{{WRAPPER}} .post-link-button',
				]
			);

			$this->add_control(
                'post_button_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-link-button' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

			$this->insert_divider();

			$this->add_control(
				'post_button_padding',
				[
					'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} .post-link-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'post_button_margin',
				[
					'label' => esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} .post-link-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
		apply_filters( 'nekit_widget_pagination_style_section_filter', $this );
		$this->add_image_overlay_section();
	}

    protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['widget_count'] = esc_html( $this::$widget_count );
        $elementClass = 'nekit-news-list-' .esc_attr( $this::$widget_count ). '-posts-wrap nekit-list-widget nekit-widget-section';
		$elementClass .= ' skin--' . $settings['widget_skin'];
		if( $settings['show_post_thumbnail'] != 'yes' ) $elementClass .= ' section-no-thumbnail';
		$elementClass .= ' layout--' . $this::$widget_count;
		$elementClass .= ' post-block-order--' . implode( '-', $settings['posts_block_sorting'] );
		$elementClass .= ( $settings['adjust_as_grid_on_smaller_screen'] == 'yes' ) ? ' adjust-layout--on' : ' adjust-layout--off';
		$elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
		$elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
		$this->add_render_attribute( 'image_hover', 'class', $imageClass );
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
		$this->add_render_attribute( 'title_hover', 'class', $titleClass );

        $widget_column_tablet = isset( $settings['widget_column_tablet'] ) ? $settings['widget_column_tablet'] : 2;
        $widget_column_mobile = isset( $settings['widget_column_mobile'] ) ? $settings['widget_column_mobile'] : 1;
		?>
			<div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<div class="news-list-post-wrap<?php echo esc_attr( ' column--' . nekit_convert_number_to_numeric_string($settings['widget_column']) ); ?> <?php echo esc_attr( ' column-tablet--' . nekit_convert_number_to_numeric_string($widget_column_tablet) ); ?> <?php echo esc_attr( ' column-mobile--' . nekit_convert_number_to_numeric_string($widget_column_mobile) ); ?>">
					<?php
						$posts_args = $this->get_posts_args_for_query();
						$post_query = new \WP_Query($posts_args);
						if( $post_query->have_posts() ) :
							$settings['maxPage'] = $post_query->max_num_pages;
							while( $post_query->have_posts() ) : $post_query->the_post();
								?>
									<article class="post-item list-item paged-1 <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
										<div class="nekit-item-box-wrap">
											<?php if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
												<figure class="post-thumb-wrap">
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?>>
														<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
															<?php if( has_post_thumbnail() ) { 
																	the_post_thumbnail($settings['image_size'], array(
																		'title' => the_title_attribute(array(
																			'echo'  => false
																		))
																	));
																}
															?>
														</div>
													</a>
													<?php if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
												</figure>
											<?php endif; ?>
											<div class="post-element">
												<?php
													$posts_elements_sorting = isset( $settings['posts_elements_sorting'] ) ? $settings['posts_elements_sorting'] :['post-title', 'post-meta', 'post-excerpt', 'post-button'];
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
															case 'post-excerpt' : 
																				if( $settings['show_post_excerpt'] == 'yes' ) : 
																					nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																				endif;
																				break;
															case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																					<a class="post-link-button" href="<?php the_permalink() ?>">
																						<?php echo esc_html( $settings['post_button_text'] ); ?>
																						<?php
																							echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $settings['post_button_icon'] ) ? $settings['post_button_icon'] : [
																								'value' => 'fas fa-angle-right',
																								'library'   =>  'fa-solid'
																							]));
																						?>
																					</a>
																				<?php
																				endif;
																				break;
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
				<?php
					$pagination_type = isset( $settings['pagination_type'] ) ? apply_filters( 'nekit_widget_pagination_get_setting_filter', 'none', $settings['pagination_type'] ) : 'none';
					if( $pagination_type != 'none' ) :
						echo '<div class="nekit-widget-pagination ' .esc_attr( 'type--' . $pagination_type ). '">';
							switch( $pagination_type ) {
								case 'replace': 
									?>
										<div class="button-wrap">
											<button class="pagination-button prev-button nekit-load-more" disabled>
												<?php
													if( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]) );
													echo esc_attr( $settings["replace_pagination__prev_text"] );
												?>
											</button>
											<button class="pagination-button next-button nekit-load-more">
												<?php
													echo esc_attr( $settings["replace_pagination__next_text"] );
													if( nekit_get_base_value(['icon' => $settings['replace_pagination__next_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['replace_pagination__next_icon']]) );
												?>
											</button>
										</div>
									<?php
											break;
								case 'append':
											echo '<button class="nekit-load-more ajax-load">' .esc_html( $settings["append_pagination_button_text"] );
												if( nekit_get_base_value(['icon' => $settings['append_pagination_button_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['append_pagination_button_icon']]) );
											echo '</button>';
										break;
							}
						echo '</div>';
					endif;
				?>
				<script>
					nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode( $settings ); ?>;
				</script>
			</div>
		<?php
	}
}