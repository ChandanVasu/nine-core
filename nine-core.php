<?php
/*
 * Plugin Name:       Nine Core
 * Plugin URI:        https://themeforest.net/user/vasutheme/
 * Description:       This is core plugin for Nine theme
 * Version:           1.0
 * Author:            VasuTheme
 * Author URI:        https://themeforest.net/user/vasutheme
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nine-core
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define('NINE_DIR', plugin_dir_path(__FILE__));

// Include ReduxFramework if not already included
if (!class_exists('ReduxFramework')) {
    require_once dirname(__FILE__) . '/framework/redux-core/framework.php';
}

// Check if the active theme is 'Nine'
$current_theme = wp_get_theme();
if ($current_theme->get('Name') == 'Nine') {
    $plugin_path = plugin_dir_path(__FILE__);
    require_once $plugin_path . 'inc/template/override/header.php';
    require_once $plugin_path . 'assets/variable.php';
    require_once $plugin_path . 'inc/post/custom-post.php';
    require_once $plugin_path . 'inc/inc.php';
    require_once $plugin_path . 'inc/template/override/footer.php';
    require_once $plugin_path . 'framework/meta-box/init.php';
    require_once $plugin_path . 'elementor/control.php';
    require_once $plugin_path . 'elementor/inc/grid-one-load.php';
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
    // wp_enqueue_style('video-style', plugins_url('assets/video.css', __FILE__));

}
add_action('wp_enqueue_scripts', 'nine_core_enqueue_styles');

function enqueue_load_more_script() {
    wp_enqueue_script('load-more-script', plugins_url('assets/js/main.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('load-more-script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('load-more-script');
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
