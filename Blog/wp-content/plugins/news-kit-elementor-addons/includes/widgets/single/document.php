<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Controls_Manager;
use Elementor\Plugin;

class Nekit_Document extends Elementor\Core\Base\Document {
	public function get_name() {
		return 'nekit-document';
	}
	
	public static function get_type() {
		return 'nekit-document';
	}
	
	public static function get_title() {
		if( get_post_meta( get_the_ID(), 'builder_type', true ) === 'popup-builder' ) :
			return esc_html__( 'Nekit Popup Builder', 'news-kit-elementor-addons' );
		else:
			return esc_html__( 'Nekit Theme Builder', 'news-kit-elementor-addons' );
		endif;
	}

	public function get_css_wrapper_selector() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return '.nekit-template-popup';
		} else {
			return '#nekit-popup-post-'. $this->get_main_id();
		}
	}

	/**
	 * Add custom classes
	 * @override
	 */
	public function get_container_attributes() {
		$attributes = parent::get_container_attributes();
		$is_popup_builder = ( get_post_meta( $this->get_main_id(), 'builder_type', true ) === 'popup-builder' );
		if( ! empty( $attributes ) && is_array( $attributes ) && $is_popup_builder ) :
			$elementor_classes = $attributes[ 'class' ];
			$nekit_custom_classes = ' nekit-popup nekit-scrollbar';
			$attributes[ 'class' ] = $elementor_classes . $nekit_custom_classes;
		endif;
		return $attributes;
	}

	/**
	 * Set route
	 * @override
	 */
	public static function get_editor_panel_config() {
		$default_route = ( get_post_meta( get_the_ID(), 'builder_type', true ) === 'popup-builder' ) ? 'panel/page-settings/settings' : 'panel/elements/categories';

		if ( ! Plugin::instance()->role_manager->user_can( 'design' ) ) {
			$default_route = 'panel/page-settings/settings';
		}

		return [
			'title' => static::get_title(), // JS Container title.
			'widgets_settings' => [],
			'elements_categories' => self::get_filtered_editor_panel_categories(),
			'default_route' => $default_route,
			'has_elements' => static::get_property( 'has_elements' ),
			'support_kit' => static::get_property( 'support_kit' ),
			'messages' => [
				'publish_notification' => sprintf(
					/* translators: %s: Document title. */
					esc_html__( 'Hurray! Your %s is live.', 'elementor' ),
					static::get_title()
				),
			],
			'show_navigator' => static::get_property( 'show_navigator' ),
			'allow_adding_widgets' => static::get_property( 'allow_adding_widgets' ),
			'show_copy_and_share' => static::get_property( 'show_copy_and_share' ),
			'library_close_title' => static::get_property( 'library_close_title' ),
			'publish_button_title' => static::get_property( 'publish_button_title' ),
			'allow_closing_remote_library' => static::get_property( 'allow_closing_remote_library' ),
		];
	}
	
	/**
	 * @override
	 */
	public static function get_properties() {
		$properties = parent::get_properties();
		$properties['support_kit'] = true;
		$properties['cpt'] = [ 'nekit-mm-cpt' ];
		return $properties;
	}

	function get_post_categories() {
		$base_categories = [];
		$categories = get_terms( [ 'taxonomy'	=>	'category', 'hide_empty'	=>	false] );
		if( !empty( $categories ) ) {
			foreach( $categories as $category ) {
				$base_categories[ $category->term_id ] = esc_html( $category->name ). ' ('.absint( $category->count ). ')';
			}
		}
		return $base_categories;
	}
	
	function get_post_tags() {
		$base_tags = [];
		$tags = get_terms( 'post_tag' );
		if( !empty( $tags ) ) {
			foreach( $tags as $tag ) {
				$base_tags[ $tag->term_id ] = esc_html( $tag->name ). ' ('.absint( $tag->count ). ')';
			}
		}
		return $base_tags;
	}

	function get_post_authors() {
		$base_authors = [];
		$admin_users = get_users(array( 'role__not_in' => 'subscriber', 'fields'  => array('ID','display_name')) );
		if( $admin_users ) {
			foreach( $admin_users as $admin_user ) {
				$base_authors[$admin_user->ID] = $admin_user->display_name;
			}
		}
		return $base_authors;
	}

	/**
	 * MARK: POPUP CONTROLS
	 * 
	 * @since 1.2.3
	 */
	protected function register_popup_builder_controls() {
		/* 
		* Settings
		* MARK: SETTINGS
		*/
		$this->start_controls_section(
			'nekit_popup_settings_section',
			[
				'label' => esc_html__( 'Settings', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_SETTINGS,
			]
		);
		
		$this->add_control(
			'nekit_open_popup',
			[
				'label' => esc_html__( 'Open Popup', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'page-load',
				'options' => apply_filters( 'nekit_filter_open_popup_methods', [
					'page-load' => esc_html__( 'On Page Load', 'news-kit-elementor-addons' ),
					'page-scroll' => esc_html__( 'On Page Scroll', 'news-kit-elementor-addons' )
				])
			]
		);

		$this->add_control(
			'nekit_to_show_after_scroll',
			[
				'label' => esc_html__( 'Scroll Progress (%)', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'max' => 100,
				'default' => 30,
				'description'	=>	esc_html__( 'Show popup after document is scrolled by 30%.', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'nekit_open_popup'	=>	'page-scroll'
				]
			]
		);

		$this->add_control(
			'nekit_element_id',
			[
				'label' => esc_html__( 'Element Selector', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description'	=>	esc_html__( 'ID attribute of the element with # infront of it.', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'nekit_open_popup'	=>	[ 'scroll-to-element', 'custom-trigger' ]
				]
			]
		);

		$this->add_control(
			'nekit_delay_after_page_load',
			[
				'label' => esc_html__( 'Delay After Page Load (Sec)', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'step' => 1,
				'default' => 1,
				'description'	=>	esc_html__( 'Zero to show immediately.', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'nekit_open_popup'	=>	[ 'page-load' ]
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_five',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'condition'	=>	[
					'nekit_open_popup'	=>	[ 'scroll-to-element', 'custom-trigger', 'page-scroll', 'page-load' ]
				]
			]
		);

		$this->add_control(
			'nekit_show_again_delay',
			[
				'label' =>  esc_html__( 'Show Again Delay', 'news-kit-elementor-addons' ),
				'type'  =>  'nekit-number-select-control',
				'default'   =>  [
					'number'	=>	1,
					'select'	=>	'minute'
				],
				'label_block'   =>  true,
				'options'   =>  [
					'none'	=>	esc_html__( 'Don\'t show again', 'news-kit-elementor-addons' ),
					'second'	=>	esc_html__( 'Seconds', 'news-kit-elementor-addons' ),
					'minute'	=>	esc_html__( 'Minute', 'news-kit-elementor-addons' ),
					'hour'	=>	esc_html__( 'Hour', 'news-kit-elementor-addons' ),
					'day'	=>	esc_html__( 'Day', 'news-kit-elementor-addons' )
				],
				'description'	=>	esc_html__( 'When to show the popup again.', 'news-kit-elementor-addons' ),
				'condition'	=>	[
					'nekit_open_popup!'	=>	[ 'custom-trigger', 'scroll-to-element' ]
				]
			]
		);

		$this->add_control(
			'nekit_popup_on_scroll',
			[
				'label' => esc_html__( 'Show on', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'every',
				'options' => [
					'every'  => esc_html__( 'Every Scroll', 'textdomain' ),
					'first' => esc_html__( 'First Scroll', 'textdomain' ),
					'odd' => esc_html__( 'Odd Scroll', 'textdomain' ),
					'even' => esc_html__( 'Even Scroll', 'textdomain' )
				],
				'condition'	=>	[
					'nekit_open_popup'	=>	[ 'scroll-to-element' ]
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_six',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'condition'	=>	[
					'nekit_open_popup!'	=>	[ 'custom-trigger' ]
				]
			]
		);

		$this->add_control(
			'nekit_popup_show_in_desktop',
			[
				'label' => esc_html__( 'Show in Desktop', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'nekit_popup_show_in_tablet',
			[
				'label' => esc_html__( 'Show in Tablet', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'nekit_popup_show_in_smartphone',
			[
				'label' => esc_html__( 'Show in Smartphone', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		apply_filters( 'nekit_add_popup_closing_options', $this );

		$this->add_control(
			'nekit_popup_divider_nine',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'condition'	=>	[
					'nekit_display_as!'	=>	'top-bar'
				]
			]
		);

		$this->add_control(
			'nekit_popup_zindex',
			[
				'label' => esc_html__( 'Z-index', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 1,
				'default' => 999,
				'selectors'	=>	[
					'{{WRAPPER}}'	=>	'z-index: {{VALUE}}'
				],
				'condition'	=>	[
					'nekit_display_as!'	=>	'top-bar'
				]
			]
		);

		$this->add_control(
			'nekit_popup_disable_page_scroll',
			[
				'label' => esc_html__( 'Disable Page Scroll', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=>	[
					'nekit_display_as!'	=>	'top-bar'
				]
			]
		);

		$this->end_controls_section();

		/* 
		* Layout
		* MARK: LAYOUT
		*/
		$this->start_controls_section(
			'nekit_popup_layout_section',
			[
				'label' => esc_html__( 'Layout', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_SETTINGS,
			]
		);

		$this->add_control(
			'nekit_display_as',
			[
				'label'	=>	esc_html__( 'Display As', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => 'modal',
				'options'   => [
					'modal'	=>	esc_html__( 'Modal Popup', 'news-kit-elementor-addons' ),
					'top-bar'	=>	esc_html__( 'Top Bar Banner', 'news-kit-elementor-addons' )
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_eight',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'nekit_popup_width',
			[
				'label' => esc_html__( 'Width', 'news-kit-elementor-addons' ),
				'size_units' => [ 'px', '%' ],
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-inner-container' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'	=>	[
					'nekit_display_as'	=>	'modal'
				]
			]
		);

		$this->add_control(
			'nekit_popup_height_select',
			[
				'label' => esc_html__( 'Height', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'auto' => esc_html__( 'Auto', 'news-kit-elementor-addons' ),
					'custom' => esc_html__( 'Custom', 'news-kit-elementor-addons' )
				],
				'default' => 'auto'
			]
		);

		$this->add_responsive_control(
			'nekit_popup_height',
			[
				'label' => esc_html__( 'Custom Height', 'news-kit-elementor-addons' ),
				'size_units' => [ 'px', '%' ],
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-inner-container .nekit-popup' => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'	=>	[
					'nekit_popup_height_select'	=>	'custom'
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_three',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'condition'	=>	[
					'nekit_display_as'	=>	'modal'
				]
			]
		);

		$this->add_control(
			'nekit_popup_horizontal_align',
			[
				'label' => esc_html__( 'Horizontal Align', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-container'  =>  'justify-content: {{VALUE}}'
				],
				'condition'	=>	[
					'nekit_display_as'	=>	'modal'
				]
			]
		);

		$this->add_control(
			'nekit_popup_vertical_align',
			[
				'label' => esc_html__( 'Vertical Align', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-middle'
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom'
					]
				],
				'default' => 'center',
				'toggle' => true,
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-popup-container'  =>  'align-items: {{VALUE}}'
				],
				'condition'	=>	[
					'nekit_display_as'	=>	'modal'
				]
			]
		);

		$this->add_control(
			'nekit_popup_content_align',
			[
				'label' => esc_html__( 'Content Align', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-middle'
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom'
					]
				],
				'default' => 'middle',
				'toggle' => true,
				'selectors'	=>	[
					'{{WRAPPER}} .popup-wrapper'  =>  'align-items: {{VALUE}}'
				],
				'condition'	=>	[
					'nekit_display_as'	=>	'modal'
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_four',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		apply_filters( 'nekit_popup_layout_settings_tab', $this );

		$this->end_controls_section();

		/**
		 * MARK: SETTINGS CLOSE BUTTON
		 */
		$this->start_controls_section(
			'nekit_popup_close_button',
			[
				'label' => esc_html__( 'Close Button', 'news-kit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$this->add_control(
			'nekit_popup_close_button_display',
			[
				'label' => esc_html__( 'Show Close Button', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none;',
					'yes' => 'display: block;'
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-close' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nekit_popup_close_button_display_delay',
			[
				'label' => esc_html__( 'Show Up Delay (sec)', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'condition' => [
					'nekit_popup_close_button_display' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'nekit_popup_close_button_position_vertical',
			[
				'label' => esc_html__( 'Vertical Position', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-close' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'nekit_popup_close_button_display' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'nekit_popup_close_button_position_horizontal',
			[
				'label' => esc_html__( 'Horizontal Position', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-close' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'nekit_popup_close_button_display' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		/* 
		* OVERLAY SETTINGS
		* MARK: OVERLAY SETTINGS
		*/
		$this->start_controls_section(
			'nekit_popup_overlay_settings_section',
			[
				'label' => esc_html__( 'Overlay', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_SETTINGS,
				'condition'	=>	[
					'nekit_display_as!'	=>	'top-bar'
				]
			]
		);

		$this->add_control(
			'nekit_popup_enable_overlay',
			[
				'label' => esc_html__( 'Enable Overlay', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none;',
					'yes' => 'display: block;'
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-overlay' => '{{VALUE}}',
				]
			]
		);

		apply_filters( 'nekit_popup_overlay_settings_tab', $this );

		$this->end_controls_section();

		/* 
		* Popup
		* MARK: POPUP
		*/
		$this->start_controls_section(
			'nekit_popup_popup_section',
			[
				'label' => esc_html__( 'Popup', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'nekit_popup_background',
				'types' => [ 'classic', 'gradient' ],
				'fields_options'	=>	[
					'background'	=>	[
						'default'	=>	'classic'
					],
					'color'	=>	[
						'default'	=>	'#fff'
					]
				],
				'selector' => '{{WRAPPER}} .nekit-popup-wrap'
			]
		);

		$this->add_control(
			'nekit_scrollbar_color',
			[
				'label' => esc_html__( 'Scroll Bar Control', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nekit-popup.nekit-scrollbar::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_one',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'nekit_popup_padding',
			[
				'label' => esc_html__( 'Padding', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-popup'	=>	'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'nekit_popup_border_radius',
			[
				'label' => esc_html__( 'Border Radius (Px)', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors'	=>	[
					'{{WRAPPER}} .nekit-popup-wrap'	=>	'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'nekit_popup_divider_two',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nekit_popup_border',
				'selector' => '{{WRAPPER}} .nekit-popup'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'nekit_popup_box_shadow',
				'selector' => '{{WRAPPER}} .nekit-popup-wrap'
			]
		);

		$this->end_controls_section();

		/* 
		* Overlay
		* MARK: OVERLAY
			*/
		$this->start_controls_section(
			'nekit_popup_overlay_style_section',
			[
				'label' => esc_html__( 'Overlay', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=>	[
					'nekit_display_as!'	=>	'top-bar'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'nekit_popup_overlay',
				'types' => [ 'classic', 'gradient' ],
				'fields_options'	=>	[
					'background'	=>	[
						'default'	=>	'classic'
					],
					'color'	=>	[
						'default'	=>	'#02020294'
					]
				],
				'selector'	=>	'{{WRAPPER}} .nekit-popup-container .nekit-popup-overlay'
			]
		);

		$this->end_controls_section();

		/* 
		* Close Button
		* MARK: CLOSE BUTTON
		*/
		$this->start_controls_section(
			'nekit_popup_close_button_style_section',
			[
				'label' => esc_html__( 'Close Button', 'news-kit-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs( 'nekit_popup_close_button_tabs' );

			$this->start_controls_tab(
				'nekit_popup_close_button_initial',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);

			$this->add_control(
				'nekit_color_button_color',
				[
					'label'  => esc_html__( 'Color', 'news-kit-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .nekit-popup-close span.dashicons' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'nekit_popup_close_button_background_color',
				[
					'label'  => esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fa5900',
					'selectors' => [
						'{{WRAPPER}} .nekit-popup-close' => 'background-color: {{VALUE}}',
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'nekit_popup_close_button_initial_border',
					'selector' => '{{WRAPPER}} .nekit-popup-close',
					'fields_options' => [
						'border' => [
							'default' => 'none'
						]
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'nekit_popup_close_button_box_shadow',
					'selector' => '{{WRAPPER}} .nekit-popup-close',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'nekit_popup_close_button_hover',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);

			$this->add_control(
				'nekit_popup_close_button_hover_color',
				[
					'label'  => esc_html__( 'Color', 'news-kit-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nekit-popup-close:hover span.dashicons' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'nekit_popup_close_button_background_color_hover',
				[
					'label'  => esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nekit-popup-close:hover' => 'background-color: {{VALUE}}',
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'nekit_popup_close_button_hover_border',
					'selector' => '{{WRAPPER}} .nekit-popup-close:hover'
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'nekit_popup_close_button_size',
			[
				'label' => esc_html__( 'Size', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-close span.dashicons'	=>	'font-size: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$this->add_control(
			'nekit_popup_close_button_box_size',
			[
				'label' => esc_html__( 'Box Size', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-close' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .nekit-popup-close span.dashicons' => 'padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-popup-close span.dashicons' => 'line-height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'popup_close_button_radius',
			[
				'label' => esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-popup-container .nekit-popup-inner-container .nekit-popup-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		if( get_post_meta( $this->get_main_id(), 'builder_type', true ) === 'popup-builder' ) :
			$this->register_popup_builder_controls();
		else:
			if( get_post_meta( $this->get_main_id(), 'builder_type', true ) == 'archive-builder' ) {
				$pages_args = [
					'recent-posts'  => esc_html__( 'Recent posts', 'news-kit-elementor-addons' ),
					'date-archives' => esc_html__( 'Date Archives', 'news-kit-elementor-addons' ),
					'author-archives'   => esc_html__( 'Author Archives', 'news-kit-elementor-addons' ),
					'categories-archives'=> esc_html__( 'Categories Archives', 'news-kit-elementor-addons' ),
					'tags-archives' => esc_html__( 'Tags Archives', 'news-kit-elementor-addons' ),
					'search-results'    => esc_html__( 'Search Results', 'news-kit-elementor-addons' )
				];
			} else {
				$pages_args = [
					'posts'  => esc_html__( 'Posts', 'news-kit-elementor-addons' ),
					'pages'  => esc_html__( 'Pages', 'news-kit-elementor-addons' )
				];
			}
			/**
			 * MARK: NEWS ELEMENTOR PREVIEW
			 */
			$this->start_controls_section(
				'nekit_preview_section',
				[
					'label' => esc_html__( 'News Elementor Preview Settings', 'news-kit-elementor-addons' ),
					'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
				]
			);
	
			$this->add_control(
				'nekit_preview_page',
				[
					'label' => esc_html__( 'Preview archive page', 'news-kit-elementor-addons' ),
					'type'  => \Elementor\Controls_Manager::SELECT,
					'default'   => ( get_post_meta( $this->get_main_id(), 'builder_type', true ) == 'archive-builder' ) ? 'recent-posts': 'posts',
					'label_block'   => true,
					'options'   => $pages_args
				]
			);
	
			$this->add_control(
				'nekit_archive_preview_author',
				[
					'label' => esc_html__( 'Preview archive page', 'news-kit-elementor-addons' ),
					'show_label'    => false, 
					'type'  => \Elementor\Controls_Manager::SELECT,
					'default'   => '',
					'label_block'   => true,
					'options'   => $this->get_post_authors(),
					'condition' => [
						'nekit_preview_page'    => 'author-archives'
					]
				]
			);
	
			$this->add_control(
				'nekit_archive_preview_category',
				[
					'label' => esc_html__( 'Preview category page', 'news-kit-elementor-addons' ),
					'show_label'    => false, 
					'type'  => \Elementor\Controls_Manager::SELECT,
					'default'   => '',
					'label_block'   => true,
					'options'   => $this->get_post_categories(),
					'condition' => [
						'nekit_preview_page'    => 'categories-archives'
					]
				]
			);
	
			$this->add_control(
				'nekit_archive_preview_tag',
				[
					'label' => esc_html__( 'Preview tag page', 'news-kit-elementor-addons' ),
					'show_label'    => false, 
					'type'  => \Elementor\Controls_Manager::SELECT,
					'default'   => '',
					'label_block'   => true,
					'options'   => $this->get_post_tags(),
					'condition' => [
						'nekit_preview_page'    => 'tags-archives'
					]
				]
			);
	
			$this->add_control(
				'nekit_archive_preview_search',
				[
					'label' => esc_html__( 'Search Term', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'news', 'news-kit-elementor-addons' ),
					'placeholder' => esc_html__( 'Type your search keyword . .', 'news-kit-elementor-addons' ),
					'condition' => [
						'nekit_preview_page' => 'search-results',
					]
				]
			);
	
			$this->add_control(
				'nekit_single_preview_post',
				[
					'label'	=> esc_html__( 'Post', 'news-kit-elementor-addons' ),
					'label_block'	=> true,
					'type' => 'nekit-select2-extend',
					'options'	=> 'select2extend/get_posts_by_post_type',
					'query_slug'	=> 'post',
					'condition' => [
						'nekit_preview_page' => 'posts',
					]
				]
			);
	
			$this->add_control(
				'nekit_single_preview_page',
				[
					'label'	=> esc_html__( 'Page', 'news-kit-elementor-addons' ),
					'label_block'	=> true,
					'type' => 'nekit-select2-extend',
					'options'	=> 'select2extend/get_posts_by_post_type',
					'query_slug'	=> 'page',
					'condition' => [
						'nekit_preview_page' => 'pages',
					]
				]
			);
	
			$this->add_control(
				'preview_settings_actions',
				[
					'label' => esc_html__( 'Save Settings', 'news-kit-elementor-addons' ),
					'show_label'	=> false,
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<div class="nekit-save-preview-settings">' .esc_html__( "Save and Preview", "news-kit-elementor-addons" ). '</div>',
					'content_classes' => 'nekit-button-actions'
				]
			);
			$this->end_controls_section();
			
			// Default Document Settings
		endif;
		parent::register_controls();
	}

	public function get_tax_query_args( $tax, $terms ) {
		$terms = empty($terms) ? [ 'all' ] : $terms;
		$args = [
			'tax_query' => [
				[
					'taxonomy' => $tax,
					'terms' => $terms,
					'field' => 'term_id',
				],
			],
		];

		return $args;
	}

	public function get_document_query_args() {
		$settings = $this->get_settings();
		$args = false;
		if( get_post_meta( $this->get_main_id(), 'builder_type', true ) !== 'popup-builder' ) :
			$source = $settings['nekit_preview_page'];
			// Default Archives
			switch ( $source ) {
				case 'recent-posts': $args = [ 
											'post_type' => 'post'
										];
									break;
				case 'categories-archives': 
					$args = $this->get_tax_query_args( 'category', $settings['nekit_archive_preview_category'] );
									break;
				case 'tags-archives': $args = $this->get_tax_query_args( 'post_tag', $settings['nekit_archive_preview_tag'] );
									break;
				case 'date-archives': $args = [
											'year'	=>	date('Y')
				];
									break;
				case 'author-archives': $args = [ 
											'author' => $settings['nekit_archive_preview_author']
										];
									break;
				case 'search-results':  $args = [ 
											's' => $settings['nekit_archive_preview_search']
										];
									break;
				case 'pages':  // Get Post
								$page = get_posts( [
									'post_type' => 'page',
									'numberposts' => 1,
									'orderby' => 'date',
									'order' => 'DESC',
									'suppress_filters' => false,
								]);
								$args = [ 'post_type' => 'page' ];
					
								// Last Post for Single Pages
								if( isset( $settings['nekit_single_preview_page'] ) && $settings['nekit_single_preview_page'] ) {
									$args['p'] = $settings['nekit_single_preview_page'];
								} else if ( ! empty( $post ) ) {
									$args['p'] = $post[0]->ID;
								}
							break;
			}

			// Default
			if ( false === $args ) {
				// Get Post
				$post = get_posts( [
					'post_type' => 'post',
					'numberposts' => 1,
					'orderby' => 'date',
					'order' => 'DESC',
					'suppress_filters' => false
				]);
				$args = [ 'post_type' => 'post' ];

				// last post for single pages
				if( isset( $settings['nekit_single_preview_post'] ) && $settings['nekit_single_preview_post'] ) {
					$args['p'] = $settings['nekit_single_preview_post'];
				} else if ( ! empty( $post ) ) {
					$args['p'] = $post[0]->ID;
				}
			}
		endif;

		return $args;
	}

	public function switch_to_preview_query() {
		if ( 'nekit-mm-cpt' === get_post_type( $this->get_main_id() ) ) {
			$document = Elementor\Plugin::instance()->documents->get_doc_or_auto_save( $this->get_main_id() );
			Elementor\Plugin::instance()->db->switch_to_query( $document->get_document_query_args() );
		}
	}

	public function get_content( $with_css = false ) {
		$this->switch_to_preview_query();
		$content = parent::get_content( $with_css );
		Elementor\Plugin::instance()->db->restore_current_query();
		return $content;
	}

	public function print_content() {
		$plugin = Plugin::elementor();

		if ( $plugin->preview->is_preview_mode( $this->get_main_id() ) ) {
			echo ''. wp_kses_post( $plugin->preview->builder_wrapper( '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo ''. wp_kses_post( $this->get_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	public static function get_preview_as_default() {
		return '';
	}

	public static function get_preview_as_options() {
		return [];
	}
	
	public function get_elements_raw_data( $data = null, $with_html_content = false ) {
		$this->switch_to_preview_query();

		$editor_data = parent::get_elements_raw_data( $data, $with_html_content );

		Elementor\Plugin::instance()->db->restore_current_query();

		return $editor_data;
	}

	public function render_element( $data ) {
		$this->switch_to_preview_query();
		$render_html = parent::render_element( $data );

		Elementor\Plugin::instance()->db->restore_current_query();

		return $render_html;
	}
}