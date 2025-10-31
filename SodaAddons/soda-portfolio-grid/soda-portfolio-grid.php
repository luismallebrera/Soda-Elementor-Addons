<?php
/*
Plugin Name: Soda Portfolio Grid
Description: A standalone Elementor widget for a flexible portfolio grid with filtering and layouts.
Version: 1.0.0
Author: SODA
Text Domain: soda-plugin
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Enqueue styles and scripts for frontend
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'soda-portfolio-grid', plugin_dir_url( __FILE__ ) . 'assets/elementor-portfolio-grid.css', [], '1.0.0' );
    wp_enqueue_script( 'isotope', plugin_dir_url( __FILE__ ) . 'assets/isotope.pkgd.min.js', [ 'jquery' ], '3.0.6', true );
    wp_enqueue_script( 'imagesloaded', plugin_dir_url( __FILE__ ) . 'assets/imagesloaded.pkgd.min.js', [ 'jquery' ], '4.1.4', true );
    wp_enqueue_script( 'packery', plugin_dir_url( __FILE__ ) . 'assets/packery-mode.pkgd.min.js', [ 'isotope' ], '2.0.1', true );
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
    wp_enqueue_script( 'isotope-js', plugin_dir_url( __FILE__ ) . 'assets/isotope.js', [ 'jquery', 'isotope', 'imagesloaded', 'packery' ], '1.0.0', true );
    wp_enqueue_script( 'soda-portfolio-grid', plugin_dir_url( __FILE__ ) . 'assets/soda-portfolio-grid.js', [ 'jquery', 'isotope', 'imagesloaded', 'packery' ], '1.0.0', true );
});

// Register the widget **AFTER Elementor is loaded**
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-soda-portfolio-grid-widget.php';
    if ( class_exists( '\SODA\Widgets\Soda_Portfolio_Grid' ) ) {
        $widgets_manager->register( new \SODA\Widgets\Soda_Portfolio_Grid() );
    }
});
