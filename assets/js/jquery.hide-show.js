/**
 * Hide/show behavior script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.2
 */

/**
 * Returns unique string ID.
 * @since 1.0.2
 *
 * @link https://stackoverflow.com/questions/4872380/uniqid-in-javascript-jquery
 *
 * @return string
 */
function uniqid( prefix, more_entropy )
{
    var id = Date.now() / 1000;
    id = id.toString( 16 ).split( '.' ).join( '' );
    while( id.length < 14 ){
        id += '0';
    }
    var more = '';
    if ( more_entropy !== undefined && more_entropy === true ) {
        more = '.' + Math.round( Math.random() * 100000000 );
    }
    return ( prefix !== undefined ? prefix : '' ) + id + more;
};
/**
 * jQuery script.
 * @since 1.0.2
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Show listener.
     * jQuery plugin.
     * @since 1.0.2
     */
    $.fn.show_listener = function()
    {
        var self = this;
        self.$el = $( this );
        self.id = uniqid();
        // Fields listener
        self.fields = {};
        self.methods = {
            ready: function() {
                self.$el.data( 'show-if' )
                    .split( '|' )
                    .map( function( field ) {
                        field = field.split( ':' );
                        self.fields[field[0]] = field[1].split( ',' );
                    } );
                for ( var field_selector in self.fields ) {
                    if ( $( field_selector ).length === 0 )
                        continue;
                    $( field_selector ).attr( 'data-listener-' + self.id, field_selector );
                    $( document ).on( 'change', field_selector, self.methods.on_listener );
                }
            },
            on_listener: function()
            {
                var val = $( this ).val();
                var field_selector = $( this ).data( 'listener-' + self.id );
                if ( self.fields[field_selector]
                    .find( function( value ) { return value == val; } ) !== undefined
                ) {
                    self.methods.show();
                } else {
                    self.methods.hide();
                }
            },
            show: function()
            {
                self.$el.show();
            },
            hide: function()
            {
                self.$el.hide();
            },
        };
        self.methods.ready();
    }
    /**
     * Show listener.
     * jQuery plugin.
     * @since 1.0.2
     */
    $.fn.hide_listener = function()
    {
        var self = this;
        self.$el = $( this );
        self.id = uniqid();
        // Fields listener
        self.fields = {};
        self.methods = {
            ready: function() {
                self.$el.data( 'hide-if' )
                    .split( '|' )
                    .map( function( field ) {
                        field = field.split( ':' );
                        self.fields[field[0]] = field[1].split( ',' );
                    } );
                for ( var field_selector in self.fields ) {
                    if ( $( field_selector ).length === 0 )
                        continue;
                    $( field_selector ).attr( 'data-listener-' + self.id, field_selector );
                    $( document ).on( 'change', field_selector, self.methods.on_listener );
                }
            },
            on_listener: function()
            {
                var val = $( this ).val();
                var field_selector = $( this ).data( 'listener-' + self.id );
                if ( self.fields[field_selector]
                    .find( function( value ) { return value == val; } ) !== undefined
                ) {
                    self.methods.hide();
                } else {
                    self.methods.show();
                }
            },
            show: function()
            {
                self.$el.show();
            },
            hide: function()
            {
                self.$el.hide();
            },
        };
        self.methods.ready();
    }
    /**
     * Plugin init.
     * @since 1.0.2
     */
    $( '*[data-show-if]' ).each( function() {
        $( this ).show_listener();
    } );
    $( '*[data-hide-if]' ).each( function() {
        $( this ).hide_listener();
    } );
} ); } )( jQuery );