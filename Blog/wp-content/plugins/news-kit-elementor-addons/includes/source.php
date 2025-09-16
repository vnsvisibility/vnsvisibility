<?php
use Elementor\TemplateLibrary\Source_Base;

/**
 * Nekit_Library setup
 *
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Nekit_Data_Source extends \Elementor\TemplateLibrary\Source_Base {

	public function get_id() {
		return 'nekit-layout-manager';
	}

	public function get_title() {
		return esc_html__( 'News Kit Elementor Addons Layout Manager', 'news-kit-elementor-addons' );
	}

	public function register_data() {}

	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a News Kit Elementor Addons layout manager' );
	}

	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a News Kit Elementor Addons layout manager' );
	}

	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a News Kit Elementor Addons layout manager' );
	}

	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a News Kit Elementor Addons layout manager' );
	}

	public function get_items( $args = [] ) {
		return [];
	}

	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}
 
	public function request_template_data( $demo_id ) {
		if ( empty( $demo_id ) ) {
			return;
		}
		
		if ( '' !== $demo_id ) {
			$url = 'https://prev.blazethemes.com/demo-data/news-kit-elementor-addons/'. $demo_id;
		} else {
			$url = 'https://prev.blazethemes.com/news-kit-elementor-addons/';
		}
		$response = wp_remote_get( $url, [
			'timeout'   => 60,
			'sslverify' => false
		]);
		return wp_remote_retrieve_body( $response );
	}

	public function get_data( array $args ) {//TODO: FIX - This function imports placeholder images in library
		$data = $this->request_template_data( $args['demo_id'] );
		$data = json_decode( $data, true );

		if ( empty( $data ) || empty( $data['content'] ) ) {
			throw new \Exception( 'Template does not have any content' );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );
		return $data;
	}
}