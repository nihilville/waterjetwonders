<?php

////////////////////////////////////////////////////////////////////
// Define our current Version number using the stylesheet version
////////////////////////////////////////////////////////////////////
function my_wp_default_styles($styles) {
	$my_theme = wp_get_theme();
	$my_version = $my_theme->get('Version');
	$styles->default_version = $my_version;
}
add_action("wp_default_styles", "my_wp_default_styles");

////////////////////////////////////////////////////////////////////
// Enqueue Styles (normal style.css and bootstrap.css)
////////////////////////////////////////////////////////////////////
function waterjet_wonders_theme_stylesheets() {
	$my_theme = wp_get_theme();
	$my_version = $my_theme->get('Version');
	wp_enqueue_style('style.css', get_stylesheet_directory_uri() . '/css/style.min.css', $my_version, true);
}
add_action('wp_enqueue_scripts', 'waterjet_wonders_theme_stylesheets');

////////////////////////////////////////////////////////////////////
// Register Bootstrap JS with jquery
////////////////////////////////////////////////////////////////////
function waterjet_wonders_theme_js() {
	$my_theme = wp_get_theme();
	$my_version = $my_theme->get('Version');
	wp_enqueue_script('theme-js', get_stylesheet_directory_uri() . '/js/min/scripts.min.js', array('jquery'), $my_version, true );
}
add_action('wp_enqueue_scripts', 'waterjet_wonders_theme_js');