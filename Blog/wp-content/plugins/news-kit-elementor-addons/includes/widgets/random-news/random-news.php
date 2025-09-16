<?php
/**
 * Random News Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Random_News_Widget extends \Nekit_Modules\Random_News_Module {
	protected $widget_name = 'nekit-random-news';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-random-news';
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'random', 'news', 'random news', 'random posts' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'news-elementor-random-news random-news-wrap';
		$elementClass .= esc_attr( ' label-position--' .$settings['random_news_title_position'] );
		$elementClass .= esc_attr( ' widget-orientation--' .$settings['items_orientation'] );
		if( $settings['widget_hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['widget_hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<a href="<?php echo esc_url( nekit_get_random_news_url() ); ?>" target="<?php echo esc_attr( $settings['widget_link_target'] ); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<?php
                    // random news title
                    if( $settings['random_news_title_option'] == 'yes' && $settings['random_news_title_position'] == 'before' ) :
                        echo '<span class="random-news-title">' .esc_html($settings['random_news_title']). '</span>';
                    endif;

                    // random news icon
                    if( $settings['random_news_icon_option'] == 'yes' ) :
                        echo '<span class="random-news-icon">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['random_news_icon']])). '</span>';
                    endif;

                    // random news title
                    if( $settings['random_news_title_option'] == 'yes' && $settings['random_news_title_position'] == 'after' ) :
                        echo '<span class="random-news-title">' .esc_html($settings['random_news_title']). '</span>';
                    endif;
                ?>
			</a>
		<?php
	}
}