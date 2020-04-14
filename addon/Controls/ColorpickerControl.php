<?php

namespace WPMVC\Addons\Administrator\Controls;

use TenQuality\WP\File;
use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * Select2 control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.6
 */
class ColorpickerControl extends Control
{
    /**
     * Control type.
     * @since 1.0.4
     * @var string
     */
    const TYPE = 'colorpicker';
    /**
     * The control type, acts like ID identifier.
     * @since 1.0.4
     * @var string
     */
    protected $type = self::TYPE;
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.4
     * @var string
     */
    protected $view = 'administrator.controls.colorpicker';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.4
     */
    public function enqueue()
    {
        wpmvc_enqueue_addon_resource( 'spectrum' );
        wpmvc_enqueue_addon_resource( 'wpmvc-colorpicker' );
    }
}