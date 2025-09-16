<?php
/**
 * Site Logo Title Widget One 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Site_Logo_Title_Widget extends \Nekit_Modules\Site_Logo_Title_Module {
	protected $widget_name = 'nekit-site-logo-title';

	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-site-logo-title';
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'logo', 'site-title', 'tagline' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( ! empty( $settings['logo_link']['url'] ) ) {
			$this->add_link_attributes( 'logo_link', $settings['logo_link'] );
		}
		?>
			<div class="news-elementor-site-logo-title site-logo-title-wrap <?php echo esc_attr( 'layout--'. $settings['widget_layout'] ); ?>">
				<?php
					if( $settings['logo_option'] != 'none' ) :
						$retina_image = isset( $settings['retina_image']['url'] ) ? $settings['retina_image']['url']: false;
						if($retina_image) $image_src = 'srcset="' .esc_url($settings['logo_image']['url']). ' 1x, ' .esc_url($retina_image). ' 2x"';
						switch($settings['logo_option']) {
							case 'custom': 
								?>
									<a class="custom-logo-link" <?php echo wp_kses_post($this->get_render_attribute_string( 'logo_link' )); ?>><img class="site-logo custom-logo" src="<?php echo esc_url($settings['logo_image']['url']); ?>" <?php if( isset($image_src) ) echo wp_kses_post($image_src); ?>/></a>
								<?php
								break;
							default: the_custom_logo();
						}
					endif;

					echo '<div class="site-title-description-wrap">';
						if( $settings['site_title_option'] != 'none' ) :
						$site_title = (is_front_page()) ? $settings["site_title_tag"] : $settings["site_title_innerpages_tag"];
							echo '<' .esc_attr( $site_title ). ' class="site-title">';
								if( $settings['site_title_frontpage_link_option'] != 'yes' || ! is_front_page() ) echo '<a href="' .esc_url(home_url()). '">';
									switch($settings['site_title_option']) {
										case 'custom': echo esc_html($settings['site_title']);
											break;
										default: echo esc_html( get_bloginfo( 'name' ) );
									}
								if( $settings['site_title_frontpage_link_option'] != 'yes' || ! is_front_page() ) echo '</a>';
							echo '</' .esc_attr( $site_title ). '>';
						endif;

						if( $settings['site_tagline_option'] != 'none' ) :
							echo '<p class="site-description">';
									switch($settings['site_tagline_option']) {
										case 'custom': echo esc_html($settings['site_tagline']);
											break;
										default: echo esc_html( get_bloginfo( 'description', 'display' ) );
									}
							echo '</p>';
						endif;
					echo '</div>';
				?>
			</div>
		<?php
	}
}