<?php 
/**
 * Single Featured Image Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets\Single;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Featured_Image extends \Nekit_Modules\Single_Module {
    protected $widget_name = 'nekit-single-featured-image';
    public function get_custom_help_url() {
        return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-single-featured-image';
    }

    public function get_keywords() {
        return [ 'featured', 'image', 'single' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'image_section',
            [
                'label' =>  esc_html__( 'Image', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/single-featured-image" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);

        $this->add_control(
            'image_sizes',
            [
                'label' =>  esc_html__( 'Image Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'large',
                'options'   =>  $this->get_image_sizes()
            ]
        );
        
        $this->add_control(
            'alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'toggle'    =>  false,
                'frontend_available' => true,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'    =>    [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ]
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' =>  esc_html__( 'Caption', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'none',
                'options'   =>  [
                    'none'  =>  esc_html__( 'None', 'news-kit-elementor-addons' ),
                    'attachment_caption'    =>  esc_html__( 'Attachment Caption', 'news-kit-elementor-addons' ),
                    'custom_caption'    =>  esc_html__( 'Custom Caption', 'news-kit-elementor-addons' )
                ]
            ]
        );

        $this->add_control(
            'custom_caption',
            [
                'label' =>  esc_html__( 'Custom Caption', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'condition' =>  [
                    'caption'   =>  'custom_caption'
                ]
            ]
        );
        $this->insert_divider();

        $this->add_responsive_control(
            'image_width',
            [
                'label' =>  esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'   =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-featured-image'  =>  'width: {{SIZE}}%'
                ]
            ]

        );

        $this-> add_responsive_control(
            'image_ratio',
            [
                'label' =>  esc_html__( 'Image Ratio', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px' =>  [
                        'min'   =>  0,
                        'max'   =>  2,
                        'step'   =>  .1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  .6,
                    'unit'  =>  'px'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .nekit-single-featured-image'  =>  'padding-bottom: calc( {{SIZE}} * 100% );'
                ]
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' =>  esc_html__( 'Object Fit', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'default',
                'options'   =>  [
                    'default'   =>  esc_html__( 'Default', 'news-kit-elementor-addons' ),
                    'fill'  =>  esc_html__( 'Fill', 'news-kit-elementor-addons' ),
                    'cover' =>  esc_html__( 'Cover', 'news-kit-elementor-addons' ),
                    'contain'   =>  esc_html__( 'Contain', 'news-kit-elementor-addons' )
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .post-image'   =>  'object-fit: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'image_style_section',
            [
                'label' =>  esc_html__( 'Image', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector' =>  '{{WRAPPER}} .nekit-single-featured-image'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  =>  'box_shadow',
                'selector' =>  '{{WRAPPER}} .nekit-single-featured-image'
            ]
        );

        $this->get_spacing_control( 'border_radius', 'Border Radius(px)', '.nekit-single-featured-image', 'border-radius' );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_overlay',
            [
                'label' =>  esc_html__( 'Image Overlay', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'image_overlay_option',
            [
                'label' =>  esc_html__( 'Show image overlay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'image_overlay_initial_background_color',
                'selector'  =>  '{{WRAPPER}} .has-image-overlay::before',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name'  =>  'image_overlay_initial_css_filter',
                'selector'  =>  '{{WRAPPER}} .post-thumb-wrap img'
            ]
        );

        $this->insert_divider();
        $this->add_responsive_control(
            'image_overlay_width',
            [
                'label' =>  esc_html__( 'Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'width:{{SIZE}}%'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_overlay_height',
            [
                'label' =>  esc_html__( 'Height', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'height:{{SIZE}}%'
                ]
            ]
        );

        $this->get_spacing_control( 'image_overlay_border_radius', 'Border Radius(px)', '.has-image-overlay::before', 'border-radius' );

        $this->end_controls_section();

        $this->start_controls_section(
            'caption_section',
            [
                'label' =>  esc_html__( 'Caption', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' =>   'caption_typography',
                'selector'  =>  '{{WRAPPER}} .single-featured-image-caption',
                'fields_options'    =>  [
                    'typography'    =>  [
                        'default'   =>  'custom'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'size'  =>  13,
                            'unit'  =>  'px'
                        ]
                    ],
                    'font_style' => [
                        'default' => 'italic'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_alignment',
            [
                'label' =>  esc_html__( 'Caption Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'center',
                'toggle'    =>  false,
                'frontend_available' => true,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-text-align-right'
                    ]
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .single-featured-image-caption'    =>  'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'caption_color',
            [
                'label' =>  esc_html__( 'Caption Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8a8a8a',
                'selectors' =>  [
                    '{{WRAPPER}} .single-featured-image-caption'    =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'caption_background_color',
                'selector'  =>  '{{WRAPPER}} .single-featured-image-caption',
                'exclude'   =>  ['image']
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'  =>  'caption_shadow',
                'selector'  =>  '{{WRAPPER}} .single-featured-image-caption'
            ]
        );

        $this->get_spacing_control( 'caption_padding', 'Padding', '.single-featured-image-caption', '', [ 9, 0, 9, 0 ] );

        $this->end_controls_section();
    }

    protected function render_template() {
        $settings = $this -> get_settings_for_display();
        $elementClass = 'nekit-single-featured-image';
        $elementClass .= esc_attr(" alignment--" . $settings['alignment'] );
        $utils_object = new \Nekit_Utilities\Utils();
        $caption = $settings['caption'];
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        if( has_post_thumbnail() ) : ?>
            <figure <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
                <div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                    <?php the_post_thumbnail( $settings['image_sizes'], [ 'class'  =>  'post-image' ] ); ?>
                </div>
                <?php
                    switch($caption):
                        case 'attachment_caption':
                            if( get_the_post_thumbnail_caption() != '' )
                                echo '<figcaption class="single-featured-image-caption">' . esc_html( get_the_post_thumbnail_caption() ) . '</figcaption>';   
                        break;

                        case 'custom_caption': 
                            if( ! empty( $settings['custom_caption'] ) ){
                                echo '<figcaption class="single-featured-image-caption">' . esc_html( $settings['custom_caption'] ) . '</figcaption>';
                            }
                        break;

                    endswitch; 
                ?>
            </figure>
        <?php
        endif;
    }
 }