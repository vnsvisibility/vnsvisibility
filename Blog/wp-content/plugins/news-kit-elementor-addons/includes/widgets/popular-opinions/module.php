<?php 
/**
 * Popular Opinions Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Popular_Opinions_Module extends \Nekit_Widget_Base\Base {
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/popular-opinions" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'widget_skin',
            [
                'label' =>  esc_html__( 'Skin', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'classic',
                'options'   =>  [
                    'classic'   =>  esc_html__( 'Classic', 'news-kit-elementor-addons' ),
                    'card'  =>  esc_html__( 'Card', 'news-kit-elementor-addons' )
                ]
            ]
        );

        $this->add_control(
            'items_orientation',
            [
                'label' => esc_html__( 'Items Orientation', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'default'   => 'horizontal',
                'options'   => [
                    'horizontal'=> [
                        'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-navigation-horizontal'
                    ],
                    'vertical'  => [
                        'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
                        'icon'  => 'eicon-navigation-vertical'
                    ]
                ],
                'toggle'    => false
            ]
        );

        $this->add_responsive_control(
            'no_of_columns',
            [
                'label' => esc_html__( 'No of columns', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'min'   => 1,
                'max'   => apply_filters( 'nekit_opinions_column_max_value_filter', 3 ),
                'step'  => 1,
                'default'   => 3
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
                        '{{WRAPPER}} .post-elements' => 'text-align: {{VALUE}};'
                    ]
                ]
            );
        $this->insert_divider();
        $this->end_controls_section();

        $this->start_controls_section(
            'post_section',
            [
                'label' =>  esc_html__( 'Opinions', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'image_icon_option',
                [
                    'label' =>  esc_html__( 'Choose Image / Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                    'default'   =>  'icon',
                    'options'   =>  [
                        'icon'  =>  [
                            'title' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-wordpress'
                        ],
                        'image' =>  [
                            'title' =>  esc_html__( 'Image', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-image-box'
                        ]
                    ],
                    'toggle'    =>  false,
                    'label_block'   =>  true
                ]
            );

            $repeater->add_control(
                'post_image',
                [
                    'label' =>  esc_html__( 'Post Image', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::MEDIA,
                    'default'   =>  [
                        'url'   =>  \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' =>  [
                        'image_icon_option' => 'image'
                    ]
                ]
            );

            $repeater->add_control(
                'post_icon',
                [
                    'label' =>  esc_html__( 'Post Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'label_block'  =>  false,
                    'skin'  =>  'inline',
                    'recommended'   => [
                        'fa-solid'  => ['comment','comments','comment-dots'],
                        'fa-regular'  => ['comment','comments']
                    ],
                    'default'   =>  [
                        'value' =>  'far fa-comment',
                        'library'   =>  'fa-regular'
                    ],
                    'exclude_inline_options'    =>  'svg',
                    'condition' =>  [
                        'image_icon_option' => 'icon'
                    ]
                ]
            );

        $repeater->add_control(
			'post_title',
			[
				'label' => esc_html__( 'Opinions Title', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
				'label_block'   => true
			]
		);

        $repeater->add_control(
            'post_url',
            [
                'label' =>  esc_html__( 'Opinions Url', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::URL,
                'options'   =>  ['url','is_external'],
                'default'   =>  [
                    'url'   =>  '',
                    'is_external'   =>  true
                ],
                'label_block'   =>  true
            ]
        );

        $repeater->add_control(
            'post_meta',
            [
                'label' =>  esc_html__( 'Opinions Meta', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'popular_opinions',
            [
                'label' =>  esc_html__( 'Opinions List', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::REPEATER,
                'fields'    =>  $repeater->get_controls(),
                'default'   =>  [
                    [
                        'post_title'    =>  esc_html__( 'Hola !', 'news-kit-elementor-addons' ),
                        'post_meta' =>  esc_html__( 'Add opinions here', 'news-kit-elementor-addons' )
                    ],
                    [
                        'post_title'    =>  esc_html__( 'Hola !', 'news-kit-elementor-addons' ),
                        'post_meta' =>  esc_html__( 'Add opinions here', 'news-kit-elementor-addons' )
                    ],
                    [
                        'post_title'    =>  esc_html__( 'Hola !', 'news-kit-elementor-addons' ),
                        'post_meta' =>  esc_html__( 'Add opinions here', 'news-kit-elementor-addons' )
                    ]
                ],
                'title_field'   =>  '{{{post_title}}}'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'hover_animation_section',
            [
                'label' =>  esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->post_title_animation_type_control();
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
					'{{WRAPPER}} .nekit-popular-opinions' => 'column-gap: {{SIZE}}{{UNIT}};'
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
					'{{WRAPPER}} .nekit-popular-opinions' => 'row-gap: {{SIZE}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_section();

        $this->add_card_skin_style_control();

        $this->start_controls_section(
            'opinion_title_typography',
            [
                'label' =>  esc_html__( 'Opinions Title', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  esc_html__( 'opinions_title_typography', 'news-kit-elementor-addons' ),
                'selector'  =>  '{{WRAPPER}} .post-title'
            ]
        );

            $this->start_controls_tabs(
                'post_title_tabs'
            );
                $this->start_controls_tab(
                    'post_title_initial_tab',
                    [
                        'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'post_title_color',
                    [
                        'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'default'   =>  '#000000',
                        'selectors' =>  [
                            '{{WRAPPER}} .post-title a' => 'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'opinions_title_background',
                        'selector'  =>  '{{WRAPPER}} .post-title a',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'post_title_hover_tab',
                    [
                        'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                    ]
                );

                $this->add_control(
                    'post_title_hover_color',
                    [
                        'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                        'type'  =>  \Elementor\Controls_Manager::COLOR,
                        'selectors' =>  [
                            '{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}}'
                        ]
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Background::get_type(),
                    [
                        'name'  =>  'opinions_title_background_hover',
                        'selector'  =>  '{{WRAPPER}} .post-title a:hover',
                        'exclude'   =>  ['image']
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->insert_divider();

            $this->add_responsive_control(
                'post_title_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px','%','em','custom' ],
                    'selectors'     =>  [
                        '{{WRAPPER}} .post-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'post_title_margin',
                [
                    'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px','%','em','custom' ],
                    'default'   =>  [
                        'top'   =>  0,
                        'right' =>  0,
                        'bottom'    =>  0,
                        'left'  =>  0,
                        'unit'  => 'px',
                        'isLinked'  =>  true
                    ],
                    'selectors'     =>  [
                        '{{WRAPPER}} .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );
        $this->end_controls_section();

        //Post Meta
        $this->start_controls_section(
            'post_meta_section',
            [
                'label' =>  esc_html__( 'Opinions Meta', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  esc_html__( 'opinions_meta_typography', 'news-kit-elementor-addons' ),
                'selector'  =>  '{{WRAPPER}} .nekit-popular-opinions .post-meta',
                'fields_options'  => [
                    'typography'  => [
                        'default' => 'custom'
                    ],
                    'font_size'   =>  [
                        'default' => [
                            'unit' => 'px',
                            'size' => 12
                        ]
                    ],
                    'font_weight' => [
                        'default' => 400
                    ],
                    'font_family' => [
                        'default' => 'Lexend'
                    ]
                ]
            ]
        );

        $this-> add_control(
            'post_meta',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#818181',
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-popular-opinions .post-meta' =>  'color:{{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'opinions_meta_background',
                'selector'  =>  '{{WRAPPER}} .post-meta',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_responsive_control(
            'post_meta_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),  
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','%','em','custom' ],
                'selectors'     =>  [
                    '{{WRAPPER}} .post-meta' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]   
        );

        $this->add_responsive_control(
            'post_meta_margin',
            [
                'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),  
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','%','em','custom' ],
                'default'   =>  [
                    'top'   =>  5,
                    'right' =>  0,
                    'bottom'    =>  0,
                    'left'  =>  0,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'selectors'     =>  [
                    '{{WRAPPER}} .post-meta' =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]   
        );

        $this->end_controls_section();

        // Image Settings
        $this->start_controls_section(
            'image_setting_section',
            [
                'label' =>  esc_html__( 'Image / Icon Settings', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->add_control(
            'image_settings_icon_settings',
            [
                'label' =>  esc_html__( 'Icon Controls', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  10,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  15
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-icon' =>  'font-size:{{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .post-icon' =>  'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_distance',
            [
                'label' =>  esc_html__( 'Icon / Image Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-popular-opinions .nekit-item-box-wrap'    =>  'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->insert_divider();
        
        $this->add_control(
            'image_settings_image_header',
            [
                'label' =>  esc_html__( 'Image Controls', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'images_sizes',
            [
                'label' =>  esc_html__( 'Images Sizes', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'medium',
                'label_block'   =>  true,
                'options'   =>  $this->get_image_sizes()
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-image'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'button_box_shadow',
                'selector'  =>  '{{WRAPPER}} .post-image'
            ]
        );

        $this->add_responsive_control(
            'image_width',
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
                    'size'  =>  25,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .selected--image .post-image'    =>  'width:{{SIZE}}%'
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
                        'step' => .1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => .2
                ],
                'selectors' => [
                    '{{WRAPPER}} .selected--image .post-image' => 'padding-bottom: calc( {{SIZE}} * 100% );'
                ]
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  => 1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .selected--image .post-image' => 'border-radius: {{VALUE}}px'
                ]
            ]
        );
        $this->end_controls_section();

        $this->add_image_overlay_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-popular-opinions';
        $elementClass .= esc_attr( " skin--". $settings['widget_skin'] );
        $elementClass .= esc_attr( " widget-orientation--". $settings['items_orientation'] );
        $elementClass .= esc_attr( " column--" . nekit_convert_number_to_numeric_string( $settings['no_of_columns'] ) );
        $elementClass .= esc_attr( " alignment--". $settings['alignment'] );
        $titleClass = 'post-title';
        if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );
        $widget_column_tablet = isset( $settings['no_of_columns_tablet'] ) ? $settings['no_of_columns_tablet'] : 3;
        $widget_column_mobile = isset( $settings['no_of_columns_mobile'] ) ? $settings['no_of_columns_mobile'] : 1;
        $elementClass .= esc_attr( " column-tablet--" . nekit_convert_number_to_numeric_string( $widget_column_tablet ) );
        $elementClass .= esc_attr( " column-mobile--" . nekit_convert_number_to_numeric_string( $widget_column_mobile ) );
        $elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
        $this->add_render_attribute( 'wrapper','class',$elementClass );
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' ) ); ?>>
            <?php 
                if( $settings['popular_opinions'] ):
                    foreach( $settings['popular_opinions'] as $repeater ):
                        if( ! empty( $repeater['post_url']['url'] ) ) $this->add_link_attributes( 'website_url', $repeater['post_url'] );
                        $href = ( ! empty( $repeater['post_url']['url'] ) ) ? $repeater['post_url']['url'] : '';
                        $target = ( $repeater['post_url']['is_external'] == true ) ? '_blank' : '_self';
                        $image_or_icon = ( $repeater['image_icon_option'] == 'image' ) ? 'selected--image' : 'selected--icon';
                        ?>
                        <div class="popular-opinions-item post-item <?php echo esc_attr( $image_or_icon ); ?>">
                            <div class="nekit-item-box-wrap">
                                <?php
                                    if( nekit_get_base_value( ['icon' => $repeater['post_icon'] ] ) || !empty( $repeater['post_image']) && $repeater['post_image']['url'] ) :
                                ?>
                                    <figure class="post-image <?php if( $repeater['image_icon_option'] == 'icon' ) echo 'post-icon'; ?>">
                                            <?php
                                                if( $repeater['image_icon_option'] == 'image' ) :
                                                    ?>
                                                    <div class="post-thumb-parent <?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                                        <?php 
                                                            if( !empty( $repeater['post_image']) && $repeater['post_image']['url'] ) echo '<img src="'.  esc_url( $repeater['post_image']['url'] ) . '">';
                                                        ?>
                                                    </div>
                                                <?php
                                                elseif( $repeater['image_icon_option'] == 'icon' ) :
                                                    echo wp_kses_post( nekit_get_base_value( ['icon' => $repeater['post_icon'] ] ) );
                                                endif;
                                            ?>
                                    </figure>
                                <?php
                                endif;

                                if( ! empty ( $repeater['post_title'] ) || ! empty ( $repeater['post_meta'] ) ) : 
                                    echo '<div class="post-elements">';
                                        if( ! empty ( $repeater['post_title'] ) ) : ?>
                                            <h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>>
                                                <a href="<?php echo esc_attr( $href ); ?>" target="<?php echo esc_attr( $target ); ?>">
                                                    <?php echo esc_html($repeater['post_title']); ?>
                                                </a>
                                            </h2>
                                        <?php 
                                            endif;
                                            if( ! empty( $repeater['post_meta'] ) ) echo '<div class="post-meta">' . esc_html( $repeater['post_meta'] ) . '</div>';
                                    echo '</div><!-- .post-elements-->';
                                endif; ?>
                            </div>
                        </div>
                    <?php
                    continue;
                    endforeach;
                endif;
            ?>
        </div>
    <?php
    }
 }