<?php

use Elementor\Plugin;

// Ensure Elementor is loaded.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Archive_Post_Title_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'archive-post-title';
    }

    public function get_title() {
        return __( 'Archive Post Title', 'your-text-domain' );
    }

    public function get_icon() {
        return 'eicon-archive-title';
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'style_section', [
                'label' => esc_html__('Style', 'nine-core'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'description' => esc_html__('Set the color of post titles.', 'nine-core'),
                'selectors' => [
                    '{{WRAPPER}} .el-archive-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_align',
            [
                'label'     => esc_html__('Alignment', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
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
                    '{{WRAPPER}} .el-archive-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Title Typography', 'nine-core'),
                'selector' => '{{WRAPPER}} .el-archive-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_shadow',
                'label'    => esc_html__('Text Shadow', 'nine-core'),
                'selector' => '{{WRAPPER}} .el-archive-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = '';

        if (Plugin::$instance->editor->is_edit_mode()) {
            echo '<h4 class="el-archive-title">' . esc_html__('Archive: Demo Title') . '</h4>';
        } else {
            if ( is_category() ) {
                $title = sprintf( __( 'Category: %s', 'your-text-domain' ), single_cat_title( '', false ) );
            } elseif ( is_tag() ) {
                $title = sprintf( __( 'Tag: %s', 'your-text-domain' ), single_tag_title( '', false ) );
            } elseif ( is_author() ) {
                the_post();
                $title = sprintf( __( 'Author: %s', 'your-text-domain' ), get_the_author() );
                rewind_posts();
            } elseif ( is_day() ) {
                $title = sprintf( __( 'Daily Archives: %s', 'your-text-domain' ), get_the_date() );
            } elseif ( is_month() ) {
                $title = sprintf( __( 'Monthly Archives: %s', 'your-text-domain' ), get_the_date( 'F Y' ) );
            } elseif ( is_year() ) {
                $title = sprintf( __( 'Yearly Archives: %s', 'your-text-domain' ), get_the_date( 'Y' ) );
            } elseif ( is_search() ) {
                $title = sprintf( __( 'Search Results for: %s', 'your-text-domain' ), get_search_query() );
            } elseif ( is_home() ) {
                $title = __( 'Latest Posts', 'your-text-domain' );
            } else {
                $title = __( 'Archives:', 'your-text-domain' );
            }
    
            echo '<h4 class="el-archive-title">' . esc_html( $title ) . '</h4>';
        }


    }
}
