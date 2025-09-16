<?php
    /**
     * Nekit Divider Widget Module
     * 
     * @package News Kit Elementor Addons
     * @since 1.3.2
     */
    namespace Nekit_Modules;
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class Nekit_Divider_Widget_Module extends \Nekit_Widget_Base\Base {
        protected function register_controls() {
            /* Content => Divider */
            $this->start_controls_section(
                'divider_section',
                [
                    'label' =>  esc_html__( 'Divider', 'news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
                ]
            );

            $this->add_control(
                'custom_or_predefined',
                [
                    'label' =>  esc_html__( 'Divider', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SELECT,
                    'default'   =>  'predefined',
                    'options'   =>  [
                        'predefined'    =>  esc_html__( 'Predefined', 'news-kit-elementor-addons' ),
                        'custom'    =>  esc_html__( 'Custom', 'news-kit-elementor-addons' )
                    ]
               ]
            );

            $this->add_control(
                'predefined_layout',
                [
                    'label' => esc_html__( 'Predefined Dividers', 'news-kit-elementor-addons' ),
                    'type' => ( version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' ) ? \Elementor\Controls_Manager::VISUAL_CHOICE : 'nekit-radio-image-control' ),
                    'label_block' => true,
                    'options' => apply_filters( 'nekit_radio_image_control_options_filter', [
                        'one'   =>  [
                            'title' =>  esc_html__( 'Layout One','news-kit-elementor-addons' ),
                            'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/six.jpg'
                        ],
                        'two'   =>  [
                            'title' =>  esc_html__( 'Layout Two','news-kit-elementor-addons' ),
                            'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/five.jpg'
                        ],
                        'three'   =>  [
                            'title' =>  esc_html__( 'Layout Three','news-kit-elementor-addons' ),
                            'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/five.jpg'
                        ],
                        'four'   =>  [
                            'title' =>  esc_html__( 'Layout Four','news-kit-elementor-addons' ),
                            'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/five.jpg'
                        ]
                    ]),
                    'default' => 'one',
                    'columns' => 2,
                    'condition' =>  [
                        'custom_or_predefined'  =>  'predefined'
                    ]
                ]
            );

            $this->add_control(
                'add_a_divider',
                [
                    'label' =>  esc_html__( 'Add a Divider', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::MEDIA,
                    'default'   =>  [
                        'url'   =>  \Elementor\Utils::get_placeholder_image_src()
                    ],
                    'condition' =>  [
                        'custom_or_predefined'  =>  'custom'
                    ]
                ]
            );

            $this->add_responsive_control(
                'divider_width',
                [
                    'label' =>  esc_html__( 'Width', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SLIDER,
                    'size_units'    =>  [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                    'range' =>  [
                        'px'    =>  [
                            'max'   =>  1000
                        ]
                    ],
                    'default'   =>  [
                        'size'  =>  100,
                        'unit'  =>  '%'
                    ],
                    'tablet_default'    =>  [
                        'unit'  =>  '%'
                    ],
                    'mobile_default'    =>  [
                        'unit'  =>  '%'
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-divider'  =>  'width: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );
    
            $this->add_responsive_control(
                'divider_alignment',
                [
                    'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                    'options'   =>  [
                        'left'  =>  [
                            'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-left'
                        ],
                        'center'    =>  [
                            'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-center'
                        ],
                        'right' =>  [
                            'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-text-align-right'
                        ]
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-divider'    =>  'text-align: {{VALUE}}',
                        '{{WRAPPER}} .nekit-divider .separator'  =>  'margin: 0 auto; margin-{{VALUE}}: 0'
                    ]
               ]
            ); 
    
            $this->add_control(
                'add_element',
                [
                    'label' =>  esc_html__( 'Add Element', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                    'default'   =>  'none',
                    'options'   =>  [
                        'none'  =>  [
                            'title' =>  esc_html__( 'None', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-ban'
                        ],
                        'text' =>  [
                            'title' =>  esc_html__( 'Text', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-t-letter-bold'
                        ],
                        'icon' =>  [
                            'title' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                            'icon'  =>  'eicon-star'
                        ]
                    ],
                    'separator' =>  'before',
                    'toggle'    =>  false,
                    'condition' =>  [
                        'custom_or_predefined'  =>  'predefined'
                    ]
                ]
            );
    
            $this->add_control(
                'divider_text',
                [
                    'label' =>  esc_html__( 'Text', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::TEXT,
                    'default'   =>  esc_html__( 'Divider', 'news-kit-elementor-addons' ),
                    'condition' =>  [
                        'add_element'  =>  'text',
                        'custom_or_predefined'  =>  'predefined'
                    ]
                ]
            );
    
            $this->add_control(
                'html_tag',
                [
                    'label' =>  esc_html__( 'HTML Tag', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::SELECT,
                    'options'   =>  [
                        'h1'    =>  'H1',
                        'h2'    =>  'H2',
                        'h3'    =>  'H3',
                        'h4'    =>  'H4',
                        'h5'    =>  'H5',
                        'h6'    =>  'H6',
                        'div'   =>  'div',
                        'span'  =>  'span',
                        'p' =>  'p'
                    ],
                    'default'   =>  'span',
                    'condition' =>  [
                        'add_element'  =>  'text',
                        'custom_or_predefined'  =>  'predefined'
                    ],
                ]
            );
    
            $this->add_control(
                'divider_icon',
                [
                    'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'default'   =>  [
                        'value' =>  'fas fa-star',
                        'library'   =>  'fa-solid'
                    ],
                    'condition' =>  [
                        'add_element'  =>  'icon',
                        'custom_or_predefined'  =>  'predefined'
                    ]
                ]
            );

            $this->end_controls_section();

            /* Style => Divider */
            $this->start_controls_section(
                'styles_divider_section',
                [
                    'label' =>  esc_html__( 'Divider', 'news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_control(
                'element_color',
                [
                    'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .separator' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'divider_margin_top_and_bottom',
                [
                    'label' =>  esc_html__( 'Margin', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'allowed_dimensions' => 'vertical',
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-divider'  =>  'margin: {{TOP}}{{UNIT}} 0px {{BOTTOM}}{{UNIT}} 0px'
                    ]
                ]
            );

            $this->end_controls_section();

            /* Style => Text */
            $this->start_controls_section(
                'styles_text_section',
                [
                    'label' =>  esc_html__( 'Text', 'news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                    'condition' =>  [
                        'custom_or_predefined'  =>  'predefined',
                        'add_element'   =>  'text'
                    ]
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'divider_text_typography',
					'selector' => '{{WRAPPER}} .separator.text'
				]
			);

            $this->add_control(
                'divider_text_color',
                [
                    'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .separator.text' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_control(
                'divider_text_position',
                [
                    'label' => esc_html__( 'Position', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'center'
                ]
            );

            $this->add_responsive_control(
                'divider_text_spacing',
                [
                    'label' => esc_html__( 'Spacing', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                    'range' => [
                        'px' => [
                            'max' => 50
                        ]
                    ],
                    'default'   =>  [
                        'unit'  =>  'px',
                        'size'  =>  0
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .separator.text' => 'margin: 0px {{SIZE}}{{UNIT}} 0px {{SIZE}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_section();

            /* Style => Icon */
            $this->start_controls_section(
                'styles_icon_section',
                [
                    'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                    'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                    'condition' =>  [
                        'custom_or_predefined'  =>  'predefined',
                        'add_element'   =>  'icon'
                    ]
                ]
            );

            $this->add_responsive_control(
                'divider_icon_font_size',
                [
                    'label' => esc_html__( 'Font Size', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'max' => 100
                        ]
                    ],
                    'default'   =>  [
                        'unit'  =>  'px',
                        'size'  =>  15
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .separator.icon i' => 'font-size: {{SIZE}}{{UNIT}}'
                    ]
                ]
            );
            
            $this->add_control(
                'divider_icon_color',
                [
                    'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .separator.icon i' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'divider_icon_background',
					'selector'  =>  '{{WRAPPER}} .separator.icon',
					'exclude'   =>  [ 'image' ]
				]
			);

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'divider_icon_border',
                    'selector' => '{{WRAPPER}} .separator.icon',
                    'condition' =>  [
                        'divider_icon_background_background'    =>  [ 'classic', 'gradient' ]
                    ]
                ]
            );

            $this->add_control(
                'divider_icon_border_radius',
                [
                    'label' => esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'default' => 0,
                    'condition' =>  [
                        'divider_icon_background_background'    =>  [ 'classic', 'gradient' ]
                    ],
                    'selectors' =>  [
                        '{{WRAPPER}} .separator.icon'   =>  'border-radius: {{VALUE}}px'
                    ]
                ]
            );

            $this->add_responsive_control(
                'divider_icon_padding',
                [
                    'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'selectors' =>  [
                        '{{WRAPPER}} .separator.icon'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ],
                    'condition' =>  [
                        'divider_icon_background_background'    =>  [ 'classic', 'gradient' ]
                    ]
                ]
            );

            $this->add_control(
                'divider_icon_position',
                [
                    'label' => esc_html__( 'Position', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-left'
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-center'
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
                            'icon' => 'eicon-h-align-right'
                        ]
                    ],
                    'default' => 'center'
                ]
            );

            $this->add_responsive_control(
                'divider_icon_rotate',
                [
                    'label' => esc_html__( 'Rotate', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
                    'default' => [
                        'unit' => 'deg'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .separator.icon i, {{WRAPPER}} .separator.icon img' => 'transform: rotate({{SIZE}}{{UNIT}})'
                    ]
                ]
            );

            $this->add_responsive_control(
                'divider_icon_spacing',
                [
                    'label' => esc_html__( 'Spacing', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                    'range' => [
                        'px' => [
                            'max' => 50
                        ]
                    ],
                    'default'   =>  [
                        'unit'  =>  'px',
                        'size'  =>  0
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .separator.icon' => 'margin: 0px {{SIZE}}{{UNIT}} 0px {{SIZE}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();
            $elementClass = 'nekit-divider';
            $elementClass .= ' ' . $settings[ 'custom_or_predefined' ];
            $elementClass .= ' layout--' . $settings[ 'predefined_layout' ];
            $separatorClass = 'separator';
            if( $settings[ 'custom_or_predefined' ] === 'predefined' ) $separatorClass .= ' ' . $settings[ 'add_element' ];
            $this->add_render_attribute( 'wrapper', 'class', $elementClass );
            $this->add_render_attribute( 'separatorClass', 'class', $separatorClass );
            ?>
                <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
                    <?php if( $settings[ 'custom_or_predefined' ] === 'predefined' ) : ?>
                        <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'separatorClass' ) ); ?>>
                            <?php
                                if( $settings[ 'add_element' ] !== 'none' ) :
                                    switch( $settings[ 'add_element' ] ) :
                                        case 'text':
                                                if( esc_html( $settings[ 'divider_text' ] ) ) echo esc_html( $settings[ 'divider_text' ] );
                                            break;
                                        case 'icon':
                                                $icon_array = $settings[ 'divider_icon' ];
                                                if( nekit_get_base_value([ 'icon' => $icon_array ]) && ( $icon_array[ 'library' ] !== 'svg' ) ) :
                                                    echo wp_kses_post( nekit_get_base_value([ 'icon' => $icon_array ]) );
                                                else:
                                                    if( ! empty( $icon_array[ 'value' ][ 'url' ] ) ) echo '<img src="' . esc_url( $icon_array[ 'value' ][ 'url' ] ) . '">';    
                                                endif;
                                            break;
                                    endswitch;
                                endif;
                            ?>
                        </span>
                    <?php else: ?>
                        <figure <?php echo wp_kses_post( $this->get_render_attribute_string( 'separatorClass' ) ); ?>>
                            <?php if( ! empty( $settings[ 'add_a_divider' ][ 'url' ] ) ) echo '<img src="' . esc_url( $settings[ 'add_a_divider' ][ 'url' ] ) . '">'; ?>
                        </figure>
                    <?php endif; ?>
                </div>
            <?php
        }
    }