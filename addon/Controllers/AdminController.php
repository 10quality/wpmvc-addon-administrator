<?php

namespace WPMVC\Addons\Administrator\Controllers;

use ReflectionClass;
use WPMVC\Request;
use WPMVC\Response;
use WPMVC\MVC\Controller;
use WPMVC\Addons\Administrator\AdministratorAddon;
use WPMVC\Addons\Administrator\Abstracts\Control;
use WPMVC\Addons\Administrator\Abstracts\SettingsModel;
use WPMVC\Addons\Administrator\Helpers\RenderHelper;

/**
 * Admin settings hooks.
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.5
 */
class AdminController extends Controller
{
    /**
     * Inits by registering administrator models and configurations.
     * @since 1.0.0
     */
    public function init()
    {
        // Registered settings models
        $models = $this->get_models();
        foreach ( $models as $key => $model ) {
            if ( array_key_exists( 'parent', $model->menu ) ) {
                add_submenu_page(
                    $model->menu['parent'],
                    $model->title,
                    array_key_exists( 'title', $model->menu ) ? $model->menu['title'] : $model->title,
                    array_key_exists( 'capability', $model->menu ) ? $model->menu['capability'] : 'manage_options',
                    $model->get_page_slug(),
                    [&$this, 'process_' . $key],
                    array_key_exists( 'position', $model->menu ) ? $model->menu['position'] : null
                );
            } else {
                add_menu_page(
                    $model->title,
                    array_key_exists( 'title', $model->menu ) ? $model->menu['title'] : $model->title,
                    array_key_exists( 'capability', $model->menu ) ? $model->menu['capability'] : 'manage_options',
                    $model->get_page_slug(),
                    [&$this, 'process_' . $key],
                    array_key_exists( 'icon', $model->menu ) ? $model->menu['icon'] : '',
                    array_key_exists( 'position', $model->menu ) ? $model->menu['position'] : null
                );
            }
        }
    }
    /**
     * Detenct page rendering.
     * @since 1.0.0
     * 
     * @param string $method
     * @param array  $args
     * 
     * @return mixed
     */
    public function __call( $method, $args = [] )
    {
        if ( strpos( $method, 'process_' ) === 0 ) {
            // Prepare
            $models = $this->get_models();
            $key = str_replace( 'process_', '', $method );
            // Validate
            $model = array_key_exists( $key, $models ) && $models[$key] ? $models[$key] : null;
            $current_tab = Request::input( 'tab', $model->default_tab );
            if ( empty( $model )
                || ! array_key_exists( $current_tab, $model->tabs )
                || ! is_array( $model->tabs[$current_tab] )
                || ! array_key_exists( 'fields', $model->tabs[$current_tab] )
                || ! is_array( $model->tabs[$current_tab]['fields'] )
                || empty( $model->tabs[$current_tab]['fields'] )
            ) {
                global $wp_query;
                $wp_query->set_404();
                status_header( 404 );
                die;
            }
            // Filters
            $model = apply_filters( 'administrator_preload_model_' . $key, $model, $current_tab );
            // Obtain all registered controls
            $controls_in_use = [];
            array_map( function( $field ) use( &$controls_in_use ) {
                if ( ( ! array_key_exists( 'type' , $field ) && ! in_array( 'input', $controls_in_use ) )
                    || ( array_key_exists( 'type' , $field ) && ! in_array( $field['type'], $controls_in_use ) )
                ) {
                    $controls_in_use[] = array_key_exists( 'type' , $field ) ? $field['type'] : 'input';
                }
            }, $model->tabs[$current_tab]['fields'] );
            $controls = $this->get_controls( $controls_in_use );
            // Model handling
            $model->load( $model->id );
            $response = null;
            if ( $_POST ) {
                $response = $this->save( $model, $current_tab );
            }
            $model = $model->get_updated_instance();
            $model = apply_filters( 'administrator_model_' . $key, $model, $current_tab );
            $this->render( $model, $current_tab, $response, $controls );
        }
    }
    /**
     * Saves current tab data.
     * @since 1.0.0
     * 
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel &$model
     * @param string                                              $current_tab
     * 
     * @return \WPMVC\Response
     */
    protected function save( SettingsModel &$model, $current_tab )
    {
        $response = new Response;
        foreach ( $model->tabs[$current_tab]['fields'] as $field_id => $field ) {
            $value = Request::input(
                $field_id,
                array_key_exists( 'type', $field )
                    && in_array( $field['type'], apply_filters( 'administrator_bool_fields', [] ) )
                        ? 0
                        : null,
                false,
                array_key_exists( 'sanitize_callback', $field ) ? $field['sanitize_callback'] : true
            );
            $model->$field_id = $value;
        }
        foreach ( $model->tabs[$current_tab]['fields'] as $field_id => $field ) {
            if ( array_key_exists( 'validate_callback', $field )
                && is_callable( $field['validate_callback'] )
                && !call_user_func_array( $field['validate_callback'], [$model->$field_id, $model] )
            ) {
                $response->error( $field_id, array_key_exists( 'validate_message', $field )
                    ? sprintf(
                        $field['validate_message'],
                        array_key_exists( 'title', $field ) ? $field['title'] : $field_id
                    )
                    : sprintf(
                        __( '<b>%s</b> is invalid.', 'wpmvc-addon-administrator' ),
                        array_key_exists( 'title', $field ) ? $field['title'] : $field_id
                    )
                );
            }
        }
        if ( $response->passes ) {
            $model = apply_filters( 'administrator_settings_before_save_' . $model->id, $model, $current_tab );
            $model->save();
            do_action( 'administrator_settings_saved_' . $model->id, $model );
            $response->success = true;
            $response->message = $model->save_message;
        }
        return $response;
    }
    /**
     * Renders output.
     * @since 1.0.0
     * 
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel &$model
     * @param string                                              $current_tab
     * @param \WPMVC\Response                                     &$response   Save response.
     * @param array                                               &$controls   Controls in use.
     */
    protected function render( SettingsModel &$model, $current_tab, &$response, &$controls )
    {
        // Prepare fields
        $fields = $model->tabs[$current_tab]['fields'];
        foreach ( $fields as $field_id => $field ) {
            if ( array_key_exists( 'type', $field ) && in_array( $field['type'], apply_filters( 'administrator_no_value_fields', [] ) ) ) {
                continue;
            }
            $fields[$field_id]['id'] = $field_id;
            $fields[$field_id]['value'] = $model->$field_id;
            $fields[$field_id]['_control'] = array_key_exists( 'type', $field ) ? $field['type'] : 'input';
            if ( $fields[$field_id]['value'] === null && array_key_exists( 'default', $field ) ) {
                $fields[$field_id]['value'] = $field['default'];
            }
            $attributes = [];
            if ( array_key_exists( 'control', $field )
                && is_array( $field['control'] )
                && array_key_exists( 'attributes', $field['control'] )
            ) {
                foreach ( $field['control']['attributes'] as $key => $value) {
                    $attributes[] = esc_attr( $key ) . '="'. esc_attr( $value )  .'"';
                }
            }
            $fields[$field_id]['html_attributes'] = implode( ' ', $attributes );
        }
        $fields = apply_filters( 'administrator_model_fields_' . $model->id, $fields, $model, $current_tab );
        // Enqueue
        $model->enqueue();
        foreach ( $controls as $key => $control ) {
            $control->enqueue();
        }
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style(
            'wpmvc-administrator-repeater',
            addon_assets_url( 'css/repeater.css', __FILE__ ),
            [],
            '1.0.1'
        );
        wp_enqueue_script(
            'wpmvc-administrator-repeater',
            addon_assets_url( 'js/jquery.repeater.js', __FILE__ ),
            ['jquery'],
            '1.0.1',
            true
        );
        wp_enqueue_script(
            'wpmvc-administrator-hideshow',
            addon_assets_url( 'js/jquery.hide-show.js', __FILE__ ),
            ['jquery'],
            '1.0.4',
            true
        );
        do_action( 'administrator_enqueue_' . $model->id );
        // Render header
        AdministratorAddon::view( 'administrator.header', ['model' => &$model, 'tab' => $current_tab] );
        // Notices
        if ( $response !== null ) {
            AdministratorAddon::view( $response->success ? 'administrator.responses.success' : 'administrator.responses.errors', ['response' => &$response] );
        }
        // Tabs
        if ( $model->has_nav_tab() ) {
            AdministratorAddon::view( 'administrator.nav_tab', ['model' => &$model, 'tab' => $current_tab] );
        }
        // Render form
        if ( !array_key_exists( 'submit', $model->tabs[$current_tab] ) || $model->tabs[$current_tab]['submit'] === true ) {
            AdministratorAddon::view( 'administrator.form-wrapper-open', ['model' => &$model, 'tab' => $current_tab] );
        }
        AdministratorAddon::view( 'administrator.tab', [
            'model' => &$model,
            'tab' => $current_tab,
            'controls' => &$controls,
            'fields' => &$fields,
            'helper' => new RenderHelper,
        ] );
        if ( !array_key_exists( 'submit', $model->tabs[$current_tab] ) || $model->tabs[$current_tab]['submit'] === true ) {
            AdministratorAddon::view( 'administrator.form-wrapper-close', ['model' => &$model, 'tab' => $current_tab] );
        }
        // Render footer
        AdministratorAddon::view( 'administrator.footer', ['model' => &$model, 'tab' => $current_tab] );
        AdministratorAddon::view( 'administrator.repeater-field-actions' );
        AdministratorAddon::view( 'administrator.repeater-index-editor' );
        AdministratorAddon::view( 'administrator.repeater-index-tag' );
        foreach ( $controls as $key => $control ) {
            $control->footer();
        }
    }
    /**
     * Returns control's <tr> attributes.
     * @since 1.0.1
     * 
     * @hook administrator_control_tr
     * 
     * @param array                                               $attributes
     * @param array                                               $field
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     * @param \WPMVC\Addons\Administrator\Helpers\RenderHelper    $helper
     * 
     * @return array|string
     */
    public function control_tr( $attributes, $field, SettingsModel $model, RenderHelper $helper )
    {
        if ( ! is_array( $attributes ) ) return '';
        // Special controls
        if ( array_key_exists( 'control' , $field )
            && is_array( $field['control'] )
            && array_key_exists( 'type' , $field['control'] )
            && $field['control']['type'] === 'hidden'
        ) {
            $attributes['class'] = 'hidden';
            $attributes['style'] = 'display:none';
        }
        // Hide/show
        $this->add_field_attribute_show_if( $attributes, $field, $model );
        $this->add_field_attribute_hide_if( $attributes, $field, $model );
        // Repeater
        if ( $helper->is_repeater_opened ) {
            $attributes['data-repeater'] = 1;
            if ( ! array_key_exists( 'class', $attributes ) )
                $attributes['class'] = '';
            $attributes['class'] .= ' ' . ( $helper->is_repeater_odd ? 'repeater-odd' : 'repeater-even' );
            if ( array_key_exists( 'field_id', $field ) )
                $attributes['aria-field'] = '#' . $field['field_id'];
        }
        if ( $helper->is_repeater_field ) {
            $attributes['data-repeater-field'] = 1;
        }
        if ( array_key_exists( 'repeater_key' , $field ) ) {
            $attributes['data-repeater-key'] = $field['repeater_key'];
        }
        // Render
        return $this->render_attributes( $attributes );
    }
    /**
     * Returns section control's attributes.
     * @since 1.0.2
     * 
     * @hook administrator_control_section
     * 
     * @param array                                               $attributes
     * @param array                                               $field
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     * @param \WPMVC\Addons\Administrator\Helpers\RenderHelper    $helper
     * 
     * @return array|string
     */
    public function control_section( $attributes, $field, SettingsModel $model, RenderHelper $helper )
    {
        if ( ! is_array( $attributes ) ) return '';
        // Hide/show
        $this->add_field_attribute_show_if( $attributes, $field, $model );
        $this->add_field_attribute_hide_if( $attributes, $field, $model );
        // Render
        return $this->render_attributes( $attributes );
    }
    /**
     * Returns array collection with setting models available.
     * @since 1.0.0
     * 
     * @return array
     */
    private function get_models()
    {
        return array_filter(
            array_map( function( $class ) {
                $reflector = new ReflectionClass( $class );
                return $reflector->newInstance();
            }, apply_filters( 'administrator_models', [] ) ),
            function( $model ) {
                return $model && $model instanceof SettingsModel;
            }
        );
    }
    /**
     * Returns array with the field controls available.
     * @since 1.0.0
     * 
     * @param array &$controls_in_use
     * 
     * @return array
     */
    private function get_controls( &$controls_in_use )
    {
        return array_filter(
            array_map(
                function ( $class ) {
                    $reflector = new ReflectionClass( $class );
                    return $reflector->newInstance();
                },
                apply_filters( 'administrator_controls', [] )
            ),
            function( $control ) use( &$controls_in_use ) {
                return $control && $control instanceof Control && in_array( $control->type, $controls_in_use );
            }
        );
    }
    /**
     * Adds show if logic to field attributes.
     * @since 1.0.2
     * 
     * @param array                                               &$attributes Current list of attributes.
     * @param array                                               &$field
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     */
    private function add_field_attribute_show_if( &$attributes, &$field, &$model )
    {
        if ( array_key_exists( 'show_if', $field ) && is_array( $field['show_if'] ) ) {
            $show_if = [];
            foreach ( $field['show_if'] as $field_id => $value ) {
                if ( ! is_array( $value ) )
                    $value = [$value];
                $is_selector = preg_match( '/^(\*|\.|#)/', $field_id );
                $show_if[] = ( $is_selector ? '' : '#' ) . $field_id . ':' . implode( ',', $value );
                // Hide current field ?
                if ( ! $is_selector && ! in_array( $model->$field_id, $value ) ) {
                    $attributes['class'] = 'hidden';
                    $attributes['style'] = 'display:none';
                }
            }
            $attributes['data-show-if'] = implode( '|' , $show_if );
        }
    }
    /**
     * Adds hide if logic to field attributes.
     * @since 1.0.2
     * 
     * @param array                                               &$attributes Current list of attributes.
     * @param array                                               &$field
     * @param \WPMVC\Addons\Administrator\Abstracts\SettingsModel $model
     */
    private function add_field_attribute_hide_if( &$attributes, &$field, &$model )
    {
        if ( array_key_exists( 'hide_if', $field ) && is_array( $field['hide_if'] ) ) {
            $hide_if = [];
            foreach ( $field['hide_if'] as $field_id => $value ) {
                if ( ! is_array( $value ) )
                    $value = [$value];
                $is_selector = preg_match( '/^(\*|\.|#)/', $field_id );
                $hide_if[] = ( $is_selector ? '' : '#' ) . $field_id . ':' . implode( ',', $value );
                // Hide current field ?
                if ( ! $is_selector && in_array( $model->$field_id, $value ) ) {
                    $attributes['class'] = 'hidden';
                    $attributes['style'] = 'display:none';
                }
            }
            $attributes['data-hide-if'] = implode( '|' , $hide_if );
        }
    }
    /**
     * Render's HTML attributes.
     * @since 1.0.2
     * 
     * @param array $attributes
     * 
     * @return string
     */
    private function render_attributes( $attributes )
    {
        foreach ( $attributes as $key => $value ) {
            $attributes[$key] = esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
        }
        return implode( ' ', $attributes );
    }
}