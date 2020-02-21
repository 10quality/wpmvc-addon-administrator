<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * HTML <select> control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
class SelectControl extends Control
{
    /**
     * Control type.
     * @since 1.0.0
     * @var string
     */
    const TYPE = 'select';
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.0
     * @var string
     */
    protected $view = 'administrator.controls.select';
}