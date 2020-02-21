/**
 * Datepicker control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Init datepicker plugin on every input requesting it.
     * @since 1.0.0
     */
    $( '.datepicker' ).each( function() {
        $( this ).datepicker( {
            showOtherMonths: $( this ).data( 'show-other-months' ) || true,
            selectOtherMonths: $( this ).data( 'select-other-months' ) || true,
            showButtonPanel: $( this ).data( 'show-button-panel' ) || false,
            changeMonth: $( this ).data( 'change-month' ) || false,
            changeYear: $( this ).data( 'change-year' ) || false,
            dateFormat: $( this ).data( 'date-format' ) || 'yy-mm-dd',
        } );
    } );
} ); } )( jQuery );