<?php

/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register the custom Elementor widget
class Copyright_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'copyright';
    }

    // Widget Title
    public function get_title() {
        return __( 'Copyright', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-info';
    }

    // Widget Category
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    // Widget Controls
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'copyright_text',
            [
                'label' => __( 'Copyright Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Copyright © 2024 Vasu Theme | Powered by WordPress.', 'nine-core' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .copyright-widget' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .copyright-widget',
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __( 'Alignment', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'nine-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'nine-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'nine-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .copyright-widget' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Widget Render
    protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<div class="copyright-widget">' . esc_html( $settings['copyright_text'] ) . '</div>';
    }

    // Widget Render for Editor
    protected function _content_template() {
        ?>
        <# var settings = settings; #>
        <div class="copyright-widget">{{{ settings.copyright_text }}}</div>
        <?php
    }
}
