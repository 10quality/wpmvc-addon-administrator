<?php
/**
 * Repeater field actions.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
 */
?>
<script id="repeater-actions" type="text/template">
    <div class="actions-list">
        <button type="button"
            role="repeater-edit-index"
            title="<?php echo esc_attr( 'Edit index', 'wpmvc-addon-administrator' ) ?>"
        ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
        <button type="button"
            role="repeater-remove"
            title="<?php echo esc_attr( 'Remove', 'wpmvc-addon-administrator' ) ?>"
        ><i class="fa fa-trash" aria-hidden="true"></i></button>
    </div>
</script>