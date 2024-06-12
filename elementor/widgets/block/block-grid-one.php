<?php

function grid_post_one($settings) {
    $defaults = [
        'posts_per_page' => 8,
        'category' => [],
        'offset' => 0,
        'order' => 'DESC',
        'title_length' => 10,
        'content_length' => 20,
        'dynamic_filtering' => 'no'
    ];
    $settings = wp_parse_args($settings, $defaults);

    // Make settings available globally within the scope of the template part
    global $title_length, $content_length;
    $title_length = $settings['title_length'];
    $content_length = $settings['content_length'];

    $query_args = [
        'post_type' => 'post',
        'posts_per_page' => $settings['posts_per_page'],
        'offset' => $settings['offset'],
        'order' => $settings['order'],
        'ignore_sticky_posts' => true,
    ];

    if ($settings['dynamic_filtering'] === 'yes') {
        $categories = get_the_category();
        $category_ids = wp_list_pluck($categories, 'term_id');

        if (is_single()) {
            $query_args['category__in'] = $category_ids;
        }
    } else {
        $query_args['category__in'] = $settings['category'];
    }

    $posts_query = new WP_Query($query_args);

    ob_start();

    if ($posts_query->have_posts()) :
        ?>
        <div class="el-g-1-grid-container">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>

                <?php get_template_part('template/elementor/g-1'); ?>

            <?php endwhile; ?>
        </div>
        <?php
    else :
        echo '<div class="el-g-1-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
    endif;

    wp_reset_postdata();

    $output = ob_get_clean();
    return $output;
}
