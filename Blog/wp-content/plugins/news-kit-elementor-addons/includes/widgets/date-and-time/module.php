<?php
/**
 * Date and Time Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Modules;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Date_And_Time_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
        $this->start_controls_section(
            'general_section',
            [
                'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/date-and-time" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->get_item_orientation_control();

        $this->add_responsive_control(
			'elements_align',
			[
				'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::CHOOSE,
				'options'   =>  [
					'left'  =>  [
						'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-left'
					],
					'center'    => [
						'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon'  =>  'eicon-text-align-center'
					],
					'right' =>  [
						'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-right'
					]
				],
				'default'   =>  'left',
				'toggle'    =>  false,
                'frontend_available' => true,
				'selectors' =>  [
					'{{WRAPPER}}'   =>  'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'separator_text',
            [
                'label' =>  esc_html__( 'Seperator', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  '/',
                'label_block'   =>  false
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_section',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => apply_filters( 'nekit_date_time_icon_condition_filter', [
                    'elements_align'    => 'pro'
                ])
            ]
        );

        $this->add_control(
            'show_date_time_icon',
            [
                'label' =>  esc_html__( 'Show date time icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  => 'yes',
                'default'   => 'yes'
            ]
        );

		$this->add_control(
			'date_time_icon',
			[
				'label' =>  esc_html__( 'Date Time Icon', 'news-kit-elementor-addons' ),
                'label_block'   => false,
				'type'  =>  \Elementor\Controls_Manager::ICONS,
				'skin'	=>  'inline',
                'recommended'	=> [
					'fa-solid'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass'],
					'fa-regular'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass']
				],
                'exclude_inline_options'    =>  'svg',
				'default'   =>    [
					'value' =>  'far fa-clock',
					'library'   =>  'fa-regular'
				]
			]
		);

        $this->add_responsive_control(
            'date_time_icon_size',
            [
                'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  11
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   =>  'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'date_time_icon_distance',
            [
                'label' =>  esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>   [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ], 
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  4
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   =>  'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->insert_divider();
        
        $this->end_controls_section();

        $this->start_controls_section(
            'time_section',
            [
                'label' =>  esc_html__('Time', 'news-kit-elementor-addons'),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_time_count',
            [
                'label' =>  esc_html__( 'Show time', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'date_section',
            [
                'label' =>  esc_html__( 'Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_date_count',
            [
                'label' =>  esc_html__( 'Show date', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'date_format',
            [
                'label' =>  esc_html__( 'Date Format', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'M d, Y',
                'options'   => apply_filters( 'nekit_date_time_format_filter', [
                    'Y/m/d' =>  date('Y/m/d'),
                    'M d, Y'    =>  date('M d, Y')
                ])
            ]
        );

        $this->add_control(
			'date_position',
			[
				'label' =>  esc_html__( 'Date Position', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'after',
                'options'   =>  [
                    'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' )
                ]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'general_styles_section',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'date_time_background_color',
                'types'  =>  ['classic', 'gradient'],
                'exclude'   =>  ['image'],
                'selector'  => '{{WRAPPER}} .date-and-time-wrap'
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .date-and-time-wrap'
			]
		);

        $this->add_control(
            'border_radius',
            [
                'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  500,
                'step'  =>  1,
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'widget_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'widget_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px', '%', 'em', 'custom'],
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_icon_section',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => apply_filters( 'nekit_date_time_icon_condition_filter', [
                    'elements_align'    => 'pro'
                ])
            ]
        );

        $this->add_control(
            'date_time_icon_color',
            [
                'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   => 'color : {{VALUE}}',
                    '{{WRAPPER}} .separator-icon i'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_time_section',
            [
                'label' =>  esc_html__( 'Time', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'name'  =>  'style_time_typography',
                'fields_options'    =>  [
                    'typography'    => [
                        'default'   =>    'custom'
                    ],
                    'font_family'   =>    [
                        'default'   =>  'Jost'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  13
                        ]
                    ],
                    'font_weight'   =>  [
                        'default'   =>  500
                    ]
                ],
                'selector'  =>   '{{WRAPPER}} .time-count'
            ]
        );

        $this->add_control(
            'time_color',
            [
                'label' =>  esc_html__( 'Time Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' =>  [
                    '{{WRAPPER}} .time-count'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'date_style_section',
            [
                'label' =>  esc_html__( 'Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'name'  =>  'date_typography',
                'fields_options'    =>  [
                    'typography'    => [
                        'default'   =>  'custom'
                    ],
                    'font_family'   =>  [
                        'default'   =>  'Jost'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  13
                        ]
                    ],
                    'font_weight'   =>  [
                        'default'   =>  500
                    ]
                ],
                'selector' => '{{WRAPPER}} .date-count'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' =>  esc_html__( 'Date color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' => [
                    '{{WRAPPER}} .date-count, {{WRAPPER}} .date-and-time-wrap .separator'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); 
        $elementClass = 'date-and-time-wrap';
        $elementClass .= esc_attr( " widget-orientation--" . $settings['items_orientation'] );
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        ?>
            <span <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
            <?php
                if( $settings['show_date_count'] == 'yes' && $settings['date_position'] == 'before' ) : ?>
                    <span class="date-count"><?php echo esc_html( date($settings['date_format']) ); ?></span>
                <?php endif;
                if( $settings['separator_text'] && $settings['date_position'] == 'before' )  echo '<span class="separator">' .esc_html($settings["separator_text"]). '</span>';
                if( $settings['show_time_count'] == 'yes' || $settings['show_date_time_icon'] == 'yes' ) :
                ?>
                    <span class="time-wrap">
                        <?php
                            if( $settings['show_date_time_icon'] == 'yes' ) :
                                echo '<span class="date-time-icon">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['date_time_icon']])). '</span>';
                            endif;

                            if( $settings['show_time_count'] == 'yes' ) :
                        ?>
                            <span class="time-count"></span>
                        <?php endif; ?>
                    </span>
                <?php
                endif;
                if( $settings['separator_text'] && $settings['date_position'] == 'after' )  echo '<span class="separator">' .esc_html($settings["separator_text"]). '</span>';
                if( $settings['show_date_count'] == 'yes' && $settings['date_position'] == 'after' ) : ?>
                    <span class="date-count"><?php echo esc_html( date($settings['date_format']) ); ?></span>
                <?php endif;
            ?>
            </span>
    <?php }
}