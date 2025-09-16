<?php
/**
 * Plugin custom functionality
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Custom;

class Custom_Styles {
    public function __construct() {
        add_action('elementor/element/after_section_end', [$this, 'add_custom_css_control'], 10, 3);
        add_action('elementor/element/parse_css', [$this, 'add_post_custom_css'], 10, 2); // add custom css for widget
        add_action( 'elementor/element/section/section_background/after_section_end', [$this, 'register_section_controls'], 10, 2 );
        add_action( 'elementor/element/container/section_background/after_section_end', [$this, 'register_section_controls'], 10, 2 );
        add_action( 'elementor/element/container/section_background/after_section_end', [$this, 'register_column_controls'], 10, 2 );
        add_action( 'elementor/element/column/section_style/after_section_end', [$this, 'register_column_controls'], 10, 2 );
    }

    // register controls for columns
    function register_column_controls($element, $section_id) {
        if( ! apply_filters( 'nekit_check_plugin_status_filter', false ) ) return;
        $element->start_controls_section(
            'nekit_column_sticky_section',
            [
                'label' => __( 'Sticky Column - Nekit', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED
            ]
        );

        $element->add_responsive_control(
			'nekit_column_sticky',
			[
				'label'	=> esc_html__( 'Make this column sticky', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__( 'Enable', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Disable', 'news-kit-elementor-addons' ),
				'return_value'	=> 'yes',
				'default'	=> 'no'
			]
		);
        $element->end_controls_section();
    }
    
	// register controls for top sections
    function register_section_controls($element, $section_id) {
        if( ! apply_filters( 'nekit_check_plugin_status_filter', false ) ) return;
        $element->start_controls_section(
            'nekit_sticky_section',
            [
                'label' => __( 'Sticky Section - Nekit', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED
            ]
        );

        $element->add_control(
			'nekit_section_sticky',
			[
				'label' => esc_html__( 'Make this section sticky', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no'
			]
		);

        $element->add_control(
			'nekit_section_sticky_position',
			[
				'label' => esc_html__( 'Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top'   => esc_html__( 'Top', 'news-kit-elementor-addons' ),
					'bottom'    => esc_html__( 'Bottom', 'news-kit-elementor-addons' )
				]
			]
		);

        $element->add_control(
			'nekit_section_sticky_condition',
			[
				'label' => esc_html__( 'Condition', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'always',
				'options' => [
					'always'=> esc_html__( 'Always', 'news-kit-elementor-addons' ),
					'down'  => esc_html__( 'On Scroll Down', 'news-kit-elementor-addons' ),
					'up'    => esc_html__( 'On Scroll Up', 'news-kit-elementor-addons' )
                ],
                'condition' => apply_filters( 'nekit_section_sticky_control_condition_filter', [
                    'nekit_section_sticky_position' => 'left'
                ])
			]
		);

        $element->add_control(
			'nekit_section_sticky_appear_direction',
			[
				'label' => esc_html__( 'Appear Direction', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
					'top'   => esc_html__( 'Top', 'news-kit-elementor-addons' ),
					'right' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
					'bottom'    => esc_html__( 'Bottom', 'news-kit-elementor-addons' ),
					'left'  => esc_html__( 'Left', 'news-kit-elementor-addons' ),
					'center'  => esc_html__( 'Center', 'news-kit-elementor-addons' )
				],
                'condition' => apply_filters( 'nekit_section_sticky_control_condition_filter', [
                    'nekit_section_sticky_position' => 'left'
                ])
			]
		);

        $element->add_control(
			'nekit_section_sticky_appear_animation',
			[
				'label' => esc_html__( 'Appear Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
					'fade'  => esc_html__( 'Fade', 'news-kit-elementor-addons' ),
					'slide' => esc_html__( 'Slide', 'news-kit-elementor-addons' )
				],
                'condition' => apply_filters( 'nekit_section_sticky_control_condition_filter', [
                    'nekit_section_sticky_position' => 'left'
                ])
			]
		);

        $element->add_control(
            'nekit_section_sticky_section_z_index',
            [
                'label' =>  esc_html__( 'Z-Index', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  4,
                'selectors' =>  [
                    '{{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-top, {{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-bottom'  =>  'z-index: {{VALUE}}'
                ]
            ]
        );

        $element->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'	=>	'nekit_section_sticky_background_color',
                'selector'	=>  '{{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-top, {{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-bottom',
                'exclude'   =>  ['image']
            ]
        );
        
        $element->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'	=>	'nekit_section_sticky_border',
                'selector'	=>	'{{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-top, {{WRAPPER}}.nekit-section--sticky.nekit-section--sticky-active-bottom'
            ]
        );
        $element->end_controls_section();
    }

    // add custom css control
    function add_custom_css_control( $element, $section_id, $args ) {
        if ( 'section_custom_css_pro' !== $section_id ) {
			return;
		}
        
        $element->start_controls_section(
			'nekit_custom_css_section',
			[
				'label' =>  sprintf( esc_html__( 'Custom CSS - %1s', 'news-kit-elementor-addons'), 'Nekit' ),
				'tab' => \Elementor\Controls_Manager::TAB_ADVANCED
			]
		);

		$element->add_control(
			'nekit_custom_css',
			[
				'type'  => \Elementor\Controls_Manager::CODE,
				'label' => esc_html__( 'Custom CSS', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'Use "selector" keyword to target the element unique wrapper', 'news-kit-elementor-addons' ),
				'label_block' => true,
				'language'  => 'css'
			]
		);
		$element->end_controls_section();
    }

    // add custom styling to the post css
    function add_post_custom_css( $post_css_file, $element ) {
        $element_settings = $element->get_settings();
        $element_name = $element->get_name();
        if( isset( $element_settings['nekit_custom_css'] ) ) :
            // render plugin custom css
            if( ! empty( $element_settings['nekit_custom_css'] ) ) {
                if( ! empty( trim($element_settings['nekit_custom_css']) ) ) {
                    $css = '/* Nekit custom element styles */';
                    $css .= trim($element_settings['nekit_custom_css']);
                    $css = str_replace('selector', $post_css_file->get_element_unique_selector($element), $css);
                    $css .= '/* Nekit custom element styles ends here */';
                }
            }
        endif;
        if( isset( $element_settings['post_title_custom_animation'] ) && $element_settings['post_title_custom_animation'] != 'none' ) {
            if( isset( $element_settings['__globals__']['general_styles_primary_color'] ) && $element_settings['__globals__']['general_styles_primary_color'] ) {
                $global_suffix = substr( $element_settings['__globals__']['general_styles_primary_color'], strpos( $element_settings['__globals__']['general_styles_primary_color'], '=' ) + 1 );
                if( ! isset($css) ) $css = '';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--one a { background-image: linear-gradient(transparent calc( 100% - 2px), var( --e-global-color-'. $global_suffix . ') 1px ); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--two a { background-image: linear-gradient(to right,var( --e-global-color-'. $global_suffix . '),var( --e-global-color-'. $global_suffix . ') 50%,currentColor 50%); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--three a { background-image: linear-gradient(90deg,var( --e-global-color-'. $global_suffix . ') 0,var( --e-global-color-'. $global_suffix . ') 94%); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--four a:hover{ background-image: linear-gradient(var( --e-global-color-'. $global_suffix . '),var( --e-global-color-'. $global_suffix . ')); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--five a { background-image: linear-gradient(var( --e-global-color-'. $global_suffix . '),var( --e-global-color-'. $global_suffix . ')); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--six a { background-image: linear-gradient(currentColor, currentColor), linear-gradient( currentColor, currentColor ), linear-gradient(var( --e-global-color-'. $global_suffix . '), var( --e-global-color-'. $global_suffix . ')); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--seven a { background-image: linear-gradient(transparent calc(100% - 10px), var( --e-global-color-'. $global_suffix . ') 30px); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--eight a { background-image: linear-gradient(to bottom, var( --e-global-color-'. $global_suffix . '), var( --e-global-color-'. $global_suffix . ')), linear-gradient(to left, currentColor, currentColor); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--nine a { background-image: linear-gradient(to bottom, var( --e-global-color-'. $global_suffix . '), var( --e-global-color-'. $global_suffix . ')), linear-gradient(to bottom, currentColor, currentColor); }';
                $css .= $post_css_file->get_element_unique_selector($element) . ' .custom-animation--ten a { background-image: linear-gradient(to bottom, var( --e-global-color-'. $global_suffix . ') 45%, currentColor 55%); }';
				$css .= $post_css_file->get_element_unique_selector($element) . ' .nekit-banner-wrap .slick-active button:before { background-color: var( --e-global-color-'. $global_suffix . '); }';
            }
        }
        if( isset( $css ) && ! empty( $css ) ) $post_css_file->get_stylesheet()->add_raw_css($css);
    }
}
new Custom_Styles();