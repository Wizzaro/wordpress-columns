<?php
namespace Wizzaro\Columns\v1;

return array(
    'path' => array (
        'main_file' => realpath( __DIR__ . '/../' . 'wizzaro-columns.php' )
    ),
    'languages' => array(
        'domain' => 'wizzaro-columns'
    ),
    'shortcode' => array(
        'tag' => 'wizzaro_column'
    ),
    'grid' => array(
        'column_html' => '<div class="%s">%s</div>',
        'clearfix_html' => '<div class="wizzaro-clearfix"></div>',
        'screens' => array(
            'desktop' => array(
                'label' => __( 'Desktop width', 'wizzaro-columns' ),
                'class_prefix' => 'wizzaro-col-',
            ),
            'tablet' => array(
                'label' => __( 'Tablet width', 'wizzaro-columns' ),
                'class_prefix' => 'wizzaro-col-tab-',
            ),
            'mobile_phone' => array(
                'label' => __( 'Mobile phone width', 'wizzaro-columns' ),
                'class_prefix' => 'wizzaro-col-mp-',
            ),
        ),
        'columns' => array(
            'wizzaro_column_empty_size'  => '---------',
            '5'  => '5%',
            '10' => '10%',
            '15' => '15%',
            '20' => '20%',
            '25' => '25%',
            '30' => '30%',
            '33' => '33%',
            '35' => '35%',
            '40' => '40%',
            '45' => '45%',
            '50' => '50%',
            '55' => '55%',
            '60' => '60%',
            '65' => '65%',
            '66' => '66%',
            '70' => '70%',
            '75' => '75%',
            '80' => '80%',
            '85' => '85%',
            '90' => '90%',
            '95' => '95%',
            '100' => '100%',
        )
    )
);
