<?php
/**
 * Administrator settings header.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<div id="<?php echo esc_attr( $model->id ) ?>" class="wrap wpmvc administrator">
    <?php do_action( 'administrator_header_' . $model->id, $model, $tab ) ?>
    <h2><?php echo $model->title ?></h2>
    <?php if ( $model->description ) : ?>
        <p class="description"><?php echo $model->description ?></p>
    <?php endif ?>
    <?php do_action( 'administrator_after_title_' . $model->id, $model, $tab ) ?>