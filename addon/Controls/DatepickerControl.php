<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * jQuery datepicker control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.6
 */
class DatepickerControl extends Control
{
    /**
     * Control type.
     * @since 1.0.0
     * @var string
     */
    const TYPE = 'datepicker';
    /**
     * The control type, acts like ID identifier.
     * @since 1.0.0
     * @var string
     */
    protected $type = self::TYPE;
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.0
     * @var string
     */
    protected $view = 'administrator.controls.datepicker';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.0
     */
    public function enqueue()
    {
        wpmvc_enqueue_addon_resource( 'jquery-ui-datepicker' );
        wpmvc_enqueue_addon_resource( 'wpmvc-datepicker' );
    }
}