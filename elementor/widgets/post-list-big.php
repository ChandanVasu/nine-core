<?php
/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */
class post_list_big extends \Elementor\Widget_Base {
    
    public function get_name()
    {
        return 'post_list_big';
    }

    public function get_title()
    {
        return esc_html__('Big List Post', 'nine-core');
    }

    public function get_icon() {
          return 'eicon-post-list ne-icon';
    }
    

    public function get_categories()
    {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['uuid'] = 'uid_' . $this->get_id();
    
        if (function_exists('post_list_big')) {
            echo post_list_big($settings);
        }
    }
    

protected function _register_controls(){
    $this->start_controls_section(
        'section_content',
        [
            'label' => esc_html__('Content', 'nine-core'),
        ]
    );

    $this->add_responsive_control(
        'dynamic_filtering',
        [
            'label' => esc_html__('Current Query', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'description' => esc_html__('Toggle to Archive Posts based on current query.', 'nine-core'),
            'default' => 'no',
        ]
    );

    // Only show category selection if dynamic filtering is disabled
    $this->add_responsive_control(
        'category',
        [
            'label' => esc_html__('Select Category', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'description' => esc_html__('Select the categories you want to display.', 'nine-core'),
            'options' => $this->get_all_categories_options(),
            'multiple' => true,
            'condition' => [
                'dynamic_filtering!' => 'yes',
            ],
        ]
    );

    $this->add_responsive_control(
        'posts_per_page',
        [
            'label'   => esc_html__('Posts Per Page', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => esc_html__('Set the number of posts to display per page.', 'nine-core'),
            'default' => 9, 
        ]
    );

    $this->add_responsive_control(
        'offset',
        [
            'label'   => esc_html__('Post Offset', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => esc_html__('Set the number of posts to offset.', 'nine-core'),
            'default' => 0, // Default offset value
        ]
    );

    $this->add_responsive_control(
        'title_length',
        [
            'label'   => esc_html__('Title Length', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => esc_html__('Set the maximum length of the title.', 'nine-core'),
            'default' => 10, // Default number of words to display in title
        ]
    );

    $this->add_responsive_control(
        'content_length',
        [
            'label'   => esc_html__('Content Length', 'nine-core'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'description' => esc_html__('Set the maximum length of the content.', 'nine-core'),
            'default' => 10, // Default number of words to display in content
        ]
    );

$this->add_responsive_control(
    'items_per_row',
    [
        'label' => esc_html__('Items Per Row', 'nine-core'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'description' => esc_html__('Set the number of items to display per row.', 'nine-core'),
        'devices' => ['desktop', 'tablet', 'mobile'],
        'desktop_default' => 3,
        'tablet_default' => 2,
        'mobile_default' => 1,
        'selectors' => [
            '{{WRAPPER}} .el-list-big-list-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
        ],
    ]
);


    $this->add_responsive_control(
        'text_align',
        [
            'label' => esc_html__('Text Align', 'nine-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'description' => esc_html__('Set the alignment of the text.', 'nine-core'),
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'nine-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'nine-core'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'nine-core'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'Left',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'order',
        [
            'label' => esc_html__('Order', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'ASC' => esc_html__('Ascending', 'nine-core'),
                'DESC' => esc_html__('Descending', 'nine-core'),
            ],
            'default' => 'DESC', // Default ordering
        ]
    );




    $this->add_responsive_control(
	'show_image',
	[
		'label' => esc_html__( 'Show Image', 'nine-core' ),
        'type'    => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => esc_html__( 'On', 'nine-core' ),
		'label_off' => esc_html__( 'Off', 'nine-core' ),
        'description' => esc_html__('Toggle to display or hide post image.', 'nine-core'),
		'return_value'	=> 'none',
		'default'	=> 'block',
		'selectors' => [
			'{{WRAPPER}} .el-list-big-thumbnail' => 'display: {{VALUE}}',
		],
	]
    );

    $this->add_responsive_control(
        'show_post_meta',
        [
            'label' => esc_html__( 'Show Meta', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide post meta.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'flex',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-meta-box' => 'display: {{VALUE}}',
            ],
        ]
    );

    $this->add_responsive_control(
        'show_category',
        [
            'label' => esc_html__( 'Show Category', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide post categories.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'none',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-category' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_post_title',
        [
            'label' => esc_html__( 'Show Post Title', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide post title.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-title, .el-list-big-title' => 'display: {{VALUE}}',
            ],
        ]
    );

    $this->add_responsive_control(
        'show_post_content',
        [
            'label' => esc_html__( 'Show Post Content', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide post content.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'block',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-excerpt' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_author_image',
        [
            'label' => esc_html__( 'Show Author Image', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide author image.', 'nine-core'),
            'return_value'	=> 'none',
            'default'	=> 'none',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-avatar' => 'display: {{VALUE}}',
            ],
        ]
    );


    $this->add_responsive_control(
        'show_date',
        [
            'label' => esc_html__( 'Show Post Date', 'nine-core' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'nine-core' ),
            'label_off' => esc_html__( 'Off', 'nine-core' ),
            'description' => esc_html__('Toggle to display or hide post date.', 'nine-core'),
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
        'label' => esc_html__('Post Style', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_responsive_control(
        'image_border_radius',
        [
            'label'     => esc_html__('  Radius', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set border radius for post images.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'transform_hover',
        [
            'label' => esc_html__('Hover Transform', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'description' => esc_html__('Set the scale factor for post items on hover.', 'nine-core'),
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
                '{{WRAPPER}} .el-list-big-thumbnail img:hover' => 'transform: scale({{SIZE}});',
            ],
        ]
    );



    $this->add_responsive_control(
        'image_height',
        [
            'label' => esc_html__( 'Image Height', 'nine-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 5,
                        ],
                    ],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );



    $this->add_responsive_control(
        'image_width',
        [
            'label' => esc_html__( 'Image Width', 'nine-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 400,
                    'step' => 5,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'list_item_gap',
        [
            'label' => esc_html__( 'Content Gap', 'nine-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 5,
                        ],
                    ],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    
    $this->end_controls_section();

    // Title Style Section
    $this->start_controls_section(
        'section_title_style',
        [
            'label' => esc_html__('Title', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'title_color',
        [
            'label'     => esc_html__('Title Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of post titles.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-title a, .el-list-big-title' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'title_color_toggle',
        [
            'label' => esc_html__('Title Hover Line', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('On', 'nine-core'),
            'label_off' => esc_html__('Off', 'nine-core'),
            'default' => 'no',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-title a, .el-list-big-title' => 'background-size: {{VALUE}};',
            ],
            'return_value' => '0 100%',
        ]
    );

    $this->add_responsive_control(
        'title_hover_text_color',
        [
            'label' => esc_html__('Title Text Color (Hover)', 'nine-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of post titles on hover.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-title:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'title_typography',
            'label'    => esc_html__('Title Typography', 'nine-core'),
            'description' => esc_html__('Set the typography for post titles.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-title a, .el-list-big-title',
        ]
    );

$this->end_controls_section();

// Category Style Section
$this->start_controls_section(
    'section_category_style',
    [
        'label' => esc_html__('Category', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_responsive_control(
        'category_text_color',
        [
            'label'     => esc_html__('Category Text Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of post category text.', 'nine-core'),
            'default' => 'black',
            'selectors' => [
                '{{WRAPPER}} .el-list-big-category a' => 'color: {{VALUE}};',
            ],
        ]
    );


    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'category_bg_color',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .el-list-big-category a',
            'label' => esc_html__('Background', 'nine-core'),
            'exclude' => ['image'],
            'description' => esc_html__('Set the background color of post category.', ),
            'fields_options' => [
            'background' => [
                'label' => esc_html__('Category Background Color', 'nine-core'),
                'default' => 'classic',
            ],
            'color' => [
                'default' => 'transparent',
            ],
        ],
    
        ]
    );

    

    $this->add_responsive_control(
        'border_radius',
        [
            'label' => esc_html__('Border Radius', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the border radius of post category.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'border_padding',
        [
            'label' => esc_html__('Padding', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the padding of post category.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'category_position',
        [
            'label' => esc_html__('Category Position', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the position of post category.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-category' => 'left: {{LEFT}}{{UNIT}}; top: {{TOP}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'category_typography',
            'label'    => esc_html__('Category Typography', 'nine-core'),
            'description' => esc_html__('Set the typography for post category.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-category',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_author_style',
        [
            'label' => esc_html__('Author', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'author_color',
        [
            'label'     => esc_html__('Author Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of post author.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-meta-box a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'author_typography',
            'label'    => esc_html__('Author Typography', 'nine-core'),
            'description' => esc_html__('Set the typography for post author.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-meta-box a',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_date_style',
        [
            'label' => esc_html__('Date', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'date_typography',
            'label'    => esc_html__('Date Typography', 'nine-core'),
            'description' => esc_html__('Set the typography for post date.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-date',
        ]
    );

$this->end_controls_section();

// Content Style Section
$this->start_controls_section(
    'section_content_style',
    [
        'label' => esc_html__('Content', 'nine-core'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

    $this->add_responsive_control(
        'content_color',
        [
            'label'     => esc_html__('Content Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of post content.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-excerpt' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'content_typography',
            'label'    => esc_html__('Content Typography', 'nine-core'),
            'description' => esc_html__('Set the typography for post content.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-excerpt',
        ]
    );

    $this->end_controls_section();

    // Container Style Section
    $this->start_controls_section(
        'section_container_style',
        [
            'label' => esc_html__('Container', 'nine-core'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'border_color',
        [
            'label' => esc_html__('Border Color', 'nine-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the color of the container border.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'border_width',
        [
            'label' => esc_html__('Border Width', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the width of the container border.', 'nine-core'),
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'border_style',
        [
            'label' => esc_html__('Border Style', 'nine-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'description' => esc_html__('Set the style of the container border.', 'nine-core'),
            'default' => 'none',
            'options' => [
                'solid' => esc_html__('Solid', 'nine-core'),
                'dotted' => esc_html__('Dotted', 'nine-core'),
                'dashed' => esc_html__('Dashed', 'nine-core'),
                'double' => esc_html__('Double', 'nine-core'),
                'groove' => esc_html__('Groove', 'nine-core'),
                'ridge' => esc_html__('Ridge', 'nine-core'),
                'inset' => esc_html__('Inset', 'nine-core'),
                'outset' => esc_html__('Outset', 'nine-core'),
                'none' => esc_html__('None', 'nine-core'),
                'hidden' => esc_html__('Hidden', 'nine-core'),
            ],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'border-style: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'background_border_radius',
        [
            'label' => esc_html__('Background Border Radius', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the border radius of the container background.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'list_padding',
        [
            'label' => esc_html__('Padding', 'nine-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'description' => esc_html__('Set the padding of post box.', 'nine-core'),
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'background_color',
        [
            'label'     => esc_html__('Background Color', 'nine-core'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'description' => esc_html__('Set the background color of the container.', 'nine-core'),
            'selectors' => [
                '{{WRAPPER}} .el-list-big-box' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow',
            'description' => esc_html__('Add box shadow to the container.', 'nine-core'),
            'selector' => '{{WRAPPER}} .el-list-big-box',
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



