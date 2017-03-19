<?php
namespace Wizzaro\Columns\v1\Config;

use Wizzaro\Columns\v1\Helper\Arrays;

class Config {
    private static $instance;
    protected $config = array();

    protected function __construct() {
        $config = include realpath( __DIR__ . '/../../config/plugin.config.php' );

        $local_config_file = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'wizzaro' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'columns' . DIRECTORY_SEPARATOR . 'plugin.config.local.php';

        if ( file_exists( $local_config_file ) ) {
            $local_config = include $local_config_file;

            if ( is_array( $local_config ) ) {
                $config = Arrays::get_instance()->deep_merge( $config, $local_config );
            }
        }

        $this->config = $config;
    }

    protected function __clone(){}

    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get_group( $group, $default = array() ) {
        if ( isset( $this->config[$group] ) ) {
            return $this->config[$group];
        }

        return $default;
    }

    public function get( $group, $key, $default = '' ) {
        if ( isset( $this->config[$group][$key] ) ) {
            return $this->config[$group][$key];
        }

        return $default;
    }

    public function get_plugin_dir_path() {
        if ( ! isset( $this->config['path']['dir'] ) ) {
            $this->config['path']['dir'] = plugin_dir_path( $this->config['path']['main_file'] );
        }

        return $this->config['path']['dir'];
    }

    public function get_plugin_dir_url() {
        if ( ! isset( $this->config['path']['url'] ) ) {
            $this->config['path']['url'] = plugin_dir_url( $this->config['path']['main_file'] );
        }

        return $this->config['path']['url'];
    }
}
