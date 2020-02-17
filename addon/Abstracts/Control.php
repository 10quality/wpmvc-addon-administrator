<?php

namespace WPMVC\Addons\Administrator\Abstracts;

use WPMVC\Addons\Administrator\Contracts\Enqueueable;
use WPMVC\Addons\Administrator\Contracts\Renderable;
/**
 * Administrator control.
 * Base abstract class.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
abstract class Control implements Enqueueable, Renderable
{
    /**
     * The control type, acts like ID identifier.
     * @since 1.0.0
     * @var string
     */
    protected $type = 'input';
    /**
     * View key to use if render method is not present.
     * View will be render as fallback.
     * @since 1.0.0
     * @var string
     */
    protected $view = 'admin.controls.input';
    /**
     * Enqueues styles and scripts especific to the control.
     * @since 1.0.0
     */
    public function enqueue()
    {
        // TODO: Based on control.
    }
    /**
     * Renders output.
     * @since 1.0.0
     * @param array $args
     */
    public function render( $args = [] )
    {
        AdministratorAddon::view( $this->view, $args );
    }
}