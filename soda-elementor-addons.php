<?php
/**
 * Plugin Name: Soda Elementor Addons
 * Description: Collection of custom Elementor widgets including menu, galleries, and more
 * Version: 2.3.0
 * Author: Soda Studio
 * Text Domain: soda-elementor-addons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Main Soda Elementor Addons Class
 */
final class Elementor_Menu_Widget_V2 {

    const VERSION = '2.3.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Register widget
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Register custom category
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);

        // Register widget styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);

        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Load custom icons
        $this->load_custom_icons();

        // Load parallax background feature
        $this->load_parallax_background();
    }

    public function load_custom_icons() {
        require_once(__DIR__ . '/modules/soda-addons-icons/icons-manager.php');
    }

    public function load_parallax_background() {
        require_once(__DIR__ . '/modules/parallax-background.php');
    }

    public function register_category($elements_manager) {
        $elements_manager->add_category(
            'soda-addons',
            [
                'title' => __('Soda Addons', 'soda-elementor-addons'),
                'icon'  => 'fa fa-plug',
            ]
        );
    }

    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" to be installed and activated.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'soda-elementor-addons') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" version %%3$s or greater.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'soda-elementor-addons') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" version %%3$s or greater.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('PHP', 'soda-elementor-addons') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function register_widgets($widgets_manager) {
        // Auto-load all widgets from the widgets directory
        $widgets_dir = __DIR__ . '/widgets/';
        
        if (is_dir($widgets_dir)) {
            $widget_files = glob($widgets_dir . '*.php');
            
            foreach ($widget_files as $widget_file) {
                require_once($widget_file);
                
                $filename = basename($widget_file, '.php');
                
                // Handle menu-toggle-widget-v2.php (legacy naming without namespace)
                if ($filename === 'menu-toggle-widget-v2') {
                    if (class_exists('Elementor_Menu_Toggle_Widget_V2')) {
                        $widgets_manager->register(new \Elementor_Menu_Toggle_Widget_V2());
                    }
                    continue;
                }
                
                // All other widgets use SodaAddons\Widgets namespace
                $class_name = 'SodaAddons\Widgets\\' . $filename;
                
                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            }
        }
    }

    public function widget_styles() {
        // Menu widget style
        wp_enqueue_style(
            'elementor-menu-widget-v2',
            plugins_url('assets/css/menu-widget-v2.css', __FILE__),
            [],
            self::VERSION
        );

        // CubePortfolio
        wp_register_style(
            'cubeportfolio-css',
            plugins_url('assets/css/cubeportfolio.min.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'frontend-widgets',
            plugins_url('assets/css/frontend-widgets.min.css', __FILE__),
            [],
            self::VERSION
        );

        // Widget-specific styles
        wp_register_style(
            'soda-moving-gallery',
            plugins_url('assets/css/moving-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-pinned-gallery',
            plugins_url('assets/css/pinned-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-zoom-gallery',
            plugins_url('assets/css/zoom-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-horizontal-gallery',
            plugins_url('assets/css/horizontal-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-portfolio-grid',
            plugins_url('assets/css/portfolio-grid.css', __FILE__),
            [],
            self::VERSION
        );
    }

    public function widget_scripts() {
        // Menu widget script
        wp_register_script(
            'elementor-menu-widget-v2',
            plugins_url('assets/js/menu-widget-v2.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        // GSAP and plugins
        wp_register_script(
            'soda-gsap',
            plugins_url('assets/js/gsap.min.js', __FILE__),
            [],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-scrollTrigger',
            plugins_url('assets/js/ScrollTrigger.min.js', __FILE__),
            ['soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-flip',
            plugins_url('assets/js/Flip.min.js', __FILE__),
            ['soda-gsap'],
            self::VERSION,
            true
        );

        // Isotope and related
        wp_register_script(
            'imagesloaded',
            plugins_url('assets/js/imagesloaded.pkgd.min.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        wp_register_script(
            'isotope',
            plugins_url('assets/js/isotope.pkgd.min.js', __FILE__),
            ['jquery', 'imagesloaded'],
            self::VERSION,
            true
        );

        wp_register_script(
            'packery-mode',
            plugins_url('assets/js/packery-mode.pkgd.min.js', __FILE__),
            ['isotope'],
            self::VERSION,
            true
        );

        // CubePortfolio
        wp_register_script(
            'cubeportfolio-js',
            plugins_url('assets/js/jquery.cubeportfolio.min.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        // Widget-specific scripts
        wp_register_script(
            'soda-moving-gallery',
            plugins_url('assets/js/moving-gallery.js', __FILE__),
            ['jquery', 'soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-pinned-gallery',
            plugins_url('assets/js/pinned-gallery.js', __FILE__),
            ['jquery', 'soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-zoom-gallery',
            plugins_url('assets/js/zoom-gallery.js', __FILE__),
            ['jquery', 'soda-gsap', 'soda-flip'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-horizontal-gallery',
            plugins_url('assets/js/horizontal-gallery.js', __FILE__),
            ['jquery', 'soda-gsap', 'soda-scrollTrigger'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-lottie-widget',
            plugins_url('assets/js/lottie-player.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-portfolio-grid',
            plugins_url('assets/js/portfolio-grid.js', __FILE__),
            ['jquery', 'isotope'],
            self::VERSION,
            true
        );

        wp_register_script(
            'isotope-grid',
            plugins_url('assets/js/isotope-grid.js', __FILE__),
            ['jquery', 'isotope'],
            self::VERSION,
            true
        );
    }
}

Elementor_Menu_Widget_V2::instance();
