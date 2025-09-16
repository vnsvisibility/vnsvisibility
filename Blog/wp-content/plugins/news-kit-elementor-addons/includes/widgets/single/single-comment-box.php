<?php
/**
 * Single Comment Box
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Comment_Box extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-comment-box';

    public function get_custom_html_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-comment-box';
    }

    public function get_keywords() {
        return ['single','comment','box','comment-box'];
    }

    protected function register_controls() {
        // comment box section
        $this->start_controls_section(
            'comment_box_section',
            [
                'label' =>  esc_html__( 'Comment Box', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-comment-box" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
        
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'comment_box_background',
                'selector' =>  '{{WRAPPER}} #comments',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' =>  'comment_box_box_shadow',
                'selector' =>  '{{WRAPPER}} #comments',
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'outer_border_heading',
            [
                'label' =>  esc_html__( 'Outer Border', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' =>  'comment_box_outer_border',
                'selector' =>  '{{WRAPPER}} #comments',
                'description'   =>  esc_html__( 'Test', 'news-kit-elementor-addons' ),
            ]
        );

        $this->add_control(
            'comment_box_outer_border_radius',
            [
                'label' =>  esc_html__( 'Outer Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} #comments' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'inner_border_heading',
            [
                'label' =>  esc_html__( 'Innner Border', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' =>  'comment_box_inner_border',
                'selector' =>  '{{WRAPPER}} #respond',
            ]
        );

        $this->add_control(
            'comment_box_inner_border_radius',
            [
                'label' =>  esc_html__( 'Inner Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} #respond' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'comment_box_padding', 'Padding', '#comments', 'padding' );
        
        $this->get_spacing_control( 'comment_box_margin', 'Margin', '#comments', 'margin' );

        $this->end_controls_section();

        //Leave a Reply Section
        $this->start_controls_section(
            'leave_a_reply',
            [
                'label' =>  esc_html__( 'Leave A Reply','news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'leave_a_reply_typography',
                'selector'  =>  '{{WRAPPER}} .comment-reply-title',
            ]
        );

        $this->add_control(
            'leave_a_reply_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .comment-reply-title'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'leave_a_reply_background',
                'selector'  =>  '{{WRAPPER}} .comment-reply-title',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_control(
            'leave_a_reply_alignment',
            [
                'label' =>  esc_html__( 'Alignment','news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
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
                    '{{WRAPPER}} .comment-reply-title'  =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'leave_a_reply_padding', 'Padding', '.comment-reply-title', 'padding' );

        $this->get_spacing_control( 'leave_a_reply_margin', 'Margin', '.comment-reply-title', 'margin', [ 10, 0, 12, 0 ] );

        $this->end_controls_section();

        //Logged in as section
        $this->start_controls_section(
            'logged_in_as',
            [
                'label' =>  esc_html__( 'Logged in as','news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'logged_in_as_typography',
                'selector'  =>  '{{WRAPPER}} .logged-in-as, {{WRAPPER}} .comment-notes, {{WRAPPER}} .comment-form-cookies-consent label'
            ]
        );

        $this->add_control(
            'logged_in_as_color',
            [
                'label' =>  esc_html__( 'color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .logged-in-as'  =>  'color: {{VALUE}}'
                ]
            ]
        );

            $this->start_controls_tabs(
                'link_color_tabs'
            );

                $this->start_controls_tab(
                    'link_color_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                    ]
                );

                $this->add_control(
                    'logged_in_as_link_color',
                    [
                        'label' =>  esc_html__( 'Link color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#FFA300',
                        'selectors' =>  [
                            '{{WRAPPER}} .logged-in-as a'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'link_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' ),
                    ]
                );

                $this->add_control(
                    'logged_in_as_link_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Link color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .logged-in-as a:hover'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'logged_in_as_background',
                'selector'  =>  '{{WRAPPER}} .logged-in-as',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_control(
            'logged_in_as_alignment',
            [
                'label' =>  esc_html__( 'Alignment','news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
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
                    '{{WRAPPER}} .logged-in-as'  =>  'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->insert_divider();
        $this->get_spacing_control( 'logged_in_as_padding', 'Padding', '.logged-in-as', 'padding' );
        $this->get_spacing_control( 'logged_in_as_margin', 'Margin', '.logged-in-as', 'margin' );
        $this->end_controls_section();

        $this->start_controls_section(
            'form_elements_section',
            [
                'label' =>  esc_html__( 'Form Elements', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'comment_name_email_website_typography',
                'selector'  =>  '{{WRAPPER}} .comment-form-comment label, {{WRAPPER}} .comment-form-author label, {{WRAPPER}} .comment-form-email label, {{WRAPPER}} .comment-form-url label'
            ]
        );

        $this->add_control(
            'comment_name_email_website_color',
            [
                'label' =>  esc_html__( 'color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .comment-form-comment'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-author'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-email'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-url'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'comment_name_email_website_background',
                'selector'  =>  '{{WRAPPER}} .comment-form-comment label, {{WRAPPER}} .comment-form-author label, {{WRAPPER}} .comment-form-email label, {{WRAPPER}} .comment-form-url label',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_control(
            'comment_name_email_website_alignment',
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
                    '{{WRAPPER}} .comment-form-comment'  =>  'text-align: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-author'  =>  'text-align: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-email'  =>  'text-align: {{VALUE}}',
                    '{{WRAPPER}} .comment-form-url'  =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'comment_name_email_website_textarea_heading',
            [
                'label' =>  esc_html__( 'Form Textarea', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'comment_name_email_website_textarea_typography',
                'selector'  =>  '{{WRAPPER}} #comment, {{WRAPPER}} #author, {{WRAPPER}} #email, {{WRAPPER}} #url'
            ]
        );

        $this->add_control(
            'comment_name_email_website_textarea_color',
            [
                'label' =>  esc_html__( 'Textarea Color', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} #comment'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} #author'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} #email'  =>  'color: {{VALUE}}',
                    '{{WRAPPER}} #url'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'comment_name_email_website_textarea_background',
                'selector'  =>  '{{WRAPPER}} #comment, {{WRAPPER}} #author, {{WRAPPER}} #email, {{WRAPPER}} #url',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'comment_name_email_website_textarea_border',
                'selector'  =>  '{{WRAPPER}} #comment, {{WRAPPER}} #author, {{WRAPPER}} #email, {{WRAPPER}} #url'
            ]
        );

        $this->add_control(
            'comment_name_email_website_textarea_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  7,
                'selectors' =>  [
                    '{{WRAPPER}} #comment'  =>  'border-radius: {{VALUE}}px',
                    '{{WRAPPER}} #author'  =>  'border-radius: {{VALUE}}px',
                    '{{WRAPPER}} #email'  =>  'border-radius: {{VALUE}}px',
                    '{{WRAPPER}} #url'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_responsive_control(
            'comment_name_email_website_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .comment-form-comment label'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-author label'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-email label'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-url label'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'comment_name_email_website_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' =>  [
                    '{{WRAPPER}} .comment-form-comment label'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-author label'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-email label'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .comment-form-url label'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();

        //Post Comment Section
        $this->start_controls_section(
            'form_button_section',
            [
                'label' =>  esc_html__( 'Form Button', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'form_button_typography',
                'selector'  =>  '{{WRAPPER}} .form-submit .submit',
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
        
            $this->start_controls_tabs(
                'form_button_tabs'
            );
                $this->start_controls_tab(
                    'form_button_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );
        
                $this->add_control(
                    'form_button_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default' => '#fff',
                        'selectors' =>  [
                            '{{WRAPPER}} .form-submit .submit'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'form_button_background',
                        'fields_options' => [
                            'background' => [
                                'default' => 'classic'
                            ],
                            'color' => [
                                'default' => '#000'
                            ]
                        ],
                        'selector'  =>  '{{WRAPPER}} .form-submit .submit',
                        'exclude'   =>  ['image'],
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'form_button_box_shadow',
                        'selector'  =>  '{{WRAPPER}} .form-submit .submit'
                    ]
                );
                
                $this->end_controls_tab();
                $this->start_controls_tab(
                    'form_button_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );
        
                $this->add_control(
                    'form_button_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .form-submit .submit:hover'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'form_button_background_hover',
                        'selector'  =>  '{{WRAPPER}} .form-submit .submit:hover',
                        'exclude'   =>  ['image'],
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name'  =>  'form_button_box_shadow_hover',
                        'selector'  =>  '{{WRAPPER}} .form-submit .submit:hover'
                    ]
                );
        
                $this->end_controls_tab();
            $this->end_controls_tabs();
        
            $this->insert_divider();
        
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name'  =>  'form_button_border',
                    'selector'  =>  '{{WRAPPER}} .form-submit .submit'
                ]
            );
        
            $this->add_control(
                'form_button_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::NUMBER,
                    'min'   =>  0,
                    'max'   =>  1000,
                    'step'  =>   1,
                    'default'   =>  3,
                    'selectors' =>  [
                        '{{WRAPPER}} .form-submit .submit'  =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );
        
            $this->insert_divider();
        
            $this->get_spacing_control( 'form_button_padding', 'Padding', '.form-submit .submit', 'padding', [ 15, 20, 15, 20 ] );

            $this->get_spacing_control( 'form_button_margin', 'Margin', '.form-submit .submit', 'margin' );
        $this->end_controls_section();

        $this->start_controls_section(
            'comments_title_section',
            [
                'label' =>  esc_html__( 'Comments Title', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' =>  'comments_title_typography',
                    'selector'  =>  '{{WRAPPER}} .comments-title, {{WRAPPER}} .comments-title span'
                ]
            );

            $this->add_control(
                'comments_title_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .comments-title'  =>  'color: {{VALUE}}'
                    ]
                ]
            );
    
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'comments_title_background',
                    'selector'  =>  '{{WRAPPER}} .comments-title',
                    'exclude'   =>  ['image']
                ]
            );
    
            $this->add_control(
                'comments_title_alignment',
                [
                    'label' =>  esc_html__( 'Alignment','news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::CHOOSE,
                    'default'  => 'left',
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
                        '{{WRAPPER}} .comments-title'  =>  'text-align: {{VALUE}}'
                    ]
                ]
            );
            $this->insert_divider();
            $this->get_spacing_control( 'comments_title_padding', 'Padding', '.comments-title', 'padding' );
            $this->get_spacing_control( 'comments_title_margin', 'Margin', '.comments-title', 'margin', [ 10, 0, 12, 0 ] );
        $this->end_controls_section();

        $this->start_controls_section(
            'comments_content_section',
            [
                'label' =>  esc_html__( 'Comments Content', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' =>  'comments_content_typography',
                    'selector'  =>  '{{WRAPPER}} .comment-content p'
                ]
            );

            $this->add_control(
                'comments_content_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .comment-content p'  =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'comments_content_background',
                    'selector'  =>  '{{WRAPPER}} .comment-content p',
                    'exclude'   =>  ['image']
                ]
            );
    
            $this->add_control(
                'comments_content_alignment',
                [
                    'label' =>  esc_html__( 'Alignment','news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::CHOOSE,
                    'default'  => 'left',
                    'options'   =>  [
                        'left'  =>  [
                            'content' =>  esc_html__( 'Left','news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-left'
                        ],
                        'center'  =>  [
                            'content' =>  esc_html__( 'Center','news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-center'
                        ],
                        'right'  =>  [
                            'content' =>  esc_html__( 'Right','news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-right'
                        ]
                    ],
                    'toggle'    =>  false,
                    'frontend_available' => true,
                    'selectors' =>  [
                        '{{WRAPPER}} .comment-content p'  =>  'text-align: {{VALUE}}'
                    ]
                ]
            );
            $this->insert_divider();
            $this->get_spacing_control( 'comments_content_padding', 'Padding', '.comment-content p', 'padding', [0 , 0 , 15, 60] );
            $this->get_spacing_control( 'comments_content_margin', 'Margin', '.comment-content', 'margin' );
        $this->end_controls_section();

        $this->start_controls_section(
            'comment_metadata_section',
            [
                'label' =>  esc_html__( 'Comments Meta', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' =>  'comment_metadata_typography',
                    'selector'  =>  '{{WRAPPER}} .comment-metadata'
                ]
            );

            $this->add_control(
                'comment_metadata_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .comment-metadata time'  =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'comment_metadata_background',
                    'selector'  =>  '{{WRAPPER}} .comment-metadata',
                    'exclude'   =>  ['image']
                ]
            );
    
            $this->insert_divider();

            $this->add_control(
                'comment_author_image_heading',
                [
                    'label' =>  esc_html__( 'Comment Author Image', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::HEADING
                ]
            );

            $this->get_spacing_control( 'comment_metadata_padding', 'Padding', '.comment-body .comment-author img', 'padding' );
            $this->get_spacing_control( 'comment_metadata_margin', 'Margin', '.comment-body .comment-author img', 'margin', [0,15,10,0] );
        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="nekit-single-comment-box">
            <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>
        </div>
    <?php
    }
 }