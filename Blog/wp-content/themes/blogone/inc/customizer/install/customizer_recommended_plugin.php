<?php
get_template_part('/inc/customizer/custom-controls/customizer-notify/customizer-notify');

$config_customizer = array(
	'recommended_plugins'       => array(
		'britetechs-companion' => array(
			'recommended' => true,
			'description' => sprintf('Install and activate <strong>Britetechs Companion</strong> plugin for taking full advantage of all the features this theme has to offer %s.', 'blogone'),
		),		
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'blogone' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'blogone' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'blogone' ),
	'activate_button_label'     => esc_html__( 'Activate', 'blogone' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'blogone' ),
);
Blogone_Customizer_Notify::init( apply_filters( 'blogone_customizer_notify_array', $config_customizer ) );