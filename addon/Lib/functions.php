<?php

use WPMVC\Addons\Administrator\AdministratorAddon;

/**
 * Global functions.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */

if ( ! function_exists( 'wpmvc_addon_administrator_control_value' ) ) {
    /**
     * Returns a control value.
     * @since 1.0.0
     * 
     * @param array|string $control
     * @param string       $key
     * @param mixed        $default
     * 
     * @return mixed 
     */
    function wpmvc_addon_administrator_control_value( $control, $key, $default = null )
    {
        return is_array( $control ) && array_key_exists( $key, $control ) ? $control[$key] : $default;
    }
}