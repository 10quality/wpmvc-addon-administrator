<?php

namespace WPMVC\Addons\Administrator\Traits;

/**
 * Administrator settings model trait.
 * Implements an instance/singleton.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
trait SettingsTrait
{
    /**
     * Static instance constructor.
     * @since 1.0.0
     * 
     * @return \WPMVC\Addons\Administrator\Abstracts\SettingsModel
     */
    public static function instance()
    {
        if ( ! isset( static::$instance ) ) {
            static::$instance = self::find( self::ID );
        }
        return static::$instance;
    }
}