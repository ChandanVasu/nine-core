<?php

// // Get the 'nine_theme' option
// $nine_theme = get_option('nine_theme');

// // Check if 'nine_theme' is not null and contains the key 'header_template_code'
// $template_id = isset($nine_theme['header_template']) ? esc_attr($nine_theme['header_template']) : null;

// // Only add the action if 'template_id' is not empty
// if (!empty($template_id)) {
//     add_action('get_header', 'override_header');
// }

// function override_header() {
//     require NINE_DIR . 'inc/template/header.php';

//     // Declare an array of templates
//     $templates = [];
//     $templates[] = 'header.php';

//     // Avoid running wp_footer hooks again.
//     remove_all_actions('wp_head');

//     // Start output buffering
//     ob_start();

//     // Locate and include the template
//     locate_template($templates, true);

//     // Clean the output buffer
//     ob_end_clean();

// }

