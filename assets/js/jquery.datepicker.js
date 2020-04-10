/**
 * Datepicker control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Init datepicker plugin on every input requesting it.
     * @since 1.0.0
     */
    $( '.datepicker' ).each( function() {
        $( this ).datepicker( {
            showOtherMonths: $( this ).data( 'show-other-months' ) !== undefined ? $( this ).data( 'show-other-months' ) : true,
            selectOtherMonths: $( this ).data( 'select-other-months' ) !== undefined ? $( this ).data( 'select-other-months' ) : true,
            showButtonPanel: $( this ).data( 'show-button-panel' ) !== undefined ? $( this ).data( 'show-button-panel' ) : false,
            changeMonth: $( this ).data( 'change-month' ) !== undefined ? $( this ).data( 'change-month' ) : false,
            changeYear: $( this ).data( 'change-year' ) !== undefined ? $( this ).data( 'change-year' ) : false,
            dateFormat: $( this ).data( 'date-format' ) || 'yy-mm-dd',
        } );
    } );
    /**
     * Repeater support, init datepicker after items is added
     * @since 1.0.2
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.add.after', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .datepicker' ).length ) {
            var $datepicker = $items.find( '*[data-repeater-key="' + key + '"] .datepicker' );
            $datepicker.datepicker( {
                showOtherMonths: $datepicker.data( 'show-other-months' ) !== undefined ? $datepicker.data( 'show-other-months' ) : true,
                selectOtherMonths: $datepicker.data( 'select-other-months' ) !== undefined ? $datepicker.data( 'select-other-months' ) : true,
                showButtonPanel: $datepicker.data( 'show-button-panel' ) !== undefined ? $datepicker.data( 'show-button-panel' ) : false,
                changeMonth: $datepicker.data( 'change-month' ) !== undefined ? $datepicker.data( 'change-month' ) : false,
                changeYear: $datepicker.data( 'change-year' ) !== undefined ? $datepicker.data( 'change-year' ) : false,
                dateFormat: $datepicker.data( 'date-format' ) || 'yy-mm-dd',
            } );
        }
    } );
    /**
     * Repeater support, destroy datepicker before item is removed
     * @since 1.0.2
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.remove.before', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .datepicker' ).length ) {
            $items.find( '*[data-repeater-key="' + key + '"] .datepicker' ).datepicker( 'destroy' );
        }
    } );
} ); } )( jQuery );