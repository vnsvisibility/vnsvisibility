<?php
/**
 * Main Banner Widget One
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Main_Banner_Widget_One extends \Nekit_Widget_Base\Base {
	protected $widget_name = 'nekit-main-banner-one';
	public static $widget_count = 'one';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#main-banner-widget-one';
	}
	
	public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'news', 'banner', 'slider' ];
	}

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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/main-banner-one" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
			'main_banner_sorting_heading',
			[
				'label'	=>	esc_html("Main Banner Sorting", 'news-kit-elementor-addons'),
				'type'	=>	\Elementor\Controls_Manager::HEADING,
				'seperator'	=>	'before'
			]
		);

		$this->add_control(
			'main_banner_sorting',
			[
				'label'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=>	true,
				'type'	=>	'sortable-control',
				'default'	=>	['main-banner-wrap', 'main-banner-tabs',],
				'options'	=>	array(
					'main-banner-wrap'	=>	array(
						'label'	=>	esc_html__( 'Main Banner Wrap', 'news-kit-elementor-addons' )
					),
					'main-banner-tabs'	=>	array(
						'label'	=>	esc_html__( 'Main Banner Tabs', 'news-kit-elementor-addons' )
					)
				)
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_posts_query_section',
			[
				'label'	=>	esc_html__( 'Slider Post Query', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_post_type_select_control( 'slider_post_custom_post_types' );
		$this->add_taxonomy_select_control( 'slider_post_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_post_order_select_control('slider_post_order');
		$this->add_control(
			'slider_post_count',
			[
				'label'	=> esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::NUMBER,
				'min'	=> 1,
				'max'	=> nekit_get_widgets_post_count_max( $this->widget_name ),
				'step'	=> 1,
				'default' => 4
			]
		);
		$this->add_authors_select_control('slider_post_authors');
		$this->add_categories_select_control( 'slider_post_categories', [
			'dependency'	=>	'slider_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'slider_post_tags', [
			'dependency'	=>	'slider_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'slider_post_to_include', 'post', 'Posts', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);

		$this->add_control(
			'slider_post_offset',
			[
				'label'	=>	esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	0,
				'max'	=>	200,
				'step'	=>	1,
				'default'	=>	0
			]
		);
		$this->add_posts_exclude_select_control( 'slider_post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_control(
			'slider_post_hide_post_without_thumbnail',
			[
				'label'	=>	esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_posts_elements_settings_section',
			[
				'label'	=>	esc_html__( 'Slider Post Elements Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'slider_show_post_title',
			[
				'label'	=>	esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);

		$this->add_control(
			'slider_show_post_categories',	
			[
				'label'	=>	esc_html__( 'Show Post Categories', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);

		$this->add_post_element_date_control('slider_');

		$this->add_control(
			'slider_show_post_excerpt',
			[
				'label'	=>	esc_html__( 'Show Post Excerpt', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no'
			]
		);

		$this->add_control(
			'slider_show_post_excerpt_length',
			[
				'label'	=>	esc_html__( 'Excerpt length', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'It counts the number of words', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	0,
				'max'	=>	100,
				'step'	=>	1,
				'default'	=>	10,
				'condition' =>  apply_filters( 'nekit_widget_post_excerpt_condition_filter', [
                    'slider_show_post_excerpt' =>  'pro'
                ])
			]
		);

		$this->add_control(
			'slider_post_elements_align_heading',
			[
				'label'	=>	esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING,
				'separator'	=>	'before'
			]
		);

		$this->add_control(
			'slider_post_elements_align',
			[
				'label'	=>	esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::CHOOSE,
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
				'default'	=>	'left',
				'toggle'	=>	false,
				'frontend_available' => true,
				'selectors'	=>	[
					'{{WRAPPER}} .main-banner-slider .post-element, {{WRAPPER}} .main-banner-slider .post-element .post-title, {{WRAPPER}} .main-banner-slider .post-element .post-excerpt' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'slider_posts_elements_sorting',
			[
				'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=>	true,
				'type'	=>	'sortable-control',
				'default'	=>	['post-meta', 'post-title', 'post-excerpt'],
				'options'	=>	array(
					'post-meta'	=>	array(
						'label'	=>	esc_html__( 'Categories / Date', 'news-kit-elementor-addons' )
					),
					'post-title'	=>	array(
						'label'	=>	esc_html__( 'Post Title', 'news-kit-elementor-addons' )
					),
					'post-excerpt'	=>	array(
						'label'	=>	esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' )
					)
				),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_post_elements_align' => 'pro'
                ])
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_settings_section',
			[
				'label'	=>	esc_html__( 'Slider Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'main_banner_slider_auto',
			[
				'label'	=>	esc_html__( 'Enable slider to auto slide', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_arrows',
			[
				'label'	=>	esc_html__( 'Show slider arrow', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_loop',
			[
				'label'	=>	esc_html__( 'Enable slider loop', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' =>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_dots',
			[
				'label'	=>	esc_html__( 'Show slider dots', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_fade',
			[
				'label'	=>	esc_html__( 'Show slider Fade', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
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
		$this->add_control(
			'main_banner_slider_speed',
			[
				'label'	=>	esc_html__( 'Slider speed', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	100,
				'max'	=>	50000,
				'step'	=>	100,
				'default'	=>	300
			]
		);
		$this->insert_divider();

		$this->add_control(
            'main_banner_slider_controller_prev_icon',
            [
                'label'	=>  esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
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
            'main_banner_slider_controller_next_icon',
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
			'main_banner_slider_icon_size',
			[
				'label'	=>	esc_html__( 'Icon size', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	['px'],
				'range'	=>	[
					'px'	=>	[
						'min'	=>	1,
						'max'	=>	1000,
						'step'	=>	1
					]
				],
				'default'	=>	[
					'unit'	=>	'px',
					'size'	=>	12
				],
				'selectors'	=>	[
					'{{WRAPPER}} .slick-arrow i'	=>	'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tabs_settings_section',
			[
				'label'	=>	esc_html__( 'Tabs Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'latest_tab_show',
			[
				'label'	=>	esc_html__( 'Show Latest Tab', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);

		$this->add_control(
			'latest_tab_icon',
			[
				'label'	=>	esc_html__( 'Latest Tab Icon', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::ICONS,
				'label_block'	=>	false,
				'skin'	=>	'inline',
				'recommended'   => [
					'fa-solid'  => ['newspaper','clock','check'],
					'fa-regular'  => ['newspaper','clock']
				],
				'exclude_inline_options'	=>	'svg',
				'default'	=>	[
					'value'	=>	'far fa-newspaper',
					'library'	=>	'fa-regular'
				],
				'condition'	=>	[
					'latest_tab_show'	=>	'yes'
				]
			]
		);
		$this->add_control(
			'latest_tab_text',
			[
				'label'	=>	esc_html__( 'Latest Tab Text', 'news-kit-elementor-addons' ),
				'default'	=>	esc_html__( 'Latest', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'condition'	=>	[
					'latest_tab_show'	=>	'yes'
				]
			]
		);
		$this->add_control(
			'latest_tab_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'popular_tab_show',
			[
				'label'	=>	esc_html__( 'Show Popular Tab', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'popular_tab_icon',
			[
				'label'	=>	esc_html__( 'Popular Tab Icon', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::ICONS,
				'label_block'	=>	false,
				'skin'	=>	'inline',
				'recommended'	=> [
					'fa-solid'	=> ['fire','fire-alt']
				],
				'exclude_inline_options'	=>	'svg',
				'default'	=>	[
					'value'	=>	'fas fa-fire',
					'library'	=>	'fa-solid'
				],
				'condition'	=>	[
					'popular_tab_show'	=>	'yes'
				]
			]
		);
		$this->add_control(
			'popular_tab_text',
			[
				'label'	=>	esc_html__( 'Popular Tab Text', 'news-kit-elementor-addons' ),
				'default'	=>	esc_html__( 'Popular', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'condition'	=>	[
					'popular_tab_show'	=>	'yes'
				]
			]
		);
		
		$this->add_control(
			'popular_tab_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'comments_tab_show',
			[
				'label'	=>	esc_html__( 'Show Commets Tab', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'comments_tab_icon',
			[
				'label'	=>	esc_html__( 'Comments Tab Icon', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::ICONS,
				'label_block'	=>	false,
				'skin'	=>	'inline',
				'recommended'	=> [
					'fa-solid'	=> ['comments','comment','comments-dollar','comment-dots','comment-alt'],
					'fa-regular'	=> ['comments','comment','comment-dots','comment-alt']
				],
				'exclude_inline_options'	=>	'svg',
				'default'	=>	[
					'value'	=>	'fas fa-comment-dots',
					'library'	=>	'fa-solid'
				],
				'condition'	=>	[
					'comments_tab_show'	=>	'yes'
				]
			]
		);
		$this->add_control(
			'comments_tab_text',
			[
				'label'	=>	esc_html__( 'Comments Tab Text', 'news-kit-elementor-addons' ),
				'default'	=>	esc_html__( 'Comments', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'condition'	=>	[
					'comments_tab_show'	=>	'yes'
				]
			]
		);

		$this->add_control(
			'banner_tabs_section_order_heading',
			[
				'label'	=>	esc_html__( 'Tabs Sorting', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HEADING,
				'separator'	=>	'before'
			]
		);

		$this->add_control(
			'banner_tabs_section_order',
			[
				'label'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=>	true,
				'type'	=>	'sortable-control',
				'default'	=>	['latest', 'popular', 'comments'],
				'options'	=>	array(
					'latest'	=>	array(
						'label'	=>	esc_html__( 'Latest', 'news-kit-elementor-addons' )
					),
					'popular'	=>	array(
						'label'	=>	esc_html__( 'Popular', 'news-kit-elementor-addons' )
					),
					'comments'	=>	array(
						'label'	=>	esc_html__( 'Comments', 'news-kit-elementor-addons' )
					)
				)
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'latest_tab_posts_query_section',
			[
				'label'	=>	esc_html__( 'Latest Tab Post Query', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_post_type_select_control( 'latest_tab_custom_post_type' );
		$this->add_taxonomy_select_control( 'latest_tab_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'latest_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'latest_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		
		$this->add_control(
			'latest_tab_post_order',
			[
				'label'	=>	esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'date-desc',
				'label_block'	=>	true,
				'options'	=>	nekit_get_widgets_post_order_options_array()
			]
		);

		$this->add_authors_select_control('latest_tab_post_authors');

		$this->add_categories_select_control( 'latest_tab_post_categories', [
			'dependency'	=>	'latest_tab_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'latest_tab_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'latest_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'latest_tab_post_tags', [
			'dependency'	=>	'latest_tab_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'latest_tab_custom_post_type',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'latest_post_to_include', 'post', 'Posts', [
			'dependency'	=>	'latest_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'latest_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);

		$this->add_control(
			'latest_tab_post_offset',
			[
				'label'	=>	esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	0,
				'max'	=>	200,
				'step'	=>	1,
				'default'	=>	0
			]
		);
		$this->add_posts_exclude_select_control( 'latest_tab_exclude_posts', 'post', 'Posts', [
			'dependency'	=>	'latest_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'latest_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		
		$this->add_control(
			'latest_tab_hide_post_without_thumbnail',
			[
				'label'	=>	esc_html__( 'Hide posts with no featured image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'latest_tab_posts_elements_settings_section',
			[
				'label'	=>	esc_html__( 'Latest Tab Post Elements Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		
		$this->add_control(
			'latest_tab_show_post_thumbnail',
			[
				'label'	=>	esc_html__( 'Show Post Thumbnail', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		
		$this->add_control(
			'latest_tab_show_post_title',
			[
				'label'	=>	esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		
		$this->add_post_element_date_control('latest_tab_');
		$this->end_controls_section();

		$this->start_controls_section(
			'popular_tab_posts_query_section',
			[
				'label'	=>	esc_html__( 'Popular Tab Post Query', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_post_type_select_control( 'popular_tab_custom_post_type' );
		$this->add_taxonomy_select_control( 'popular_tab_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'popular_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'popular_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		
		$this->add_control(
			'popular_tab_post_order',
			[
				'label'	=>	esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'date-desc',
				'label_block'	=>	true,
				'options'	=>	nekit_get_widgets_post_order_options_array()
			]
		);
		$this->add_authors_select_control('popular_tab_post_authors');

		$this->add_categories_select_control( 'popular_tab_post_categories', [
			'dependency'	=>	'popular_tab_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'popular_tab_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'popular_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'popular_tab_post_tags', [
			'dependency'	=>	'popular_tab_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'popular_tab_custom_post_type',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'popular_post_to_include', 'post', 'Posts', [
			'dependency'	=>	'popular_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'popular_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_control(
			'popular_tab_post_offset',
			[
				'label'	=>	esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::NUMBER,
				'min'	=>	0,
				'max'	=>	200,
				'step'	=>	1,
				'default'	=>	0
			]
		);
		$this->add_posts_exclude_select_control( 'popular_tab_exclude_posts', 'post', 'Posts', [
			'dependency'	=>	'popular_tab_custom_post_type',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'popular_tab_custom_post_type',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		
		$this->add_control(
			'popular_tab_hide_post_without_thumbnail',
			[
				'label'	=>	esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'popular_tab_posts_elements_settings_section',
			[
				'label'	=>	esc_html__( 'Popular Tab Post Elements Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		
		$this->add_control(
			'popular_tab_show_post_thumbnail',
			[
				'label'	=>	esc_html__( 'Show Post Thumbnail', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		
		$this->add_control(
			'popular_tab_show_post_title',
			[
				'label'	=>	esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		
		$this->add_post_element_date_control('popular_tab_');

		$this->end_controls_section();

		$this->start_controls_section(
			'animation_settings_section',
			[
				'label'	=>	esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->post_title_animation_type_control();

		$this->add_control(
			'image_hover_animation',
			[
				'label'	=>	esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::HOVER_ANIMATION
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
				'default'	=>	'large',
				'label_block'	=>	true,
				'options'	=>	$this->get_image_sizes()
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
                'selector'=> '{{WRAPPER}} .post-thumb, {{WRAPPER}} .post-thumb-wrap'
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
					'{{WRAPPER}} .nekit-banner-wrap .row' => 'margin-inline: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-banner-wrap .main-banner-wrap' => 'padding: 0 {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-banner-wrap .main-banner-tabs' => 'padding: 0 {{SIZE}}{{UNIT}};'
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
				'selectors' => [
					'{{WRAPPER}} .nekit-banner-wrap .main-banner-tabs article + article' => 'padding-top: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-banner-wrap .post-thumb-wrap' => 'height: calc( 420px + 6*{{SIZE}}{{UNIT}} );'
				]
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
			'slider_post_title_section_typography',
			[
				'label'	=>	esc_html__( 'Slider Post Title', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'slider_post_title_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-slider .post-title'
				]
			);

			$this->start_controls_tabs(
				'slider_post_title_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_title_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_title_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#fff',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-title a' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_title_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_title_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-title a:hover' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'slider_post_title_background_color',
				[
					'label'	=>	esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-title a' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_post_title_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	'0',
						'right'	=>	'0',
						'bottom'	=>	'0',
						'left'	=>	'0',
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-wrap .post-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_title_margin',[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	15,
						'right'	=>	0,
						'bottom'	=>	0,
						'left'	=>	0,
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-wrap .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_excerpt_section_typography',
			[
				'label'	=>	esc_html__( 'Slider Post Excerpt', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'slider_post_excerpt_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-slider .post-excerpt, {{WRAPPER}} .main-banner-tabs .tab-item .news-elementor-comm-content .news-elementor-comment'
				]
			);
			
			$this->add_control(
				'slider_post_excerpt_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#fff',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->insert_divider();
			$this->add_control(
				'slider_post_excerpt_background_color',
				[
					'label'	=>	esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_post_excerpt_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	'0',
						'right'	=>	'0',
						'bottom'	=>	'0',
						'left'	=>	'0',
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_excerpt_margin',[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	7,
						'right'	=>	0,
						'bottom'	=>	0,
						'left'	=>	0,
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_categories_section_typography',
			[
				'label'	=>	esc_html__( 'Slider Post Categories', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'slider_post_categories_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-slider .post-categories a'
				]
			);

			$this->start_controls_tabs(
				'slider_post_categories_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_categories_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_categories_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#fff',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-categories a' => 'color: {{VALUE}}'
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'slider_post_categories_background_color',
					'selector'  =>  '{{WRAPPER}} .main-banner-slider .post-categories a',
					'fields_options'    =>  [
                        'background'    =>  [
                            'default'   => 'classic'
                        ],
                        'color' =>  [
                            'default'   =>  '#333'
                        ]
					],
					'exclude'   =>  ['image']
				]
			);

			$this->add_control(
                'slider_post_categories_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .main-banner-slider .post-categories a' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_categories_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_categories_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-categories a:hover' => 'color: {{VALUE}}'
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'slider_post_categories_background_color_hover',
					'selector'  =>  '{{WRAPPER}} .main-banner-slider .post-categories a:hover',
					'exclude'   =>  ['image']
				]
			);

			$this->add_control(
                'slider_post_categories_border_radius_hover',
                [
                    'label' =>  esc_html__( 'Hover Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .main-banner-slider .post-categories a:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();

			$this->add_responsive_control(
				'slider_post_categories_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	'3',
						'right'	=>	'7',
						'bottom'	=>	'3',
						'left'	=>	'7',
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_categories_margin',[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	0,
						'right'	=>	10,
						'bottom'	=>	0,
						'left'	=>	0,
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .post-categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_date_section_typography',
			[
				'label'	=>	esc_html__( 'Slider Post Date', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'slider_post_date_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-slider .published-date-context, {{WRAPPER}} .main-banner-slider .post-published-date'
				]
			);

			$this->start_controls_tabs(
				'slider_post_date_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_date_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_date_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#fff',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .published-date-context, {{WRAPPER}} .main-banner-slider .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_date_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'slider_post_date_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .main-banner-slider .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'slider_post_date_background_color',
				[
					'label'	=>	esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_post_date_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_date_margin', [
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
                    'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
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
                            'default'   => 'classic'
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
                            'default'   => 'classic'
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

		$this->start_controls_section(
			'tabs_title_section_typography',
			[
				'label'	=>	esc_html__( 'Tabs Title Typography', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);
		
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Title Typography', 'news-kit-elementor-addons' ),
					'name'	=>	'tabs_title_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-tabs .banner-tab'
				]
			);
		
			$this->start_controls_tabs(
				'tabs_title_style_tabs'
			);
			$this->start_controls_tab(
				'tabs_title_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_title_color',
				[
					'label'	=> 	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab' => 'color: {{VALUE}}'
					]
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'tabs_title_background_color',
					'selector' 	=> '{{WRAPPER}} .main-banner-tabs .banner-tab',
					'exclude'   =>  ['image']
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tabs_title_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_title_hover_color',
				[
					'label'	=>	esc_html__( 'Text Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab:hover' => 'color: {{VALUE}}'
					]
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'tabs_title_background_hover_color',
					'selector' 	=> '{{WRAPPER}} .main-banner-tabs .banner-tab:hover',
					'exclude'   =>  ['image']
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name'	=>	'tabs_title_border_control',
					'selector'	=>	'{{WRAPPER}} .main-banner-tabs .banner-tab'
				]
			);

			$this->add_control(
				'tabs_title_border_radius',
				[
					'label'	=>	esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::NUMBER,
					'min'	=>	0,
					'max'	=>	1000,
					'step'	=>	1,
					'default'	=>	0,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab'	=>	'border-radius: {{VALUE}}px'
					]
				]
			);
			
			$this->add_responsive_control(
				'tabs_title_padding_control',
				[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'tabs_title_margin_control',
				[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,					
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_control(
				'active_tab_divider',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER
				]
			);

			$this->add_control(
				'active_tab_style_setting_header',
				[
					'label'	=>	esc_html__( 'Active Tabs', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::HEADING,
					'separator'	=>	'after'
				]
			);

			$this->start_controls_tabs(
				'tabs_active_title_style_tabs'
			);
			$this->start_controls_tab(
				'tabs_active_title_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_active_title_color',
				[
					'label'	=>	esc_html__( 'Active Tab Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab.active' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'tabs_active_background_color',
					'selector' 	=> '{{WRAPPER}} .main-banner-tabs .banner-tab.active',
					'exclude'   =>  ['image']
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tabs_active_title_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_active_title_hover_color',
				[
					'label'	=>	esc_html__( 'Active Tab Text Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab.active:hover' => 'color: {{VALUE}}'
					]
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' 		=> 'tabs_active_background_hover_color',
					'selector' 	=> '{{WRAPPER}} .main-banner-tabs .banner-tab.active:hover',
					'exclude'   =>  ['image']
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name'	=>	'tabs_active_title_border_control',
					'selector'	=>	'{{WRAPPER}} .main-banner-tabs .banner-tab.active'
				]
			);

			$this->add_control(
				'tabs_active_title_border_radius',
				[
					'label'	=>	esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::NUMBER,
					'min'	=>	0,
					'max'	=>	1000,
					'step'	=>	1,
					'default'	=>	0,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab.active'	=>	'border-radius: {{VALUE}}px'
					]
				]
			);

			$this->add_responsive_control(
				'tabs_active_title_padding_control',
				[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab.active'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$this->add_responsive_control(
				'tabs_active_title_margin_control',
				[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,					
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .banner-tab.active'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'tabs_post_title_section_typography',
			[
				'label'	=>	esc_html__( 'Tabs Post Title', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);
		
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Post Title', 'news-kit-elementor-addons' ),
					'name'	=>	'tabs_post_title_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-tabs .post-title, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content a'
				]
			);
		
			$this->start_controls_tabs(
				'tabs_post_title_style_tabs'
			);
			$this->start_controls_tab(
				'tabs_post_title_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_post_title_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#000',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .post-title a, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content a ' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tabs_post_title_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_post_title_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .post-title a:hover, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content a:hover' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'tabs_post_title_background_color',
				[
					'label'	=>	esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .post-title a, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content a' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'tabs_post_title_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .post-title a, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'tabs_post_title_margin', [
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'default'	=>	[
						'top'	=>	6,
						'right'	=>	0,
						'bottom'	=>	0,
						'left'	=>	0,
						'unit'	=>	'px',
						'isLinked'	=>	true
					],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .post-title, {{WRAPPER}} .main-banner-tabs .news-elementor-comm-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'tabs_post_date_section_typography',
			[
				'label'	=>	esc_html__( 'Tabs Post Date', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);
		
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label'	=>	esc_html__( 'Post Date', 'news-kit-elementor-addons' ),
					'name'	=>	'tabs_post_date_typography',
					'selector'	=>	'{{WRAPPER}} .main-banner-tabs .published-date-context, {{WRAPPER}} .main-banner-tabs .post-published-date'
				]
			);
		
			$this->start_controls_tabs(
				'tabs_post_date_style_tabs'
			);
			$this->start_controls_tab(
				'tabs_post_date_initial_tab',
				[
					'label'	=>	esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_post_date_color',
				[
					'label'	=>	esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'default'	=>	'#8A8A8C',
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .published-date-context, {{WRAPPER}} .main-banner-tabs .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tabs_post_date_hover_tab',
				[
					'label'	=>	esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
			
			$this->add_control(
				'tabs_post_date_hover_color',
				[
					'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .main-banner-tabs .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'tabs_post_date_background_color',
				[
					'label'	=>	esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::COLOR,
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .date-meta-wrap' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'tabs_post_date_padding',[
					'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .date-meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'tabs_post_date_margin',[
					'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'	=>	[ 'px', 'em', '%', 'custom' ],
					'selectors'	=>	[
						'{{WRAPPER}} .main-banner-tabs .date-meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();
	}

	/**
	 * Custom post type support
	 * MARK: Post Type
	 */
	public function main_banner_post_type_support( $tab ) {
		$settings = $this->get_settings_for_display();
		if( ! $tab ) return;
		$custom_taxonomies = $post_categories = '';
		switch( $tab ) :
			case 'latest':
				$custom_taxonomies = is_array( $settings['latest_tab_custom_taxonomies'] ) ? $settings['latest_tab_custom_taxonomies'] : [];		
				$post_categories = is_array( $settings['latest_tab_post_categories'] ) ? $settings['latest_tab_post_categories'] : [];		
				break;
			case 'popular':
				$custom_taxonomies = is_array( $settings['popular_tab_custom_taxonomies'] ) ? $settings['popular_tab_custom_taxonomies'] : [];		
				$post_categories = is_array( $settings['popular_tab_post_categories'] ) ? $settings['popular_tab_post_categories'] : [];		
				break;
		endswitch;
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
			return $tax_query;
		else :
			return;
		endif;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		//  post title attributes
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
		$this->add_render_attribute( 'title_hover', 'class', $titleClass );

		$imageClass = '';
		if ( $settings['image_hover_animation'] ) $imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		$this->add_render_attribute( 'image_hover', 'class', $imageClass );
		?>
		<section class="nekit-widget-section nekit-banner-wrap main-banner-section banner-layout--one <?php echo esc_attr( 'section-column-order--' . implode('--',$settings['main_banner_sorting']) ); ?> <?php echo ( $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( 'arrow-on-hover--on' ) : esc_attr( 'arrow-on-hover--off' ); ?>">
            <div class="news-elementor-container">
                <div class="row">
					<?php
						foreach( $settings['main_banner_sorting'] as $main_banner_sort ):
							switch($main_banner_sort):
								case 'main-banner-wrap': ?>
									<div class="main-banner-wrap">
										<div class="main-banner-slider" data-auto="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_auto'] == 'yes' ) ); ?>" data-arrows="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_arrows'] == 'yes' ) ); ?>" data-dots="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_dots'] == 'yes' ) ); ?>" data-loop="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_loop'] == 'yes' ) ); ?>" data-speed="<?php echo esc_attr($settings['main_banner_slider_speed']); ?>" data-prev-icon="<?php echo esc_attr(nekit_get_base_attribute_value([ 'icon'	=> $settings['main_banner_slider_controller_prev_icon'] ])); ?>" data-next-icon="<?php echo esc_attr(nekit_get_base_attribute_value([ 'icon'	=> $settings['main_banner_slider_controller_next_icon'] ])); ?>" data-fade="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_fade'] == 'yes' ) ); ?>">
											<?php
												$slider_posts_args = $this->get_posts_args_for_query('slider_post');
												$slider_post_query = new \WP_Query($slider_posts_args);
												if( $slider_post_query->have_posts() ) :
													while( $slider_post_query->have_posts() ) : $slider_post_query->the_post();
														?>
															<article class="post-item slide-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
																<div class="post_slider_template_one">
																	<figure class="post-thumb-wrap">
																		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
																			<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																				<?php 
																					if( has_post_thumbnail()) {
																						the_post_thumbnail( $settings['image_size'], array(
																							'title' => the_title_attribute(array(
																								'echo'  => false
																							)),
																							'class'	=>	$imageClass
																						));
																					}
																				?>
																			</div>
																		</a>
																	</figure>
																	<div class="post-element">
																		<?php
																			$slider_posts_elements_sorting = isset( $settings['slider_posts_elements_sorting'] ) ? $settings['slider_posts_elements_sorting'] : ['post-meta', 'post-title', 'post-excerpt'];
																			foreach( $slider_posts_elements_sorting as $slider_posts_element ) :
																				switch($slider_posts_element) {
																					case 'post-meta':?>
																						<div class="post-meta">
																							<?php
																								if( $settings['slider_show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );

																								if( $settings['slider_show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																									'base'  =>  isset( $settings['slider_post_date_icon_position'] ) ? $settings['slider_post_date_icon_position'] : 'prefix',
																									'icon'  =>  isset( $settings['slider_post_date_icon'] ) ? $settings['slider_post_date_icon'] : [
																										'value' =>  'fas fa-calendar',
																										'library'   =>  'fa-solid'
																									],
																									'url'	=>	'yes'
																								]));
																							?>
																						</div>
																					<?php
																								break;
																					case 'post-title':
																								if( $settings['slider_show_post_title'] == 'yes' ): ?>
																									<h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																								<?php endif;
																						break;
																					case 'post-excerpt': 
																									if( $settings['slider_show_post_excerpt'] == 'yes' ) :
																										nekit_get_post_excerpt_output($settings['slider_show_post_excerpt_length'] ? $settings['slider_show_post_excerpt_length']: 0);
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
									</div>
								<?php
								break;
								case 'main-banner-tabs': ?>
									<div class="main-banner-tabs">
										<ul class="banner-tabs">
											<?php
												$tab_count = 0;												
												foreach( $settings['banner_tabs_section_order'] as $tab_key => $tab_section_order ) :
													switch( $tab_section_order ) {
														case 'latest':
															if( $settings['latest_tab_show'] == 'yes' ) :
																$latest_tab_text = $settings['latest_tab_text']; ?> <li class="banner-tab latest-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="latest">
																		<?php if( nekit_get_base_value(['icon' => $settings['latest_tab_icon']]) ) { echo wp_kses_post( nekit_get_base_value(['icon' => $settings['latest_tab_icon']]) ); ?><?php } ?>
																		<?php echo esc_html( $latest_tab_text ); ?></li>
																	<?php
																	$tab_count++;
															endif;
														break;
														case 'popular': 
															if( $settings['popular_tab_show'] == 'yes' ) :
																$popular_tab_text = $settings['popular_tab_text']; ?> <li class="banner-tab latest-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="popular">
																<?php if( nekit_get_base_value(['icon' => $settings['popular_tab_icon']]) ) { echo wp_kses_post( nekit_get_base_value(['icon' => $settings['popular_tab_icon']]) ); ?><?php } ?>
																<?php echo esc_html( $popular_tab_text ); ?></li>
																	<?php
																	$tab_count++;
															endif;
														break;
														case 'comments': 
															if( $settings['comments_tab_show'] == 'yes' ) :
																$comments_tab_texrt = $settings['comments_tab_text']; ?> <li class="banner-tab latest-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="comments">
																<?php if( nekit_get_base_value(['icon' => $settings['comments_tab_icon']]) ) { echo wp_kses_post( nekit_get_base_value(['icon' => $settings['comments_tab_icon']]) ); ?><?php } ?>
																<?php echo esc_html( $settings['comments_tab_text'] ); ?></li>
																				<?php
																				$tab_count++;
															endif;
														break;
													}
											endforeach; ?>
										</ul>
										<div class="banner-tabs-content">
											<?php
												$tab_ccount = 0;
												foreach( $settings['banner_tabs_section_order'] as $tab_key => $tab_section_order ) :
													if( $settings['latest_tab_show'] != 'yes' && $tab_section_order == 'latest') continue;
													if( $settings['popular_tab_show'] != 'yes' && $tab_section_order == 'popular') continue;
													if( $settings['comments_tab_show'] != 'yes' && $tab_section_order == 'comments') continue;
													?>
													<div class="tab-item<?php if( $tab_ccount == 0 ) echo ' active'; ?>" tab-content="<?php echo esc_attr( $tab_section_order ); ?>">
													<?php
														switch( $tab_section_order ) {
															case 'latest': 
																		if( $settings['latest_tab_show'] == 'yes' ) :
																			$latest_tab_post_order = $settings['latest_tab_post_order'];
																			$latest_tab_post_order_split = explode( '-', $latest_tab_post_order );
																			$latest_tab_post_tags = $settings['latest_tab_post_tags'];
																			$latest_tab_post_authors = $settings['latest_tab_post_authors'];
																			$latest_tab_custom_post_type = is_array( $settings['latest_tab_custom_post_type'] ) ? $settings['latest_tab_custom_post_type'] : 'post';
																			$latest_tab_posts_args = [
																				'post_type' => $latest_tab_custom_post_type,
																				'orderby'	=> $latest_tab_post_order_split[0],
																				'order'	=> $latest_tab_post_order_split[1],
																				'posts_per_page'	=> 4
																			];
																			if( $settings['latest_tab_post_offset'] > 0 ) $latest_tab_posts_args['offset'] = absint($settings['latest_tab_post_offset']);
																			if($latest_tab_post_authors) $latest_tab_posts_args['author'] = implode( ',', $latest_tab_post_authors );
																			if($latest_tab_post_tags) $latest_tab_posts_args['tag__in'] = $latest_tab_post_tags;
																			if( $settings['latest_tab_hide_post_without_thumbnail'] === 'yes' ) {
																				$latest_tab_posts_args['meta_query'] = [
																					[
																						'key' => '_thumbnail_id',
																						'compare' => 'EXISTS'
																					]
																				];
																			}
																			if( $settings['latest_post_to_include'] ) $latest_tab_posts_args['post__in'] = $settings['latest_post_to_include'];
																			if( $settings['latest_tab_exclude_posts'] ) $latest_tab_posts_args['post__not_in'] = $settings['latest_tab_exclude_posts'];
																			/* Tax Query */
																			$latest_tab_tax_query = $this->main_banner_post_type_support( 'latest' );
																			if( ! $latest_tab_tax_query ) $latest_tab_posts_args['tax_query'] = $latest_tab_tax_query;
																			$latest_tab_posts = get_posts( $latest_tab_posts_args );
																			if( $latest_tab_posts ) :
																				foreach( $latest_tab_posts as $latest_tab_post ) :
																					$latest_tab_id  = $latest_tab_post->ID;
																				?>
																					<article class="post-item news-elementor-category-no-bk <?php if( ! has_post_thumbnail( $latest_tab_id ) ){ echo esc_attr('no-feat-img'); } if( $settings['latest_tab_show_post_thumbnail'] != 'yes' ) echo esc_attr( ' section-no-thumbnail' ) ?>">
																						<figure class="post-thumb">
																							<?php if( has_post_thumbnail($latest_tab_id) && $settings['latest_tab_show_post_thumbnail'] == 'yes' ): ?>
																								<a href="<?php echo esc_url(get_the_permalink( $latest_tab_id )); ?>" title="<?php the_title_attribute(array( 'post' => $latest_tab_id )); ?>">
																									<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																										<img <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?> src="<?php echo esc_url( get_the_post_thumbnail_url($latest_tab_id, $settings['image_size']) ); ?>"/>
																									</div>
																								</a>
																							<?php endif; ?>
																						</figure>
																						<div class="post-element">
																							<div class="post-meta">
																								<?php
																									if( $settings['latest_tab_show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																										'base'  =>  isset( $settings['latest_tab_post_date_icon_position'] ) ? $settings['latest_tab_post_date_icon_position'] : 'prefix',
																										'icon'  =>  isset( $settings['latest_tab_post_date_icon'] ) ? $settings['latest_tab_post_date_icon'] : [
																											'value' =>  'fas fa-calendar',
																											'library'   =>  'fa-solid'
																										],
																										'url'	=>	'yes'
																									]));
																								?>
																							</div>
																							<?php
																								if( $settings['latest_tab_show_post_title'] == 'yes' ) {
																							?>
																									<h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink($latest_tab_id); ?>" title="<?php the_title_attribute(array( 'post' => $latest_tab_id )); ?>"><?php echo esc_html(get_the_title($latest_tab_id) ); ?></a></h2>
																							<?php
																								}
																							?>
																						</div>
																					</article>
																				<?php
																				endforeach;
																			endif;
																			$tab_ccount++;
																		endif;
																	break;
															case 'popular': 
																		if( $settings['popular_tab_show'] == 'yes' ) :
																			$popular_tab_post_order = $settings['popular_tab_post_order'];
																			$popular_tab_post_order_split = explode( '-', $popular_tab_post_order );
																			$popular_tab_post_tags = $settings['popular_tab_post_tags'];
																			$popular_tab_post_authors = $settings['popular_tab_post_authors'];
																			$popular_tab_custom_post_type = is_array( $settings['popular_tab_custom_post_type'] ) ? $settings['popular_tab_custom_post_type'] : 'post';
																			$popular_tab_posts_args = [
																				'post_type' => $popular_tab_custom_post_type,
																				'orderby'	=> $popular_tab_post_order_split[0],
																				'order'	=> $popular_tab_post_order_split[1],
																				'posts_per_page'	=> 4
																			];
																			if( $settings['popular_tab_post_offset'] > 0 ) $popular_tab_posts_args['offset'] = absint($settings['popular_tab_post_offset']);
																			if($popular_tab_post_authors) $popular_tab_posts_args['author'] = implode( ',', $popular_tab_post_authors );
																			if($popular_tab_post_tags) $popular_tab_posts_args['tag__in'] = $popular_tab_post_tags;
																			if( $settings['popular_tab_hide_post_without_thumbnail'] === 'yes' ) {
																				$popular_tab_posts_args['meta_query'] = [
																					[
																						'key' => '_thumbnail_id',
																						'compare' => 'EXISTS'
																					]
																				];
																			}
																			if( $settings['popular_post_to_include'] ) $popular_tab_posts_args['post__in'] = $settings['popular_post_to_include'];
																			if( $settings['popular_tab_exclude_posts'] ) $popular_tab_posts_args['post__not_in'] = $settings['popular_tab_exclude_posts'];
																			/* Tax Query */
																			$popular_tab_tax_query = $this->main_banner_post_type_support( 'popular' );
																			if( ! $popular_tab_tax_query ) $popular_tab_posts_args['tax_query'] = $popular_tab_tax_query;
																			$popular_tab_posts = get_posts( $popular_tab_posts_args );
																				if( $popular_tab_posts ) :
																					foreach( $popular_tab_posts as $popular_tab_post ) :
																						$popular_tab_id  = $popular_tab_post->ID;
																					?>
																						<article class="post-item news-elementor-category-no-bk <?php if($settings['popular_tab_show_post_thumbnail'] != 'yes'){ echo esc_attr('no-feat-img');} ?>">
																						<?php if($settings['popular_tab_show_post_thumbnail'] == 'yes') : ?>
																								<figure class="post-thumb">
																									<?php
																									if( has_post_thumbnail($popular_tab_id) ) : ?>
																										<a href="<?php echo esc_url(get_the_permalink($popular_tab_id)); ?>" title="<?php the_title_attribute(array( 'post' => $popular_tab_id )); ?>">
																											<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																												<img <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?> src="<?php echo esc_url( get_the_post_thumbnail_url($popular_tab_id, $settings['image_size']) ); ?>"/>
																											</div>
																										</a>
																									<?php endif; ?>
																								</figure>
																							<?php endif; ?>
																							<div class="post-element">
																								<div class="post-meta">
																									<?php
																										if( $settings['popular_tab_show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																											'base'  =>  isset( $settings['popular_tab_post_date_icon_position'] ) ? $settings['popular_tab_post_date_icon_position'] : 'prefix',
																											'icon'  =>  isset( $settings['popular_tab_post_date_icon'] ) ? $settings['popular_tab_post_date_icon'] : [
																												'value' =>  'fas fa-calendar',
																												'library'   =>  'fa-solid'
																											],
																											'url'	=>	'yes'
																										]));
																									?>
																								</div>
																								<?php if($settings['popular_tab_show_post_title'] == 'yes') : ?>
																									<h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink($popular_tab_id); ?>" title="<?php the_title_attribute(array( 'post' => $popular_tab_id )); ?>"><?php echo esc_html(get_the_title($popular_tab_id) ); ?></a></h2>
																								<?php endif; ?>
																							</div>
																						</article>
																					<?php
																					endforeach;
																				endif;
																				$tab_ccount++;
																		endif;
																	break;
															case 'comments': 
																			if( $settings['comments_tab_show'] == 'yes' ) :
																				$banner_comments = get_comments(array( 'number'   => 4 ));
																				if( $banner_comments ) :
																					foreach( $banner_comments as $banner_comment ) :
																				?>
																						<div class="comment-item">
																							<figure class="nekit_avatar">
																									<a href="<?php echo esc_url( get_comment_link( $banner_comment->comment_ID ) ); ?>">
																										<?php echo get_avatar( $banner_comment->comment_author_email, 50 ); ?>     
																									</a>
																							</figure>
																							<div class="news-elementor-comm-content">
																								<a href="<?php echo esc_url( get_comment_link( $banner_comment->comment_ID ) ); ?>">
																									<span class="news-elementor-comment-author"><?php echo esc_html( get_comment_author( $banner_comment->comment_ID ) ); ?> </span> - <span class="nekit_comment_post"><?php echo esc_html( get_the_title($banner_comment->comment_post_ID) ); ?></span>
																								</a>
																								<p class="news-elementor-comment">
																									<?php echo esc_html(wp_trim_words(wp_kses_post( $banner_comment->comment_content ), 10 ) ); ?>
																								</p>
																							</div>
																
																						</div>
																				<?php
																					endforeach;
																				endif;
																				$tab_ccount++;
																			endif;
																		break;
														}
													?>
													</div>
													<?php
											endforeach; ?>
										</div>
									</div>
								<?php break;
							endswitch;
						endforeach; 
					?>
				</div>
			</div>
		</section>
		<?php
	}
}