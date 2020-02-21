<?php
/**
 * Select control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
$class = array_merge( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [], isset( $class ) ? $class : [] );
?>
<select id="<?php echo esc_attr( $id ) ?>"
    name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    <?php echo $html_attributes ?>
>
    <?php if ( isset( $control ) && array_key_exists( 'add_empty', $control ) && $control['add_empty'] === true ) : ?>
        <option value=""><?php echo array_key_exists( 'empty_label', $control ) ? $control['empty_label'] : '' ?></option>
    <?php endif ?>
    <?php foreach ( $options as $val => $label ) : ?>
        <option value="<?php echo esc_attr( $val ) ?>"
            <?php if ( $value == $val ) : ?>selected="selected"<?php endif ?>
            ><?php echo esc_attr( $label ) ?></option>
    <?php endif ?>
</select>