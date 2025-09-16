<?php
/**
 * Mail Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Mail_Widget extends \Nekit_Modules\Mailbox_Module {
	protected $widget_name = 'nekit-mailbox';

	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-mailbox';
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'email', 'mail' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'news-elementor-mail-box mail-box-wrap';
		$elementClass .= esc_attr( ' label-position--' .$settings['mail_title_position'] );
		$elementClass .= esc_attr( ' widget-orientation--' .$settings['items_orientation'] );
		if ( $settings['widget_hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['widget_hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
			<a href="<?php echo esc_attr( 'mailto:' . $settings['mail_address'] ); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<?php
                    // mail title
                    if( $settings['mail_title_option'] == 'yes' && $settings['mail_title_position'] == 'before' ) :
                        echo '<span class="mail-title">' .esc_html($settings['mail_title']). '</span>';
                    endif;

                    // mail icon
                    if( $settings['mail_icon_option'] == 'yes' ) :
                        echo '<span class="mail-icon">' .wp_kses_post(nekit_get_base_value(['icon' => $settings['mail_icon']])). '</span>';
                    endif;

                    // mail title
                    if( $settings['mail_title_option'] == 'yes' && $settings['mail_title_position'] == 'after' ) :
                        echo '<span class="mail-title">' .esc_html($settings['mail_title']). '</span>';
                    endif;
                ?>
			</a>
		<?php
	}
}