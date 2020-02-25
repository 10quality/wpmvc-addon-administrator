<?php

namespace WPMVC\Addons\Administrator\Controls;

use WPMVC\Addons\Administrator\Abstracts\Control;
/**
 * HTML <textarea> control.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
 */
class EditorControl extends Control
{
    /**
     * Control type.
     * @since 1.0.1
     * @var string
     */
    const TYPE = 'editor';
    /**
     * The control type, acts like ID identifier.
     * @since 1.0.1
     * @var string
     */
    protected $type = self::TYPE;
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.1
     * @var string
     */
    protected $view = 'administrator.controls.editor';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.1
     */
    public function enqueue()
    {
        wp_enqueue_editor();
    }
}