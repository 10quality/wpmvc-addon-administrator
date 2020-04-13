/**
 * Hide/show behavior script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
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
 * Regenerates element ID.
 * Makes it unique.
 * @since 1.0.5
 *
 * @param {object} $el   Element want the ID to be changed.
 * @param {object} $item Repeater item. (optionl)
 * @param {string} group Additional group identifier
 */
function regen_id( $el, $item, group )
{
    var $ = jQuery;
    var current_id = $el.attr( 'id' );
    var new_id = $el.attr( 'id' ) + ( group ? '-' + group : '' ) + '-' + uniqid();
    new_id = new_id.replace( /[\[\]]+/g, '' );
    $el.attr( 'id', new_id );
    if ( $item && $item.length ) {
        // Show if compatibility
        $item.find( '*[data-show-if]' ).each( function() {
            var show_if = $( this ).data( 'show-if' ).split( ':' );
            if ( show_if[0] === '#' + current_id ) {
                show_if[0] = '#' + new_id;
                $( this ).attr( 'data-show-if', show_if.join( ':' ) );
            }
        } );
        // Hide if compatibility
        $item.find( '*[data-hide-if]' ).each( function() {
            var hide_if = $( this ).data( 'hide-if' ).split( ':' );
            if ( hide_if[0] === '#' + current_id ) {
                hide_if[0] = '#' + new_id;
                $( this ).attr( 'data-hide-if', hide_if.join( ':' ) );
            }
        } );
    } else {
        // Global replacement
        $( '*[data-show-if]' ).each( function() {
            var show_if = $( this ).data( 'show-if' ).split( ':' );
            if ( show_if[0] === '#' + current_id ) {
                show_if[0] = '#' + new_id;
                $( this ).attr( 'data-show-if', show_if.join( ':' ) );
            }
        } );
        $( '*[data-hide-if]' ).each( function() {
            var hide_if = $( this ).data( 'hide-if' ).split( ':' );
            if ( hide_if[0] === '#' + current_id ) {
                hide_if[0] = '#' + new_id;
                $( this ).attr( 'data-hide-if', hide_if.join( ':' ) );
            }
        } );
    }
}
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