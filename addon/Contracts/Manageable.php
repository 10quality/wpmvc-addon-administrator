<?php

namespace WPMVC\Addons\Administrator\Contracts;

/**
 * Interface for objects that can be managed.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
interface Manageable
{
    /**
     * Returns flag indicating if object has a tab navigation to display.
     * @since 1.0.0
     * @return bool
     */
    function has_nav_tab();
    /**
     * Returns page slug for management purposes.
     * @since 1.0.0
     * @return string
     */
    function get_page_slug();
    /**
     * Returns an url within the settings management module.
     * @since 1.0.0
     * @return string
     */
    function get_url( $tab = null, $args = [] );
}