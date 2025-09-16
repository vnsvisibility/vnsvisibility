<?php
/**
 * Widgets manager 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! function_exists( 'news_kit_elementor_addons_add_menu_description' ) ) :
	// merge menu description element to the menu 
	function news_kit_elementor_addons_add_menu_description( $item_output, $item, $depth, $args ) {
		if ( !empty( $item->description ) ) {
			$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
		}
		return $item_output;
	}
endif;

if( ! function_exists( 'nekit_register_custom_widgets' ) ) :
    /**
     * Register Wdigets for elementor editor 
     * 
     * @since 1.0.0
     * @package News Kit Elementor Addons
     */
    function nekit_register_custom_widgets( $widgets_manager ) {
        require_once( __DIR__ . '/widgets/base.php' );
        require_once( __DIR__ . '/widgets/social-share/module.php' );
        require_once( __DIR__ . '/widgets/ticker-news/module.php' );
        require_once( __DIR__ . '/widgets/site-logo-title/module.php' );
        require_once( __DIR__ . '/widgets/theme-mode/module.php' );
        require_once( __DIR__ . '/widgets/site-nav-mega-menu/module.php' );
        require_once( __DIR__ . '/widgets/site-nav-menu/module.php' );
        require_once( __DIR__ . '/widgets/random-news/module.php' );
        require_once( __DIR__ . '/widgets/popular-opinions/module.php' );
        require_once( __DIR__ . '/widgets/phone-call/module.php' );
        require_once( __DIR__ . '/widgets/news-timeline/module.php' );
        require_once( __DIR__ . '/widgets/mailbox/module.php' );
        require_once( __DIR__ . '/widgets/advanced-heading-icon/module.php' );
        require_once( __DIR__ . '/widgets/back-to-top/module.php' );
        require_once( __DIR__ . '/widgets/news-carousel/module.php' );
        require_once( __DIR__ . '/widgets/news-grid/module.php' );
        require_once( __DIR__ . '/widgets/news-list/module.php' );
        require_once( __DIR__ . '/widgets/single/module.php' );
        require_once( __DIR__ . '/widgets/news-block/module.php' );
        require_once( __DIR__ . '/widgets/news-filter/module.php' );
        require_once( __DIR__ . '/widgets/live-now-button/module.php' );
        require_once( __DIR__ . '/widgets/full-width-banner/module.php' );
        require_once( __DIR__ . '/widgets/live-search/module.php' );
        require_once( __DIR__ . '/widgets/date-and-time/module.php' );
        require_once( __DIR__ . '/widgets/categories-collection/module.php' );
        require_once( __DIR__ . '/widgets/tags-cloud/module.php' );
        require_once( __DIR__ . '/widgets/canvas-menu/module.php' );
        require_once( __DIR__ . '/widgets/sticky-posts/module.php' );
        require_once( __DIR__ . '/widgets/insta-gallery/module.php' );
        require_once( __DIR__ . '/widgets/divider/module.php' );

        require_once( __DIR__ . '/widgets/ticker-news/ticker-news-one.php' );
        require_once( __DIR__ . '/widgets/news-list/news-list-one.php' );
        require_once( __DIR__ . '/widgets/news-list/news-list-two.php' );
        require_once( __DIR__ . '/widgets/news-list/news-list-three.php' );
        require_once( __DIR__ . '/widgets/news-grid/news-grid-one.php' );
        require_once( __DIR__ . '/widgets/news-grid/news-grid-two.php' );
        require_once( __DIR__ . '/widgets/news-grid/news-grid-three.php' );
        require_once( __DIR__ . '/widgets/news-carousel/news-carousel-one.php' );
        require_once( __DIR__ . '/widgets/news-carousel/news-carousel-two.php' );
        require_once( __DIR__ . '/widgets/news-carousel/news-carousel-three.php' );
        require_once( __DIR__ . '/widgets/main-banner/main-banner-one.php' );
        require_once( __DIR__ . '/widgets/main-banner/main-banner-two.php' );
        require_once( __DIR__ . '/widgets/main-banner/main-banner-three.php' );
        require_once( __DIR__ . '/widgets/main-banner/main-banner-four.php' );
        require_once( __DIR__ . '/widgets/site-logo-title/site-logo-title.php' );
        require_once( __DIR__ . '/widgets/site-nav-mega-menu/site-nav-mega-menu.php' );
        require_once( __DIR__ . '/widgets/site-nav-menu/site-nav-menu.php' );
        require_once( __DIR__ . '/widgets/phone-call/phone-call.php' );
        require_once( __DIR__ . '/widgets/mailbox/mailbox.php' );
        require_once( __DIR__ . '/widgets/back-to-top/back-to-top.php' );
        require_once( __DIR__ . '/widgets/live-search/live-search.php' );
        require_once( __DIR__ . '/widgets/date-and-time/date-and-time.php');
        require_once( __DIR__ . '/widgets/random-news/random-news.php' );
        require_once( __DIR__ . '/widgets/live-now-button/live-now-button.php' );
        require_once( __DIR__ . '/widgets/theme-mode/theme-mode.php' );
        require_once( __DIR__ . '/widgets/popular-opinions/popular-opinions.php' );
        require_once( __DIR__ . '/widgets/archive/archive-title.php' );
        require_once( __DIR__ . '/widgets/archive/archive-posts.php' );
        require_once( __DIR__ . '/widgets/single/single-title.php' );
        require_once( __DIR__ . '/widgets/full-width-banner/full-width-banner.php' );
        require_once( __DIR__ . '/widgets/categories-collection/categories-collection.php' );
        require_once( __DIR__ . '/widgets/news-timeline/news-timeline.php' );
        require_once( __DIR__ . '/widgets/advanced-heading-icon/advanced-heading-icon.php' );
        require_once( __DIR__ . '/widgets/single/single-featured-image.php' );
        require_once( __DIR__ . '/widgets/single/single-content.php' );
        require_once( __DIR__ . '/widgets/single/single-tags.php' );
        require_once( __DIR__ . '/widgets/single/single-categories.php' );
        require_once( __DIR__ . '/widgets/single/single-date.php' );
        require_once( __DIR__ . '/widgets/single/single-author.php' );
        require_once( __DIR__ . '/widgets/single/single-author-box.php' );
        require_once( __DIR__ . '/widgets/single/single-comment.php' );
        require_once( __DIR__ . '/widgets/single/single-comment-box.php' );
        require_once( __DIR__ . '/widgets/single/single-post-navigation.php' );
        require_once( __DIR__ . '/widgets/single/single-table-of-content.php' );
        require_once( __DIR__ . '/widgets/news-block/news-block-one.php' );
        require_once( __DIR__ . '/widgets/news-block/news-block-two.php' );
        require_once( __DIR__ . '/widgets/news-filter/news-filter-one.php' );
        require_once( __DIR__ . '/widgets/news-filter/news-filter-two.php' );
        require_once( __DIR__ . '/widgets/news-block/news-block-three.php' );
        require_once( __DIR__ . '/widgets/news-block/news-block-four.php' );
        require_once( __DIR__ . '/widgets/news-filter/news-filter-three.php' );
        require_once( __DIR__ . '/widgets/news-filter/news-filter-four.php' );
        require_once( __DIR__ . '/widgets/ticker-news/ticker-news-two.php' );
        require_once( __DIR__ . '/widgets/main-banner/main-banner-five.php' );
        require_once( __DIR__ . '/widgets/social-share/social-share.php' );
        require_once( __DIR__ . '/widgets/tags-cloud/tags-cloud.php' );
        require_once( __DIR__ . '/widgets/canvas-menu/canvas-menu.php' );
        require_once( __DIR__ . '/widgets/sticky-posts/sticky-posts.php' );
        require_once( __DIR__ . '/widgets/insta-gallery/insta-gallery.php' );
        require_once( __DIR__ . '/widgets/divider/divider.php' );

        $widgets_manager->register( new \Nekit_Widgets\Ticker_News_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Ticker_News_Two_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Main_Banner_Widget_One() );
        $widgets_manager->register( new \Nekit_Widgets\Main_Banner_Widget_Two() );
        $widgets_manager->register( new \Nekit_Widgets\Main_Banner_Widget_Three() );
        $widgets_manager->register( new \Nekit_Widgets\Main_Banner_Widget_Four() );
        $widgets_manager->register( new \Nekit_Widgets\Main_Banner_Widget_Five() );
        $widgets_manager->register( new \Nekit_Widgets\Full_Width_Banner() );
        $widgets_manager->register( new \Nekit_Widgets\List_Widget_One() );
        $widgets_manager->register( new \Nekit_Widgets\List_Widget_Two() );
        $widgets_manager->register( new \Nekit_Widgets\List_Widget_Three() );
        $widgets_manager->register( new \Nekit_Widgets\Grid_Widget_One() );
        $widgets_manager->register( new \Nekit_Widgets\Grid_Widget_Two() );
        $widgets_manager->register( new \Nekit_Widgets\Grid_Widget_Three() );
        $widgets_manager->register( new \Nekit_Widgets\Carousel_Widget_One() );
        $widgets_manager->register( new \Nekit_Widgets\Carousel_Widget_Two() );
        $widgets_manager->register( new \Nekit_Widgets\Carousel_Widget_Three() );
        $widgets_manager->register( new \Nekit_Widgets\Site_Logo_Title_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Site_Nav_Mega_Menu_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Site_Nav_Menu_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Phone_Call_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Mail_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Back_To_Top_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Live_Search_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Date_And_Time_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Random_News_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Live_Now_Button_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Theme_Mode_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Popular_Opinions() );
        $widgets_manager->register( new \Nekit_Widgets\Categories_Collection() );
        $widgets_manager->register( new \Nekit_Widgets\News_Timeline() );
        $widgets_manager->register( new \Nekit_Widgets\Advanced_Heading_icon() );
        $widgets_manager->register( new \Nekit_Widgets\News_Block_One() );
        $widgets_manager->register( new \Nekit_Widgets\News_Block_Two() );
        $widgets_manager->register( new \Nekit_Widgets\News_Block_Three() );
        $widgets_manager->register( new \Nekit_Widgets\News_Block_Four() );
        $widgets_manager->register( new \Nekit_Widgets\Filter_Widget_One() );
        $widgets_manager->register( new \Nekit_Widgets\Filter_Widget_Two() );
        $widgets_manager->register( new \Nekit_Widgets\Filter_Widget_Three() );
        $widgets_manager->register( new \Nekit_Widgets\Filter_Widget_Four() );
        $widgets_manager->register( new \Nekit_Widgets\Tags_Cloud_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Canvas_Menu_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Social_Share_Widget() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Title() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Featured_Image() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Content() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Tags() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Categories() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Date() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Author() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Author_Box() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Comment() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Comment_Box() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Post_Navigation() );
        $widgets_manager->register( new \Nekit_Widgets\Single\Table_Of_Content() );
        $widgets_manager->register( new \Nekit_Widgets\Archive\Title() );
        $widgets_manager->register( new \Nekit_Widgets\Archive\Posts() );
        $widgets_manager->register( new \Nekit_Widgets\Sticky_Posts() );
        $widgets_manager->register( new \Nekit_Widgets\Insta_Gallery() );
        $widgets_manager->register( new \Nekit_Widgets\Nekit_Divider_Widget() );

        /* Unregister nekit widgets. */
        $nekit_disabled_widgets = nekit_get_settings([ 'key' => 'nekit_disabled_widgets' ]);
        if( ! empty( $nekit_disabled_widgets ) && is_array( $nekit_disabled_widgets ) ) :
            foreach( $nekit_disabled_widgets as $widget ) :
                $widgets_manager->unregister( 'nekit-' . $widget );
            endforeach;
        endif;
    }
    add_action( 'elementor/widgets/register', 'nekit_register_custom_widgets', 99 );
endif;

if( ! function_exists( 'nekit_register_document_type' ) ) :
    /**
     * Register custom document type for plugin
     * 
     * @since 1.0.0
     */ 
    function nekit_register_document_type( $documents_manager ) {
        // custom documents
        require NEKIT_PATH . '/includes/widgets/single/document.php';
		$documents_manager->register_document_type( 'nekit-document', 'Nekit_Document' );
    }
    add_action( 'elementor/documents/register', 'nekit_register_document_type' );
endif;

if( ! function_exists( 'nekit_register_settings_tab' ) ) :
    /**
     * Register custom settings tab
     * 
     * @since 1.0.0
     */
    function nekit_register_settings_tab($kit) {
        // custom settings tab
        require_once( NEKIT_PATH . '/custom/tabs/settings-preloader.php' );
        require_once( NEKIT_PATH . '/custom/tabs/settings-background-animation.php' );
		$kit->register_tab( 'nekit-settings-preloader', '\News_Kit_Elementor_Addons_Tabs\Nekit_Settings_Preloader' );
		$kit->register_tab( 'nekit-settings-background-animation', '\News_Kit_Elementor_Addons_Tabs\Nekit_Settings_Background_Animation' );
    }
    add_action( 'elementor/kit/register_tabs', 'nekit_register_settings_tab' );
endif;

if( ! function_exists( 'nekit_register_new_controls' ) ) :
    /**
     * Register new controls
     * 
     * @since 1.0.0
     */
    function nekit_register_new_controls( $controls_manager ) {
        require_once( __DIR__ . '/controls/radio-image/radio-image-control.php' );
        require_once( __DIR__ . '/controls/select2-extend/select2-control.php' );
        require_once( __DIR__ . '/controls/sortable/sortable-control.php' );
        require_once( __DIR__ . '/controls/number-select/number-select-control.php' );

        $controls_manager->register( new \Nekit_Elementor_Controls\Radio_Image_Control() );
        $controls_manager->register( new \Nekit_Elementor_Controls\Select2_Extend() );
        $controls_manager->register( new \Nekit_Elementor_Controls\Sortable_Control() );
        $controls_manager->register( new \Nekit_Elementor_Controls\Number_Select_Control() );
    }
    add_action( 'elementor/controls/register', 'nekit_register_new_controls' );
endif;

require_once( __DIR__ . '/vendors/filters.php' );
require_once( __DIR__ . '/vendors/vendors.php' );
require_once( __DIR__ . '/utils.php' );
require_once( __DIR__ . '/source.php' );