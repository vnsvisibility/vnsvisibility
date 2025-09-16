<?php
/**
 * Single Author Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Author extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-author';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-author';
    }

    public function get_keywords() {
        return ['single', 'author', 'post-author'];
    }

    protected function register_controls() {
        //General Section
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-author" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'link_url',
            [
                'label' =>  esc_html__( 'Link Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Enable', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Disable', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'no'
            ]
        );

        $this->add_control(
            'open_in_new_tab',
            [
                'label' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  '_self',
                'options'   =>  [
                    '_blank'    =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                    '_self'    =>  esc_html__( 'Open in same tab', 'news-kit-elementor-addons' )
                ]
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
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
                        'title' =>  esc_html__( 'Right','news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-author'  =>  'text-align: {{VALUE}}'
                ],
                'separator' =>  'after'
            ]
        );

        $this->add_control(
            'author_context',
            [
                'label' =>  esc_html__( 'Author Context', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'icon',
                'options'   =>  [
                    'icon'  =>  [
                        'title' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-person'
                    ],
                    'text'  =>  [
                        'title' =>  esc_html__( 'Text', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-t-letter-bold'
                    ]
                ],
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'author_icon',
            [
                'label' =>  esc_html__( 'Author Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'	=> [
					'fa-solid'	=> ['users','user','users-cog','user-tie','user-tag','user-shield','user-secret','user-plus','user-nurse','user-md','user-graduate','user-friends','user-edit','user-cog','user-circle','user-check','user-astronaut','user-alt','feather','highlighter','pen'],
					'fa-regular'	=> ['user','user-circle']
				],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'far fa-user'
                ],
                'exclude_inline_options'    =>  ['svg'],
                'condition' =>  [
                    'author_context'    =>  'icon'
                ]
            ]
        );

        $this->add_control(
            'author_text',
            [
                'label' =>  esc_html__( 'Author Text', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'By ', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'author_context'    =>  'text'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'icon_text_size',
            [
                'label' =>  esc_html__( 'Icon / Text Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .author-meta-wrap .author-context' =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'icon_distance',
            [
                'label' =>  esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  10,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-author-suffix' =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .post-author-prefix' =>  'margin-right: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'author_context'    =>  'icon'
                ]
            ]
        );

        $this->add_control(
            'icon_text_position',
            [
                'label' =>  esc_html__( 'Icon / Text Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'prefix',
                'options'   =>  [
                    'prefix'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' ),
                    'suffix'    =>  esc_html__( 'After', 'news-kit-elementor-addons' )
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_section',
            [
                'label' =>  esc_html__( 'Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>   'author_typography',
                'selector'  =>  '{{WRAPPER}} .post-author, {{WRAPPER}} .author-context',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit' =>  'px',
                            'size'  =>  16
                        ]
                    ]
                ]
            ]
        );

        $this->start_controls_tabs(
            'author_tabs'
        );
            $this->start_controls_tab(
                'author_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'author_initial_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#8A8A8C',
                    'selectors' =>  [
                        '{{WRAPPER}} .author-meta-wrap' =>  'color: {{VALUE}}',
                        '{{WRAPPER}} .author-meta-wrap a' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'author_initial_background',
                    'selector'  =>  '{{WRAPPER}} .author-meta-wrap',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  =>  'author_initial_box_shadow',
                    'selector'  =>  '{{WRAPPER}} .author-meta-wrap'
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'author_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'author_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .author-meta-wrap:hover' =>  'color: {{VALUE}}',
                        '{{WRAPPER}} .author-meta-wrap:hover a' =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'author_hover_background',
                    'selector'  =>  '{{WRAPPER}} .author-meta-wrap:hover',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  =>  'author_hover_box_shadow',
                    'selector'  =>  '{{WRAPPER}} .author-meta-wrap:hover'
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();
            
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'author_border',
                'selector'  =>  '{{WRAPPER}} .author-meta-wrap'
            ]
        );

        $this->add_control(
            'author_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .author-meta-wrap' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->get_spacing_control( 'author_padding', 'Padding', '.author-meta-wrap', 'padding' );

        $this->get_spacing_control( 'author_margin', 'Margin', '.author-meta-wrap', 'margin' );

        $this->insert_divider();

        $this->add_control(
            'single_author_context_heading',
            [
                'label' =>  esc_html__( 'Context Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'context_color',
            [
                'label' =>  esc_html__( 'Context Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' =>  [
                    '{{WRAPPER}} .author-context'   =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display(); ?>
        <div class="nekit-single-author">
            <?php
                $author_args = [
                    'base'  =>  $settings['icon_text_position'],
                    'icon'  =>  $settings['author_icon'],
                    'url'   =>  $settings['link_url'],
                    'target'   =>  $settings['open_in_new_tab']
                ];
                if( $settings['author_context'] == 'icon' ) $author_args['icon'] = $settings['author_icon'];
                if( $settings['author_context'] == 'text' ) $author_args['text'] = $settings['author_text'];
                echo wp_kses_post(nekit_get_posts_author( $author_args ));
            ?>
        </div>    
    <?php
    }
 }