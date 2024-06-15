<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0
Author: Vasu Theme
Author URI: https://yourwebsite.com
*/

// Define constant for plugin directory path
define('NINE_DIR', plugin_dir_path(__FILE__));

// Include ReduxFramework if not already included
if (!class_exists('ReduxFramework')) {
    require_once dirname(__FILE__) . '/redux-core/framework.php';
}

// Check if the active theme is 'Nine'
$current_theme = wp_get_theme();
if ($current_theme->get('Name') == 'Nine') {
    $plugin_path = plugin_dir_path(__FILE__);
    require_once $plugin_path . 'inc/template/override/header.php';
    require_once $plugin_path . 'assets/variable.php';
    require_once $plugin_path . 'inc/post/custom-post.php';
    require_once $plugin_path . 'inc/template/override/footer.php';
    require_once $plugin_path . 'inc/inc.php';
    require_once $plugin_path . 'inc/template/opstion/header.php';
    require_once $plugin_path . '/cmb2/init.php';
    require_once $plugin_path . '/elementor/control.php';
    require_once $plugin_path . '/elementor/inc/grid-one-load.php';
}


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
    wp_enqueue_style('video-style', plugins_url('assets/video.css', __FILE__));

}
add_action('wp_enqueue_scripts', 'nine_core_enqueue_styles');

// Enqueue load more script
function enqueue_load_more_script() {
    wp_enqueue_script('load-more-script', plugins_url('assets/js/load-more.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('video-script', plugins_url('assets/js/video.js', __FILE__));
    wp_localize_script('load-more-script', 'ajaxurl', admin_url('admin-ajax.php'));

    // Enqueue the script
    wp_enqueue_script('load-more-script');
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');



