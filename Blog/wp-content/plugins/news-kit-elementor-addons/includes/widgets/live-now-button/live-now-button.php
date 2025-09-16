<?php 
/**
 * Live Now Button
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Live_Now_Button_Widget extends \Nekit_Modules\Live_Now_Button_Module {
    protected $widget_name = 'nekit-live-now-button';
    
    public function get_custom_help_url(){
        return "https://forum.blazethemes.com/news-elementor/addons/#live-now-button";
    }

    public function get_keywords(){
        return ['live','button','live now'];
    }
}