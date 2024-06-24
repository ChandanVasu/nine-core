<?php
class Elementor_Breadcrumbs_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'Elementor_Breadcrumbs_Widget';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-mega-menu';
	}

	public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
	}

	public function get_keywords() {
		return [ 'Breadcrumbs', 'world' ];
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'home_label',
            [
                'label' => esc_html__( 'Home Label', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Home', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            'breadcrumbs_color',
            [
                'label' => esc_html__( 'Color', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .breadcrumbs a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .breadcrumbs .breadcrumb-delimiter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__( 'Typography', 'elementor-addon' ),
                'selector' => '{{WRAPPER}} .breadcrumbs, {{WRAPPER}} .breadcrumbs a, {{WRAPPER}} .breadcrumbs .breadcrumb-delimiter',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<div class="breadcrumbs">';
        echo '<a href="' . home_url() . '">' . esc_html($settings['home_label']) . '</a>';
        
        $delimiter_class = 'breadcrumb-delimiter'; // CSS class for the delimiter
        
        if (is_category() || is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<span class="' . $delimiter_class . '"> / </span>';
                $category_links = array_map(function($category) {
                    return '<a href="' . get_category_link($category->term_id) . '">' . esc_html($category->name) . '</a>';
                }, $categories);
                echo implode(' <span class="' . $delimiter_class . '"> / </span> ', $category_links);
            }
            if (is_single()) {
                echo '<span class="' . $delimiter_class . '"> / </span>';
                the_title();
            }
        } elseif (is_page()) {
            echo '<span class="' . $delimiter_class . '"> / </span>';
            the_title();
        }
        echo '</div>';
    }
}
