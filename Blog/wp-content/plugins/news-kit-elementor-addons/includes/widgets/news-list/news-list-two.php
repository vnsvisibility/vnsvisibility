<?php
/**
 * News List Widget Two
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class List_Widget_Two extends \Nekit_Modules\List_Module {
	protected $widget_name = 'nekit-news-list-two';
	public static $widget_count = 'two';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-list-widget-two';
	}
}