/**
 * Select2 control script.
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
 */
( function( $ ) { $( document ).ready( function() {
    /**
     * Select 2 request to be sent to server.
     * @since 1.0.4
     *
     * @link https://select2.org/data-sources/ajax
     *
     * @param {object} params
     *
     * @return {object}
     */
    window.default_select2_request = function( params ) {
        return {
            q: params.q,
            term: params.term,
            page: params.page,
        };
    };
    /**
     * Select 2 default response results handler.
     * @since 1.0.4
     *
     * @link https://select2.org/data-sources/ajax
     *
     * @param {object} response
     * @param {object} params
     *
     * @return {object}
     */
    window.default_select2_results = function( response, params ) {
        var data = {
            results: response && response.data && response.data.results
                ? response.data.results
                : ( response && response.data ? response.data : response ),
        };
        if ( response && response.data && response.data.pagination ) {
            data.pagination = {
                more: true,
            };
        }
        return data;
    };
    /**
     * Select 2 default response results handler.
     * @since 1.0.4
     *
     * @link https://select2.org/data-sources/ajax
     *
     * @param {object} row Results row.
     *
     * @return {object}
     */
    window.select2_format_html = function( row ) {
        if ( row.loading ) {
            return row.text;
        }
        return $( row.text );
    }
    /**
     * Init datepicker plugin on every input requesting it.
     * @since 1.0.4
     */
    $( '.select2' ).each( function() {
        var ajax = undefined;
        regen_id( $( this ), undefined, 's2' );
        var $select2 = $( '#' + $( this ).attr( 'id' ) );
        if ( $select2.data( 'ajax' ) ) {
            ajax = {
                url: $select2.data( 'ajax' ),
                dataType: $select2.data( 'ajax-data-type' ) || 'json',
                data: $select2.data( 'ajax-request' ) ? window[$( this ).data( 'ajax-request' )] : window.default_select2_request,
                processResults: $select2.data( 'ajax-results' ) ? window[$( this ).data( 'ajax-results' )] : window.default_select2_results,
                delay: $select2.data( 'ajax-delay' ) || undefined,
                cache: $select2.data( 'ajax-cache' ) !== undefined ? $( this ).data( 'ajax-cache' ) : undefined,
            }
        }
        $select2.select2( {
            placeholder: $select2.attr( 'placeholder' ) || undefined,
            allowClear: $select2.data( 'allow-clear' ) !== undefined ? $( this ).data( 'allow-clear' ) : false,
            ajax: ajax,
            minimumInputLength: $select2.data( 'min-input-length' ) || 0,
            maximumInputLength: $select2.data( 'max-input-length' ) || 0,
            maximumSelectionLength: $select2.data( 'max-selection-length' ) || 0,
            minimumResultsForSearch: $select2.data( 'min-results-search' ) || 0,
            templateResult: $select2.data( 'template-results' ) ? window[$select2.data( 'template-results' )] : undefined,
            templateSelection: $select2.data( 'template-selection' ) ? window[$select2.data( 'template-selection' )] : undefined,
            sorter: $select2.data( 'sorter' ) ? window[$select2.data( 'sorter' )] : undefined,
            tokenizer: $select2.data( 'tokenizer' ) ? window[$select2.data( 'tokenizer' )] : undefined,
            initSelection: $select2.data( 'init-selection' ) ? window[$select2.data( 'init-selection' )] : undefined,
            matcher: $select2.data( 'matcher' ) ? window[$select2.data( 'matcher' )] : undefined,
            tags: $select2.data( 'tags' ) !== undefined ? $( this ).data( 'tags' ) : false,
            selectOnClose: $select2.data( 'select-on-close' ) !== undefined ? $( this ).data( 'select-on-close' ) : false,
            scrollAfterSelect: $select2.data( 'scroll-after-select' ) !== undefined ? $( this ).data( 'scroll-after-select' ) : false,
            containerCssClass: $select2.attr( 'container-class' ) || undefined,
            language: $select2.attr( 'lang' ) || undefined,
        } );
    } );
    /**
     * Repeater support, init select2 after items is added
     * @since 1.0.4
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.add.after', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .select2' ).length ) {
            var ajax = undefined;
            var $select2 = $('#' + $items.find( '*[data-repeater-key="' + key + '"] .select2' ).attr( 'id' ) );
            if ( $select2.data( 'ajax' ) ) {
                ajax = {
                    url: $select2.data( 'ajax' ),
                    dataType: $select2.data( 'ajax-data-type' ) || 'json',
                    data: $select2.data( 'ajax-request' ) ? window[$( this ).data( 'ajax-request' )] : window.default_select2_request,
                    processResults: $select2.data( 'ajax-results' ) ? window[$( this ).data( 'ajax-results' )] : window.default_select2_results,
                    delay: $select2.data( 'ajax-delay' ) || undefined,
                    cache: $select2.data( 'ajax-cache' ) !== undefined ? $select2.data( 'ajax-cache' ) : undefined,
                }
            }
            $select2.select2( {
                placeholder: $select2.attr( 'placeholder' ) || undefined,
                allowClear: $select2.data( 'allow-clear' ) !== undefined ? $select2.data( 'allow-clear' ) : false,
                ajax: ajax,
                minimumInputLength: $select2.data( 'min-input-length' ) || 0,
                maximumInputLength: $select2.data( 'max-input-length' ) || 0,
                maximumSelectionLength: $select2.data( 'max-selection-length' ) || 0,
                minimumResultsForSearch: $select2.data( 'min-results-search' ) || 0,
                templateResult: $select2.data( 'template-results' ) ? window[$select2.data( 'template-results' )] : undefined,
                templateSelection: $select2.data( 'template-selection' ) ? window[$select2.data( 'template-selection' )] : undefined,
                sorter: $select2.data( 'sorter' ) ? window[$select2.data( 'sorter' )] : undefined,
                tokenizer: $select2.data( 'tokenizer' ) ? window[$select2.data( 'tokenizer' )] : undefined,
                initSelection: $select2.data( 'init-selection' ) ? window[$select2.data( 'init-selection' )] : undefined,
                matcher: $select2.data( 'matcher' ) ? window[$select2.data( 'matcher' )] : undefined,
                tags: $select2.data( 'tags' ) !== undefined ? $select2.data( 'tags' ) : false,
                selectOnClose: $select2.data( 'select-on-close' ) !== undefined ? $select2.data( 'select-on-close' ) : false,
                scrollAfterSelect: $select2.data( 'scroll-after-select' ) !== undefined ? $select2.data( 'scroll-after-select' ) : false,
                containerCssClass: $select2.attr( 'container-class' ) || undefined,
                language: $select2.attr( 'lang' ) || undefined,
            } );
        }
    } );
    /**
     * Repeater support, destroy datepicker before item is removed
     * @since 1.0.4
     *
     * @param {object} event
     * @param {object} $items
     * @param {string} key
     */
    $( document ).on( 'repeater:items.remove.before', function( event, $items, key ) {
        if ( $items.find( '*[data-repeater-key="' + key + '"] .select2' ).length ) {
            var $select2 = $('#' + $items.find( '*[data-repeater-key="' + key + '"] .select2' ).attr( 'id' ) );
            $select2.select2( 'destroy' );
        }
    } );
} ); } )( jQuery );