<?php
/**
 * Archive Title Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets\Archive;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Title extends \Nekit_Widget_Base\Base {
	protected $widget_name = 'nekit-archive-title';

    public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#back-to-top';
	}

    public function get_categories() {
		return [ 'nekit-archive-templates-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'archive', 'title', 'archive title' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/archive-title" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

		$this->add_control(
			'archive_context_option',
			[
				'label' => esc_html__( 'Show title context', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
            'title_html_tag',
            [
                'label' =>  esc_html__( 'HTML Tag','news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'	=>  'h2',
                'label_block'=>  true,
                'options'	=>  $this->get_html_tags()
            ]   
        );

		$this->add_responsive_control(
			'title_align',
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					]
				],
				'default' => 'left',
				'toggle' => false,
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blog_page_title',
			[
				'label'	=>	esc_html__( 'Blog Page Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'default'	=>	'default',
				'options'	=>	[
					'default'	=>	esc_html__( 'Default Page Title', 'news-kit-elementor-addons' ),
					'custom'	=>	esc_html__( 'Custom', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'custom_page_title',
			[
				'label'	=>	esc_html__( 'Custom Page Title', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::TEXT,
				'placeholder'	=>	esc_html__( 'Page Title', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'blog_page_title'	=>	'custom'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => esc_html__( 'Title', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .nekit-archive-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
				'name' => 'title_text_typography',
				'selector' => '{{WRAPPER}} .nekit-archive-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .nekit-archive-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .nekit-archive-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'	=>	esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-archive-title' =>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label'	=>	esc_html__( 'Margin', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-archive-title' =>	'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				]
			]
		);
		$this->end_controls_section();
    }

    protected function render() {
		$settings = $this->get_settings_for_display();
		$utils_object = new \Nekit_Utilities\Utils();
		$utils_object->clear_theme_filters();
		$custom_page_title = ( isset( $settings['custom_page_title'] ) ) ? $settings['custom_page_title'] : '';
		$page_title = ( $settings['blog_page_title'] == 'default' ) ? get_the_title( get_option('page_for_posts') ) : $custom_page_title;
		if( is_search() ) {
			echo '<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-archive-title">' .esc_html__( 'You searched for : ', 'news-kit-elementor-addons' ). '<span class="search-query">' .esc_html( get_search_query() ). '</span></' .esc_html( $settings['title_html_tag'] ). '>';
		} else if( is_date() ) {
			if( $settings['archive_context_option'] != 'yes' ) add_filter( 'get_the_archive_title_prefix', '__return_false' );
				the_archive_title('<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-archive-title">', '</' .esc_html( $settings['title_html_tag'] ). '>');
			if( $settings['archive_context_option'] != 'yes' ) remove_filter( 'get_the_archive_title_prefix', '__return_false' );
			echo '<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-archive-title">' .esc_html__( 'Year : ', 'news-kit-elementor-addons' ). '<span class="date-query">' .esc_html(date( 'Y' )). '</span></' .esc_html( $settings['title_html_tag'] ). '>';
		} else if ( is_home() ) {
			echo '<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-archive-title">' .esc_html( $page_title ) . '</' .esc_html( $settings['title_html_tag'] ). '>';
		} else {
			if( $settings['archive_context_option'] != 'yes' ) add_filter( 'get_the_archive_title_prefix', '__return_false' );
				the_archive_title('<' .esc_html( $settings['title_html_tag'] ). ' class="nekit-archive-title">', '</' .esc_html( $settings['title_html_tag'] ). '>');
			if( $settings['archive_context_option'] != 'yes' ) remove_filter( 'get_the_archive_title_prefix', '__return_false' );
		}
    }
}