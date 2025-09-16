<?php
/**
 * Web Stories Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Insta_Gallery extends \Nekit_Modules\Insta_Gallery_Module {
    protected $widget_name = 'nekit-insta-gallery';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-insta-gallery';
	}
	
	public function get_keywords() {
		return [ 'instagram', 'insta', 'gallery', 'images', 'image', 'photo', 'photos' ];
	}
 }