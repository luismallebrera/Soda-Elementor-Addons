<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Elementor_Soda_Moving_Gallery_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'soda_moving_gallery';
    }

    public function get_title() {
        return __( 'Moving Gallery', 'soda-moving-gallery' );
    }

    public function get_icon() {
        return 'eicon-exchange';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'soda-moving-gallery' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label'   => __( 'Add Images To Gallery', 'soda-moving-gallery' ),
                'type'    => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'   => __( 'Direction', 'soda-moving-gallery' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'fw-gallery',
                'options' => [
                    'fw-gallery' => __( 'Forward', 'soda-moving-gallery' ),
                    'bw-gallery' => __( 'Backward', 'soda-moving-gallery' ),
                ],
            ]
        );

        $this->add_control(
            'randomize',
            [
                'label'        => __( 'Randomize gallery images size?', 'soda-moving-gallery' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'soda-moving-gallery' ),
                'label_off'    => __( 'No', 'soda-moving-gallery' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<div class="moving-gallery ' . esc_attr( $settings['direction'] );
        if( $settings['randomize'] === 'yes' ){
            echo ' random-sizes';
        }
        echo '">';
        echo '<ul class="wrapper-gallery">';
        if ( !empty( $settings['gallery'] ) ) {
            foreach ( $settings['gallery'] as $image ) {
                $image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );
                echo '<li>';
                echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '" />';
                echo '</li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
}