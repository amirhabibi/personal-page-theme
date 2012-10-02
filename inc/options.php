<?php
/*
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	global $_ppt, $fonts_data, $font_names;
	$imagepath =  get_stylesheet_directory_uri() . '/images/';

	$font_weight = array(
		'normal' => __('Normal', 'personalpagetheme'),
		'bold' => __('Bold', 'personalpagetheme')
	);

	$wp_editor_settings = array(
		'wpautop' => true, 
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options = array();

	$options[] = array(
		'name' => __('Layout', 'personalpagetheme'),
		'type' => 'heading');

	$options[] = array(
		'name' => "Layout",
		'desc' => "Main text position. Default is left",
		'id' => "layout",
		'std' => $_ppt['std']['layout'],
		'type' => "images",
		'options' => array(
			'left' => $imagepath . 'layout-text-left.png',
			'right' => $imagepath . 'layout-text-right.png')
	);

	$options[] = array(
		'name' => __('Logo', 'personalpagetheme'),
		'desc' => __('Small logo. Width will be ajusted to fit 50px.', 'personalpagetheme'),
		'id' => 'logo',
		'std' => $imagepath . $_ppt['std']['logo'],
		'type' => 'upload');

	$options[] = array(
		'name' => __('Custom background image', 'personalpagetheme'),
		'desc' => __('Custom background image. Will override included backgrounds.', 'personalpagetheme'),
		'id' => 'background',
		'type' => 'upload');

	$options[] = array(
		'name' => "Background image",
		'id' => "default_background",
		'std' => $_ppt['std']['default_background'],
		'type' => "images",
		'options' => array(
			'bg_01.png' => $imagepath . 'bg_01_t.png',
			'bg_02.jpg' => $imagepath . 'bg_02_t.jpg',
			'bg_03.png' => $imagepath . 'bg_03_t.png',
			'bg_04.png' => $imagepath . 'bg_04_t.png',
			'bg_05.jpg' => $imagepath . 'bg_05_t.jpg',
			'bg_06.png' => $imagepath . 'bg_06_t.png',
			'bg_07.png' => $imagepath . 'bg_07_t.png',
			'bg_08.png' => $imagepath . 'bg_08_t.png'
			)
	);

	$options[] = array(
		'name' => __('Background color', 'personalpagetheme'),
		'desc' => __('Used in mobile view.', 'personalpagetheme'),
		'id' => 'background_color',
		'std' => $_ppt['std']['background_color'],
		'type' => 'color' );

	$options[] = array(
		'name' => __('Background Fade', 'personalpagetheme'),
		'id' => 'background_fade',
		'std' => $_ppt['std']['background_fade'],
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Content', 'personalpagetheme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Main content', 'personalpagetheme'),
		'id' => 'content',
		'type' => 'editor',
		'std' => $_ppt['std']['content'],
		'settings' => $wp_editor_settings
	);

	$options[] = array(
	'name' => __('Font for headings', 'personalpagetheme'),
	'desc' => __('System fonts and <a href="http://google.com/webfonts">Google fonts</a> mixed.', 'personalpagetheme'),
	'id' => 'font_headings',
	'std' => $_ppt['std']['font_headings'],
	'type' => 'typography',
	'options' => array(
		'faces' => $font_names)
	);

	$options[] = array(
	'name' => __('Font for paragraphs', 'personalpagetheme'),
	'desc' => __('System fonts and <a href="http://google.com/webfonts">Google fonts</a> mixed.', 'personalpagetheme'),
	'id' => 'font_paragraphs',
	'std' => $_ppt['std']['font_paragraphs'],
	'type' => 'typography',
	'options' => array(
		'faces' => $font_names)
	);

	$options[] = array(
		'name' => __('Link color', 'personalpagetheme'),
		'id' => 'link_color',
		'std' => $_ppt['std']['link_color'],
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link Hover color', 'personalpagetheme'),
		'id' => 'link_hover_color',
		'std' => $_ppt['std']['link_hover_color'],
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link Underline color', 'personalpagetheme'),
		'id' => 'link_underline_color',
		'std' => $_ppt['std']['link_underline_color'],
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link weight', 'personalpagetheme'),
		'id' => 'link_weight',
		'std' => $_ppt['std']['link_weight'],
		'type' => 'select',
		'class' => 'mini',
		'options' => $font_weight);

	$options[] = array(
		'name' => __('Disable underlines for links', 'personalpagetheme'),
		'id' => 'link_underline_disabled',
		'std' => $_ppt['std']['link_underline_disabled'],
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Social', 'personalpagetheme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Email', 'personalpagetheme'),
		'id' => 'email',
		'type' => 'text');

	$options[] = array(
		'name' => __('Skype', 'personalpagetheme'),
		'id' => 'skype',
		'type' => 'text');

	$options[] = array(
		'name' => __('Facebook URL', 'personalpagetheme'),
		'id' => 'facebook_url',
		'std' => $_ppt['std']['facebook_url'],
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter URL', 'personalpagetheme'),
		'id' => 'twitter_url',
		'std' => $_ppt['std']['twitter_url'],
		'type' => 'text');

	$options[] = array(
		'name' => __('Google+ URL', 'personalpagetheme'),
		'id' => 'googleplus_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Linkedin URL', 'personalpagetheme'),
		'id' => 'linkedin_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flickr URL', 'personalpagetheme'),
		'id' => 'flickr_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Dribbble URL', 'personalpagetheme'),
		'id' => 'dribbble_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Vimeo URL', 'personalpagetheme'),
		'id' => 'vimeo_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Tumblr URL', 'personalpagetheme'),
		'id' => 'tumblr_url',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Advanced', 'personalpagetheme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Text bloc width (with units)', 'personalpagetheme'),
		'desc' => __('Default is ' . $_ppt['std']['about_width'] . '.', 'personalpagetheme'),
		'id' => 'about_width',
		'std' => $_ppt['std']['about_width'],
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('<head> section', 'personalpagetheme'),
		'desc' => __('Custom HTML code. Will be added in the &lt;head&gt; of the page. If you\'re using services like Typekit, here you can paste the code in order to load external fonts. ', 'personalpagetheme'),
		'id' => 'head',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Custom CSS', 'personalpagetheme'),
		'desc' => __('Custom CSS code. Will be added after the existing styles. Main elements are : #about, #logo, h1, p.', 'personalpagetheme'),
		'id' => 'css',
		'type' => 'textarea',
		'validate' => 'none');

	$options[] = array(
		'name' => __('Disable theme\'s default CSS', 'personalpagetheme'),
		'desc' => __('Only your custom CSS will be added.', 'personalpagetheme'),
		'id' => 'custom_css_only',
		'std' => $_ppt['std']['custom_css_only'],
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Tracking Code', 'personalpagetheme'),
		'desc' => __('Paste your <a href="http://www.google.com/analytics/">Google Analytics</a> or any other tracking code here.', 'personalpagetheme'),
		'id' => 'tracking_code',
		'type' => 'textarea');

	return $options;
}

