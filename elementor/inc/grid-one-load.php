<?php

function g_1_load_more() {
    $page = $_POST['page'];
    $settings = $_POST['settings'];
    $posts_per_page = $settings['posts_per_page'];
    $category = $settings['category'];
    $offset = $settings['offset'];
    $order = $settings['order'];
    $title_length = $settings['title_length'];
    $content_length = $settings['content_length'];
    $dynamic_filtering = $settings['dynamic_filtering'];

    // Make settings available globally within the scope of the template part
    global $title_length, $content_length;
    $title_length = $settings['title_length'];
    $content_length = $settings['content_length'];

    $query_args = [
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset + ($posts_per_page * ($page - 1)),
        'order' => $order,
        'ignore_sticky_posts' => true,
    ];

    if ($dynamic_filtering === 'yes' && is_single()) {
        $categories = get_the_category();
        $category_ids = wp_list_pluck($categories, 'term_id');
        $query_args['category__in'] = $category_ids;
    } else {
        $query_args['category__in'] = $category;
    }

    $posts_query = new WP_Query($query_args);

    if ($posts_query->have_posts()) :
        while ($posts_query->have_posts()) : $posts_query->the_post(); ?>

            <?php get_template_part('template/block/elementor/g-1'); ?>

        <?php endwhile;
    else :
        echo '';
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'g_1_load_more');
add_action('wp_ajax_nopriv_load_more_posts', 'g_1_load_more');
