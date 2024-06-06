<?php

class Grid_Post_1 extends \Elementor\Widget_Base {
    
    public function get_name()
    {
        return 'Grid_Post_1';
    }

    public function get_title()
    {
        return __('Grid Style 1 - Papers', 'nine-core');
    }

    public function get_icon() {
          return 'eicon-post-list';
    }
    

    public function get_categories()
    {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function render() {
        $settings = $this->get_settings();
    
        // Check if dynamic filtering is enabled
        if ($settings['dynamic_filtering'] === 'yes') {
            // Get current query parameters
            $current_query = $GLOBALS['wp_query'];
            $query_args = $current_query->query;
    
            $categories = get_the_category();
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
    
            if (is_single()) {
                $query_args = array(
                    'post_type'    => 'post',
                    'category__in' => $category_ids,
                );
            }
    
            if (!isset($query_args['posts_per_page'])) {
                $query_args['posts_per_page'] = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 5;
            }
    
            if (!isset($query_args['offset'])) {
                $query_args['offset'] = isset($settings['offset']) ? $settings['offset'] : 0;
            }
    
            if (!isset($query_args['order'])) {
                $query_args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';
            }
    
            $query_args['post_type'] = 'post';
    
            $posts_query = new WP_Query($query_args);
        } else {
            $query_args = array(
                'post_type'      => 'post',
                'posts_per_page' => isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 5,
                'category__in'   => isset($settings['category']) ? $settings['category'] : array(),
                'offset'         => isset($settings['offset']) ? $settings['offset'] : 0,
                'order'          => isset($settings['order']) ? $settings['order'] : 'DESC',
            );
    
            $posts_query = new WP_Query($query_args);
        }
    
        // Display posts
        if ($posts_query->have_posts()) :
            ?>
            <div class="el-g-1-grid-container"> <!-- Modified class name -->
                <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                    <div class="el-g-1-box"> <!-- Modified class name -->
                        <div class="el-g-1-thumbnail"> <!-- Modified class name -->
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail(); ?>
                            </a>
                            <span class="el-g-1-category">
                                <?php the_category(', '); ?>
                            </span> <!-- Modified class name -->
                        </div>
    
                        <h2 class="el-g-1-title title"><a href="<?php the_permalink(); ?>">
                                <?php echo wp_trim_words(get_the_title(), $settings['title_length'], '...'); ?>
                            </a></h2> <!-- Modified class name -->
    
                        <div class="el-g-1-excerpt excerpt"> <!-- Modified class name -->
                            <?php echo wp_trim_words(get_the_content(), $settings['content_length'], '...'); ?>
                        </div>
                        <div class="el-g-1-meta-box"> <!-- Modified class name -->
                            <?php
                            $author_id = get_the_author_meta('ID');
                            $author_avatar = get_avatar_url($author_id, ['size' => 32]);
                            ?>
                            <img class="el-g-1-avatar author-avatar" src="<?php echo esc_url($author_avatar); ?>"
                                 alt="<?php echo esc_attr(get_the_author()); ?>"> <!-- Modified class name -->
                            <a class="el-g-1-name" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                <?php the_author(); ?>
                            </a>
                            <span class="el-g-1-date">
                                <?php echo get_the_date(); ?>
                            </span> <!-- Modified class name -->
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php
            wp_reset_postdata(); // Reset post data
        else :
            echo '<div class="el-g-1-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
        endif;
    }


protected function _register_controls(){
    $this->start_controls_section(
        'section_content',
        [
            'label' => __('Content', 'nine-core'),
        ]
    );

    $this->add_control(
        'dynamic_filtering',
        [
            'label' => __('Current Query', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'description' => __('Toggle to Archive Posts based on current query.', 'nine-core'),
            'default' => 'no',
        ]
    );

    // Only show category selection if dynamic filtering is disabled
    $this->add_control(
        'category',
        [
            'label' => __('Select Category', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'description' => __('Select the categories you want to display.', 'nine-core'),
            'options' => $this->get_all_categories_options(),
            'multiple' => true,
            'condition' => [
                'dynamic_filtering!' => 'yes',
            ],
        ]
    );

    $this->add_control(
        'posts_per_page',
        [
            'label'   => __('Posts Per Page', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => __('Set the number of posts to display per page.', 'nine-core'),
            'default' => 8, // Default number of posts to display
        ]
    );

    $this->add_control(
        'offset',
        [
            'label'   => __('Post Offset', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => __('Set the number of posts to offset.', 'nine-core'),
            'default' => 0, // Default offset value
        ]
    );

    $this->add_control(
        'title_length',
        [
            'label'   => __('Title Length', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => __('Set the maximum length of the title.', 'nine-core'),
            'default' => 10, // Default number of words to display in title
        ]
    );

    $this->add_control(
        'content_length',
        [
            'label'   => __('Content Length', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => __('Set the maximum length of the content.', 'nine-core'),
            'default' => 20, // Default number of words to display in content
        ]
    );

    $this->add_responsive_control(
        'items_per_row_desktop',
        [
            'label'     => __('Items Per Row ', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'description' => __('Set the number of items to display per row on desktop.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-grid-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]
    );

    $this->add_control(
        'text_align',
        [
            'label' => __('Text Align', 'nine-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'description' => __('Set the alignment of the text.', 'nine-core'),
            'options' => [
                'left' => [
                    'title' => __('Left', 'nine-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'nine-core'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'nine-core'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'Left',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'order',
        [
            'label' => __('Order', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'ASC' => __('Ascending', 'nine-core'),
                'DESC' => __('Descending', 'nine-core'),
            ],
            'default' => 'DESC', // Default ordering
        ]
    );




    $this->add_responsive_control(
	'show_image',
	[
		'label' => __( 'Show Image', 'nine-core' ),
        'type'    => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'On', 'nine-core' ),
		'label_off' => __( 'Off', 'nine-core' ),
        'description' => __('Toggle to display or hide post image.', 'nine-core'),
		'return_value'	=> 'none',
		'default'	=> 'block',
		'selectors' => [
			'{{WRAPPER}} .el-g-1-thumbnail' => 'display: {{VALUE}}',
		],
	]
    );

    $this->add_responsive_control(
        'show_post_meta',
        [
            'label' => __( 'Show Meta', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide post meta.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'flex',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-meta-box' => 'display: {{VALUE}}',
            ],
        ]
    );

    $this->add_responsive_control(
        'show_category',
        [
            'label' => __( 'Show Category', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide post categories.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-category' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_post_title',
        [
            'label' => __( 'Show Post Title', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide post title.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-title' => 'display: {{VALUE}}',
            ],
        ]
    );

    $this->add_responsive_control(
        'show_post_content',
        [
            'label' => __( 'Show Post Content', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide post content.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-excerpt' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_author_image',
        [
            'label' => __( 'Show Author Image', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide author image.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-g-1-avatar' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_date',
        [
            'label' => __( 'Show Post Date', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'nine-core' ),
            'label_off' => __( 'Off', 'nine-core' ),
            'description' => __('Toggle to display or hide post date.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-l-1-date-meta-vasutheme' => 'display: {{VALUE}}',
            ],
        ]
    );

$this->end_controls_section();



// Post Style Subsection
$this->start_controls_section(  
    'section_post_style',
    [
        'label' => __('Post Style', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_control(
        'image_border_radius',
        [
            'label'     => __('  Radius', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => __('Set border radius for post images.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'transform_hover',
        [
            'label' => __('Hover Transform', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'description' => __('Set the scale factor for post items on hover.', 'nine-core'),
            'size_units' => [''],
            'range' => [
                'px' => [
                    'min' => 0.5,
                    'max' => 2,
                    'step' => 0.01,
                ],
            ],
            'default' => [
                'unit' => '',
                'size' => 1.1,
            ],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-thumbnail img:hover' => 'transform: scale({{SIZE}});',
            ],
        ]
    );



    $this->add_responsive_control(
        'image_height',
        [
            'label' => esc_html__( 'Image Height', 'textdomain' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 5,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 150,
            ],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();

    // Title Style Section
    $this->start_controls_section(
        'section_title_style',
        [
            'label' => __('Title', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'title_color',
        [
            'label'     => __('Title Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of post titles.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-title a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'title_hover_text_decoration',
        [
            'label' => __('Title Text Decoration (Hover)', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'description' => __('Set the text decoration for post titles on hover.', 'nine-core'),
            'default' => 'none',
            'options' => [
                'none' => __('None', 'nine-core'),
                'underline' => __('Underline', 'nine-core'),
                'overline' => __('Overline', 'nine-core'),
                'line-through' => __('Line Through', 'nine-core'),
            ],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-title:hover ' => 'text-decoration: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'title_hover_text_color',
        [
            'label' => __('Title Text Color (Hover)', 'nine-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of post titles on hover.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-title:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'title_typography',
            'label'    => __('Title Typography', 'nine-core'),
            'description' => __('Set the typography for post titles.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-title a',
        ]
    );

$this->end_controls_section();

// Category Style Section
$this->start_controls_section(
    'section_category_style',
    [
        'label' => __('Category', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_control(
        'category_text_color',
        [
            'label'     => __('Category Text Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of post category text.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-category a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'category_bg_color',
        [
            'label'     => __('Category Background Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the background color of post category.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-category a' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'border_radius',
        [
            'label' => __('Border Radius', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => __('Set the border radius of post category.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'category_position',
        [
            'label' => __('Category Position', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => __('Set the position of post category.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-category a' => 'left: {{LEFT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'category_typography',
            'label'    => __('Category Typography', 'nine-core'),
            'description' => __('Set the typography for post category.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-category',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_author_style',
        [
            'label' => __('Author', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'author_color',
        [
            'label'     => __('Author Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of post author.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-meta-box a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'author_typography',
            'label'    => __('Author Typography', 'nine-core'),
            'description' => __('Set the typography for post author.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-meta-box a',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_date_style',
        [
            'label' => __('Date', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'date_typography',
            'label'    => __('Date Typography', 'nine-core'),
            'description' => __('Set the typography for post date.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-date',
        ]
    );

$this->end_controls_section();

// Content Style Section
$this->start_controls_section(
    'section_content_style',
    [
        'label' => __('Content', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_control(
        'content_color',
        [
            'label'     => __('Content Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of post content.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-excerpt' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'content_typography',
            'label'    => __('Content Typography', 'nine-core'),
            'description' => __('Set the typography for post content.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-excerpt',
        ]
    );

    $this->end_controls_section();

    // Container Style Section
    $this->start_controls_section(
        'section_container_style',
        [
            'label' => __('Container', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'border_color',
        [
            'label' => __('Border Color', 'nine-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the color of the container border.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'border_width',
        [
            'label' => __('Border Width', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => __('Set the width of the container border.', 'nine-core'),
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'border_style',
        [
            'label' => __('Border Style', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'description' => __('Set the style of the container border.', 'nine-core'),
            'default' => 'none',
            'options' => [
                'solid' => __('Solid', 'nine-core'),
                'dotted' => __('Dotted', 'nine-core'),
                'dashed' => __('Dashed', 'nine-core'),
                'double' => __('Double', 'nine-core'),
                'groove' => __('Groove', 'nine-core'),
                'ridge' => __('Ridge', 'nine-core'),
                'inset' => __('Inset', 'nine-core'),
                'outset' => __('Outset', 'nine-core'),
                'none' => __('None', 'nine-core'),
                'hidden' => __('Hidden', 'nine-core'),
            ],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'border-style: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'background_border_radius',
        [
            'label' => __('Background Border Radius', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => __('Set the border radius of the container background.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'background_color',
        [
            'label'     => __('Background Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => __('Set the background color of the container.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-g-1-box' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow',
            'description' => __('Add box shadow to the container.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-g-1-box',
        ]
    );

$this->end_controls_section();

    }
    private function get_all_categories_options()
    {
        $categories = get_categories();
        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }

    

    
}