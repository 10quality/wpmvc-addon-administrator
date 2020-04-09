<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * Select2 control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
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
        wp_enqueue_style(
            'spectrum',
            addon_assets_url( 'css/spectrum.css', __FILE__ ),
            [],
            '1.8.0'
        );
        wp_enqueue_script(
            'spectrum',
            addon_assets_url( 'js/spectrum.js', __FILE__ ),
            ['jquery'],
            '1.8.0',
            true
        );
        wp_enqueue_script(
            'wpmvc-administrator-colorpicker',
            addon_assets_url( 'js/jquery.colorpicker.js', __FILE__ ),
            ['select2', 'spectrum'],
            '1.0.4',
            true
        );
        // i18n support
        $locale = substr( get_locale(), 0, 2 );
        wp_enqueue_script(
            'spectrum-i18n-' . $locale,
            addon_assets_url( 'js/i18n/' . $locale . '.js', __FILE__ ),
            ['spectrum'],
            '1.8.0',
            true
        );
    }
}