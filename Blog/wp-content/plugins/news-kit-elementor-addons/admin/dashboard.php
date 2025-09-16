<?php
    /**
     * Nekit Admin Dashboard
     * 
     * @package News Kit Elementor Addons
     * @since 1.3.1
     */
    namespace News_Kit_Elementor_Addons_Admin;
    use Elementor\Plugin as Elementor;
    use Nekit_Utilities\Utils as Nekit_Utils;

    class Dashboard {
        
        /**
         * Elementor instance
         * 
         * @since 1.3.1
         */
        public $elementor_instance;
        
        /**
         * Nekit widgets
         * 
         * @since 1.3.1
         */
        public $nekit_widgets;
        
        /**
         * Nekit widget categories
         * 
         * @since 1.3.1
         */
        public $nekit_widgets_categories;
        
        /**
         * Nekit Pro Widgets
         * 
         * @since 1.3.1
         */
        public $nekit_pro_widgets;
        
        /**
         * Nekit Pro Widgets
         * 
         * @since 1.3.1
         */
        public $nekit_disabled_widgets;

        /**
         * Method that gets called when class is instantiated
         * 
         * @since 1.3.1
         */
        public function __construct() {
            $this->elementor_instance = Elementor::instance();
            $this->nekit_widgets = Nekit_Utils::registered_widgets();
            $this->nekit_widgets_categories = Nekit_Utils::get_nekit_widget_categories();
            $this->nekit_pro_widgets = Nekit_Utils::get_nekit_pro_widgets();
            $this->nekit_disabled_widgets = nekit_get_settings([ 'key' => 'nekit_disabled_widgets' ]);
            $this->init();
        }

        /**
         * Initialize all methods from here
         * 
         * @since 1.3.1
         */
        public function init() {
            $is_pro = apply_filters( 'nekit_is_pro_active_filter', false );
            ?>
                <div class="nekit-admin-dashboard">
                    <div class="welcome-upsell-wrapper">
                        <?php
                            $this->welcome();
                            if( ! $is_pro ) $this->upsell();
                        ?>
                    </div>
                    <?php 
                        $this->warning();
                        $this->widgets();
                    ?>
                </div>
            <?php
        }

        /**
         * Render Welcome notice
         * 
         * @since 1.3.1
         */
        public function welcome() {
            ?>
                <div class="welcome-wrapper block">
                    <h2 class="title"><?php echo esc_html__( 'Welcome to News Kit Elementor Addons.', 'news-kit-elementor-addons' ); ?></h2>
                    <p class="description"><?php echo esc_html__( 'All News focused elementor widgets that you are looking for in Elementor Page Builder. Currently, with 57 feature rich widgets and theme builder you can develop a complete news or blog website easily.', 'news-kit-elementor-addons' ); ?></p>
                </div>
            <?php
        }

        /**
         * Render upsell notice
         * 
         * @since 1.3.1
         */
        public function upsell() {
            $pro_features = [
                esc_html__( 'Video Playlist Widget', 'news-kit-elementor-addons' ),
                esc_html__( 'Breadcrumb Widget', 'news-kit-elementor-addons' ),
                esc_html__( 'Tag Clouds Animation Widget', 'news-kit-elementor-addons' ),
                esc_html__( 'Single Related Post Widget', 'news-kit-elementor-addons' )
            ];
            ?>
                <div class="upsell-wrapper block">
                    <h2 class="title"><?php echo esc_html__( 'Upgrade to Pro', 'news-kit-elementor-addons' ); ?></h2>
                    <ul class="pro-features">
                        <?php
                            if( ! empty( $pro_features ) && is_array( $pro_features ) ) :
                                foreach( $pro_features as $feature ) :
                                    ?>
                                        <li class="feature">
                                            <span class="dashicons dashicons-awards"></span>
                                            <span class="label"><?php echo esc_html( $feature ); ?></span>
                                        </li>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                    </ul>
                    <button class="upgrade-button">
                        <a href="<?php echo esc_url( '//blazethemes.com/news-kit-elementor-addons#nekit-pricing-wrap' ); ?>" target="_blank">
                            <?php echo esc_html__( 'Upgrade Now', 'news-kit-elementor-addons' ); ?>
                        </a>
                    </button>
                </div>
            <?php
        }

        /**
         * Render Warning
         * 
         * @since 1.3.1
         */
        public function warning() {
            ?>
                <div class="warning-wrapper">
                    <span class="warning-description"><?php echo esc_html__( 'Deactivating widgets here will remove them from both the Editor and your website, which can cause changes to your overall layout, design and what visitors see.', 'news-kit-elementor-addons' ); ?></span>
                    <button class="hide-warning"><?php echo esc_html__( 'Hide', 'news-kit-elementor-addons' ); ?></button>
                </div>
            <?php
        }

        /**
         * Render Widgets
         * 
         * @since 1.3.1
         */
        public function widgets() {
            $disabled_widgets = ( ! empty( $this->nekit_disabled_widgets ) && is_array( $this->nekit_disabled_widgets ) ) ? $this->nekit_disabled_widgets : [];
            ?>
                <div class="widgets-wrapper">
                    <?php $this->widgets_header(); ?>
                    <div class="widget-category-wrapper">
                        <?php
                            if( ! empty( $this->nekit_widgets_categories ) && is_array( $this->nekit_widgets_categories ) ) :
                                foreach( $this->nekit_widgets_categories as $cat_key => $cat_value ) :
                                    $cat_label = $cat_value[ 'label' ];
                                    $cat_widgets = $cat_value[ 'widgets' ];
                                    $cat_category = $cat_value[ 'category' ];
                                    $widgetCategoryClass = 'widget-category ' . $cat_category;
                                    ?>
                                        <div class="<?php echo esc_attr( $widgetCategoryClass ); ?>" data-category="<?php echo esc_html__( $cat_key ); ?>">
                                            <h2 class="title"><?php echo esc_html( $cat_label ); ?></h2>
                                            <div class="widgets">
                                                <?php
                                                    if( ! empty( $cat_widgets ) && is_array( $cat_widgets ) ) :
                                                        foreach( $cat_widgets as $widget_key ) :
                                                            $widgetClass = 'widget';
                                                            $is_disabled = in_array( $widget_key, $disabled_widgets );
                                                            if( ! $is_disabled ) $widgetClass .= ' widget-active';
                                                            if( in_array( $widget_key, $this->nekit_pro_widgets ) ) $widgetClass .= ' pro';
                                                            ?>
                                                                <div class="<?php echo esc_attr( $widgetClass ); ?>" data-name="<?php echo esc_attr( $widget_key ); ?>">
                                                                    <span class="icon"><i class="<?php echo esc_attr( $this->nekit_widgets[ $widget_key ][ 'icon' ] ); ?>"></i></span>
                                                                    <span class="label"><?php echo esc_html( $this->nekit_widgets[ $widget_key ][ 'name' ] ); ?></span>
                                                                    <button class="template-switch">
                                                                        <span class="template-switch-label"></span>
                                                                        <span class="template-switch-handle"></span>
                                                                    </button>
                                                                </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                    </div>
                    <div class="no-widgets-found"><?php echo esc_html__( 'No such widget.', 'news-kit-elementor-addons' ); ?></div>
                </div>
            <?php
        }

        /**
         * Render Widgets Header
         * 
         * @since 1.3.1
         */
        public function widgets_header() {
            $toggleWidgetsClass = 'toggle-widgets';
            if( empty( $this->nekit_disabled_widgets ) ) $toggleWidgetsClass .= ' widget-active';
            ?>
                <div class="widgets-header-wrapper">
                <h2 class="title"><?php echo esc_html__( 'Widgets', 'news-kit-elementor-addons' ); ?></h2>
                    <div class="<?php echo esc_attr( $toggleWidgetsClass ); ?>">
                        <h2 class="label"><?php echo esc_html__( 'Toggle all Widgets', 'news-kit-elementor-addons' ); ?></h2>
                        <button class="template-switch">
                            <span class="template-switch-label"></span>
                            <span class="template-switch-handle"></span>
                        </button>
                    </div>
                </div>
                <div class="filter-buttons">
                    <button class="filter-button all active"><?php echo esc_html__( 'All', 'news-kit-elementor-addons' ); ?></button>
                    <button class="filter-button general"><?php echo esc_html__( 'General', 'news-kit-elementor-addons' ); ?></button>
                    <button class="filter-button theme-builder"><?php echo esc_html__( 'Theme Builder', 'news-kit-elementor-addons' ); ?></button>
                    <div class="search-wrapper">
                        <input value="" type="search" name="widgets_search" placeholder="<?php echo esc_html__( 'Type to search . .', 'news-kit-elementor-addons' ); ?>">
                        <span class="dashicons dashicons-search"></span>
                    </div>
                </div>
            <?php
        }
    }