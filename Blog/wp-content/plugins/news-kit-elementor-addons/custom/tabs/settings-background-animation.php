<?php
// namespace Elementor\Core\Kits\Documents\Tabs;
namespace News_Kit_Elementor_Addons_Tabs;
use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Core\Files\Uploads_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'Nekit_Settings_Background_Animation' ) ) :
    class Nekit_Settings_Background_Animation extends \Elementor\Core\Kits\Documents\Tabs\Tab_Base {
        public function get_id() {
            return 'nekit-settings-background-animation';
        }

        public function get_title() {
            return esc_html__( 'Background Animation', 'news-kit-elementor-addons' );
        }

        public function get_group() {
            return 'settings';
        }

        public function get_icon() {
            return 'eicon-background';
        }

        public function get_help_url() {
            return 'https://forum.blazethemes.com/news-elementor/addons/#background-animation-site-settings';
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
                'nekit_background_animation_option',
                [
                    'label'	=>	esc_html__( 'Type', 'news-kit-elementor-addons' ),
                    'type'	=>	\Elementor\Controls_Manager::SELECT,
                    'default'	=>	'none',
                    'options'	=>	[
                        'none'  => esc_html__( 'None', 'news-kit-elementor-addons' ),
                        'one'  => esc_html__( 'Animation 1', 'news-kit-elementor-addons' ),
                        'two'  => esc_html__( 'Animation 2', 'news-kit-elementor-addons' ),
                        'three'  => esc_html__( 'Animation 3', 'news-kit-elementor-addons' )
                    ]
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

            if ( isset( $data['settings']['nekit_background_animation_option'] ) ) {
                update_option( 'nekit_background_animation_option', $data['settings']['nekit_background_animation_option'] );
            } else {
                update_option( 'nekit_background_animation_option', 'none' );
            }
        }
    }
endif;