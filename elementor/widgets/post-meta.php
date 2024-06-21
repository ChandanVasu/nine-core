<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register the custom Elementor widget
class Single_Post_Meta_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'single_post_meta';
    }

    // Widget Title
    public function get_title() {
        return __( 'POST META', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-post-info';
    }

    // Widget Categories
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


        $this->add_responsive_control(
            'el-post-author',
            [
                'label' => esc_html__( 'Author Image', 'nine-core' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'nine-core' ),
                'label_off' => esc_html__( 'Off', 'nine-core' ),
                'return_value'	=> 'none',
                'default'	=> 'block',
                'selectors' => [
                    '{{WRAPPER}} .el-post-author' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'el-author-name',
            [
                'label' => esc_html__( 'Author Name', 'nine-core' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'nine-core' ),
                'label_off' => esc_html__( 'Off', 'nine-core' ),
                'return_value'	=> 'none',
                'default'	=> 'block',
                'selectors' => [
                    '{{WRAPPER}} .el-author-name' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'el-post-date',
            [
                'label' => esc_html__( 'Date', 'nine-core' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'nine-core' ),
                'label_off' => esc_html__( 'Off', 'nine-core' ),
                'return_value'	=> 'none',
                'default'	=> 'block',
                'selectors' => [
                    '{{WRAPPER}} .el-post-date' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'el-post-categories',
            [
                'label' => esc_html__( 'Category', 'nine-core' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'nine-core' ),
                'label_off' => esc_html__( 'Off', 'nine-core' ),
                'return_value'	=> 'none',
                'default'	=> 'block',
                'selectors' => [
                    '{{WRAPPER}} .el-post-categories' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'el-post-tags',
            [
                'label' => esc_html__( 'Tag', 'nine-core' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'nine-core' ),
                'label_off' => esc_html__( 'Off', 'nine-core' ),
                'return_value'	=> 'none',
                'default'	=> 'block',
                'selectors' => [
                    '{{WRAPPER}} .el-post-tags' => 'display: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'label' => __( 'Meta Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-post-meta',
            ]
        );

        $this->add_control(
            'meta_bg_color',
            [
                'label' => __( 'Background Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-post-meta' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_padding',
            [
                'label' => __( 'Padding', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-post-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'meta_border_radius',
            [
                'label' => __( 'Border Radius', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .el-post-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'avatar_size',
            [
                'label' => __( 'Author Avatar Size', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 128,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-post-author img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'avatar_border_radius',
            [
                'label' => __( 'Author Avatar Border Radius', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-post-author img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_name_color',
            [
                'label' => __( 'Author Name Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-author-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __( 'Date Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-post-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'categories_color',
            [
                'label' => __( 'Categories Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-post-categories a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tags_color',
            [
                'label' => __( 'Tags Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-post-tags a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'author_typography',
            [
                'label' => __( 'Author Name Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'author_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-author-name',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'date_typography',
            [
                'label' => __( 'Date Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-post-date',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'categories_typography',
            [
                'label' => __( 'Categories Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'categories_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-post-categories a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tags_typography',
            [
                'label' => __( 'Tags Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-post-tags a',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $is_editor_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
    
        ?>
        <div class="el-post-meta">
            <div class="el-post-author">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
               
            </div>
            
            <div class="el-author-name"><?php the_author_posts_link(); ?></div>
    
            <div class="el-post-date">
                <span><?php echo get_the_date(); ?></span>
            </div>
    
            <div class="el-post-categories">
                <?php if ( $is_editor_mode ) : ?>
                    <a href="#">Category 1</a>, <a href="#">Category 2</a>
                <?php else : ?>
                    <?php the_category( ', ' ); ?>
                <?php endif; ?>
            </div>
    
            <div class="el-post-tags">
                <?php if ( $is_editor_mode ) : ?>
                    <a href="#">Tag 1</a>, <a href="#">Tag 2</a>
                <?php else : ?>
                    <?php the_tags( '', ', ', '' ); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    
}


