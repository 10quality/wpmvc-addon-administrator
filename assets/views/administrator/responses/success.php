<?php
/**
 * Success response notice.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
    <p><strong><?php echo $response->message ?></strong></p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ) ?></span>
    </button>
</div>