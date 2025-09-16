<?php
/**
 * Class to handle plugin functions
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Addon;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Plugin as Elementor_Plugin;

final class Plugin {
    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     * @var \Nekit_Addon\Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     * @return \Nekit_Addon\Plugin An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    /**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

    /**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function is_compatible() {
		// Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( \ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Check if Elementor Editor is open.
	 *
	 * @since  1.0.0
	 *
	 * @return boolean True IF Elementor Editor is loaded, False If Elementor Editor is not loaded.
	 */
	private function is_elementor_editor() {
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}
		return false;
	}

	/**
	 * Initialize
	 *
	 * Load the addons functionality only after Elementor is initialized.
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ], 99 );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontend_scripts' ], 99 );
		add_action( 'elementor/preview/enqueue_scripts', [ $this, 'preview_scripts' ] );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'preview_styles' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
		add_filter( 'elementor/editor/localize_settings', [$this, 'register_premium_widgets']);
		add_action( 'wp_ajax_nekit_live_search_widget_posts_content', [$this,'live_search_widget_posts_content']);
		add_action( 'wp_ajax_nopriv_nekit_live_search_widget_posts_content', [$this,'live_search_widget_posts_content'] );
		add_action( 'wp_ajax_nekit_news_filter_tab_content_change', [$this,'news_filter_widget_tab_content_change']);
		add_action( 'wp_ajax_nopriv_nekit_news_filter_tab_content_change', [$this,'news_filter_widget_tab_content_change'] );
		add_action( 'wp_ajax_nekit_archive_posts_ajax_load_more', [$this,'archive_posts_ajax_load_more']);
		add_action( 'wp_ajax_nopriv_nekit_archive_posts_ajax_load_more', [$this,'archive_posts_ajax_load_more'] );
		add_action( 'wp_ajax_nekit_grid_widget_ajax_content', [$this,'grid_widget_ajax_content'] );
		add_action( 'wp_ajax_nopriv_nekit_grid_widget_ajax_content', [$this,'grid_widget_ajax_content'] );
		add_action( 'wp_ajax_nekit_list_widget_ajax_content', [$this,'list_widget_ajax_content'] );
		add_action( 'wp_ajax_nopriv_nekit_list_widget_ajax_content', [$this,'list_widget_ajax_content'] );
		add_action( 'wp_ajax_nekit_block_widget_ajax_content', [$this,'block_widget_ajax_content'] );
		add_action( 'wp_ajax_nopriv_nekit_block_widget_ajax_content', [$this,'block_widget_ajax_content'] );
		add_action( 'wp_ajax_nekit_single_related_posts_widget_ajax_content', [$this,'single_related_posts_widget_ajax_content'] );
		add_action( 'wp_ajax_nopriv_nekit_single_related_posts_widget_ajax_content', [$this,'single_related_posts_widget_ajax_content'] );
		add_action( 'wp', [ $this, 'theme_builder_compatibility' ] );
		add_action( 'elementor/preview/init', [ $this, 'nekit_library_modal_html' ] );
		add_filter( 'admin_footer_text', [ $this, 'nekit_admin_footer_text' ] );
		
		// Load plugin file
	    require_once( __DIR__ . '/widgets-manager.php' );
	    require_once( __DIR__ . '/controls/select2-extend/select2-extend-api.php' );
	    require_once( NEKIT_PATH . '/custom/meta.php' );

		add_action( 'wp_footer', [ $this, 'render_popup' ] );
		add_filter( 'template_include', [ $this, 'render_test' ] );
		add_action( 'elementor/page_templates/canvas/nekit_print_content', [ $this, 'nekit_frontend_template_display' ] );
	}
	
    public function frontend_styles() {
		require_once NEKIT_PATH . 'admin/assets/wptt-webfont-loader.php';
		wp_register_style( 'nekit-fonts', wptt_get_webfont_url( $this->get_fonts_url() ), array(), null );
		wp_register_style( 'slick', plugins_url( 'assets/external/slick/slick.min.css', __FILE__ ), '1.8.0' );
		wp_register_style( 'nekit-swiper', plugins_url( 'assets/external/swiper/swiper-bundle.min.css', __FILE__ ), '11.2.5' );
		wp_register_style( 'nekit-main-one', plugins_url( 'assets/css/frontend-style-one.css', __FILE__ ) );
		wp_register_style( 'fontawesome', plugins_url( 'assets/external/fontawesome/css/all.min.css', __FILE__ ) );

		// menu animation
		wp_register_style( 'nekit-main', plugins_url( 'assets/css/frontend-style.css', __FILE__ ) );
		wp_register_style( 'nekit-link-animation', plugins_url( 'assets/css/link-animation.css', __FILE__ ) );
		wp_register_style( 'nekit-text-animation' , plugins_url( 'assets/css/text-animation.css',__FILE__ ) );
		wp_register_style( 'nekit-main-responsive-one', plugins_url( 'assets/css/frontend-responsive-one.css', __FILE__ ) );
		wp_register_style( 'nekit-main-responsive', plugins_url( 'assets/css/frontend-responsive.css', __FILE__ ) );
		wp_register_style( 'nekit-popup', plugins_url( 'assets/css/popup-builder.css', __FILE__ ) );

		// blocks css
		wp_register_style( 'nekit-grid-css', plugins_url( 'assets/css/widgets/grid.css', __FILE__ ) );
		wp_register_style( 'nekit-carousel-css', plugins_url( 'assets/css/widgets/carousel.css', __FILE__ ) );
		wp_register_style( 'nekit-list-css', plugins_url( 'assets/css/widgets/list.css', __FILE__ ) );
		wp_register_style( 'nekit-filter-css', plugins_url( 'assets/css/widgets/filter.css', __FILE__ ) );
		wp_register_style( 'nekit-main-banner-css', plugins_url( 'assets/css/widgets/main-banner.css', __FILE__ ) );
		wp_register_style( 'nekit-single-css', plugins_url( 'assets/css/widgets/single.css', __FILE__ ) );
		wp_register_style( 'nekit-comment-css', plugins_url( 'assets/css/widgets/comment.css', __FILE__ ) );
		wp_register_style( 'nekit-news-block-css', plugins_url( 'assets/css/widgets/news-block.css', __FILE__ ) );
		wp_register_style( 'nekit-table-css', plugins_url( 'assets/css/widgets/table.css', __FILE__ ) );
		wp_register_style( 'nekit-ticker-news-css', plugins_url( 'assets/css/widgets/ticker-news.css', __FILE__ ) );
		wp_register_style( 'nekit-social-share-css', plugins_url( 'assets/css/widgets/social-share.css', __FILE__ ) );

		// preloader css
		wp_register_style( 'nekit-preloader-animation', plugins_url( 'assets/css/preloader-animation.css', __FILE__ ) );

		wp_enqueue_style( 'nekit-fonts' );
		wp_enqueue_style( 'nekit-swiper' );
		wp_enqueue_style( 'slick' );
		wp_enqueue_style( 'nekit-main-one' );
		wp_enqueue_style( 'nekit-main' );
		wp_add_inline_style( 'nekit-main', $this->add_general_css() );
		wp_enqueue_style( 'nekit-link-animation' );
		wp_enqueue_style( 'nekit-text-animation' );		
		wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'nekit-main-responsive-one' );
		wp_enqueue_style( 'nekit-main-responsive' );
		wp_enqueue_style( 'nekit-grid-css' );
		wp_enqueue_style( 'nekit-carousel-css' );
		wp_enqueue_style( 'nekit-list-css' );
		wp_enqueue_style( 'nekit-filter-css' );
		wp_enqueue_style( 'nekit-main-banner-css' );
		wp_enqueue_style( 'nekit-single-css' );
		wp_enqueue_style( 'nekit-comment-css' );
		wp_enqueue_style( 'nekit-news-block-css' );
		wp_enqueue_style( 'nekit-table-css' );
		wp_enqueue_style( 'nekit-ticker-news-css' );
		wp_enqueue_style( 'nekit-social-share-css' );
		wp_enqueue_style( 'nekit-preloader-animation' );
		wp_enqueue_style( 'nekit-popup' );
	}

	public function frontend_scripts() {
		wp_register_script( 'nekit-swiper', plugins_url( 'assets/external/swiper/swiper-bundle.min.js', __FILE__ ), [ 'jquery' ], '11.2.5', true );
		wp_register_script( 'slick', plugins_url( 'assets/external/slick/slick.min.js', __FILE__ ), [ 'jquery' ], '1.8.0', true );
		wp_register_script( 'js-marquee', plugins_url( 'assets/external/js-marquee/jquery.marquee.min.js', __FILE__ ), [ 'jquery' ], '1.0.0', true );
		wp_register_script( 'typed-js', plugins_url( 'assets/external/typed-main/typed.umd.js', __FILE__ ), [], '3', true );
		wp_register_script( 'jquery-cookie', plugins_url( 'assets/external/jquery-cookie/jquery-cookie.js', __FILE__ ), ['jquery'], '1.4.1', true );
		wp_register_script( 'nekit-main-frontend-data-source', plugins_url( 'assets/js/frontend-script-data.js', __FILE__ ), [ 'jquery' ], '1.0.0', false );
		wp_register_script( 'nekit-main', plugins_url( 'assets/js/frontend-script.js', __FILE__ ), [ 'jquery' ], '1.0.0', true );

		wp_enqueue_script( 'nekit-swiper' );
		wp_enqueue_script( 'slick' );
		wp_enqueue_script( 'js-marquee' );
		wp_enqueue_script( 'typed-js' );
		wp_enqueue_script( 'jquery-cookie' );
		wp_enqueue_script( 'nekit-main-frontend-data-source' );
		wp_enqueue_script( 'nekit-main' );

		wp_localize_script( 'nekit-main-frontend-data-source', 'frontendDataSource', [
            '_wpnonce'	=> wp_create_nonce( 'nekit-frontend-nonce' ),
			'ajaxUrl'	=> admin_url('admin-ajax.php'),
			'preloader'	=> ( get_option( 'nekit_preloader_option' ) ) ? esc_html( get_option( 'nekit_preloader_option' ) ) : 'none',
			'preloaderExitAnimation'=> ( get_option( 'nekit_preloader_exit_animation' ) ) ? esc_html( get_option( 'nekit_preloader_exit_animation' ) ) : 'none',
			'isElementorPreview'	=> ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) ? \Elementor\Plugin::$instance->preview->is_preview_mode() : false
        ]);

		wp_localize_script( 'nekit-main', 'frontendData', [
            '_wpnonce'	=> wp_create_nonce( 'nekit-frontend-nonce' ),
			'ajaxUrl'	=> admin_url('admin-ajax.php')
        ]);
	}

	public function preview_scripts() {
		wp_register_script( 'nekit-preview', plugins_url( 'assets/js/frontend-preview.js', __FILE__ ), [ 'jquery', 'masonry' ], '1.3.1', [ 'strategy' => 'defer', 'in_footer' => true ] );
		wp_enqueue_script('masonry');
		wp_enqueue_script( 'nekit-preview' );
		wp_localize_script( 'nekit-preview', 'frontendPreviewData', [
            '_wpnonce'	=> wp_create_nonce( 'nekit-frontend-nonce' ),
			'ajaxUrl'	=> admin_url('admin-ajax.php')
        ]);
	}

	public function preview_styles() {
		wp_register_style( 'nekit-preview', plugins_url( 'assets/css/frontend-preview.css', __FILE__ ) );
		wp_enqueue_style( 'nekit-preview' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'news-kit-elementor-addons' ),
			'<strong>' . esc_html__( 'News Kit Elementor Addons', 'news-kit-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'news-kit-elementor-addons' ) . '</strong>'
		);

		echo wp_kses_post( sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ) );
	}

	/**
	 * Runs hooks for theme builder to make it global compatibility
	 * 
	 */
	public function theme_builder_compatibility() {
		/* Header */
		add_action( 'get_header', [ $this, 'render_header' ] );
		add_action( 'elementor/page_templates/canvas/before_content', [ $this, 'render_canvas_header' ] );

		/* Footer */
		add_action( 'get_footer', [ $this, 'render_footer' ] );
		add_action( 'elementor/page_templates/canvas/after_content', [ $this, 'render_canvas_footer' ] );
	}

	/**
	 * MARK: TEST
	 */
	public function render_test( $template ) {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$conditions_matches = false;
		if( is_single() ) {
			if( $Nekit_render_templates_html->is_template_available( 'single' ) ) $conditions_matches = true;
		} else if( is_archive() ) {

			if( is_category() ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archivepostcategories-nekitallnekit']);
			} else if( is_tag() ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposttags-nekitallnekit']);
			} else if( is_author() ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveauthor-nekitallnekit']);
			} else if( is_date() ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'datearchive']);
			} else if( is_tax() ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archives-all']);
			}
			if( $archive_template ) $conditions_matches = true;

		} else if( is_search() ) {

			$search_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'searchresultsarchive']);
			if( $search_template ) $conditions_matches = true;

		} else if( is_page() ) {

			$child_page = is_front_page() ? 'frontpage' : 'pages-nekitallnekit';
			$page_template = nekit_get_conditions_settings_builder_id(['parent' => 'single-builder','child' => $child_page]);
			if( $page_template ) $conditions_matches = true;

		} else if( is_home() ) {

			$home_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposts']);
			if( $home_template ) $conditions_matches = true;

		} else if( is_404() ) {
			$error_page_template = nekit_get_conditions_settings_builder_id(['parent' => '404-builder','child' => '404page']);
			if( $error_page_template ) $conditions_matches = true;
		}

		if( $conditions_matches ) :
			return NEKIT_PATH . '/admin/templates/canvas.php';
		else:
			return $template;
		endif;
	}

	/**
	 * MARK: TEST
	 */
	public function nekit_frontend_template_display() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$template = '';

		if( is_single() || is_page() ) {

			if( $Nekit_render_templates_html->is_template_available( 'single' ) ) :
				$template =  $Nekit_render_templates_html->current_builder_template();
			endif;

		} else if( is_archive() || is_search() || is_home() ) {

			if( $Nekit_render_templates_html->is_template_available( 'archive' ) ) :
				$template =  $Nekit_render_templates_html->current_builder_template();
			endif;
			
		} else if( is_404() ) {
			if( $Nekit_render_templates_html->is_template_available( '404' ) ) :
				$template =  $Nekit_render_templates_html->current_builder_template();
			endif;
		}
		echo $template;
	}

	/**
	 * Render active header builder content
	 * 
	 */
	function render_header() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$header_rendered = false;
		if( $Nekit_render_templates_html->is_template_available('header') ) {
			$header_rendered = true;
			require NEKIT_PATH . '/admin/templates/parts/builder-header-render.php';
			$templates   = [];
			$templates[] = 'header.php';
			
			remove_all_actions( 'wp_head' ); // Avoid running wp_head hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
		}
	}

	/**
	 * MARK: TEST
	 */
	public function render_canvas_header() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$header_rendered = false;
		if( $Nekit_render_templates_html->is_template_available('header') ) {
			$header_rendered = true;
			require NEKIT_PATH . '/admin/templates/parts/builder-header-render.php';
			$templates   = [];
			$templates[] = 'header.php';
			
			remove_all_actions( 'wp_head' ); // Avoid running wp_head hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
		} else {
			if( ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) get_header();
		}
	}

	/**
	 * Render active footer builder content
	 * 
	 */
	function render_footer() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$footer_rendered = false;
		if( $Nekit_render_templates_html->is_template_available('footer') ) {
			$footer_rendered = true;
			require NEKIT_PATH . '/admin/templates/parts/builder-footer-render.php';
			$templates   = [];
			$templates[] = 'footer.php';
			
			remove_all_actions( 'wp_footer' ); // Avoid running wp_footer hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
		}
	}
	
	/**
	 * MARK: TEST
	 */
	function render_canvas_footer() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		$footer_rendered = false;
		if( $Nekit_render_templates_html->is_template_available('footer') ) {
			$footer_rendered = true;
			require NEKIT_PATH . '/admin/templates/parts/builder-footer-render.php';
			$templates   = [];
			$templates[] = 'footer.php';
			
			remove_all_actions( 'wp_footer' ); // Avoid running wp_footer hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
		} else {
			if( ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) get_footer();
		}
	}


	/**
	 * Render active archive builder content
	 */
	function render_archive() {
		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		if( $Nekit_render_templates_html->is_template_available('archive') ) {
			add_action( 'template_include', function() {
				echo $Nekit_render_templates_html->current_builder_template();
			});
		}
	}

	/**
	 * Render active popup builder content
	 */
	function render_popup() {
		if( \Elementor\Plugin::$instance->preview->is_preview_mode() ) return;
		$default_values = [
			'nekit_open_popup'	=>	'page-load',
			'nekit_delay_after_page_load'	=>	1,
			'nekit_show_again_delay'	=>	[
				'number'	=>	1,
				'select'	=>	'minute'
			],
			'nekit_to_show_after_scroll'	=>	30,
			'nekit_element_id'	=>	'',
			'nekit_popup_close_on_esc'	=>	true,
			'nekit_popup_enable_automatic_closing'	=>	false,
			'nekit_delay_close_automatically_after'	=>	5,
			'nekit_popup_close_button_display'	=>	true,
			'nekit_popup_close_button_display_delay'	=>	0,
			'nekit_popup_enable_overlay'	=>	true,
			'nekit_popup_enable_closing_on_overlay_click'	=>	true,
			'nekit_popup_on_scroll'	=>	'every',
			'nekit_popup_disable_page_scroll'	=>	false,
			'nekit_display_as'	=>	'modal'
		];

		$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
		if( $Nekit_render_templates_html->is_template_available( 'popup' ) ) :
			$template_ids = $Nekit_render_templates_html->get_current_builder_id();	/* Get Template ids */
			if( ! empty( $template_ids ) && is_array( $template_ids ) ) :
				$reversed_template_ids = array_reverse( $template_ids );
				foreach( $reversed_template_ids as $template_id ):
					$id_attribute = 'nekit-popup-post-' . $template_id;	/* ID Attribute */
					$class_attributes = 'nekit-popup-wrapper';	/* Class Attribute */
					$class_attributes .= ' nekit-popup-template';	/* Class Attribute */
					$new_control_values = get_post_meta( $template_id, '_elementor_page_settings', true );	/* Meta */

					/* Reponsive */
					$nekit_display_as = isset( $new_control_values[ 'nekit_display_as' ] ) ? $new_control_values[ 'nekit_display_as' ] : 'model';
					$nekit_popup_entrance_animation = isset( $new_control_values[ 'nekit_popup_entrance_animation' ] ) ? $new_control_values[ 'nekit_popup_entrance_animation' ] : 'none';
					$nekit_popup_height_select = isset( $new_control_values[ 'nekit_popup_height_select' ] ) ? $new_control_values[ 'nekit_popup_height_select' ] : 'auto';
					$enabled_in_desktop = isset( $new_control_values[ 'nekit_popup_show_in_desktop' ] ) ? $new_control_values[ 'nekit_popup_show_in_desktop' ] : true;
					$enabled_in_tablet = isset( $new_control_values[ 'nekit_popup_show_in_tablet' ] ) ? $new_control_values[ 'nekit_popup_show_in_tablet' ] : true;
					$enabled_in_smartphone = isset( $new_control_values[ 'nekit_popup_show_in_smartphone' ] ) ? $new_control_values[ 'nekit_popup_show_in_smartphone' ] : true;
					$class_attributes .= ' as-' . $nekit_display_as;
					$class_attributes .= ' height-' . $nekit_popup_height_select;
					if( $enabled_in_desktop ) $class_attributes .= ' desktop--on';
					if( $enabled_in_tablet ) $class_attributes .= ' tablet--on';
					if( $enabled_in_smartphone ) $class_attributes .= ' smartphone--on';

					/* Merging default values with new control values */
					if( ! empty( $new_control_values ) && is_array( $new_control_values ) ) :
						$needed_settings = array_intersect_key( $new_control_values, $default_values );
						$control_values = array_merge( $default_values, $needed_settings );
					else:
						$control_values = $default_values;
					endif;
					$data_attributes = wp_json_encode( $control_values );	/* Data Attribute */

					$innerContainerClass = 'nekit-popup-inner-container';
					$innerContainerClass .= ' ' . $nekit_popup_entrance_animation;
					?>
						<div id="<?php echo esc_attr( $id_attribute ); ?>" class="<?php echo esc_attr( $class_attributes ); ?>" data-settings="<?php echo esc_attr( $data_attributes ); ?>">
							<div class="nekit-popup-container">
								<div class="nekit-popup-overlay"></div>
								<div class="<?php echo esc_attr( $innerContainerClass ); ?>">
									<?php if( $control_values[ 'nekit_popup_close_button_display' ] ) : ?>
										<button class="nekit-popup-close">
											<span class="dashicons dashicons-no"></span>
										</button>
									<?php endif; ?>
									<div class="nekit-popup-wrap">
										<?php echo $Nekit_render_templates_html->current_builder_template( $template_id ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php
				endforeach;
			endif;
		endif;
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'news-kit-elementor-addons' ),
			'<strong>' . esc_html__( 'News Kit Elementor Addons', 'news-kit-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'news-kit-elementor-addons' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		echo wp_kses_post( sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'news-kit-elementor-addons' ),
			'<strong>' . esc_html__( 'News Kit Elementor Addons', 'news-kit-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'news-kit-elementor-addons' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		echo wp_kses_post( sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ) );
	}

	/**
	 * Add widget categories
	 *
	 * Groups the similar types of widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function add_elementor_widget_categories( $elements_manager ) {
		$current_post_id = get_the_ID();
        $builder_type = get_post_meta( $current_post_id, 'builder_type', true );

		$elements_manager->add_category(
			'nekit-widgets-group',
			[
				'title' => esc_html__( 'News Elementor Widgets', 'news-kit-elementor-addons' ),
				'icon' 	=> 'fa fa-plug'
			]
		);
		$elements_manager->add_category(
			'nekit-post-layouts-widgets-group',
			[
				'title' => esc_html__( 'News Elementor Posts Layouts', 'news-kit-elementor-addons' ),
				'icon' 	=> 'fa fa-plug'
			]
		);
		if( $builder_type == 'archive-builder' ) {
			$elements_manager->add_category(
				'nekit-archive-templates-widgets-group',
				[
					'title' => esc_html__( 'News Elementor Archive', 'news-kit-elementor-addons' ),
					'icon'	=> 'fa fa-plug'
				]
			);
		}
		if( $builder_type == 'single-builder' ) {
			$elements_manager->add_category(
				'nekit-single-templates-widgets-group',
				[
					'title'	=> esc_html__( 'News Elementor Single', 'news-kit-elementor-addons' ),
					'icon'	=> 'fa fa-plug'
				]
			);
		}
	}

	/**
	 * Add premium widget categories
	 *
	 * Groups the similar types of widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function register_premium_widgets($config) {
		$config['promotionWidgets'] = apply_filters( 'nekit_promotion_widgets_filter', [
			[
				'name'	=> 'breadcrumb-pro',
				'title' => esc_html__( 'Breadcrumb', 'news-kit-elementor-addons' ),
				'icon'	=> 'nekit-icon-pro icon-nekit-breadcrumb premium-widget',
				'categories' => '["nekit-single-templates-widgets-group","nekit-widgets-group"]'
			],
			[
				'name'	=> 'nekit-video-playlist-pro',
				'title' => esc_html__( 'Video Playlist', 'news-kit-elementor-addons' ),
				'icon'	=> 'nekit-icon-pro icon-nekit-video-playlist premium-widget',
				'categories' => '["nekit-widgets-group"]'
			],
			[
				'name'	=> 'nekit-tags-cloud-animation-pro',
				'title' => esc_html__( 'Tags Cloud Animation', 'news-kit-elementor-addons' ),
				'icon'	=> 'nekit-icon-pro icon-nekit-tags-cloud-animation premium-widget',
				'categories' => '["nekit-widgets-group"]'
			],
			[
				'name'	=> 'nekit-single-related-post-pro',
				'title' => esc_html__( 'Single Related Post', 'news-kit-elementor-addons' ),
				'icon'	=> 'nekit-icon-pro icon-nekit-grid-one premium-widget',
				'categories' => '["nekit-single-templates-widgets-group","nekit-widgets-group"]'
			]
		], $config);
		return $config;
	}

	/**
	 * Posts ajax function with search query
	 *
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function live_search_widget_posts_content() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnonce' );
		$search_key = isset( $_POST['search_key'] ) ? sanitize_text_field( wp_unslash( $_POST['search_key'] ) ): '';
		$settings = isset( $_POST['dataSettings'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['dataSettings'] ) ), true ): '';
		$query_vars = [
			'post_type'	=> 'post',
			'post_status'	=> 'publish',
			'posts_per_page'=> absint( $settings['count'] ),
			's'	=> esc_html($search_key)
		];
		$n_posts = new \WP_Query($query_vars);
		$res['loaded'] = false;
		if ( $n_posts->have_posts() ) :
			ob_start();
			echo '<div class="search-results-wrap">';
				echo '<span class="close-modal"><i class="fas fa-times"></i></span>';
				echo '<div class="search-posts-wrap">';
				$res['loaded'] = true;
					while ( $n_posts->have_posts() ) :
						$n_posts->the_post();
						?>
							<div class="article-item">
								<?php if( $settings['thumbnail_option'] == 'yes' ) : ?>
									<figure class="post-thumb-wrap <?php if( ! has_post_thumbnail() ){ echo esc_attr( 'no-feat-img' ); } ?>">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="<?php echo esc_attr( $settings['link_target'] ); ?>">
											<?php
												if( has_post_thumbnail() ) :
													the_post_thumbnail( $settings['image_size'], array(
														'title' => the_title_attribute(array(
															'echo'  => false
														))
													));
												endif;
											?>
										</a>
									</figure>
								<?php endif; ?>
								<div class="post-element">
									<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="<?php echo esc_attr( $settings['link_target'] ); ?>"><?php the_title(); ?></a></h2>
									<?php
										if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
											'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
											'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
												'value' =>  'fas fa-calendar',
												'library'   =>  'fa-solid'
											],
											'url'	=>	'yes'
										]));
									?>
								</div>
							</div>
						<?php
					endwhile;
				echo '</div><!-- .search-posts-wrap -->';

				if( $settings['button_option'] == 'yes' ) :
				?>
						<a class="view-all-search-button" href="<?php echo esc_url( get_search_link( esc_html($search_key) ) ); ?>" target="<?php echo esc_attr( $settings['link_target'] ); ?>"><?php echo esc_html( $settings['button_label'] ); ?></a>
				<?php
				endif;
			echo '</div><!-- .search-results-wrap -->';
			$res['posts'] = ob_get_clean();
		else :
			ob_start();
				?>
				<div class="search-results-wrap no-posts-found">
					<h2 class="no-posts-found-title"><?php echo esc_html( $settings['no_results_title'] ); ?></h2>
					<p class="no-posts-found-description"><?php echo esc_textarea( $settings['no_results_description'] ); ?></p>
				</div><!-- .search-results-wrap -->
				<?php
			$res['posts'] = ob_get_clean();
		endif;
		wp_send_json_success( $res );
		wp_die();
	}

	/**
	 * Filter and Enqueue typography fonts
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function get_fonts_url() {
		$filter = 'nekit_fonts_url_combine_filter';
		$action = function($filter,$id) {
			return apply_filters(
				$filter,
				$id
			);
		};
		$font1 = "Rubik:wght@100,300,400,500,600,700";
		$font2 = "Lexend:wght@100,300,400,500,600,700";
		$font3 = "Jost:wght@100,300,400,500,600,700";
		$get_fonts = apply_filters( 'nekit_get_fonts_toparse', [$font1, $font2, $font3] );
		$font_weight_array = array();
		foreach ( $get_fonts as $fonts ) {
			$each_font = explode( ':', $fonts );
			if ( ! isset ( $font_weight_array[$each_font[0]] ) ) {
				$font_weight_array[$each_font[0]][] = $each_font[1];
			} else {
				if ( ! in_array( $each_font[1], $font_weight_array[$each_font[0]] ) ) {
					$font_weight_array[$each_font[0]][] = $each_font[1];
				}
			}
		}
		$final_font_array = array();
		foreach ( $font_weight_array as $font => $font_weight ) {
			$each_font_string = $font.':'.implode( ',', $font_weight );
			$final_font_array[] = $each_font_string;
		}

		$final_font_string = implode( '|', $final_font_array );
		$google_fonts_url = '';
		$subsets   = 'cyrillic,cyrillic-ext';
		if ( $final_font_string ) {
			$query_args = array(
				'family' => urlencode( $final_font_string ),
				'subset' => urlencode( $subsets )
			);
			$google_fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
		return $google_fonts_url;
	}
	
	/**
	 * News Filter Ajax Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function news_filter_widget_tab_content_change() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$options = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$category_id = isset( $_POST['category'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['category'] ) ), true ) : '';
		$widget_count = isset( $_POST['widgetCount'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['widgetCount'] ) ), true ) : '';
		$widgetId = isset( $_POST['widgetId'] ) ? sanitize_text_field( wp_unslash( $_POST['widgetId'] ) ) : '';
		$post_order = explode( "-", $options['post_order'] );
		$filter_by = is_null( $options['filter_by'] ) ? 'categories' : $options['filter_by'];
		$filter_args = [
			'post_type'	=>	'post',
			'posts_per_page'	=>	$options['post_count'],
			'post_status'	=>	'publish',
			'order'	=>	$post_order[1],
			'orderby'	=>	$post_order[0]
		];
		if( $options['post_offset'] > 0 ) $filter_args['offset'] = $options['post_offset'];
		if( $filter_by == 'categories' ) $filter_args['cat'] = $category_id;
		if( $filter_by == 'tags' ) $filter_args['tag__in'] = $category_id;
		if( $filter_by == 'authors' ) $filter_args['author'] = $category_id;
		if( $category_id == 'news-elementor-filter-all' ) :
			$filter_args['cat'] = $options['post_categories'];
			$filter_args['tag__in'] = $options['post_tags'];
			$filter_args['author'] = $options['post_authors'];
			$filter_args['orderby'] = 'rand';
		endif;
		if( $options['post_hide_post_without_thumbnail'] === 'yes' ) :
			$filter_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		endif;
		if( $options['post_to_exclude'] ) $filter_args['post__not_in'] = $options['post_to_exclude'];
		$post_query = new \WP_Query( $filter_args );
		if( $post_query->have_posts() ) :
			$total_post =  $post_query->post_count;
			$tab_class = ( $category_id == 'news-elementor-filter-all' ) ? 'all' : $category_id;
			echo '<div class="news-filter-post-wrap tab-'. esc_attr( $tab_class ) .' isActive">';
				echo '<div class="tab-content">';
					while( $post_query->have_posts() ) : $post_query->the_post();
						$current_post =  $post_query->current_post;
						if( $widget_count == 'one' ) :
							if( $current_post % 6 === 0 ) echo '<div class="featured-post">';
								if( $current_post % 6 === 2 ) echo '<div class="trailing-post">';
						endif;
						if( $widget_count == 'two' ) :
							if( $current_post === 0 ) echo '<div class="primary-row">';
								if( $current_post === 5 ) echo '<div class="secondary-row trailing-post">';
									if( $current_post === 0 ) echo '<div class="featured-post">';
										if( $current_post === 1 ) echo '<div class="trailing-post">';
						endif;
						if( $widget_count == 'three' ) :
							if( $current_post % 7 === 0 && $current_post === 0 ) echo '<div class="primary-row"><div class="featured-post">';
								if( $current_post % 7 === 1 ) echo '<div class="trailing-post">';
						endif;
						if( $widget_count == 'four' ) :
							if( $current_post % 10 === 0 ) echo '<div class="primary-row"><div class="featured-post">';
								if( $current_post % 10 === 4 ) echo '<div class="secondary-row">';
									if( $current_post % 10 === 1 ) echo '<div class="trailing-post">';
						endif;

							if( $widget_count == 'four' ) echo '<div class="filter-inner-wrap">';
								?>
									<article class="filter-item <?php if( ! has_post_thumbnail() ){ echo esc_attr('no-feat-img');} ?>">
										<div class="nekit-item-box-wrap">
											<?php 
												if( ( $widget_count == 'three' && $current_post % 7 != 0 ) || $widget_count == 'one' || $widget_count == 'two' || $widget_count == 'four') :
														if( $options['show_post_thumbnail'] == 'yes' ) :
														?>
															<figure class="post-thumb-wrap">
																<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($options['imageClass']); ?>>
																	<div class="post-thumb-parent<?php if( $options['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																		<?php 
																			if( has_post_thumbnail() ) {
																				the_post_thumbnail($options['image_size'], array(
																					'title' => the_title_attribute(array(
																						'echo'  => false
																					))
																				));
																			}
																		?>
																	</div>
																</a>
																<?php
																	if( $options['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
																?>
															</figure>
														<?php endif; 
													endif;?>
												<div class="post-element">
													<div class="post-element-inner">
														<?php
															if( ! isset( $options['posts_elements_sorting'] ) ) $options['posts_elements_sorting'] = ['post-title', 'post-meta', 'post-excerpt', 'post-button'];
															foreach( $options['posts_elements_sorting'] as $posts_element ) :
																switch( $posts_element ) {
																	case 'post-title' : 
																						if( $options['show_post_title'] == 'yes' ) :
																							?>
																								<h2 <?php echo wp_kses_post($options['titleClass'] ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																							<?php
																						endif;
																					break;
																	case 'post-meta' : ?>
																						<div class="post-meta">
																							<?php
																								if( $options['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																									'base'	=> isset( $options['post_author_icon_position'] ) ? $options['post_author_icon_position'] : 'prefix',
																									'icon'	=> isset( $options['post_author_icon'] ) ? $options['post_author_icon']: [
																										'value' =>  'far fa-user-circle',
																										'library'   =>  'fa-regular'
																									],
																									'url'	=>	'yes'
																								]));
																								if( $options['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																									'base'  =>  isset( $options['post_date_icon_position'] ) ? $options['post_date_icon_position'] : 'prefix',
																									'icon'  =>  isset( $options['post_date_icon'] ) ? $options['post_date_icon'] : [
																										'value' =>  'fas fa-calendar',
																										'library'   =>  'fa-solid'
																									],
																									'url'	=>	'yes'
																								]));
																								if( $options['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																									'base'  =>  isset( $options['post_comments_icon_position'] ) ? $options['post_comments_icon_position'] : 'prefix',
																									'icon'  =>  isset( $options['post_comments_icon'] ) ? $options['post_comments_icon']: [
																										'value' =>  'far fa-comment',
																										'library'   =>  'fa-regular'
																									]
																								]));
																							?>
																						</div>
																						<?php
																					break;
																	case 'post-excerpt' : 
																						if( $options['show_post_excerpt'] == 'yes' ) :
																							nekit_get_post_excerpt_output($options['show_post_excerpt_length'] ? $options['show_post_excerpt_length']: 0);
																							endif;
																						break;
																	case 'post-button' : if( $options['show_post_button'] == 'yes' ) : ?>
																							<a class="post-link-button" href="<?php the_permalink() ?>"><?php echo esc_html( $options['post_button_text'] ); ?></a>
																						<?php
																						endif;
																						break;
																}
															endforeach;
														?>
													</div><!-- .post-element-inner -->
												</div>
											<?php 
												if( $widget_count == 'three' && $current_post % 7 == 0 ) :
													if( $options['show_post_thumbnail'] == 'yes' ) :
													?>
														<figure class="post-thumb-wrap">
															<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($options['imageClass']); ?>>
																<div class="post-thumb-parent<?php if( $options['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																	<?php 
																		if( has_post_thumbnail() ) {
																			the_post_thumbnail($options['image_size'], array(
																				'title' => the_title_attribute(array(
																					'echo'  => false
																				))
																			));
																		}
																	?>
																</div>
															</a>
															<?php
																if( $options['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
															?>
														</figure>
													<?php endif; 
												endif;?>
										</div>
									</article>
								<?php 
							if( $widget_count == 'four' ) echo '</div><!-- .filter-inner-wrap -->';

						if( $widget_count == 'one' ) :
							if( $current_post % 6 == 1 )  {
								echo '</div><!-- .featured-post -->';
							} else if( $current_post % 6 === 5 || $total_post == $current_post + 1 ) {
								echo '</div><!-- .trailing-post -->';
							}
						endif;
						if( $widget_count == 'two' ) :
							if( $current_post === 0 ) {
								echo '</div><!-- .featured-post -->';
								if( $total_post === $current_post + 1 ) echo '</div><!-- .primary-row -->';
							} else if( $current_post === 4 ) {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							} else if( $current_post < 4 && $total_post === $current_post + 1 ) {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							} else if( $current_post > 4 && $total_post === $current_post + 1 ) {
								echo '</div><!-- .secondary-row -->';
							} else if( $total_post === $current_post + 1 ) {
								echo '</div><!-- *complete-row -->';
							}
						endif;
						if( $widget_count == 'three' ) :
							if( $current_post % 7 === 0 )  {
								echo '</div><!-- .featured-post -->';
								if( $total_post == $current_post + 1 ) echo '</div><!-- .primary-row -->';
							} else if( $current_post  % 7 === 6 )  {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							} else if( $current_post % 7 > 0 && $total_post == $current_post + 1 ) {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							}
						endif;
						if( $widget_count == 'four' ) :
							if( $current_post % 10 === 0 ) {
								echo '</div><!-- .featured-post -->';
								if( $total_post === $current_post + 1 ) echo '</div><!-- .primary/secondary-row -->';
							} else if( $current_post % 10 === 3 ) {
								echo '</div><!-- .trailing-post --></div><!-- .primary-row -->';
							} else if( $current_post % 10 > 0 && $current_post % 10 < 3 && $total_post === $current_post + 1 ) {
								echo '</div><!-- .trailing-post --></div><!-- .primary-row -->';
							} else if( $current_post % 10 === 9 ) {
								echo '</div><!-- .secondary-row -->';
							} else if( $current_post % 10 > 3 && $current_post % 10 <= 9 && $total_post === $current_post + 1 ) {
								echo '</div><!-- .secondary-row -->';
							} else if( $total_post === $current_post + 1 ) {
								if( $total_post === $current_post + 1 ) echo '</div><!-- .primary/secondary-row -->';
							}
						endif;
					endwhile;
					wp_reset_postdata();
				echo '</div><!-- .tab-content -->';
			echo '</div> <!--news-filter-post-wrap-->';
		endif;
		wp_die();
	}

	// add custom styles for plugin general styles
	function add_general_css() {
		$css = '';
		$nav_menus = wp_get_nav_menus(); // get all available nav menus
		if( $nav_menus ) :
			foreach( $nav_menus as $nav_menu ) :
				if( isset( $nav_menu->slug ) && $nav_menu->slug ) :
					$menu_items = wp_get_nav_menu_items($nav_menu->slug); // get all nav menu items
						foreach( $menu_items as $menu_item ) :
							if( $menu_item->menu_item_parent == 0 ) {
								$nekit_menu_icon_option = get_post_meta( $menu_item->ID, 'nekit_menu_icon_option', true );
								if( $nekit_menu_icon_option && $nekit_menu_icon_option == 'show' ) {
									$nekit_menu_icon_size = get_post_meta( $menu_item->ID, 'nekit_menu_icon_size', true );
									// $nekit_menu_icon_size_tablet = get_post_meta( $menu_item->ID, 'nekit_menu_icon_size_tablet', true );
									// $nekit_menu_icon_size_mobile = get_post_meta( $menu_item->ID, 'nekit_menu_icon_size_mobile', true );
									$nekit_menu_icon_distance = get_post_meta( $menu_item->ID, 'nekit_menu_icon_distance', true );
									// $nekit_menu_icon_distance_tablet = get_post_meta( $menu_item->ID, 'nekit_menu_icon_distance_tablet', true );
									// $nekit_menu_icon_distance_mobile = get_post_meta( $menu_item->ID, 'nekit_menu_icon_distance_mobile', true );
									$nekit_menu_icon_color = get_post_meta( $menu_item->ID, 'nekit_menu_icon_color', true );
									
									$css .= ' #menu-item-' .$menu_item->ID. ' .nekit-menu-context { font-size: ' .$nekit_menu_icon_size. 'px; color: ' .$nekit_menu_icon_color. ' } ';
									$css .= ' #menu-item-' .$menu_item->ID. '.nekit-icon-position--before .nekit-menu-context { margin-right: ' .absint( $nekit_menu_icon_distance ). 'px;  } ';
									$css .= ' #menu-item-' .$menu_item->ID. '.nekit-icon-position--after .nekit-menu-context { margin-left: ' .absint( $nekit_menu_icon_distance ). 'px;  } ';

								}
								$nekit_custom_width = get_post_meta( $menu_item->ID, 'nekit_custom_width', true );
								 $nekit_custom_width_tablet = get_post_meta( $menu_item->ID, 'nekit_custom_width_tablet', true );
								 $nekit_custom_width_mobile = get_post_meta( $menu_item->ID, 'nekit_custom_width_mobile', true );
								// mega menu custom width
								$css .= ' #menu-item-' .$menu_item->ID. ' .nekit-mega-menu-container.nekit-megamenu-custom-width { width: ' .absint( $nekit_custom_width ). 'px;  } ';

								$css .= ' @media (max-width: 768px) { #menu-item-' .$menu_item->ID. ' .nekit-mega-menu-container.nekit-megamenu-custom-width { width: ' .absint( $nekit_custom_width_tablet ). 'px;  } }';

								$css .= ' @media (max-width: 480px) { #menu-item-' .$menu_item->ID. ' .nekit-mega-menu-container.nekit-megamenu-custom-width { width: ' .absint( $nekit_custom_width_mobile ). 'px;  } }';
							}
						endforeach;
				endif;
			endforeach;
		endif;
		return apply_filters( 'nekit_add_general_css_filter', wp_strip_all_tags($css) );
	}
	
	/**
	 * Archive Posts Ajax Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function archive_posts_ajax_load_more() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$options = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$pagination = isset( $_POST['pagination'] ) ? json_decode( intval( wp_unslash( $_POST['pagination'] ) ), true ) : '';
		$post_args = [
			'post_type'	=>	'post',
			'post_status'	=>	'publish',
			'paged'	=>	$pagination
		];
		if( $options['check_archive'] == 'category' ) $post_args['cat'] = $options['queried_object_id'];
		if( $options['check_archive'] == 'tag' ) $post_args['tag_id'] = $options['queried_object_id'];
		if( $options['check_archive'] == 'author' ) $post_args['author'] = $options['queried_object_id'];
		if( $options['check_archive'] == 'search' ) $post_args['s'] = $options['queried_object_id'];
		if( $options['check_archive'] == 'date' ) $post_args['date_query'] = $options['queried_object_id'];
		$post_query = new \WP_Query( $post_args );
		if( $post_query->have_posts() ) :
			while( $post_query->have_posts() ) : $post_query->the_post();
				?>
				<article <?php post_class( 'post-item' ); ?>>
					<div class="nekit-item-box-wrap">
						<figure class="post-thumb">
							<?php
								if( has_post_thumbnail() ) :
							?>
									<a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $options['link_target'] ); ?>" <?php echo wp_kses_post( $options['imageClass'] ); ?>>
										<div class="post-thumb-parent<?php if( $options['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
											<?php
												the_post_thumbnail( '', [
													'title' => the_title_attribute(array(
														'echo'  => false
													))
												]);
											?>
										</div>
									</a>
								<?php
									if( $options['show_post_categories'] == 'yes' ) :
										if( $options['widget_layouts'] != 'three' ) nekit_get_post_categories( get_the_ID(), 2 );
									endif;
								endif;
							?>
						</figure>
						<div class="post-element">
							<?php
								if( $options['show_post_categories'] == 'yes' ) :
									if( $options['widget_layouts'] == 'three' ) nekit_get_post_categories( get_the_ID(), 2 );
								endif;
								if( $options['show_post_title'] == 'yes' ) the_title('<' .esc_html( $options['show_post_title'] ). ' ' . wp_kses_post($options['titleClass']) . '><a href="' .esc_url( get_the_permalink() ). '" target="' .esc_attr( $options['link_target'] ). '">','</a></' .esc_html( $options['title_html_tag'] ). '>');
							?>
							<div class="post-meta">
								<?php
									if( $options['show_post_author'] == 'yes' )
										echo wp_kses_post(nekit_get_posts_author([
											'base'	=> isset( $options['post_author_icon_position'] ) ? $options['post_author_icon_position'] : 'prefix',
											'icon'	=> isset( $options['post_author_icon'] ) ? $options['post_author_icon']: [
												'value' =>  'far fa-user-circle',
												'library'   =>  'fa-regular'
											],
											'url'   =>  'yes'
										]));
									if( $options['show_post_date'] == 'yes' ) 
										echo wp_kses_post(nekit_get_posts_date([
											'base'  =>  isset( $options['post_date_icon_position'] ) ? $options['post_date_icon_position'] : 'prefix',
											'icon'  =>  isset( $options['post_date_icon'] ) ? $options['post_date_icon'] : [
												'value' =>  'fas fa-calendar',
												'library'   =>  'fa-solid'
											],
											'url'   =>  'yes'
										]));
									if( $options['show_post_comments'] == 'yes' )
										echo wp_kses_post(nekit_get_posts_comments([
											'base'  =>  isset( $options['post_comments_icon_position'] ) ? $options['post_comments_icon_position'] : 'prefix',
											'icon'  =>  isset( $options['post_comments_icon'] ) ? $options['post_comments_icon']: [
												'value' =>  'far fa-comment',
												'library'   =>  'fa-regular'
											]
										]));
								?>
							</div>
							<?php
								if( $options['show_post_excerpt'] == 'yes' ) :
									nekit_get_post_excerpt_output($settings['post_excerpt_length'] ? $settings['post_excerpt_length']: 0);
								endif;
								
								if( $options['show_post_button'] == 'yes' ) : ?>
									<a class="post-link-button" href="<?php the_permalink() ?>" target="<?php echo esc_attr( $options['link_target'] ); ?>">
										<?php echo esc_html( $options['post_button_text'] ); ?>
										<?php
											echo wp_kses_post( apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
												'value' => 'fas fa-angle-right',
												'library'   =>  'fa-solid'
											]) );
										?>
									</a>
								<?php
								endif;
							?>
						</div><!-- .post-element -->
					</div><!-- .nekit-item-box-wrap -->	
				</article>
				<?php
			endwhile;
		endif;
		wp_die();
	}

	/**
	 * Grid widget AJAX Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function grid_widget_ajax_content() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$response['loaded'] = false;
		$response['html'] = '';
		$settings = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$paged = isset( $_POST['paged'] ) ? intval( wp_unslash( $_POST['paged'] ) ) : 2;
		$prefix = 'post';
		$post_order = $settings[$prefix . '_order'];
		$post_order_split = explode( '-', $post_order );
		$post_count = $settings[$prefix . '_count'];
		$post_categories = $settings[$prefix . '_categories'];
		$post_tags = $settings[$prefix . '_tags'];
		$post_authors = $settings[$prefix . '_authors'];
		$posts_args = [
			'post_type' => 'post',
			'orderby'	=> $post_order_split[0],
			'order'	=> $post_order_split[1],
			'posts_per_page'	=> absint( $post_count )
		];
		if( $settings[$prefix . '_offset'] > 0 ) $posts_args['offset'] = absint( $settings[$prefix . '_offset'] );
		if($post_categories) $posts_args['cat'] = implode( ',', $post_categories );
		if($post_authors) $posts_args['author'] = implode( ',', $post_authors );
		if($post_tags) $posts_args['tag__in'] = $post_tags;
		if( $settings[$prefix . '_hide_post_without_thumbnail'] === 'yes' ) {
			$posts_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}
		if( $settings[$prefix . '_to_exclude'] ) $posts_args['post__not_in'] = $settings[$prefix . '_to_exclude'];
		if( isset( $settings[$prefix . '_to_include'] ) ) :
			if( $settings[$prefix . '_to_include'] ) $posts_args['post__in'] = $settings[$prefix . '_to_include'];
		endif;
		$posts_args['paged'] = absint($paged);
		$posts_args =  apply_filters( 'nekit_widgets_query_args_filter', $posts_args );
		$post_query = new \WP_Query($posts_args);
		if( $post_query->have_posts() ) :
			ob_start();
				$imageClass = '';
				if ( $settings['image_hover_animation'] ) {
					$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
				}
				$titleClass = 'post-title';
				if( $settings['post_title_animation_choose'] == 'elementor' ) {
					if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
				} else {
					if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
				}
				while( $post_query->have_posts() ) : $post_query->the_post();
					if( $settings['widget_count'] == 'three' ) {
						?>
							<article class="post-item grid-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?> paged-<?php echo esc_attr($paged); ?>">
								<div class="nekit-item-box-wrap">
									<?php if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
										<figure class="post-thumb-wrap">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
												<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
													<?php if( has_post_thumbnail() ) { 
															the_post_thumbnail($settings['image_size'], array(
																'title' => the_title_attribute(array(
																	'echo'  => false
																))
															));
														}
													?>
												</div>
											</a>
											<div class="post-element">
												<div class="post-element-inner">
													<?php
														if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
														foreach( $settings['posts_elements_sorting'] as $posts_element ) :
															switch( $posts_element ) {
																case 'post-title' : 
																					if( $settings['show_post_title'] == 'yes' ) :
																						?>
																							<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																						<?php
																					endif;
																				break;
																case 'post-meta' : ?>
																					<div class="post-meta">
																						<?php
																							if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																								'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																								'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																									'value' =>  'far fa-user-circle',
																									'library'   =>  'fa-regular'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																								'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																									'value' =>  'fas fa-calendar',
																									'library'   =>  'fa-solid'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																								'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																									'value' =>  'far fa-comment',
																									'library'   =>  'fa-regular'
																								]
																							]));
																						?>
																					</div>
																					<?php
																				break;
																case 'post-excerpt' : 
																					if( $settings['show_post_excerpt'] == 'yes' ) : 
																						nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																					endif;
																					break;
																case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																						<a class="post-link-button" href="<?php the_permalink() ?>">
																							<?php echo esc_html( $settings['post_button_text'] ); ?>
																							<?php
																								echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																									'value' => 'fas fa-angle-right',
																									'library'   =>  'fa-solid'
																								]));
																							?>
																						</a>
																					<?php
																					endif;
																					break;
															}
														endforeach;
													?>
												</div><!-- .post-element-inner -->
											</div>
										</figure>
									<?php endif; ?>
								</div>
							</article>
						<?php
					} else {
						?>
							<article class="post-item grid-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?> paged-<?php echo esc_attr($paged); ?>">
								<div class="nekit-item-box-wrap">
									<?php if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
										<figure class="post-thumb-wrap">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
												<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
													<?php if( has_post_thumbnail() ) { 
															the_post_thumbnail($settings['image_size'], array(
																'title' => the_title_attribute(array(
																	'echo'  => false
																))
															));
														}
													?>
												</div>
											</a>
											<?php if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] != 'two' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
										</figure>
									<?php endif; ?>
									<div class="post-element">
										<?php
											if( $settings['show_post_numbering'] == 'yes' ) :
										?>
												<div class="post-count"><?php echo absint( $post_query->current_post+1 ); ?></div>
										<?php
											endif;
										?>
											<div class="post-element-inner">
												<?php
													if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] == 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
													foreach( $settings['posts_elements_sorting'] as $posts_element ) :
														switch( $posts_element ) {
															case 'post-title' : 
																				if( $settings['show_post_title'] == 'yes' ) :
																					?>
																						<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																					<?php
																				endif;
																			break;
															case 'post-meta' : ?>
																				<div class="post-meta">
																					<?php
																						if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																							'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																							'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																								'value' =>  'far fa-user-circle',
																								'library'   =>  'fa-regular'
																							],
																							'url'	=>	'yes'
																						]));
																						if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																							'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																							'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																								'value' =>  'fas fa-calendar',
																								'library'   =>  'fa-solid'
																							],
																							'url'	=>	'yes'
																						]));
																						if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																							'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																							'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																								'value' =>  'far fa-comment',
																								'library'   =>  'fa-regular'
																							]
																						]));
																					?>
																				</div>
																				<?php
																			break;
															case 'post-excerpt' : 
																				if( $settings['show_post_excerpt'] == 'yes' ) : 
																					nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																				endif;
																				break;
															case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																					<a class="post-link-button" href="<?php the_permalink() ?>">
																						<?php echo esc_html( $settings['post_button_text'] ); ?>
																						<?php
																							echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																								'value' => 'fas fa-angle-right',
																								'library'   =>  'fa-solid'
																							]));
																						?>
																					</a>
																				<?php
																				endif;
																				break;
														}
													endforeach;
												?>
											</div><!-- .post-element-inner -->
									</div>
								</div>
							</article>
						<?php
					}
				endwhile;
				wp_reset_postdata();
			$response['loaded'] = true;
			$response['html'] = ob_get_clean();
		endif;
		wp_send_json_success(wp_json_encode($response));
		wp_die();
	}

	/**
	 * List widget AJAX Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function list_widget_ajax_content() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$response['loaded'] = false;
		$response['html'] = '';
		$settings = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$paged = isset( $_POST['paged'] ) ? intval( wp_unslash( $_POST['paged'] ) ): 2;
		$prefix = 'post';
		$post_order = $settings[$prefix . '_order'];
		$post_order_split = explode( '-', $post_order );
		$post_count = $settings[$prefix . '_count'];
		$post_categories = $settings[$prefix . '_categories'];
		$post_tags = $settings[$prefix . '_tags'];
		$post_authors = $settings[$prefix . '_authors'];
		$posts_args = [
			'post_type' => 'post',
			'orderby'	=> $post_order_split[0],
			'order'	=> $post_order_split[1],
			'posts_per_page'	=> absint( $post_count )
		];
		if( $settings[$prefix . '_offset'] > 0 ) $posts_args['offset'] = absint( $settings[$prefix . '_offset'] );
		if($post_categories) $posts_args['cat'] = implode( ',', $post_categories );
		if($post_authors) $posts_args['author'] = implode( ',', $post_authors );
		if($post_tags) $posts_args['tag__in'] = $post_tags;
		if( $settings[$prefix . '_hide_post_without_thumbnail'] === 'yes' ) {
			$posts_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}
		if( $settings[$prefix . '_to_exclude'] ) $posts_args['post__not_in'] = $settings[$prefix . '_to_exclude'];
		if( isset( $settings[$prefix . '_to_include'] ) ) :
			if( $settings[$prefix . '_to_include'] ) $posts_args['post__in'] = $settings[$prefix . '_to_include'];
		endif;
		$posts_args['paged'] = absint($paged);
		$posts_args =  apply_filters( 'nekit_widgets_query_args_filter', $posts_args );
		$post_query = new \WP_Query($posts_args);
		if( $post_query->have_posts() ) :
			ob_start();
				$imageClass = '';
				if ( $settings['image_hover_animation'] ) {
					$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
				}
				$titleClass = 'post-title';
				if( $settings['post_title_animation_choose'] == 'elementor' ) {
					if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
				} else {
					if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
				}
				while( $post_query->have_posts() ) : $post_query->the_post();
					if( $settings['widget_count'] == 'three' ) {
						?>
							<article class="post-item list-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?> paged-<?php echo esc_attr($paged); ?>">
								<div class="nekit-item-box-wrap">
								<?php
									if( $settings['show_post_title'] == 'yes' ) :
										?>
											<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<?php
									endif;
									?>
									<div class="blog_inner_wrapper">
									<?php
										if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
											<figure class="post-thumb-wrap">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
													<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
														<?php if( has_post_thumbnail() ) { 
																the_post_thumbnail($settings['image_size'], array(
																	'title' => the_title_attribute(array(
																		'echo'  => false
																	))
																));
															}
														?>
													</div>
												</a>
												<?php if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
											</figure>
										<?php endif; ?>
										<div class="post-element">
											<?php
												foreach( $settings['posts_elements_sorting'] as $posts_element ) :
													switch( $posts_element ) {
														case 'post-meta' : ?>
																			<div class="post-meta">
																				<?php
																					if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																						'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																						'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																							'value' =>  'far fa-user-circle',
																							'library'   =>  'fa-regular'
																						],
																						'url'	=>	'yes'
																					]));
																					if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																						'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																						'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																							'value' =>  'fas fa-calendar',
																							'library'   =>  'fa-solid'
																						],
																						'url'	=>	'yes'
																					]));
																					if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																						'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																						'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																							'value' =>  'far fa-comment',
																							'library'   =>  'fa-regular'
																						]
																					]));
																				?>
																			</div>
																			<?php
																		break;
														case 'post-excerpt' : 
																			if( $settings['show_post_excerpt'] == 'yes' ) : 
																				nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																			endif;
																			break;
														case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																				<a class="post-link-button" href="<?php the_permalink() ?>">
																					<?php echo esc_html( $settings['post_button_text'] ); ?>
																					<?php
																						echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																							'value' => 'fas fa-angle-right',
																							'library'   =>  'fa-solid'
																						]));
																					?>
																				</a>
																			<?php
																			endif;
																			break;
													}
												endforeach;
											?>
										</div>
									</div>
								</div>
							</article>
						<?php
					} else {
						?>
							<article class="post-item list-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?> paged-<?php echo esc_attr($paged); ?>">
								<div class="nekit-item-box-wrap">
									<?php if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
										<figure class="post-thumb-wrap">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
												<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
													<?php if( has_post_thumbnail() ) { 
															the_post_thumbnail($settings['image_size'], array(
																'title' => the_title_attribute(array(
																	'echo'  => false
																))
															));
														}
													?>
												</div>
											</a>
											<?php if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
										</figure>
									<?php endif; ?>
									<div class="post-element">
										<?php
											foreach( $settings['posts_elements_sorting'] as $posts_element ) :
												switch( $posts_element ) {
													case 'post-title' : 
																		if( $settings['show_post_title'] == 'yes' ) :
																			?>
																				<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																			<?php
																		endif;
																	break;
													case 'post-meta' : ?>
																		<div class="post-meta">
																			<?php
																				if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																					'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																					'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																						'value' =>  'far fa-user-circle',
																						'library'   =>  'fa-regular'
																					],
																					'url'	=>	'yes'
																				]));
																				if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																					'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																					'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																						'value' =>  'fas fa-calendar',
																						'library'   =>  'fa-solid'
																					],
																					'url'	=>	'yes'
																				]));
																				if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																					'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																					'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																						'value' =>  'far fa-comment',
																						'library'   =>  'fa-regular'
																					]
																				]));
																			?>
																		</div>
																		<?php
																	break;
													case 'post-excerpt' : 
																		if( $settings['show_post_excerpt'] == 'yes' ) : 
																			nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																		endif;
																		break;
													case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																			<a class="post-link-button" href="<?php the_permalink() ?>">
																				<?php echo esc_html( $settings['post_button_text'] ); ?>
																				<?php
																					echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																						'value' => 'fas fa-angle-right',
																						'library'   =>  'fa-solid'
																					]));
																				?>
																			</a>
																		<?php
																		endif;
																		break;
												}
											endforeach;
										?>
									</div>
								</div>
							</article>
						<?php
					}
				endwhile;
				wp_reset_postdata();
			$response['loaded'] = true;
			$response['html'] = ob_get_clean();
		endif;
		wp_send_json_success(wp_json_encode($response));
		wp_die();
	}

	/**
	 * Block widget AJAX Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function block_widget_ajax_content() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$response['loaded'] = false;
		$response['html'] = '';
		$settings = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$paged = isset( $_POST['paged'] ) ? intval( wp_unslash( $_POST['paged'] ) ) : 2;
		$prefix = 'post';
		$post_order = $settings[$prefix . '_order'];
		$post_order_split = explode( '-', $post_order );
		$post_count = $settings[$prefix . '_count'];
		$post_categories = $settings[$prefix . '_categories'];
		$post_tags = $settings[$prefix . '_tags'];
		$post_authors = $settings[$prefix . '_authors'];
		$posts_args = [
			'post_type' => 'post',
			'orderby'	=> $post_order_split[0],
			'order'	=> $post_order_split[1],
			'posts_per_page'	=> absint( $post_count )
		];
		if( $settings[$prefix . '_offset'] > 0 ) $posts_args['offset'] = absint( $settings[$prefix . '_offset'] );
		if($post_categories) $posts_args['cat'] = implode( ',', $post_categories );
		if($post_authors) $posts_args['author'] = implode( ',', $post_authors );
		if($post_tags) $posts_args['tag__in'] = $post_tags;
		if( $settings[$prefix . '_hide_post_without_thumbnail'] === 'yes' ) {
			$posts_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}
		if( $settings[$prefix . '_to_exclude'] ) $posts_args['post__not_in'] = $settings[$prefix . '_to_exclude'];
		if( isset( $settings[$prefix . '_to_include'] ) ) :
			if( $settings[$prefix . '_to_include'] ) $posts_args['post__in'] = $settings[$prefix . '_to_include'];
		endif;
		$posts_args['paged'] = absint($paged);
		$posts_args =  apply_filters( 'nekit_widgets_query_args_filter', $posts_args );
		$post_query = new \WP_Query($posts_args);
		if( $post_query->have_posts() ) :
			$total_post =  $post_query->post_count;
			ob_start();
				$imageClass = '';
				if ( $settings['image_hover_animation'] ) {
					$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
				}
				$titleClass = 'post-title';
				if( $settings['post_title_animation_choose'] == 'elementor' ) {
					if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
				} else {
					if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
				}
				while( $post_query->have_posts() ) : $post_query->the_post();
				$current_post =  $post_query->current_post;
					if( $settings['widget_count'] == 'four' ) {
						if( $current_post % 10 === 0 ) echo '<div class="primary-row paged-' .esc_attr($paged). '"><div class="featured-post">';
							if( $current_post % 10 === 4 ) echo '<div class="secondary-row paged-' .esc_attr($paged). '">';
									if( $current_post % 10 === 1 ) echo '<div class="trailing-post">';
										?>
											<div class="block-inner-wrap">
												<article class="post-item block-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
													<div class="nekit-item-box-wrap">
														<?php if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
															<figure class="post-thumb-wrap">
																<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
																	<?php
																		if( has_post_thumbnail() ) { 
																			?>
																			<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																				<?php
																					the_post_thumbnail($settings['image_size'], array(
																						'title' => the_title_attribute(array(
																							'echo'  => false
																						))
																					));
																				?>
																			</div>
																			<?php
																		}
																	?>
																</a>
																<?php
																	if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
																?>
															</figure>
														<?php endif; ?>
														<div class="post-element">
															<div class="post-element-inner">
																<?php
																	foreach( $settings['posts_elements_sorting'] as $posts_element ) :
																		switch( $posts_element ) {
																			case 'post-title' : 
																								if( $settings['show_post_title'] == 'yes' ) :
																									?>
																										<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																									<?php
																								endif;
																							break;
																			case 'post-meta' : ?>
																								<div class="post-meta">
																									<?php
																										if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																											'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																											'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																												'value' =>  'far fa-user-circle',
																												'library'   =>  'fa-regular'
																											],
																											'url'	=>	'yes'
																										]));
																										if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																											'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																											'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																												'value' =>  'fas fa-calendar',
																												'library'   =>  'fa-solid'
																											],
																											'url'	=>	'yes'
																										]));
																										if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																											'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																											'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																												'value' =>  'far fa-comment',
																												'library'   =>  'fa-regular'
																											]
																										]));
																									?>
																								</div>
																								<?php
																							break;
																			case 'post-excerpt' : 
																								if( $settings['show_post_excerpt'] == 'yes' ) : 
																									nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																								endif;
																								break;
																			case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																									<a class="post-link-button" href="<?php the_permalink() ?>">
																										<?php echo esc_html( $settings['post_button_text'] ); ?>
																										<?php
																											echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																												'value' => 'fas fa-angle-right',
																												'library'   =>  'fa-solid'
																											]));
																										?>
																									</a>
																								<?php
																								endif;
																								break;
																		}
																	endforeach;
																?>
															</div><!-- .post-element-inner -->
														</div>
													</div>
												</article>
											</div>
										<?php
								if( $current_post % 10 === 0 ) {
									echo '</div><!-- .featured-post -->';
									if( $total_post === $current_post + 1 ) echo '</div><!-- .primary/secondary-row -->';
								} else if( $current_post % 10 === 3 ) {
									echo '</div><!-- .trailing-post --></div><!-- .primary-row -->';
								} else if( $current_post % 10 > 0 && $current_post % 10 < 3 && $total_post === $current_post + 1 ) {
									echo '</div><!-- .trailing-post --></div><!-- .primary-row -->';
								} else if( $current_post % 10 === 9 ) {
									echo '</div><!-- .secondary-row -->';
								} else if( $current_post % 10 > 3 && $current_post % 10 <= 9 && $total_post === $current_post + 1 ) {
									echo '</div><!-- .secondary-row -->';
								} else if( $total_post === $current_post + 1 ) {
									if( $total_post === $current_post + 1 ) echo '</div><!-- .primary/secondary-row -->';
								}
					} else if( $settings['widget_count'] == 'three' ) {
						if( $current_post % 7 === 0 ) echo '<div class="primary-row paged-' .esc_attr($paged). '"><div class="featured-post">';
							if( $current_post % 7 === 1 ) echo '<div class="trailing-post">';
								?>
									<article class="post-item block-item <?php if(!has_post_thumbnail()) { echo esc_attr('no-feat-img'); } ?>">
										<div class="nekit-item-box-wrap">
											<?php
												if( $current_post % 7 != 0 ) :
													?>
														<figure class="post-thumb-wrap">
															<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr($imageClass); ?>">
																<?php
																	if( has_post_thumbnail() ) { 
																		?>
																		<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																			<?php
																				the_post_thumbnail($settings['image_size'], array(
																					'title' => the_title_attribute(array(
																						'echo'  => false
																					))
																				));
																			?>
																		</div>
																		<?php
																	}
																?>
															</a>
															<?php
																if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] != 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
															?>
														</figure>
													<?php
												endif;
											?>
											<div class="post-element">
												<div class="post-element-inner">
													<?php
														if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] == 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
														foreach( $settings['posts_elements_sorting'] as $posts_element ) :
															switch( $posts_element ) {
																case 'post-title' : 
																					if( $settings['show_post_title'] == 'yes' ) :
																						?>
																							<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																						<?php
																					endif;
																				break;
																case 'post-meta' : ?>
																					<div class="post-meta">
																						<?php
																							if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																								'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																								'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																									'value' =>  'far fa-user-circle',
																									'library'   =>  'fa-regular'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																								'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																									'value' =>  'fas fa-calendar',
																									'library'   =>  'fa-solid'
																								],
																								'url'	=>	'yes'
																							]));
																							if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																								'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																								'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																									'value' =>  'far fa-comment',
																									'library'   =>  'fa-regular'
																								]
																							]));
																						?>
																					</div>
																					<?php
																				break;
																case 'post-excerpt' : 
																					if( $settings['show_post_excerpt'] == 'yes' ) : 
																						nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																					endif;
																					break;
																case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																						<a class="post-link-button" href="<?php the_permalink() ?>">
																							<?php echo esc_html( $settings['post_button_text'] ); ?>
																							<?php
																								echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																									'value' => 'fas fa-angle-right',
																									'library'   =>  'fa-solid'
																								]));
																							?>
																						</a>
																					<?php
																					endif;
																					break;
															}
														endforeach;
													?>
												</div><!-- .post-element-inner -->
											</div>
											<?php
												if( $current_post % 7 === 0 ) :
													if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
														<figure class="post-thumb-wrap">
															<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo esc_attr( $imageClass ); ?>>
																<?php
																	if( has_post_thumbnail() ) { 
																		?>
																		<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																			<?php
																				the_post_thumbnail($settings['image_size'], array(
																					'title' => the_title_attribute(array(
																						'echo'  => false
																					))
																				));
																			?>
																		</div>
																		<?php
																	}
																?>
															</a>
															<?php
																if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] != 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
															?>
														</figure>
													<?php 
													endif;
												endif;
											?>
										</div>
									</article>
								<?php
							if( $current_post % 7 === 0 )  {
								echo '</div><!-- .featured-post -->';
								if( $total_post == $current_post + 1 ) echo '</div><!-- .primary-row -->';
							} else if( $current_post  % 7 === 6 )  {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							} else if( $current_post % 7 > 0 && $total_post == $current_post + 1 ) {
								echo '</div><!-- .trailing-post -->';
								echo '</div><!-- .primary-row -->';
							}
					} else if( $settings['widget_count'] == 'two' ) {
						if( $current_post === 0 ) echo '<div class="primary-row paged-' .esc_attr($paged). '">';
							if( $current_post === 5 ) echo '<div class="secondary-row trailing-post paged-' .esc_attr($paged). '">';
								if( $current_post === 0 ) echo '<div class="featured-post">';
									if( $current_post === 1 ) echo '<div class="trailing-post">';
										?>
											<article class="post-item block-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
												<div class="nekit-item-box-wrap">
													<?php if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
														<figure class="post-thumb-wrap">
															<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
																<?php
																	if( has_post_thumbnail() ) { 
																		?>
																		<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																			<?php
																				the_post_thumbnail($settings['image_size'], array(
																					'title' => the_title_attribute(array(
																						'echo'  => false
																					))
																				));
																			?>
																		</div>
																		<?php
																	}
																?>
															</a>
															<?php
																if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
															?>
														</figure>
													<?php endif; ?>
													<div class="post-element">
														<div class="post-element-inner">
															<?php
																foreach( $settings['posts_elements_sorting'] as $posts_element ) :
																	switch( $posts_element ) {
																		case 'post-title' : 
																							if( $settings['show_post_title'] == 'yes' ) :
																								?>
																									<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																								<?php
																							endif;
																						break;
																		case 'post-meta' : ?>
																							<div class="post-meta">
																								<?php
																									if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																										'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																										'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																											'value' =>  'far fa-user-circle',
																											'library'   =>  'fa-regular'
																										],
																										'url'	=>	'yes'
																									]));
																									if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																										'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																										'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																											'value' =>  'fas fa-calendar',
																											'library'   =>  'fa-solid'
																										],
																										'url'	=>	'yes'
																									]));
																									if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																										'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																										'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																											'value' =>  'far fa-comment',
																											'library'   =>  'fa-regular'
																										]
																									]));
																								?>
																							</div>
																							<?php
																						break;
																		case 'post-excerpt' : 
																							if( $settings['show_post_excerpt'] == 'yes' ) :
																								nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																							endif;
																							break;
																		case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																								<a class="post-link-button" href="<?php the_permalink() ?>">
																									<?php echo esc_html( $settings['post_button_text'] ); ?>
																									<?php
																										echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																											'value' => 'fas fa-angle-right',
																											'library'   =>  'fa-solid'
																										]));
																									?>
																								</a>
																							<?php
																							endif;
																							break;
																	}
																endforeach;
															?>
														</div><!-- .post-element-inner -->
													</div>
												</div>
											</article>
										<?php
									if( $current_post === 0 ) {
										echo '</div><!-- .featured-post -->';
										if( $total_post === $current_post + 1 ) echo '</div><!-- .primary-row -->';
									} else if( $current_post === 4 ) {
										echo '</div><!-- .trailing-post -->';
										echo '</div><!-- .primary-row -->';
									} else if( $current_post < 4 && $total_post === $current_post + 1 ) {
										echo '</div><!-- .trailing-post -->';
										echo '</div><!-- .primary-row -->';
									} else if( $current_post > 4 && $total_post === $current_post + 1 ) {
										echo '</div><!-- .secondary-row -->';
									} else if( $total_post === $current_post + 1 ) {
										echo '</div><!-- *complete-row -->';
									}
					} else {
						if( $current_post % 6 === 0 ) echo '<div class="featured-post paged-' .esc_attr($paged). '">';
							if( $current_post % 6 === 2 ) echo '<div class="trailing-post paged-' .esc_attr($paged). '">';
							?>
								<article class="post-item block-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
									<div class="nekit-item-box-wrap">
										<?php if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
											<figure class="post-thumb-wrap">
												<a class="<?php echo esc_attr( $imageClass ); ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
													<?php
														if( has_post_thumbnail() ) { 
															?>
															<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																<?php
																	the_post_thumbnail($settings['image_size'], array(
																		'title' => the_title_attribute(array(
																			'echo'  => false
																		))
																	));
																?>
															</div>
															<?php
														}
													?>
												</a>
												<?php if( $settings['show_post_categories'] == 'yes' && $settings['widget_count'] != 'two' ) nekit_get_post_categories( get_the_ID(), 2 ); ?>
											</figure>
										<?php endif; ?>
										<div class="post-element">
											<div class="post-element-inner">
												<?php
													foreach( $settings['posts_elements_sorting'] as $posts_element ) :
														switch( $posts_element ) {
															case 'post-title' : 
																				if( $settings['show_post_title'] == 'yes' ) :
																					?>
																						<h2 class="<?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																					<?php
																				endif;
																			break;
															case 'post-meta' : ?>
																				<div class="post-meta">
																					<?php
																						if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
																							'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
																							'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																								'value' =>  'far fa-user-circle',
																								'library'   =>  'fa-regular'
																							],
																							'url'	=>	'yes'
																						]));
																						if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																							'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																							'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																								'value' =>  'fas fa-calendar',
																								'library'   =>  'fa-solid'
																							],
																							'url'	=>	'yes'
																						]));
																						if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
																							'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
																							'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																								'value' =>  'far fa-comment',
																								'library'   =>  'fa-regular'
																							]
																						]));
																					?>
																				</div>
																				<?php
																			break;
															case 'post-excerpt' : 
																				if( $settings['show_post_excerpt'] == 'yes' ) : 
																					nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
																				endif;
																				break;
															case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
																					<a class="post-link-button" href="<?php the_permalink() ?>">
																						<?php echo esc_html( $settings['post_button_text'] ); ?>
																						<?php
																							echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $options['post_button_icon'] ) ? $options['post_button_icon'] : [
																								'value' => 'fas fa-angle-right',
																								'library'   =>  'fa-solid'
																							]));
																						?>
																					</a>
																				<?php
																				endif;
																				break;
														}
													endforeach;
												?>
											</div><!-- .post-element-inner -->
										</div>
									</div>
								</article>
							<?php
							if( $current_post % 6 == 1 )  {
								echo '</div><!-- .featured-post -->';
							} else if( $current_post % 6 === 5 || $total_post == $current_post + 1 ) {
								echo '</div><!-- .trailing-post -->';
							}
					}
				endwhile;
				wp_reset_postdata();
			$response['loaded'] = true;
			$response['html'] = ob_get_clean();
		endif;
		wp_send_json_success(wp_json_encode($response));
		wp_die();
	}

	/**
	 * Single related posts widget AJAX Function
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function single_related_posts_widget_ajax_content() {
		check_ajax_referer( 'nekit-frontend-nonce', '_wpnounce' );
		$response['loaded'] = false;
		$response['html'] = '';
		$settings = isset( $_POST['options'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true ) : '';
		$paged = isset( $_POST['paged'] ) ? intval( wp_unslash( $_POST['paged'] ) ): 2;
		$posts_args = $settings['posts_args'];
		$posts_args['paged'] = absint($paged);
		$post_query = new \WP_Query($posts_args);
		if( $post_query->have_posts() ) :
			ob_start();
				$imageClass = '';
				if ( $settings['image_hover_animation'] ) {
					$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
				}
				$titleClass = 'post-title';
				if( $settings['post_title_animation_choose'] == 'elementor' ) {
					if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
				} else {
					if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
				}
				while( $post_query->have_posts() ) : $post_query->the_post();
					?>
						<article class="post-item related-posts-wrap paged-<?php echo esc_attr($paged); ?>">
                            <div class="related-post-thumbnail-wrap">
                                <?php
                                    if( $settings['show_post_thumbnail'] == 'yes' ) :
                                ?>
                                        <figure class="related-post-thumbnail">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr( $imageClass ); ?>">
                                                <div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                                    <?php the_post_thumbnail(); ?>
                                                </div>
                                            </a>
                                        </figure>
                                <?php 
                                    endif;
                                ?>
                            </div>
                            <div class="related-post-title-meta-wrap">
                                <?php
                                    if( $settings['show_post_title'] == 'yes' ) :
								?>
                                        <h2 class="related-post-title <?php echo esc_attr( $titleClass ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<?php
                                    endif;
                                    foreach( $settings['related_posts_meta_sorting'] as $sorting ) :
                                        switch( $sorting ) :
                                            case 'related-post-author':
                                                if( $settings['show_post_author'] == 'yes' ) :
                                                    echo '<span class="related-post-author">' . 
                                                        wp_kses_post(nekit_get_posts_author([
                                                            'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
															'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
																'value' =>  'far fa-user-circle',
																'library'   =>  'fa-regular'
															]
                                                        ])).
                                                    '</span>';
                                                endif;
                                            break;
                                            case 'related-post-comment':
                                                if( $settings['show_post_comments'] == 'yes' ) :
                                                    echo '<span class="related-post-comment">' .
                                                        wp_kses_post(nekit_get_posts_comments([
                                                            'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
															'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
																'value' =>  'far fa-comment',
																'library'   =>  'fa-regular'
															]
                                                        ])).
                                                    '</span>';
                                                endif;
                                            break;
                                            case 'related-post-date':
                                                if( $settings['show_post_date'] == 'yes' ) :
                                                    echo '<span class="related-post-date">' .
                                                        wp_kses_post(nekit_get_posts_date([
                                                            'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
															'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
																'value' =>  'fas fa-calendar',
																'library'   =>  'fa-solid'
															]
                                                        ])).
                                                    '</span>';
                                                endif;
                                            break;
                                        endswitch;
                                    endforeach;
                                ?>
                            </div>  <!-- .related-post-title-meta-wrap -->
                        </article><!-- .related-posts-wrap -->
					<?php
				endwhile;
				wp_reset_postdata();
			$response['loaded'] = true;
			$response['html'] = ob_get_clean();
		endif;
		wp_send_json_success(wp_json_encode($response));
		wp_die();
	}

	/**
	 * Library Modal HTML
	 * 
	 * @since 1.2.4
	 */
	public function nekit_library_modal_html() {
		?>
			<div id="nekit-library-popup">
				<div class="nekit-library-popup library-popup-inner">
					<div class="header">
						<div class="logo">
							<img src="<?php echo esc_url( plugins_url( 'admin/assets/images/logo.png', __DIR__ ) ); ?>">
						</div>
						<div class="templates-tabs">
							<div class="tab-title isActive" data-tab="blocks"><?php esc_html_e( 'Blocks', 'news-kit-elementor-addons' ); ?></div>
							<div class="tab-title" data-tab="pages"><?php esc_html_e( 'Pages', 'news-kit-elementor-addons' ); ?></div>
						</div>
						<div class="popup-close-trigger">
							<i class="eicon-close" aria-hidden="true" title="<?php esc_html_e( 'Close', 'news-kit-elementor-addons' ); ?>"></i>
						</div>
					</div>
					<div class="templates-tab-content">
						<div class="inner-tab-content blocks-tab-content">
							<div class="filter-tab-search-wrap">   
								<div class="widgets-category-title-filter">
									<div class="active-filter"><span class="filter-text"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ) ?></span><span class="dashicons dashicons-arrow-down-alt2"></span></div>
									<ul class="filter-list"></ul>
								</div>
								<div class="free-pro-filter-tabs">
									<button class="filter-tab free"><?php echo esc_html__( 'Free', 'news-kit-elementor-addons' ); ?></button>
									<button class="filter-tab pro"><?php echo esc_html__( 'Pro', 'news-kit-elementor-addons' ); ?></button>
									<button class="filter-tab both active"><?php echo esc_html__( 'Free & Pro', 'news-kit-elementor-addons' ); ?></button>
								</div>
								<div class="search-wrapper">
									<input type="search" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>">
									<span class="dashicons dashicons-search"></span>
								</div>
							</div>
							<div class="tab-blocks-list-wrap">
								<div class="tab-content-wrap tab-blocks-list widgets-blocks-library">
									<div class="grid-sizer"></div>
								</div>
							</div>
						</div>
						<div class="inner-tab-content pages-tab-content">
							<div class="filter-tab-search-wrap">
								<div class="widgets-category-title-filter">
									<div class="active-filter"><span class="filter-text"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ) ?></span><span class="dashicons dashicons-arrow-down-alt2"></span></div>
									<ul class="filter-list"></ul>
								</div>
								<div class="free-pro-filter-tabs">
									<button class="filter-tab free"><?php echo esc_html__( 'Free', 'news-kit-elementor-addons' ); ?></button>
									<button class="filter-tab pro"><?php echo esc_html__( 'Pro', 'news-kit-elementor-addons' ); ?></button>
									<button class="filter-tab both active"><?php echo esc_html__( 'Free & Pro', 'news-kit-elementor-addons' ); ?></button>
								</div>
								<div class="search-wrapper">
									<input type="search" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>">
									<span class="dashicons dashicons-search"></span>
								</div>
							</div>
							<div class="tab-pages-list-wrap">
								<div class="tab-content-wrap tab-pages-list pages-library">
									<div class="grid-sizer"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="nekit-elementor-loading" class="nekit-elementor-loading" style="display: none;">
					<div class="elementor-loader-wrapper">
						<div class="elementor-loader" aria-hidden="true">
							<div class="elementor-loader-boxes">
							<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div></div></div>
						<div class="elementor-loading-title"><?php echo esc_html__( 'Loading', 'news-kit-elementor-addons' ); ?></div>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * Admin thank you footer text
	 * MARK: ADMIN FOOTER
	 * 
	 * @since 1.2.4
	 */
	public function nekit_admin_footer_text( $footer_text ) {
		global $plugin_page;
		$is_nekit_page = in_array( $plugin_page, ['news-kit-elementor-addons', 'news-kit-elementor-addons-theme-builder', 'news-kit-elementor-addons-starter-sites','news-kit-elementor-addons-settings', 'news-kit-elementor-addons-popup-builder','news-kit-elementor-addons-pre-made-blocks' ] );
		if( $is_nekit_page ) $footer_text = apply_filters( 'nekit_admin_footer_text_filter',  sprintf( esc_html__( 'Thank you for using News Kit Elementor Addons. Please leave us a %1$s', 'news-kit-elementor-addons' ), '<a href="'. esc_url( '//wordpress.org/support/plugin/news-kit-elementor-addons/reviews/?filter=5' ) .'" target="_blank">'. esc_html__( 'Rating', 'news-kit-elementor-addons' ) .'</a>' ) );
		return $footer_text;
	}
}