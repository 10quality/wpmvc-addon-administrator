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
$is_multiple = isset( $control )
    && array_key_exists( 'attributes', $control )
    && array_key_exists( 'multiple', $control['attributes'] )
    && $control['attributes']['multiple'];
?>
<select id="<?php echo esc_attr( $id ) ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?><?php if ( $is_multiple ) : ?>[]<?php endif ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    lang="<?php echo esc_attr( substr( get_locale(), 0, 2 ) ) ?>"
    <?php echo $html_attributes ?>
>
    <?php if ( isset( $control ) && array_key_exists( 'add_empty', $control ) && $control['add_empty'] === true ) : ?>
        <option value=""><?php echo array_key_exists( 'empty_label', $control ) ? $control['empty_label'] : '' ?></option>
    <?php endif ?>
    <?php if ( isset( $options ) ) : ?>
        <?php foreach ( $options as $val => $label ) : ?>
            <option value="<?php echo esc_attr( $val ) ?>"
                <?php if ( ( $is_multiple && is_array( $value ) && in_array( $val, $value ) ) || $value == $val
                ) : ?>selected="selected"<?php endif ?>
                ><?php echo esc_attr( $label ) ?></option>
        <?php endforeach ?>
    <?php elseif ( !empty( $value ) ) : ?>
        <?php if ( is_array( $value ) ) : ?>
            <?php foreach ( $value as $item ) : ?>
                <option value="<?php echo esc_attr( $item ) ?>" selected
                    ><?php echo apply_filters( 'administrator_value_' . ( isset( $field_id ) ? $field_id : $id ), $item ) ?></option>
            <?php endforeach ?>
        <?php else : ?>
            <option value="<?php echo esc_attr( $value ) ?>" selected
                ><?php echo apply_filters( 'administrator_value_' . ( isset( $field_id ) ? $field_id : $id ), $value ) ?></option>
        <?php endif ?>
    <?php endif ?>
</select>