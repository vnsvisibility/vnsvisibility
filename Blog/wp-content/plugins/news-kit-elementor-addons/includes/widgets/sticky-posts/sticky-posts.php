<?php
/**
 * Social Share Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Sticky_Posts extends \Nekit_Modules\Sticky_Posts_Module {
    protected $widget_name = 'nekit-sticky-posts';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-sticky-posts';
	}

	public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}
	
	public function get_keywords() {
		return [ 'posts', 'post', 'sticky' ];
	}
 }