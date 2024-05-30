<?php
/*
Plugin Name: Nine Core
Description: A simple plugin for demonstration.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
*/

// Define constant for plugin directory path
define( 'NINE_DIR', plugin_dir_path( __FILE__ ) );

// Include ReduxFramework if not already included
if ( ! class_exists( 'ReduxFramework' ) ) {
    require( dirname( __FILE__ ) . '/redux-core/framework.php' );
}

// Include necessary files
$plugin_path = plugin_dir_path( __FILE__ );
require( $plugin_path . 'inc/template/override/header.php' );
require( $plugin_path . 'assets/variable.php' );
require( $plugin_path . 'inc/post/custom-post.php' );
require( $plugin_path . 'inc/template/override/footer.php' );
require( $plugin_path . 'inc/inc.php' );
require( $plugin_path . 'inc/template/opstion/header.php' );
require( $plugin_path . '/cmb2/init.php' );


// Adjust the load order of the 'elementor-frontend' style
function adjust_styles_load_order() {
    wp_dequeue_style( 'elementor-frontend' );
    wp_enqueue_style( 'elementor-frontend' );
}
add_action( 'wp_enqueue_scripts', 'adjust_styles_load_order', 99 );



function nine_core_activate() {
}
register_activation_hook( __FILE__, 'nine_core_activate' );