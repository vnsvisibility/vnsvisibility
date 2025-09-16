<?php
/**
 * Plugin utilities class
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Utilities;

class Utils {
    public static function registered_widgets() {
        return apply_filters( 'nekit_registered_widgets_filter', array(
             "advanced-heading-icon" => [
                'name'  => esc_html__( 'Advanced Heading Icon', 'news-kit-elementor-addons' ),
                'category'  => 'advanced-heading',
                'icon'	=>	'icon-nekit-advanced-heading'
            ],
            "archive-posts" => [
                'name'  => esc_html__( 'Archive Posts', 'news-kit-elementor-addons' ),
                'category'  => 'archive',
                'icon'	=> 'icon-nekit-archive-posts'
            ],
            "archive-title" => [
                'name'  => esc_html__( 'Archive Title', 'news-kit-elementor-addons' ),
                'category'  => 'archive',
                'icon'	=> 'icon-nekit-single-title'
            ],
            "back-to-top" => [
                'name'  => esc_html__( 'Back To Top', 'news-kit-elementor-addons' ),
                'category'  => 'back-to-top',
                'icon'	=> 'icon-nekit-back-to-top'
            ],
            "breadcrumb" => [
                'name'  => esc_html__( 'Breadcrumb', 'news-kit-elementor-addons' ),
                'category'  => 'breadcrumb',
                'icon'	=>	'icon-nekit-breadcrumb'
            ],
            "categories-collection" => [
                'name'  => esc_html__( 'Categories Collection', 'news-kit-elementor-addons' ),
                'category'  => 'categories-collection',
                'icon'	=>	'icon-nekit-categories-collection'
            ],
            "date-and-time" => [
                'name'  => esc_html__( 'Date and Time', 'news-kit-elementor-addons' ),
                'category'  => 'date-and-time',
                'icon'	=> 'icon-nekit-date-time'
            ],
            "full-width-banner" => [
                'name'  => esc_html__( 'Full Width Banner', 'news-kit-elementor-addons' ),
                'category'  => 'full-width-banner',
                'icon'	=>	'icon-nekit-full-width-banner'
            ],
            "live-now-button" => [
                'name'  => esc_html__( 'live Now Button', 'news-kit-elementor-addons' ),
                'category'  => 'live-now-button',
                'icon'	=>	'icon-nekit-live-now-button'
            ],
            "live-search" => [
                'name'  => esc_html__( 'Live Search', 'news-kit-elementor-addons' ),
                'category'  => 'live-search',
                'icon'	=>	'icon-nekit-live-search'
            ],
            "mailbox" => [
                'name'  => esc_html__( 'Mailbox', 'news-kit-elementor-addons' ),
                'category'  => 'mailbox',
                'icon'	=>	'icon-nekit-mailbox'
            ],
            "main-banner-one" => [
                'name'  => esc_html__( 'Main Banner One', 'news-kit-elementor-addons' ),
                'category'  => 'banner',
                'icon'	=> 'icon-nekit-main-banner-one'
            ],
            "main-banner-two" => [
                'name'  => esc_html__( 'Main Banner Two', 'news-kit-elementor-addons' ),
                'category'  => 'banner',
                'icon'	=> 'icon-nekit-main-banner-two'
            ],
            "main-banner-three" => [
                'name'  => esc_html__( 'Main Banner Three', 'news-kit-elementor-addons' ),
                'category'  => 'banner',
                'icon'	=> 'icon-nekit-main-banner-three'
            ],
            "main-banner-four" => [
                'name'  => esc_html__( 'Main Banner Four', 'news-kit-elementor-addons' ),
                'category'  => 'banner',
                'icon'	=> 'icon-nekit-main-banner-four'
            ],
            "main-banner-five" => [
                'name'  => esc_html__( 'Main Banner Five', 'news-kit-elementor-addons' ),
                'category'  => 'banner',
                'icon'	=>	'icon-nekit-main-banner-five'
            ],
            "news-block-one" => [
                'name'  => esc_html__( 'News Block 1', 'news-kit-elementor-addons' ),
                'category'  => 'block',
                'icon'	=>	'icon-nekit-news-block-one'
            ],
            "news-block-two" => [
                'name'  => esc_html__( 'News Block 2', 'news-kit-elementor-addons' ),
                'category'  => 'block',
                'icon'	=>	'icon-nekit-news-block-two'
            ],
            "news-block-three" => [
                'name'  => esc_html__( 'News Block 3', 'news-kit-elementor-addons' ),
                'category'  => 'block',
                'icon'	=>	'icon-nekit-news-block-three'
            ],
            "news-block-four" => [
                'name'  => esc_html__( 'News Block 4', 'news-kit-elementor-addons' ),
                'category'  => 'block',
                'icon'	=>	'icon-nekit-news-block-four'
            ],
            "news-carousel-one" => [
                'name'  => esc_html__( 'News Carousel One', 'news-kit-elementor-addons' ),
                'category'  => 'carousel',
                'icon'	=>	'icon-nekit-carousel-one'
            ],
            "news-carousel-two" => [
                'name'  => esc_html__( 'News Carousel Two', 'news-kit-elementor-addons' ),
                'category'  => 'carousel',
                'icon'	=>	'icon-nekit-carousel-two'
            ],
            "news-carousel-three" => [
                'name'  => esc_html__( 'News Carousel Three', 'news-kit-elementor-addons' ),
                'category'  => 'carousel',
                'icon'	=>	'icon-nekit-carousel-three'
            ],
            "news-filter-one" => [
                'name'  => esc_html__( 'News Filter One', 'news-kit-elementor-addons' ),
                'category'  => 'filter',
                'icon'	=>	'icon-nekit-news-filter-one'
            ],
            "news-filter-two" => [
                'name'  => esc_html__( 'News Filter Two', 'news-kit-elementor-addons' ),
                'category'  => 'filter',
                'icon'	=>	'icon-nekit-news-filter-two'
            ],
            "news-filter-three" => [
                'name'  => esc_html__( 'News Filter Three', 'news-kit-elementor-addons' ),
                'category'  => 'filter',
                'icon'	=>	'icon-nekit-news-filter-three'
            ],
            "news-filter-four" => [
                'name'  => esc_html__( 'News Filter Four', 'news-kit-elementor-addons' ),
                'category'  => 'filter',
                'icon'	=>	'icon-nekit-news-filter-four'
            ],
            "news-grid-one" => [
                'name'  => esc_html__( 'News Grid One', 'news-kit-elementor-addons' ),
                'category'  => 'grid',
                'icon'	=>	'icon-nekit-grid-one'
            ],
            "news-grid-two" => [
                'name'  => esc_html__( 'News Grid Two', 'news-kit-elementor-addons' ),
                'category'  => 'grid',
                'icon'	=>	'icon-nekit-grid-two'
            ],
            "news-grid-three" => [
                'name'  => esc_html__( 'News Grid Three', 'news-kit-elementor-addons' ),
                'category'  => 'grid',
                'icon'	=>	'icon-nekit-grid-three'
            ],
            "news-timeline" => [
                'name'  => esc_html__( 'News Timeline', 'news-kit-elementor-addons' ),
                'category'  => 'news-timeline',
                'icon'	=>	'icon-nekit-news-timeline'
            ],
            "phone-call" => [
                'name'  => esc_html__( 'Phone Call', 'news-kit-elementor-addons' ),
                'category'  => 'phone-call',
                'icon'	=>	'icon-nekit-phone-call'
            ],
            "popular-opinions" => [
                'name'  => esc_html__( 'Popular Opinions', 'news-kit-elementor-addons' ),
                'category'  => 'popular-opinion',
                'icon'	=>	'icon-nekit-popular-opinions'
            ],
            "random-news" => [
                'name'  => esc_html__( 'Random News', 'news-kit-elementor-addons' ),
                'category'  => 'random-news',
                'icon'	=>	'icon-nekit-random-news'
            ],
            "single-author-box" => [
                'name'  => esc_html__( 'Single Author Box', 'news-kit-elementor-addons' ),
                'category'  => 'single-author-box',
                'icon'	=> 'icon-nekit-single-author-box'
            ],
            "single-author" => [
                'name'  => esc_html__( 'Single Author', 'news-kit-elementor-addons' ),
                'category'  => 'single-author',
                'icon'	=> 'icon-nekit-single-author'
            ],
            'single-content'	=>	[
                'name'	=>	esc_html__( 'Single Content', 'news-kit-elementor-addons' ),
                'category'  => 'single-content',
                'icon'	=>	'icon-nekit-single-content'
            ],
            "single-categories" => [
                'name'  => esc_html__( 'Single Categories', 'news-kit-elementor-addons' ),
                'category'  => 'single-categories',
                'icon'	=>	'icon-nekit-tags-cloud'
            ],
            "single-comment-box" => [
                'name'  => esc_html__( 'Single Comment Box', 'news-kit-elementor-addons' ),
                'category'  => 'single-comment-box',
                'icon'	=> 'icon-nekit-single-comment-box'
            ],
            "single-comment" => [
                'name'  => esc_html__( 'Single Comment', 'news-kit-elementor-addons' ),
                'category'  => 'single-comment',
                'icon'	=> 'icon-nekit-single-comment'
            ],
            "single-date" => [
                'name'  => esc_html__( 'Single Date', 'news-kit-elementor-addons' ),
                'category'  => 'single-date',
                'icon'	=> 'icon-nekit-single-date'
            ],
            "single-featured-image" => [
                'name'  => esc_html__( 'Single Featured Image', 'news-kit-elementor-addons' ),
                'category'  => 'single-featured-image',
                'icon'	=>	'icon-nekit-featured-image'
            ],
            "single-post-navigation" => [
                'name'  => esc_html__( 'Single Post Navigation', 'news-kit-elementor-addons' ),
                'category'  => 'single-post-navigation',
                'icon'	=>	'icon-nekit-single-post-navigation'
            ],
            "single-related-post" => [
                'name'  => esc_html__( 'Single Related post', 'news-kit-elementor-addons' ),
                'category'  => 'single-related-post',
                'icon'	=>	'icon-nekit-grid-one'
            ],
            "single-table-of-content" => [
                'name'  => esc_html__( 'Single Table Of Content', 'news-kit-elementor-addons' ),
                'category'  => 'single-table-of-content',
                'icon'	=>	'icon-nekit-table-of-content'
            ],
            "single-tags" => [
                'name'  => esc_html__( 'Single Tags', 'news-kit-elementor-addons' ),
                'category'  => 'single-tags',
                'icon'	=>	'icon-nekit-tags-cloud'
            ],
            "single-title" => [
                'name'  => esc_html__( 'Single Title', 'news-kit-elementor-addons' ),
                'category'  => 'single-title',
                'icon'	=> 'icon-nekit-single-title'
            ],
            "site-logo-title" => [
                'name'  => esc_html__( 'Site Logo Title', 'news-kit-elementor-addons' ),
                'category'  => 'site-logo-title',
                'icon'	=>	'icon-nekit-site-logo'
            ],
            "site-nav-menu" => [
                'name'  => esc_html__( 'Site Nav Menu', 'news-kit-elementor-addons' ),
                'category'  => 'site-nav-menu',
                'icon'	=> 'icon-nekit-site-nav-menu'
            ],
            "site-nav-mega-menu" => [
                'name'  => esc_html__( 'Site Nav Mega Menu', 'news-kit-elementor-addons' ),
                'category'  => 'site-nav-mega-menu',
                'icon'	=> 'icon-nekit-site-mega-menu'
            ],
            "theme-mode" => [
                'name'  => esc_html__( 'Theme Mode', 'news-kit-elementor-addons' ),
                'category'  => 'theme-mode',
                'icon'	=>	'icon-nekit-theme-mode'
            ],
            "ticker-news-one" => [
                'name'  => esc_html__( 'Ticker News One', 'news-kit-elementor-addons' ),
                'category'  => 'ticker',
                'icon'	=> 'icon-nekit-ticker-news-one'
            ],
            "ticker-news-two" => [
                'name'  => esc_html__( 'Ticker News Two', 'news-kit-elementor-addons' ),
                'category'  => 'ticker',
                'icon'	=>	'icon-nekit-ticker-news-slider'
            ],
            "video-playlist" => [
                'name'  => esc_html__( 'Video Playlist', 'news-kit-elementor-addons' ),
                'category'  => 'video-playlist',
                'icon'	=> 'icon-nekit-video-playlist'
            ],
            "news-list-one"   => [
                'name'  => esc_html__( 'News List 1', 'news-kit-elementor-addons' ),
                'category'  => 'list',
                'icon'	=>	'icon-nekit-list-one'
            ],
            "news-list-two"   => [
                'name'  => esc_html__( 'News List 2', 'news-kit-elementor-addons' ),
                'category'  => 'list',
                'icon'	=>	'icon-nekit-list-two'
            ],
            "news-list-three"   => [
                'name'  => esc_html__( 'News List 3', 'news-kit-elementor-addons' ),
                'category'  => 'list',
                'icon'	=>	'icon-nekit-list-three'
            ],
            "news-list-two"   => [
                'name'  => esc_html__( 'News List 2', 'news-kit-elementor-addons' ),
                'category'  => 'list',
                'icon'	=>	'icon-nekit-list-two'
            ],
            "tags-cloud"   => [
                'name'  => esc_html__( 'Tag Cloud', 'news-kit-elementor-addons' ),
                'category'  => 'tags-cloud',
                'icon'	=>	'icon-nekit-tags-cloud'
            ],
            "tags-cloud-animation"   => [
                'name'  => esc_html__( 'Tags Cloud Animation', 'news-kit-elementor-addons' ),
                'category'  => 'tags-cloud-animation',
                'icon'	=>	'icon-nekit-tags-cloud-animation'
            ],
            "canvas-menu"   => [
                'name'  => esc_html__( 'Canvas Menu', 'news-kit-elementor-addons' ),
                'category'  => 'canvas-menu',
                'icon'	=>	'icon-nekit-canvas-menu'
            ],
            "social-share"   => [
                'name'  => esc_html__( 'Social Share', 'news-kit-elementor-addons' ),
                'category'  => 'social-share',
                'icon'	=>	'icon-nekit-social-share'
            ],
            'sticky-posts'   =>  [
                'name'  => esc_html__( 'Sticky Posts', 'news-kit-elementor-addons' ),
                'category'  => 'tags-cloud-animation',
                'icon'	=>	'icon-nekit-tags-cloud-animation'
            ],
            'insta-gallery'   =>  [
                'name'  => esc_html__( 'Insta Gallery', 'news-kit-elementor-addons' ),
                'category'  => 'insta-gallery',
                'icon'	=>	'icon-nekit-tags-cloud-animation'
            ],
            'divider'   =>  [
                'name'  => esc_html__( 'Divider', 'news-kit-elementor-addons' ),
                'category'  => 'insta-gallery',
                'icon'	=>	'icon-nekit-tags-cloud-animation'
            ]
        ));
    }

    public static function get_registered_widgets_with_demo() {
        $widgets = array_filter( self::registered_widgets(), function( $widget_key ){
            $widgets_with_no_demo = [ 'back-to-top', 'archive-title', 'archive-posts', 'breadcrumb', 'date-and-time', 'mailbox', 'phone-call', 'random-news', 'single-author-box', 'single-author', 'single-categories', 'single-comment-box', 'single-comment', 'single-date', 'single-featured-image', 'single-post-navigation', 'single-related-post', 'single-table-of-content', 'single-tags', 'single-title', 'site-logo-title', 'site-nav-mega-menu', 'theme-mode', 'ticker-news-one', 'ticker-news-two' ];
    
            if( ! in_array( $widget_key, $widgets_with_no_demo ) ) return $widget_key;
        } , ARRAY_FILTER_USE_KEY );
        return $widgets;
    }

    /**
     * Get nekit widget categories
     * 
     * @since 1.3.1
     */
    public static function get_nekit_widget_categories() {
        return apply_filters( 'nekit_widget_categories_filter', [
            'nekit-widgets-group'   =>  [
                'label' =>  esc_html__( 'News Elementor Widgets', 'news-kit-elementor-addons' ),
                'widgets'   =>  [ 'advanced-heading-icon', 'back-to-top', 'date-and-time', 'live-now-button', 'live-search', 'mailbox', 'phone-call', 'random-news', 'site-logo-title', 'site-nav-mega-menu', 'theme-mode', 'video-playlist', 'tags-cloud', 'tags-cloud-animation', 'site-nav-menu', 'canvas-menu', 'social-share', 'insta-gallery', 'divider' ],
                'category'  =>  'general'
            ],
            'nekit-post-layouts-widgets-group'  =>  [
                'label' =>  esc_html__( 'News Elementor Posts Layouts', 'news-kit-elementor-addons' ),
                'widgets'   =>  [ 'categories-collection', 'full-width-banner', 'main-banner-one', 'main-banner-two', 'main-banner-three', 'main-banner-four', 'main-banner-five', 'news-block-one', 'news-block-two', 'news-block-three', 'news-block-four', 'news-carousel-one', 'news-carousel-two', 'news-carousel-three', 'news-filter-one', 'news-filter-two', 'news-filter-three', 'news-filter-four', 'news-grid-one', 'news-grid-two', 'news-grid-three', 'news-timeline', 'popular-opinions', 'ticker-news-one', 'ticker-news-two', 'news-list-one', 'news-list-two', 'news-list-three', 'sticky-posts' ],
                'category'  =>  'general'
            ],
            'nekit-archive-templates-widgets-group' =>  [
                'label' =>  esc_html__( 'News Elementor Archive', 'news-kit-elementor-addons' ),
                'widgets'   =>  [ 'archive-posts', 'archive-title' ],
                'category'  =>  'theme-builder'
            ],
            'nekit-single-templates-widgets-group'  =>  [
                'label' =>  esc_html__( 'News Elementor Single', 'news-kit-elementor-addons' ),
                'widgets'   =>  [ 'breadcrumb', 'single-author-box', 'single-author', 'single-categories', 'single-comment-box', 'single-comment', 'single-date', 'single-featured-image', 'single-post-navigation', 'single-related-post', 'single-table-of-content', 'single-tags', 'single-title', 'single-content' ],
                'category'  =>  'theme-builder'
            ]
        ]);
    }

    /**
     * Nekit Pro Widgets 
     * 
     * @since 1.3.1
     */
    public static function get_nekit_pro_widgets() {
        return apply_filters( 'nekit_pro_widgets_filter', [ 'breadcrumb', 'video-playlist', 'single-related-post', 'tags-cloud-animation' ] );
    }
    
    // Theme Builder Template Check
	public static function is_theme_builder_template() {
		$current_page = get_post(get_the_ID());

		if ( $current_page ) {
			return strpos($current_page->post_name, 'user-archive') !== false || strpos($current_page->post_name, 'user-single') !== false || strpos($current_page->post_name, 'user-product') !== false;
		} else {
			return false;
		}
	}

    public static function library_widgets_data() {
        $library_widgets_data = file_get_contents( NEKIT_PATH . '/library/assets/library.json' );
        return apply_filters( 'nekit_library_get_widgets_data', $library_widgets_data );
    }

    public static function library_pages_data() {
        $library_pages_data = file_get_contents( NEKIT_PATH . '/library/assets/library-pages.json' );
        return apply_filters( 'nekit_library_get_pages_data', $library_pages_data );
    }

    public function clear_theme_filters() {
        remove_filter( 'get_the_archive_title_prefix', 'nekit_prefix_string' ); // remove filter applied to the archive title
    }
}