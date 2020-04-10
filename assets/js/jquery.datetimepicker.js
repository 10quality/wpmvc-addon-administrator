/**
 * Datetimepicker control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Init datetimepicker plugin on every input requesting it.
     * @since 1.0.5
     */
    $( '.datetimepicker' ).each( function() {
        var i18n = $( this ).data( 'i18n' )
            ? window[$( this ).data( 'i18n' )]( $( this ).attr( 'lang' ) )
            : undefined;
        var allowTimes = $( this ).data( 'allowed-times' )
            ? window[$( this ).data( 'allowed-times' )]()
            : undefined;
        $( this ).datetimepicker( {
            timepicker: $( this ).data( 'show-time' ) !== undefined ? $( this ).data( 'show-time' ) : true,
            datepicker: $( this ).data( 'show-date' ) !== undefined ? $( this ).data( 'show-date' ) : true,
            format: $( this ).data( 'format' ) || 'Y-m-d H:i',
            startDate: $( this ).data( 'start-date' ) || undefined,
            minDate: $( this ).data( 'min-date' ) || undefined,
            maxDate: $( this ).data( 'max-date' ) || undefined,
            mask: $( this ).data( 'mask' ) !== undefined ? $( this ).data( 'mask' ) : false,
            inline: $( this ).data( 'show-inline' ) !== undefined ? $( this ).data( 'show-inline' ) : false,
            i18n: i18n || undefined,
            allowTimes: allowTimes || undefined,
            lang: $( this ).attr( 'lang' ) || undefined,
        } );
    } );
    /**
     * Repeater support, init datetimepicker after items is added
     * @since 1.0.5
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.add.after', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .datetimepicker' ).length ) {
            var $datetimepicker = $items.find( '*[data-repeater-key="' + key + '"] .datetimepicker' );
            var i18n = $datetimepicker.data( 'i18n' )
                ? window[$datetimepicker.data( 'i18n' )]( $datetimepicker.attr( 'lang' ) )
                : undefined;
            var allowTimes = $datetimepicker.data( 'allowed-times' )
                ? window[$datetimepicker.data( 'allowed-times' )]()
                : undefined;
            $datetimepicker.datetimepicker( {
                timepicker: $datetimepicker.data( 'show-time' ) !== undefined ? $datetimepicker.data( 'show-time' ) : true,
                datepicker: $datetimepicker.data( 'show-date' ) !== undefined ? $datetimepicker.data( 'show-date' ) : true,
                format: $datetimepicker.data( 'format' ) || 'Y-m-d H:i',
                startDate: $datetimepicker.data( 'start-date' ) || undefined,
                minDate: $datetimepicker.data( 'min-date' ) || undefined,
                maxDate: $datetimepicker.data( 'max-date' ) || undefined,
                mask: $datetimepicker.data( 'mask' ) !== undefined ? $datetimepicker.data( 'mask' ) : false,
                inline: $datetimepicker.data( 'show-inline' ) !== undefined ? $datetimepicker.data( 'show-inline' ) : false,
                i18n: i18n || undefined,
                allowTimes: allowTimes || undefined,
                lang: $datetimepicker.attr( 'lang' ) || undefined,
            } );
        }
    } );
    /**
     * Repeater support, destroy datetimepicker before item is removed
     * @since 1.0.5
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.remove.before', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .datetimepicker' ).length ) {
            $items.find( '*[data-repeater-key="' + key + '"] .datetimepicker' ).datetimepicker( 'destroy' );
        }
    } );
} ); } )( jQuery );