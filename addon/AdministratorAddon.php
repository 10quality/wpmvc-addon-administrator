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
        add_action( 'admin_menu', [&$this, 'settings_init'], 5 );
        add_filter( 'administrator_controls', [&$this, 'register_controls'], 1 );
        add_filter( 'administrator_no_value_fields', function() {
            return [
                'section_open',
                'section_close',
                'section_separator',
                'callback',
            ];
        }, 1 );
        add_filter( 'administrator_bool_fields', function() {
            return [
                'checkbox',
            ];
        }, 1 );
    }
    /**
     * Inits
     * @since 1.0.0
     * 
     * @hook admin_menu
     */
    public function settings_init()
    {
        $this->mvc->call( 'AdminController@init' );
    }
    /**
     * Registers administrator controls.
     * @since 1.0.0
     * 
     * @hook administrator_controls
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
            addon_assets_url( 'css/font-awesome.min.css', __FILE__ ),
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