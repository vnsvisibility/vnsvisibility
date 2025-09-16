<?php
/**
 * Single Author Box Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Author_Box extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-author-box';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-author-box';
    }

    public function get_keywords() {
        return ['single', 'author', 'box'];
    }

    public function get_open_in_new_tab_control( $id = '' ) {
        $this->add_control(
            $id,
            [
                'label' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  '_self',
                'options'   =>  [
                    '_self' =>  esc_html__( 'Open in same tab', 'news-kit-elementor-addons' ),
                    '_blank' =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' )
                ]
            ]
        );
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-author-box" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'alignment',
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
                'toggle'    =>  false,
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-author-box'  =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'image_position',
            [
                'label' =>  esc_html__( 'Image Position', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'toggle'    =>  false,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-left'
                    ],
                    'above'  =>  [
                        'title' =>  esc_html__( 'Above', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-v-align-top'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right','news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-h-align-right'
                    ]
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_profile_picture',
            [
                'label' =>  esc_html__( 'Show Profile Picture', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' =>  esc_html__( 'Image Height', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  500,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  100
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .author-profile-picture img'   =>  'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' =>  esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  500,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  100
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .author-profile-picture img'   =>  'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_display_name',
            [
                'label' =>  esc_html__( 'Show Display Name', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'html_tags',
            [
                'label' =>  esc_html__( 'Html Tags', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'h2',
                'options'   =>  $this->get_html_tags(),
                'condition' =>  [
                    'show_display_name' =>  'yes'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_email',
            [
                'label' =>  esc_html__( 'Show Email', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );



        $this->add_control(
            'show_biography_info',
            [
                'label' =>  esc_html__( 'Show Biography Info', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_website',
            [
                'label' =>  esc_html__( 'Show Website', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->get_open_in_new_tab_control( 'open_in_new_tab' );

        $this->insert_divider();

        $this->add_control(
            'show_social_platforms',
            [
                'label' =>  esc_html__( 'Show Social Platforms', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->get_open_in_new_tab_control( 'social_platforms_open_in_new_tab' );

        $this->add_control(
            'social_platform_icon_size',
            [
                'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  18,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .platform-icon'    =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        //Author Box Styles
        $this->start_controls_section(
            'general_styles_section',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'author_box_shadow',
                'selector' =>  '{{WRAPPER}} .nekit-single-author-box'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'author_border',
                'selector' =>  '{{WRAPPER}} .nekit-single-author-box'
            ]
        );

        $this->add_control(
            'author_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-author-box'  =>  'border-radius: {{VALUE}}%'
                ]
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'section_padding', 'Section Padding', '.nekit-single-author-box', 'padding' );

        $this->get_spacing_control( 'section_margin', 'Section Margin', '.nekit-single-author-box', 'margin' );

        $this->end_controls_section();


        //Display Name Styles
        $this->start_controls_section(
            'display_name_styles',
            [
                'label' =>  esc_html__( 'Display Name', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'display_name_typography',
                'selector'  =>  '{{WRAPPER}} .author-display-name'
            ]
        );

        $this->add_control(
            'display_name_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .author-display-name'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'display_name_background_color',
                'selector' => '{{WRAPPER}} .author-display-name',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'display_name_padding', 'Padding', '.author-display-name', 'padding' );

        $this->get_spacing_control( 'display_name_margin', 'Margin', '.author-display-name', 'margin', [ 0, 0, 8, 0 ] );

        $this->insert_divider();
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'display_name_border',
                'selector' =>  '{{WRAPPER}} .author-display-name'
            ]
        );

        $this->add_control(
            'display_name_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .author-display-name'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->end_controls_section();

        //Profile Picture Styles
        $this->start_controls_section(
            'profile_picture_styles',
            [
                'label' =>  esc_html__( 'Profile Picture','news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
      
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'profile_picture_border',
                'selector' =>  '{{WRAPPER}} .author-profile-picture img'
            ]
        );

        $this->add_control(
            'profile_picture_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  500,
                'step'  =>  1,
                'default'   =>  100,
                'selectors' =>  [
                    '{{WRAPPER}} .author-profile-picture img'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->end_controls_section();

        //Email Styles Section
        $this->start_controls_section(
            'email_styles',
            [
                'label' =>  esc_html__( 'Email','news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'email_typography',
                'selector'  =>  '{{WRAPPER}} .author-email'
            ]
        );

        $this->add_control(
            'email_color',
            [
                'label' =>  esc_html__( 'Color','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .author-email'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'email_background_color',
                'selector' => '{{WRAPPER}} .author-email',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'email_padding', 'Padding', '.author-email', 'padding' );

        $this->get_spacing_control( 'email_margin', 'Margin', '.author-email', 'margin', [ 0, 0, 6, 0 ] );

        $this->insert_divider();
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'email_border',
                'selector' =>  '{{WRAPPER}} .author-email'
            ]
        );

        $this->add_control(
            'email_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .author-email'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->end_controls_section();

        //Biography Styles Section
        $this->start_controls_section(
            'biography_styles',
            [
                'label' =>  esc_html__( 'Biography', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'biography_typography',
                'selector'  =>  '{{WRAPPER}} .author-biography'
            ]
        );
        
        $this->add_control(
            'biography_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#363636',
                'selectors' =>  [
                    '{{WRAPPER}} .author-biography'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'biography_background_color',
                'selector' => '{{WRAPPER}} .author-biography',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();
        
        $this->get_spacing_control( 'biography_padding', 'Padding', '.author-biography', 'padding' );

        $this->get_spacing_control( 'biography_margin', 'Margin', '.author-biography', 'margin' );

        $this->insert_divider();
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'biography_border',
                'selector' =>  '{{WRAPPER}} .author-biography'
            ]
        );
        
        $this->add_control(
            'biography_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .author-biography'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );
        
        $this->end_controls_section();

        //Url Styles Section
        $this->start_controls_section(
            'url_styles',
            [
                'label' =>  esc_html__( 'Website Url', 'news-kit-elementor-addons' ),
                'tab'   =>   \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'url_typography',
                'selector'  =>  '{{WRAPPER}} .author-url a'
            ]
        );
        
            $this->start_controls_tabs(
                'url_tabs'
            );
                $this->start_controls_tab(
                    'url_initial_tab',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );
        
                $this->add_control(
                    'url_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#444',
                        'selectors' =>  [
                            '{{WRAPPER}} .author-url a'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'url_background_color',
                        'selector' => '{{WRAPPER}} .author-url',
                        'exclude'   =>  ['image']
                    ]
                );
        
                $this->end_controls_tab();
                $this->start_controls_tab(
                    'url_hover_tab',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );
        
                $this->add_control(
                    'url_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .author-url:hover a'  =>  'color: {{VALUE}}'
                        ]
                    ]
                );
        
                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'url_background_color_hover',
                        'selector' => '{{WRAPPER}} .author-url:hover',
                        'exclude'   =>  ['image']
                    ]
                );
        
                $this->end_controls_tab();
            $this->end_controls_tabs();
        
        $this->insert_divider();

        $this->get_spacing_control( 'url_padding', 'Padding', '.author-url', 'padding' );

        $this->get_spacing_control( 'url_margin', 'Margin', '.author-url', 'margin', [ 4, 0, 0, 0 ] );

        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'url_border',
                'selector' =>  '{{WRAPPER}} .author-url'
            ]
        );
        
        $this->add_control(
            'url_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .author-url'  =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'social_platform_styles',
            [
                'label' =>  esc_html__( 'Social Platform Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs(
            'social_platform_tabs'
        );
            $this->start_controls_tab(
                'social_platform_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'social_platform_icon_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default' => '#000',
                    'selectors' =>  [
                        '{{WRAPPER}} .platform-icon a'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'social_platform_background',
                    'selector'  =>  '{{WRAPPER}} .platform-icon a',
                    'exclude'   =>  ['image']
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'social_platform_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'social_platform_icon_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'selectors' =>  [
                        '{{WRAPPER}} .platform-icon:hover a'    =>  'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'social_platform_background_hover',
                    'selector'  =>  '{{WRAPPER}} .platform-icon:hover a',
                    'exclude'   =>  ['image']
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->insert_divider();

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'social_platforms_box_shadow',
                'selector' =>  '{{WRAPPER}} .platform-icon a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'social_platforms_border',
                'selector' =>  '{{WRAPPER}} .platform-icon a'
            ]
        );

        $this->add_control(
            'social_platform_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .platform-icon a'    =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'social_platform_icon_padding', 'Padding', '.platform-icon a', 'padding' );

        $this->get_spacing_control( 'social_platform_icon_margin', 'Margin', '.social-platforms-wrap', 'margin', [ 10, 0, 0, 0 ] );

        $this->end_controls_section();
    }

    protected function render_template(){
        $settings = $this->get_settings_for_display();
        $email = get_the_author_meta( 'user_email' );
        $profile_picture  = get_avatar_url( $email );
        $display_name = get_the_author_meta( 'display_name' );
        $biography = get_the_author_meta( 'description' );
        $website = get_the_author_meta( 'user_url' );
        $elementClass = 'nekit-single-author-box';
        $elementClass .= esc_attr( " position--" . $settings['image_position'] );
        $elementClass .= esc_attr( " alignment--" . $settings['alignment'] );
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
            <div class="author-display-name-picture-wrap">

                <?php
                    if( $settings['show_profile_picture'] == 'yes' ):
                        ?>
                            <figure class="author-profile-picture">
                                <img src="<?php echo esc_url( $profile_picture ); ?>">
                            </figure>
                        <?php
                    endif; 
                ?>

            </div> <!-- .author-display-name-picture-wrap -->
            
            <div class="author-meta-wrap">
                <div class="author-elements">
                    <?php
                        if( $display_name ):
                            if( $settings['show_display_name'] == 'yes' ) 
                                echo '<'. esc_attr($settings['html_tags']) . ' class="author-display-name">' . esc_html( $display_name ) . '</' . esc_attr($settings['html_tags']) . '>';
                        endif;

                        if( $email ):
                            if( $settings['show_email'] == 'yes' ) echo '<span class="author-email">' . esc_html( $email ) . '</span>';
                        endif;

                        if( $biography ):
                            if( $settings['show_biography_info'] == 'yes' ) echo '<p class="author-biography">' . esc_html( $biography ) . '</p>';
                        endif;

                        if( $website ):
                            if( $settings['show_website'] == 'yes' ) 
                                echo '<span class="author-url">
                                        <a href="'.esc_url(get_the_permalink()).'" target="'.esc_attr( $settings['open_in_new_tab'] ).'">' . esc_html( $website ) . '</a>
                                </span>';
                        endif;
                    ?>
                </div>
                <div class="social-platforms-wrap">
                    <?php
                        if( $settings['show_social_platforms'] == 'yes' ):
                            $social_platforms = nekit_get_social_platform_html( $settings['social_platforms_open_in_new_tab'] );
                            foreach( $social_platforms as $social_platform ):
                                echo wp_kses_post($social_platform);
                            endforeach;
                        endif;
                    ?>
                </div>
            </div>
        </div> <!-- .nekit-single-author-box -->
    <?php
    }
 }
