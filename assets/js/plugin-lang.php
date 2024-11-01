<?php
if ( ! defined( 'ABSPATH' ) ){ exit; }

if ( ! class_exists( '_WP_Editors' ) ){
    require( ABSPATH . WPINC . '/class-wp-editor.php' );
}

function shaplatools_tinymce_plugin_translation() {
    $strings = array(
        'insert'            => __('Insert Shapla Shortcode', 'shaplatools'),
        'button'            => __('Buttons', 'shaplatools'),
        'columns'           => __('Columns', 'shaplatools'),
        'tabs'              => __('Tabs', 'shaplatools'),
        'toggle'            => __('Toggle', 'shaplatools'),
        'dropcap'           => __('Dropcap', 'shaplatools'),
        'icon'              => __('Font Icon', 'shaplatools'),
        'media_elements'    => __('Media Elements', 'shaplatools'),
        'widget_area'       => __('Widget Area', 'shaplatools'),
        'image'             => __('Image', 'shaplatools'),
        'video'             => __('Video', 'shaplatools'),
        'map'               => __('Google Map', 'shaplatools'),
    );
    $locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.shapla", ' . json_encode( $strings ) . ");\n";

     return $translated;
}

$strings = shaplatools_tinymce_plugin_translation();