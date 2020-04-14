<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * HTML <input[type="radio"]> control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.6
 */
class ChooseControl extends Control
{
    /**
     * Control type.
     * @since 1.0.0
     * @var string
     */
    const TYPE = 'choose';
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
    protected $view = 'administrator.controls.choose';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.0
     */
    public function enqueue()
    {
        wpmvc_enqueue_addon_resource( 'wpmvc-choose' );
    }
    /**
     * Renders output.
     * @since 1.0.0
     * @param array $args
     */
    public function render( $args = [] )
    {
        $args['options'] = array_map( function( $option ) {
            if ( !is_array( $option ) ) {
                $option = ['value' => $option, 'type' => 'string'];
            } elseif ( !array_key_exists( 'value', $option ) ) {
                $option['value'] = '';
            }
            if ( filter_var( $option['value'], FILTER_VALIDATE_URL ) ) {
                $option['type'] = 'url';
            } elseif ( strpos( $option['value'], 'fa' ) === 0 ) {
                $option['type'] = 'fa';
            } elseif ( strpos( $option['value'], 'dashicon' ) === 0 ) {
                $option['type'] = 'dashicon';
            }
            return $option;
        }, $args['options'] );
        parent::render( $args );
    }
}