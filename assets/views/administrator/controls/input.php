<?php
/**
 * Input control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
$class = array_merge( isset( $wide ) && $wide ? ['widefat'] : [], isset( $class ) ? $class : [] );
?>
<input id="<?php echo esc_attr( $id ) ?>"
    type="<?php echo isset( $control ) && array_key_exists( 'input', $control ) ? esc_attr( $control['input'] ) : 'text' ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    value="<?php echo isset( $control ) && array_key_exists( 'input', $control ) && $control['input'] === 'url' ? esc_url( $value ) : esc_attr( $value ) ?>"
    <?php echo $html_attributes ?>
/>