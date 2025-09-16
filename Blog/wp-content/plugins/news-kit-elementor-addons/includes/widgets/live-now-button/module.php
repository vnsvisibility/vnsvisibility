<?php
/**
 * Live Now Button Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Live_Now_Button_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
        $this->start_controls_section(
            'lnb_general_section',
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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/live-now-button" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'lnb_link',
            [
                'label' =>  esc_html__( 'Link', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::URL,
                'options' =>    ['url', 'is_external','nofollow'],
				'default' =>    [
					'url'   => '',
					'is_external'   => true,
                    'nofollow'  => true,
				],
				'label_block' => true
            ]
        );

        $this->add_control(
            'lnb_item_orientation',
            [
                'label' =>  esc_html__( 'Item Orientation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'horizontal',
                'options'   =>  [
                    'horizontal'    =>  array(
                        'title' =>  esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-navigation-horizontal'
                    ),
                    'vertical'=>array(
                        'title' =>  esc_html__( 'Vertical', 'news-kit-elementor-addons'),
                        'icon'  =>  'eicon-navigation-vertical'
                    )
                ],
                'toggle'=>false
            ]
        );

        $this->add_responsive_control(
            'lnb_alignment',
            [
                'label' => esc_html__('Alignment', 'news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => array(
                    'left'  => array(
                        'title' => esc_html__("Left", 'news-kit-elementor-addons'),
                        'icon'  => 'eicon-text-align-left'
                    ),
                    'center'    => array(
                        'title' => esc_html__("Center", 'news-kit-elementor-addons'),
                        'icon'  => 'eicon-text-align-center'
                    ),
                    'right' => array(
                        'title' => esc_html__("Right", 'news-kit-elementor-addons'),
                        'icon'  => 'eicon-text-align-right'
                    )
                ),
                'toggle'    => false,
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}}' =>    'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'lnb_icon_section',
            [
                'label' => esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

         $this->add_control(
            'lnb_icon_font_size',
            [
                'label' => esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 1000,
                        'step'  => 1
                    ]
                ],
                'default'   => [
                    'unit'  => 'px',
                    'size'  => 13
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'lnb_icon_distance',
            [
                'label' => esc_html__( 'Icon Distance', 'news-kit-elementor-addons'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 1000,
                        'step'  => 1
                    ]
                ],
                'default'   => [
                    'unit'  => 'px',
                    'size'  => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .live-now-button-wrap'   => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'lnb_icon',
            [
                'label' => esc_html__( 'Button Icon', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'skin'  => 'inline',
                'recommended'   => [
                    'fa-solid'  => ['play','play-circle','headset'],
                    'fa-regular'  => ['play-circle'],
                    'fa-brand'  => ['youtube']
                ],
                'label_block'  => false,
                'default'   => [
                    'value' => 'fas fa-play',
                    'library'   => 'fa-solid'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'lnb_title_section',
            [
                'label' => esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'lnb_show_title',
            [
                'label' => esc_html__( 'Show Title', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>esc_html__( 'Show', 'news-kit-elementor-addons'),
                'return_value'  => 'yes',
                'default'   => 'yes'
            ]
        );

        $this->add_control(
            'lnb_title',
            [
                'label' => esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'label_block'   => false,
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'Live Now', 'news-kit-elementor-addons' ),
                'placeholder' => esc_html__( 'Button text', 'news-kit-elementor-addons' ),
                'condition' => [
                    'lnb_show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'lnb_title_position',
            [
                'label' => esc_html__( 'Title Position', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'default'   => 'after',
                'options'   => [
                    'after' => esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'    => esc_html__( 'Before', 'news-kit-elementor-addons' )
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'lnb_hover_animation_section',
            [
                'label' => esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\ControlS_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'lnb_hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'news-kit-elementor-addons' ),
                'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'general_styles_section',
            [
                'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  => 'lnb_title_styles_typography',
                'fields_options' => [
                    'typography' => [
                        'default' => 'classic'
                    ],
                    'font_family' => [
                        'default' => 'Rubik'
                    ],
                    'font_width' => [
                        'default' => 500
                    ]
                ],
                'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'selector'  => '{{WRAPPER}} .live-now-title'
            ]
        );

        $this->start_controls_tabs(
            'widget_styles_initial_hover_tab'
        );
            $this->start_controls_tab(
                'widget_style_initial_tab',
                [
                    'label' =>   esc_html__('Initial','news-kit-elementor-addons')
                ]
            );

            $this->add_control(
                'text_color', [
                    'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .nekit-live-now-button-wrap' => 'color:{{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'background_color',
                    'types'  =>  ['classic','gradient'],
                    'fields_options' => [
                        'background' => [
                            'default' => 'classic'
                        ],
                        'color' => [
                            'default' => '#000'
                        ]
                    ],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .nekit-live-now-button-wrap'
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'widget_initial_box_shadow',
                    'selector' => '{{WRAPPER}} .nekit-live-now-button-wrap'
                ]
            );

            $this->add_responsive_control(
                'widget_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-live-now-button-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->start_controls_tab(
                'widget_style_hover_tab',
                [
                    'label' =>  esc_html__('Hover', 'news-kit-elementor-addons')
                ]
            );

            $this->add_control(
                'text_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .nekit-live-now-button-wrap:hover'   => 'color:{{VALUE}};'
                    ]
                ]
            );
            
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'      =>  'background_hover_color',
                    'types'      =>  ['classic','gradient'],
                    'exclude'   =>  ['image'],
                    'selector'  =>  '{{WRAPPER}} .nekit-live-now-button-wrap:hover'
                ]
            );
            
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'widget_hover_box_shadow',
                    'selector' => '{{WRAPPER}} .nekit-live-now-button-wrap:hover'
                ]
            );

            $this->add_responsive_control(
                'widget_hover_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    =>  [ 'px' ],
                    'label_block'   =>  true,
                    'selectors' =>  [
                        '{{WRAPPER}} .nekit-live-now-button-wrap:hover'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lnb_widget_border',
                'selector' => '{{WRAPPER}} .nekit-live-now-button-wrap'
            ]
        );

        $this->add_responsive_control(
            'lnb_whole_padding',
            [
                'label' =>  esc_html__('Padding','news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'default'   =>  [
                    'top'   =>  10,
                    'right' =>  15,
                    'bottom'    =>  10,
                    'left'  =>  15,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-live-now-button-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'lnb_whole_margin',
            [
                'label' =>  esc_html__('Margin','news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px','%','em','custom'],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-live-now-button-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = "nekit-live-now-button-wrap";
        $elementClass .= esc_attr(" widget-orientation--" . $settings['lnb_item_orientation'] );
        $elementClass .= esc_attr(" label-position--" . $settings['lnb_title_position']);
        if( $settings['lnb_hover_animation'] ) $elementClass .= ' elementor-animation-' . $settings['lnb_hover_animation'];
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        if( ! empty( $settings['lnb_link']['url'] ) ) :
            $this->add_link_attributes( 'website_link', $settings['lnb_link'] );
        endif;
        ?>
        <a <?php echo wp_kses_post($this->get_render_attribute_string('website_link')); echo wp_kses_post($this->get_render_attribute_string('wrapper')); ?>>
            <div class="live-now-button-wrap">
                <?php 
                    if( $settings['lnb_show_title'] == 'yes' && $settings['lnb_title_position'] == "before" ) 
                        echo '<span class="live-now-title">' .esc_html($settings['lnb_title']). '</span>';

                    if( nekit_get_base_value( ['icon' => $settings['lnb_icon']] ) )
                        echo '<span class="button-icon">' .wp_kses_post(nekit_get_base_value( [ 'icon' => $settings['lnb_icon'] ] )). '</span>';
                    
                    if( $settings['lnb_show_title'] == 'yes' && $settings['lnb_title_position'] == "after" )
                        echo '<span class="live-now-title">' .esc_html($settings['lnb_title']). '</span>';
                ?>
            </div>
        </a>
<?php
    }
}