<?php

namespace WPMVC\Addons\Administrator\Abstracts;

use ReflectionClass;
use WPMVC\Request;
use WPMVC\MVC\Models\OptionModel;
use WPMVC\Addons\Administrator\Contracts\Enqueueable;
use WPMVC\Addons\Administrator\Contracts\Instanceable;

/**
 * Administrator settings model.
 * This model has the definition of all the feidls to display,
 * tabs, admin menus and other.
 * While not a PHP abstract class, it is treated as one.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
class SettingsModel extends OptionModel implements Enqueueable, Instanceable
{
    /**
     * Settings model instance.
     * @since 1.0.0
     * @var \WPMVC\Addons\Administrator\Abstracts\SettingsModel
     */
    protected static $instance;
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
    protected $display_tab_nav = true;
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
}