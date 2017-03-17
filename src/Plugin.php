<?php
namespace Wizzaro\Columns\v1;

use Wizzaro\Columns\v1\Config\Config;
use Wizzaro\Columns\v1\Helper\Arrays;

class Plugin {

    private static $instance;
    private $config;

    protected function __construct() {
        $config = include realpath(__DIR__ . '/../config/plugin.config.php');

        $local_config_file = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'wizzaro' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'columns' . DIRECTORY_SEPARATOR . 'plugin.config.local.php';

        if ( file_exists( $local_config_file ) ) {
            $local_config = include $local_config_file;

            if ( is_array( $local_config ) ) {
                $config = Arrays::get_instance()->deep_merge( $config, $local_config );
            }
        }

        $this->config = new Config( $config );
    }

    protected function __clone() {}

    public static function create() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
