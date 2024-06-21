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
        return __( 'Single Post Meta', 'nine-core' );
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

        $this->add_control(
            'display_author',
            [
                'label' => __( 'Display Author', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'nine-core' ),
                'label_off' => __( 'Hide', 'nine-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_author_avatar',
            [
                'label' => __( 'Display Author Avatar', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'nine-core' ),
                'label_off' => __( 'Hide', 'nine-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'display_author' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'display_date',
            [
                'label' => __( 'Display Date', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'nine-core' ),
                'label_off' => __( 'Hide', 'nine-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_categories',
            [
                'label' => __( 'Display Categories', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'nine-core' ),
                'label_off' => __( 'Hide', 'nine-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_tags',
            [
                'label' => __( 'Display Tags', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'nine-core' ),
                'label_off' => __( 'Hide', 'nine-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'before_author_text',
            [
                'label' => __( 'Before Author Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'before_categories_text',
            [
                'label' => __( 'Before Categories Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'before_date_text',
            [
                'label' => __( 'Before Date Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'before_tags_text',
            [
                'label' => __( 'Before Tags Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'before_author_text',
            [
                'label' => __( 'Before Author Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'before_author_text_color',
            [
                'label' => __( 'Before Author Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .before-author-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'before_author_typography',
                'label' => __( 'Before Author Text Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .single-post-meta .before-author-text',
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'before_author_text_color',
            [
                'label' => __( 'Before Author Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .before_categories_text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'before_author_typography',
                'label' => __( 'Before Author Text Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .single-post-meta .before_date_text',
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'before_author_typography',
                'label' => __( 'Before Author Text Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .single-post-meta .before_date_text',
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'before_author_text_color',
            [
                'label' => __( 'Before Author Text Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .before_tags_text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'before_author_text!' => '',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'before_author_typography',
                'label' => __( 'Before Author Text Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .single-post-meta .before_tags_text',
                'condition' => [
                    'before_author_text!' => '',
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
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .single-post-meta',
            ]
        );


        $this->add_control(
            'meta_bg_color',
            [
                'label' => __( 'Background Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .single-post-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .single-post-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .post-author img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_author_avatar' => 'yes',
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
                    '{{WRAPPER}} .post-author img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_author_avatar' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'author_name_color',
            [
                'label' => __( 'Author Name Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .post-author .author-name' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_author' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __( 'Date Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .post-date' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'categories_color',
            [
                'label' => __( 'Categories Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .post-categories a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_categories' => 'yes',
                ],
            ]
        );
        

        $this->add_control(
            'tags_color',
            [
                'label' => __( 'Tags Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-post-meta .post-tags a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_tags' => 'yes',
                ],
            ]
        );
        

        $this->end_controls_section();

        $this->start_controls_section(
            'author_typography',
            [
                'label' => __( 'Author Name Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_author' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'author_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .post-author .author-name',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'date_typography',
            [
                'label' => __( 'Date Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_date' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .post-date',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'categories_typography',
            [
                'label' => __( 'Categories Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_categories' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'categories_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .post-categories',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tags_typography',
            [
                'label' => __( 'Tags Typography', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_tags' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .post-tags',
            ]
        );

        $this->end_controls_section();
    }


    protected function render() {
        global $post;
    
        $settings = $this->get_settings_for_display();
    
        $meta_data = [
            'author' => $settings['display_author'],
            'author_avatar' => $settings['display_author_avatar'],
            'date' => $settings['display_date'],
            'categories' => $settings['display_categories'],
            'tags' => $settings['display_tags'],
        ];
    
        echo '<div class="single-post-meta">';
    
        // Display author information if enabled
        if ($meta_data['author'] === 'yes') {
            $author_id = get_the_author_meta('ID');
            $author_name = get_the_author_meta('display_name', $author_id);
            
            echo '<div class="post-author">';
            
            // Display author avatar if enabled
            if ($meta_data['author_avatar'] === 'yes') {
                echo get_avatar($author_id, $settings['avatar_size']['size'], '', '', [
                    'class' => 'author-avatar',
                ]);
            }
            
            // Display before author text if provided
            if (!empty($settings['before_author_text'])) {
                echo '<span class="before-author-text" style="';
                if (!empty($settings['before_author_text_color'])) {
                    echo 'color: ' . $settings['before_author_text_color'] . ';';
                }
                echo '">';
                echo esc_html($settings['before_author_text']) . ' ';
                echo '</span>';
            }
            
            // Display author name
            echo '<span class="author-name">' . esc_html($author_name) . '</span>';
            echo '</div>'; // Closing div for post-author
        }
    
        // Display post date if enabled
        if ($meta_data['date'] === 'yes') {
            $post_date = get_the_date('F j, Y');
            
            echo '<div class="post-date">';
            
            // Display before date text if provided
            if (!empty($settings['before_date_text'])) {
                echo '<span class="before-date-text" style="';
                if (!empty($settings['before_date_text_color'])) {
                    echo 'color: ' . $settings['before_date_text_color'] . ';';
                }
                echo '">';
                echo esc_html($settings['before_date_text']) . ' ';
                echo '</span>';
            }
            
            // Display post date
            echo esc_html($post_date) . '</div>'; // Closing div for post-date
        }
    
        // Display categories if enabled
        if ($meta_data['categories'] === 'yes') {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                // Display demo categories in Elementor editor
                echo '<div class="post-categories">';
                if (!empty($settings['before_categories_text'])) {
                    echo '<span class="before-categories-text" style="';
                    if (!empty($settings['before_categories_text_color'])) {
                        echo 'color: ' . $settings['before_categories_text_color'] . ';';
                    }
                    echo '">';
                    echo esc_html($settings['before_categories_text']) . ' ';
                    echo '</span>';
                }
                echo '<a>Category 1, Category 2</a></div>';
            } else {
                // Display actual categories on live site
                $categories = get_the_category_list(', ');
                if ($categories) {
                    echo '<div class="post-categories">';
                    if (!empty($settings['before_categories_text'])) {
                        echo '<span class="before-categories-text" style="';
                        if (!empty($settings['before_categories_text_color'])) {
                            echo 'color: ' . $settings['before_categories_text_color'] . ';';
                        }
                        echo '">';
                        echo esc_html($settings['before_categories_text']) . ' ';
                        echo '</span>';
                    }
                    echo $categories . '</div>';
                }
            }
        }
    
        // Display tags if enabled
        if ($meta_data['tags'] === 'yes') {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                // Display demo tags in Elementor editor
                echo '<div class="post-tags">';
                if (!empty($settings['before_tags_text'])) {
                    echo '<span class="before-tags-text" style="';
                    if (!empty($settings['before_tags_text_color'])) {
                        echo 'color: ' . $settings['before_tags_text_color'] . ';';
                    }
                    echo '">';
                    echo esc_html($settings['before_tags_text']) . ' ';
                    echo '</span>';
                }
                echo '<a>Tag 1, Tag 2, Tag 3</a></div>';
            } else {
                // Display actual tags on live site
                $tags = get_the_tag_list('', ', ');
                if ($tags) {
                    echo '<div class="post-tags">';
                    if (!empty($settings['before_tags_text'])) {
                        echo '<span class="before-tags-text" style="';
                        if (!empty($settings['before_tags_text_color'])) {
                            echo 'color: ' . $settings['before_tags_text_color'] . ';';
                        }
                        echo '">';
                        echo esc_html($settings['before_tags_text']) . ' ';
                        echo '</span>';
                    }
                    echo $tags . '</div>';
                }
            }
        }
    
        echo '</div>'; // Closing div for single-post-meta
    }
    
    
}    
