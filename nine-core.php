<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
*/

// Define constant for plugin directory path
define('NINE_DIR', plugin_dir_path(__FILE__));

// Include ReduxFramework if not already included
if (!class_exists('ReduxFramework')) {
    require_once dirname(__FILE__) . '/redux-core/framework.php';
}

// Include necessary files
$plugin_path = plugin_dir_path(__FILE__);
require_once $plugin_path . 'inc/template/override/header.php';
require_once $plugin_path . 'assets/variable.php';
require_once $plugin_path . 'inc/post/custom-post.php';
require_once $plugin_path . 'inc/template/override/footer.php';
require_once $plugin_path . 'inc/inc.php';
require_once $plugin_path . 'inc/template/opstion/header.php';
require_once $plugin_path . '/cmb2/init.php';
require_once $plugin_path . '/elementor/control.php';

// Enqueue main.css file
function adjust_styles_load_order() {
    wp_dequeue_style('elementor-frontend');
    wp_enqueue_style('elementor-frontend');
}
add_action('wp_enqueue_scripts', 'adjust_styles_load_order', 99);

// Activation hook
function nine_core_activate() {
    // Activation code here
}
register_activation_hook(__FILE__, 'nine_core_activate');

// Enqueue styles
function nine_core_enqueue_styles() {
    wp_enqueue_style('nine-core-main-style', plugins_url('assets/main.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'nine_core_enqueue_styles');

// Enqueue load more script
function enqueue_load_more_script() {
    wp_enqueue_script('load-more-script', plugins_url('assets/js/load-more.js', __FILE__), array('jquery'), null, true);

    wp_localize_script('load-more-script', 'ajaxurl', admin_url('admin-ajax.php'));

    // Enqueue the script
    wp_enqueue_script('load-more-script');
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');



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

