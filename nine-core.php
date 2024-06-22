<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0.0
Author: Vasu Theme
Author URI: https://themeforest.net/user/vasutheme
Requires Plugins: elementor
*/

define('NINE_DIR', plugin_dir_path(__FILE__));



$current_theme = wp_get_theme();
if ($current_theme->get('Name') == 'Nine') {
    $files_to_include = [
        'inc/template/override/header.php',
        'assets/variable.php',
        'inc/post/custom-post.php',
        'inc/template/override/footer.php',
        'inc/inc.php',
        'inc/template/opstion/header.php',
        'meta-box/init.php',
        'elementor/control.php',
        'elementor/inc/grid-one-load.php'
    ];

    foreach ($files_to_include as $file) {
        require_once NINE_DIR . $file;
    }
}

function adjust_styles_load_order() {
    wp_dequeue_style('elementor-frontend');
    wp_enqueue_style('elementor-frontend');
}
add_action('wp_enqueue_scripts', 'adjust_styles_load_order', 99);

if (!class_exists('ReduxFramework')) {
    require_once NINE_DIR . 'redux-core/framework.php';
}

function nine_core_activate() {
    
}
register_activation_hook(__FILE__, 'nine_core_activate');

function nine_core_enqueue_styles() {
    wp_enqueue_style('nine-core-main-style', plugins_url('assets/main.css', __FILE__));
    // Uncomment to enqueue video style if needed
    // wp_enqueue_style('video-style', plugins_url('assets/video.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'nine_core_enqueue_styles');

function enqueue_load_more_script() {
    wp_enqueue_script('load-more-script', plugins_url('assets/js/main.js', __FILE__), ['jquery'], null, true);
    // Uncomment to enqueue video script if needed
    // wp_enqueue_script('video-script', plugins_url('assets/js/video.js', __FILE__));
    wp_localize_script('load-more-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
