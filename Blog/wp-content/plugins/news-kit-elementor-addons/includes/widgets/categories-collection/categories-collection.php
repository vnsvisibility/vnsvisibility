<?php
/**
 * Categories Collection Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 use Nekit_Widget_Base;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Categories_Collection extends \Nekit_Modules\Categories_Collection_Module {
    protected $widget_name = 'nekit-categories-collection';

    public function get_custom_url_help(){
        return 'https://forum.blazethemes.com/news-elementor/addons/#categories-collection';
    }

    public function get_keywords(){
        return ['categories', 'collection', 'category'];
    }
}