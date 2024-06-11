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
                            <?php echo wp_trim_words(get_the_title(), $settings['title_length'], '...'); ?>
                        </a>
                    </h2>
                    <div class="el-g-1-excerpt excerpt">
                        <?php echo wp_trim_words(get_the_content(), $settings['content_length'], '...'); ?>
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
            <?php endwhile; ?>
        </div>
        <?php
    else :
        echo '<div class="el-g-1-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
    endif;

    $output = ob_get_clean();
    return $output;
}
