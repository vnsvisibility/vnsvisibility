<?php 
/**
 * Popular Opinions Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Popular_Opinions extends \Nekit_Modules\Popular_Opinions_Module {
    protected $widget_name = 'nekit-popular-opinions';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-popular-opinions';
    }

    public function get_categories() {
        return ['nekit-post-layouts-widgets-group'];
    }

    public function get_keywords() {
        return ['popular', 'opinions'];
    }
}