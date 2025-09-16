<?php
/**
 * News Carousel Widget One
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Carousel_Widget_One extends \Nekit_Modules\Carousel_Module {
	protected $widget_name = 'nekit-news-carousel-one';
	public static $widget_count = 'one';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-carousel-widget-one';
	}
}