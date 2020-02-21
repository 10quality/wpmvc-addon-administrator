/**
 * Media control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Init plugin on every input requesting it.
     * @since 1.0.0
     */
    $( '.media-uploader' ).each( function() {
        $( this ).mediaUploader( {
            editor: $( this ).data( 'editor' ),
            target: $( this ).data( 'target' ),
            clearTarget: $( this ).data( 'clear-target' ) || true,
            clearTemplate: $( this ).data( 'clear-template' ) || true,
        } );
    } );
} ); } )( jQuery );