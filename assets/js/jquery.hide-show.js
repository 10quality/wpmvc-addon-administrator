/**
 * Hide/show behavior script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.2
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
                for ( var field_id in self.fields ) {
                    if ( $( '#' + field_id ).length === 0 )
                        continue;
                    $( '#' + field_id ).on( 'change', self.methods.on_listener );
                }
            },
            on_listener: function()
            {
                var val = $( this ).val();
                if ( self.fields[$( this ).attr( 'id' )]
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
                for ( var field_id in self.fields ) {
                    if ( $( '#' + field_id ).length === 0 )
                        continue;
                    $( '#' + field_id ).on( 'change', self.methods.on_listener );
                }
            },
            on_listener: function()
            {
                var val = $( this ).val();
                if ( self.fields[$( this ).attr( 'id' )]
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