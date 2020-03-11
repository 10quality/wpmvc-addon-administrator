<?php
/**
 * Textarea control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.3
 */
$class = array_merge( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [], isset( $class ) ? $class : [] );
?>
<textarea id="<?php echo esc_attr( $id ) ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    <?php echo $html_attributes ?>
><?php echo stripslashes( $value ) ?></textarea>