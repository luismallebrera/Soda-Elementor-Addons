<?php
/**
 * Parallax Background Module
 * Adds parallax effect to Elementor section backgrounds
 */

if (!defined('ABSPATH')) {
    exit;
}

class Soda_Parallax_Background {

    public function __construct() {
        // Para secciones normales
        add_action('elementor/element/section/section_background/before_section_end', [$this, 'add_parallax_controls'], 10, 2);
        
        // Para containers (Elementor 3.16+)
        add_action('elementor/element/container/section_background/before_section_end', [$this, 'add_parallax_controls'], 10, 2);
        
        // Para widgets individuales
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'add_widget_parallax_controls'], 10, 2);
        
        if (!is_admin()) {
            add_action('wp_head', [$this, 'parallax_script']);
        }
    }

    public function add_parallax_controls($element, $args) {
        $element->add_control(
            'soda_parallax',
            [
                'label' => esc_html__('Parallax Background', 'elementor-menu-widget-v2'),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => '',
                'prefix_class' => 'soda_parallax-',
                'separator' => 'before',
            ]
        );
    }

    public function add_widget_parallax_controls($element, $args) {
        $element->start_controls_section(
            'soda_parallax_section',
            [
                'label' => esc_html__('Parallax Effect', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'soda_enable_parallax',
            [
                'label' => esc_html__('Enable Parallax', 'elementor-menu-widget-v2'),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $element->add_control(
            'soda_parallax_speed',
            [
                'label' => esc_html__('Parallax Speed (Y)', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'size' => -50,
                ],
                'condition' => [
                    'soda_enable_parallax' => 'yes',
                ],
            ]
        );

        $element->end_controls_section();

        // Add render attributes
        add_action('elementor/frontend/widget/before_render', function($widget) {
            $settings = $widget->get_settings_for_display();
            
            if (isset($settings['soda_enable_parallax']) && $settings['soda_enable_parallax'] === 'yes') {
                $speed = isset($settings['soda_parallax_speed']['size']) ? $settings['soda_parallax_speed']['size'] : -50;
                $widget->add_render_attribute('_wrapper', 'data-jarallax-element', $speed . ' 0');
            }
        });
    }

    public function parallax_script() {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax-element.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Parallax para backgrounds
                const parallaxBackgrounds = document.querySelectorAll('.soda_parallax-yes');
                
                if (parallaxBackgrounds.length > 0) {
                    jarallax(parallaxBackgrounds, {
                        speed: 0.65,
                        type: 'scroll'
                    });
                }

                // Parallax para elementos (widgets dentro de secciones parallax)
                const parallaxElements = document.querySelectorAll('.soda_parallax-yes [data-jarallax-element]');
                
                if (parallaxElements.length > 0) {
                    jarallaxElement();
                }
            });
        </script>
        <?php
    }
}

// Initialize the module
new Soda_Parallax_Background();
