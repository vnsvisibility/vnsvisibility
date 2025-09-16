<?php
/**
 * Advanced Heading Icon Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Heading_Icon extends \Nekit_Modules\Advanced_Heading_Icon_Module {
    protected $widget_name = 'nekit-advanced-heading-icon';

    public function get_custom_help_url(){
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-advanced-heading-icon';
    }

    public function get_keywords() {
        return [ 'advanced','heading','icon' ];
    }
}