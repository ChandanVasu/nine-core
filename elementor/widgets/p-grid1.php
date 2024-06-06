<?php

function grid_post_one($settings){

    // Determine the number of posts to display
    $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 5;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

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

        // Ensure 'posts_per_page' is not adjusted incorrectly
        if (!isset($query_args['posts_per_page']) || $query_args['posts_per_page'] != $posts_per_page) {
            $query_args['posts_per_page'] = $posts_per_page;
        }

        if (!isset($query_args['offset'])) {
            $query_args['offset'] = isset($settings['offset']) ? $settings['offset'] : 0;
        }

        if (!isset($query_args['order'])) {
            $query_args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';
        }

        $query_args['paged'] = $paged;

        $posts_query = new WP_Query($query_args);
    } else {
        $query_args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            'category__in'   => isset($settings['category']) ? $settings['category'] : array(),
            'offset'         => isset($settings['offset']) ? $settings['offset'] : 0,
            'order'          => isset($settings['order']) ? $settings['order'] : 'DESC',
            'paged'          => $paged,
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

                    <h2 class="el-g-1-title "><a href="<?php the_permalink(); ?>">
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
                        <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                        </span> <!-- Modified class name -->
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class='pagination'>
                <?php custom_pagination($posts_query); ?>
            </div>
        <?php
        wp_reset_postdata(); // Reset post data
    else :
        echo '<div class="el-g-1-no-posts-found">' . __('No posts found', 'nine-core') . '</div>';
    endif;
}

if (!function_exists('custom_pagination')) {
    function custom_pagination($query = null) {
        if (!$query) {
            global $wp_query;
            $query = $wp_query;
        }

        if ($query->max_num_pages <= 1) return;

        $paginate_args = array(
            'current'   => max(1, get_query_var('paged')),
            'total'     => $query->max_num_pages,
            'prev_next' => true,
            'prev_text' => __('&#9664;', 'nine-theme'),
            'next_text' => __('&#9654;', 'nine-theme'),
        );

        echo paginate_links($paginate_args);
    }
}



