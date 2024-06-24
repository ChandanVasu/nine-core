<?php
/**
 * Elementor Render Part
 * @package nine-core
 */
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

    global $title_length, $content_length;
    $title_length = $settings['title_length'];
    $content_length = $settings['content_length'];

    $query_args = [
        'post_type'      => 'post',
        'posts_per_page' => $settings['posts_per_page'],
        'offset'         => $settings['offset'],
        'order'          => $settings['order'],
        'ignore_sticky_posts' => true,
    ];

    if ($settings['dynamic_filtering'] === 'yes') {
        // If on a single post page, filter by categories of the current post
        if (is_single()) {
            $categories = get_the_category();
            $category_ids = wp_list_pluck($categories, 'term_id');
            $query_args['category__in'] = $category_ids;
        } else {
            // If on an archive page, use the current query's categories
            $current_query = $GLOBALS['wp_query'];
            $query_args = $current_query->query;

            $categories = get_the_category();
            $category_ids = wp_list_pluck($categories, 'term_id');
            if (!empty($category_ids)) {
                $query_args['category__in'] = $category_ids;
            }
        }
    } else {
        // Use the settings' category if dynamic filtering is off
        $query_args['category__in'] = $settings['category'];
    }

    // Ensure posts_per_page, offset, and order are set correctly
    $query_args['posts_per_page'] = $settings['posts_per_page'];
    $query_args['offset'] = $settings['offset'];
    $query_args['order'] = $settings['order'];

    $posts_query = new WP_Query($query_args);

    ob_start();

    ?>
    <div id="<?php echo esc_attr($settings['uuid']); ?>" class="posts-container">
        <?php
        if ($posts_query->have_posts()) :
            ?>
            <div class="el-g-1-grid-container">
                <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                    <?php get_template_part('template/block/elementor/g-1'); ?>
                <?php endwhile; ?>
            </div>
            <?php if ($posts_query->found_posts > $settings['posts_per_page']) : ?>
                <button id="load-more-<?php echo esc_attr($settings['uuid']); ?>" class="load-more-button" data-page="2" data-settings="<?php echo esc_attr(json_encode($settings)); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce('load_more_posts_nonce')); ?>">
                    <?php _e('Load More', 'nine-core'); ?>
                </button>
            <?php endif; ?>
            <?php
        else :
            echo '<div class="el-g-1-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
        endif;

        wp_reset_postdata();
        ?>
    </div>
    <?php

    return ob_get_clean();
}
