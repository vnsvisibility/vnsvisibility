<?php 
/**
 * Date and Time Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Date_And_Time_Widget extends \Nekit_Modules\Date_And_Time_Module {
	protected $widget_name = 'nekit-date-and-time';
    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#date-and-time';
    }

    public function get_keywords() {
        return [ 'date', 'time', 'counter', 'current time' ];
    }
 }