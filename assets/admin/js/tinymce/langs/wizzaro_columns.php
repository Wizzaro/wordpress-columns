<?php
use Wizzaro\Columns\v1\Config\Config;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '_WP_Editors' ) ) {
    require( ABSPATH . WPINC . '/class-wp-editor.php' );
}

function wizzaro_columns_add_tinymce_plugin_translation() {
     $languages_domain = Config::get_instance()->get( 'languages', 'domain' );

     $i18n = array(
         'add_button_title' => __( 'Add column', $languages_domain ),
         'last_column_in_row' => __( 'Last column in row?', $languages_domain )
     );

     $editor_locale = _WP_Editors::$mce_locale;
     $translated = 'tinyMCE.addI18n("' . $editor_locale . '.wizzaro_columns", ' . json_encode( $i18n ) . ");\n";

     return $translated;
}

$strings = wizzaro_columns_add_tinymce_plugin_translation();
