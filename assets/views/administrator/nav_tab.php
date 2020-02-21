<?php
/**
 * Tab navigation.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<?php do_action( 'administrator_before_nav_tab_' . $model->id, $model, $tab ) ?>
<h3 class="nav-tab-wrapper">
    <?php foreach ( $model->tabs as $key => $options ) : ?>
        <a class="nav-tab <?php if ( $tab === $key ) :?>nav-tab-active<?php endif ?>"
            href="<?= esc_url( $model->get_url( $key ) ) ?>"
        >
            <?php if ( array_key_exists( 'icon', $options ) ) : ?><i class="fa <?php echo esc_attr( $options['icon'] ) ?>"></i>&nbsp;&nbsp;<?php endif ?><?php echo $options['title'] ?>
        </a>
    <?php endforeach ?>
    <?php do_action( 'administrator_inside_nav_tab_' . $model->id, $model, $tab ) ?>
</h3>
<?php do_action( 'administrator_after_nav_tab_' . $model->id, $model, $tab ) ?>