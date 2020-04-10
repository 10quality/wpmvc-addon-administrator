<?php
/**
 * Switch control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
 */
$class = array_merge( ['switch control'], isset( $class ) ? $class : [] );
?>
<label id="<?php echo esc_attr( $id ) ?>"
    for="switch-input2"
    role="switch"
    class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
    <?php echo $html_attributes ?>
>
    <input id="switch-input"
        type="number"
        name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
        value="<?php echo esc_attr( $value ) ?>"
        style="display:none"
    />
    <div class="controller">
        <div class="switch-val on"><?php _e( 'On' ) ?></div>
        <div class="switch-val off"><?php _e( 'Off' ) ?></div>
    </div>
</label>