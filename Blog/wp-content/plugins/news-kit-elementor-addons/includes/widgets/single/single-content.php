<?php
/**
 * Single Content Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Content extends \Nekit_Modules\Single_Module {
	protected $widget_name = 'nekit-single-content';

    public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-content';
	}

	public function get_keywords() {
		return [ 'single', 'content', 'single content', 'post content' ];
	}

	protected function register_controls() {
		//Content Section
        $this->start_controls_section(
            'content',
            [
                'label' =>  esc_html__( 'Content', 'news-kit-elementor-addons' ),
                'tab'   =>   \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-content" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
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
                    'center'    =>    [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ],
                    'justify'   =>   [
                        'title' =>  esc_html__( 'Justify', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-justify'
                    ]
                ],
                'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-content' =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'single_content_typography',
                'selector'  =>  '{{WRAPPER}} .nekit-single-content',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  20
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'single_content_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-content' =>  'color: {{VALUE}}'
                ]
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'single_content_background_color',
                'selector'  =>  '{{WRAPPER}} .nekit-single-content',
                'exclude'   =>  ['image']
            ]
        );

        $this->get_spacing_control( 'single_content_padding', 'Padding', '.nekit-single-content' );
        
        $this->end_controls_section();
    }

    protected function render_template() {
		$settings = $this->get_settings_for_display();
		$utils_object = new \Nekit_Utilities\Utils();
    ?>
        <div class="nekit-single-content">
            <?php the_content(); ?>
        </div>
    <?php
    }
}