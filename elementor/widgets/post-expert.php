<?php
/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */
class Elementor_Custom_Excerpt_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'elementor_custom_excerpt_widget';
    }

    public function get_title() {
        return esc_html__('Custom Excerpt', 'nine-core');
    }

    public function get_icon() {
        return 'eicon-text';
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    public function get_keywords() {
        return [ 'custom', 'excerpt', 'post' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'nine-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length (Words)', 'nine-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 10,
                'max' => 50,
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'nine-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-excerpt .post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'nine-core'),
                'selector' => '{{WRAPPER}} .custom-excerpt .post-excerpt',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        echo '<div class="custom-excerpt">';
        
        // Check if post has a manual excerpt set
        if (has_excerpt()) {
            echo '<div class="post-excerpt">' . get_the_excerpt() . '</div>';
        } else {
            // Fallback to content if no manual excerpt is set
            echo '<div class="post-excerpt">' . wp_trim_words(get_the_content(), $settings['excerpt_length']) . '</div>';
        }
        
        echo '</div>';
    }
}

