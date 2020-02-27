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
<script id="repeater-index-editor" type="text/template">
    <div class="index-editor">
        <label for="index-editor"><span class="label"><?php _e( 'Index:', 'wpmvc-addon-administrator' ) ?></span></label>
        <input id="index-editor" type="text"/>
        <button role="index-cancel"><?php _e( 'Cancel', 'wpmvc-addon-administrator' ) ?></button>
        <button role="index-update"><?php _e( 'Update' ) ?></button>
    </div>
</script>