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
<form method="POST"<?php if ( $model->can_upload_files ) : ?> enctype="multipart/form-data"<?php endif ?>>
    <?php do_action( 'administrator_form_top_' . $model->id, $model, $tab ) ?>