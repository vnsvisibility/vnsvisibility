<?php
/**
 * Base class to handle popup builder
 * 
 * @package News Kit Elementor Addons
 * @since 1.2.3
 */

 namespace Nekit_Popup_Builder;
 use News_Kit_Elementor_Addons_Admin;
 if( ! class_exists( 'Popup_Builder' ) ) :
    /**
     * Popup Builder class
     */
    class Popup_Builder {
        /**
         * Method that gets called when class is instantiated
         * 
         * @since 1.2.3
         */
        public function __construct() {
            $this->html_template();
        }

        /**
         * Render the html of Popup Builder submenu page
         * 
         * @since 1.2.3
         */
        public function html_template() {
            $tab = 'popup-builder';
            $admin = new News_Kit_Elementor_Addons_Admin\Admin();
            $admin->current_tab = 'popup-builder';
            ?>
                <div id="nekit-admin-page">
                    <div class="page-header">
                        <h2 class="page-title"><?php echo esc_html__( 'News Kit Elementor Addons', 'news-kit-elementor-addons' ); ?></h2>
                        <p><?php echo esc_html__( 'Manage popup builder settings', 'news-kit-elementor-addons' ); ?></p>
                        <button class="video-redirect-button"><a href="https://www.youtube.com/" target="_blank"><?php echo esc_html__( 'How Does Popup Builder Work?', 'news-kit-elementor-addons' ); ?><span class="dashicons dashicons-youtube"></span></a></button>
                    </div>
                    <div class="page-content">
                        <ul class="tabs-title-wrap">
                            <li class="tab-title<?php if($tab == 'popup-builder') echo ' active-tab' ?>"><a href="<?php echo esc_url( add_query_arg( 'tab', 'popup-builder' ) ); ?>"><?php echo esc_html__( 'Popup', 'news-kit-elementor-addons' ); ?></a></li>
                        </ul>
                        <div class="<?php echo esc_attr( str_replace( '404', 'error-page', $tab ) ); ?>-tabs-content">
                            <div class="tab-content-header">
                                <button class="show-create-template-form"><?php echo esc_html( sprintf( /* translators: %1s: Template name */ esc_html__( 'Create %1s Template', 'news-kit-elementor-addons' ), esc_html( str_replace( '-builder', '', $tab ) ) ) ); ?><span class="dashicons dashicons-plus-alt2"></span></button>
                            </div>
                            <div class="tab-content-body"><?php $admin->print_template_list(str_replace( '-builder', '', $tab )); ?></div>
                        </div>
                    </div>
                    <div id="nekit-create-template-modal" class="nekit-admin-modal" data-template="<?php echo esc_attr($tab) ?>">
                        <div class="nekit-template-modal-inner">
                            <span class="nekit-modal-close dashicons dashicons-no-alt"></span>
                            <div class="header">
                                <h2 class="modal-title">
                                    <?php echo esc_html__( 'New Popup Template', 'news-kit-elementor-addons' ); ?>
                                </h2>
                                <p class="modal-sub-title">
                                    <?php echo esc_html__( 'Templates gives you choices of different layouts on your websites. You can choose different templates for different popups for different period of time', 'news-kit-elementor-addons' ); ?>
                                </p>
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
                                    <?php echo esc_html__( 'Are you sure you want to delete this popup template ?', 'news-kit-elementor-addons' ); ?>
                                </h2>
                                <p class="modal-sub-title"><?php echo esc_html__( 'Once done You cannot revert this process.', 'news-kit-elementor-addons' ); ?></p>
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
    }
 endif;