/**
 * Repeater script.
 * @link https://codepen.io/amostajo/pen/dyovLOG
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.1
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * jQuery plugin.
     * @since 1.0.1
     */
    $.fn.repeater = function()
    {
        var self = this;
        self.$el = $( this );
        self.$items = undefined;
        self.$button = undefined;
        self.$template = undefined;
        self.methods = {
            ready: function() {
                self.$template = self.$el.find( 'script[type="text/template"]' );
                self.$items = self.$el.find( '*[role="repeater-items"]' );
                self.$button = self.$el.find( '*[role="repeater-add"]' );
                if ( self.$button.length && self.$template.length && self.$items.length )
                    self.$button.on( 'click', self.methods.on_add );
            },
            on_add: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                var $item = $( self.$template.html() );
                $item.find('*').each( function() {
                    if ( $( this ).attr( 'name' ) !== undefined ) {
                        var name = $( this ).attr( 'name' );
                        $( this ).attr( 'name', name + '[]' );
                    }
                } );
                self.$items.append( $item );
            },
        };
        self.methods.ready();
    };
    /**
     * Init repeater.
     * @since 1.0.1
     */
    $( '*[role="repeater"]' ).each( function() {
        $( this ).repeater();
    } );
} ); } )( jQuery );