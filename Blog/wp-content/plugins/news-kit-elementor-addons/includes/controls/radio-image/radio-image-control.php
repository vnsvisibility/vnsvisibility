<?php
/**
 * Radio image control
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */

namespace Nekit_Elementor_Controls;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Radio_Image_Control extends \Elementor\Base_Data_Control {
    public function get_type() {
		return 'nekit-radio-image-control';
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'separator' => 'after',
			'options' => [],
		];
	}

	public function enqueue() {
		// Styles
		wp_register_style( 'nekit-radio-image-control-style', plugins_url( 'control.css', __FILE__ ) );
		wp_enqueue_style( 'nekit-radio-image-control-style' );
		// Scripts
		wp_register_script( 'nekit-radio-image-control-script', plugins_url( 'control.js', __FILE__ ), ['jquery'] );
		wp_enqueue_script( 'nekit-radio-image-control-script' );

	}

    public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper">
				<input id="<?php echo esc_attr($control_uid); ?>" type="hidden" data-setting="{{ data.name }}">
			</div>
			<div class="control-content-wrapper">
				<# _.each( data.options, function( value, key ) { #>
					<div data-value="{{ key }}" class="<# if( key === data.controlValue ) { #>isActive<# } #>"><img src="{{{ value.url }}}" alt="{{{ value.label }}}"/></div>
				<# } ); #>
			</div>
            <# if ( data.description ) { #>
                <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>
		</div>
		<?php
	}
}