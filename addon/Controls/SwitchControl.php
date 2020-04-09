<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * HTML <input[type="radio"]> control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
 */
class SwitchControl extends Control
{
    /**
     * Control type.
     * @since 1.0.4
     * @var string
     */
    const TYPE = 'switch';
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
    protected $view = 'administrator.controls.switch';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.4
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'wpmvc-administrator-switch',
            addon_assets_url( 'css/switch.css', __FILE__ ),
            [],
            '1.0.4'
        );
        wp_enqueue_script(
            'wpmvc-administrator-switch',
            addon_assets_url( 'js/jquery.switch.js', __FILE__ ),
            ['jquery'],
            '1.0.4',
            true
        );
    }
    /**
     * Renders output.
     * @since 1.0.4
     * @param array $args
     */
    public function render( $args = [] )
    {
        $args['value'] = $args['value'] ? 1 : 0;
        parent::render( $args );
    }
}