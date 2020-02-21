<?php
/**
 * Form open wrapper.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
    <?php do_action( 'administrator_form_' . $model->id, $model, $tab ) ?>
    <?php submit_button() ?>
    <?php do_action( 'administrator_form_bottom_' . $model->id, $model, $tab ) ?>
</form><!--form-->