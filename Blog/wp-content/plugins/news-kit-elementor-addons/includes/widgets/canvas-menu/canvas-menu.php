<?php
/**
 * Canvas Menu Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Canvas_Menu_Widget extends \Nekit_Modules\Canvas_Menu_Widget_Module {
	protected $widget_name = 'nekit-canvas-menu';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#canvas-menu';
	}
    
	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'menu', 'canvas', 'menu' ];
	}

    function render() {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="news-elementor-canvas-menu <?php echo esc_attr( 'position--' . $settings['canvas_position'] ); ?>">
                <button class="canvas-content-trigger canvas-menu-icon <?php echo esc_attr( 'icon-style--' . $settings['canvas_menu_icon_style'] ); ?>">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </button>
                <div class="canvas-menu-content <?php echo esc_attr( 'appear-from--' . $settings['canvas_appear_from'] ); ?> <?php echo esc_attr( 'appear-animation--' . $settings['canvas_appear_animation'] ); ?>">
                    <?php
                        if( $settings['canvas_template_id'] != 0 ) :
                            $canvas_template = new \Nekit_Render_Templates_Html();
                            $canvas_template->set_current_builder_id($settings['canvas_template_id']);
                            echo $canvas_template->current_builder_template();
                        endif;
                    ?>
                </div>
            </div>
        <?php
    }
}