<?php
/**
 * Single Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Modules;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Single_Module extends \Nekit_Widget_Base\Base {
    public function get_categories() {
        return ['nekit-single-templates-widgets-group'];
    }

    public function get_open_in_new_tab_control( $id = '' ) {
        $this->add_control(
            $id,
            [
                'label' =>  esc_html__( 'Links Open In', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  '_self',
                'options'   =>  [
                    '_blank'   =>  esc_html__( 'Open in new tab', 'news-kit-elementor-addons' ),
                    '_self'   =>  esc_html__( 'Open in same tab', 'news-kit-elementor-addons' )
                ]
            ]
        );
    }

    public function get_spacing_control( $id = '', $label = '', $class = '', $css_property = '', $default = [0, 0, 0, 0] ) {
        $label_or_css_property = ( $css_property ) ? $css_property : strtolower( $label ) ;
        $this->add_responsive_control(
            $id,
            [
                'label'	=>	esc_html( $label ),
                'type'	=>	\Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px','em','%','custom' ],
                'default'	=>	[
                	'top'	=>	$default[0],
                	'right'	=>	$default[1],
                	'bottom'	=>	$default[2],
                	'left'	=>	$default[3],
                	'unit'	=>	'px',
                	'isLinked'	=>	true
                ],
                'label_block'	=>	true,
                'selectors'	=>	[
                    '{{WRAPPER}} ' . $class =>	$label_or_css_property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
    }
    
    protected function render() {
        while( have_posts() ) :
            the_post();
            $this->render_template();
        endwhile;
    }
 }