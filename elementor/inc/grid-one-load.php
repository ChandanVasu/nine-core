<?php

function load_more_posts_ajax_handler($settings) {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $settings = isset($_POST['settings']) ? $_POST['settings'] : [];
    $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 4;
    $category = !empty($settings['category']) ? array_map('intval', (array) $settings['category']) : [];
    $offset = !empty($settings['offset']) ? intval($settings['offset']) : 0;
    $order = !empty($settings['order']) ? sanitize_text_field($settings['order']) : 'DESC';
    $title_length = !empty($settings['title_length']) ? intval($settings['title_length']) : 10;
    $content_length = !empty($settings['content_length']) ? intval($settings['content_length']) : 20;
    $dynamic_filtering = !empty($settings['dynamic_filtering']) ? sanitize_text_field($settings['dynamic_filtering']) : 'no';

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
            <div class="el-g-1-box">
                <div class="el-g-1-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <span class="el-g-1-category">
                        <?php the_category(', '); ?>
                    </span>
                </div>
                <h2 class="el-g-1-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo wp_trim_words(get_the_title(), $title_length, '...'); ?>
                    </a>
                </h2>
                <div class="el-g-1-excerpt excerpt">
                    <?php echo wp_trim_words(get_the_content(), $content_length, '...'); ?>
                </div>
                <div class="el-g-1-meta-box">
                    <?php
                    $author_id = get_the_author_meta('ID');
                    $author_avatar = get_avatar_url($author_id, ['size' => 32]);
                    ?>
                    <img class="el-g-1-avatar author-avatar" src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr(get_the_author()); ?>">
                    <a class="el-g-1-name" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                        <?php the_author(); ?>
                    </a>
                    <span class="el-g-1-date">
                        <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                    </span>
                </div>
            </div>
        <?php endwhile;
    else :
        echo '';
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax_handler');