<?php
namespace Wizzaro\Columns\v1;

use Wizzaro\Columns\v1\Config\Config;
use _WP_Editors;

class Plugin {

    private static $instance;
    private $config;

    protected function __construct() {
        $this->config = Config::get_instance();

        add_shortcode( $this->config->get( 'shortcode', 'tag' ), array( $this, 'render_shortcode' ), 10, 2 );

		if ( is_admin() ){
			add_action( 'admin_head', array( $this, 'action_admin_head' ) );
			add_action( 'admin_enqueue_scripts', array( $this , 'action_admin_enqueue_scripts' ) );
		} else {
            wp_register_style( 'wizzaro-columns-style', $this->config->get_plugin_dir_url() . 'assets/css/wizzaro-columns.css', array(), '1.0' );
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
    public function render_shortcode( $atts , $content = null ) {
        wp_enqueue_style( 'wizzaro-columns-style' );
        
        $grid = $this->config->get_group( 'grid' );
        $class = '';

        foreach ( $grid['screens'] as $key => $settings) {
            if ( array_key_exists( $key, $atts ) && array_key_exists( $atts[$key], $grid['columns'] ) ) {
                $class .= ' ' . $settings['class_prefix'] . esc_attr( $atts[$key] );
            }
        }

        $shortcode_view = sprintf( $grid['column_html'], trim( $class ), \do_shortcode( $content ) );

        if ( array_key_exists( 'last_column_in_row', $atts ) && 'true' === $atts['last_column_in_row'] ) {
            $shortcode_view .= $grid['clearfix_html'];
        }

		return $shortcode_view;
	}

    //Functions for admin
    public function action_admin_head() {
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}

		// check if WYSIWYG is enabled
		if ( true == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this ,'filter_mce_external_plugins' ) );
            add_filter( 'mce_external_languages', array( $this ,'filter_mce_external_languages' ) );
			add_filter( 'mce_buttons', array($this, 'filter_mce_buttons' ) );
            wp_localize_script('editor', 'wpWizzaroColumns', array(
                'shortcode' => $this->config->get_group( 'shortcode' ),
                'grid' => $this->config->get_group( 'grid' )
            ));
		}
	}

	public function filter_mce_external_plugins( $plugin_array ) {
		$plugin_array['wizzaro_columns'] = $this->config->get_plugin_dir_url() . 'assets/admin/js/wizzaro-columns.min.js';
		return $plugin_array;
	}

    public function filter_mce_external_languages( $locales ) {
        $locales['wizzaro_columns'] = $this->config->get_plugin_dir_path() . 'assets/admin/js/tinymce/langs/wizzaro_columns.php';
        return $locales;
    }

	public function filter_mce_buttons( $buttons ) {
		array_push( $buttons, 'wizzaro_column_add' );
		return $buttons;
	}

	public function action_admin_enqueue_scripts(){
		 wp_enqueue_style( 'wizzaro-columns-admin-style', $this->config->get_plugin_dir_url() . 'assets/admin/css/wizzaro-columns.css' );
	}
}
