<?php

namespace WPMVC\Addons\Administrator\Controllers;

use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\Controls\InputControl;
use WPMVC\Addons\Administrator\Controls\CheckboxControl;
use WPMVC\Addons\Administrator\Controls\SelectControl;
use WPMVC\Addons\Administrator\Controls\RadioControl;
use WPMVC\Addons\Administrator\Controls\PagesControl;
use WPMVC\Addons\Administrator\Controls\ChooseControl;
use WPMVC\Addons\Administrator\Controls\DatepickerControl;
use WPMVC\Addons\Administrator\Controls\MediaControl;
use WPMVC\Addons\Administrator\Controls\TextareaControl;
use WPMVC\Addons\Administrator\Controls\EditorControl;
use WPMVC\Addons\Administrator\Controls\Select2Control;
use WPMVC\Addons\Administrator\Controls\ColorpickerControl;
use WPMVC\Addons\Administrator\Controls\SwitchControl;

/**
 * Add-on configuration hooks.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
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
        $classes[DatepickerControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\DatepickerControl';
        $classes[MediaControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\MediaControl';
        $classes[TextareaControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\TextareaControl';
        $classes[EditorControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\EditorControl';
        $classes[Select2Control::TYPE] = 'WPMVC\Addons\Administrator\Controls\Select2Control';
        $classes[ColorpickerControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\ColorpickerControl';
        $classes[SwitchControl::TYPE] = 'WPMVC\Addons\Administrator\Controls\SwitchControl';
        return $classes;
    }
}