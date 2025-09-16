<?php
/**
 * News Grid Widget Two
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Widget_Two extends \Nekit_Modules\Grid_Module {
	protected $widget_name = 'nekit-news-grid-two';
	public static $widget_count = 'two';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-grid-widget-two';
	}
}