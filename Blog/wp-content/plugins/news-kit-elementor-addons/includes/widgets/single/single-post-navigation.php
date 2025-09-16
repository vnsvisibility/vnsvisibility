<?php
/**
 * Single Post Navigation Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Post_Navigation extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-post-navigation';

    public function get_keywords() {
        return [ 'post','navigation','single' ];
    }

    protected function register_controls() {
        // General Section
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-post-navigation" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'show_title',
            [
                'label' =>  esc_html__( 'Show Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes',
                'seperator' =>  'after'
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' =>  esc_html__( 'Show Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
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
                        'step'  =>  1 
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  15
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .previous-icon'    =>  'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .next-icon'    =>  'margin-right: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'icon_size',
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
                    'unit'  =>  'px',
                    'size'  =>  15
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-icon'    =>  'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'previous_button_icon',
            [
                'label' =>  esc_html__( 'Previous Button Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
                    'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-arrow-left'
                ],
                'exclude_inline_options'    =>  ['svg'],
                'condition' =>  [
                    'show_icon' =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'next_button_icon',
            [
                'label' =>  esc_html__( 'Next Button Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
                'recommended'   => [
                    'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
                    'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
                ],
                'default'   =>  [
                    'library'   =>  'fa-solid',
                    'value' =>  'fas fa-arrow-right'
                ],
                'exclude_inline_options'    =>  ['svg'],
                'condition' =>  [
                    'show_icon' =>  'yes'
                ]
            ]
        );

        $this->insert_divider();

        $this->add_control(
            'show_previous_next_label',
            [
                'label' =>  esc_html__( 'Show Previous Label', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'previous_label',
            [
                'label' =>  esc_html__( 'Previous Label', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Previous', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'show_previous_next_label'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'next_label',
            [
                'label' =>  esc_html__( 'Next Label', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Next', 'news-kit-elementor-addons' ),
                'condition' =>  [
                    'show_previous_next_label'   =>  'yes'
                ]
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label' =>  esc_html__( 'Show Content', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );
        
        $this->add_control(
            'content_length',
            [
                'label' =>  esc_html__( 'Content Length', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  100000,
                'step'  =>  1,
                'default'   => 5
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' =>  esc_html__( 'Show Thumbnail', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' =>  esc_html__( 'Show Date', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_setting_section',
            [
                'label' =>  esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'image_sizes',
            [
                'label' =>  esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'medium',
                'options'   =>  $this->get_image_sizes(),
                'label_block'   =>  true
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' =>  esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'   =>  1
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nav-thumbnail-wrap'  =>  'width: {{SIZE}}%'
                ]
            ]

        );

        $this-> add_responsive_control(
            'image_ratio',
            [
                'label' =>  esc_html__( 'Image Ratio', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px' =>  [
                        'min'   =>  0,
                        'max'   =>  2,
                        'step'   =>  .1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0.1
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nav-thumbnail-wrap'  =>  'padding-bottom: calc( {{SIZE}} * 100% );'
                ]
            ]
        );

        $this->get_spacing_control( 'border_radius', 'Border Radius(px)', '.post-thumbnail', 'border-radius' );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .nav-thumbnail-wrap'
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'label_section',
            [
                'label' =>  esc_html__( 'Label', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'label_typography',
                'selector' =>  '{{WRAPPER}} .nav-label'
            ]
        );

            $this->start_controls_tabs(
                'label_tabs'
            );
                $this->start_controls_tab(
                    'label_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'label_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .nav-label, {{WRAPPER}} .nav-icon' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'label_background',
                        'selector' =>  '{{WRAPPER}} .previous-title-context-wrap, .next-title-context-wrap',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'label_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'label_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .previous-content-wrap:hover .nav-label, {{WRAPPER}} .previous-content-wrap:hover .nav-icon' =>  'color: {{VALUE}}',
                            '{{WRAPPER}} .next-content-wrap:hover .nav-label, {{WRAPPER}} .next-content-wrap:hover .nav-icon' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'label_background_hover',
                        'selector' =>  '{{WRAPPER}} .previous-title-context-wrap:hover, .next-title-context-wrap:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();
            
            $this->insert_divider();
            
            $this->add_responsive_control(
                'label_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .previous-title-context-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .next-title-context-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
            
            $this->add_responsive_control(
                'label_margin',
                [
                    'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .previous-title-context-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .next-title-context-wrap'  =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

        $this->end_controls_section();

        //Title Section
        $this->start_controls_section(
            'title_section',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'title_typography',
                'selector' =>  '{{WRAPPER}} .nav-title'
            ]
        );

            $this->start_controls_tabs(
                'title_tabs'
            );
                $this->start_controls_tab(
                    'title_initial',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'title_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .nav-title' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'title_background',
                        'selector' =>  '{{WRAPPER}} .nav-title',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();
                $this->start_controls_tab(
                    'title_hover',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'title_color_hover',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .nav-title:hover' =>  'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name' =>  'title_background_hover',
                        'selector' =>  '{{WRAPPER}} .nav-title:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();
            
        $this->insert_divider();

        $this->get_spacing_control( 'title_padding', 'Padding', '.nav-title', 'padding' );

        $this->get_spacing_control( 'title_margin', 'Margin', '.nav-title', 'margin' );

        $this->end_controls_section();

        //Excerpt Styles Section
        $this->start_controls_section(
            'excerpt_styles_section',
            [
                'label' =>  esc_html__( 'Excerpt', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'excerpt_typography',
                'selector' =>  '{{WRAPPER}} .nav-excerpt'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .nav-excerpt' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'excerpt_background',
                'selector' =>  '{{WRAPPER}} .nav-excerpt',
                'exclude'   =>  ['image']
            ]
        );
            
        $this->insert_divider();
    
        $this->get_spacing_control( 'excerpt_padding', 'Padding', '.nav-excerpt', 'padding' );

        $this->get_spacing_control( 'excerpt_margin', 'Margin', '.nav-excerpt', 'margin' );
        
        $this->end_controls_section();

        //Date styles Section
        $this->start_controls_section(
            'content_styles_section',
            [
                'label' =>  esc_html__( 'Content', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'content_typography',
                'selector' =>  '{{WRAPPER}} .previous-post-content-wrap'
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-post-navigation .nav-date' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'content_background',
                'selector' =>  '{{WRAPPER}} .previous-post-content-wrap',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'content_padding', 'Padding', '.previous-post-content-wrap', 'padding' );
        
        $this->get_spacing_control( 'content_margin', 'Margin', '.previous-post-content-wrap', 'margin' );

        $this->end_controls_section();
        //Date styles Section
        $this->start_controls_section(
            'date_styles_section',
            [
                'label' =>  esc_html__( 'Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>  'date_typography',
                'selector' =>  '{{WRAPPER}} .date-wrap'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .nav-date' =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' =>  'date_background',
                'selector' =>  '{{WRAPPER}} .nav-date',
                'exclude'   =>  ['image']
            ]
        );

        $this->insert_divider();

        $this->get_spacing_control( 'date_padding', 'Padding', '.nav-date', 'padding' );
        
        $this->get_spacing_control( 'date_margin', 'Margin', '.nav-date', 'margin' );

        $this->end_controls_section();

    }

    protected function render_template() {
        $settings = $this->get_settings_for_display();
        $show_thumbnail = ( $settings['show_thumbnail'] == 'yes' ) ? 'show-thumbnail--yes' : 'show-thumbnail--no';
        ?>
        <div class="nekit-single-post-navigation <?php echo esc_html( $show_thumbnail );?>">
            <?php
                $previous_title = $previous_icon =  $previous_label = $previous_content = $previous_thumbnail = $previous_date = '';
                $next_title = $next_icon = $next_label = $next_content = $next_thumbnail = $next_date = '';
                //For Title
                if(  $settings['show_title'] == 'yes' ):
                    $previous_title = '<h2 class="nav-title previous-title">%title</h2>';
                    $next_title = '<h2 class="nav-title next-title">%title</h2>';
                endif;

                //For Icon
                if( $settings['show_icon']  == 'yes' ):
                    $previous_icon = '<span class="nav-icon previous-icon">' . nekit_get_base_value( [ 'icon' => $settings['previous_button_icon'] ] ) . '</span>';
                    $next_icon = '<span class="nav-icon next-icon">' . nekit_get_base_value( [ 'icon' => $settings['next_button_icon'] ] ) . '</span>';
                endif;

                //For Label
                if( $settings['show_previous_next_label'] == 'yes' ):
                    $previous_label = '<span class="nav-label previous-label">' . esc_html( $settings['previous_label'] ) . '</span>';
                    $next_label = '<span class="nav-label next-label">' . esc_html( $settings['next_label'] ) . '</span>';
                endif;

                $previous = get_previous_post();
                $next = get_next_post();
                if( $settings['show_content'] == 'yes' ):
                    $previous_content = ( $previous != '' ) ? '<div class="nav-excerpt">' . esc_html( wp_trim_words( $previous->post_content, $settings['content_length'] ) ) . '</div>' : '';
                    $next_content = ( $next != '' ) ? '<div class="nav-excerpt">' . esc_html( wp_trim_words( $next->post_content, $settings['content_length'] ) ) . '</div>' : '';
                endif;

                if( $settings['show_thumbnail'] == 'yes' ):
                    $previous_thumbnail = ( $previous != '' ) ? '<figure class="previous-post-thumbnail-wrap nav-thumbnail-wrap">' . get_the_post_thumbnail( $previous->ID, $settings['image_sizes'], [ 'class' =>  'post-thumbnail previous-post-thumb' ] ) . '</figure>' : '';

                    $next_thumbnail = ( $next != '' ) ? '<figure class="next-post-thumbnail-wrap nav-thumbnail-wrap">' . get_the_post_thumbnail( $next->ID, $settings['image_sizes'], [ 'class' =>  'post-thumbnail next-post-thumb' ] ) . '</figure>' : '';
                endif;

                if( $settings['show_date'] == 'yes' ):
                    $previous_date = ( $previous != '' ) ? '<span class="nav-date">' . esc_html( $previous->post_date ) . '</span>' : '';
                    $next_date = ( $next != '' ) ? '<span class="nav-date">' . esc_html( $next->post_date ) . '</span>' : '';
                endif;

            ?>
			<div class="previous-post-wrap <?php if( get_previous_post_link() ) { if( empty( get_the_post_thumbnail( $previous->ID ) ) ) echo 'no-feat-img'; } ?>" >
                <?php 
                    previous_post_link( '%link', $previous_thumbnail . '<div class="previous-content-wrap"><span class="previous-title-context-wrap">' . $previous_label . $previous_icon . '</span>' . '<div class="previous-post-title-content-wrap">'. $previous_title . $previous_content . '</div>' . $previous_date . '</div>');
                ?>
			</div>
			<div class="next-post-wrap <?php if( get_next_post_link() ) { if( empty( get_the_post_thumbnail( $next->ID ) ) ) echo 'no-feat-img'; } ?>">
                <?php
                    next_post_link( '%link', '<div class="next-content-wrap"><span class="next-title-context-wrap">' . $next_icon . $next_label . '</span>' . '<div class="next-post-title-content-wrap">'. $next_title . $next_content . '</div>' . $next_date . '</div>' . $next_thumbnail );
                ?>
			</div>
		</div>
    <?php
    }
 }