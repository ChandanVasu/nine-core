<?php

function post_list_big($settings) {
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
        'post_type' => 'post',
        'posts_per_page' => $settings['posts_per_page'],
        'offset' => $settings['offset'],
        'order' => $settings['order'],
        'ignore_sticky_posts' => true,
    ];

    if ($settings['dynamic_filtering'] === 'yes' && is_single()) {
        $categories = get_the_category();
        $category_ids = wp_list_pluck($categories, 'term_id');
        $query_args['category__in'] = $category_ids;
    } else {
        $query_args['category__in'] = $settings['category'];
    }

    $posts_query = new WP_Query($query_args);

    if ($posts_query->have_posts()) :
        ?>
        <div class="el-list-big-list-container">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                <div class="el-list-big-box">
                    <div class="el-list-big-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                    </div>
                    <div class="el-list-big-content">
                        <span class="el-list-big-category">
                            <?php the_category(', '); ?>
                        </span>
                        <h2 class="el-list-big-title"><a href="<?php the_permalink(); ?>">
                            <?php echo wp_trim_words(get_the_title(), $title_length, '...'); ?>
                        </a></h2>
                        <div class="el-list-big-excerpt excerpt">
                            <?php echo wp_trim_words(get_the_content(), $content_length, '...'); ?>
                        </div>
                        <div class="el-list-big-meta-box">
                            <?php
                            $author_id = get_the_author_meta('ID');
                            $author_avatar = get_avatar_url($author_id, ['size' => 32]);
                            ?>
                            <img class="el-list-big-avatar author-avatar" src="<?php echo esc_url($author_avatar); ?>"
                                 alt="<?php echo esc_attr(get_the_author()); ?>">
                            <a class="el-list-big-name" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                <?php the_author(); ?>
                            </a>
                            <span class="el-list-big-date">
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    else :
        echo '<div class="el-list-big-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
    endif;
}
?>
