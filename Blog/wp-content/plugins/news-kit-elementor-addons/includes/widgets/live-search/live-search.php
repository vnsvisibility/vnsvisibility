<?php
/**
 * Live Search Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Live_Search_Widget extends \Nekit_Modules\Live_Search_Module {
	protected $widget_name = 'nekit-live-search';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#live-search';
	}
	
	public function get_keywords() {
		return [ 'search', 'live search' ];
	}
}