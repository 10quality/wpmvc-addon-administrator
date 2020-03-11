<?php
/**
 * Editor control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.3
 */
$settings = isset( $control ) ? $control : [];
$settings['textarea_name'] = isset( $name ) ? $name : $id;
wp_editor( stripslashes( $value ), $id, $settings );