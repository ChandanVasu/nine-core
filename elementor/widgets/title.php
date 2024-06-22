<?php

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;

/**
 * Class Single_Title
 *
 */
class Single_Title extends Widget_Base {

    public function get_name() {
        return 'Single_Title';
    }

    public function get_title() {
        return esc_html__('Post Title', 'nine-core');
    }

    public function get_icon() {
        return 'eicon-post-title';
    }

    public function get_keywords() {
        return ['single', 'template', 'builder', 'title', 'subtitle', 'tagline'];
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'style_section', [
                'label' => esc_html__('Style', 'nine-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'description' => esc_html__('Set the color of post titles.', 'nine-core'),
                'selectors' => [
                    '{{WRAPPER}} .single-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'title_align',
            [
                'label'     => esc_html__('Alignment', 'nine-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => esc_html__('Left', 'nine-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'nine-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'nine-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'nine-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_font',
                'label'    => esc_html__('Title Font', 'nine-core'),
                'selector' => '{{WRAPPER}} .single-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_shadow',
                'label'    => esc_html__('Text Shadow', 'nine-core'),
                'selector' => '{{WRAPPER}} .single-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (Plugin::$instance->editor->is_edit_mode()) {
            echo '<h1 class="single-title">' . esc_html__('Dynamic post title will be replaced with the real title after you assign this template', 'nine-core') . '</h1>';
        } else {
            if (function_exists('nine_single_title')) {
                nine_single_title();
            }
        }
    }
}


if ( ! function_exists( 'nine_single_title' ) ) {
    /**
     * Display the title of the current post.
     */
    function nine_single_title() {
        if ( is_singular() ) {
            echo '<h1 class="single-title">' . esc_html( get_the_title() ) . '</h1>';
        } else {
            echo '<h2 class="single-title">' . esc_html( get_the_title() ) . '</h2>';
        }
    }
}
