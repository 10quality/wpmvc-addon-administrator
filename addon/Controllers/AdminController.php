<?php

namespace WPMVC\Addons\Administrator\Controllers;

use ReflectionClass;
use WPMVC\MVC\Request;
use WPMVC\MVC\Response;
use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\Abstracts\Control;
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
     * Inits by registering administrator models and configurations.
     * @since 1.0.0
     */
    public function init()
    {
        // Registered settings models
        $models = $this->get_models();
        foreach ( $models as $key => $model ) {
            if ( array_key_exists( 'parent', $model->menu ) ) {
                add_submenu_page(
                    $model->menu['parent'],
                    $model->title,
                    array_key_exists( 'title', $model->menu ) ? $model->menu['title'] : $model->title,
                    array_key_exists( 'capability', $model->menu ) ? $model->menu['capability'] : 'manage_options',
                    $model->id,
                    [&$this, 'process_' . $key],
                    array_key_exists( 'position', $model->menu ) ? $model->menu['position'] : null
                );
            } else {
                add_menu_page(
                    $model->title,
                    array_key_exists( 'title', $model->menu ) ? $model->menu['title'] : $model->title,
                    array_key_exists( 'capability', $model->menu ) ? $model->menu['capability'] : 'manage_options',
                    $model->id,
                    [&$this, 'process_' . $key],
                    array_key_exists( 'icon', $model->menu ) ? $model->menu['icon'] : '',
                    array_key_exists( 'position', $model->menu ) ? $model->menu['position'] : null
                );
            }
        }
    }
    /**
     * Detenct page rendering.
     * @since 1.0.0
     * 
     * @param string $method
     * @param array  $args
     * 
     * @return mixed
     */
    public function __call( $method, $args = [] )
    {
        if ( strpos( $method, 'process_' ) === 0 ) {
            // Prepare
            $models = $this->get_models();
            $key = str_replace( 'process_', '', $method );
            $current_tab = Request::input( 'tab', SettingsModel::NO_TAB );
            // Validate
            $model = array_key_exists( $key, $models ) && $models[$key] ? $models[$key] : null;
            if ( empty( $model )
                || ! array_key_exists( $current_tab, $model->tabs )
                || ! is_array( $model->tabs[$current_tab] )
                || ! array_key_exists( 'fields', $model->tabs[$current_tab] )
                || ! is_array( $model->tabs[$current_tab]['fields'] )
                || empty( $model->tabs[$current_tab]['fields'] )
            ) {
                // TODO: Return 404
                return;
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
            $controls = $this->get_controls( $controls_in_use );
            // Model handling
            $model->load();
            $response = null;
            if ( $_POST ) {
                $response = $this->save( $model, $current_tab );
            }
            $this->render( $model->get_updated_instance(), $current_tab );
        }
        return parent::__call( $method, $args );
    }
    /**
     * Renders output.
     * @since 1.0.0
     * 
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     * @param string                                              $current_tab
     */
    public function render( SettingsModel &$model, $current_tab, Response $response )
    {
        // Enqueue
        $model->enqueue();
        foreach ( $controls as $key => $control ) {
            $control->enqueue();
        }
        do_action( 'administrator_enqueue_' . $model->id );
    }
    /**
     * Renders output.
     * @since 1.0.0
     * 
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     * @param string                                              $current_tab
     * 
     * @return \WPMVC\Response
     */
    public function save( SettingsModel &$model, $current_tab )
    {
    }
    /**
     * Returns array collection with setting models available.
     * @since 1.0.0
     * 
     * @return array
     */
    private function get_models()
    {
        return array_filter(
            array_map( function( $class ) {
                $reflector = new ReflectionClass( $class );
                return $reflector->newInstance();
            }, apply_filters( 'administrator_models', [] ) ),
            function( $model ) {
                return $model && $model instanceof SettingsModel && ! empty( $model->menu );
            }
        );
    }
    /**
     * Returns array with the field controls available.
     * @since 1.0.0
     * 
     * @param array &$controls_in_use
     * 
     * @return array
     */
    private function get_controls( &$controls_in_use )
    {
        return array_filter(
            array_map(
                function ( $class ) {
                    $reflector = new ReflectionClass( $class );
                    return $reflector->newInstance();
                },
                apply_filters( 'administrator_controls', [] )
            ),
            function( $control ) use( &$controls_in_use ) {
                return $control && $control instanceof Control && in_array( $control->type, $controls_in_use );
            }
        );
    }
}