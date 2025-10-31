<?php
/**
 * Plugin Name: Soda Zoom Gallery
 * Description: An Elementor widget for a zoom gallery with scroll-triggered animation.
 * Version: 1.0.0
 * Author: luismallebrera
 * Text Domain: soda-zoom-gallery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Enqueue styles and scripts
function soda_zoom_gallery_enqueue_assets() {
	$plugin_url = plugin_dir_url(__FILE__);

	// Enqueue the main gallery CSS
	wp_enqueue_style(
		'soda-zoom-gallery',
		$plugin_url . 'assets/zoom-gallery.css',
		array(),
		'1.0.0'
	);

	// Enqueue GSAP core
	wp_enqueue_script(
		'gsap',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
		array(),
		'3.12.5',
		true
	);

	// Enqueue GSAP ScrollTrigger plugin
	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
		array('gsap'),
		'3.12.5',
		true
	);

	// Enqueue GSAP Flip plugin
	wp_enqueue_script(
		'gsap-flip',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Flip.min.js',
		array('gsap'),
		'3.12.5',
		true
	);

	// Enqueue your gallery JS, which depends on GSAP and the plugins
	wp_enqueue_script(
		'soda-zoom-gallery',
		$plugin_url . 'assets/zoom-gallery.js',
		array('gsap', 'gsap-scrolltrigger', 'gsap-flip'),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'soda_zoom_gallery_enqueue_assets' );

// Register the widget only after Elementor is loaded
function soda_zoom_gallery_register_widget() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	require_once( __DIR__ . '/includes/class-soda-zoom-gallery-widget.php' );
	\Elementor\Plugin::instance()->widgets_manager->register( new \Soda_Zoom_Gallery_Widget() );
}
add_action( 'elementor/widgets/register', 'soda_zoom_gallery_register_widget' );
