<?php
/**
 * Pages control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
$class = array_merge( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [], isset( $class ) ? $class : [] );
$args = [
    'id' => $id,
    'name' => isset( $name ) ? $name : $id,
    'class' => implode( ' ' , $class ),
    'selected' => $value,
];
if ( isset( $control ) && array_key_exists( 'show_option_none', $control ) ) {
    $args['show_option_none'] = $control['show_option_none'];
}
if ( isset( $control ) && array_key_exists( 'show_option_no_change', $control ) ) {
    $args['show_option_no_change'] = $control['show_option_no_change'];
}
if ( isset( $control ) && array_key_exists( 'option_none_value', $control ) ) {
    $args['option_none_value'] = $control['option_none_value'];
}
if ( isset( $control ) && array_key_exists( 'value_field', $control ) ) {
    $args['value_field'] = $control['value_field'];
}
if ( isset( $control ) && array_key_exists( 'depth', $control ) ) {
    $args['depth'] = $control['depth'];
}
wp_dropdown_pages( $args );