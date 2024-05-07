<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
*/

define( 'HFE_DIR', plugin_dir_path( __FILE__ ) );


if( !class_exists('ReduxFramework')){
    require_once(dirname(__FILE__) . '/redux-core/framework.php');
}

$plugin_path = plugin_dir_path(__FILE__); // This gives you the current plugin's directory

// Include the file
include_once($plugin_path . 'assets/veriabl.php');
include_once($plugin_path . 'inc/post/custom-post.php');
include_once($plugin_path . 'inc/template/override/footer.php');




function adjust_styles_load_order() {
    wp_dequeue_style('elementor-frontend');
    wp_enqueue_style('elementor-frontend');
 }
 add_action('wp_enqueue_scripts', 'adjust_styles_load_order', 1);




//  function get_footer_content() {
//     echo "<div class='footer-width-fixer'>";
//     echo self::$elementor_instance->frontend->get_builder_content_for_display( get_hfe_footer_id() ); 
//     echo '</div>';
// }


function my_custom_admin_css() {
    echo '
    <style>
        #adminmenu .menu-top.menu-icon-nine_theme .wp-menu-name, #adminmenu .toplevel_page_nine-options .wp-menu-name {
            color: #FFB700; 
        }
    </style>
    ';
}
add_action('admin_head', 'my_custom_admin_css');

