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
<div class="choose direction-<?php echo isset( $control ) && array_key_exists( 'direction', $control ) ? esc_attr( $control['direction'] ) : 'row' ?>"
    <?php if ( isset( $control ) && array_key_exists( 'background', $control) ) : ?>style="background:<?php echo esc_attr( $control['background'] ) ?>;"<?php endif ?>
    >
    <?php foreach ( $options as $val => $options ) : ?>
        <label for="<?php echo esc_attr( $id ) ?>-<?php echo esc_attr( $val ) ?>"
            <?php if ( array_key_exists( 'title', $options) ) : ?>title="<?php echo esc_attr( $options['title'] ) ?>"<?php endif ?>
            >
            <input id="<?php echo esc_attr( $id ) ?>-<?php echo esc_attr( $val ) ?>"
                type="radio"
                name="<?php echo esc_attr( isset( $name ) ? $name : $id ) ?>"
                class="<?php echo isset( $class ) ? esc_attr( implode( ' ', $class ) ) : '' ?>"
                value="<?php echo esc_attr( $val ) ?>"
                style="display:none"
                <?php if ( $value == $val ) : ?>checked="checked"<?php endif ?>
            />
            <div class="choose-option" <?php echo $html_attributes ?>>
                <?php if ( $options['type'] === 'url' ) : ?>
                    <img src="<?php echo esc_url( $options['value'] ) ?>" alt="<?php echo esc_attr( $val ) ?>"/>
                <?php elseif ( $options['type'] === 'dashicon' ) : ?>
                    <span class="dashicons <?php echo esc_attr( $options['value'] ) ?>"></span>
                <?php elseif ( $options['type'] === 'fa' ) : ?>
                    <span class="fa <?php echo esc_attr( $options['value'] ) ?>"></span>
                <?php else : ?>
                    <span class="option-text"><?php echo esc_attr( $options['value'] ) ?></span>
                <?php endif ?>
            </div>
        </label>
    <?php endforeach ?>
</div>