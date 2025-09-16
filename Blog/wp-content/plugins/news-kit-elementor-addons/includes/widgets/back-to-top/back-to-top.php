<?php
/**
 * Back To Top Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Back_To_Top_Widget extends \Nekit_Modules\Back_To_Top_Module {
	protected $widget_name = 'nekit-back-to-top';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-back-to-top';
	}

	public function get_keywords() {
		return [ 'scroll to top', 'back to top', 'top' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$back_to_top_title_position = isset( $settings['back_to_top_title_position'] ) ? $settings['back_to_top_title_position']: 'after';
		$elementClass = 'nekit-back-to-top-wrap';
		$elementClass .= esc_attr( ' widget-position--' .$settings['widget_position'] );
		$elementClass .= esc_attr( ' label-position--' . $back_to_top_title_position );
		$elementClass .= esc_attr( ' widget-orientation--' .$settings['items_orientation'] );
		if ( $settings['widget_hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['widget_hover_animation'];
		}

		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<span <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-show="<?php echo esc_attr($settings['display_widget_point']); ?>">
				<?php
                    // back to top title
                    if( $settings['back_to_top_title_option'] == 'yes' && $settings['back_to_top_title_position'] == 'before' ) :
                        echo '<span class="back-to-top-title">' .esc_html($settings['back_to_top_title']). '</span>';
                    endif;

                    // back to top icon
                    if( $settings['back_to_top_icon_option'] == 'yes' ) :
                        echo '<span class="back-to-top-icon">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['back_to_top_icon']])). '</span>';
                    endif;

                    // back to top title
                    if( $settings['back_to_top_title_option'] == 'yes' && $settings['back_to_top_title_position'] == 'after' ) :
                        echo '<span class="back-to-top-title">' .esc_html($settings['back_to_top_title']). '</span>';
                    endif;
                ?>
			</span>
		<?php
	}
}