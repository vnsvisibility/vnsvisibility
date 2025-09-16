<?php
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-canvas' );

$is_preview_mode = \Elementor\Plugin::$instance->preview->is_preview_mode();
// $woocommerce_class = $is_preview_mode && class_exists( 'WooCommerce' ) ? 'woocommerce woocommerce-page woocommerce-shop canvas-test' : '';
$woocommerce_class =  $is_preview_mode && class_exists( 'WooCommerce' ) ? 'woocommerce woocommerce-page' : '';

$nekit_popup_class = 'nekit';
if( $is_preview_mode && get_post_meta( get_the_ID(), 'builder_type', true ) === 'popup-builder' ) $nekit_popup_class .= ' nekit-popover-preview';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo esc_html(wp_get_document_title()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></title>
	<?php endif; ?>
	<?php 
		wp_head();
		remove_all_actions( 'wp_head' ); // Avoid running wp_head hooks again.
	?>
	<?php

	// Keep the following line after `wp_head()` call, to ensure it's not overridden by another templates.
	Utils::print_unescaped_internal_string( Utils::get_meta_viewport( 'canvas' ) );
	?>
</head>

<body <?php body_class([ $woocommerce_class, $nekit_popup_class ]); ?>>
	<?php
		if ( method_exists( 'Elementor\Modules\PageTemplates\Module', 'body_open' ) ) Elementor\Modules\PageTemplates\Module::body_open();
		/**
		 * Before canvas page template content.
		 *
		 * Fires before the content of Elementor canvas page template.
		 *
		 * @since 1.0.0
		 */
		if( ! $is_preview_mode ) do_action( 'elementor/page_templates/canvas/before_content' );

		if( $is_preview_mode && get_post_meta( get_the_ID(), 'builder_type', true ) === 'popup-builder' ) :
			
			echo '<div id="nekit-popup-post-'. esc_attr( get_the_ID() ) .'" class="nekit-template-popup">';

				echo '<div class="nekit-popup-container">';

					echo '<div class="nekit-popup-overlay"></div>';

					echo '<div class="nekit-popup-inner-container">';

						echo '<button class="nekit-popup-close"><span class="dashicons dashicons-no"></span></button>';

						echo '<div class="nekit-popup-wrap">';
		endif;
							// Elementor Editor
							if ( $is_preview_mode || is_singular('nekit-mm-cpt') ) {
								\Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();
							// Frontend
							} else {
								// Display Custom Elementor Templates
								do_action( 'elementor/page_templates/canvas/nekit_print_content' );
							}

		if( $is_preview_mode && get_post_meta( get_the_ID(), 'builder_type', true ) === 'popup-builder' ) :

						echo '</div><!-- .nekit-popup-wrap -->';
						
					echo '</div><!-- .nekit-popup-inner-container -->';

				echo '</div><!-- .nekit-popup-container -->';

			echo '</div><!-- .nekit-popup-template -->';
			
		endif;

		/**
		 * After canvas page template content.
		 *
		 * Fires after the content of Elementor canvas page template.
		 *
		 * @since 1.0.0
		 */
		if( ! $is_preview_mode ) do_action( 'elementor/page_templates/canvas/after_content' );

		if( $is_preview_mode ) wp_footer();	/* Comment this because wp_footer will be called from other files. */
	?>
	</body>
</html>