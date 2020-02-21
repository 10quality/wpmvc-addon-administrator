<?php
/**
 * Media control.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
$show_input = isset( $control ) && array_key_exists( 'show_input', $control ) && $control['show_input'];
$class = array_merge( isset( $control ) && array_key_exists( 'wide', $control ) && $control['wide'] ? ['widefat'] : [], isset( $class ) ? $class : [] );
?>
<a href="#" class="insert-media button"
    data-editor="editor-<?php echo esc_attr( $id ) ?>"class="d">
    <?php if ( !isset( $control ) || !array_key_exists( 'show_icon', $control ) || $control['show_icon'] === true ) : ?>
        <span class="dashicons dashicons-admin-media"></span>
    <?php endif ?>
    <?php echo isset( $control ) && array_key_exists( 'button_label', $control ) ? $control['button_label'] : __( 'Add media' ) ?>
</a>
<!-- Caller -->
<script id="caller-<?php echo esc_attr( $id ) ?>"
    type="text/template"
    class="media-uploader"
    data-editor="editor-<?php echo esc_attr( $id ) ?>"
    data-target="#media-<?php echo esc_attr( $id ) ?>"
>
    <div class="attachment">
        <img alt="{{ alt }}" height="<?php echo isset( $control ) && array_key_exists( 'height', $control ) ? $control['height'] : 75 ?>"/>
        <?php if ( isset( $control ) && array_key_exists( 'type', $control ) && $control['type'] === 'url' ) : ?>
            <?php if ( ! $show_input ) : ?><span class="name-value">{{ url }}</span><?php endif ?>
            <input id="<?php echo esc_attr( $id ) ?>"
                type="<?php echo $show_input ? 'url' : 'hidden' ?>"
                name="<?php echo esc_attr( $id ) ?>"
                value="{{ url }}"
                class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
                <?php echo $html_attributes ?>/>
        <?php else : ?>
            <input id="<?php echo esc_attr( $id ) ?>"
                type="<?php echo $show_input ? 'text' : 'hidden' ?>"
                name="<?php echo esc_attr( $id ) ?>"
                value="{{ id }}"
                class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
                <?php echo $html_attributes ?>/>
        <?php endif ?>
    </div>
</script>
<!-- placeholder -->
<div id="media-<?php echo esc_attr( $id ) ?>" class="media">
    <?php if ( isset( $attachment ) && $attachment ) : ?>
        <div class="attachment">
            <img alt="<?php echo esc_attr( $attachment->alt ) ?>"
                src="<?php echo esc_url( $attachment->medium_url ? $attachment->medium_url : $attachment->url ) ?>"
                height="<?php echo isset( $control ) && array_key_exists( 'height', $control ) ? $control['height'] : 75 ?>"
                />
            <input id="<?php echo esc_attr( $id ) ?>"
                type="<?php echo $show_input ? 'text' : 'hidden' ?>"
                name="<?php echo esc_attr( $id ) ?>"
                value="<?php echo esc_attr( $attachment->ID ) ?>"
                class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
                <?php echo $html_attributes ?>
            />
        </div>
    <?php elseif ( ! empty( $value ) ) : ?>
        <div class="attachment">
            <?php if ( ! $show_input ) : ?><span class="name-value"><?php echo $value ?></span><?php endif ?>
            <input id="<?php echo esc_attr( $id ) ?>"
                type="<?php echo $show_input ? 'url' : 'hidden' ?>"
                name="<?php echo esc_attr( $id ) ?>"
                value="<?php echo esc_url( $value ) ?>"
                class="<?php echo esc_attr( implode( ' ', $class ) ) ?>"
                <?php echo $html_attributes ?>
            />
        </div>
    <?php endif ?>
</div>