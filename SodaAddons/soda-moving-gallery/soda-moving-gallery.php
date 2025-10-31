<?php
/**
 * Plugin Name: Soda Moving Gallery for Elementor
 * Description: An Elementor widget that displays a moving gallery on scroll.
 * Version: 1.0.0
 * Author: luismallebrera
 * Text Domain: soda-moving-gallery
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Register Widget
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once __DIR__ . '/includes/class-soda-moving-gallery-widget.php';
    $widgets_manager->register( new \Elementor_Soda_Moving_Gallery_Widget() );
} );

// Enqueue assets
add_action( 'wp_enqueue_scripts', function() {
    if ( ! is_admin() ) {
        wp_enqueue_style(
            'soda-moving-gallery',
            plugins_url( 'assets/moving-gallery.css', __FILE__ ),
            [],
            '1.0.0'
        );
        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/gsap.min.js',
            [],
            '3.12.1',
            true
        );
        wp_enqueue_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.1',
            true
        );
        wp_enqueue_script(
            'soda-moving-gallery',
            plugins_url( 'assets/moving-gallery.js', __FILE__ ),
            ['gsap', 'gsap-scrolltrigger'],
            '1.0.0',
            true
        );
    }
} );