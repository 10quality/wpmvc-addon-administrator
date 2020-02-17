<?php

namespace WPMVC\Addons\Administrator\Controllers;

use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\Abstracts\SettingsModel;

/**
 * Admin settings hooks.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
class AdminController extends Controller
{
    /**
     * Renders output.
     * @since 1.0.0
     */
    public function render( SettingsModel $model )
    {
        $current_tab = Request::input( 'tab', SettingsModel::NO_TAB );
        if ( ! array_key_exists( $current_tab, $model->tabs )
            || ! is_array( $model->tabs[$current_tab] )
            || ! array_key_exists( 'fields', $model->tabs[$current_tab] )
            || ! is_array( $model->tabs[$current_tab]['fields'] )
            || empty( $model->tabs[$current_tab]['fields'] )
        ) {
            // TODO: Return 404
        }
        // Obtain all registered controls
        $controls_in_use = [];
        array_map( function( $field ) use( &$controls_in_use ) {
            if ( array_key_exists( 'control' , $field )
                && ! in_array( is_array( $field['control'] ) ? $field['control']['type'] : $field['control'], $controls_in_use )
            ) {
                $controls_in_use[] = is_array( $field['control'] ) ? $field['control']['type'] : $field['control'];
            }
        }, $this->tabs[$current_tab]['fields'] );
        $controls = array_filter(
            array_map(
                function ( $class ) {
                    $reflector = new ReflectionClass( $class );
                    return $reflector->newInstance();
                },
                apply_filters( 'wpmvc_addon_administrator_controls', [] )
            ),
            function( $control ) use( &$controls_in_use ) {
                return in_array( $control->type, $controls_in_use );
            }
        );
        // Enqueue

        do_action( 'administrator_enqueue_' . $model->id );
    }
}