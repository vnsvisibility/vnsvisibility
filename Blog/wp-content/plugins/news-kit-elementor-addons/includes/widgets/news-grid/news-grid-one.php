<?php
/**
 * News Grid Widget One
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Widget_One extends \Nekit_Modules\Grid_Module {
	protected $widget_name = 'nekit-news-grid-one';
	public static $widget_count = 'one';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-grid-widget-one';
	}
}