<?php
namespace Wizzaro\Columns\v1\Config;

class Config {

    protected $_config = array();

    public function __construct( array $config = array() ) {
        $this->_config = $config;
    }

    public function get_group( $group, $default = array() ) {
        if ( isset( $this->_config[$group] ) ) {
            return $this->_config[$group];
        }

        return $default;
    }

    public function get( $group, $key, $default = '' ) {
        if ( isset( $this->_config[$group][$key] ) ) {
            return $this->_config[$group][$key];
        }

        return $default;
    }
}
