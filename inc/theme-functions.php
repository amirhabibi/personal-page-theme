<?php
/*
 * The fonts
 */
require_once dirname( __FILE__ ) . '/fonts.php';

function sort_fonts( $a, $b ) {
    return strcmp($a['name'], $b['name']);
}
usort($fonts_data, 'sort_fonts');

$font_names = array();
foreach ($fonts_data as $key){
    array_push($font_names, $key['name']);
}

$default_font_headings = array_search( 'Old Standard TT', $font_names );
$default_font_paragraphs = array_search( 'Arial', $font_names );

/* 
 * The very Defaults. Don't change them here. Use the theme options in the Wordpress admin.
 */
$_ppt['std']['layout'] = 'left';
$_ppt['std']['content'] = '
<h1>Personal Page Theme</h1>
<p>Personal Page Theme is a Responsive Single Page Theme for WP similar to <a href="http://about.me" target="_blank">about.me</a>.<br />To edit this page, go to Appearance / Theme options.</p>
';
$_ppt['std']['default_background'] = 'bg_02.jpg';
$_ppt['std']['background_color'] = '#333333';
$_ppt['std']['background_fade'] = '1';
$_ppt['std']['logo'] = 'logo-bretzel.png';
$_ppt['std']['about_width'] = '410px';
$_ppt['std']['custom_css_only'] = '0';
$_ppt['std']['link_color'] = '#FFFFFF';
$_ppt['std']['link_hover_color'] = '#ECB011';
$_ppt['std']['link_underline_color'] = '#ECB011';
$_ppt['std']['link_underline_disabled'] = '0';
$_ppt['std']['link_weight'] = 'bold';
$_ppt['std']['font_headings'] = array( 'size' => '70px', 'face' => $default_font_headings, 'style' => 'normal', 'color' => '#ffffff');
$_ppt['std']['font_paragraphs'] = array( 'size' => '16px', 'face' => $default_font_paragraphs, 'style' => 'normal', 'color' => '#ffffff');
$_ppt['std']['facebook_url'] = 'http://www.facebook.com/amirhabibi.is';
$_ppt['std']['twitter_url'] = 'https://twitter.com/amirhabibi';

/*
 * Hex to rgb conversion.
 */
function hex2rgb( $colour ) {

    if ( $colour[0] == '#' ) {
        $colour = substr( $colour, 1 );
    }
    if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( $r, $g, $b );
    
}

/* 
 * Options location.
 */
add_filter( 'options_framework_location', 'options_framework_location_override' );
function options_framework_location_override() {
    return array('/inc/options.php');
}

/*
 * Let's allow some tags in textareas in out Options.
 */ 
add_action( 'admin_init', 'optionscheck_change_santiziation', 100);
function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
function custom_sanitize_textarea( $input ) {
    global $allowedposttags;
    $custom_allowedtags['link'] = array(
        'href' => array(),
        'rel' => array(),
        'type' => array()
    );
    $custom_allowedtags['script'] = array();
    $custom_allowedtags = array_merge( $custom_allowedtags, $allowedposttags );
    $output = wp_kses( $input, $custom_allowedtags );
    return $output;
}

/*
 * Google fonts ?
 */
function options_typography_google_fonts() {

    global $_ppt, $fonts_data;
    $font_headings = of_get_option( 'font_headings', $_ppt['std']['font_headings'] );
    $font_paragraphs = of_get_option( 'font_paragraphs', $_ppt['std']['font_paragraphs'] );

    $selected_fonts = array (
        $font_headings['face'],
        $font_paragraphs['face']    
    );

    // Remove duplicates
    $selected_fonts = array_unique($selected_fonts);
    
    $names = array();
    foreach ( $selected_fonts as $font ) { 
        if ( $fonts_data[$font]['source'] === 'google' ) {
            $names[] = str_replace( ' ', '+', $fonts_data[$font]['name'] ) . $fonts_data[$font]['variant'];
        }
    }

    if ( count($names) ) {
        return '<link href="http://fonts.googleapis.com/css?family=' . implode( '|' , $names ) . '" rel="stylesheet" type="text/css">';
    }

}

/*
 * Returns a typography option in a format that can be outputted as inline CSS
 */
function options_typography_font_styles($option) {

    global $_ppt, $fonts_data;
    $font_family = '"' . $fonts_data[$option['face']]['name'] . '"';
    if ( isset($fonts_data[$option['face']]['faces']) && $fonts_data[$option['face']]['faces'] ) {
         $font_family .= ', ' . $fonts_data[$option['face']]['faces'];
    } else {
        $font_family .= ', sans-serif'; 
    }

    // This is based on the Golden Ratio Typography Calculator
    // http://www.pearsonified.com/typography/
    // The formula :
    // http://www.pearsonified.com/2011/12/golden-ratio-typography.php

    $about_width = 550;

    $font_size = (int)$option['size'];  
    $h = 1.618 - ( 1 / (2*1.618) ) *  ( 1 - $about_width / ( ($font_size*1.618)*($font_size*1.618) ) );
    $line_height = (int)($font_size * $h);

    $output = 'font: ' . $option['style'] . ' ' . $option['size'] . '/' . $line_height . 'px ' . $font_family  . '; color: ' . $option['color'] . ';';
    return $output;

}

/*
 * Find the full size of the background image. To be optimized.
 */
function background_src() {

    $page = get_page_by_title( 'Background', 'OBJECT', 'optionsframework' );

    if ( $page->ID ) {
        $get_children_array = get_children(array('post_parent' => $page->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => 1 ));
        $rekeyed_array = array_values($get_children_array);
        $child_image = $rekeyed_array[0];
        $att = wp_get_attachment_image_src($child_image->ID, 'full');
        return $att[0];
    } else {
        return false;
    }

}

?>