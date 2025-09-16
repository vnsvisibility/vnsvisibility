<?php
    /**
     * Nekit Divider Widget
     * 
     * @package News Kit Elementor Addons
     * @since 1.3.2
     */
    namespace Nekit_Widgets;
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class Nekit_Divider_Widget extends \Nekit_Modules\Nekit_Divider_Widget_Module {
        protected $widget_name = 'nekit-divider';

        public function get_custom_help_url() {
            return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-divider';
        }
        
        public function get_keywords() {
            return [ 'divider', 'separator' ];
        }
    }