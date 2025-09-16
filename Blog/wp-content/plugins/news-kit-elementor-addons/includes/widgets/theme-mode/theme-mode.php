<?php 
/**
 * Theme mode Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Theme_mode_Widget extends \Nekit_Modules\Theme_Mode_Module{
    protected $widget_name = 'nekit-theme-mode';

    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-theme-mode';
    }

    public function get_categories() {
        return ['nekit-widgets-group'];
    }
    
    public function get_keywords() {
        return ['light', 'dark', 'theme', 'mode'];
    }

    protected function render() {
        $settings=$this->get_settings_for_display(); 
        $elementClass = 'nekit-theme-mode';
        $elementClass .= esc_attr( " widget-orientation--". $settings['theme_mode_orientation'] );
        $elementClass .= esc_attr( " nekit-theme-mode-align--". $settings['theme_mode_alignment'] );
        $elementClass .= isset( $settings['theme_mode_alignment_tablet'] ) ? esc_attr( " nekit-theme-mode-align--". $settings['theme_mode_alignment_tablet'] ) : $settings['theme_mode_alignment'];
        $elementClass .= isset( $settings['theme_mode_alignment_mobile'] ) ? esc_attr( " nekit-theme-mode-align--". $settings['theme_mode_alignment_mobile'] ) : $settings['theme_mode_alignment'];
        $elementClass .= esc_attr( " nekit-theme-mode-position--". $settings['theme_mode_position'] );
        $elementClass .= esc_attr( " label-position--". $settings['light_and_dark_title'] );
        if( isset( $_COOKIE['nekitThemeMode'] ) && $_COOKIE['nekitThemeMode'] == 'dark' ) {
            $elementClass .= esc_attr( " dark-mode--on");
        } else if( isset( $_COOKIE['nekitThemeMode'] ) && $_COOKIE['nekitThemeMode'] == 'light' ) {
            $elementClass .= esc_attr( " light-mode--on");
        } else {
            $elementClass .= esc_attr( " light-mode--on");
        }
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
            <span class="theme-mode-light-section theme-mode">
                <?php if( $settings['light_and_dark_title'] == 'before' ) : ?>
                    <span class="theme-mode-title"><?php echo esc_html( $settings['theme_mode_light_title_text'] ); ?></span>
                <?php endif;

                if( $settings['theme_mode_show_light_icon'] == 'yes' ) : ?>
                    <span class="theme-mode-light-icon"><?php echo wp_kses_post( nekit_get_base_value( ['icon' => $settings['theme_mode_light_icon'] ] ) ); ?></span>
                <?php endif;
                
                if( $settings['light_and_dark_title'] == 'after' ) : ?>
                    <span class="theme-mode-title"><?php echo esc_html( $settings['theme_mode_light_title_text'] ); ?></span>
                <?php endif; ?>
            </span>

            <span class="theme-mode-dark-section theme-mode">
                <?php if( $settings['light_and_dark_title'] == 'before' ) : ?>
                    <span class="theme-mode-title"><?php echo esc_html( $settings['theme_mode_dark_title_text'] );?></span>
                <?php endif;

                if( $settings['theme_mode_show_dark_icon'] == 'yes' ) : ?>
                    <span class="theme-mode-dark-icon"><?php echo wp_kses_post( nekit_get_base_value( ['icon' => $settings['theme_mode_dark_icon'] ] ) ); ?></span>
                <?php endif;

                if( $settings['light_and_dark_title'] == 'after' ) : ?>
                    <span class="theme-mode-title"><?php echo esc_html( $settings['theme_mode_dark_title_text'] ); ?></span>
                <?php endif; ?>
            </span>
        </div>
<?php
    }
}