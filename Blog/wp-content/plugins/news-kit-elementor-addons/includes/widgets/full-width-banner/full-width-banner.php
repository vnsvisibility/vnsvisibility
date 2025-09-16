<?php 
/**
 * Full Width Banner Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Full_Width_Banner extends \Nekit_Modules\Full_Width_Banner_Module {
    protected $widget_name = 'nekit-full-width-banner';
    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#full-widget-banner';
    }

    public function get_keywords() {
        return ['full','width','banner','full width banner'];
    }
}