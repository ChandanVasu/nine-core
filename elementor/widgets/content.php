<?php

/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */

 
// Register the custom Elementor widget
class single_post_content extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'single_post_content';
    }

    // Widget Title
    public function get_title() {
        return __( 'Post Content', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-post-content';
    }

    // Widget Category
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    // Render Widget Output
    protected function render() {
        global $post;

        // Check if it's a single post
        if ( is_singular( 'post' ) ) {
            setup_postdata( $post );
            echo '<div class="el-single-post-content-nine">' . the_content() . '</div>';
            wp_reset_postdata();
        } else {
            echo '
                <h1>Main Title: Welcome to Our Blog</h1>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections .Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections .</p>


                <h2>Subheading: Conclusion</h2>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections.</p>

                <h3>Sub-subheading: Final Thoughts</h3>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections .</p>

                <h4>Smaller Subheading: Future Outlook</h4>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections .</p>

                <h5>Even Smaller Subheading: Additional Resources</h5>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections.</p>
            ';
        }
    }

    // Register Widget Controls
    protected function _register_controls() {

        // Typography Style Section
        $this->start_controls_section(
            'typography_style_section',
            [
                'label' => __( 'Typography Style', 'nine-core' ),
            ]
        );

        // Title Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Heading Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} h1',
            ]
        );

        // Heading 2 Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'h2_typography',
                'label'    => __( 'Heading 2 Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} h2',
            ]
        );

        // Heading 3 Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'h3_typography',
                'label'    => __( 'Heading 3 Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} h3',
            ]
        );

        // Heading 4 Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'h4_typography',
                'label'    => __( 'Heading 4 Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} h4',
            ]
        );

        // Heading 5 Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'h5_typography',
                'label'    => __( 'Heading 5 Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} h5',
            ]
        );

        // Paragraph Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'paragraph_typography',
                'label'    => __( 'Paragraph Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} p',
            ]
        );

        // Link Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'link_typography',
                'label'    => __( 'Link Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} a',
            ]
        );

        $this->end_controls_section();

        // Content Style Section
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __( 'Content Style', 'nine-core' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Heading Color Controls
        $this->add_responsive_control(
            'heading_color_h1',
            [
                'label'     => __( 'H1 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h1' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_color_h2',
            [
                'label'     => __( 'H2 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_color_h3',
            [
                'label'     => __( 'H3 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_color_h4',
            [
                'label'     => __( 'H4 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h4' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_color_h5',
            [
                'label'     => __( 'H5 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h5' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_color_h6',
            [
                'label'     => __( 'H6 Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Paragraph Color Control
        $this->add_responsive_control(
            'paragraph_color',
            [
                'label'     => __( 'Paragraph Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} p' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Link Color Control
        $this->add_responsive_control(
            'link_color',
            [
                'label'     => __( 'Link Color', 'nine-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Margin Style Section
        $this->start_controls_section(
            'margin_style_section',
            [
                'label' => __( 'Margin Style', 'nine-core' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Heading Margin Controls
        $this->add_responsive_control(
            'h1_margin',
            [
                'label' => __( 'Heading 1 Margin', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} h1' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'h2_margin',
            [
                'label' => __( 'Heading 2 Margin', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} h2' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'h3_margin',
            [
                'label' => __( 'Heading 3 Margin', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} h3' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        // Paragraph Margin Control
        $this->add_responsive_control(
            'paragraph_margin',
            [
                'label' => __( 'Paragraph Margin', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} p' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style Section
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __( 'Image Style', 'nine-core' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Image Margin Control
        $this->add_responsive_control(
            'image_margin',
            [
                'label' => __( 'Image Margin', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} img' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        // Image Width Control
        $this->add_responsive_control(
            'image_width',
            [
                'label' => __( 'Image Width', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'separator' => 'before',
            ]
        );

        // Image Height Control
        $this->add_responsive_control(
            'image_height',
            [
                'label' => __( 'Image Height', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'separator' => 'before',
            ]
        );

        // Image Border Radius Control
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __( 'Image Border Radius', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

}
?>
