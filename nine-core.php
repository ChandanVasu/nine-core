<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
*/

if( !class_exists('ReduxFramework')){
    require_once(dirname(__FILE__) . '/redux-core/framework.php');
}

// Define the path to the assets directory
$plugin_path = plugin_dir_path(__FILE__); // This gives you the current plugin's directory

// Include the file
include_once($plugin_path . 'assets/veriabl.php');

include_once($plugin_path . 'assets/post/custom-post.php');


// // Function to render the custom footer using a shortcode
// function my_custom_footer_shortcode() {
//     echo do_shortcode('[vasutheme_Template id="30"]'); // Replace with your specific shortcode
// }

// // Add this function to the 'wp_footer' hook
// add_action('wp_head', 'my_custom_footer_shortcode');

// // Remove the default footer content
// function my_remove_default_footer() {
//     remove_action('wp_head', 'theme_footer_function'); // Replace 'theme_footer_function' with your theme's footer function
// }

// // Ensure this runs before the custom footer is added
// add_action('wp_head', 'my_remove_default_footer', 5);

// This should be placed in your theme's functions.php or a custom plugin

function remove_my_head_actions() {
    remove_action( 'wp_head', 'rsd_link' );
    // Add more remove_action calls here for other actions
  }
  add_action( 'init', 'remove_my_head_actions' ); // Hook to 'init' action
  
