<?php
/**
 * Number Select control
 * 
 * @package News Kit Elementor Addons
 * @since 1.2.3
 */

namespace Nekit_Elementor_Controls;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Number_Select_Control extends \Elementor\Base_Data_Control {
    public function get_type() {
		return 'nekit-number-select-control';
	}

	protected function get_default_settings() {
		return [
            'input_attrs'   =>  [
                'min'   =>  0,
                'max'   =>  100,
                'step'  =>  1
            ],
            'options'    =>  []
        ];
	}

	public function enqueue() {
		/* Styles */
		wp_register_style( 'nekit-number-select-control-style', plugins_url( 'control.css', __FILE__ ) );
		wp_enqueue_style( 'nekit-number-select-control-style' );
		/* Scripts */
		wp_register_script( 'nekit-number-select-control-script', plugins_url( 'control.js', __FILE__ ), ['jquery'] );
		wp_enqueue_script( 'nekit-number-select-control-script' );
	}

    public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="control-content-wrapper">
				<#
					let inputClass = 'nekit-input-field';
					if( data.controlValue.select === 'none' ) inputClass += ' is-hidden'
				#>
				<input type="number" class="{{ inputClass }}" value="{{ data.controlValue.number }}" min="{{ data.input_attrs.min }}" max="{{ data.input_attrs.max }}" step="{{ data.input_attrs.step }}">
                <select class="nekit-select-field" value="{{ data.controlValue.select }}">
                    <# _.each( data.options, function( value, key ) { #>
						<# let selected = ( key === data.controlValue.select ) ? 'selected' : '' #>
                        <option value="{{ key }}" {{{ selected }}}>{{{ value }}}</option>
                    <# } ); #>
                </select>
			</div>
            <# if ( data.description ) { #>
                <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>
		</div>
		<?php
	}
}