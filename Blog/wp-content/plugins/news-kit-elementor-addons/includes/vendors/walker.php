<?php
/**
 * Class rendering mega menu structure
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Walker;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Walker_Nav_Menu extends \Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu nekit-sub-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}
    /**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
	 *              to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item. Used for padding.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;
		if( $depth == 0 ) :
			$mega_menu_classes[] = 'nekit-animate-submenu';
			$menu_mega_menu_id = get_post_meta( $menu_item->ID, 'nekit_mega_menu_id', true );
			$nekit_mega_menu_option = get_post_meta( $menu_item->ID, 'nekit_mega_menu_option', true );
			$nekit_mobile_sub_menu_type = get_post_meta( $menu_item->ID, 'nekit_mobile_sub_menu_type', true );
			if( wp_is_mobile() && $nekit_mobile_sub_menu_type == 'wordpress-submenu' ) $nekit_mega_menu_option = 'disabled';
			$nekit_menu_icon_option = get_post_meta( $menu_item->ID, 'nekit_menu_icon_option', true );
			$nekit_menu_icon = get_post_meta( $menu_item->ID, 'nekit_menu_icon', true );
			$nekit_menu_icon_position = get_post_meta( $menu_item->ID, 'nekit_menu_icon_position', true );
			if( $nekit_mega_menu_option && $nekit_mega_menu_option == 'enable' ) :
				$nekit_width_layout = get_post_meta( $menu_item->ID, 'nekit_width_layout', true );
				$nekit_position = get_post_meta( $menu_item->ID, 'nekit_position', true );
				$nekit_appear_direction = get_post_meta( $menu_item->ID, 'nekit_appear_direction', true );
				$nekit_appear_animation = get_post_meta( $menu_item->ID, 'nekit_appear_animation', true );
				$nekit_display_on_event_type = get_post_meta( $menu_item->ID, 'nekit_display_on_event_type', true );
				$nekit_close_on_outside_click = get_post_meta( $menu_item->ID, 'nekit_close_on_outside_click', true );
				$mega_menu_classes[] = $nekit_width_layout ? esc_attr( 'nekit-megamenu-' . $nekit_width_layout) : 'nekit-boxed-layout';
				$mega_menu_classes[] = $nekit_position ? esc_attr($nekit_position) : 'relative';
				$mega_menu_classes[] = $nekit_appear_direction ? esc_attr( 'nekit-mega-menu-appear-from--' . $nekit_appear_direction) : 'nekit-mega-menu-appear-from--top';
				$mega_menu_classes[] = $nekit_appear_animation ? esc_attr( 'nekit-mega-menu-appear-animation--' . $nekit_appear_animation) : 'nekit-mega-menu-appear-animation--fade';
				$mega_menu_classes[] = $nekit_close_on_outside_click ? esc_attr( 'close-event--' . $nekit_close_on_outside_click) : 'close-event--outside-click';
			endif;
		endif;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
		if( is_array( $menu_item->classes ) && in_array( 'menu-item-has-children', $menu_item->classes) ) $class_names .= ' nekit-has-sub-menu';
		// Append the mega menu classe in suitable place
		if( $depth == 0 ) :
			$menu_item_icon_class = $nekit_menu_icon_position ? esc_attr( 'nekit-icon-position--' . $nekit_menu_icon_position ) : 'before';
			if( $nekit_menu_icon_option == 'show' ) $class_names .= ' ' . $menu_item_icon_class;
			if( $nekit_mega_menu_option == 'enable' ) :
				$class_names .= ' nekit-has-mega-menu';
				$class_names .= ' appear-event--' . $nekit_display_on_event_type;
			endif;
		endif;

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID attribute applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item    The current menu item.
		 * @param stdClass $args         An object of wp_nav_menu() arguments.
		 * @param int      $depth        Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}
		$atts['href']         = ! empty( $menu_item->url ) ? $menu_item->url : '';
		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );
		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		if( $depth == 0 ) :
			if( $nekit_menu_icon_option == 'show' && $nekit_menu_icon_position == 'before' ) :
				$item_output .= '<i class="nekit-menu-context ' .esc_attr($nekit_menu_icon). '"></i>';		
			endif;
		endif;
		$item_output .= ( isset( $args->link_before )  && isset( $args->link_after ) ) ? $args->link_before . $title . $args->link_after : '';
		if( $depth == 0 ) :
			if( $nekit_menu_icon_option == 'show' && $nekit_menu_icon_position == 'after' ) :
				$item_output .= '<i class="nekit-menu-context ' .esc_attr($nekit_menu_icon). '"></i>';		
			endif;
		endif;
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );

		// Append the mega menu html structure in suitable place
		if( $depth == 0 ) :
			if( $nekit_mega_menu_option == 'enable' ) :
				$Nekit_render_templates_html = new \Nekit_Render_Templates_Html();
				$output .= '<div class="nekit-mega-menu-container ' .esc_attr(implode(" ", $mega_menu_classes)). '">';
				$output .= $Nekit_render_templates_html->current_builder_template($menu_mega_menu_id);
				$output .= '</div><!-- .nekit-mega-menu-container -->';
			endif;
		endif;
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 * @since 5.9.0 Renamed `$item` to `$data_object` to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output      Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object Menu item data object. Not used.
	 * @param int      $depth       Depth of page. Not Used.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}
}