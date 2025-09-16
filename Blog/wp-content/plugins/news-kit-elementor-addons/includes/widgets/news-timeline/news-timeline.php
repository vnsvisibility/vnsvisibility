<?php 
/**
 * News Timeline widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_widgets;
 use Nekit_Widget_Base;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class News_Timeline extends \Nekit_Modules\News_Timeline_Module {
    protected $polyline_icon;
    protected $widget_name = 'nekit-news-timeline';
    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-news-timeline';
    }

    public function get_keywords() {
        return ['news', 'timeline'];
    }
    
    public function get_categories() {
        return ['nekit-post-layouts-widgets-group'];
    }
 }