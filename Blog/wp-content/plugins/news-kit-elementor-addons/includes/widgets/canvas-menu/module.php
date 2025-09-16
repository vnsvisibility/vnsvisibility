<?php
/**
 * Canvas Menu Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Canvas_Menu_Widget_Module extends \Nekit_Widget_Base\Base {
    public function get_saved_templates() {
        $templates_array = [];
        $templates_array['none'] = esc_html__( 'Select a template', 'news-kit-elementor-addons' );
        $templates_args = [
            'post_type' => 'elementor_library',
            'meta_key' => '_elementor_template_type',
            'meta_value' => ['page', 'section', 'container'],
            'posts_per_page'  => -1
        ];
        $templates = get_posts($templates_args);
        foreach($templates as $template) :
            $templates_array[$template->ID] = $template->post_title;
        endforeach;
        return apply_filters( 'news_kit_elementor_addons_saved_templates_filter', $templates_array );
    }

    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/canvas-menu" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
			'canvas_template_id',
			[
				'label'	=> esc_html__( 'Canvas Template', 'news-kit-elementor-addons' ),
				'default' => 'none',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_saved_templates()
			]
		);

        $this->add_responsive_control(
			'elements_align',
			[
				'label' => esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .news-elementor-canvas-menu' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'canvas_menu_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'one',
				'options' => [
					'one'	=> esc_html__( 'Style One', 'news-kit-elementor-addons' ),
					'two'	=> esc_html__( 'Style Two', 'news-kit-elementor-addons' ),
					'three'	=> esc_html__( 'Style Three', 'news-kit-elementor-addons' ),
					'four'	=> esc_html__( 'Style Four', 'news-kit-elementor-addons' ),
					'five'	=> esc_html__( 'Style Five', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_responsive_control(
			'canvas_menu_icon_width',
			[
				'label' => esc_html__( 'Icon Width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 60
				],
				'selectors' => [
					'{{WRAPPER}} .canvas-menu-icon ' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'canvas_menu_icon_height',
			[
				'label' => esc_html__( 'Icon Height', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.5
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 3
				],
				'selectors' => [
					'{{WRAPPER}} .canvas-menu-icon .line' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'canvas_menu_icon_gap',
			[
				'label' => esc_html__( 'Icon Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 0.5
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 5
				],
				'selectors' => [
					'{{WRAPPER}} .canvas-menu-icon .line' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .canvas-menu-icon .line' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->insert_divider();
		$this->add_control(
			'canvas_position',
			[
				'label' => esc_html__( 'Canvas Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'right',
				'options' => apply_filters( 'nekit_canvas_widget_position_filter', [
					'right'	=> esc_html__( 'Right', 'news-kit-elementor-addons' ),
					'left'	=> esc_html__( 'Left', 'news-kit-elementor-addons' )
				])
			]
		);

		$this->add_control(
			'canvas_appear_from',
			[
				'label' => esc_html__( 'Appear From', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'right',
				'options' => apply_filters( 'nekit_canvas_widget_appear_from_filter', [
					'right'	=> esc_html__( 'Right', 'news-kit-elementor-addons' ),
					'left'	=> esc_html__( 'Left', 'news-kit-elementor-addons' )
				])
			]
		);
		
		$this->add_control(
			'canvas_appear_animation',
			[
				'label' => esc_html__( 'Appear Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'	=> 'slide',
				'options' => apply_filters( 'nekit_canvas_widget_appear_animation_filter', [
					'none'	=> esc_html__( 'None', 'news-kit-elementor-addons' ),
					'slide'	=> esc_html__( 'Slide', 'news-kit-elementor-addons' )
				])
			]
		);

		$this->add_responsive_control(
			'canvas_menu_content_width',
			[
				'label' => esc_html__( 'Canvas Width', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => apply_filters( 'nekit_canvas_widget_width_filter', 300 ),
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 300
				],
				'selectors' => [
					'{{WRAPPER}} .position--right .canvas-menu-content, {{WRAPPER}} .position--left .canvas-menu-content' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'	=>  [
					'canvas_position'	=> apply_filters( 'nekit_canvas_menu_content_width_filter', 'pro' )
				]
			]
		);

		$this->add_responsive_control(
			'canvas_menu_content_height',
			[
				'label' => esc_html__( 'Canvas Height', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 300
				],
				'selectors' => [
					'{{WRAPPER}} .position--top .canvas-menu-content, {{WRAPPER}} .position--bottom .canvas-menu-content' => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'	=> [
					'canvas_position'	=> ['top', 'bottom']
				]
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
			'general_style_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE
			]
		);
		$this->start_controls_tabs(
			'widget_style_tabs'
		);
			$this->start_controls_tab(
				'widget_initial_style_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' )
				]
			);
				$this->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#000000',
						'selectors' => [
							'{{WRAPPER}} .canvas-menu-icon .line' => 'background-color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'  =>  'canvas_icon_background_color',
						'selector'  =>  '{{WRAPPER}} .canvas-menu-icon',
						'exclude'	=> ['image']
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'icon_initial_box_shadow',
						'selector' => '{{WRAPPER}} .canvas-menu-icon'
					]
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'widget_hover_style_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' )
				]
			);
				$this->add_control(
					'icon_hover_color',
					[
						'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#000000',
						'selectors' => [
							'{{WRAPPER}} .canvas-menu-icon:hover .line' => 'background-color: {{VALUE}}'
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name'  =>  'canvas_icon_hover_background_color',
						'selector'  =>  '{{WRAPPER}} .canvas-menu-icon:hover'
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'icon_initial_hover_box_shadow',
						'selector' => '{{WRAPPER}} .canvas-menu-icon:hover'
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'canvas_button_border',
				'selector' => '{{WRAPPER}} .canvas-menu-icon'
			]
		);

		$this->add_responsive_control(
			'canvas_button_border_radius',
			[
				'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .canvas-menu-icon'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'canvas_icon_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'default' => [ 
					'top'   => '9',
					'right' => '16',
					'bottom'=> '9',
					'left'  => '16',
					'unit'  => 'px',
					'isLinked ' => true
				],
				'selectors' =>  [
					'{{WRAPPER}} .canvas-menu-icon'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->insert_divider();
		$this->add_control(
			'canvas_content_styles',
			[
				'label' => esc_html__( 'Canvas Content', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);
		$this->insert_divider();
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'canvas_content_border',
				'selector' => '{{WRAPPER}} .canvas-menu-content'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'canvas_content_box_shadow',
				'selector' => '{{WRAPPER}} .canvas-menu-content'
			]
		);
		$this->add_responsive_control(
			'canvas_content_padding',
			[
				'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
				'label_block'   =>  true,
				'selectors' =>  [
					'{{WRAPPER}} .canvas-menu-content'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'  =>  'canvas_content_background_color',
				'selector'  =>  '{{WRAPPER}} .canvas-menu-content'
			]
		);
		$this->add_control(
			'scrollbar_color',
			[
				'label' => esc_html__( 'Scroll Bar Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f9f9f9',
				'selectors' => [
					'{{WRAPPER}} .news-elementor-canvas-menu .canvas-menu-content::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->end_controls_section();
    }
 }