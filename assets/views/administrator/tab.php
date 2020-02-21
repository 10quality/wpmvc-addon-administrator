<?php
/**
 * Tab.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<?php do_action( 'administrator_content_top_' . $model->id . '_tab_' . $tab, $model ) ?>
<section id="<?php echo esc_attr( $tab ) ?>" class="tab">
    <?php if ( array_key_exists( 'title', $model->tabs[$tab] ) ) : ?>
        <h2><?php echo $model->tabs[$tab]['title'] ?></h2>
    <?php endif ?>
    <?php if ( array_key_exists( 'description', $model->tabs[$tab] ) ) : ?>
        <p><?php echo $model->tabs[$tab]['description'] ?></p>
    <?php endif ?>
    <?php foreach ( $model->tabs[$tab]['fields'] as $id => $field ) : ?>
        <?php if ( $field['type'] === 'section_open' ) : ?>
            <div id="<?php echo esc_attr( $tab ) ?>" class="tab-section fieldset">
                <?php if ( array_key_exists( 'title', $field ) ) : ?>
                    <h3  ><?php echo $field['title'] ?></h3>
                <?php endif ?>
                <?php if ( array_key_exists( 'description', $field ) ) : ?>
                    <p class="description"></p>
                <?php endif ?>
                <table class="form-table">
        <?php elseif ( $field['type'] === 'section_close' ) : ?>
                </table>
            </div><!--.tab-section-->
        <?php elseif ( $field['type'] === 'section_separator' ) : ?>
            <hr id="<?php echo esc_attr( $tab ) ?>"/>
        <?php else : ?>
            <?php $control = array_key_exists( 'control', $field ) && array_key_exists( 'type', $field['control'] ) ? $field['control']['type'] : 'input' ?>
            <?php if ( array_key_exists( $control, $controls ) ) : ?>
                <?php $controls[$control]->render( $field['control'] ) ?>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
</section>
<?php do_action( 'administrator_content_bottom_' . $model->id . '_tab_' . $tab, $model ) ?>