<?php

class Blogone_Plugin_Install_Helper {

	private static $instance;


	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogone_Plugin_Install_Helper ) ) {
			self::$instance = new Blogone_Plugin_Install_Helper;
		}

		return self::$instance;
	}

	public function get_button_html( $slug ) {
		$button = '';
		$state  = $this->check_plugin_state( $slug );
		if ( ! empty( $slug ) ) {

			$button .= '<div class=" plugin-card-' . $slug . '" style="padding: 8px 0 5px;">';

			switch ( $state ) {
				case 'install':
					$nonce  = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'from'   => 'import',
								'plugin' => $slug,
							),
							esc_url_raw( network_admin_url( 'update.php' ) )
						),
						'install-plugin_' . $slug
					);
					$button .= '<a data-slug="' . esc_attr($slug) . '" class="install-now blogone-install-plugin button  " href="' . esc_url( $nonce ) . '" data-name="' . esc_attr($slug) . '" aria-label="' . esc_attr( __('Install %1$s','blogone'),$slug) . '">' . __( 'Install and activate', 'blogone' ) . '</a>';
					break;

				case 'activate':
					if ( $slug == 'woocommerce' ) {
						$plugin_link_suffix = $slug . '/woocommerce.php';
					} else {
						$plugin_link_suffix = $slug . '/' . $slug . '.php';
					}

					$nonce = add_query_arg(
						array(
							'action'        => 'activate',
							'plugin'        => rawurlencode( $plugin_link_suffix ),
							'plugin_status' => 'all',
							'paged'         => '1',
							'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_link_suffix ),
						), esc_url_raw( network_admin_url( 'plugins.php' ) )
					);

					$button .= '<a data-slug="' . esc_attr($slug) . '" class="activate-now button button-primary" href="' . esc_url( $nonce ) . '" aria-label="' . esc_attr( __('Install %1$s','blogone'),$slug) . '">' . __( 'Activate', 'blogone' ) . '</a>';
					break;
			}
			$button .= '</div>';
		}// End if().

		return $button;
	}

	private function check_plugin_state( $slug ) {
		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) || file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/index.php' ) || file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/wp-contact-form-7.php' ) ) {
			$needs = ( is_plugin_active( $slug . '/' . $slug . '.php' ) || is_plugin_active( $slug . '/index.php' ) || is_plugin_active( $slug . '/wp-contact-form-7.php' ) ) ? 'deactivate' : 'activate';

			return $needs;
		} else {
			return 'install';
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );
		wp_enqueue_script( 'blogone-plugin-install-helper', get_template_directory_uri() . '/inc/customizer/install/js/install.js', array( 'jquery' ) );
		wp_localize_script(
			'blogone-plugin-install-helper', 'blogone_plugin_helper',
			array(
				'activating' => esc_html__( 'Activating ', 'blogone' ),
			)
		);
		wp_localize_script(
			'blogone-plugin-install-helper', 'blogone_pagenow',
			array( 'import' )
		);
	}
}