<?php
/**
 * Social Share Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Social_Share_Widget extends \Nekit_Modules\Social_Share_Module {
    protected $widget_name = 'nekit-social-share';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-social-share';
	}

	public function get_categories() {
		return ['nekit-single-templates-widgets-group'];
	}
	
	public function get_keywords() {
		return [ 'social', 'share', 'brands' ];
	}
 }