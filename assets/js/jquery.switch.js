/**
 * Switch control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Switch jQuery plugin.
     * @since 1.0.4
     */
    $.fn.switch = function() {
        var self = this;
        self.$el = $( this );
        self.$input = undefined;
        self.is_on = false;
        self.methods = {
            init: function() {
                self.$input = self.$el.find( 'input[type="number"]' );
                self.is_on = self.$input.val() == 1;
                self.$el.on( 'click', self.methods.toggle );
                self.methods.render();
            },
            toggle: function( e ) {
                if ( e !== undefined ) e.preventDefault();
                self.is_on = !self.is_on;
                self.methods.render();
                self.$input.change();
                self.$el.trigger( 'switch:toggle', [self.is_on, self] );
            },
            render: function() {
                if ( self.is_on ) {
                    self.$input.val( 1 );
                    self.$el.find( '.switch-val.on' ).addClass( 'active' );
                    self.$el.find( '.switch-val.off' ).removeClass( 'active' );
                    self.$el.trigger( 'switch:on', [self] );
                } else {
                    self.$input.val( 0 );
                    self.$el.find( '.switch-val.on' ).removeClass( 'active' );
                    self.$el.find( '.switch-val.off' ).addClass( 'active' );
                    self.$el.trigger( 'switch:off' , [self] );
                }
            }
        };
        self.methods.init();
        return {
            toggle: function() {
                return self.methods.toggle();
            }
        };
    };
    /**
     * Init plugin on every input requesting it.
     * @since 1.0.4
     */
    $( '*[role="switch"]' ).each( function() {
        $( this ).switch();
    } );
    /**
     * Repeater support, init colorpicker after items is added
     * @since 1.0.4
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.add.after', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .switch' ).length ) {
            var $switch = $items.find( '*[data-repeater-key="' + key + '"] .switch' );
            $switch.switch();
        }
    } );
} ); } )( jQuery );