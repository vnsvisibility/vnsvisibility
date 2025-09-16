<?php
// namespace Elementor\Core\Kits\Documents\Tabs;
namespace News_Kit_Elementor_Addons_Tabs;
use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Core\Files\Uploads_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'Nekit_Settings_Preloader' ) ) :
    class Nekit_Settings_Preloader extends \Elementor\Core\Kits\Documents\Tabs\Tab_Base {
        public function get_id() {
            return 'nekit-settings-preloader';
        }

        public function get_title() {
            return esc_html__( 'Preloader', 'news-kit-elementor-addons' );
        }

        public function get_group() {
            return 'settings';
        }

        public function get_icon() {
            return 'eicon-loading';
        }

        public function get_help_url() {
            return 'https://forum.blazethemes.com/news-elementor/addons/#preloader-site-settings';
        }

        protected function register_tab_controls() {
            $this->start_controls_section(
                'section_' . $this->get_id(),
                [
                    'label' => $this->get_title(),
                    'tab' => $this->get_id()
                ]
            );

            $this->add_control(
                'nekit_preloader_option',
                [
                    'label'	=>	esc_html__( 'Type', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'none',
                    'options'	=>	[
                        'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
                        'animation'  => esc_html__( 'Animation', 'news-kit-elementor-addons' ),
                        'icon'  => esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                        'image' => esc_html__( 'Image', 'news-kit-elementor-addons' )
                    ]
                ]
            );

            $this->add_control(
                'nekit_preloader_icon',
                [
                    'label' =>  esc_html__( 'Loader Icon', 'news-kit-elementor-addons' ),
                    'label_block'   => false,
                    'type'  =>  \Elementor\Controls_Manager::ICONS,
                    'skin'  =>  'inline',
                    'exclude_inline_options'    => ['svg'],
                    'default'   =>  [
                        'value' =>  'fas fa-spinner',
                        'library'   =>  'fa-solid'
                    ],
                    'condition' => [
                        'nekit_preloader_option'   => 'icon'
                    ]
                ]
            );

            $this->add_control(
                'nekit_preloader_image',
                [
                    'label' => esc_html__( 'Loader Image', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'nekit_preloader_option'   => 'image'
                    ]
                ]
            );

            $this->add_control(
                'nekit_preloader_animation_type',
                [
                    'label'	=>	esc_html__( 'Animation', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'circle',
                    'options'	=>	[
                        'circle' => esc_html__( 'Circle', 'news-kit-elementor-addons' ),
                        'packman'  =>  esc_html__( 'Packman', 'news-kit-elementor-addons' ),
                        'dot-loader' =>   esc_html__( 'Dot Loader', 'news-kit-elementor-addons' ),
                        'bar-loader' =>   esc_html__( 'Bar Loader', 'news-kit-elementor-addons' ),
                        'circle-loader-new' =>   esc_html__( 'Circle Loader New', 'news-kit-elementor-addons' ),
                        'progress-bar' =>   esc_html__( 'Progress Bar', 'news-kit-elementor-addons' ),
                        'dot-wave' =>   esc_html__( 'Dot Wave', 'news-kit-elementor-addons' ),
                        'gooey-effect' =>   esc_html__( 'Gooey Effect', 'news-kit-elementor-addons' ),
                        'cardle-loader' =>   esc_html__( 'Cardle Loader', 'news-kit-elementor-addons' )
                    ],
                    'condition' => [
                        'nekit_preloader_option'    => 'animation'
                    ]
                ]
            );

            $this->add_control(
                'nekit_preloader_image_icon_animation_type',
                [
                    'label'	=>	esc_html__( 'Animation', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'spinning',
                    'options'	=>	[
                        'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
                        'spinning'   => esc_html__( 'Spinning', 'news-kit-elementor-addons' ),
                        'bounce'   => esc_html__( 'Bounce', 'news-kit-elementor-addons' ),
                        'flash'   => esc_html__( 'Flash', 'news-kit-elementor-addons' ),
                        'pulse'   => esc_html__( 'Pulse', 'news-kit-elementor-addons' ),
                        'rubberBand'   => esc_html__( 'Rubber Band', 'news-kit-elementor-addons' ),
                        'shake'   => esc_html__( 'Shake', 'news-kit-elementor-addons' ),
                        'headShake'   => esc_html__( 'Head Shake', 'news-kit-elementor-addons' ),
                        'swing'   => esc_html__( 'Swing', 'news-kit-elementor-addons' ),
                        'tada'   => esc_html__( 'Tada', 'news-kit-elementor-addons' ),
                        'wobble'   => esc_html__( 'Wobble', 'news-kit-elementor-addons' ),
                        'jello'   => esc_html__( 'Jello', 'news-kit-elementor-addons' )
                    ],
                    'condition' => [
                        'nekit_preloader_option'    => ['icon','image']
                    ]
                ]
            );

            $this->add_control(
				'nekit_preloader_animation_duration',
				[
					'label' =>  esc_html__( 'Duration  (ms)', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::NUMBER,
					'min'   =>  0,
					'max'   =>  100000,
					'step'  =>  100,
					'default'   =>  2000,
                    'condition' => [
                        'nekit_preloader_option!'    => 'none'
                    ],
                    'selectors' =>   [
                        '{{WRAPPER}} #nekit-preloader-elm i' => 'animation-duration: {{VALUE}}ms',
                        '{{WRAPPER}} #nekit-preloader-elm img' => 'animation-duration: {{VALUE}}ms'
                    ]
				]
			);

            $this->add_control(
				'nekit_preloader_animation_delay',
				[
					'label' =>  esc_html__( 'Loader Delay (ms)', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::NUMBER,
					'min'   =>  0,
					'max'   =>  100000,
					'step'  =>  100,
					'default'   =>  800,
                    'condition' => [
                        'nekit_preloader_option!'    => 'none'
                    ],
                    'selectors' =>   [
                        '{{WRAPPER}} #nekit-preloader-elm i' => 'animation-delay: {{VALUE}}ms',
                        '{{WRAPPER}} #nekit-preloader-elm img' => 'animation-delay: {{VALUE}}ms'
                    ]
				]
			);

            $this->add_control(
                'nekit_preloader_animation_color',
                [
                    'label'	=>	esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::COLOR,
                    'selectors'	=>	 [
                        '{{WRAPPER}} .nekit-preloader-elm i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .nekit-preloader-elm .nekit-preload-circle' => 'border-top-color: {{VALUE}}',
                        '{{WRAPPER}} .nekit-preloader-elm .nekit-packman .packman-wrap::before, 
                            {{WRAPPER}} .nekit-preloader-elm .nekit-packman .packman-wrap::after,
                            {{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading:before, 
                            {{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading:after, 
                            {{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading
                         ' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading:before, 
                            {{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading:after, 
                            {{WRAPPER}} .nekit-preloader-elm .nekit-bar-loading, {{WRAPPER}} .nekit-preloader-elm .nekit-dot-wave-wrap .nekit-dot-wave, {{WRAPPER}} .nekit-preloader-elm .nekit-gooey-ball:before' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .nekit-preloader-elm .nekit-circle-loading-new' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .nekit-preloader-elm .nekit-circle-loading-new:before, {{WRAPPER}} .nekit-preloader-elm .nekit-circle-loading-new span:before' => 'border-right-color: {{VALUE}}; border-top-color: {{VALUE}}',
                            '{{WRAPPER}} .nekit-preloader-elm .nekit-circle-loading-new span:before' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .nekit-preloader-elm .nekit-bar-loader-new .nekit-bar-inner-loader, {{WRAPPER}} .nekit-preloader-elm .nekit-newtons-cradle__dot::after' => 'background-color: {{VALUE}}',


                    ],
                    'condition' => [
                        'nekit_preloader_option'    => ['animation','icon']
                    ]
                ]
            );

            $this->add_responsive_control(
				'nekit_preloader_animation_size',
				[
					'label' =>  esc_html__( 'Size', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::NUMBER,
					'min'   =>  1,
					'max'   =>  500,
					'step'  =>  1,
					'default'   =>  24,
                    'condition' => [
                        'nekit_preloader_option'    => ['icon']
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} #nekit-preloader-elm i'=> 'font-size: {{VALUE}}px; margin-left: calc(-{{VALUE}}px / 2); margin-top: calc(-{{VALUE}}px / 2)'
                        ]

				]
			);

            $this->add_responsive_control(
				'nekit_preloader_animation_image_width',
				[
					'label' =>  esc_html__( 'Image Width', 'news-kit-elementor-addons' ),
					'type'  =>  \Elementor\Controls_Manager::NUMBER,
					'min'   =>  1,
					'max'   =>  5000,
					'step'  =>  1,
                    'condition' => [
                        'nekit_preloader_option'    => 'image'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} #nekit-preloader-elm img'=> 'width: {{VALUE}}px; margin-left: calc(-{{VALUE}}px / 2); margin-top: calc(-{{VALUE}}px / 2)'
                        ]
				]
			);
            $this->end_controls_section();

            $this->start_controls_section(
                'nekit_preloader_background_section',
                [
                    'label' => esc_html__( 'Background & Transition', 'news-kit-elementor-addons' ),
                    'tab' => $this->get_id(),
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'      =>  'nekit_preloader_background',
                    'type'      =>  ['classical','gradient'],
                    'selector' 	=> '{{WRAPPER}} #nekit-preloader-elm'
                ]
            );

            $this->add_control(
                'nekit_preloader_transition_setting_heading',
                [
                    'label' => esc_html__( 'Transition', 'news-kit-elementor-addons' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
            );

            $this->add_control(
                'nekit_preloader_entrance_animation',
                [
                    'label'	=>	esc_html__( 'Entrance Animation', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'none',
                    'options'	=>	[
                        'none' => esc_html__('None', 'news-kit-elementor-addons'),
                        'fade-in'  => esc_html__( 'Fade In', 'news-kit-elementor-addons' ),
                        'fade-in-down'  => esc_html__( 'Fade In Down', 'news-kit-elementor-addons' ),
                        'fade-in-right'  => esc_html__( 'Fade In Right', 'news-kit-elementor-addons' ),
                        'fade-in-up'  => esc_html__( 'Fade In Up', 'news-kit-elementor-addons' ),
                        'fade-in-left'  => esc_html__( 'Fade In Left', 'news-kit-elementor-addons' ),
                        'zoom-in'  => esc_html__( 'Zoom In', 'news-kit-elementor-addons' ),
                        'slide-in-up'  => esc_html__( 'Slide In Up', 'news-kit-elementor-addons' ),
                        'slide-in-down'  => esc_html__( 'Slide In Down', 'news-kit-elementor-addons' ),
                        'slide-in-left'  => esc_html__( 'Slide In Left', 'news-kit-elementor-addons' ),
                        'slider-in-right'  => esc_html__( 'Slide In Right', 'news-kit-elementor-addons' )
                    ]
                ]
            );
            
            $this->add_control(
                'nekit_preloader_exit_animation',
                [
                    'label'	=>	esc_html__( 'Exit Animation', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'none',
                    'options'   =>  [
                        'none' => esc_html__('None', 'news-kit-elementor-addons'),
                        'fade-out'  => esc_html__( 'Fade Out', 'news-kit-elementor-addons' ),
                        'fade-out-down'  => esc_html__( 'Fade Out Down', 'news-kit-elementor-addons' ),
                        'fade-out-right'  => esc_html__( 'Fade Out Right', 'news-kit-elementor-addons' ),
                        'fade-out-up'  => esc_html__( 'Fade Out Up', 'news-kit-elementor-addons' ),
                        'fade-out-left'  => esc_html__( 'Fade Out Left', 'news-kit-elementor-addons' ),
                        'zoom-out'  => esc_html__( 'Zoom Out', 'news-kit-elementor-addons' ),
                        'slide-out-up'  => esc_html__( 'Slide Out Up', 'news-kit-elementor-addons' ),
                        'slide-out-down'  => esc_html__( 'Slide Out Down', 'news-kit-elementor-addons' ),
                        'slide-out-left'  => esc_html__( 'Slide Out Left', 'news-kit-elementor-addons' ),
                        'slider-out-right'  => esc_html__( 'Slide Out Right', 'news-kit-elementor-addons' ),

                    ]
                ]
            );

            $this->add_control(
                'nekit_preloader_preview_button',
                [
                    'type' => \Elementor\Controls_Manager::BUTTON,
                    'label_block' => true,
                    'show_label' => false,
                    'button_type' => 'default elementor-button-center',
                    'text' => esc_html__( 'Preview Loader', 'news-kit-elementor-addons' ),
                    'event' => 'nekitPreloader:preview'
                ]
            );
            $this->end_controls_section();
        }

        public function on_save( $data ) {
            if (
                ! isset( $data['settings']['post_status'] ) ||
                Document::STATUS_PUBLISH !== $data['settings']['post_status'] ||
                // Should check for the current action to avoid infinite loop
                strpos( current_action(), 'update_option_' ) === 0
            ) {
                return;
            }

            if ( isset( $data['settings']['nekit_preloader_option'] ) ) {
                update_option( 'nekit_preloader_option', $data['settings']['nekit_preloader_option'] );
            } else {
                update_option( 'nekit_preloader_option', 'none' );
            }

            if ( isset( $data['settings']['nekit_preloader_entrance_animation'] ) ) {
                update_option( 'nekit_preloader_entrance_animation', $data['settings']['nekit_preloader_entrance_animation'] );
            } else {
                update_option( 'nekit_preloader_entrance_animation', 'none' );
            }

            if ( isset( $data['settings']['nekit_preloader_exit_animation'] ) ) {
                update_option( 'nekit_preloader_exit_animation', $data['settings']['nekit_preloader_exit_animation'] );
            } else {
                update_option( 'nekit_preloader_exit_animation', 'none' );
            }
            
            if ( isset( $data['settings']['nekit_preloader_animation_type'] ) ) {
                update_option( 'nekit_preloader_animation_type', $data['settings']['nekit_preloader_animation_type'] );
            } else {
                update_option( 'nekit_preloader_animation_type', 'circle' );
            }

            if ( isset( $data['settings']['nekit_preloader_image_icon_animation_type'] ) ) {
                update_option( 'nekit_preloader_image_icon_animation_type', $data['settings']['nekit_preloader_image_icon_animation_type'] );
            } else {
                update_option( 'nekit_preloader_image_icon_animation_type', 'spinning' );
            }

            if ( isset( $data['settings']['nekit_preloader_icon'] ) ) {
                update_option( 'nekit_preloader_icon', $data['settings']['nekit_preloader_icon'] );
            } else {
                update_option( 'nekit_preloader_icon', [
                    'value' =>  'fas fa-spinner',
                    'library'   =>  'fa-solid'
                ]);
            }
            
            if ( isset( $data['settings']['nekit_preloader_image'] ) ) {
                update_option( 'nekit_preloader_image', $data['settings']['nekit_preloader_image'] );
            }
        }
    }
endif;