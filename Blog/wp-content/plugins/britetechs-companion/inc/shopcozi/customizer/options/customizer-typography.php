<?php
function bc_shopcozi_customizer_typography( $wp_customize ){

	$option = shopcozi_default_options();

	// Shopcozi Typography Panel
	$wp_customize->add_panel( 'shopcozi_typography',
		array(
			'priority'       => 41,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__('Shopcozi Typography','shopcozi'),
		)
	);

	$sections = array(
		'body',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
	);

	foreach( $sections as $key => $section ){

		// Sections
	    $wp_customize->add_section('shopcozi_'.$section.'_section',
	        array(
	            'priority'     => $key,
	            'title'        => sprintf(__('%s','shopcozi'),ucfirst($section)),
	            'panel'        => 'shopcozi_typography',
	        )
	    );

			// font size
			$wp_customize->add_setting('shopcozi_'.$section.'_fontsize',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_range_value',
					'priority'          => 2,
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(new Shopcozi_Range_Control($wp_customize,'shopcozi_'.$section.'_fontsize',
				array(
					'label' 		=> esc_html__('Font Size', 'shopcozi'),
					'section' 		=> 'shopcozi_'.$section.'_section',
					'type'          => 'range-value',
					'media_query'   => true,
                    'input_attr' => array(
                        'mobile' => array(
                            'min' => 6,
                            'max' => 50,
                            'step' => 1,
                            'default_value' => $option['shopcozi_'.$section.'_fontsize'],
                        ),
                        'tablet' => array(
                            'min' => 6,
                            'max' => 50,
                            'step' => 1,
                            'default_value' => $option['shopcozi_'.$section.'_fontsize'],
                        ),
                        'desktop' => array(
                            'min' => 6,
                            'max' => 50,
                            'step' => 1,
                            'default_value' => $option['shopcozi_'.$section.'_fontsize'],
                        ),
                    ),
				)
			) );

			// line height
			$wp_customize->add_setting('shopcozi_'.$section.'_lineheight',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_range_value',
					'priority'          => 3,
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(new Shopcozi_Range_Control($wp_customize,'shopcozi_'.$section.'_lineheight',
				array(
					'label' 		=> esc_html__('Line Height', 'shopcozi'),
					'section' 		=> 'shopcozi_'.$section.'_section',
					'type'          => 'range-value',
					'media_query'   => true,
                    'input_attr' => array(
                        'mobile' => array(
                            'min' => 0.1,
                            'max' => 3,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_lineheight'],
                        ),
                        'tablet' => array(
                            'min' => 0.1,
                            'max' => 3,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_lineheight'],
                        ),
                        'desktop' => array(
                            'min' => 0.1,
                            'max' => 3,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_lineheight'],
                        ),
                    ),
				)
			) );

			// letter spacing
			$wp_customize->add_setting('shopcozi_'.$section.'_letterspace',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_range_value',
					'priority'          => 4,
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(new Shopcozi_Range_Control($wp_customize,'shopcozi_'.$section.'_letterspace',
				array(
					'label' 		=> esc_html__('Letter Spacing', 'shopcozi'),
					'section' 		=> 'shopcozi_'.$section.'_section',
					'type'          => 'range-value',
					'media_query'   => true,
                    'input_attr' => array(
                        'mobile' => array(
                            'min' => 0.1,
                            'max' => 10,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_letterspace'],
                        ),
                        'tablet' => array(
                            'min' => 0.1,
                            'max' => 10,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_letterspace'],
                        ),
                        'desktop' => array(
                            'min' => 0.1,
                            'max' => 10,
                            'step' => 0.1,
                            'default_value' => $option['shopcozi_'.$section.'_letterspace'],
                        ),
                    ),
				)
			) );

			// font weight
	    	$wp_customize->add_setting('shopcozi_'.$section.'_fontweight',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_select',
					'default'           => $option['shopcozi_'.$section.'_fontweight'],
					'priority'          => 5,
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control('shopcozi_'.$section.'_fontweight',
				array(
					'type'        => 'select',
					'label'       => esc_html__('Font Weight', 'shopcozi'),
					'section'     => 'shopcozi_'.$section.'_section',
					'choices'     => shopcozi_font_weight(),
				)
			);

			// text transform
	    	$wp_customize->add_setting('shopcozi_'.$section.'_texttransform',
				array(
					'sanitize_callback' => 'shopcozi_sanitize_select',
					'default'           => $option['shopcozi_'.$section.'_texttransform'],
					'priority'          => 6,
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control('shopcozi_'.$section.'_texttransform',
				array(
					'type'        => 'select',
					'label'       => esc_html__('Text Transform', 'shopcozi'),
					'section'     => 'shopcozi_'.$section.'_section',
					'choices'     => shopcozi_text_transform(),
				)
			);

	}	

}
add_action('customize_register','bc_shopcozi_customizer_typography');

if( !function_exists('shopcozi_subset')):
	function shopcozi_subset(){
		$subset = array(
			'latin'=>'latin',
			'latin-ext'=>'latin-ext',
			'cyrillic'=>'cyrillic',
			'cyrillic-ext'=>'cyrillic-ext',
			'greek'=>'greek',
			'greek-ext'=>'greek-ext',
			'vietnamese'=>'vietnamese',
			'arabic'=>'arabic',
			);
		return $subset;
	}
endif;

if( !function_exists('shopcozi_font_size')):
	function shopcozi_font_size(){
		$font_size = array(''=>'-- Select --');
		for( $i=9; $i<=100; $i++ ){		
			$font_size[$i] = $i;		
		}	
		return $font_size;
	}
endif;

if( !function_exists('shopcozi_line_height')):
	function shopcozi_line_height(){
		$lineheight = array(''=>'-- Select --');
		for( $i=1; $i<=100; $i++ ){		
			$lineheight[$i] = $i;		
		}	
		return $lineheight;
	}
endif;

if( !function_exists('shopcozi_font_weight')):
	function shopcozi_font_weight(){
		$fontweight = array(
			''=>'-- Select --',
			100=>100,
			200=>200,
			300=>300,
			400=>400,
			500=>500,
			600=>600,
			700=>700,
			800=>800,
			900=>900,
		);	
		return $fontweight;
	}
endif;


if( !function_exists('shopcozi_letterspace')):
	function shopcozi_letterspace(){
		$letterspace = array(
			''=>'-- Select --'
		);
		for( $i=1; $i<=100; $i++ ){		
			$letterspace[$i] = $i;		
		}	
		return $letterspace;
	}
endif;

if( !function_exists('shopcozi_font_style')):
	function shopcozi_font_style(){
		$font_style = array(
			''=>'-- Select --',
			'normal'=>'Normal',
			'italic'=>'Italic',
			'oblique'=>'Oblique',
			'initial'=>'Initial',
			'inherit'=>'Inherit',
		);	
		return $font_style;	
	}
endif;

if( !function_exists('shopcozi_text_decoration')):
	function shopcozi_text_decoration(){
		$textdecoration = array(
			''=>'-- Select --',
			'overline'=>'overline',
			'line-through'=>'line-through',
			'underline'=>'underline',
			'underline overline'=>'underline overline',
			'inherit'=>'Inherit',
		);	
		return $textdecoration;	
	}
endif;

if( !function_exists('shopcozi_text_transform')):
	function shopcozi_text_transform(){
		$texttransform = array(
			''=>'-- Select --',
			'none'=>'none',
			'capitalize'=>'capitalize',
			'uppercase'=>'uppercase',
			'lowercase'=>'lowercase',
			'initial'=>'initial',
			'inherit'=>'inherit',
		);	
		return $texttransform;	
	}
endif;