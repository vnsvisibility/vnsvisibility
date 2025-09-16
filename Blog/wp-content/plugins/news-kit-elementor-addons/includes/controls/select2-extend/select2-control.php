<?php
/**
 * News List Widget One 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Elementor_Controls;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Select2_Extend extends \Elementor\Base_Data_Control {
	public function get_type() {
		return 'nekit-select2-extend';
	}

	public function enqueue() {
		wp_register_script( 'nekit-select2-extend-control', plugins_url( 'control.js', __FILE__ ), ['jquery'] );
		wp_enqueue_script( 'nekit-select2-extend-control' );
	}

	protected function get_default_settings() {
		return [
			'options' => [],
			'multiple' => false,
			'query_slug' => 'post'
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr($control_uid); ?>" class="elementor-control-type-nekit-select2-extend" {{ multiple }} data-query-slug="{{data.query_slug}}" data-setting="{{ data.name }}" data-rest-url="<?php echo esc_attr( get_rest_url(). 'nekit/v1' . '/{{data.options}}/' ); ?>" data-dependency="{{ data.dependency }}">
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
