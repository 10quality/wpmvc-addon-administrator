<?php
/**
 * Media control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.6
 */
$class = array_merge( ['media-uploader', 'button'], isset( $class ) ? $class : [] );
?>
<div class="media-wrapper">
    <button role="media-uploader"
        id="<?php echo esc_attr( $id ) ?>"
        type="button"
        class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
        name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
        value="<?php echo esc_attr( is_array( $value ) ? implode( ',', $value ) : $value ) ?>"
        data-editor="editor-<?php echo esc_attr( $id ) ?>"
        <?php if ( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ) : ?>
            data-input-class="widefat"
        <?php endif ?>
        <?php echo $html_attributes ?>
    >
        <?php if ( ( !isset( $control ) || !array_key_exists( 'show_icon', $control ) || $control['show_icon'] === true )
            && ( !isset( $control ) || !array_key_exists( 'icon', $control ) )
        ) : ?>
            <span class="dashicons dashicons-admin-media"></span>
        <?php endif ?>
        <?php if ( isset( $control ) && array_key_exists( 'icon', $control ) ) : ?>
            <i class="fa <?php echo esc_attr( $control['icon'] ) ?>" aria-hidden="true"></i>
        <?php endif ?>
        <?php echo isset( $control ) && array_key_exists( 'button_label', $control ) ? $control['button_label'] : __( 'Add media' ) ?>
    </button>
</div>