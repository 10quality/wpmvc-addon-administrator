/**
 * Repeater script.
 * @link https://codepen.io/amostajo/pen/dyovLOG
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
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
        self.$index_editor = undefined;
        self.$edited_field = undefined;
        self.key = undefined;
        self.methods = {
            ready: function() {
                self.$template = self.$el.find( 'script[type="text/template"]' );
                self.$items = self.$el.find( '*[role="repeater-items"]' );
                self.$button = self.$el.find( '*[role="repeater-add"]' );
                if ( self.$button.length && self.$template.length && self.$items.length ) {
                    self.$button.on( 'click', self.methods.on_add );
                    self.key = self.$items.find( '*[data-repeater-field="1"]' ).length;
                    self.methods.init_actions();
                    self.methods.update_index_tags();
                }
                self.$el.on( 'click', '*[role="repeater-remove"]', self.methods.on_remove );
                self.$el.on( 'click', '*[role="repeater-edit-index"]', self.methods.on_index_edit );
            },
            on_add: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                var $item = $('<div></div>');
                $item.html( self.$template.html() );
                $item.find( '*' ).each( function() {
                    if ( $( this ).attr( 'name' ) !== undefined ) {
                        var name = $( this ).attr( 'name' );
                        $( this ).attr( 'name', name + '[]' );
                    }
                } );
                $item.find( '*[id]' ).each( function() {
                    regen_id( $( this ), $item );
                } );
                var aux = 0;
                $item.find( '*[data-repeater="1"]' ).each( function() {
                    if ( aux === 0 ) {
                        // Add actions
                        $( this ).find( '*[role="repeater-actions"]' ).html(
                            $( document ).find( '#repeater-actions' ).html()
                        );
                    }
                    $( this ).attr( 'data-repeater-field', 1 );
                    $( this ).attr( 'data-repeater-key', self.key );
                    aux++;
                } );
                $( document ).trigger( 'repeater:items.add.before', [self.$items, self] );
                self.$items.append( $item.html() );
                $( document ).trigger( 'repeater:items.add.after', [self.$items, self.key, self] );
                self.key++;
                self.methods.update_evens_odds();
            },
            on_remove: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                var key = $( this ).closest( '*[data-repeater-field="1"]' ).data( 'repeater-key' );
                if ( key !== undefined && confirm( self.$el.data( 'remove-message' ) ) ) {
                    $( document ).trigger( 'repeater:items.remove.before', [self.$items, key, self] );
                    self.$items.find( '*[data-repeater-key="' + key + '"]' ).remove();
                    self.methods.update_evens_odds();
                    $( document ).trigger( 'repeater:items.remove.after', [self.$items, key, self] );
                }
            },
            init_actions: function() {
                var keys = [];
                self.$items.find( '*[data-repeater-field="1"]' ).each( function() {
                    var key = $( this ).data( 'repeater-key' );
                    if ( key !== undefined
                        && keys.find( function( existing ) { return existing === key; } ) === undefined
                    ) {
                        keys.push( key );
                        $( this ).find( '*[role="repeater-actions"]' ).html(
                            $( document ).find( '#repeater-actions' ).html()
                        );
                    }
                } );
                // Index editor
                var $template = $( $( document ).find( '#repeater-index-editor' ).html() );
                $template.attr( 'id', 'index-editor' ).css( 'display', 'none' );
                $( 'body' ).append( $template );
                self.$index_editor = $( '#index-editor' );
                self.$index_editor.find( '*[role="index-cancel"]' ).on( 'click', self.methods.on_index_cancel );
                self.$index_editor.find( '*[role="index-update"]' ).on( 'click', self.methods.on_index_update );
                self.$index_editor.find( 'input' ).on( 'keypress', function( event ) {
                    if ( event.which === 13 ) {
                        return self.methods.on_index_update();
                    }
                } );
                $( document ).trigger( 'repeater:init', self );
            },
            update_evens_odds: function() {
                var keys = [];
                self.$items.find( '*[data-repeater-field="1"]' ).each( function() {
                    var key = $( this ).data( 'repeater-key' );
                    if ( key !== undefined
                        && keys.find( function( existing ) { return existing === key; } ) === undefined
                    ) {
                        keys.push( key );
                    }
                } );
                for ( var i = 0; i < keys.length; i++ ) {
                    var is_odd = ( i + 1 ) % 2;
                    self.$items.find( '*[data-repeater-key="' + keys[i] + '"]' ).removeClass( is_odd ? 'repeater-even' : 'repeater-odd' );
                    self.$items.find( '*[data-repeater-key="' + keys[i] + '"]' ).addClass( is_odd ? 'repeater-odd' : 'repeater-even' );
                }
            },
            on_index_edit: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                self.$edited_field = $( this );
                var index = self.$edited_field.closest( '*[data-repeater-field="1"]' )
                    .find( '*[name]' )
                    .attr( 'name' )
                    .replace( /^[a-zA-Z0-9\-\_]+\[|\]\[|\]/g, '' );
                self.$index_editor.find( 'input' ).val( index );
                self.$index_editor.css({
                    top: self.$edited_field.offset().top - 5,
                    left: self.$edited_field.offset().left - self.$index_editor.width() - 12,
                });
                self.$index_editor.show();
                self.$index_editor.find( 'input' ).focus();
            },
            on_index_cancel: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                self.$index_editor.hide();
            },
            on_index_update: function( event ) {
                if ( event !== undefined )
                    event.preventDefault();
                var key = self.$edited_field.closest( '*[data-repeater-field="1"]' ).data( 'repeater-key' );
                self.$items.find( '*[data-repeater-key="' + key + '"]' ).each( function() {
                    var name = $( this ).find( '*[name]' ).attr( 'name' );
                    var multidimension = name.match( /\[/g ).length;
                    name = name.replace( /\[(|[\s\S]+)\]/g, '' ) + '[' + self.methods.slugify( self.$index_editor.find( 'input' ).val() ) + ']';
                    for ( var i = 1; i < multidimension; i++ ) {
                        name += '[]';
                    }
                    $( this ).find( '*[name]' ).attr( 'name', name );
                } );
                self.$index_editor.hide();
                self.methods.update_index_tags();
            },
            update_index_tags: function() {
                self.$items.find( '*[data-repeater-field="1"]' ).each( function() {
                    // Remove any existing tag
                    $( this ).find( '.index-tag' ).remove();
                    var index = $( this ).find( '*[name]' )
                        .attr( 'name' )
                        .replace( /^[a-zA-Z0-9\-\_]+\[|\]\[|\]/g, '' )
                        .trim();
                    if ( index && index !== '' ) {
                        var $template = $( $( document ).find( '#repeater-index-tag' ).html() );
                        $template.find( '*[role="index-value"]' ).text( index );
                        $( this ).find( '*[name]' )
                            .closest( 'td' )
                            .append( $template );
                    }
                } );
            },
            slugify: function( value ) {
                return value.toString().toLowerCase().trim()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/&/g, '-and-')         // Replace & with 'and'
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')
                    .replace(/\-/g, '_');
            }
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