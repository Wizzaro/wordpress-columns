<?php
namespace Wizzaro\Columns\v1;

class Plugin {

    private static $instance;

    protected function __construct() {}
    protected function __clone() {}

    public static function create() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
