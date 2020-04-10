<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * jQuery datetimepicker control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
 */
class DatetimepickerControl extends Control
{
    /**
     * Control type.
     * @since 1.0.5
     * @var string
     */
    const TYPE = 'datetimepicker';
    /**
     * The control type, acts like ID identifier.
     * @since 1.0.5
     * @var string
     */
    protected $type = self::TYPE;
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.5
     * @var string
     */
    protected $view = 'administrator.controls.datetimepicker';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.5
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'jquery-datetimepicker',
            addon_assets_url( 'css/jquery.datetimepicker.min.css', __FILE__ ),
            [],
            '2.5.21'
        );
        wp_enqueue_script(
            'jquery-datetimepicker',
            addon_assets_url( 'js/jquery.datetimepicker.min.js', __FILE__ ),
            ['jquery'],
            '2.5.21',
            true
        );
        wp_enqueue_script(
            'wpmvc-administrator-datetimepicker',
            addon_assets_url( 'js/jquery.datetimepicker.js', __FILE__ ),
            ['jquery-datetimepicker'],
            '1.0.5',
            true
        );
    }
}