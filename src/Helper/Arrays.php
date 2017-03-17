<?php
namespace Wizzaro\Columns\v1\Helper;

class Arrays {

    private static $instance;

    protected function __construct() {}
    protected function __clone() {}

    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function deep_merge( $array1, $array2 ) {
        $merged = $array1;

        foreach ( $array2 as $key => &$value )
        {
            if ( is_array( $value ) && isset( $merged[$key] ) && is_array( $merged[$key] ) ) {
                $merged[$key] = $this->deep_merge( $merged[$key], $value );
            } else if ( is_numeric( $key ) ) {
                 if ( ! in_array( $value, $merged ) )
                    $merged[] = $value;
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
