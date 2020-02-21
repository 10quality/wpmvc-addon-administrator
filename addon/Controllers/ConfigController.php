<?php

namespace WPMVC\Addons\Administrator\Controllers;

use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\Controls\InputControl;
use WPMVC\Addons\Administrator\Controls\CheckboxControl;
use WPMVC\Addons\Administrator\Controls\SelectControl;
use WPMVC\Addons\Administrator\Controls\RadioControl;
use WPMVC\Addons\Administrator\Controls\PagesControl;
use WPMVC\Addons\Administrator\Controls\ChooseControl;

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
        $classes[CheckboxControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\CheckboxControl';
        $classes[SelectControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\SelectControl';
        $classes[RadioControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\RadioControl';
        $classes[PagesControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\PagesControl';
        $classes[ChooseControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\ChooseControl';
        return $classes;
    }
}