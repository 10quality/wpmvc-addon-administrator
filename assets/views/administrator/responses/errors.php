<?php
/**
 * Error response notice.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
?>
<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"> 
    <ul>
        <?php foreach ( $response->errors as $field_id => $messages ) : ?>
            <li id="error-<?php echo esc_attr( $field_id ) ?>"><?php echo implode( ' ', $messages ) ?></li>
        <?php endforeach ?>
    </ul>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ) ?></span>
    </button>
</div>