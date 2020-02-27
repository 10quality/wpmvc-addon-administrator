<?php

namespace WPMVC\Addons\Administrator\Abstracts;

use ReflectionClass;
use WPMVC\Request;
use WPMVC\MVC\Models\OptionModel;
use WPMVC\Addons\Administrator\Contracts\Enqueueable;
use WPMVC\Addons\Administrator\Contracts\Instanceable;
use WPMVC\Addons\Administrator\Contracts\Manageable;

/**
 * Administrator settings model.
 * This model has the definition of all the feidls to display,
 * tabs, admin menus and other.
 * While not a PHP abstract class, it is treated as one.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
 */
class SettingsModel extends OptionModel implements Enqueueable, Instanceable, Manageable
{
    /**
     * Tab ID that indicates to the rendering process
     * not to use tabs, as all fields will be displayed in one page.
     * @since 1.0.0
     * @var string
     */
    const NO_TAB = '__NOTAB';
    /**
     * Settings page title.
     * @since 1.0.0
     * @var string|null
     */
    protected $title = null;
    /**
     * Settings page description.
     * @since 1.0.0
     * @var string|null
     */
    protected $description = null;
    /**
     * Menu settings.
     * @since 1.0.0
     * @var array
     */
    protected $menu = [];
    /**
     * Tabs, settings and fields definition.
     * @since 1.0.0
     * @var array
     */
    protected $tabs = [];
    /**
     * Default tab ID to display.
     * @since 1.0.0
     * @var string
     */
    protected $default_tab = self::NO_TAB;
    /**
     * Flag that indicates if settings page should display a tab nav or not.
     * @since 1.0.0
     * @var bool
     */
    protected $display_nav_tab = true;
    /**
     * Flag that indicates if form can upload files.
     * @since 1.0.0
     * @var bool
     */
    protected $can_upload_files = true;
    /**
     * Custom page slug.
     * @since 1.0.0
     * @var string
     */
    protected $page_slug = null;
    /**
     * Successful save message.
     * @since 1.0.0
     * @var string
     */
    protected $save_message = null;
    /**
     * Default constructor.
     * @since 1.0.0
     * 
     * @param string $id Model ID.
     */
    public function __construct( $id = null )
    {
        // Forces adds settings field
        $this->aliases['_settings'] = 'field__settings';
        $this->attributes['_settings'] = [];
        $this->save_message = __( 'Settings saved!', 'wpmvc-addon-administrator' );
        $this->init();
        // Construct
        if ( ! empty( $id ) )
            $this->load( $this->id );
    }
    /**
     * Getter function.
     * @since 1.0.0
     *
     * @param string $property
     *
     * @return mixed
     */
    public function &__get( $property )
    {
        if ( array_key_exists( $property, $this->attributes['_settings'] ) ) {
            return $this->attributes['_settings'][$property];
        } elseif ( property_exists( $this, $property ) ) {
            return $this->$property;
        }
        return parent::__get( $property );
    }
    /**
     * Setter function.
     * @since 1.0.0
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return object
     */
    public function __set( $property, $value )
    {
        if ( array_key_exists( $property, $this->attributes['_settings'] ) ) {
            $this->attributes['_settings'][$property] = $value;
        } elseif ( $property !== 'id' && property_exists( $this, $property ) ) {
            $this->$property = $value;
        }
        parent::__set( $property, $value );
    }
    /**
     * Finds record based on an ID.
     * @since 1.0.0
     *
     * @param mixed $id Record ID.
     */
    public static function find( $id = 0 )
    {
        return new self( $id );
    }
    /**
     * Inits model.
     * @since 1.0.0
     */
    protected function init()
    {
        // TODO on final class
    }
    /**
     * Loads model from db.
     * @since 1.0.0
     *
     * @param string $id Option key ID.
     */
    public function load( $id )
    {
        parent::load( $id );
        // Update settings based on fields
        if ( empty( $this->attributes['_settings'] ) || !is_array( $this->attributes['_settings'] ) )
            $this->attributes['_settings'] = [];
        // Load tab settings and those stored @ options
        foreach ( $this->tabs as $tab ) {
            foreach ( $tab['fields'] as $field_id => $field ) {
                if ( array_key_exists( 'type', $field ) && in_array( $field['type'], apply_filters( 'administrator_no_value_fields', [] ) ) ) {
                    continue;
                }
                if ( !array_key_exists( $field_id, $this->_settings ) ) {
                    $this->_settings[$field_id] = null;
                }
                if ( is_array( $field ) && array_key_exists( 'storage', $field ) && $field['storage'] === 'option' ) {
                    $this->_settings[$field_id] = get_option( $field_id, null );
                }
            }
        }
    }
    /**
     * Saves current model in the db.
     * Returns flag indicating if save was made.
     * @since 1.0.0
     *
     * @return bool.
     */
    public function save()
    {
        if ( ! $this->is_loaded() ) return false;
        // Save those stored @ options
        foreach ( $this->tabs as $tab ) {
            foreach ( $tab['fields'] as $id => $field ) {
                if ( array_key_exists( 'type', $field ) && in_array( $field['type'], apply_filters( 'administrator_no_value_fields', [] ) ) ) {
                    continue;
                }
                if ( is_array( $field ) && array_key_exists( 'storage', $field ) && $field['storage'] === 'option' ) {
                    update_option( $id, $this->_settings[$id], !array_key_exists( 'autoload', $field ) || $field['autoload'] );
                    unset( $this->_settings[$id] );
                }
            }
        }
        return parent::save();
    }
    /**
     * Returns and updates static instance.
     * @since 1.0.0
     * 
     * @return \WPMVC\Addons\Administrator\Abstracts\SettingsModel
     */
    public function get_updated_instance()
    {
        static::$instance = $this;
        return static::$instance;
    }
    /**
     * Enqueues styles and scripts especific to the settings defined.
     * @since 1.0.0
     */
    public function enqueue()
    {
        // TODO: Based on control.
    }
    /**
     * Returns flag indicating if settings object is empty.
     * Meaning that it has no fields to display.
     * @since 1.0.0
     * *
     * @return bool
     */
    public function is_empty()
    {
        return empty( $this->tabs );
    }
    /**
     * Returns flag indicating if object has a tab navigation to display.
     * @since 1.0.0
     * *
     * @return bool
     */
    public function has_nav_tab()
    {
        return !$this->is_empty()
            && $this->display_nav_tab
            && count( $this->tabs ) > 1;
    }
    /**
     * Returns page slug for management purposes.
     * @since 1.0.0
     * 
     * @return string
     */
    public function get_page_slug()
    {
        return $this->page_slug ? $this->page_slug : $this->id;
    }
    /**
     * Returns an url within the settings management module.
     * @since 1.0.0
     * @return string
     */
    public function get_url( $tab = null, $args = [] )
    {
        $url = array_key_exists( 'parent', $this->menu ) && $this->menu['parent'] === 'options-general.php'
            ? admin_url( 'options-general.php?page=' . $this->id )
            : admin_url( 'admin.php?page=' . $this->id );
        if ( $tab && $tab !== $this->default_tab ) {
            $url = add_query_arg( 'tab', $tab, $url );
        }
        if ( !empty( $args ) && is_array( $args ) ) {
            $url = add_query_arg( $args, $url );
        }
        return $url;
    }
}