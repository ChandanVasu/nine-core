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

