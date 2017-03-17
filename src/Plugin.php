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

        add_shortcode( $this->config->get( 'shordcode', 'tag' ), array( $this, 'render_shordcode' ) );

		if ( is_admin() ){
			add_action( 'admin_head', array( $this, 'action_admin_head' ) );
			add_action( 'admin_enqueue_scripts', array( $this , 'action_admin_enqueue_scripts' ) );
		}
    }

    protected function __clone() {}

    public static function create() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    //Function for front
    public function render_shordcode($atts , $content = null){
		return '';
	}

    //Functions for admin
    public function action_admin_head() {
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}

		// check if WYSIWYG is enabled
		if ( true == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this ,'filter_mce_external_plugins' ) );
			add_filter( 'mce_buttons', array($this, 'filter_mce_buttons' ) );
		}
	}

	public function filter_mce_external_plugins( $plugin_array ) {
		//$plugin_array[$this->config->get( 'shordcode', 'tag' )] = plugins_url( 'assets/js/mce-button.min.js' , __FILE__ );
		return $plugin_array;
	}

	public function filter_mce_buttons( $buttons ) {
		//array_push( $buttons, $this->config->get( 'shordcode', 'tag' ) );
		return $buttons;
	}

	public function action_admin_enqueue_scripts(){
		 //wp_enqueue_style('bs3_panel_shortcode', plugins_url( 'assets/css/mce-button.css' , __FILE__ ) );
	}
}
