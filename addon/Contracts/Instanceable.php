<?php

namespace WPMVC\Addons\Administrator\Contracts;

/**
 * Interface for objects that have singleton instance and can update their instance object.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
interface Instanceable
{
    /**
     * Returns and updates static instance.
     * @since 1.0.0
     * 
     * @return \WPMVC\Addons\Administrator\Abstracts\SettingsModel
     */
    function get_updated_instance();
}