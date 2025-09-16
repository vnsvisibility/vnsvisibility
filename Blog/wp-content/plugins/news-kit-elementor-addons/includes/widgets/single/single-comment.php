<?php
/**
 * Single Comment Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Comment extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-comment';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-comment';
    }

    public function get_keywords() {
        return ['single','comment'];
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-comment" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
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
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-comment'  =>  'text-align: {{VALUE}}'
                ],
                'separator' =>  'after'
            ]
        );
        
        $this->add_control(
            'comment_context',
            [
                'label' =>  esc_html__( 'Comment Context', 'news-kit-elementor-addons' ),
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
            'comment_icon',
            [
                'label' =>  esc_html__( 'Comment Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'	=> [
					'fa-solid'	=> ['comments','comment','comments-dollar','comment-dots','comment-alt'],
					'fa-regular'	=> ['comments','comment','comment-dots','comment-alt']
				],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-comment'
                ],
                'exclude_inline_options'    =>  ['svg'],
                'condition' =>  [
                    'comment_context'   =>  'icon'
                ]
            ]
        );

        $this->add_control(
            'comment_text',
            [
                'label' =>  esc_html__( 'Comment Text', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Comment: ', 'news-kit-elementor-addons' ),  
                'condition' =>  [
                    'comment_context'   =>  'text'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_responsive_control(
            'icon__text_size',
            [
                'label' =>  esc_html__( 'Icon / Text Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    => [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'   =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  15,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-comments-context' =>  'font-size: {{SIZE}}{{UNIT}}'
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
                    'size'  =>  6,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-comments-suffix' =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .post-comments-prefix' =>  'margin-right: {{SIZE}}{{UNIT}}'
                ],
                'condition' =>  [
                    'comment_context'    =>  'icon'
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
            'comment_styles',
            [
                'label' =>  esc_html__( 'Comment Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'comment_typography',
                'selector' =>  '{{WRAPPER}} .post-comments'
            ]
        );

            $this->start_controls_tabs(
                'comment_tabs'
                
            );
            
                $this->start_controls_tab(
                    'comment_initial_tab',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'comment_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#8A8A8C',
                        'selectors' =>  [
                            '{{WRAPPER}} .comments-meta-wrap a'   =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'comment_background',
                        'selector' =>  '{{WRAPPER}} .comments-meta-wrap a',
                        'exclude'   =>  ['image']
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'comment_box_shadow',
                        'selector' =>  '{{WRAPPER}} .comments-meta-wrap a',
                    ]
                );
                
                $this->end_controls_tab();
                $this->start_controls_tab(
                    'comment_hover_tab',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'comment_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .comments-meta-wrap a:hover'   =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'comment_background_hover',
                        'selector' =>  '{{WRAPPER}} .comments-meta-wrap a:hover',
                        'exclude'   =>  ['image']
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'comment_box_shadow_hover',
                        'selector' =>  '{{WRAPPER}} .comments-meta-wrap a:hover'
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'comment_border',
                'selector' =>  '{{WRAPPER}} .comments-meta-wrap a'
            ]
        );

        $this->add_control(
            'comment_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'   =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .comments-meta-wrap a' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->get_spacing_control( 'comment_padding', 'Padding', '.comments-meta-wrap a', 'padding' );

        $this->get_spacing_control( 'comment_margin', 'Margin', '.comments-meta-wrap a', 'margin' );

        $this->insert_divider();

        $this->add_control(
            'single_comment_context_heading',
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
                    '{{WRAPPER}} .comments-meta-wrap .post-comments-context'   =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display();
        $comment_args = [ 'base'  =>  $settings['icon_text_position'] ];
        if( $settings['comment_context'] == 'icon' ) $comment_args['icon']  =  $settings['comment_icon'];
        if( $settings['comment_context'] == 'text' ) $comment_args['text']  =  $settings['comment_text'];
    ?>
        <div class="nekit-single-comment">
            <?php
                echo wp_kses_post(nekit_get_posts_comments( $comment_args ));
            ?>
        </div>
    <?php
    }
 }