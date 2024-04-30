<?php

// Function to generate custom CSS using theme options
function generate_custom_css() {
    // Retrieve theme options
    $nine_theme = get_option('nine_theme');
    
    // Get body background color from options
    $body_bg_color = esc_attr($nine_theme['body_bg_color']);
    
    $link_color = esc_attr($nine_theme['link_color']);
   
    $primary_color = esc_attr($nine_theme['primary_color']);

    $primary_text_color = esc_attr($nine_theme['primary_text']);



    
    
    
    // Define CSS rules with PHP variables
    $custom_css = "
    :root {
        --primary: {$body_bg_color};
        --primary-color: {$primary_color};
        --secondary-color: #ffffff;
        --primary-text: {$primary_text_color};
        --secondary-text: #232323;
        --link-color: {$link_color};
    }
    ";

    // Output CSS inside a style tag
    echo '<style>' . $custom_css . '</style>';
}

// Adding to wp_head for inline CSS
add_action('wp_head', 'generate_custom_css');
