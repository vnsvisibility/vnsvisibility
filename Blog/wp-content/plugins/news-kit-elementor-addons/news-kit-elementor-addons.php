<?php
/**
 * Plugin Name: News Kit Elementor Addons
 * Description: Elementor addons for your website.
 * Version:     1.3.6
 * Author:      BlazeThemes
 * Author URI:  http://blazethemes.com/
 * Text Domain: news-kit-elementor-addons
 * Domain Path: /languages
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Elementor tested up to: 3.29.0
 * Elementor Pro tested up to: 3.26.1
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 define( "NEKIT_URL", plugin_dir_url( __FILE__ ) );
 define( "NEKIT_PATH", plugin_dir_path( __FILE__ ) );
 if( ! defined( 'ELEMENTOR_VERSION' ) ) define( 'ELEMENTOR_VERSION', '0' );

 if( ! function_exists( 'news_kit_elementor_addons_init' ) ) :
	/**
	 * Load plugin
	 * 
	 * @package News Kit Elementor Addons
	 */
	function news_kit_elementor_addons_init() {
		// Load plugin file
		require_once( __DIR__ . '/includes/plugin.php' );
		require_once( __DIR__ . '/custom/custom-styles.php' );
		require_once( __DIR__ . '/custom/popup/base.php' );
		require_once( __DIR__ . '/admin/admin.php' );
		require_once( __DIR__ . '/library/library.php' );
		
		Nekit_Addon\Plugin::instance();
		News_Kit_Elementor_Addons_Admin\Admin::instance();
		News_Kit_Elementor_Addons_Library\Library::instance();
		do_action( 'news_kit_elementor_addons_loaded' );
	}
	add_action( 'plugins_loaded', 'news_kit_elementor_addons_init' );
endif;

if( ! function_exists( 'news_kit_elementor_addons_i18n' ) ) :
	/**
	 * Load text domain
	 * 
	 * @package News Kit Elementor Addons
	 */
	function news_kit_elementor_addons_i18n() {
		load_plugin_textdomain('news-kit-elementor-addons', false, NEKIT_PATH . '/languages');
	}
	add_action( 'plugins_loaded', 'news_kit_elementor_addons_i18n' );
endif;

if( ! function_exists( 'nekit_preloader_html' ) ) :
	/**
	 * Prepends html on '<body>'
	 * 
	 */
	function nekit_preloader_html() {
		if( did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) return;
		$nekit_preloader_option =  get_option( 'nekit_preloader_option' );
		if( ! $nekit_preloader_option || $nekit_preloader_option == 'none' ) return;
		$nekit_preloader_entrance_animation =  get_option( 'nekit_preloader_entrance_animation' );
		$nekit_preloader_icon =  get_option( 'nekit_preloader_icon' ) ? get_option( 'nekit_preloader_icon' ) : ['value' =>  'fas fa-spinner','library'   =>  'fa-solid'];
		$nekit_preloader_image =  get_option( 'nekit_preloader_image' );
		$nekit_preloader_image_icon_animation_type = get_option( 'nekit_preloader_image_icon_animation_type' ) ? get_option( 'nekit_preloader_image_icon_animation_type' ): 'spinning';
		$wrapper_class = 'nekit-preloader-elm';
		$wrapper_class .= ' nekit-preloader-icon-image-animation--' . esc_attr( $nekit_preloader_image_icon_animation_type );
		$wrapper_class .= ' nekit-animated-entrance-' . esc_attr( $nekit_preloader_entrance_animation );
		?>
		<div id="nekit-preloader-elm" class="<?php echo esc_attr( $wrapper_class ); ?>" style="position: fixed;width: 100%;height: 100vh;z-index:9999;">
			<?php
				switch( $nekit_preloader_option ) {
					case 'icon': if( isset( $nekit_preloader_icon['value'] ) && $nekit_preloader_icon['value'] ) echo '<i class="' .esc_attr( $nekit_preloader_icon['value'] ). '"></i>';
							break;
					case 'image': 
							if( isset( $nekit_preloader_image['url'] ) ) echo '<img class="preloader-item preloader-image" src="' .esc_url( $nekit_preloader_image['url'] ). '"/>';
							break;
					default: $nekit_preloader_animation_type = get_option( 'nekit_preloader_animation_type' );
							$nekit_preloader_animation_type = $nekit_preloader_animation_type ? $nekit_preloader_animation_type : 'circle';
							switch($nekit_preloader_animation_type) {
								case 'packman': echo '<div class="nekit-packman"><div class="packman-wrap"></div><div class="dots"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>';
											break;
								case 'dot-loader': echo '<div class="nekit-dot-loading-area"><div class="nekit-dot-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>';
											break;
								case 'bar-loader': echo '<div class="nekit-bar-loader"><div class="nekit-bar-center nekit-bar-loading"></div></div>';
											break;
								case 'circle-loader-new': echo '<div class="nekit-circle-loading-new-wrap"><div class="nekit-circle-loading-new">Loading<span></span></div></div>';
											break;
								case 'progress-bar': echo '<div class="nekit-bar-loader-new"><span class="nekit-bar-loader-new nekit-bar-inner-loader"></span></div>';
													break;
								case 'dot-wave': echo '<div class="nekit-dot-wave-wrap"><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span></div>';
												break;
								case 'gooey-effect': echo '<div class="nekit-gooey-wrap"><div class="nekit-gooey-ball nekit-gooey-ball-1"></div><div class="nekit-gooey-ball nekit-gooey-ball-2"></div><div class="nekit-gooey-ball nekit-gooey-ball-3"></div></div>';
												break;
								case 'cardle-loader': echo '<div class="nekit-newtons-cradle"><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div></div>';
												break;
								default: echo '<div class="nekit-preload-circle"></div>';
							}
				}
			?>
		</div>
	<?php
	}
	add_action( 'wp_head', 'nekit_preloader_html', 99 );
endif;

if( ! function_exists( 'nekit_preloader_html_preview' ) ) :
	/**
	 * Prepends html on '<body>'
	 * 
	 */
	function nekit_preloader_html_preview() {
		$nekit_preloader_option =  get_option( 'nekit_preloader_option' );
		if( ! $nekit_preloader_option ) $nekit_preloader_option = 'none';
		$nekit_preloader_entrance_animation =  get_option( 'nekit_preloader_entrance_animation' );
		$nekit_preloader_icon =  get_option( 'nekit_preloader_icon' ) ? get_option( 'nekit_preloader_icon' ) : ['value' =>  'fas fa-spinner','library'   =>  'fa-solid'];
		$nekit_preloader_image =  get_option( 'nekit_preloader_image' );
		$nekit_preloader_image_icon_animation_type = get_option( 'nekit_preloader_image_icon_animation_type' ) ? get_option( 'nekit_preloader_image_icon_animation_type' ): 'fade-out';
		$wrapper_class = 'nekit-preloader-elm';
		$wrapper_class .= ' nekit-preloader-animation-type--' . esc_attr( $nekit_preloader_option );
		$wrapper_class .= ' nekit-preloader-icon-image-animation--' . esc_attr( $nekit_preloader_image_icon_animation_type );
		$wrapper_class .= ' nekit-animated-entrance-' . esc_attr( $nekit_preloader_entrance_animation );
	?>
		<div id="nekit-preloader-elm" class="<?php echo esc_attr( $wrapper_class ); ?>" style="display: none;position: fixed;width: 100%;height: 100vh;z-index:9999;">
			<?php
				if( isset( $nekit_preloader_icon['value'] ) && $nekit_preloader_icon['value'] ) {
					echo '<i class="preloader-item preloader-icon ' .esc_attr( $nekit_preloader_icon['value'] ). '"></i>';
				} else {
					echo '<i class="preloader-item preloader-icon"></i>';
				}
				if( isset( $nekit_preloader_image['url'] ) ) echo '<img class="preloader-item preloader-image" src="' .esc_url( $nekit_preloader_image['url'] ). '"/>';
				$nekit_preloader_animation_type = get_option( 'nekit_preloader_animation_type' );
				$nekit_preloader_animation_type = $nekit_preloader_animation_type ? $nekit_preloader_animation_type : 'circle';
				switch($nekit_preloader_animation_type) {
					case 'packman': echo '<div class="preloader-item preloader-custom nekit-packman"><div class="packman-wrap"></div><div class="dots"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>';
								break;
					case 'dot-loader': echo '<div class="preloader-item preloader-custom nekit-dot-loading-area"><div class="nekit-dot-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>';
								break;
					case 'bar-loader': echo '<div class="preloader-item preloader-custom nekit-bar-loader"><div class="nekit-bar-center nekit-bar-loading"></div></div>';
								break;
					case 'circle-loader-new': echo '<div class="preloader-item preloader-custom nekit-circle-loading-new-wrap"><div class="nekit-circle-loading-new">Loading<span></span></div></div>';
								break;
					case 'progress-bar': echo '<div class="preloader-item preloader-custom nekit-bar-loader-new"><span class="nekit-bar-loader-new nekit-bar-inner-loader"></span></div>';
										break;
					case 'dot-wave': echo '<div class="preloader-item preloader-custom nekit-dot-wave-wrap"><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span></div>';
									break;
					case 'gooey-effect': echo '<div class="preloader-item preloader-custom nekit-gooey-wrap"><div class="nekit-gooey-ball nekit-gooey-ball-1"></div><div class="nekit-gooey-ball nekit-gooey-ball-2"></div><div class="nekit-gooey-ball nekit-gooey-ball-3"></div></div>';
									break;
					case 'cardle-loader': echo '<div class="preloader-item preloader-custom nekit-newtons-cradle"><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div></div>';
									break;
					default: echo '<div class="preloader-item preloader-custom nekit-preload-circle"></div>';
				}
			?>
		</div>
	<?php
	}
	add_action( 'elementor/preview/init', 'nekit_preloader_html_preview', 99 );
endif;