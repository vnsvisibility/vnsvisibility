<?php
/**
 * Phone Call Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Phone_Call_Widget extends \Nekit_Modules\Phone_Call_Module {
	protected $widget_name = 'nekit-phone-call';

	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-phone-call';
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'call', 'phone' ];
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'news-elementor-phone-call phone-call-wrap';
		$elementClass .= esc_attr( ' label-position--' .$settings['phone_title_position'] );
		$elementClass .= esc_attr( ' widget-orientation--' .$settings['items_orientation'] );
		if( $settings['widget_hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['widget_hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<a href="<?php echo esc_attr( 'tel:' . $settings['phone_number'] ); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<?php
                    // phone title
                    if( $settings['phone_title_option'] == 'yes' && $settings['phone_title_position'] == 'before' ) :
                        echo '<span class="phone-title">' .esc_html($settings['phone_title']). '</span>';
                    endif;
					
                    // phone icon
                    if( $settings['phone_icon_option'] == 'yes' ) :
                        echo '<span class="phone-icon">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['phone_icon']])). '</span>';
                    endif;

                    // phone title
                    if( $settings['phone_title_option'] == 'yes' && $settings['phone_title_position'] == 'after' ) :
                        echo '<span class="phone-title">' .esc_html($settings['phone_title']). '</span>';
                    endif;
                ?>
			</a>
		<?php
	}
}