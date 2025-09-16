<?php
/**
 * Plugin admin class
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace News_Kit_Elementor_Addons_Admin;
use Nekit_Utilities;
use News_Kit_Elementor_Addons_Library;
use WP_Ajax_Upgrader_Skin;
use Plugin_Upgrader;
use Nekit_Popup_Builder;

class Admin {
	public $ajax_response = [];
    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     * @var \Elementor_Test_Addon\Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Active tab
	 *
	 * @since 1.0.0
	 * @var string current builder tab.
	 */
	public $current_tab = 'header-builder';
    
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     * @return \Elementor_Test_Addon\Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		if ( ! $this->is_compatible() ) return;
		$this->current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'header-builder';
        add_action( 'admin_menu', [$this,'menu_page'] );
		add_action( 'admin_enqueue_scripts', [$this,'handle_scripts'] );
		add_filter( 'option_elementor_cpt_support', [$this,'add_mega_menu_cpt_support'] );
		add_filter( 'default_option_elementor_cpt_support', [$this,'add_mega_menu_cpt_support'] );
		add_action( 'init', [$this,'register_custom_post_types'] );
		add_action( 'wp_ajax_nekit_render_mega_menu_modal', [ $this, 'render_mega_menu_modal' ] );
		add_action( 'wp_ajax_nekit_update_mega_menu_option_val', [ $this, 'update_mega_menu_option_val' ] );
		add_action( 'wp_ajax_nekit_update_mega_menu_form', [ $this, 'update_mega_menu_form' ] );
		add_action( 'wp_ajax_nekit_create_template_action', [ $this, 'create_template_action' ] );
		add_action( 'wp_ajax_nekit_update_templates_meta_action', [ $this, 'update_templates_meta_action' ] );
		add_action( 'wp_ajax_nekit_delete_template_action', [ $this, 'delete_template_action' ] );
		add_action( 'wp_ajax_nekit_import_template_action', [ $this, 'import_template_action' ] );
		add_action( 'wp_ajax_nekit_install_importer', [ $this, 'install_importer' ] );
		add_action( 'wp_ajax_nekit_404_builder_active', [ $this, 'nekit_404_builder_active' ] );
		add_action( 'wp_ajax_nekit_builder_active', [ $this, 'nekit_builder_active' ] );
		add_action( 'wp_ajax_nekit_widgets_enable_disable_ajax_call', [ $this, 'nekit_widgets_enable_disable_ajax_call' ] );
		add_action( 'in_admin_header', [ $this, 'nekit_admin_header' ] );
	}

    /**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function is_compatible() {
		
        // Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			return false;
		}
		
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			return false;
		}
		
		return true;
	}

    /**
	 * register a custom admin menu page.
	 * 
	 * MARK: MENU AND SUBMENU PAGES
	 */
    function menu_page() {
        add_menu_page(
            __( 'News Kit', 'news-kit-elementor-addons' ),
            __( 'News Kit', 'news-kit-elementor-addons' ),
            'manage_options',
            'news-kit-elementor-addons',
            [$this,'admin_page_callback'],
            plugins_url( '/assets/images/nekit-logo-new.png', __FILE__ ),
            6
        );
        add_submenu_page(
			'news-kit-elementor-addons',
            __( 'Pre-made Blocks', 'news-kit-elementor-addons' ),
            __( 'Pre-made Blocks', 'news-kit-elementor-addons' ),
            'manage_options',
            'news-kit-elementor-addons-pre-made-blocks',
            [$this,'admin_pre_made_blocks_callback'],
        );
		add_submenu_page(
			'news-kit-elementor-addons',
			__( 'Theme Builder', 'news-kit-elementor-addons' ),
			__( 'Theme Builder', 'news-kit-elementor-addons' ),
			'manage_options',
			'news-kit-elementor-addons-theme-builder',
			[$this,'admin_page_theme_builder_callback']
		);
		add_submenu_page(
			'news-kit-elementor-addons',
			__( 'Popup Builder', 'news-kit-elementor-addons' ),
			__( 'Popup Builder', 'news-kit-elementor-addons' ),
			'manage_options',
			'news-kit-elementor-addons-popup-builder',
			[$this,'admin_page_popup_builder_callback']
		);
		add_submenu_page(
			'news-kit-elementor-addons',
			__( 'Starter Sites', 'news-kit-elementor-addons' ),
			__( 'Starter Sites', 'news-kit-elementor-addons' ),
			'manage_options',
			'news-kit-elementor-addons-starter-sites',
			[$this,'admin_page_starter_sites_callback']
		);
		add_submenu_page(
			'news-kit-elementor-addons',
			__( 'Settings', 'news-kit-elementor-addons' ),
			__( 'Settings', 'news-kit-elementor-addons' ),
			'manage_options',
			'news-kit-elementor-addons-settings',
			[$this,'admin_page_settings_callback']
		);
    }

	/**
	 * renders the admin theme builder content
	 * 
	 * MARK: THEME BUILDER
	 */
	function admin_page_theme_builder_callback() {
		$tab = $this->current_tab;
		?>
			<div id="nekit-admin-page">
				<div class="page-header">
					<h2 class="page-title"><?php echo esc_html__( 'News Kit Elementor Addons', 'news-kit-elementor-addons' ); ?></h2>
					<p><?php echo esc_html__( 'Manage news addon builder settings', 'news-kit-elementor-addons' ); ?></p>
					<button class="video-redirect-button nekit-admin-button"><a href="https://www.youtube.com/watch?v=AhNQasgJ-AI&list=PLUhfyaBfMJ4k0ed1VNX48SqxNI0TuaCV4" target="_blank"><?php echo esc_html__( 'How Does Builder Works?', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
				</div>
				<div class="page-content">
					<ul class="tabs-title-wrap">
						<li class="tab-title<?php if($tab == 'header-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'header-builder' ) ); ?>"><?php echo esc_html__( 'Header', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == 'single-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'single-builder' ) ); ?>"><?php echo esc_html__( 'Single', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == 'archive-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'archive-builder' ) ); ?>"><?php echo esc_html__( 'Archive', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == 'footer-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'footer-builder' ) ); ?>"><?php echo esc_html__( 'Footer', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == '404-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', '404-builder' ) ); ?>"><?php echo esc_html__( '404', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == 'saved-templates') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'saved-templates' ) ); ?>"><?php echo esc_html__( 'Saved Templates', 'news-kit-elementor-addons' ); ?></a></li>
						<li class="tab-title<?php if($tab == 'mega-menu-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'mega-menu-builder' ) ); ?>"><?php echo esc_html__( 'Mega Menu', 'news-kit-elementor-addons' ); ?></a></li>
					</ul>
					<div class="<?php echo esc_attr( str_replace( '404', 'error-page', $tab ) ); ?>-tabs-content">
					<?php
						switch($tab) {
							case 'mega-menu-builder': ?>
									<div class="tab-content-header">
										<h2 class="tab-header-title"><?php echo esc_html__( 'How to create Mega Menu with News Kit Elementor Addons', 'news-kit-elementor-addons' ); ?></h2>
										<button class="video-redirect-button"><a href="<?php echo esc_url('https://youtu.be/hrGdMMLqkEw?list=PLUhfyaBfMJ4k0ed1VNX48SqxNI0TuaCV4'); ?>" target="_blank"><?php echo esc_html__( 'Video Tutorial', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
									</div>
									<div class="tab-content-body">
									</div>
			<?php
								break;
							case 'saved-templates': ?>
									<div class="tab-content-header">
										<button class="show-create-template-form"><?php echo esc_html__( 'Create New Template', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-plus-alt2"></span></a></button>
									</div>
									<div class="tab-content-body">
										<div class="template-list" data-template="<?php echo esc_attr($tab); ?>">
											<?php
												$saved_templates = nekit_get_builders($tab);
												if( $saved_templates ) :
													foreach( $saved_templates as $saved_template ) :
														$template_id = $saved_template['id'];
														$template_title = $saved_template['title'];
														?>
															<div class="template-list-item" data-template="<?php echo absint($template_id); ?>">
																<h2 class="template-title"><?php echo esc_html($template_title); ?></h2>
																<button class="edit-template" data-template="<?php echo absint($template_id); ?>"><a href="<?php echo esc_url( add_query_arg( [ 'post' => absint($template_id), 'action' => 'elementor' ], admin_url( 'post.php') ) ); ?>" target="_blank"><?php echo esc_html__( 'Edit Template', 'news-kit-elementor-addons' ); ?></a></button>
																<button class="show-delete-template-form" data-template-id="<?php echo absint($template_id); ?>" ><span class="dashicons dashicons-trash"></span></button>
															</div>
															<?php
													endforeach;
												else : ?>
													<div class="tab-content-item empty-field">
														<?php echo esc_html( sprintf( /* translators: %1s: Tab name */ esc_html__( 'You have not created any %1s templates yet!', 'news-kit-elementor-addons' ), esc_html( $tab ) ) ); ?>
													</div>
													<?php
												endif;
											?>
										</div>
									</div>
			<?php
								break;
							default: 
						?>
								<div class="tab-content-header">
									<button class="show-create-template-form"><?php echo esc_html( sprintf( /* translators: %1s: Template name */ esc_html__( 'Create %1s Template', 'news-kit-elementor-addons' ), esc_html( str_replace( '-builder', '', $tab ) ) ) ); ?><span class="dashicons dashicons-plus-alt2"></span></button>
								</div>
								<div class="tab-content-body"><?php $this->print_template_list(str_replace( '-builder', '', $tab )); ?></div>
						<?php } ?>
					</div>
				</div>
				<div id="nekit-create-template-modal" class="nekit-admin-modal" data-template="<?php echo esc_attr($tab) ?>">
					<div class="nekit-template-modal-inner">
						<span class="nekit-modal-close dashicons dashicons-no-alt"></span>
						<div class="header">
							<h2 class="modal-title">
								<?php
									switch($tab) {
										case '404-builder': echo esc_html__( 'New 404 Template', 'news-kit-elementor-addons' );
															break;
										case 'footer-builder': echo esc_html__( 'New Footer Template', 'news-kit-elementor-addons' );
															break;
										case 'single-builder': echo esc_html__( 'New Single Template', 'news-kit-elementor-addons' );
															break;
										case 'archive-builder': echo esc_html__( 'New Archive Template', 'news-kit-elementor-addons' );
															break;
										case 'saved-templates': echo esc_html__( 'New Template', 'news-kit-elementor-addons' );
															break;
										default: echo esc_html__( 'New Header Template', 'news-kit-elementor-addons' );
									}
								?>
							</h2>
							<?php
								if( $tab == 'saved-templates' ) {
									$modal_desc = esc_html__( 'Templates gives you choices of different layouts on your websites. You can choose these templates from Canvas Menu widget from elementor edit screen', 'news-kit-elementor-addons' );
								} else {
									$modal_desc = esc_html__( 'Templates gives you choices of different layouts on your websites. You can choose different templates for different pages for different period of time', 'news-kit-elementor-addons' );
								}
							?>
							<p class="modal-sub-title"><?php echo esc_html( $modal_desc ); ?></p>
						</div>
						<div class="body">
							<input type="text" name="template-name" placeholder="<?php echo esc_html__( 'Add Template Name', 'news-kit-elementor-addons' ); ?>">
						</div>
						<div class="footer">
							<button class="create-new-template"><?php echo esc_html__( 'Create Template', 'news-kit-elementor-addons' ); ?></button>
							<form id="nekit-builder-create-form" method="POST">
								<input type="hidden" name="condition_id">
								<?php wp_nonce_field( 'nekit_admin_submit_builder_creation_action', 'nekit_admin_form_nonce' ); ?>
							</form>
						</div>
					</div>
				</div>
				<div id="nekit-delete-template-modal" class="nekit-admin-modal" data-template="<?php echo esc_attr($tab) ?>">
					<div class="nekit-template-modal-inner">
						<span class="nekit-modal-close dashicons dashicons-no-alt"></span>
						<div class="header">
							<h2 class="modal-title">
								<?php 
									switch($tab) {
										case '404-builder': echo esc_html__( 'Are you sure you want to delete this 404 template', 'news-kit-elementor-addons' );
															break;
										case 'footer-builder': echo esc_html__( 'Are you sure you want to delete this footer template', 'news-kit-elementor-addons' );
															break;
										case 'single-builder': echo esc_html__( 'Are you sure you want to delete this single template', 'news-kit-elementor-addons' );
															break;
										case 'archive-builder': echo esc_html__( 'Are you sure you want to delete this archive template', 'news-kit-elementor-addons' );
															break;
										case 'saved-templates': echo esc_html__( 'Are you sure you want to delete this saved template', 'news-kit-elementor-addons' );
															break;
										default: echo esc_html__( 'Are you sure you want to delete this header template', 'news-kit-elementor-addons' );
									}
								?>
							</h2>
							<p class="modal-sub-title"><?php echo esc_html__( 'You cannot revert this process', 'news-kit-elementor-addons' ); ?></p>
						</div>
						<div class="footer">
							<button class="delete-old-template"><?php echo esc_html__( 'Delete', 'news-kit-elementor-addons' ); ?> <span class="dashicons dashicons-trash"></span></button>
							<button class="cancel-delete-old-template"><?php echo esc_html__( 'Cancel', 'news-kit-elementor-addons' ); ?> <span class="dashicons dashicons-marker"></span></button>
						</div>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * renders the sub menu page content
	 * 
	 * MARK: PRE-MADE BLOCKS
	 */
	function admin_pre_made_blocks_callback() {
		?>
			<div id="nekit-sub-admin-page" class="nekit-templates-list">
				<div class="page-header">
					<h2 class="page-title"><?php echo esc_html__( 'Pre-made Blocks', 'news-kit-elementor-addons' ); ?></h2>
					<p><?php echo esc_html__( 'Preview and Import all the pre-made blocks.', 'news-kit-elementor-addons' ); ?></p>
					<button class="video-redirect-button nekit-admin-button"><a href="<?php echo esc_url('https://www.youtube.com/watch?v=LFD5KtXVXrc'); ?>" target="_blank"><?php echo esc_html__( 'How to use pre-made blocks', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
				</div>
				<div class="page-content">
					<div class="nekit-library-popup library-popup-inner pre-built-block-wrap">
						<div class="templates-tab-content">
							<div class="inner-tab-content blocks-tab-content">
								<div class="filter-tab-search-wrap">								
									<div class="widgets-category-title-filter">
										<div class="active-filter"><span class="filter-text"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ) ?></span><span class="dashicons dashicons-arrow-down-alt2"></span></div>
										<ul class="filter-list">
											<li class="filter-tab active" data-value="all">
												<span class="tab-label"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></span>
												<div class="count-wrapper">
													<span class="count free-count"></span>
													<span class="count pro-count"></span>
												</div>
											</li>
											<?php
												$widget_list = \Nekit_Utilities\Utils::get_registered_widgets_with_demo();
												$widgets_for_option = [];
												if( $widget_list ) :
													foreach( $widget_list as $widget ) :
														$widgets_for_option[$widget['category']] = esc_html( str_replace( '-', ' ', $widget['category'] ) );
													endforeach;
												endif;
												if( $widgets_for_option ) :
													foreach( $widgets_for_option as $option_key => $option ) :
														?>
															<li class="filter-tab" data-value="<?php echo esc_attr( $option_key ); ?>">
																<span class="tab-label"><?php echo esc_html( $option ); ?></span>
																<div class="count-wrapper">
																	<span class="count free-count"></span>
																	<span class="count pro-count"></span>
																</div>
															</li>
														<?php
													endforeach;
												endif;
											?>
										</ul>
									</div>
									<div class="free-pro-filter-tabs">
										<button class="filter-tab free"><?php echo esc_html__( 'Free', 'news-kit-elementor-addons' ); ?></button>
										<button class="filter-tab pro"><?php echo esc_html__( 'Pro', 'news-kit-elementor-addons' ); ?></button>
										<button class="filter-tab both active"><?php echo esc_html__( 'Free & Pro', 'news-kit-elementor-addons' ); ?></button>
									</div>
									<div class="search-wrapper">
										<input value="" type="search" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>">
										<span class="dashicons dashicons-search"></span>
									</div>
								</div>
								<div class="tab-blocks-list-wrap">
									<div class="tab-blocks-list widgets-blocks-library">
										<div class="grid-sizer"></div>
										<?php
											$widgets_demos = Nekit_Utilities\Utils::library_widgets_data();
											$widgets_demos = json_decode($widgets_demos);
											if( $widgets_demos && is_array($widgets_demos) ) :
												foreach( $widgets_demos as $widget_demo ) :
													$filter_attr = 'all ' . $widget_demo->type;
													$filter_attr .= ' ';
													$filter_attr .= is_array( $widget_demo->category ) ? implode( " ", $widget_demo->category ) : $widget_demo->category;
													?>
														<figure class="template-item <?php echo esc_attr( $filter_attr ); ?>">
															<a href="<?php echo esc_url($widget_demo->preview_url); ?>" target="_blank"><img src="<?php echo esc_url($widget_demo->preview_image); ?>" loading="lazy" /></a>
															<div class="button-actions">
																<span class="widget-name block-label"><?php echo esc_html( $widget_demo->name ); ?></span>
																<a class="preview-demo" href="<?php echo esc_url( $widget_demo->preview_url); ?>" target="_blank"><?php echo esc_html__( 'Preview', 'news-kit-elementor-addons' ); ?> <span class="dashicons dashicons-visibility"></span></a>
															</div>
														</figure>
													<?php
												endforeach;
											endif;
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * renders the settings page
	 * 
	 * MARK: SETTINGS
	 */
	function admin_page_settings_callback() {
		if( $this->current_tab === 'freevspro' ) :
			echo 'Free Vs Pro';
		else:
			if( isset($_POST['nekit_submit']) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'nekit-admin-setting-form-nonce') ) :
				$nekit_youtube_api_key = isset($_POST['nekit_youtube_api_key']) ? sanitize_text_field( wp_unslash( $_POST['nekit_youtube_api_key'] ) ): '';
				nekit_update_settings([
					'key'	=> 'nekit_youtube_api_key',
					'value'	=> esc_html( $nekit_youtube_api_key )
				]);
			else :
				$nekit_youtube_api_key = nekit_get_settings([
					'key'	=> 'nekit_youtube_api_key'
				]);
			endif;
			?>
				<div id="nekit-sub-admin-page" class="nekit-admin-setting-page">
					<div class="page-header">
						<h2 class="page-title"><?php echo esc_html__( 'Settings', 'news-kit-elementor-addons' ); ?></h2>
						<p><?php echo esc_html__( 'Manage the general settings of the plugin. You can store API keys, category colors and other global settings', 'news-kit-elementor-addons' ); ?></p>
						<button class="video-redirect-button nekit-admin-button"><a href="<?php echo esc_url( 'https://www.youtube.com/' ); ?>" target="_blank"><?php echo esc_html__( 'Youtube API keys', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
					</div>
					<div class="page-content">
						<form id="nekit-admin-setting-form" method="POST">
							<?php wp_nonce_field('nekit-admin-setting-form-nonce'); ?>
							<div class="form-body">
								<div class="form-field-wrap">
									<label for="nekit_youtube_api_key" class="form-label"><?php esc_html_e( 'Youtube API Key', 'news-kit-elementor-addons' ); ?></label>
									<p class="form-description"><?php esc_html_e( 'In order to display pro per title and video duration api key is required. Please go throught this url to know how to generate api key ', 'news-kit-elementor-addons' ); ?><a href="<?php echo esc_url( 'https://blog.hubspot.com/website/how-to-get-youtube-api-key' ); ?>" target="_blank"><?php echo esc_html__( 'here', 'news-kit-elementor-addons' ); ?></a></p>
									<input type="text" class="form-field" name="nekit_youtube_api_key" placeholder="<?php esc_html_e( 'Please add valid youtube API key', 'news-kit-elementor-addons' ); ?>" value="<?php echo esc_html( $nekit_youtube_api_key ); ?>">
								</div>
							</div>
							<div class="form-footer">
								<div class="form-field-wrap">
									<button class="form-field nekit-admin-button" type="submit" name="nekit_submit"><?php esc_html_e( 'Save settings', 'news-kit-elementor-addons' ); ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php
		endif;
	}

	/**
	 * renders the sub menu templates page content
	 * 
	 * MARK: STARTER SITES
	 */
	function admin_page_starter_sites_callback() {
		$page = 'demo-list';
		$pages_demos = Nekit_Utilities\Utils::library_pages_data();
		$pages_demos = json_decode( $pages_demos, true );
		if( isset( $_GET['demo-preview'] ) ) :
			$page = 'demo-preview';
			$demo_type = sanitize_text_field( wp_unslash( $_GET['demo-preview'] ) );
		endif;
		$page_class = ( $page == 'demo-preview' ) ? 'main-demo-inner-list' : 'main-demo-list';
		$is_pro = apply_filters( 'nekit_is_pro_active_filter', false );
	?>
			<div id="nekit-sub-admin-page" class="nekit-templates-list <?php echo esc_attr( $page_class ); ?>">
				<?php
					switch( $page ) {
						// MARK: Starter Sites Inner
						case 'demo-preview' :
							$preview_demos = $pages_demos[$demo_type]['pages'];
							$preview_demo_home = $preview_demos['home']['preview_url'];
							?>
											<div class="page-header">
												<div class="main-demo-inner-header-wrap">
													<button class="back-to-library-redirect-button nekit-admin-button">
														<a class="dashicons dashicons-arrow-left-alt2" href="<?php echo esc_url( admin_url('admin.php') . '?page=news-kit-elementor-addons-starter-sites' );?>">
															<h2 class="main-demo-inner-header">
																<?php echo esc_html__( 'Back To Library', 'news-kit-elementor-addons' ); ?>
															</h2>
														</a>
													</button>	
												</div>
											</div>
											<div class="page-content">
												<div class="nekit-library-popup library-popup-inner">
													<div class="templates-tab-content">
														<div class="inner-tab-content tab-pages-list pages-library">
															<?php
																if( $preview_demos && is_array( $preview_demos ) ) :
																	foreach( $preview_demos as $preview_demo ) :
																		?>
																			<figure class="template-item">
																				<a href="<?php echo esc_url( $preview_demo['preview_url'] ); ?>" target="_blank"><img src="<?php echo esc_url( $preview_demo['screenshot'] ); ?>" loading="lazy"/></a>
																				<div class="button-actions">
																					<h2 class="demo-name"><?php echo esc_html( $preview_demo['name'] ); ?></h2>
																					<button class="demo-link nekit-admin-button"><a href="<?php echo esc_url( $preview_demo['preview_url'] ); ?>" target="_blank"><?php echo esc_html__( 'Preview', 'news-kit-elementor-addons' ); ?></a></button>
																				</div>
																			</figure>
																		<?php
																	endforeach;
																endif;
															?>
														</div>
													</div>
												</div>
											</div>
											<div class="page-footer">
												<div class="footer-buttons-wrap">
													<a href="<?php echo esc_url( $preview_demo_home ); ?>" class="footer-button preview-redirect-button"><span class="button-text"><?php echo esc_html__( 'Preview Demo', 'news-kit-elementor-addons' ); ?></span><span class="dashicons dashicons-visibility"></span></a>
													<a href="<?php echo esc_url('https://www.youtube.com/watch?v=zCw0bkswns4'); ?>" target="_blank" class="footer-button video-redirect-button"><span class="button-text"><?php echo esc_html__( 'How to import demo ? ', 'news-kit-elementor-addons' ); ?></span><span class="dashicons dashicons-youtube"></span></a>
												</div>
												<?php
													$import_status = true;
													if( $pages_demos[$demo_type]['type'] == 'pro' ) {
														$pro_plugin_path = WP_PLUGIN_DIR . '/news-kit-elementor-addons-pro/news-kit-elementor-addons-pro.php';
														$pro_check_active = is_plugin_active( 'news-kit-elementor-addons-pro/news-kit-elementor-addons-pro.php' );
														$import_status = $pro_check_active ? true: false;
													}
													if( $import_status ) :
														$check_active = is_plugin_active( 'blaze-demo-importer/blaze-demo-importer.php' );
														$plugin_path = WP_PLUGIN_DIR . '/blaze-demo-importer/blaze-demo-importer.php';
														if( file_exists( $plugin_path ) ) :
															if( $check_active ) :
																?>
																	<div class="reset-info">
																		<label class="blaze-demo-importer-reset-website-checkbox">
																			<input id="checkbox-reset-blaze-import" type="checkbox" value="1" checked="checked">
																			<?php echo esc_html__( 'Reset Website - Check this box only if you are sure to reset the website.', 'news-kit-elementor-addons' ); ?>
																		</label>
																	</div>
																	<button class="footer-button import-action" data-demo="<?php echo esc_attr( $demo_type ); ?>">
																		<?php echo esc_html__( 'Import', 'news-kit-elementor-addons' ); ?>
																		<span class="dashicons dashicons-download"></span>
																		<span class="reset-info"><?php echo esc_html__( 'Reseting the website will delete all your post, pages, custom post types, categories, taxonomies, images and all other customizer and theme option settings. It is always recommended to backup the database for a complete demo import.', 'news-kit-elementor-addons' ); ?></span>
																	</button>
																<?php
															else:
																echo '<button class="footer-button importer-action activate" data-demo="' . esc_attr( $demo_type ) . '">' .esc_html__( 'Activate Importer', 'news-kit-elementor-addons' ). '<span class="dashicons dashicons-download"></span></button>';
															endif;
														else:
															echo '<button class="footer-button importer-action install" data-demo="' . esc_attr( $demo_type ) . '">' .esc_html__( 'Install Importer', 'news-kit-elementor-addons' ). '<span class="dashicons dashicons-download"></span></button>';
														endif;
													else:
														echo '<a class="footer-button importer-action upgrade" target="_blank" href="' .esc_url( "//blazethemes.com/news-kit-elementor-addons/" ). '">' .esc_html__( 'Upgrade To Pro', 'news-kit-elementor-addons' ). '<span class="dashicons dashicons-external"></span></a>';
													endif;
												?>
											</div>
											<div class="nekit-importer-modal" style="display: none;">
												<div class="modal-inner-wrap">
													<div class="modal-header">
														<?php echo esc_html__( 'Demo is being imported', 'news-kit-elementor-addons' ); ?>
													</div>
													<div class="modal-body">
														<div class="inner-body">
															<p class="on-import-running"><?php echo esc_html__( 'Please be patient ! It may take few minutes to fully import the demo content.', 'news-kit-elementor-addons' ); ?></p>
															<p class="on-import-running"><?php echo esc_html__( 'Do not reload or close this window.', 'news-kit-elementor-addons' ); ?></p>
															<p class="on-success"><?php echo wp_kses_post(sprintf( esc_html__( 'Navigate to %1sTheme Builder%2s admin page to customize %3sHeader%4s, %5sFooter%6s, %7sSingle%8s, %9sArchive%10s, %11s404 page%12s and other page templates.', 'news-kit-elementor-addons' ), '<a href="' .esc_url( admin_url( '/admin.php?page=news-kit-elementor-addons-theme-builder' ) ). '">', '</a>', '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>' )); ?></p>
														</div>
														<div class="progress-container">
															<div class="progress-log">
																<span class="log-item running-log"><?php echo esc_html__( 'Preparing for import', 'news-kit-elementor-addons' ); ?></span>
															</div>
															<div class="progress-result">
																<div class="progress-bar-number">0%</div>
																<div class="progress-bar">
																	<div class="progress-bar-inner"></div>
																</div>
																<div class="demo-success-button on-success">
																	<a href="<?php echo esc_url( site_url() ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Visit Site', 'news-kit-elementor-addons' ); ?></a>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<a href="<?php echo esc_url('http://blazethemes.com/support'); ?>" target="_blank"><?php echo esc_html__( 'Trouble having demo import?', 'news-kit-elementor-addons' ); ?><span class="button-suffix"><?php echo esc_html__( 'Get Support', 'news-kit-elementor-addons' ) ?><span class="dashicons dashicons-sos"></span></span></a>
													</div>
												</div>
											</div>
										<?php
											break;
							// MARK: Starter Sites Main
						default :  ?>
								<div class="page-header">
									<div class="page-header">
										<h2 class="page-title"><?php echo esc_html__( 'Pre-built Templates', 'news-kit-elementor-addons' ); ?></h2>
										<p><?php echo esc_html__( 'Preview and Import all the pre-built templates.', 'news-kit-elementor-addons' ); ?></p>
										<button class="video-redirect-button nekit-admin-button"><a href="<?php echo esc_url('https://www.youtube.com/watch?v=zCw0bkswns4'); ?>" target="_blank"><?php echo esc_html__( 'How to import pre-built templates', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
									</div>
								</div>
								<div class="page-content">
									<div class="nekit-library-popup library-popup-inner">
										<div class="templates-tab-content">
											<div class="inner-tab-content tab-pages-list pages-library">
												<div class="filter-tab-search-wrap">
													<div class="templates-category-title-filter">
														<div class="active-filter"><span class="filter-text"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ) ?></span><span class="dashicons dashicons-arrow-down-alt2"></span></div>
														<?php
															$filter_list = [
																'all'	=>	esc_html__( 'All', 'news-kit-elementor-addons' ),
																'news'	=>	esc_html__( 'News', 'news-kit-elementor-addons' ),
																'sports'	=>	esc_html__( 'Sports', 'news-kit-elementor-addons' ),
																'gaming'	=>	esc_html__( 'Gaming', 'news-kit-elementor-addons' ),
																'politics'	=>	esc_html__( 'Politics', 'news-kit-elementor-addons' ),
																'food'	=>	esc_html__( 'Food', 'news-kit-elementor-addons' )
															];
														?>
														<ul class="filter-list">
															<?php
																$count = 0;
																if( ! empty( $filter_list ) && is_array( $filter_list ) ) :
																	foreach( $filter_list as $tab_key => $tab_value ) :
																		$listClass = 'filter-tab';
																		if( $count === 0 ) $listClass .= ' active';
																		?>
																			<li class="<?php echo esc_attr( $listClass ); ?>" data-value="<?php echo esc_attr( $tab_key ); ?>">
																				<span class="tab-label"><?php echo esc_html( $tab_value ); ?></span>
																				<div class="count-wrapper">
																					<span class="count free-count"></span>
																					<span class="count pro-count"></span>
																				</div>
																			</li>
																		<?php
																		$count++;
																	endforeach;
																endif;
															?>
														</ul>
													</div>
													<div class="free-pro-filter-tabs">
														<button class="filter-tab free"><?php echo esc_html__( 'Free', 'news-kit-elementor-addons' ); ?></button>
														<button class="<?php echo esc_attr( $is_pro ? 'filter-tab pro' : 'filter-tab upgrade' ); ?>"><?php echo esc_html__( 'Pro', 'news-kit-elementor-addons' ); ?></button>
														<button class="filter-tab both active"><?php echo esc_html__( 'Free & Pro', 'news-kit-elementor-addons' ); ?></button>
													</div>
													<div class="search-wrapper">
														<input value="" type="search" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>">
														<span class="dashicons dashicons-search"></span>
													</div>
												</div>
												<div class="tab-blocks-list-wrap">
													<div class="tab-blocks-list widgets-blocks-library">
														<?php
															$pages_demos = apply_filters( 'nekit_array_pop_filter', $pages_demos );
															$pages_demos = apply_filters( 'nekit_array_pop_filter', $pages_demos );
															if( $pages_demos && is_array($pages_demos) ) :
																foreach( $pages_demos as $page_demo_key => $page_demo ) :
																	$import_status = true;
																	if( $page_demo['type'] == 'pro' ) {
																		$pro_plugin_path = WP_PLUGIN_DIR . '/news-kit-elementor-addons-pro/news-kit-elementor-addons-pro.php';
																		$pro_check_active = is_plugin_active( 'news-kit-elementor-addons-pro/news-kit-elementor-addons-pro.php' );
																		$import_status = $pro_check_active ? true: false;
																		if( ! $is_pro ) $page_demo['type'] = 'upgrade';
																	}
																	$filter_attr = 'all ' . $page_demo['type'];
																	$filter_attr .= ' ';
																	$filter_attr .= is_array( $page_demo['category'] ) ? implode( " ", $page_demo['category'] ) : $page_demo['category'];
																	?>
																		<figure class="template-item <?php echo esc_attr( $filter_attr ); ?>">
																			<a href="<?php echo esc_url( $page_demo['pages']['home']['preview_url'] ); ?>" target="_blank"><img src="<?php echo esc_url($page_demo['pages']['home']['screenshot']); ?>"/></a>
																			<div class="button-actions">
																				<h2 class="demo-name block-label"><?php echo esc_html( $page_demo['name'] ); ?></h2>
																				<?php
																					if( $import_status ) {
																				?>
																						<button class="demo-link"><a href="<?php echo esc_url( admin_url('admin.php') . '?page=news-kit-elementor-addons-starter-sites&demo-preview="'.$page_demo_key.'"' ); ?>"><?php echo esc_html__( 'Lets Start', 'news-kit-elementor-addons' ); ?></a></button>
																				<?php
																					} else {
																				?>
																						<button class="demo-link"><a href="<?php echo esc_url( "https://blazethemes.com/news-kit-elementor-addons/" ) ?>" target="_blank"><?php echo esc_html__( 'Upgrade', 'news-kit-elementor-addons' ); ?></a></button>
																				<?php
																					}
																				?>
																			</div>
																		</figure>
																	<?php
																endforeach;
															endif;
														?>
													</div>
												</div><!-- .tab-blocks-list-wrap -->
											</div><!-- .inner-tab-content -->
										</div><!-- .templates-tab-content -->
									</div><!-- .nekit-library-popup -->
								</div><!-- .page-content -->
						<?php
					}
				?>
			</div><!-- #nekit-sub-admin-page -->
		<?php
	}

	/**
	 * register scripts and styles
	 * 
	 * MARK: HANDLE SCRIPTS
	 */
	function handle_scripts($hook) {
		if( $hook === 'toplevel_page_news-kit-elementor-addons' ) :
			wp_register_style( 'nekit-editor-widget-icons', plugins_url( 'includes/assets/external/nekit-widget-icons/style.css', __DIR__ ));
			wp_enqueue_style( 'nekit-editor-widget-icons' );
		endif;

		if( ! $hook == 'nav-menus.php' && ! in_array( $hook, ['toplevel_page_news-kit-elementor-addons', 'news-kit_page_news-kit-elementor-addons-pre-made-blocks', 'news-kit_page_news-kit-elementor-addons-theme-builder', 'news-kit_page_news-kit-elementor-addons-starter-sites','news-kit-elementor-addons-settings', 'news-kit_page_news-kit-elementor-addons-popup-builder' ] ) ) return;
		require_once NEKIT_PATH . 'admin/assets/wptt-webfont-loader.php';
		wp_register_style( 'nekit-admin-fonts', wptt_get_webfont_url( $this->get_fonts_url() ), [], null );
		wp_register_style( 'fontawesome', NEKIT_URL . 'includes/assets/external/fontawesome/css/all.min.css', [], '5.15.3' );
		wp_register_style( 'nekit-admin-main', plugins_url( 'assets/admin.css', __FILE__ ) );
		wp_enqueue_style( 'nekit-admin-fonts' );
		wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'nekit-admin-main' );
		// Add the color picker css file  
		wp_enqueue_style( 'wp-color-picker' );
		wp_register_script( 'nekit-components', plugins_url( 'components.js', __FILE__ ), [ 'jquery' ], '1.3.1', [ 'strategy' => 'defer', 'in_footer' => true ] );
		wp_enqueue_script( 'nekit-components' );
		wp_register_script( 'nekit-admin-main', plugins_url( 'assets/admin.js', __FILE__ ), [ 'jquery','wp-color-picker', 'masonry', 'nekit-components' ], '1.3.1', [ 'strategy' => 'defer', 'in_footer' => true ] );

		wp_enqueue_script( 'nekit-admin-main' );
		wp_enqueue_script( 'masonry' );
		wp_localize_script( 'nekit-admin-main', 'adminObject', [
			'_wpnonce'	=> wp_create_nonce( 'nekit-admin-nonce' ),
			'ajaxUrl'	=> admin_url('admin-ajax.php'),
			'page'	=> $hook,
			'savingText'	=> esc_html__( 'Saving', 'news-kit-elementor-addons' ),
			'installingText'	=> esc_html__( 'Installing', 'news-kit-elementor-addons' ),
			'activatingText'	=> esc_html__( 'Activating', 'news-kit-elementor-addons' ),
			'emptyFieldText'=> esc_html__( 'Enter the template title', 'news-kit-elementor-addons' ),
			'buttonText'	=> esc_html__( ' Mega Menu', 'news-kit-elementor-addons' ),
			'formButtonText'	=> esc_html__( 'Save Changes', 'news-kit-elementor-addons' ),
			'formButtonSavedText'	=> esc_html__( 'Saved', 'news-kit-elementor-addons' ),
			'desktopText'	=> esc_html__( 'Desktop', 'news-kit-elementor-addons' ),
			'tabletText'	=> esc_html__( 'Tablet', 'news-kit-elementor-addons' ),
			'mobileText'	=> esc_html__( 'Mobile', 'news-kit-elementor-addons' ),
			'enabledText'	=> esc_html__( 'Enabled', 'news-kit-elementor-addons' ),
			'disabledText'	=> esc_html__( 'Disabled', 'news-kit-elementor-addons' )
		]);
	}

	// Add Elementor Editor Support
	function add_mega_menu_cpt_support( $value ) {
		if ( empty( $value ) ) {
			$value = [];
		}
		return array_merge( $value, ['nekit-mm-cpt'] );
	}

	/**
	 * Register Custom Post Type
	 * 
	 * MARK: REGISTER CPT
	 */
	function register_custom_post_types() {
		// mega menu post
		$labels = array(
			'name'                     => __( 'Nekit Mega Menu', 'news-kit-elementor-addons' ),
			'singular_name'            => __( 'Nekit Mega Menu', 'news-kit-elementor-addons' ),
			'add_new'                  => __( 'Add New', 'news-kit-elementor-addons' ),
			'add_new_item'             => __( 'Add New Mega Menu', 'news-kit-elementor-addons' ),
			'edit_item'                => __( 'Edit Mega Menu', 'news-kit-elementor-addons' ),
			'new_item'                 => __( 'New Mega Menu', 'news-kit-elementor-addons' ),
			'view_item'                => __( 'View Mega Menu', 'news-kit-elementor-addons' ),
			'view_items'               => __( 'View Mega Menu', 'news-kit-elementor-addons' ),
			'search_items'             => __( 'Search Mega Menu', 'news-kit-elementor-addons' ),
			'not_found'                => __( 'No Mega Menu found.', 'news-kit-elementor-addons' ),
			'not_found_in_trash'       => __( 'No Mega Menu found in Trash.', 'news-kit-elementor-addons' ),
			'parent_item_colon'        => __( 'Parent Mega Menu:', 'news-kit-elementor-addons' ),
			'all_items'                => __( 'All Mega Menu', 'news-kit-elementor-addons' ),
			'archives'                 => __( 'Mega Menu Archives', 'news-kit-elementor-addons' ),
			'attributes'               => __( 'Mega Menu Attributes', 'news-kit-elementor-addons' ),
			'insert_into_item'         => __( 'Insert into Mega Menu', 'news-kit-elementor-addons' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this Mega Menu', 'news-kit-elementor-addons' ),
			'featured_image'           => __( 'Featured Image', 'news-kit-elementor-addons' ),
			'set_featured_image'       => __( 'Set featured image', 'news-kit-elementor-addons' ),
			'remove_featured_image'    => __( 'Remove featured image', 'news-kit-elementor-addons' ),
			'use_featured_image'       => __( 'Use as featured image', 'news-kit-elementor-addons' ),
			'menu_name'                => __( 'Nekit Mega Menu', 'news-kit-elementor-addons' ),
			'filter_items_list'        => __( 'Filter Mega Menu list', 'news-kit-elementor-addons' ),
			'filter_by_date'           => __( 'Filter by date', 'news-kit-elementor-addons' ),
			'items_list_navigation'    => __( 'Mega Menu list navigation', 'news-kit-elementor-addons' ),
			'items_list'               => __( 'Mega Menu list', 'news-kit-elementor-addons' ),
			'item_published'           => __( 'Mega Menu published.', 'news-kit-elementor-addons' ),
			'item_published_privately' => __( 'Mega Menu published privately.', 'news-kit-elementor-addons' ),
			'item_reverted_to_draft'   => __( 'Mega Menu reverted to draft.', 'news-kit-elementor-addons' ),
			'item_scheduled'           => __( 'Mega Menu scheduled.', 'news-kit-elementor-addons' ),
			'item_updated'             => __( 'Mega Menu updated.', 'news-kit-elementor-addons' ),
			'item_link'                => __( 'Mega Menu Link', 'news-kit-elementor-addons' ),
			'item_link_description'    => __( 'A link to an announcement.', 'news-kit-elementor-addons' )
		 );
		 $args = array(
			'labels'                => $labels,
			'description'           => __( 'Manage news kit elementor addons mega menu builder', 'news-kit-elementor-addons' ),
			'public'                => true,
			'hierarchical'          => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'show_in_nav_menus'     => false,
			'show_in_admin_bar'     => false,
			'show_in_rest'          => false,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-megaphone',
			'capability_type'       => 'post',
			'capabilities'          => array(),
			'supports'              => array( 'title', 'editor', 'revisions' ),
			'taxonomies'            => array(),
			'has_archive'           => false,
			'rewrite'               => array( 'slug' => 'nekit-mm-cpt' ),
			'query_var'             => true,
			'can_export'            => true,
			'delete_with_user'      => false,
			'template'              => array(),
			'template_lock'         => false
		 );
		 register_post_type( 'nekit-mm-cpt', $args );
		 add_action( 'template_include', function($template) {
			if ( is_singular('nekit-mm-cpt') ) {
				$template = NEKIT_PATH . 'admin/templates/canvas.php';
			}
			return $template;
		 }, 9999 );
	}

	/**
	 * megamenu popup html
	 * 
	 * MARK: MEGA MENU
	 */
    function render_mega_menu_modal() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
        $menu = isset($_POST['menu']) ? sanitize_text_field(wp_unslash($_POST['menu'])) : '';
        $menu_name = isset($_POST['menu_name']) ? sanitize_text_field(wp_unslash($_POST['menu_name'])) : '';
		$menu = (int)str_replace( 'menu-item-', '', $menu );
		if( metadata_exists( 'post', $menu, 'nekit_mega_menu_id' ) ) {
			$menu_mega_menu_id = get_post_meta( $menu, 'nekit_mega_menu_id', true );
			// delete_post_meta( $menu, 'nekit_mega_menu_id' );
		} else {
			$new_mega_menu_args = [
				'post_type'	=> 'nekit-mm-cpt',
				'post_title'   => esc_html__( 'Mega Menu' , 'news-kit-elementor-addons' ),
				'post_content' => '',
				'post_status'	=> 'publish'
			];
			$menu_mega_menu_id = wp_insert_post( $new_mega_menu_args );
			update_post_meta( $menu, 'nekit_mega_menu_id', absint($menu_mega_menu_id) );
		}
		if( metadata_exists( 'post', $menu, 'nekit_mega_menu_option' ) ) {
			$menu_mega_menu_option = get_post_meta( $menu, 'nekit_mega_menu_option', true );
		} else {
			$menu_mega_menu_option = 'disable';
			update_post_meta( $menu, 'nekit_mega_menu_option', sanitize_text_field($menu_mega_menu_option) );
		}

		// mega menu width layout
		if( metadata_exists( 'post', $menu, 'nekit_width_layout' ) ) {
			$nekit_width_layout = get_post_meta( $menu, 'nekit_width_layout', true );
		} else {
			$nekit_width_layout = 'boxed';
			update_post_meta( $menu, 'nekit_width_layout', sanitize_text_field($nekit_width_layout) );
		}

		// mega menu custom width
		if( metadata_exists( 'post', $menu, 'nekit_custom_width' ) ) {
			$nekit_custom_width = get_post_meta( $menu, 'nekit_custom_width', true );
		} else {
			$nekit_custom_width = 800;
			update_post_meta( $menu, 'nekit_custom_width', absint($nekit_custom_width) );
		}

		// mega menu custom width tablet
		if( metadata_exists( 'post', $menu, 'nekit_custom_width_tablet' ) ) {
			$nekit_custom_width_tablet = get_post_meta( $menu, 'nekit_custom_width_tablet', true );
		} else {
			$nekit_custom_width_tablet = 600;
			update_post_meta( $menu, 'nekit_custom_width_tablet', absint($nekit_custom_width_tablet) );
		}

		// mega menu custom width mobile
		if( metadata_exists( 'post', $menu, 'nekit_custom_width_mobile' ) ) {
			$nekit_custom_width_mobile = get_post_meta( $menu, 'nekit_custom_width_mobile', true );
		} else {
			$nekit_custom_width_mobile = 400;
			update_post_meta( $menu, 'nekit_custom_width_mobile', absint($nekit_custom_width_mobile) );
		}

		// mega menu position
		if( metadata_exists( 'post', $menu, 'nekit_position' ) ) {
			$nekit_position = get_post_meta( $menu, 'nekit_position', true );
		} else {
			$nekit_position = 'default';
			update_post_meta( $menu, 'nekit_position', sanitize_text_field($nekit_position) );
		}

		// mega menu icon option
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_option' ) ) {
			$nekit_menu_icon_option = get_post_meta( $menu, 'nekit_menu_icon_option', true );
		} else {
			$nekit_menu_icon_option = 'hide';
			update_post_meta( $menu, 'nekit_menu_icon_option', sanitize_text_field($nekit_menu_icon_option) );
		}

		// mega menu icon
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon' ) ) {
			$nekit_menu_icon = get_post_meta( $menu, 'nekit_menu_icon', true );
		} else {
			$nekit_menu_icon = 'fas fa-home';
			update_post_meta( $menu, 'nekit_menu_icon', sanitize_text_field($nekit_menu_icon) );
		}

		// mega menu icon position
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_position' ) ) {
			$nekit_menu_icon_position = get_post_meta( $menu, 'nekit_menu_icon_position', true );
		} else {
			$nekit_menu_icon_position = 'before';
			update_post_meta( $menu, 'nekit_menu_icon_position', sanitize_text_field($nekit_menu_icon_position) );
		}

		// mega menu icon size
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_size' ) ) {
			$nekit_menu_icon_size = get_post_meta( $menu, 'nekit_menu_icon_size', true );
		} else {
			$nekit_menu_icon_size = 18;
			update_post_meta( $menu, 'nekit_menu_icon_size', absint($nekit_menu_icon_size) );
		}

		// mega menu icon size tablet
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_size_tablet' ) ) {
			$nekit_menu_icon_size_tablet = get_post_meta( $menu, 'nekit_menu_icon_size_tablet', true );
		} else {
			$nekit_menu_icon_size_tablet = 16;
			update_post_meta( $menu, 'nekit_menu_icon_size_tablet', absint($nekit_menu_icon_size_tablet) );
		}

		// mega menu icon size mobile
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_size_mobile' ) ) {
			$nekit_menu_icon_size_mobile = get_post_meta( $menu, 'nekit_menu_icon_size_mobile', true );
		} else {
			$nekit_menu_icon_size_mobile = 14;
			update_post_meta( $menu, 'nekit_menu_icon_size_mobile', absint($nekit_menu_icon_size_mobile) );
		}

		// mega menu icon distance
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_distance' ) ) {
			$nekit_menu_icon_distance = get_post_meta( $menu, 'nekit_menu_icon_distance', true );
		} else {
			$nekit_menu_icon_distance = 6;
			update_post_meta( $menu, 'nekit_menu_icon_distance', absint($nekit_menu_icon_distance) );
		}

		// mega menu icon distance tablet
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_distance_tablet' ) ) {
			$nekit_menu_icon_distance_tablet = get_post_meta( $menu, 'nekit_menu_icon_distance_tablet', true );
		} else {
			$nekit_menu_icon_distance_tablet = 6;
			update_post_meta( $menu, 'nekit_menu_icon_distance_tablet', absint($nekit_menu_icon_distance_tablet) );
		}

		// mega menu icon distance mobile
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_distance_mobile' ) ) {
			$nekit_menu_icon_distance_mobile = get_post_meta( $menu, 'nekit_menu_icon_distance_mobile', true );
		} else {
			$nekit_menu_icon_distance_mobile = 6;
			update_post_meta( $menu, 'nekit_menu_icon_distance_mobile', absint($nekit_menu_icon_distance_mobile) );
		}

		// mega menu icon color
		if( metadata_exists( 'post', $menu, 'nekit_menu_icon_color' ) ) {
			$nekit_menu_icon_color = get_post_meta( $menu, 'nekit_menu_icon_color', true );
		} else {
			$nekit_menu_icon_color = '#000000';
			update_post_meta( $menu, 'nekit_menu_icon_color', sanitize_hex_color($nekit_menu_icon_color) );
		}

		// mega menu appear direction
		if( metadata_exists( 'post', $menu, 'nekit_appear_direction' ) ) {
			$nekit_appear_direction = get_post_meta( $menu, 'nekit_appear_direction', true );
		} else {
			$nekit_appear_direction = 'top';
			update_post_meta( $menu, 'nekit_appear_direction', sanitize_text_field($nekit_appear_direction) );
		}

		// mega menu appear animation
		if( metadata_exists( 'post', $menu, 'nekit_appear_animation' ) ) {
			$nekit_appear_animation = get_post_meta( $menu, 'nekit_appear_animation', true );
		} else {
			$nekit_appear_animation = 'fade';
			update_post_meta( $menu, 'nekit_appear_animation', sanitize_text_field($nekit_appear_animation) );
		}

		// mega menu show on event type
		if( metadata_exists( 'post', $menu, 'nekit_display_on_event_type' ) ) {
			$nekit_display_on_event_type = get_post_meta( $menu, 'nekit_display_on_event_type', true );
		} else {
			$nekit_display_on_event_type = 'hover';
			update_post_meta( $menu, 'nekit_display_on_event_type', sanitize_text_field($nekit_display_on_event_type) );
		}

		// mega menu show on event type
		if( metadata_exists( 'post', $menu, 'nekit_close_on_outside_click' ) ) {
			$nekit_close_on_outside_click = get_post_meta( $menu, 'nekit_close_on_outside_click', true );
		} else {
			$nekit_close_on_outside_click = 'outside-click';
			update_post_meta( $menu, 'nekit_close_on_outside_click', sanitize_text_field($nekit_close_on_outside_click) );
		}

		// menu item mobile sub menu type 
		if( metadata_exists( 'post', $menu, 'nekit_mobile_sub_menu_type' ) ) {
			$nekit_mobile_sub_menu_type = get_post_meta( $menu, 'nekit_mobile_sub_menu_type', true );
		} else {
			$nekit_mobile_sub_menu_type = 'mega-menu';
			update_post_meta( $menu, 'nekit_mobile_sub_menu_type', sanitize_text_field($nekit_mobile_sub_menu_type) );
		}

		$nekit_width_layout_options = apply_filters( 'nekit_admin_mega_menu_width_layouts_options_filter', [
			'boxed'	=> esc_html__( 'Boxed', 'news-kit-elementor-addons' ),
			'fit-to-section'	=> esc_html__( 'Fit To Section', 'news-kit-elementor-addons' )
		]);
		$nekit_menu_icon_position_options = apply_filters( 'nekit_admin_mega_menu_icon_positions_options_filter', []);
		$nekit_menu_icon_distance_render = apply_filters( 'nekit_menu_icon_distance_render_filter', false);
		$nekit_appear_direction_options = apply_filters('nekit_admin_mega_menu_appear_direction_options_filter', [
			'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
			'top'   => esc_html__( 'Top', 'news-kit-elementor-addons' )
		]);
		$nekit_display_on_event_type_render = apply_filters( 'nekit_display_on_event_type_render_filter', false);
		$nekit_appear_animation_options = apply_filters('nekit_admin_mega_menu_appear_animation_options_filter', [
			'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
			'fade'   => esc_html__( 'Fade', 'news-kit-elementor-addons' )
		]);

        ob_start();
        ?>
            <div class="nekit-mega-menu-modal">
				<div class="mega-menu-modal-inner-container">
					<div class="modal-notice">
						<div class="logo">
							<img src="<?php echo esc_url(plugins_url( '/assets/images/logo.png', __FILE__ )); ?>">
						</div>
						<div class="modal_notice_inner">
							<?php echo esc_html__( 'You are editing ', 'news-kit-elementor-addons' ); ?><span class="highlight-text secondary-highlight"><?php echo esc_html__( 'Menu Item : ', 'news-kit-elementor-addons' ); ?></span><span class="highlight-text primary-highlight"><?php echo esc_html($menu_name); ?></span>
						</div>
					</div>
					<div class="header_title_wrap">
						<div class="popup-close-trigger">
							<i class="eicon-close" aria-hidden="true" title="<?php esc_html_e( 'Close', 'news-kit-elementor-addons' ); ?>"></i>
						</div>
						<div class="header">
							<div class="modal-actions-wrap">
								<div class="mega-menu-toggle-field switch-field">
									<label for="nekit-mega-menu-option[<?php echo esc_attr($menu); ?>]">
										<h5 for="field-label"><?php esc_html_e( 'Enable Mega Menu', 'news-kit-elementor-addons' ); ?></h5>
										<div class="field-input <?php echo esc_attr($menu_mega_menu_option); ?>" data-value="<?php echo esc_attr($menu_mega_menu_option); ?>" data-menu="<?php echo esc_attr($menu); ?>">
											<span class="enabled"><?php esc_html_e( 'Enabled', 'news-kit-elementor-addons' ); ?></span>
											<span class="disabled"> / <?php esc_html_e( 'Disabled', 'news-kit-elementor-addons' ); ?></span>
										</div>
									</label>
									<input type="checkbox" id="nekit-mega-menu-option[<?php echo esc_attr($menu); ?>]" name="nekit-mega-menu-option[<?php echo esc_attr($menu); ?>]" <?php checked( $menu_mega_menu_option, 'enable', true ) ?>>
								</div>
							</div>
							<span class="nekit-editwith-elementor"><i class="fab fa-elementor"></i> <span><?php echo esc_html__( 'Edit With Elementor', 'news-kit-elementor-addons' ); ?></span>
						</div>
					</div>
					<div class="tab-content">
						<div class="tab-edit-content" style="display: none;"><span class="mega-menu-inner-close-btn"></span><iframe src="<?php echo esc_url(add_query_arg(['post'	=> absint( $menu_mega_menu_id ),'action'	=> 'elementor'], admin_url('/post.php') ) ); ?>"></iframe></div>
						<div class="tab-settings-content">
							<form id="nekit-mega-menu-setting-[<?php echo absint($menu); ?>]" class="nekit-mega-menu-setting-form" method="POST">
								<div class="nekit-mega-menu-setting-field nekit-submit-form-field">
									<input type="submit" class="submit-button" name="submit" value="<?php echo esc_html__( 'Save Changes' , 'news-kit-elementor-addons' ); ?>">
								</div>
								<div class="nekit-mega-menu-setting-field">
									<h2 class="heading-control"><?php echo esc_html__( 'General Settings' , 'news-kit-elementor-addons' ); ?></h2>
								</div>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_width_layout[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Width Layout' , 'news-kit-elementor-addons' ); ?></label>
									<select class="field-link" id="nekit_width_layout[<?php echo absint($menu); ?>]" name="nekit_width_layout[<?php echo absint($menu); ?>]">
										<?php
											foreach( $nekit_width_layout_options as $nekit_width_layout_option_key => $nekit_width_layout_option ) :
										?>
												<option value="<?php echo esc_attr( $nekit_width_layout_option_key ); ?>" <?php selected( $nekit_width_layout, $nekit_width_layout_option_key ); ?>><?php echo esc_html( $nekit_width_layout_option ); ?></option>
										<?php
											endforeach;
										?>
									</select>
								</div>
								<?php
									if( array_key_exists( 'custom-width', $nekit_width_layout_options ) ) :
								?>
										<div class="nekit-mega-menu-setting-field">
											<label for="nekit_custom_width[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Custom Width ( in px )' , 'news-kit-elementor-addons' ); ?></label>
											<button class="nekit-responsive-field-trigger"><span class="dashicons dashicons-desktop" title="<?php echo esc_html__( 'Desktop', 'news-kit-elementor-addons' ); ?>"></span></button>
											<input class="field-link control-desktop" type="number" id="nekit_custom_width[<?php echo absint($menu); ?>]" class="desktop-control" name="nekit_custom_width[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_custom_width); ?>" min="1" max="10000" step="1">
											<input class="field-link control-tablet" type="number" id="nekit_custom_width_tablet[<?php echo absint($menu); ?>]" class="tablet-control" name="nekit_custom_width_tablet[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_custom_width_tablet); ?>" min="1" max="1000" step="1">
											<input class="field-link control-phone" type="number" id="nekit_custom_width_mobile[<?php echo absint($menu); ?>]" class="mobile-control" name="nekit_custom_width_mobile[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_custom_width_mobile); ?>" min="1" max="1000" step="1">
										</div>
								<?php
									endif;
								?>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_position[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Position' , 'news-kit-elementor-addons' ); ?></label>
									<select class="field-link" id="nekit_position[<?php echo absint($menu); ?>]" name="nekit_position[<?php echo absint($menu); ?>]">
										<option value="default" <?php selected( $nekit_position, 'default' ); ?>><?php echo esc_html__( 'Default', 'news-kit-elementor-addons' ); ?></option>
										<option value="relative" <?php selected( $nekit_position, 'relative' ); ?>><?php echo esc_html__( 'Relative', 'news-kit-elementor-addons' ); ?></option>
									</select>
								</div>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_menu_icon[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Menu Icon' , 'news-kit-elementor-addons' ); ?></label>
									<div class="icon-picker-field">
										<div class="icon-picker-holder">
											<input type="hidden" class="field-link" id="nekit_menu_icon[<?php echo absint($menu); ?>]" name="nekit_menu_icon[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon); ?>">
											<span class="icon-value"><i class="<?php echo esc_attr($nekit_menu_icon); ?>"></i></span>
											<div class="field-label inner-field toggle-field <?php echo esc_attr( $nekit_menu_icon_option ); ?>">
												<span class="toggle-item toggle-item-hide"><?php echo esc_html__( 'Hide Icon', 'news-kit-elementor-addons' ); ?></span>
												<span class="toggle-item toggle-item-show"><?php echo esc_html__( 'Show Icon', 'news-kit-elementor-addons' ); ?></span>
												<input type="hidden" class="field-link" id="nekit_menu_icon_option[<?php echo absint($menu); ?>]" name="nekit_menu_icon_option[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_option); ?>">
											</div>
										</div>
										<div class="icon-picker-modal" style="display: none;">
											<div class="modal-inner-wrap">
												<i class="modal-close fas fa-times"></i>
												<div class="modal-header">
													<input type="search" class="icon-search-field" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>"/>
												</div>
												<div class="icons-list">
													<?php
														$nekit_library = new \News_Kit_Elementor_Addons_Library\Library();
														$icon_array = $nekit_library->get_all_fontawesome_icons_class_attr();
														foreach( $icon_array as $icon ) :
															?>
																<span class="icon-item <?php if( $icon == $nekit_menu_icon ) echo ' selected' ?>"><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
															<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
										<p class="field-description icon-picker-field-description"><?php echo esc_html__( 'Click on icon to choose from icon list' , 'news-kit-elementor-addons' ); ?></p>
									</div>
								</div>
								<?php
									if( $nekit_menu_icon_position_options ) :
								?>
										<div class="nekit-mega-menu-setting-field">
											<label for="nekit_menu_icon_position[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Menu Icon Position' , 'news-kit-elementor-addons' ); ?></label>
											<select class="field-link" id="nekit_menu_icon_position[<?php echo absint($menu); ?>]" name="nekit_menu_icon_position[<?php echo absint($menu); ?>]">
											<?php
												foreach( $nekit_menu_icon_position_options as $nekit_menu_icon_position_option_key => $nekit_menu_icon_position_option ) :
											?>
													<option value="<?php echo esc_attr( $nekit_menu_icon_position_option_key ); ?>" <?php selected( $nekit_menu_icon_position, $nekit_menu_icon_position_option_key ); ?>><?php echo esc_html( $nekit_menu_icon_position_option ); ?></option>
											<?php
												endforeach;
											?>
											</select>
										</div>
								<?php
									endif;
								?>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_menu_icon_size[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Icon Size ( in px )' , 'news-kit-elementor-addons' ); ?></label>
									<button class="nekit-responsive-field-trigger"><span class="dashicons dashicons-desktop" title="<?php echo esc_html__( 'Desktop', 'news-kit-elementor-addons' ); ?>"></span></button>
									<input class="field-link control-desktop" type="number" id="nekit_menu_icon_size[<?php echo absint($menu); ?>]" class="desktop-control" name="nekit_menu_icon_size[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_size); ?>" min="1" max="100" step="1">
									<input class="field-link control-tablet" type="number" id="nekit_menu_icon_size_tablet[<?php echo absint($menu); ?>]" class="tablet-control" name="nekit_menu_icon_size_tablet[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_size_tablet); ?>" min="1" max="100" step="1">
									<input class="field-link control-phone" type="number" id="nekit_menu_icon_size_mobile[<?php echo absint($menu); ?>]" class="mobile-control" name="nekit_menu_icon_size_mobile[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_size_mobile); ?>" min="1" max="100" step="1">
								</div>
								<?php
									if( $nekit_menu_icon_distance_render ) :
								?>
										<div class="nekit-mega-menu-setting-field">
											<label for="nekit_menu_icon_distance[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Icon Distance ( in px )' , 'news-kit-elementor-addons' ); ?></label>
											<button class="nekit-responsive-field-trigger"><span class="dashicons dashicons-desktop"></span></button>
											<input class="field-link control-desktop" type="number" id="nekit_menu_icon_distance[<?php echo absint($menu); ?>]" name="nekit_menu_icon_distance[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_distance); ?>" min="1" max="100" step="1">
											<input class="field-link control-tablet" type="number" id="nekit_menu_icon_distance_tablet[<?php echo absint($menu); ?>]" name="nekit_menu_icon_distance_tablet[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_distance_tablet); ?>" min="1" max="100" step="1">
											<input class="field-link control-phone" type="number" id="nekit_menu_icon_distance_mobile[<?php echo absint($menu); ?>]" name="nekit_menu_icon_distance_mobile[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_distance_mobile); ?>" min="1" max="100" step="1">
										</div>
								<?php
									endif;
								?>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_menu_icon_color[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Icon Color' , 'news-kit-elementor-addons' ); ?></label>
									<input class="field-link nekit-color-field" type="text" id="nekit_menu_icon_color[<?php echo absint($menu); ?>]" name="nekit_menu_icon_color[<?php echo absint($menu); ?>]" value="<?php echo esc_attr($nekit_menu_icon_color); ?>" data-default-color="#333333">
								</div>
								<div class="nekit-mega-menu-setting-field">
									<h2 class="heading-control"><?php echo esc_html__( 'Mega Menu Modal/Popup Settings' , 'news-kit-elementor-addons' ); ?></h2>
								</div>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_appear_direction[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Appear Direction' , 'news-kit-elementor-addons' ); ?></label>
									<select class="field-link" id="nekit_appear_direction[<?php echo absint($menu); ?>]" name="nekit_appear_direction[<?php echo absint($menu); ?>]">
									<?php
										foreach( $nekit_appear_direction_options as $nekit_appear_direction_option_key => $nekit_appear_direction_option ) :
									?>
											<option value="<?php echo esc_attr( $nekit_appear_direction_option_key ); ?>" <?php selected( $nekit_appear_direction, $nekit_appear_direction_option_key ); ?>><?php echo esc_html( $nekit_appear_direction_option ); ?></option>
									<?php
										endforeach;
									?>
									</select>
								</div>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_appear_animation[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Appear Animation' , 'news-kit-elementor-addons' ); ?></label>
									<select class="field-link" id="nekit_appear_animation[<?php echo absint($menu); ?>]" name="nekit_appear_animation[<?php echo absint($menu); ?>]">
									<?php
										foreach( $nekit_appear_animation_options as $nekit_appear_animation_option_key => $nekit_appear_animation_option ) :
									?>
											<option value="<?php echo esc_attr( $nekit_appear_animation_option_key ); ?>" <?php selected( $nekit_appear_animation, $nekit_appear_animation_option_key ); ?>><?php echo esc_html( $nekit_appear_animation_option ); ?></option>
									<?php
										endforeach;
									?>
									</select>
								</div>
								<?php
									if( $nekit_display_on_event_type_render ) :
								?>
										<div class="nekit-mega-menu-setting-field">
											<label for="nekit_display_on_event_type[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Show Modal/Popup on' , 'news-kit-elementor-addons' ); ?></label>
											<select class="field-link" id="nekit_display_on_event_type[<?php echo absint($menu); ?>]" name="nekit_display_on_event_type[<?php echo absint($menu); ?>]">
												<option value="hover" <?php selected( $nekit_display_on_event_type, 'hover' ); ?>><?php echo esc_html__( 'Hover', 'news-kit-elementor-addons' ); ?></option>
												<option value="click" <?php selected( $nekit_display_on_event_type, 'click' ); ?>><?php echo esc_html__( 'Click', 'news-kit-elementor-addons' ); ?></option>
											</select>
										</div>
										<div class="nekit-mega-menu-setting-field">
											<label for="nekit_close_on_outside_click[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Close Modal/Popup on' , 'news-kit-elementor-addons' ); ?></label>
											<select class="field-link" id="nekit_close_on_outside_click[<?php echo absint($menu); ?>]" name="nekit_close_on_outside_click[<?php echo absint($menu); ?>]">
												<option value="outside-click" <?php selected( $nekit_close_on_outside_click, 'outside-click' ); ?>><?php echo esc_html__( 'Outside Click', 'news-kit-elementor-addons' ); ?></option>
												<option value="menu-click" <?php selected( $nekit_close_on_outside_click, 'menu-click' ); ?>><?php echo esc_html__( 'Only on Menu Click', 'news-kit-elementor-addons' ); ?></option>
											</select>
										</div>
								<?php
									endif;
								?>
								<div class="nekit-mega-menu-setting-field">
									<h2 class="heading-control"><?php echo esc_html__( 'Responsive Settings' , 'news-kit-elementor-addons' ); ?></h2>
								</div>
								<div class="nekit-mega-menu-setting-field">
									<label for="nekit_mobile_sub_menu_type[<?php echo absint($menu); ?>]" class="field-label"><?php echo esc_html__( 'Mobile Submenu Type' , 'news-kit-elementor-addons' ); ?></label>
									<select class="field-link" id="nekit_mobile_sub_menu_type[<?php echo absint($menu); ?>]" name="nekit_mobile_sub_menu_type[<?php echo absint($menu); ?>]">
										<option value="mega-menu" <?php selected( $nekit_mobile_sub_menu_type, 'mega-menu' ); ?>><?php echo esc_html__( 'Mega Menu', 'news-kit-elementor-addons' ); ?></option>
										<option value="wordpress-submenu" <?php selected( $nekit_mobile_sub_menu_type, 'wordpress-submenu' ); ?>><?php echo esc_html__( 'WordPress Submenu', 'news-kit-elementor-addons' ); ?></option>
									</select>
									<p class="field-description"><?php echo esc_html__( 'Whether to display mega menu content or a default sub menu on mobile' , 'news-kit-elementor-addons' ); ?></p>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        <?php
        $res['html'] = ob_get_clean();
        $res['loaded'] = true;
        wp_send_json_success( $res );
		wp_die();
    }

	/**
	 * Html content for template list
	 * 
	 * @return html
	 */
	function print_template_list( $template = 'header' ) {
		$tab = $this->current_tab;
		?>
			<div class="template-list" data-template="<?php echo esc_attr($tab); ?>">
				<?php
					$hb_templates = nekit_get_builders( $template . '-builder');
					if( $hb_templates ) :
						foreach( $hb_templates as $hb_template ) :
							$template_id = $hb_template['id'];
							$template_title = $hb_template['title'];
							$assigned_pages['include'] = $hb_template['builder_placement'];
							$assigned_pages['exclude'] = $hb_template['builder_placement_exclude'];
							$assigned_pages['use'] = $hb_template['nekit_builder_in_use'];
							$nekit_admin_form_nonce = isset( $_POST['nekit_admin_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nekit_admin_form_nonce']) ): '';
							if ( wp_verify_nonce( $nekit_admin_form_nonce, 'nekit_admin_submit_builder_creation_action' ) ) {
								$active_manage_condition_template_id = isset( $_POST['condition_id'] ) ? intval( wp_unslash( $_POST['condition_id'] ) ) : 0;
							} else {
								$active_manage_condition_template_id = 0;
							}
							$nekit_404_active_template = get_option( 'nekit_404_active_template' );
							$template_active_label = ( $assigned_pages['use'] === '1' ) ? esc_html__( 'Enabled', 'news-kit-elementor-addons' ) : esc_html__( 'Disabled', 'news-kit-elementor-addons' );
							$builder_active_class = ( isset( $assigned_pages['include'] ) && ! empty( $assigned_pages['include'] ) && sizeof( $assigned_pages['include'] ) > 0 && $assigned_pages['use'] === '1' ) || ( $tab === '404-builder' && $nekit_404_active_template == $template_id );
							?>
								<div class="template-list-item <?php if( $builder_active_class ) echo 'builder-active' ?>" data-template="<?php echo absint( $template_id ); ?>">
									<div class="template-title-wrapper">
										<h2 class="template-title"><?php echo esc_html($template_title); ?></h2>
										<?php if( $tab !== '404-builder' ) : ?>
											<span class="template-switch<?php if( $assigned_pages['use'] === '1' ) echo esc_attr( ' isactive' ); ?>">
												<span class="template-switch-label"><?php echo esc_html( $template_active_label ); ?></span>
												<span class="template-switch-handle"></span>
											</span>
											<span class="template-saved-label"></span>
										<?php endif; ?>
									</div>
									<button class="edit-template" data-template="<?php echo absint($template_id); ?>"><a href="<?php echo esc_url( add_query_arg( [ 'post' => absint($template_id), 'action' => 'elementor' ], admin_url( 'post.php') ) ); ?>" target="_blank"><?php echo esc_html__( 'Edit Template', 'news-kit-elementor-addons' ); ?></a></button>
									<?php if( $tab != '404-builder' ) : ?>
										<button class="manage-template-conditions"><?php echo esc_html__( 'Manage Conditions', 'news-kit-elementor-addons' ); ?></button>
									<?php
										else:
											$isactive_or_not = ( $nekit_404_active_template == $template_id ) ? esc_html__( 'Enabled', 'news-kit-elementor-addons' ) : esc_html__( 'Disabled', 'news-kit-elementor-addons' );
									?>
											<span class="error-page-switch<?php if( $nekit_404_active_template == $template_id ) echo esc_attr( ' isactive' ); ?>">
												<span class="error-page-switch-label"><?php echo esc_html( $isactive_or_not ); ?></span>
												<span class="error-page-switch-handle"></span>
											</span>
											<span class="template-saved-label"></span>
									<?php endif; ?>
									<button class="show-delete-template-form" data-template-id="<?php echo absint($template_id); ?>" ><span class="dashicons dashicons-trash"></span></button>
								</div>
								<?php
									if( $tab != '404-builder' ) :
								?>
										<div class="nekit-admin-modal nekit-manage-condition-modal <?php if( $active_manage_condition_template_id == $template_id ) { echo esc_attr( 'isShow' ); } ?>" data-template-id="<?php echo absint($template_id); ?>">
											<div class="nekit-template-modal-inner">
												<div class="nekit-template-modal-inner-child">
													<span class="nekit-modal-close dashicons dashicons-no-alt"></span>
													<div class="header">
														<h2 class="modal-title">
															<?php echo esc_html__( 'Where Do You Want to Display Your Template?', 'news-kit-elementor-addons' ); ?>
														</h2>
														<p class="modal-sub-title"><?php echo wp_kses_post(sprintf( esc_html__( 'Set the conditions that determine where your template is used throughout your site. For example, choose %1s to display the template across your site.', 'news-kit-elementor-addons' ), '<strong>' . esc_html__( 'Entire Site', 'news-kit-elementor-addons' ) . '</strong>' ) ); ?></p>
													</div>
													<div class="body">
														<div class="inner-fields-group-wrap">
															<?php
																foreach( $assigned_pages as $assigned_pages_split_key => $assigned_pages_split ) :
																	if( $assigned_pages_split && is_array($assigned_pages_split) ) { // if builder is already assigned
																		foreach( $assigned_pages_split as $assigned_page_key => $assigned_page ) :
																			$archive_assigned_page = $singular_assigned_page = $single_posts_assigned_page = 'all';
																			$is_archives = strpos( $assigned_page, 'archives' );
																			if( $is_archives !== false ) {	// runs if archive is selected
																				$splits_placement = explode( '-', $assigned_page );
																				$assigned_page = $splits_placement[0];
																				$archive_assigned_page = $splits_placement[1];
																			}

																			$is_singular = strpos( $assigned_page, 'singular' );
																			if( $is_singular !== false ) {	// runs if singular is selected
																				$splits_placement = explode( '-', $assigned_page );
																				$assigned_page = $splits_placement[0];
																				$singular_assigned_page = $splits_placement[1];
																			}
																			// single  and archive builder
																			$is_single_posts = strpos( $assigned_page, 'posts' );
																			$is_single_pages = strpos( $assigned_page, 'pages' );
																			$is_archive_author = strpos( $assigned_page, 'archiveauthor' );
																			$is_archive_categories = strpos( $assigned_page, 'archivepostcategories' );
																			$is_archive_tags = strpos( $assigned_page, 'archiveposttags' );
																			$has_dash = strpos( $assigned_page, '-' );
																			if( ( $is_single_posts !== false || $is_single_pages !== false || $is_archive_author !== false || $is_archive_categories !== false || $is_archive_tags !== false ) && $has_dash !== false ) {
																				$splits_placement = explode( '-', $assigned_page );
																				$assigned_page = $splits_placement[0];
																				$single_posts_assigned_page = str_replace( 'nekit', '', $splits_placement[1] );
																			}
																			$parent_pages = $this->get_parent_pages_options_array(str_replace( '-builder', '', $tab ));
																?>
																				<div class="condition-field-group">
																					<div class="condition-field-inner-group">
																						<select class="template-condition-type">
																							<option value="include" <?php selected( $assigned_pages_split_key, 'include', true ); ?>><?php echo esc_html__( '+ Include', 'news-kit-elementor-addons' ); ?></option>
																							<option value="exclude" <?php selected( $assigned_pages_split_key, 'exclude', true ); ?>><?php echo esc_html__( '- Exclude ', 'news-kit-elementor-addons' ); ?></option>
																						</select>
																						<?php
																							if( is_array( $parent_pages ) ) :
																						?>
																								<select class="template-display-pages">
																									<?php
																										foreach( $parent_pages as $parent_page_key => $parent_page ) :
																									?>
																											<option value="<?php echo esc_attr( $parent_page_key ); ?>" <?php selected( $assigned_page, $parent_page_key, true ); ?>><?php echo esc_html( $parent_page ); ?></option>
																									<?php
																										endforeach;
																									?>
																								</select>
																						<?php
																							endif;

																							if( in_array( $tab, [ 'header-builder', 'footer-builder', 'popup-builder' ] ) ) :
																						?>
																								<select class="template-display-archives-pages <?php if( $assigned_page == 'archives' ) echo esc_attr( 'field-show' ); ?>">
																									<option value="all" <?php selected( $archive_assigned_page, 'all', true ); ?>><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></option>
																									<option value="category" <?php selected( $archive_assigned_page, 'category', true ); ?>><?php echo esc_html__( 'Category Archive', 'news-kit-elementor-addons' ); ?></option>
																									<option value="tag" <?php selected( $archive_assigned_page, 'tag', true ); ?>><?php echo esc_html__( 'Tags Archive', 'news-kit-elementor-addons' ); ?></option>
																									<option value="author" <?php selected( $archive_assigned_page, 'author', true ); ?>><?php echo esc_html__( 'Author Archive', 'news-kit-elementor-addons' ); ?></option>
																									<option value="date" <?php selected( $archive_assigned_page, 'date', true ); ?>><?php echo esc_html__( 'Date Archive', 'news-kit-elementor-addons' ); ?></option>
																									<option value="search" <?php selected( $archive_assigned_page, 'search', true ); ?>><?php echo esc_html__( 'Search Archive', 'news-kit-elementor-addons' ); ?></option>
																								</select>
																								<select class="template-display-singular-pages <?php if( $assigned_page == 'singular' ) echo esc_attr( 'field-show' ); ?>">
																									<option value="all" <?php selected( $singular_assigned_page, 'all', true ); ?>><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></option>
																									<option value="frontpage" <?php selected( $singular_assigned_page, 'frontpage', true ); ?>><?php echo esc_html__( 'Frontpage', 'news-kit-elementor-addons' ); ?></option>
																									<option value="post" <?php selected( $singular_assigned_page, 'post', true ); ?>><?php echo esc_html__( 'Post', 'news-kit-elementor-addons' ); ?></option>
																									<option value="page" <?php selected( $singular_assigned_page, 'page', true ); ?>><?php echo esc_html__( 'Page', 'news-kit-elementor-addons' ); ?></option>
																									<option value="404page" <?php selected( $singular_assigned_page, '404page', true ); ?>><?php echo esc_html__( '404 Page', 'news-kit-elementor-addons' ); ?></option>
																								</select>
																							<?php
																								endif;

																								if( in_array( $tab, ['single-builder','archive-builder'] ) ) :
																									$disable_field = apply_filters( 'nekit_pro_admin_field_filter', true );
																							?>
																									<input class="template-display-post_type-ids <?php if( in_array( $assigned_page, ['posts', 'pages', 'archiveauthor', 'archivepostcategories', 'archiveposttags'] ) ) echo esc_attr( 'field-show' ); ?>" type="text" value="<?php echo esc_attr($single_posts_assigned_page); ?>" placeholder="<?php echo esc_html__( 'Enter comma separated IDs', 'news-kit-elementor-addons' ); ?>" <?php disabled( $disable_field, true ); ?>>
																							<?php
																								endif;
																							?>
																					</div>
																					<div class="delete-field-group">
																						<span class="delete-row dashicons dashicons-no-alt"></span>
																					</div>
																				</div>
																<?php
																		endforeach;
																	}
																endforeach;
															?>
														</div>
														<?php $this->print_identical_condition_group(str_replace( '-builder', '', $tab )); ?>
														<div class="inner-fields-wrap">
															<button class="add-condition"><?php echo esc_html__( 'Add Conditions', 'news-kit-elementor-addons' ); ?></button>
														</div>
													</div>
													<div class="footer">
														<p class="nekit-modal-note"><?php echo wp_kses_post( sprintf( esc_html__( '%1s Duplicate conditions will be merged into one condition.', 'news-kit-elementor-addons' ), '<strong>' . esc_html__( 'Note : ', 'news-kit-elementor-addons' ) . '</strong>' ) ); ?></p>
														<button class="save-conditions"><?php echo esc_html__( 'Save & Exit', 'news-kit-elementor-addons' ); ?></button>
														<button class="edit-template" data-template="<?php echo absint($template_id); ?>"><a href="<?php echo esc_url( add_query_arg( [ 'post' => absint($template_id), 'action' => 'elementor' ], admin_url( 'post.php') ) ); ?>" target="_blank"><?php echo esc_html__( 'Edit Template', 'news-kit-elementor-addons' ); ?></a></button>
													</div>
												</div>
											</div>
										</div><!-- .nekit-manage-condition-modal.nekit-admin-modal -->
								<?php
									endif;
						endforeach;
					else : ?>
						<div class="tab-content-item empty-field">
							<?php echo esc_html( sprintf( esc_html__( 'You have not created any %1s templates yet!', 'news-kit-elementor-addons' ), esc_html( $template ) ) ); ?>
						</div>
						<?php
					endif;
				?>
			</div>
		<?php
	}

	/**
	 * Html content for template condition field group
	 * 
	 * @return html
	 */
	function print_identical_condition_group($tab = 'header') {
		$parent_pages = $this->get_parent_pages_options_array($tab);
		$disable_field = apply_filters( 'nekit_pro_admin_field_filter', true );
		?>
		<div class="condition-identical-group" style="display:none;">
			<div class="condition-field-group">
				<div class="condition-field-inner-group">
					<select class="template-condition-type">
						<option value="include"><?php echo esc_html__( '+ Include', 'news-kit-elementor-addons' ); ?></option>
						<option value="exclude"><?php echo esc_html__( '- Exclude ', 'news-kit-elementor-addons' ); ?></option>
					</select>
					<?php
						if( is_array( $parent_pages ) ) :
					?>
							<select class="template-display-pages">
								<?php
									foreach( $parent_pages as $parent_page_key => $parent_page ) :
								?>
										<option value="<?php echo esc_attr( $parent_page_key ); ?>"><?php echo esc_html( $parent_page ); ?></option>
								<?php
									endforeach;
								?>
							</select>
					<?php
						endif;
						
						if( in_array( $tab, [ 'header', 'footer', 'popup' ] ) ) :
					?>
							<select class="template-display-archives-pages">
								<option value="all"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></option>
								<option value="category"><?php echo esc_html__( 'Category Archive', 'news-kit-elementor-addons' ); ?></option>
								<option value="tag"><?php echo esc_html__( 'Tags Archive', 'news-kit-elementor-addons' ); ?></option>
								<option value="author"><?php echo esc_html__( 'Author Archive', 'news-kit-elementor-addons' ); ?></option>
								<option value="date"><?php echo esc_html__( 'Date Archive', 'news-kit-elementor-addons' ); ?></option>
								<option value="search"><?php echo esc_html__( 'Search Archive', 'news-kit-elementor-addons' ); ?></option>
							</select>
							<select class="template-display-singular-pages">
								<option value="all"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></option>
								<option value="frontpage"><?php echo esc_html__( 'Frontpage', 'news-kit-elementor-addons' ); ?></option>
								<option value="post"><?php echo esc_html__( 'Post', 'news-kit-elementor-addons' ); ?></option>
								<option value="page"><?php echo esc_html__( 'Page', 'news-kit-elementor-addons' ); ?></option>
								<option value="404page"><?php echo esc_html__( '404 Page', 'news-kit-elementor-addons' ); ?></option>
							</select>
					<?php
						endif;

						if( in_array( $tab, ['single','archive'] ) ) :
					?>
							<input class="template-display-post_type-ids" type="text" value="all" placeholder="<?php echo esc_html__( 'Enter comma separated IDs', 'news-kit-elementor-addons' ); ?>" <?php disabled( $disable_field, true ); ?>>
					<?php
						endif;
					?>
				</div>
				<div class="delete-field-group">
					<span class="delete-row dashicons dashicons-no-alt"></span>
				</div>
			</div>
		</div>
		<?php
	}

	// prepare the parent pages select dropdown options
	function get_parent_pages_options_array($tab = 'header') {
		$args_array = [];
		switch($tab) {
			case 'single': $args_array = apply_filters( 'nekit_theme_single_builder_condition_filter',[
							'frontpage'	=> esc_html__( 'Frontpage', 'news-kit-elementor-addons' ),
							'posts'	=> esc_html__( 'Posts', 'news-kit-elementor-addons' ),
							'pages'	=> esc_html__( 'Pages', 'news-kit-elementor-addons' )
						]);
						break;
			case 'archive': $args_array = apply_filters( 'nekit_theme_archive_builder_condition_filter', [
							'archives-all'	=> esc_html__( 'All Archives', 'news-kit-elementor-addons' ),
							'archiveposts'	=> esc_html__( 'Post Archive', 'news-kit-elementor-addons' ),
							'datearchive'	=> esc_html__( 'Date Archive', 'news-kit-elementor-addons' ),
							'searchresultsarchive'	=> esc_html__( 'Search Results', 'news-kit-elementor-addons' ),
							'archiveauthor'	=> esc_html__( 'Author Archive', 'news-kit-elementor-addons' ),
							'archivepostcategories'	=> esc_html__( 'Post Categories', 'news-kit-elementor-addons' ),
							'archiveposttags'	=> esc_html__( 'Post Tags', 'news-kit-elementor-addons' )
						]);
						break;
			default: $args_array = apply_filters( 'nekit_theme_builder_condition_filter', [
				'entire-site'	=> esc_html__( 'Entire Site', 'news-kit-elementor-addons' ),
				'archives-pro'	=> esc_html__( 'Archives ( in Pro )', 'news-kit-elementor-addons' ),
				'singular-pro'	=> esc_html__( 'Singular ( in Pro )', 'news-kit-elementor-addons' )
			]);
		}
		return apply_filters( 'nekit_admin_get_parent_pages_options_array_filter', $args_array );
	}

	// megamenu popup html
    function update_mega_menu_option_val() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
        $value = isset($_POST['value']) ? sanitize_text_field(wp_unslash($_POST['value'])) : '';
		$menu = isset($_POST['menu']) ? sanitize_text_field(wp_unslash($_POST['menu'])) : '';
		update_post_meta( $menu, 'nekit_mega_menu_option', sanitize_text_field($value) );
		$res['updated'] = true;
        wp_send_json_success( $res );
		wp_die();
	}

	// update megamenu form values
    function update_mega_menu_form() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
        $form_data = isset($_POST['formData']) ? sanitize_text_field(wp_unslash($_POST['formData'])) : '';
		$menu = isset($_POST['menu']) ? absint(wp_unslash($_POST['menu'])) : '';
		$form_data = json_decode($form_data, true);
		foreach( $form_data as $field_key => $field_data ) :
			update_post_meta( $menu, $field_data['name'], $field_data['value'] );
		endforeach;
		$res['updated'] = true;
        wp_send_json_success( $res );
		wp_die();
	}

	// save admin settings
    function create_template_action() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
        $template = isset($_POST['template']) ? sanitize_text_field(wp_unslash($_POST['template'])) : '';
        $templateTitle = isset($_POST['templateTitle']) ? sanitize_text_field(wp_unslash($_POST['templateTitle'])) : '';

		$template_post_type = ( $template == 'saved-templates' ) ? 'elementor_library': 'nekit-mm-cpt';
		$new_template_args = [
			'post_type'	=> esc_html( $template_post_type ),
			'post_title'   => esc_html( $templateTitle ),
			'post_content' => '',
			'post_status'	=> 'publish'
		];
		if( $template === 'popup-builder' ) $new_template_args[ 'post_content' ] = '<h2>' . esc_html__( 'This Popup content will appear on your site according to builder display conditions.', 'news-kit-elementor-addons' ) . '</h2>';
		$new_template_id = wp_insert_post( $new_template_args );
		if( $template == 'single-builder' || $template == 'archive-builder' ) {
			update_post_meta( $new_template_id, '_elementor_template_type', 'nekit-document' );
		} else if( $template == '404-builder' ) {
			update_post_meta( $new_template_id, 'builder_placement_status', 'active' );
		} else if( $template == 'saved-templates' ) {
			update_post_meta( $new_template_id, '_elementor_template_type', 'page' );
		}
		
		// add required post meta
		add_post_meta( $new_template_id, 'builder_type', $template );
		add_post_meta( $new_template_id, 'nekit_builder_in_use', true );
		add_post_meta( $new_template_id, 'builder_placement', [ 'entire-site' ] );
		add_post_meta( $new_template_id, 'builder_placement_exclude', [] );
		update_post_meta( $new_template_id, '_wp_page_template', 'elementor_canvas' ); // set canvas template
		$res['updated'] = true;
		$res['post_id'] = $new_template_id;
        wp_send_json_success( $res );
		wp_die();
	}

	// delete template action
	function delete_template_action() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
		$template_id = isset($_POST['template_id']) ? absint(wp_unslash($_POST['template_id'])) : '';
		if( ! current_user_can( 'delete_posts', $template_id ) ) :
			$res['deleted'] = false;
			wp_send_json_error( [ 'message' => 'Unauthorized Request' ], 401 );
			wp_die();
		endif;
        $template = isset($_POST['template']) ? sanitize_text_field(wp_unslash($_POST['template'])) : '';
		ob_start();
			if( $template ) {
				$template_status = get_post_status($template_id); // delete post
				if( $template_status ) {
					wp_delete_post( $template_id, true );
					$res['deleted'] = true;
				}
				$res['template_status'] = $template_status;
				$html = ob_get_clean();
			} else {
				$res['deleted'] = false;
			}
		$html = ob_get_clean();
		$res['html'] = $html;
        wp_send_json_success( $res );
		wp_die();
	}

	// add templates conditions
	function update_templates_meta_action() {
        check_ajax_referer( 'nekit-admin-nonce', 'security' );
		$template_id = isset($_POST['templateId']) ? sanitize_text_field(wp_unslash($_POST['templateId'])) : '';
		if( isset( $_POST['isEmpty'] ) && rest_sanitize_boolean( $_POST['isEmpty'] ) ) : // on empty conditions
			update_post_meta( $template_id, 'builder_placement', [] );
			update_post_meta( $template_id, 'builder_placement_exclude', [] );
			$res['updated'] = true;
			wp_send_json_success( $res );
			wp_die();
		else :
			$pages = isset($_POST['pages']) ? sanitize_text_field(wp_unslash($_POST['pages'])) : '';
			$conditions = isset($_POST['conditions']) ? sanitize_text_field(wp_unslash($_POST['conditions'])) : '';
			$conditionType = isset($_POST['conditionType']) ? sanitize_text_field(wp_unslash($_POST['conditionType'])) : '';
			$decoded_pages = json_decode( $pages, true );
			$decoded_conditions = json_decode( $conditions, true );
			if( $decoded_pages ) {
				update_post_meta( $template_id, 'builder_placement', [] );
				update_post_meta( $template_id, 'builder_placement_exclude', [] );
				foreach( $decoded_pages as $decoded_page_key => $decoded_page ) :
					if( ! apply_filters( 'nekit_check_plugin_status_filter', false ) ) :
						$check_valid_page = strpos( $decoded_page, '-pro' );
						if( $check_valid_page != false ) {
							$decoded_page = apply_filters( 'nekit_theme_builder_callback_value_filter', 'builder-callback-condition', $decoded_page );
						}
						$check_valid_innerpage = preg_match('~[0-9]+~', $decoded_page);
						if( $check_valid_innerpage ) {
							$decoded_page = apply_filters( 'nekit_theme_builder_callback_value_filter', 'inner-builder-callback-condition', $decoded_page );
						}
					endif;
					nekit_update_builder_post_meta( $decoded_conditions[$decoded_page_key], $decoded_page, $template_id );
				endforeach;
			}
			$res['updated'] = true;
			wp_send_json_success( $res );
			wp_die();
		endif;
	}

	// import template action
	function import_template_action() {
		check_ajax_referer( 'nekit-admin-nonce', 'security' );
		$demoId = isset($_POST['demoId']) ? sanitize_text_field(wp_unslash($_POST['demoId'])) : '';
		require( NEKIT_PATH . '/admin/importer/importer.php' );
		$importer = new Nekit_Importer();
		start_download_files();
		$res['loaded'] = false;
		wp_send_json_success( $res );
		wp_die();
	}

	/**
	 * Filter and Enqueue typography fonts
	 * 
	 * @package News Kit Elementor Addons Pro
	 * @since 1.0.0
	 */
	function get_fonts_url() {
		$filter = 'nekit_fonts_url_combine_filter';
		$action = function($filter,$id) {
			return apply_filters(
				$filter,
				$id
			);
		};
		$font1 = "Prompt:wght@100;200;300;400;500;600";
		$font2 = "Outfit:wght@100;300;400;500;600";
		$font3 = "Rubik:wght@100;300;400;500;600";
		$get_fonts = apply_filters( 'nekit_get_fonts_toparse', [$font1, $font2, $font3] );
		$font_weight_array = array();
		foreach ( $get_fonts as $fonts ) {
			$each_font = explode( ':', $fonts );
			if ( ! isset ( $font_weight_array[$each_font[0]] ) ) {
				$font_weight_array[$each_font[0]][] = $each_font[1];
			} else {
				if ( ! in_array( $each_font[1], $font_weight_array[$each_font[0]] ) ) {
					$font_weight_array[$each_font[0]][] = $each_font[1];
				}
			}
		}
		$final_font_array = array();
		foreach ( $font_weight_array as $font => $font_weight ) {
			$each_font_string = $font.':'.implode( ',', $font_weight );
			$final_font_array[] = $each_font_string;
		}

		$final_font_string = implode( '|', $final_font_array );
		$google_fonts_url = '';
		$subsets   = 'cyrillic,cyrillic-ext';
		if ( $final_font_string ) {
			$query_args = array(
				'family' => urlencode( $final_font_string ),
				'subset' => urlencode( $subsets )
			);
			$google_fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
		return $google_fonts_url;
	}

	/**
	 * Function to install or activate blaze demo importer
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.0.0
	 */
	function install_importer() {
		check_ajax_referer( 'nekit-admin-nonce', '_wpnonce' );
		$option = ( isset( $_POST['option'] ) ) ? sanitize_text_field(wp_unslash( $_POST['option'] )) : false;
		if( ! $option ) {
			$this->ajax_response['status'] = false;
			$this->ajax_response['message'] = esc_html__( 'Unable to get required parameters', 'news-kit-elementor-addons' );
			$this->send_popup_message();
		}
		$file_path = 'blaze-demo-importer/blaze-demo-importer.php';
		$message = '';
		if( $option == 'install' ) :
			$url = 'https://downloads.wordpress.org/plugin/blaze-demo-importer.zip';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
			require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
			$skin = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Plugin_Upgrader( $skin );
			$upgrader->install( $url );
			activate_plugin( $file_path, '', false, true );
			if( ! is_wp_error( activate_plugin( $file_path ) ) ) :
				$this->ajax_response['status'] = true;
				$this->ajax_response['message'] = esc_html__( 'Demo importer plugin installed and activated', 'news-kit-elementor-addons' );
				$this->send_popup_message();
			endif;
		elseif( $option == 'activate' ) :
			$plugin_path = WP_PLUGIN_DIR . '/blaze-demo-importer/blaze-demo-importer.php';
			if( file_exists( $plugin_path ) && ! is_plugin_active( $file_path ) ) :
				activate_plugin( $file_path, '', false, true );
				if( ! is_wp_error( activate_plugin( $file_path ) ) ) :
					$this->ajax_response['status'] = true;
					$this->ajax_response['message'] = esc_html__( 'Demo importer plugin activated', 'news-kit-elementor-addons' );
					$this->send_popup_message();
				endif;
			endif;
		endif;
		$this->ajax_response['status'] = false;
		$this->ajax_response['message'] = esc_html__( 'Error while trying to install or active the plugin.', 'news-kit-elementor-addons' );
		$this->send_popup_message();
	}

	public function send_popup_message() {
		wp_send_json_success( $this->ajax_response );
		wp_die();
	}

	public function remove_admin_notices() {
		if( isset( $_GET['page'] ) && in_array( $_GET['page'], ['news-kit-elementor-addons', 'news-kit-elementor-addons-pre-made-blocks', 'news-kit-elementor-addons-theme-builder', 'news-kit-elementor-addons-popup-builder','news-kit-elementor-addons-starter-sites','news-kit-elementor-addons-settings'] ) ) remove_all_actions( 'admin_notices' );
	}

	public function nekit_404_builder_active() {
		check_ajax_referer( 'nekit-admin-nonce', 'security' );
		$option = ( isset( $_POST['option'] ) ) ? $_POST['option'] : '';
		update_option( 'nekit_404_active_template', $option );
		wp_die();	
	}

	public function nekit_builder_active() {
		check_ajax_referer( 'nekit-admin-nonce', 'security' );
		$template_id = ( isset( $_POST['template_id'] ) ) ? absint( $_POST['template_id'] ) : 0;
		$template_active = ( isset( $_POST['template_active'] ) ) ? rest_sanitize_boolean( $_POST['template_active'] ) : false;
		update_post_meta( $template_id, 'nekit_builder_in_use', $template_active );
		wp_die();	
	}

	/**
	 * render contents in popup builder sub menu page
	 * 
	 * MARK: POPUP BUILDER
	 */
	public function admin_page_popup_builder_callback() {
		new Nekit_Popup_Builder\Popup_Builder();
	}

	/**
	 * Custom Menu page header
	 * MARK: HEADER
	 * 
	 * @package News Kit Elementor Addons
	 * @since 1.2.4
	 */
	public function nekit_admin_header() {
		$this->remove_admin_notices();

		global $submenu, $menu, $plugin_page;
		$nekit_main_menu_slug = 'news-kit-elementor-addons';
		$nekit_menus = array_key_exists( $nekit_main_menu_slug, $submenu ) ? $submenu[ $nekit_main_menu_slug ] : [];	/* Contains menu label, capability, etc */
		$nekit_menu_slugs = [];	/* Contains only slugs */
		$menuItemClass = 'menu-item';

		if( ! empty( $nekit_menus ) && is_array( $nekit_menus ) ) :
			foreach( $nekit_menus as $menu ) :
				/**
				 * $menu
				 * 
				 * 0 = menu title
				 * 1 = capability
				 * 2 = submenu slug
				 * 3 = page title
				 */
				$nekit_menu_slugs[] = $menu[2];
			endforeach;
		endif;

		if( ! empty( $nekit_menu_slugs ) && is_array( $nekit_menu_slugs ) && in_array( $plugin_page, $nekit_menu_slugs ) ) :
			if( in_array( $plugin_page, [ 'news-kit-elementor-addons-popup-builder', 'news-kit-elementor-addons-theme-builder' ] ) ) $menuItemClass .= ' active';
			?>
				<header class="nekit-section-header" id="nekit-section-header">
					<div class="nav-menu-wrapper">
						<div class="logo-wrapper">
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $nekit_main_menu_slug ) ); ?>">
								<img src="<?php echo esc_url( plugins_url( '/assets/images/logo.png', __FILE__ ) ); ?>">
							</a>
						</div><!-- .logo-wrapper -->
						<nav class="nekit-admin-nav-menu">
							<ul class="nav-menu">
								<li class="<?php echo esc_attr( $menuItemClass . ' has-sub-menu' ); ?>">
									<a href="#"><?php echo esc_html__( 'Builder', 'news-kit-elementor-addons' ); ?></a>
									<ul class="sub-menu">
										<li class="menu-item<?php if(( $this->current_tab === 'header-builder' ) && ( $plugin_page === 'news-kit-elementor-addons-theme-builder' )) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-theme-builder' ) ); ?>"><?php echo esc_html__( 'Header Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
										<li class="menu-item<?php if(( $this->current_tab === 'footer-builder' ) && ( $plugin_page === 'news-kit-elementor-addons-theme-builder' )) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-theme-builder&tab=footer-builder' ) ); ?>"><?php echo esc_html__( 'Footer Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
										<li class="menu-item<?php if(( $this->current_tab === 'single-builder' ) && ( $plugin_page === 'news-kit-elementor-addons-theme-builder' )) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-theme-builder&tab=single-builder' ) ); ?>"><?php echo esc_html__( 'Single Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
										<li class="menu-item<?php if(( $this->current_tab === 'archive-builder' ) && ( $plugin_page === 'news-kit-elementor-addons-theme-builder' )) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-theme-builder&tab=archive-builder' ) ); ?>"><?php echo esc_html__( 'Archive Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
										<li class="menu-item<?php if(( $this->current_tab === '404-builder' ) && ( $plugin_page === 'news-kit-elementor-addons-theme-builder' )) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-theme-builder&tab=404-builder' ) ); ?>"><?php echo esc_html__( '404 Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
										<li class="menu-item<?php if( $plugin_page === 'news-kit-elementor-addons-popup-builder' ) echo ' active'; ?>">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=news-kit-elementor-addons-popup-builder' ) ); ?>"><?php echo esc_html__( 'Popup Builder', 'news-kit-elementor-addons' ); ?></a>
										</li>
									</ul>
								</li>
								<li class="menu-item"><a href="<?php echo esc_url( '//blazethemes.com/news-kit-elementor-addons#nekit-pricing-wrap' ); ?>" target="_blank"><?php echo esc_html__( 'Free vs Pro', 'news-kit-elementor-addons' ); ?></a></li>
								<?php echo apply_filters( 'nekit_header_get_pro_filter', '<li class="menu-item get-pro"><a href="'. esc_url( '//blazethemes.com/news-kit-elementor-addons' ) .'" target="_blank"><span></span><span></span><span></span><span></span>'. esc_html__( 'Get Pro', 'news-kit-elementor-addons' ) .'</a></li>' );?>
							</ul>
						</nav>
					</div><!-- .nav-menu-wrapper -->
					<div class="nekit-admin-actions">
						<span class="free-or-pro"><?php echo apply_filters( 'nekit_free_pro_label_filter', esc_html__( 'Free', 'news-kit-elementor-addons' ) ); ?></span>
						<span class="version"><?php echo apply_filters( 'nekit_version_filter', esc_html__( 'Version 1.3.1', 'news-kit-elementor-addons' ) ); ?></span>
						<button class="action">
							<a href="<?php echo esc_url( '//forum.blazethemes.com/news-kit-elementor-addons/theme-builder/' ); ?>" target="_blank">
								<span class="icon dashicons dashicons-media-document"></span>
								<span class="label"><?php echo esc_html__( 'Documentation', 'news-kit-elementor-addons' ); ?></span>
							</a>
						</button>
						<button class="action">
							<a href="<?php echo esc_url( '//blazethemes.com/support/' ); ?>" target="_blank">
								<span class="icon dashicons dashicons-email"></span>
								<span class="label"><?php echo esc_html__( 'Support', 'news-kit-elementor-addons' ); ?></span>
							</a>
						</button>
						<?php 
							echo apply_filters( 'nekit_header_rating_filter', '<button class="action"><a href="'. esc_url( '//wordpress.org/support/plugin/news-kit-elementor-addons/reviews/?filter=5' ) .'" target="_blank"><span class="icon dashicons dashicons-star-half"></span><span class="label">'. esc_html__( 'Rating', 'news-kit-elementor-addons' ) .'</span></a></button>' );
						?>
					</div><!-- .nekit-admin-actions -->
				</header><!-- .nekit-section-header -->
			<?php
		endif;
	}

	/**
	 * MARK: DASHBOARD
	 * 
	 * @since 1.3.1
	 */
	public function admin_page_callback() {
		require_once( 'dashboard.php' );
		new Dashboard();
	}

	/**
	 * Nekit enable/disalbe widgets
	 * MARK: AJAX CALL
	 * 
	 * @since 1.3.1
	 */
	public function nekit_widgets_enable_disable_ajax_call() {
		check_ajax_referer( 'nekit-admin-nonce', '_wpnounce' );
		$disable_single = isset( $_POST[ 'disableSingle' ] ) ? rest_sanitize_boolean( $_POST[ 'disableSingle' ] ) : false;
		$disabled_widgets = nekit_get_settings([ 'key' => 'nekit_disabled_widgets' ]);
		if( $disable_single ) :
			$widget = isset( $_POST[ 'widgets' ] ) ? rest_sanitize_array( $_POST[ 'widgets' ] ) : [];
			$disabled_widgets = $widget;
		else:
			$widget_name = isset( $_POST[ 'widgetName' ] ) ? sanitize_text_field( $_POST[ 'widgetName' ] ) : '';
			$is_updated = false;
			if( ! empty( $disabled_widgets ) && is_array( $disabled_widgets ) && in_array( $widget_name, $disabled_widgets ) ) :
				$disabled_widgets = array_diff( $disabled_widgets, [ $widget_name ] );
			else:
				$disabled_widgets[] = $widget_name;
			endif;
		endif;
		$is_updated = nekit_update_settings([
			'key'	=>	'nekit_disabled_widgets',
			'value'	=>	$disabled_widgets
		]);
	}
}