<?php
function generate_custom_css() {
    // Retrieve theme options using nine_get_opt
    $options = get_option('nine_theme'); // Adjust 'nine_theme' to your actual Redux options name

    // Define CSS variables
    $body_bg_color = isset($options['body_bg_color']) ? sanitize_hex_color($options['body_bg_color']) : '#ffffff';
    $primary_color = isset($options['primary_color']) ? sanitize_hex_color($options['primary_color']) : '#007bff';
    $primary_text_color = isset($options['primary_text_color']) ? sanitize_hex_color($options['primary_text_color']) : '#333333';
    $header_bg_color = isset($options['header_bg_color']) ? sanitize_hex_color($options['header_bg_color']) : '#f8f9fa';
    $box_color = isset($options['box_color']) ? sanitize_hex_color($options['box_color']) : '#eeeeee';
    $sticky_header = isset($options['sticky_header']) && $options['sticky_header'] === '1';

    // Start building CSS string
    $custom_css = "
    :root {
        --body-background-color: {$body_bg_color};
        --primary-color: {$primary_color};
        --primary-text-color: {$primary_text_color};
        --header-background-color: {$header_bg_color};
        --box-color: {$box_color};
    }
    ";

    // Conditionally add styles based on options
    if (!$sticky_header) {
        $custom_css .= "
        #main-header {
            position: relative;
        }
        .admin-bar #main-header {
            top: 0px; 
        }
        ";
    }

    // Output CSS inside a style tag
    echo '<style>' . wp_strip_all_tags($custom_css) . '</style>';
}

// Hook into wp_head to output the custom CSS
add_action('wp_head', 'generate_custom_css');
?>
