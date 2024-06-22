<?php

namespace nineElementor\Widgets;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Plugin;

/**
 * Class Single_Featured_Image
 *
 * @package nineElementor\Widgets
 */
class Single_Featured_Image extends Widget_Base {

    public function get_name() {
        return 'nine-single-featured-image';
    }

    public function get_title() {
        return esc_html__('Featured Image', 'nine-core');
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_keywords() {
        return ['single', 'template', 'builder', 'image', 'featured image', 'thumbnail'];
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Image', 'nine-core'),
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'nine-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-thum img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'nine-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 450,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-thum img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'nine-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .el-thum img, .plyr--video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'nine-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .el-thum img, .plyr--video' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nine-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-thum img, .plyr--video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__('Border', 'nine-core'),
                'selector' => '{{WRAPPER}} .el-thum img, .plyr--video',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'label' => esc_html__('Box Shadow', 'nine-core'),
                'selector' => '{{WRAPPER}} .el-thum img, .plyr--video',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        echo '<div class="el-thum">';
        if (Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="post-format-image-thumbnail">';
            echo '<img src="' . esc_url(get_template_directory_uri() . '/Assets/images/preview.png') . '" alt="' . esc_attr__('Placeholder Image', 'nine-core') . '">';
            echo '</div>';
        } else {
            if (function_exists('display_post_thumbnail')) {
                display_post_thumbnail();
            }
        }
        echo '</div>';
    }
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type(new Single_Featured_Image());
