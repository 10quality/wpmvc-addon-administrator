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
class Select2Control extends Control
{
    /**
     * Control type.
     * @since 1.0.4
     * @var string
     */
    const TYPE = 'select2';
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
    protected $view = 'administrator.controls.select2';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.4
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'select2',
            addon_assets_url( 'css/select2.min.css', __FILE__ ),
            [],
            '4.0.13'
        );
        wp_enqueue_script(
            'select2',
            addon_assets_url( 'js/select2.min.js', __FILE__ ),
            ['jquery'],
            '4.0.13',
            true
        );
        wp_enqueue_script(
            'wpmvc-administrator-select2',
            addon_assets_url( 'js/jquery.select2.js', __FILE__ ),
            ['select2'],
            '1.0.4',
            true
        );
        // i18n support
        $locale = substr( get_locale(), 0, 2 );
        wp_enqueue_script(
            'select2-i18n-' . $locale,
            addon_assets_url( 'js/i18n/' . $locale . '.js', __FILE__ ),
            ['select2'],
            '4.0.13',
            true
        );
    }
}