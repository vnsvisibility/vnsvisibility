<?php
/**
 * Back To Top Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widget_Base;
use Nekit_Utilities\Utils as Nekit_Utils;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Base extends \Elementor\Widget_Base {
	private $divider = 0;
	public function get_name() {
		return $this->widget_name;
	}

    public function get_title() {
		return nekit_get_widgets_info( $this->widget_name )[ 'name' ];
	}

	public function get_icon() {
		return esc_attr( 'nekit-icon ' . nekit_get_widgets_info( $this->widget_name )[ 'icon' ] );
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	function add_layouts_skin_control() {
		$this->add_control(
			'widget_skin',
			[
				'label' => esc_html__( 'Skin', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SELECT,
                'default'   => 'classic',
				'options'   => [
                    'classic'   => esc_html__( 'Classic', 'news-kit-elementor-addons' ),
                    'card'  => esc_html__( 'Card', 'news-kit-elementor-addons' )
                ]
			]
		);
	}

	function get_item_orientation_control() {
		$this->add_control(
			'items_orientation',
			[
				'label' => esc_html__( 'Items Orientation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal'
					],
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-vertical'
					]
				],
				'default' => 'horizontal',
				'toggle' => false
			]
		);
	}

	function insert_divider() {
		$this->divider++;
		$this->add_control(
			$this->widget_name . $this->divider,
			[
				'type'	=>	\Elementor\Controls_Manager::DIVIDER
			]
		);
	}

	function add_post_order_select_control($name = 'post_order') {
		$this->add_control(
			$name,
			[
				'label' =>  esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SELECT,
				'default'   =>  'date-desc',
				'label_block'   =>  true,
				'options'   =>  nekit_get_widgets_post_order_options_array()
			]
		);
	}

	function add_authors_select_control( $name = 'post_authors' , $label = 'Post' ) {
		$this->add_control(
			$name,
			[
				'label'	=> esc_html( $label ) . esc_html__( ' authors', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_users',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
	}

	function add_post_type_select_control( $name = 'post_custom_post_types' , $label = 'Select Post Types' ) {
		$this->add_control(
			$name,
			[
				'label'	=> esc_html( $label ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'default'	=>	[ 'post' ],
				'options'	=> 'select2extend/get_custom_post_types',
				// 'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
	}

	function add_taxonomy_select_control( $name = 'post_custom_taxonomies' , $label = 'Select Taxonomies', $args = [] ) {
		$control_args = [
			'label'	=> esc_html( $label ),
			'label_block'	=> true,
			'multiple'	=> true,
			'type' => 'nekit-select2-extend',
			'default'	=>	[ 'category' ],
			'options'	=> 'select2extend/get_custom_taxonomies'
		];
		if( count( $args ) > 0 ) $control_args += $args;

		$this->add_control(
			$name,
			$control_args
		);
	}

	function add_categories_select_control( $name = 'post_categories', $args = [] ) {
		$control_args = [
			'label'	=> esc_html__( 'Post categories ( Terms to include )', 'news-kit-elementor-addons' ),
			'label_block'	=> true,
			'multiple'	=> true,
			'type' => 'nekit-select2-extend',
			'options'	=> 'select2extend/get_taxonomies',
			'query_slug'	=> 'category',
			'default'	=>	[],
		];

		if( count( $args ) > 0 ) $control_args += $args;

		$this->add_control(
			$name,
			$control_args
		);
	}

	function add_tags_select_control( $name = 'post_tags', $args = [] ) {
		$control_args = [
			'label'	=> esc_html__( 'Post tags', 'news-kit-elementor-addons' ),
			'label_block'	=> true,
			'multiple'	=> true,
			'type' => 'nekit-select2-extend',
			'options'	=> 'select2extend/get_taxonomies',
			'query_slug'	=> 'post_tag'
		];

		if( count( $args ) > 0 ) $control_args += $args;

		$this->add_control(
			$name,
			$control_args
		);
	}

	function add_posts_exclude_select_control($name = 'post_to_exclude', $query_slug = 'post', $label = 'Posts', $args = [] ) {
		$control_args = [
			'label'	=> $label . esc_html__( ' to exclude', 'news-kit-elementor-addons' ),
			'description'	=> $label . esc_html__( ' to exclude from the query', 'news-kit-elementor-addons' ),
			'label_block'	=> true,
			'multiple'	=> true,
			'type'	=> 'nekit-select2-extend',
			'options'	=> 'select2extend/get_posts_by_post_type',
			'query_slug'=> $query_slug
		];
		if( count( $args ) > 0 ) $control_args += $args;

		$this->add_control(
			$name,
			$control_args
		);
	}

	function add_posts_include_select_control($name = 'post_to_include', $query_slug = 'post', $label = 'Posts', $args = [] ) {
		$control_args = [
			'label'	=> $label . esc_html__( ' to include', 'news-kit-elementor-addons' ),
			'description'	=> $label . esc_html__( ' to include in the query', 'news-kit-elementor-addons' ),
			'label_block'	=> true,
			'multiple'	=> true,
			'type'	=> 'nekit-select2-extend',
			'options'	=> 'select2extend/get_posts_by_post_type',
			'query_slug'=> $query_slug
		];
		if( count( $args ) > 0 ) $control_args += $args;

		$this->add_control(
			$name,
			$control_args
		);
	}

	function add_post_element_author_control() {
		$this->add_control(
			'show_post_author',
			[
				'label' => esc_html__( 'Show Post Author', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'post_author_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
			]
		);
		
		$this->add_control(
            'post_author_icon',
            [
                'label' =>  esc_html__( 'Author Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['users','user','users-cog','user-tie','user-tag','user-shield','user-secret','user-plus','user-nurse','user-md','user-graduate','user-friends','user-edit','user-cog','user-circle','user-check','user-astronaut','user-alt','feather','highlighter','pen'],
					'fa-regular'	=> ['user','user-circle']
				],
                'default'   =>  [
                    'value' =>  'far fa-user-circle',
                    'library'   =>  'fa-regular'
				],
				'separator'	=> 'after',
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
            ]
        );
	}

	function add_post_element_date_control( $prefix = '' ) {
		$this->add_control(
			$prefix . 'show_post_date',
			[
				'label'	=> esc_html__( 'Show Post Date', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default'	=> 'yes'
			]
		);

		$this->add_control(
			$prefix . 'post_date_icon_position',
			[
				'label'	=> esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_date_condition_filter', [
					$prefix . 'show_post_date'	=> 'pro'
				])
			]
		);
		
		$this->add_control(
            $prefix . 'post_date_icon',
            [
                'label' =>  esc_html__( 'Date Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass'],
					'fa-regular'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass']
				],
                'default'   => [
                    'value' =>  'fas fa-calendar',
                    'library'   =>  'fa-solid'
				],
				'condition'	=> apply_filters( 'nekit_widget_post_date_condition_filter', [
					$prefix . 'show_post_date'	=> 'pro'
				])
            ]
        );
	}

	function add_post_element_comments_control() {
		$this->add_control(
			'show_post_comments',
			[
				'label' => esc_html__( 'Show Post Comments', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'post_comments_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_comments_condition_filter', [
					'show_post_comments'	=> 'pro'
				])
			]
		);

		$this->add_control(
            'post_comments_icon',
            [
                'label' =>  esc_html__( 'Comments Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['comments','comment','comments-dollar','comment-dots','comment-alt'],
					'fa-regular'	=> ['comments','comment','comment-dots','comment-alt']
				],
                'default'   =>  [
                    'value' =>  'far fa-comment',
                    'library'   =>  'fa-regular'
				],
				'separator'	=> 'after',
				'condition'	=> apply_filters( 'nekit_widget_post_comments_condition_filter', [
					'show_post_comments'	=> 'pro'
				])
            ]
        );
	}

	function add_card_skin_style_control() {
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
                'selector'  =>  '{{WRAPPER}} .skin--card .nekit-item-box-wrap, {{WRAPPER}} .skin--card.nekit-news-grid-two-posts-wrap .post-element, 
                {{WRAPPER}} .skin--card.nekit-news-carousel-three-posts-wrap .post-element, {{WRAPPER}} .nekit-news-list-two-posts-wrap.skin--card .post-title,
                {{WRAPPER}} .nekit-archive-posts-wrap.layout--three.skin--card .post-element, {{WRAPPER}} .nekit-archive-posts-wrap.layout--four.skin--card .post-title',
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
                    'name'  => 'card_initial_background',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap',
					'exclude'	=>	['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_initial_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap'
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
                    'name'	=> 'card_hover_background_color',
                    'selector'	=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap:hover',
					'exclude'	=>	['image']
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_hover_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap:hover'
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
                    '{{WRAPPER}} .skin--card .nekit-item-box-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
                    '{{WRAPPER}} .skin--card .nekit-item-box-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
	}

	function add_image_overlay_section() {
		$this->start_controls_section(
            'image_overlay',
            [
                'label' =>  esc_html__( 'Image Overlay', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'image_overlay_option',
            [
                'label' =>  esc_html__( 'Show image overlay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->start_controls_tabs(
            'image_overlay_tabs'
        );
            $this->start_controls_tab(
                'image_overlay_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'	=>  'image_overlay_initial_background_color',
                    'selector'  =>  '{{WRAPPER}} .has-image-overlay::before',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'name'  =>  'image_overlay_initial_css_filter',
                    'selector'  =>  '{{WRAPPER}} .post-item img'
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'image_overlay_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'	=>  'image_overlay_hover_background_color',
                    'selector'  =>  '{{WRAPPER}} .post-item:hover .has-image-overlay::before',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'name'  =>  'image_overlay_hover_css_filter',
                    'selector'  =>  '{{WRAPPER}} .post-item:hover img'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_responsive_control(
            'image_overlay_width',
            [
                'label' =>  esc_html__( 'Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'width:{{SIZE}}%'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_overlay_height',
            [
                'label' =>  esc_html__( 'Height', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'height:{{SIZE}}%'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_overlay_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
	}
	
	// Get list of html tags
	public function get_html_tags() {
		return apply_filters( 'nekit_widgets_html_tags_array_filter', [
			'h1'	=> 'H1',
			'h2'	=> 'H2',
			'h3'	=> 'H3',
			'h4'	=> 'H4',
			'h5'	=> 'H5',
			'h6'	=> 'H6',
			'div'	=> 'div',
			'span'	=> 'span',
			'p'	=> 'P'
		]);
	}

	// badges option array
	public function get_posts_badges() {
		return apply_filters( 'nekit_widgets_html_tags_array_filter', [
			'categories'	=> esc_html__( 'Categories', 'news-kit-elementor-addons' ),
			'tags'	=> esc_html__( 'Tags', 'news-kit-elementor-addons' ),
			'date'	=> esc_html__( 'Date', 'news-kit-elementor-addons' ),
			'author'	=> esc_html__( 'Author', 'news-kit-elementor-addons' ),
			'caption'	=> esc_html__( 'Featured Image Caption', 'news-kit-elementor-addons' )
		]);
	}

	// Get list of image sizes
	public function get_image_sizes() {
		$sizes_lists = [];
		$images_sizes = get_intermediate_image_sizes();
		if( $images_sizes ) {
			foreach( $images_sizes as $size ) {
				$sizes_lists[$size] = $size;
			}
		}
		return $sizes_lists;
	}

	function post_title_animation_type_control() {
        $this->add_control(
            'post_title_animation_choose',
            [
                'label' =>  esc_html__( 'Post Title Animation Type', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'options'   =>  [
                    'custom' =>  [
                        'title' =>  esc_html__( 'Custom', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-custom'
                    ],
                    'elementor' =>  [
                        'title' =>  esc_html__( 'Elementor', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-elementor'
                    ]
                ],
                'label_block'   =>  true,
                'default'   =>  'custom',
                'toggle'    =>  false
            ]
        );

        $this->add_control(
            'post_title_custom_animation',
            [
                'label' =>  esc_html__( 'Custom Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  nekit_get_post_title_animation_effects_array(),
                'label_block'   =>  true,
                'default'   =>  'none',
                'condition' =>  [
                    'post_title_animation_choose'   =>  'custom'
                ]
            ]
        );

        $this->add_control(
            'post_title_hover_animation',
            [
                'label' =>  esc_html__( 'Elementor Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HOVER_ANIMATION,
                'condition' =>  [
                    'post_title_animation_choose'   =>  'elementor'
                ]
            ]
        );
		$this->insert_divider();
    }
	
	function general_styles_primary_color_control() {
		$this->add_control(
			'general_styles_primary_color',
			[
				'label'	=>	esc_html__( 'Primary Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'default'	=>	'#969696',
				'selectors'	=>	[
					'{{WRAPPER}} .custom-animation--one a'	=>	'background-image: linear-gradient(transparent calc( 100% - 2px), {{VALUE}} 1px )',
					'{{WRAPPER}} .custom-animation--two a'	=>	'background-image: linear-gradient(to right,{{VALUE}},{{VALUE}} 50%,currentColor 50%);',
					'{{WRAPPER}} .custom-animation--three a'	=>	'background-image: linear-gradient(90deg,{{VALUE}} 0,{{VALUE}} 94%);',
					'{{WRAPPER}} .custom-animation--four a:hover'	=>	'background-image: linear-gradient({{VALUE}},{{VALUE}});',
					'{{WRAPPER}} .custom-animation--five a'	=>	'background-image: linear-gradient({{VALUE}},{{VALUE}});',
					'{{WRAPPER}} .custom-animation--six a'	=>	'background-image: linear-gradient(currentColor, currentColor), linear-gradient( currentColor, currentColor ), linear-gradient({{VALUE}}, {{VALUE}});',
					'{{WRAPPER}} .custom-animation--seven a'	=>	'background-image: linear-gradient(transparent calc(100% - 10px), {{VALUE}} 30px);',
					'{{WRAPPER}} .custom-animation--eight a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}}, {{VALUE}}), linear-gradient(to left, currentColor, currentColor);',
					'{{WRAPPER}} .custom-animation--nine a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}}, {{VALUE}}), linear-gradient(to bottom, currentColor, currentColor);',
					'{{WRAPPER}} .custom-animation--ten a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}} 45%, currentColor 55%);',
					'{{WRAPPER}} .nekit-banner-wrap .slick-active button:before'	=>	'background-color: {{VALUE}};'
				]
			]
		);
	}

	// prepare the args array for widget query
	function get_posts_args_for_query( $prefix = 'post' ) {
		$settings = $this->get_settings_for_display();

		$post_type = isset( $settings[ $prefix . '_custom_post_types' ] ) ? $settings[ $prefix . '_custom_post_types' ] : [ 'post' ];
		$custom_taxonomies = ( isset( $settings[ $prefix . '_custom_taxonomies' ] ) && is_array( $settings[ $prefix . '_custom_taxonomies' ] ) ) ? $settings[ $prefix . '_custom_taxonomies' ] : [];

		$post_order = ( strpos( $settings[$prefix . '_order'], '-pro' ) === false ) ? $settings[$prefix . '_order']: 'date-desc';
		$post_order_split = explode( '-', $post_order );
		$post_count = $settings[$prefix . '_count'];
		$post_categories = is_array( $settings[$prefix . '_categories'] ) ? $settings[$prefix . '_categories'] : [];
		$post_tags = $settings[$prefix . '_tags'];
		$post_authors = $settings[$prefix . '_authors'];
		$posts_args = [
			'post_type' => $post_type,
			'orderby'	=> $post_order_split[0],
			'order'	=> $post_order_split[1],
			'posts_per_page'	=> absint( $post_count )
		];
		if( $settings[$prefix . '_offset'] > 0 ) $posts_args['offset'] = absint( $settings[$prefix . '_offset'] );
		if($post_authors) $posts_args['author'] = implode( ',', $post_authors );
		if($post_tags) $posts_args['tag__in'] = $post_tags;
		if( $settings[$prefix . '_hide_post_without_thumbnail'] === 'yes' ) {
			$posts_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}
		if( $settings[$prefix . '_to_exclude'] ) $posts_args['post__not_in'] = $settings[$prefix . '_to_exclude'];
		if( isset( $settings[$prefix . '_to_include'] ) ) :
			if( $settings[$prefix . '_to_include'] ) $posts_args['post__in'] = $settings[$prefix . '_to_include'];
		endif;

		$tax_query = [];
		if( count( $custom_taxonomies ) > 0 ) :
			$tax_query = [
				'relation'	=>	"OR"
			];
			foreach( $custom_taxonomies as $tax ) :
				$tax_query[] = [
					'taxonomy'	=>	$tax,
					'terms'	=>	$post_categories,
					'operator'	=>	( count( $post_categories ) > 0 ) ? 'IN' : 'EXISTS'
				];
			endforeach;
		endif;
		if( ! empty( $tax_query ) ) $posts_args['tax_query'] = $tax_query;
		return apply_filters( 'nekit_widgets_query_args_filter', $posts_args );
	}
}

function nekit_get_widgets_info( $widget_name = '' ) {
	$widgets = Nekit_Utils::registered_widgets();
	$new_widget_name = str_replace( 'nekit-', '', $widget_name );
	if( $widget_name === '' ) return $widgets;
	return $widgets[ $new_widget_name ];
}