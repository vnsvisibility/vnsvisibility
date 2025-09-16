<?php
/**
 * News Carousel Widget Three
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Carousel_Widget_Three extends \Nekit_Modules\Carousel_Module {
	protected $widget_name = 'nekit-news-carousel-three';
	public static $widget_count = 'three';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-carousel-widget-three';
	}
}