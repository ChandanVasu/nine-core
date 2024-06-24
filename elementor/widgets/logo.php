<?php
/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * Widget Name: Site Logo
 */
class Site_Logo extends Widget_Base {

    public function get_name() {
        return 'site_logo';
    }

    public function get_title() {
        return __( 'Site Logo', 'nine-core' );
    }

    public function get_icon() {
        return 'eicon-logo'; // Change 'eicon-logo' to your desired icon class
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'logo_image',
            [
                'label' => __( 'Choose Logo Image', 'nine-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_url',
            [
                'label' => __( 'Logo Link URL', 'nine-core' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://example.com', 'nine-core' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                ],
                'description' => __( 'Enter the URL where clicking the logo will navigate.', 'nine-core' ),
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Image Width', 'nine-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Image Height', 'nine-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-logo img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $logo_image_url = $settings['logo_image']['url'];
        $logo_link_url = $settings['logo_url']['url'];

        if ( has_custom_logo() && empty( $logo_image_url ) ) {
            the_custom_logo();
        } else {
            if ( ! empty( $logo_image_url ) ) {
                echo '<a class="site-logo" href="' . esc_url( $logo_link_url ) . '">';
                echo '<img src="' . esc_url( $logo_image_url ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '">';
                echo '</a>';
            } else {
                echo '<h1 class="nine-menu-text-logo logo-text">';
                echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
                bloginfo( 'name' );
                echo '</a>';
                echo '</h1>';
            }
        }
    }

}

// Register widget
