/**
 * Hide/show behavior script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
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
                        if ( self.$el.data( 'repeater' ) !== undefined
                            && $( '*[aria-field="' + field[0] + '"][data-repeater-key="' + self.$el.data( 'repeater-key' ) + '"]' ).length
                        ) {
                            var repeater_class = 'hsr-' + self.$el.data( 'repeater-key' ) + '-' + uniqid();
                            $( '*[aria-field="' + field[0] + '"][data-repeater-key="' + self.$el.data( 'repeater-key' ) + '"]' ).addClass( repeater_class );
                            field[0] = '.' + repeater_class;
                        }
                        if ( !$( field[0] ).is( 'input' )
                            && !$( field[0] ).is( 'select' )
                            && !$( field[0] ).is( 'textarea' )
                        ) {
                            var input_class = 'hsi-' + uniqid();
                            if ( $( field[0] ).find( 'input' ).length ) {
                                $( field[0] ).find( 'input' ).addClass( input_class );
                            } else if ( $( field[0] ).find( 'select' ).length ) {
                                $( field[0] ).find( 'select' ).addClass( input_class );
                            } else if ( $( field[0] ).find( 'textarea' ).length ) {
                                $( field[0] ).find( 'textarea' ).addClass( input_class );
                            }
                            field[0] = '.' + input_class;
                        }
                        self.fields[field[0]] = field[1].split( ',' );
                    } );
                for ( var field_selector in self.fields ) {
                    if ( $( field_selector ).length === 0 )
                        continue;
                    $( field_selector ).attr( 'data-listener-' + self.id, field_selector );
                    $( document ).on( 'change', field_selector, self.methods.on_listener );
                    // For on_listen
                    if ( self.$el.data( 'repeater' ) !== undefined )
                        self.methods.on_listener( undefined, $( field_selector ) );
                }
            },
            on_listener: function( event, $input )
            {
                if ( $input === undefined )
                    $input = $( this )
                var val = $input.val();
                var field_selector = $input.data( 'listener-' + self.id );
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
                        if ( self.$el.data( 'repeater' ) !== undefined
                            && $( '*[aria-field="' + field[0] + '"][data-repeater-key="' + self.$el.data( 'repeater-key' ) + '"]' ).length
                        ) {
                            var repeater_class = 'hsr-' + self.$el.data( 'repeater-key' ) + '-' + uniqid();
                            $( '*[aria-field="' + field[0] + '"][data-repeater-key="' + self.$el.data( 'repeater-key' ) + '"]' ).addClass( repeater_class );
                            field[0] = '.' + repeater_class;
                        }
                        if ( !$( field[0] ).is( 'input' )
                            && !$( field[0] ).is( 'select' )
                            && !$( field[0] ).is( 'textarea' )
                        ) {
                            var input_class = 'hsi-' + uniqid();
                            if ( $( field[0] ).find( 'input' ).length ) {
                                $( field[0] ).find( 'input' ).addClass( input_class );
                            } else if ( $( field[0] ).find( 'select' ).length ) {
                                $( field[0] ).find( 'select' ).addClass( input_class );
                            } else if ( $( field[0] ).find( 'textarea' ).length ) {
                                $( field[0] ).find( 'textarea' ).addClass( input_class );
                            }
                            field[0] = '.' + input_class;
                        }
                        self.fields[field[0]] = field[1].split( ',' );
                    } );
                for ( var field_selector in self.fields ) {
                    if ( $( field_selector ).length === 0 )
                        continue;
                    $( field_selector ).attr( 'data-listener-' + self.id, field_selector );
                    $( document ).on( 'change', field_selector, self.methods.on_listener );
                    // For on_listen
                    if ( self.$el.data( 'repeater' ) !== undefined )
                        self.methods.on_listener( undefined, $( field_selector ) );
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
    /**
     * Repeater support, init datepicker after items is added
     * @since 1.0.4
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.add.after', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"][data-show-if]' ).length ) {
            $items.find( '*[data-repeater-key="' + key + '"][data-show-if]' ).show_listener();
        }
        if ( $items.find( '*[data-repeater-key="' + key + '"][data-hide-if]' ).length ) {
            $items.find( '*[data-repeater-key="' + key + '"][data-hide-if]' ).hide_listener();
        }
    } );
} ); } )( jQuery );