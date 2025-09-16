<?php
/**
 * Site Logo Title Widget One 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Site_Logo_Title_Module extends \Nekit_Widget_Base\Base {
    protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label'	=>	esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/site-logo-title" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
			'widget_layout',
			[
				'label'	=>	esc_html__( 'Layouts', 'news-kit-elementor-addons' ),
				'label_block'	=>	true,
				'type'	=>	( version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' ) ? \Elementor\Controls_Manager::VISUAL_CHOICE : 'nekit-radio-image-control' ),
				'default'	=>	'one',
				'options'	=>	apply_filters( 'nekit_radio_image_control_options_filter', array(
					'one'	=>	array(
						'label'	=>	esc_html__( 'Layout One', 'news-kit-elementor-addons' ),
						'image'	=>	NEKIT_URL . 'admin/assets/images/layouts/site-title/one.jpg'
					),
					'two'	=>	array(
						'label'	=>	esc_html__( 'Layout Two', 'news-kit-elementor-addons' ),
						'image'	=>	NEKIT_URL . 'admin/assets/images/layouts/site-title/two.jpg'
					),
					'three'	=>	array(
						'label'	=>	esc_html__( 'Layout Three', 'news-kit-elementor-addons' ),
						'image'	=>	NEKIT_URL . 'admin/assets/images/layouts/site-title/three.jpg'
					)
				)),
				'columns'   =>  2
			]
		);

		$this->add_responsive_control(
			'elements_align',
			[
				'label'	=>	esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::CHOOSE,
				'options'	=>	[
					'left'	=>	[
						'title'	=>	esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-left'
					],
					'center'	=>	[
						'title'	=>	esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-center'
					],
					'right'	=>	[
						'title'	=>	esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-right'
					]
				],
				'default'	=>	'left',
				'toggle'	=>	false,
				'frontend_available' => true,
				'selectors'	=>	[
					'{{WRAPPER}} .site-logo-title-wrap'	=>	'text-align: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'site_logo_section',
			[
				'label'	=>	esc_html__( 'Site Logo', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'logo_option',
			[
				'label'	=>	esc_html__( 'Logo Image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'default',
				'options'	=>	[
					'none'	=>	esc_html__( 'None', 'news-kit-elementor-addons' ),
					'custom'	=>	esc_html__( 'Custom', 'news-kit-elementor-addons' ),
					'default'	=>	esc_html__( 'Default', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label'	=>	esc_html__( 'Logo Image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::MEDIA,
				'default'	=>	[
					'url'	=>	\Elementor\Utils::get_placeholder_image_src()
				],
				'condition'	=>	[
					'logo_option'	=>	'custom'
				]
			]
		);

		$this->add_control(
			'retina_image',
			[
				'label'	=>	esc_html__( 'Retina Image', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::MEDIA,
				'condition'	=>	[
					'logo_option'	=>	'custom'
				]
			]
		);

		$this->add_control(
			'logo_link',
			[
				'label'	=>	esc_html__( 'Link', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::URL,
				'placeholder'	=>	esc_html__( 'Add valid url', 'news-kit-elementor-addons' ),
				'options'	=>	[ 'url', 'is_external', 'nofollow' ],
				'default'	=>	[
					'url'	=>	esc_url(home_url('/')),
					'is_external'	=>	false,
					'nofollow'	=>	true
				],
				'label_block'	=>	true,
				'condition'	=>	[
					'logo_option'	=>	'custom'
				]
			]
		);

		$this->add_responsive_control(
			'site_logo_width',
			[
				'label'	=>	esc_html__('Width','news-kit-elementor-addons'),
				'type'	=>	\Elementor\Controls_Manager::SLIDER,
				'size_units'	=>	['px'],
				'range'	=>	[
					'px'	=>	[
						'min'	=>	20,
						'max'	=>	400,
						'step'	=>	5
					]
				],
				'default'	=>	[
					'units'	=>	'px',
					'size'	=>	50
				],
				'selectors'	=>	[
					'{{WRAPPER}} .news-elementor-site-logo-title img'	=>	'width: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'site_title_section',
			[
				'label'	=>	esc_html__( 'Site Title', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'site_title_option',
			[
				'label'	=>	esc_html__( 'Site Title Option', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'default',
				'options'	=>	[
					'none'	=>	esc_html__( 'None', 'news-kit-elementor-addons' ),
					'custom'	=>	esc_html__( 'Custom', 'news-kit-elementor-addons' ),
					'default'	=>	esc_html__( 'Default', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'site_title',
			[
				'label'	=>	esc_html__( 'Title Text', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'placeholder'	=>	esc_html__( 'Type your title here', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'site_title_option'	=>	'custom'
				]
			]
		);

		$this->add_control(
			'site_title_tag',
			[
				'label'	=>	esc_html__( 'Frontpage Tag', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=> 	'h1',
				'options'	=>	[
					'h1'	=>	esc_html__( 'H1', 'news-kit-elementor-addons' ),
					'h2'	=>	esc_html__( 'H2', 'news-kit-elementor-addons' ),
					'h3'	=>	esc_html__( 'H3', 'news-kit-elementor-addons' ),
					'h4'	=>	esc_html__( 'H4', 'news-kit-elementor-addons' ),
					'h5'	=>	esc_html__( 'H5', 'news-kit-elementor-addons' ),
					'h6'	=> 	esc_html__( 'H6', 'news-kit-elementor-addons' )
				],
				'condition'	=>	[
					'site_title_option'	=>	['custom', 'default']
				]
			]
		);

		$this->add_control(
			'site_title_innerpages_tag',
			[
				'label'	=>	esc_html__( 'Innerpages Tag', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'h2',
				'options'	=>	[
					'h1'	=>	esc_html__( 'H1', 'news-kit-elementor-addons' ),
					'h2'	=>	esc_html__( 'H2', 'news-kit-elementor-addons' ),
					'h3'	=>	esc_html__( 'H3', 'news-kit-elementor-addons' ),
					'h4'	=>	esc_html__( 'H4', 'news-kit-elementor-addons' ),
					'h5'	=>	esc_html__( 'H5', 'news-kit-elementor-addons' ),
					'h6'	=>	esc_html__( 'H6', 'news-kit-elementor-addons' ),
					'p'		=>	esc_html__( 'P', 'news-kit-elementor-addons' ),
					'span'	=>	esc_html__( 'span', 'news-kit-elementor-addons' )
				],
				'condition'	=>	[
					'site_title_option'	=>	['custom', 'default']
				]
			]
		);

		$this->add_control(
			'site_title_frontpage_link_option',
			[
				'label'	=>	esc_html__( 'Disable link in frontpage', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'label_off' =>	esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'return_value' 	=>	'yes',
				'default'	=>	'yes',
				'condition'	=>	[
					'site_title_option'	=>	['custom', 'default']
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'site_tagline_section',
			[
				'label'	=>	esc_html__( 'Site Tagline', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'site_tagline_option',
			[
				'label'	=>	esc_html__( 'Site Tagline Option', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'none',
				'options'	=>	[
					'none'	=>	esc_html__( 'None', 'news-kit-elementor-addons' ),
					'custom'	=>	esc_html__( 'Custom', 'news-kit-elementor-addons' ),
					'default'	=>	esc_html__( 'Default', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'site_tagline',
			[
				'label'	=>	esc_html__( 'Tagline Text', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'placeholder'	=>	esc_html__( 'Type your tagline here', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'site_tagline_option'	=>	'custom'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'site_logo_typography_section',
			[
				'label'	=>	esc_html__( 'Site Logo Styles', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'site_logo_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'selectors'	=>	[
					'{{WRAPPER}} img.custom-logo'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'site_logo_margin',
			[
				'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'selectors'	=>	[
					'{{WRAPPER}} img.custom-logo'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'site_title_typography_section',
			[
				'label'	=>	esc_html__( 'Site Title Styles', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'site_title_typography',
				'selector'	=>	'{{WRAPPER}} .site-title'
			]
		);

		$this->add_control(
			'site_title_color',
			[
				'label'	=>	esc_html__( 'Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .site-title, {{WRAPPER}} .site-title a'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'site_title_hover_color',
			[
				'label'	=>	esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .site-title a:hover'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'site_title_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'selectors'	=>	[
					'{{WRAPPER}} .site-title'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'site_title_margin',
			[
				'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'default'	=>	[
						'top'	=> 	'2',
						'right'	=>	'0',
						'bottom'	=>	'2',
						'left'	=>	'0',
						'unit'	=>	'px',
					],
				'selectors'	=>	[
					'{{WRAPPER}} .site-title'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'site_tagline_typography_section',
			[
				'label'	=>	esc_html__( 'Site Tagline Styles', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'site_tagline_typography',
				'selector'	=>	'{{WRAPPER}} .site-description'
			]
		);

		$this->add_control(
			'site_tagline_color',
			[
				'label'	=>	esc_html__( 'Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} .site-description'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'site_tagline_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'default'	=>	[ 
						'top'   => '10',
						'right' => '0',
						'bottom'=> '5',
						'left'  => '0',
						'unit'  => 'px'
					],
				'selectors' => [
					'{{WRAPPER}} .site-description'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'site_tagline_margin',
			[
				'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=>	[ 'px', '%', 'em', 'custom' ],
				'default'	=>	[
						'top'	=> 	'1',
						'right'	=>	'0',
						'bottom'	=>	'0',
						'left'	=>	'0',
						'unit'	=>	'px',
					],
				'selectors'	=>	[
					'{{WRAPPER}} .site-description'	=>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();
	}
 }