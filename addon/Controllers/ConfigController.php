<?php

namespace WPMVC\Addons\Administrator\Controllers;

use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\Controls\InputControl;

/**
 * Add-on configuration hooks.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
class ConfigController extends Controller
{
    /**
     * Registers administrator control classes.
     * @since 1.0.0
     * 
     * @hook wpmvc_addon_administrator_controls
     * 
     * @param array $controls
     * 
     * @return array
     */
    public function controls( $classes )
    {
        $classes[InputControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\InputControl';
        return $classes;
    }
}