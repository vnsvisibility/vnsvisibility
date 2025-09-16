<?php
/**
 * Single Categories Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Categories extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-categories';
    
    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-categories';
    }

    public function get_keywords() {
        return [ 'single','categories','post' ];
    }

    protected function register_controls() {
        //Categories Section
        $this->start_controls_section(
            'categories_section',
            [
                'label' =>  esc_html__( 'Category', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-categories" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'no_of_categories_to_show',
            [
                'label' =>  esc_html__( 'Number of categories to show', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  1,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  5
            ]
        );

        $this->add_control(
            'alignnemt',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
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
                'toggle'    => false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WARPPER}} .nekit-single-category'    =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'link_url',
            [
                'label' =>  esc_html__( 'Link Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no',
                'description'   =>  esc_html__( 'Link category to its respective archive page', 'news-kit-elementor-addons' )
            ]   
        );

        $this->add_control(
            'open_in_new_tab',
            [
                'label' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Yes', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'No', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );

        $this->end_controls_section();

        //Category Styles
        $this->start_controls_section(
            'category_styles',
            [
                'label' =>  esc_html__( 'Category Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'category_style_typography',
                'selector'  =>  '{{WRAPPER}} .post-category',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  16
                        ]
                    ]
                ]
            ]
        );
        
            $this->start_controls_tabs(
                'category_styles_tabs'
            );

                $this->start_controls_tab(
                    'category_styles_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'initial_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' =>  [
                            '{{WRAPPER}} .post-category'    =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .post-category a'    =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'category_styles_background',
                        'selector'  =>  '{{WRAPPER}} .post-category',
                        'fields_options' => [
                            'background' => [
                                'default' => 'classic'
                            ],
                            'color' => [
                                'default' => '#000'
                            ]
                        ],
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'category_styles_box_shadow',
                        'selector'  =>  '{{WRAPPER}} .post-category'
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'category_styles_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'hover_color',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .post-category:hover'    =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .post-category:hover a'    =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'category_styles_background_hover',
                        'selector'  =>  '{{WRAPPER}} .post-category:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'category_styles_box_shadow_hover',
                        'selector'  =>  '{{WRAPPER}} .post-category:hover'
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->insert_divider();

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'category_style_border',
                    'selector'  =>  '{{WRAPPER}} .post-category'
                ]
            );

            $this->add_control(
                'category_styles_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  1000,
                    'step'   =>  1,
                    'default'   =>  0,
                    'selectors' =>  [
                        '{{WRAPPER}} .post-category'    =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

            $this->get_spacing_control( 'category_styles_padding', 'Padding', '.post-category', 'padding', [ 2, 10, 2, 10 ] );

            $this->get_spacing_control( 'category_styles_margin', 'Margin', '.post-category', 'margin', [ 0, 10, 0, 0 ] );

        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display();
    ?>
            <div class="nekit-single-category">
                <?php
                    $post_categories = get_categories([
                        'object_ids' => get_the_ID(),
                        'number'    =>  $settings['no_of_categories_to_show']
                    ]);
                    foreach( $post_categories as $post_category ):
                        if( $settings['link_url'] == 'yes' ): ?>
                            <span class="post-category">
                                <a href="<?php echo esc_attr( get_term_link( $post_category->term_id ) ); ?>" 
                                    <?php if( $settings['open_in_new_tab'] ) echo 'target="_blank"'; ?>>
                                        <?php echo esc_html( $post_category->name ); ?>
                                </a>
                            </span>
                        <?php
                        else:
                            echo '<span class="post-category">' . esc_html( $post_category->name ) . '</span>';
                        endif;
                    endforeach;
                ?>
            </div>
    <?php
    }
 }