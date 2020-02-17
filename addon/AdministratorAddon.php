<?php

namespace WPMVC\Addons\Administrator;

use WPMVC\Addon;

/**
 * Addon class.
 * Wordpress MVC.
 *
 * @link http://www.wordpress-mvc.com/v1/add-ons/
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
class AdministratorAddon extends Addon
{
    /**
     * Instance.
     * @since 1.0.0
     * 
     * @var \WPMVC\Addons\Customizer\AdministratorAddon
     */
    protected static $instance;
    /**
     * Function called when plugin or theme starts.
     * @since 1.0.0
     */
    public function init()
    {
        static::$instance = $this;
        add_action( 'admin_enqueue_scripts', [&$this, 'admin_enqueue'], 99 );
        add_action( 'admin_init', [&$this, 'init'], 5 );
        add_filter( 'wpmvc_addon_administrator_controls', [&$this, 'register_controls'], 1 );
    }
    /**
     * Registers administrator controls.
     * @since 1.0.0
     * 
     * @hook admin_init
     */
    public function init()
    {
        $this->mvc->call( 'ConfigController@controls' );
    }
    /**
     * Registers administrator controls.
     * @since 1.0.0
     * 
     * @hook wpmvc_addon_administrator_controls
     */
    public function register_controls()
    {
        return $this->mvc->action( 'ConfigController@controls', [] );
    }
    /**
     * Registers/enqueues general admin assets.
     * @since 1.0.0
     * 
     * @hook admin_enqueue_scripts
     */
    public function admin_enqueue()
    {
        wp_register_style(
            'font-awesome',
            addon_assets_url( 'css/font-awesome.min.css', __DIR__ ),
            [],
            '4.7.0'
        );
    }
    /**
     * Renders an addon view.
     * @since 1.0.0
     * 
     * @param string $key  View key.
     * @param array  $args View arguments.
     */
    public static function view( $key, $args = [] )
    {
        if ( isset( static::$instance ) ) {
            static::$instance->mvc->view->show( $key, $args );
        }
    }
    /**
     * Renders an addon view.
     * @since 1.0.0
     * 
     * @param string $key  View key.
     * @param array  $args View arguments.
     */
    public static function get_view( $key, $args = [] )
    {
        return isset( static::$instance ) ? static::$instance->mvc->view->get( $key, $args ) : '';
    }
}