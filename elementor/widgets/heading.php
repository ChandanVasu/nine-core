<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register the custom Elementor widget
class Block_Heading_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'block_heading';
    }

    // Widget Title
    public function get_title() {
        return __( 'Block Heading', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-t-letter';
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
            'heading_text',
            [
                'label' => __( 'Heading Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Block Heading', 'nine-core' ),
            ]
        );

        $this->add_control(
            'view_all_text',
            [
                'label' => __( 'View All Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'nine-core' ),
            ]
        );

        $this->add_control(
            'view_all_url',
            [
                'label' => __( 'View All URL', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'nine-core' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'heading_style_section',
            [
                'label' => __( 'Heading Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_text_color',
            [
                'label' => __( 'Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-heading h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_background_color',
            [
                'label' => __( 'Background Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-heading h4' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .block-heading h4',
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' => esc_html__('Padding', 'nine-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .block-heading h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_border_radius',
            [
                'label'     => esc_html__(' Radius', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .block-heading h4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'view_all_style_section',
            [
                'label' => __( 'View All Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'view_all_text_color',
            [
                'label' => __( 'View All Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-heading .view-all' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'view_all_typography',
                'label' => __( 'View All Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .block-heading .view-all',
            ]
        );

        $this->end_controls_section();
    }

    // Widget Render
    protected function render() {
        $settings = $this->get_settings_for_display();
        $heading_text = $settings['heading_text'];
        $view_all_text = $settings['view_all_text'];
        $view_all_url = $settings['view_all_url']['url'];

        echo '<div class="block-heading">';
        echo '<h4>' . esc_html( $heading_text ) . '</h4>';
        if ( $view_all_text ) {
            echo '<a class="view-all" href="' . esc_url( $view_all_url ) . '">' . esc_html( $view_all_text ) . '</a>';
        }
        echo '</div>';
    }
}
