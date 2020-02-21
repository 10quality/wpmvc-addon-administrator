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
$section_opened = false;
?>
<?php do_action( 'administrator_content_top_' . $model->id . '_tab_' . $tab, $model ) ?>
<section id="<?php echo esc_attr( $tab ) ?>" class="tab">
    <?php if ( array_key_exists( 'title', $model->tabs[$tab] ) ) : ?>
        <h2><?php echo $model->tabs[$tab]['title'] ?></h2>
    <?php endif ?>
    <?php if ( array_key_exists( 'description', $model->tabs[$tab] ) ) : ?>
        <p><?php echo $model->tabs[$tab]['description'] ?></p>
    <?php endif ?>
    <?php foreach ( $model->tabs[$tab]['fields'] as $field_id => $field ) : ?>
        <?php if ( $field['type'] === 'section_open' ) : ?>
            <?php if ( $section_opened ) : ?></table><?php endif ?>
            <?php $section_opened = true ?>
            <div id="<?php echo esc_attr( $field_id ) ?>" class="tab-section fieldset">
                <?php if ( array_key_exists( 'title', $field ) ) : ?>
                    <h3  ><?php echo $field['title'] ?></h3>
                <?php endif ?>
                <?php if ( array_key_exists( 'description', $field ) ) : ?>
                    <p class="description"></p>
                <?php endif ?>
                <table class="form-table">
        <?php elseif ( $field['type'] === 'section_close' && $section_opened ) : ?>
                </table>
            </div><!--.tab-section-->
            <?php $section_opened = false ?>
        <?php elseif ( $field['type'] === 'section_separator' ) : ?>
            <?php if ( $section_opened ) : ?></table><?php endif ?>
            <hr id="<?php echo esc_attr( $field_id ) ?>"/>
            <?php if ( $section_opened ) : ?><table class="form-table"><?php endif ?>
        <?php else : ?>
            <?php if ( !$section_opened ) : ?><table class="form-table"><?php endif ?>
            <?php $control = array_key_exists( 'control', $field ) && array_key_exists( 'type', $field['control'] ) ? $field['control']['type'] : 'input' ?>
            <?php if ( array_key_exists( $control, $controls ) ) : ?>
                <?php $controls[$control]->render( $field['control'] ) ?>
            <?php endif ?>
            <?php if ( !$section_opened ) : ?></table><?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
    <?php if ( $section_opened ) : ?></table><?php endif ?>
</section>
<?php do_action( 'administrator_content_bottom_' . $model->id . '_tab_' . $tab, $model ) ?>