<?php
/**
 * Import class for xml
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
class Nekit_Importer {
    public $configFile;
    public $uploads_dir;
    public $ajax_response = array();
    
    /**
     * A reference to an instance of this class.
     *
     * @since  1.0.0
     * @access private
     * @var    object
     */
    private static $instance = null;

    /**
     * Initiator
     *
     * @since 1.0.0
     * @return object
     */
    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct() {
        $this->uploads_dir = wp_get_upload_dir();
        add_action('wp_ajax_nekit_start_download_files', array($this, 'start_download_files'));
    }

    function start_download_files() {
        $demoId = isset($_POST['demoId']) ? sanitize_text_field($_POST['demoId']) : '';
        $downloads = $this->download_files($this->configFile[$demoId]['external_url']);
        if ($downloads) {
            $this->ajax_response['demo'] = $demoId;
            $this->send_ajax_response();
        }
    }

    public function download_files($external_url) {
        // Make sure we have the dependency.
        if (!function_exists('WP_Filesystem')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        /**
         * Initialize WordPress' file system handler.
         *
         * @var WP_Filesystem_Base $wp_filesystem
         */
        WP_Filesystem();
        global $wp_filesystem;

        $result = true;

        if (!($wp_filesystem->exists($this->demo_upload_dir()))) {
            $result = $wp_filesystem->mkdir($this->demo_upload_dir());
        }

        // Abort the request if the local uploads directory couldn't be created.
        if (!$result) {
            return false;
        } else {
            $demo_pack = $this->demo_upload_dir() . 'demo.zip';

            $file = wp_remote_retrieve_body(wp_remote_get($external_url, array(
                'timeout' => 60,
            )));
            $wp_filesystem->put_contents($demo_pack, $file);
            unzip_file($demo_pack, $this->demo_upload_dir());
            $wp_filesystem->delete($demo_pack);
            return true;
        }
    }

    function demo_upload_dir($path = '') {
        $upload_dir = $this->uploads_dir['basedir'] . '/nekit-import-files/' . $path;
        return $upload_dir;
    }
}