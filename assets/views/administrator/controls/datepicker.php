<?php
/**
 * Datepicker control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
$class = array_merge( ['datepicker'], isset( $class ) ? $class : [] );
?>
<input id="<?php echo esc_attr( $id ) ?>"
    type="text"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    value="<?php echo esc_attr( $value ) ?>"
    <?php if ( isset( $control ) && isset( $control['autocomplete'] ) && $control['autocomplete'] ) : ?>
        autocomplete="on"
    <?php else : ?>
        autocomplete="off"
    <?php endif ?>
    <?php echo $html_attributes ?>
/>