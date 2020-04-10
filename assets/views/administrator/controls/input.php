<?php
/**
 * Input control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.3
 */
$class = array_merge( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [], isset( $class ) ? $class : [] );
$value = isset( $control ) && array_key_exists( 'type', $control ) && $control['type'] === 'url' ? esc_url( $value ) : esc_attr( stripslashes( $value ) );
?>
<input id="<?php echo esc_attr( $id ) ?>"
    type="<?php echo isset( $control ) && array_key_exists( 'type', $control ) ? esc_attr( $control['type'] ) : 'text' ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    value="<?php echo $value ?>"
    <?php if ( isset( $control ) && isset( $control['autocomplete'] ) && $control['autocomplete'] ) ?>
        autocomplete="on"
    <?php else : ?>
        autocomplete="off"
    <?php endif ?>
    <?php echo $html_attributes ?>
/>