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
?>
<label for="<?php echo esc_attr( $id ) ?>">
    <input id="<?php echo esc_attr( $id ) ?>"
        type="checkbox"
        name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
        class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
        value="yes"
        <?php if ( $value === 'yes' ) : ?>checked="checked"<?php endif ?>
        <?php echo $html_attributes ?>
    /><?php if ( isset( $control ) && array_key_exists( 'label', $control ) ) : ?> <?php echo $control['label'] ?><?php endif ?>
</label>