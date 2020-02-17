<?php

namespace WPMVC\Addons\Administrator\Contracts;

/**
 * Interface for objects that will render output.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
interface Renderable
{
    /**
     * Renders output.
     * @since 1.0.0
     * @param array $args
     */
    function render( $args = [] );
}