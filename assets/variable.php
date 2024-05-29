<?php
// Function to generate custom CSS using theme options
function generate_custom_css() {
    // Retrieve theme options
    $nine_theme = get_option('nine_theme');
    
    // Check if theme options are set
    if (isset($nine_theme['body_bg_color'])) {
        // Get body background color from options
        $body_bg_color = esc_attr($nine_theme['body_bg_color']);
    }
    
    if (isset($nine_theme['primary_colors'])) {
        $primary_color = esc_attr($nine_theme['primary_colors']);
    }
    
    if (isset($nine_theme['primary_text'])) {
        $primary_text_color = esc_attr($nine_theme['primary_text']);
    }
    
    if (isset($nine_theme['header_background_colors'])) {
        $header_background_color = esc_attr($nine_theme['header_background_colors']);
    }

    if (isset($nine_theme['box_color'])) {
        $box_color = esc_attr($nine_theme['box_color']);
    }
    
    // Define CSS rules with PHP variables
    $custom_css = "
    :root {
        ";
    
    if (isset($body_bg_color)) {
        $custom_css .= "--body-background-color: {$body_bg_color};";
    }
    
    if (isset($primary_color)) {
        $custom_css .= "--primary-color: {$primary_color};";
    }
    
    if (isset($primary_text_color)) {
        $custom_css .= "--primary-text-color: {$primary_text_color};";
    }
    
    if (isset($header_background_color)) {
        $custom_css .= "--header-background-color: {$header_background_color};";
    }

    if (isset($box_color)) {
        $custom_css .= "--box-color: {$box_color};";
    }
    
    $custom_css .= "
    }
    ";

    // Output CSS inside a style tag
    echo '<style>' . $custom_css . '</style>';
}

// Adding to wp_head for inline CSS
add_action('wp_head', 'generate_custom_css');
?>
