<?php
/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CategoryCollation extends \Elementor\Widget_Base {

    public function get_name() {
        return 'cat_collation';
    }

    // Widget Title
    public function get_title() {
        return __('Category Collation', 'nine-core');
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-call-to-action';
    }

    // Widget Category
    public function get_categories() {
        return [sanitize_key(wp_get_theme()->get('Name')) . '-widgets'];
    }

    // Widget Controls
    protected function _register_controls() {
        $categories = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => false,
        ]);

        $categories_choices = [];

        foreach ($categories as $category) {
            $categories_choices[$category->term_id] = $category->name;
        }

        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'nine-core'),
            ]
        );

        $this->add_control(
            'selected_categories',
            [
                'label' => __('Select Categories', 'nine-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $categories_choices,
                'default' => [],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'number_of_categories',
            [
                'label' => __('Number of Categories', 'nine-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5, // Default number of categories to display
            ]
        );

        $this->add_responsive_control(
            'items_per_row',
            [
                'label' => esc_html__('Items Per Row', 'nine-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => esc_html__('Set the number of items to display per row.', 'nine-core'),
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 4,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .nine-item-box-wrap' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
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
                    'size' => 1.02,
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-category-thumb img:hover' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        // Control for title color
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'description' => esc_html__('Set the color of post titles.', 'nine-core'),
                'selectors' => [
                    '{{WRAPPER}} .el-badge-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Control for title hover color
        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__('Title Hover Color', 'nine-core'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'description' => esc_html__('Set the hover color of post titles.', 'nine-core'),
                'selectors' => [
                    '{{WRAPPER}} .el-badge-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-badge-item .el-category-count',
                'label' => esc_html__('Background', 'nine-core'),
                'exclude' => ['image'],
                'description' => esc_html__('Set the background color of post category.', ),
                'fields_options' => [
                'background' => [
                    'label' => esc_html__('Category Background Color', 'nine-core'),
                    'default' => 'classic',
                ],
                'color' => [
                    'default' => 'blue',
                ],
            ],
        
            ]
        );

        $this->end_controls_section();
    }

    // Widget Rendering
    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_categories = !empty($settings['selected_categories']) ? $settings['selected_categories'] : [];
        $number_of_categories = !empty($settings['number_of_categories']) ? $settings['number_of_categories'] : 5;

        $cc_args = [
            'taxonomy'  => 'category',
            'include'   => $selected_categories,
            'number'    => $number_of_categories,
        ];
        $cc_query = get_terms($cc_args);

        ?>
        <div class="nine-item-box-wrap">
            <?php
            foreach ($cc_query as $category):
                $cc_post_query = new \WP_Query([
                    'cat'                   => absint($category->term_id),
                    'posts_per_page'        => 1,
                    'orderby'               => 'rand',
                    'meta_query'            => [
                        [
                            'key'     => '_thumbnail_id',
                            'compare' => 'EXISTS'
                        ]
                    ],
                    'ignore_sticky_posts'   => true
                ]);

                if ($cc_post_query->have_posts()) {
                    $cc_post_query->the_post();
                    $thumbnail_post_id = get_the_ID();
                    $thumbnail = get_the_post_thumbnail($thumbnail_post_id, 'full', [
                        'title' => esc_attr($category->name)
                    ]);
                    $category_link = esc_url(get_term_link($category->term_id));
                    $category_name = esc_html($category->name);
                    $category_count = absint($category->count);
                    $category_description = esc_html($category->description);
                    ?>
                    <div class="el-cat-post-item">
                        <div class="el-sole-category">
                            <figure class="el-category-thumb thumbnail">
                                <a href="<?php echo $category_link; ?>">
                                    <?php echo $thumbnail; ?>
                                </a>
                                <h4 class="el-badge-item badge-title ">
                                    <a href="<?php echo $category_link; ?>"><?php echo $category_name; ?></a>
                                    <span class="el-category-count"><?php echo $category_count; ?></span>

                                </h4>
                            </figure>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata(); // Reset the post data
                }
            endforeach;
            ?>
        </div> <!-- .category-collation-wrapper -->
        <?php
    }
}

