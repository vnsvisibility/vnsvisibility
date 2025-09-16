<?php
/**
 * Site Nav Menu Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
use Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Site_Nav_Menu_Widget extends \Nekit_Modules\Site_Nav_Menu_Widget_Module {
	protected $widget_name = 'nekit-site-nav-menu';
	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#site-nav-menu';
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'menu', 'nav' ];
	}
	
    public function get_nav_menus_options_array() {
        $nav_menu_array = [];
        $nav_menu_array['none'] = esc_html__( 'Select a menu', 'news-kit-elementor-addons' );
        $nav_menus = wp_get_nav_menus();
        foreach($nav_menus as $nav_menu) :
            $nav_menu_array[$nav_menu->slug] = $nav_menu->name;
        endforeach;
        return apply_filters( 'news_kit_elementor_addons_nav_menus_option_filter', $nav_menu_array );
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
		$sub_menu_dropdown_icon_position = isset( $settings['sub_menu_dropdown_icon_position'] ) ? $settings['sub_menu_dropdown_icon_position']: 'after';
		$elementClass = 'news-elementor-nav-menu nav-menu-wrap';
		if( isset( $settings['menu_item_hover_effect'] ) ) $elementClass .= ' nekit-pointer-'.$settings['menu_item_hover_effect'];
		if( isset( $settings['menu_item_hover_animate'] ) ) $elementClass .= ' nekit-pointer-'.$settings['menu_item_hover_animate'];
		$elementClass .= isset( $settings['sub_menu_display_type'] ) ? ' nekit-' . $settings['sub_menu_display_type'] : ' nekit-submenu-onmouse-hover';
		$elementClass .= ' nekit-' . $settings['sub_menu_display_appear_direction'];
		$elementClass .= ' nekit-' . $settings['sub_menu_display_appear_animation'];
		$elements_align = isset( $settings['elements_align'] ) ? $settings['elements_align']: 'left';
		$submenu_elements_align = isset( $settings['submenu_elements_align'] ) ? $settings['submenu_elements_align']: 'left';
		$elementClass .= ' nekit-menu-items-align--' . $elements_align;
		$elementClass .= isset( $settings['elements_align_tablet'] ) ? ' nekit-menu-items-tablet-align--' . $settings['elements_align_tablet'] : ' nekit-menu-items-tablet-align--' . $elements_align;
		$elementClass .= isset( $settings['elements_align_mobile'] ) ? ' nekit-menu-items-mobile-align--' . $settings['elements_align_mobile'] : ' nekit-menu-items-mobile-align--' . $elements_align;
		$elementClass .= ' nekit-sub-menu-items-align--' . $submenu_elements_align;
		$elementClass .= isset( $settings['submenu_elements_align_tablet'] ) ? ' nekit-sub-menu-items-tablet-align--' . $settings['submenu_elements_align_tablet'] : ' nekit-sub-menu-items-tablet-align--' . $settings['submenu_elements_align'];
		$elementClass .= isset( $settings['submenu_elements_align_mobile'] ) ? ' nekit-sub-menu-items-mobile-align--' . $settings['submenu_elements_align_mobile'] : ' nekit-sub-menu-items-mobile-align--' . $settings['submenu_elements_align'];
		$elementClass .= ' mobile-menu-dropdown-width--' . $settings['dropdown_menu_stretch'];
		$elementClass .= ' mobile-menu-appear-from--' . $settings['dropdown_menu_appear_direction'];
		$elementClass .= ' mobile-menu-dropdown-appear-animation--' . $settings['dropdown_menu_appear_animation'];
		$elementClass .= ' mobile-menu-dropdown-sub-menu-display-type--' . $settings['dropdown_menu_sub_menu_display_type'];
		if( isset( $settings['menu_description_position'] ) ) $elementClass .= ' nekit-'. $settings['menu_description_position'];
		if( isset( $settings['menu_description_motion_effect'] ) ) $elementClass .= ' nekit-menu-description-motion--'. $settings['menu_description_motion_effect'];
		$elementClass .= ' nekit-menu-dropdown-section-align--'. $settings['mobile_dropdown_menu_section_align'];

		$mobile_hamburger_style = isset( $settings['mobile_hamburger_style'] ) ? $settings['mobile_hamburger_style']: 'one';

		if( empty( $settings['nav_menu_display'] ) ) {
			echo esc_html__( 'Select the menu from select nav menu to display', 'news-kit-elementor-addons' );
			return;
		} elseif( ! is_nav_menu( $settings['nav_menu_display'] ) ) {
			echo esc_html__( 'Selected menu has been deleted. Please select the another existing nav menu.', 'news-kit-elementor-addons' );
			return;
		}
		?>
			<div class="<?php echo esc_attr($elementClass); ?>" 
				data-mobile="<?php echo esc_attr( $settings['mobile_menu_breakdown'] ); ?>" 
				data-parent-dropdown="<?php echo esc_attr( nekit_get_base_attribute_value( ['icon' => $settings['parent_sub_menu_dropdown_icon']] ) ); ?>" 
				data-parent-upside="<?php echo esc_attr( nekit_get_base_attribute_value( ['icon' => $settings['parent_sub_menu_upside_icon']] ) ); ?>"
				data-dropdown="<?php echo esc_attr( nekit_get_base_attribute_value( ['icon' => $settings['sub_menu_dropdown_icon']] ) ); ?>" 
				data-upside="<?php echo esc_attr( nekit_get_base_attribute_value( ['icon' => $settings['sub_menu_upside_icon']] ) ); ?>" 
				data-dropdown-position="<?php echo esc_attr( $sub_menu_dropdown_icon_position ); ?>"
				data-dropdown-header-icon="<?php echo esc_attr( nekit_get_base_value(['icon'	=> $settings['dropdown_header_icon']])); ?>">

				<button class="responsive-menu-trigger">
					<div class="nekit-hamburger-icon <?php echo esc_attr( 'hamburger-style--' . $mobile_hamburger_style ); ?>" id="nekit-<?php echo esc_attr( $settings['mobile_hamburger_menu_animation_style'] ); ?>">
			          	<span class="line"></span><span class="line"></span><span class="line"></span>
			        </div>
					<?php
						if( isset( $settings['mobile_hamburger_menu_type_text_open'] ) || isset( $settings['mobile_hamburger_menu_type_text_close'] ) ) :
							$mobile_hamburger_menu_type_text_open = ( isset( $settings['mobile_hamburger_menu_type_text_open'] ) && $settings['mobile_hamburger_menu_type_text_open'] ) ? $settings['mobile_hamburger_menu_type_text_open']: '';
							$mobile_hamburger_menu_type_text_close = ( isset( $settings['mobile_hamburger_menu_type_text_close'] ) && $settings['mobile_hamburger_menu_type_text_close'] ) ? $settings['mobile_hamburger_menu_type_text_close']: '';
					?>
							<span class="nekit-hamburger-menu-text">
								<span class="nekit-hamburger-menu-opentext"><?php echo esc_html( $mobile_hamburger_menu_type_text_open ); ?></span>
								<span class="nekit-hamburger-menu-closetext"><?php echo esc_html( $mobile_hamburger_menu_type_text_close ); ?></span>
							</span>
					<?php
						endif;
					?>
				</button>
				<?php
					if( $settings['show_menu_description'] == 'yes' ) add_filter( 'walker_nav_menu_start_el', 'news_kit_elementor_addons_add_menu_description', 10, 4 );
						require_once( NEKIT_PATH . '/includes/vendors/custom-walker.php' );
						// print out nav menu html
						wp_nav_menu([
							'menu'  => esc_html($settings['nav_menu_display']),
							'container'	=> 'nav',
							'container_class'  => 'nekit-nav-menu-container',
							'menu_class'	=> 'nekit-nav-menu-list-wrap orientation--' .esc_attr( $settings['menu_orientation'] ) . ' icon-position--' .esc_attr( $sub_menu_dropdown_icon_position ),
							'walker'    => new \Nekit_Walker\Walker_Custom_Nav_Menu()
						]);
						if( $settings['show_menu_description'] == 'yes' ) remove_filter( 'walker_nav_menu_start_el', 'news_kit_elementor_addons_add_menu_description', 10 );
                ?>
			</div>
		<?php
	}
}