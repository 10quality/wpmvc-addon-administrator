<?php
/**
 * Radio control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<div class="radio-group">
    <?php foreach ( $options as $val => $label ) : ?>
        <input id="<?php echo esc_attr( $id ) ?>-<?php echo esc_attr( $val ) ?>"
            type="radio"
            name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
            class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
            value="<?php echo esc_attr( $val ) ?>"
            <?php if ( $value == $val ) : ?>checked="checked"<?php endif ?>
            <?php echo $html_attributes ?>
        /> <?php echo $label ?>
    <?php endforeach ?>
</div>