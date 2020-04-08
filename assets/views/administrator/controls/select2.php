<?php
/**
 * Select2 control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
 */
$class = array_merge(
    isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [],
    isset( $class ) ? $class : [],
    ['select2']
);
$is_multiple = isset( $control ) && array_key_exists( 'multiple', $control );
?>
<select id="<?php echo esc_attr( $id ) ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?><?php if ( $is_multiple ) : ?>[]<?php endif ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    lang="<?php echo esc_attr( substr( get_locale(), 0, 2 ) ) ?>"
    <?php echo $html_attributes ?>
>
    <?php if ( isset( $options ) ) : ?>
        <?php foreach ( $options as $val => $label ) : ?>
            <option value="<?php echo esc_attr( $val ) ?>"
                <?php if ( ( $is_multiple && is_array( $value ) && in_array( $val, $value ) ) || $value == $val
                ) : ?>selected="selected"<?php endif ?>
                ><?php echo esc_attr( $label ) ?></option>
        <?php endforeach ?>
    <?php endif ?>
</select>