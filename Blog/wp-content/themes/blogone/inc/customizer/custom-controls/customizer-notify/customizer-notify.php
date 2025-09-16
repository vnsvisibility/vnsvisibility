<?php
class Blogone_Customizer_Notify {

	private $recommended_actions;
	private $recommended_plugins;
	private static $instance;
	private $recommended_actions_title;
	private $recommended_plugins_title;
	private $dismiss_button;
	private $install_button_label;
	private $activate_button_label;
	private $deactivate_button_label;
	private $config;

	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogone_Customizer_Notify ) ) {
			self::$instance = new Blogone_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	public function setup_config() {

		global $blogone_customizer_notify_recommended_plugins;
		global $blogone_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$blogone_customizer_notify_recommended_plugins = array();
		$blogone_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$blogone_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$blogone_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$deactivate_button_label = isset( $this->config['deactivate_button_label'] ) ? $this->config['deactivate_button_label'] : '';
	}

	public function setup_actions() {
		// Register the section
		add_action( 'customize_register', array( $this, 'blogone_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'blogone_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_blogone_customizer_notify_dismiss_action', array( $this, 'blogone_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_blogone_customizer_notify_dismiss_recommended_plugins', array( $this, 'blogone_customizer_notify_dismiss_recommended_plugins_callback' ) );
	}

	
	public function blogone_customizer_notify_scripts_for_customizer() {
		wp_enqueue_style( 'blogone-customizer-notify-css', get_template_directory_uri() . '/inc/customizer/custom-controls/customizer-notify/css/notify.css', array());

		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_add_inline_script( 'plugin-install', 'var blogone_pagenow = "customizer";' );

		wp_enqueue_script( 'updates' );

		wp_enqueue_script( 'blogone-customizer-notify-js', get_template_directory_uri() . '/inc/customizer/custom-controls/customizer-notify/js/notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'blogone-customizer-notify-js', 'blogoneCustomizercompanionObject', array(
				'ajaxurl'            => admin_url( 'admin-ajax.php' ),
				'template_directory' => get_template_directory_uri(),
				'base_path'          => admin_url(),
				'activating_string'  => __( 'Activating', 'blogone' ),
			)
		);
	}

	
	public function blogone_plugin_notification_customize_register( $wp_customize ) {
		
		require get_parent_theme_file_path('/inc/customizer/custom-controls/customizer-notify/customizer-notify-section.php');

		$wp_customize->register_section_type( 'Blogone_Customizer_Notify_Section' );
		$wp_customize->add_section(
			new Blogone_Customizer_Notify_Section(
				$wp_customize,
				'blogone-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);
	}

	public function blogone_customizer_notify_dismiss_recommended_action_callback() {
		global $blogone_customizer_notify_recommended_actions;

		$option = wp_parse_args(  get_option( 'blogone_option', array() ), array() );

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); 

		if ( ! empty( $action_id ) ) {

			
			if ( $option['blogone_customizer_notify_show'] != '' ) {

				$blogone_customizer_notify_show_recommended_actions = $option['blogone_customizer_notify_show'];
				switch ( $_GET['todo'] ) {
					case 'add':
						$blogone_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$blogone_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				$option['blogone_customizer_notify_show'] = $blogone_customizer_notify_show_recommended_actions;
				update_option('blogone_option',$option);
				
			} else {
				$blogone_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $blogone_customizer_notify_recommended_actions ) ) {
					foreach ( $blogone_customizer_notify_recommended_actions as $blogone_customizer_notify_recommended_action ) {
						if ( $blogone_customizer_notify_recommended_action['id'] == $action_id ) {
							$blogone_customizer_notify_show_recommended_actions[ $blogone_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$blogone_customizer_notify_show_recommended_actions[ $blogone_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					$option['blogone_customizer_notify_show'] = $blogone_customizer_notify_show_recommended_actions;
					update_option('blogone_option',$option);
				}
			}
		}
		die(); 
	}

	public function blogone_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		$option = wp_parse_args(  get_option( 'blogone_option', array() ), array() );

		echo esc_html( $action_id ); 

		if ( ! empty( $action_id ) ) {

			$blogone_customizer_notify_show_recommended_plugins = $option['blogone_customizer_notify_show_recommended_plugins'];

			switch ( $_GET['todo'] ) {
				case 'add':
					$blogone_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$blogone_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			$option['blogone_customizer_notify_show_recommended_plugins'] = $blogone_customizer_notify_show_recommended_plugins;
			update_option('blogone_option',$option);
		}
		die(); 
	}

}