<?php
/**
 * Repeater field.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
 */
?>
<tr id="tr-<?php echo esc_attr( $repeater_id ) ?>-<?php echo esc_attr( $field_id ) ?>-<?php echo esc_attr( $key ) ?>"
    <?php echo apply_filters( 'administrator_control_tr', [], $field, $model, $helper ) ?>
>
    <th><?php echo array_key_exists( 'title', $field ) ? $field['title'] : $field_id ?></th>
    <td>
        <?php if ( array_key_exists( $field['_control'], $controls ) ) : ?>
            <?php $controls[$field['_control']]->render( $field ) ?>
        <?php endif ?>
        <?php if ( array_key_exists( 'description', $field ) && !empty( $field['description'] ) ) : ?>
            <br><p class="description"><?php echo $field['description'] ?></p>
        <?php endif ?>
    </td>
</tr>