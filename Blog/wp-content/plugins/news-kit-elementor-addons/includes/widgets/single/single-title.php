<?php
/**
 * Single Title Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets\Single;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Title extends \Nekit_Modules\Single_Module {
	protected $widget_name = 'nekit-single-title';
    public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-title';
	}

	public function get_keywords() {
		return [ 'single', 'title', 'single title', 'post title' ];
	}

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
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-title" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a</div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
            'title_html_tag',
            [
                'label'	=>	esc_html__( 'HTML Tag', 'news-kit-elementor-addons' ),
                'type'	=>	\Elementor\Controls_Manager::SELECT,
                'default'	=>	'h2',
                'label_block'	=>	true,
                'options'	=>	$this->get_html_tags()
            ]   
        );

		$this->add_responsive_control(
			'title_align',
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
					],
					'justify'	=>	[
						'title'	=>	esc_html__( 'Justify', 'news-kit-elementor-addons' ),
						'icon'	=>	'eicon-text-align-justify'
					]
				],
				'default'	=>	'left',
				'toggle'	=>	false,
				'frontend_available' => true,
				'selectors'	=>	[
					'{{WRAPPER}}'	=>	'text-align: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label'	=>	esc_html__( 'Title', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'	=>	esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name'	=>	'title_text_typography',
				'fields_options'	=>	[
					'typography'	=>	[
						'default'	=>	'classic'
					],
					'font_family'	=>	[
						'default'	=>	'Rubik'
					],
					'font_size'	=>	[
						'default'	=>	[
							'unit'	=>	'px',
							'size'	=>	22
						]
					],
					'font_weight'	=>	[
						'default'	=>	500
					]
				],
				'selector'	=>	'{{WRAPPER}} .nekit-single-title'
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'	=>	esc_html__( 'Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'default'	=>	'#000000',
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-single-title'	=>	'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'	=>	'background_color',
                'selector'	=>	'{{WRAPPER}} .nekit-single-title',
                'exclude'	=>	['image']
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name'	=>	'title_text_stroke',
				'selector'	=>	'{{WRAPPER}} .nekit-single-title'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name'	=>	'title_text_shadow',
				'selector'	=>	'{{WRAPPER}} .nekit-single-title'
			]
		);

		$this->insert_divider();

		$this->get_spacing_control( 'padding', 'Padding', '.nekit-single-title'.'' );
		
		$this->get_spacing_control( 'margin', 'Margin', '.nekit-single-title', '', [ 0, 0, 0, 0 ] );
		
		$this->end_controls_section();
    }

    protected function render_template() {
		$settings = $this->get_settings_for_display();
		the_title( '<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-single-title">', '</' .esc_html( $settings['title_html_tag'] ). '>' );
    }
}