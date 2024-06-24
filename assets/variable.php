<?php
function generate_custom_css() {
    // Retrieve theme options using nine_get_opt
    $options = get_option('nine_theme'); // Adjust 'nine_theme' to your actual Redux options name

    // Define CSS variables
    $body_bg_color = esc_attr(nine_get_opt('body_bg_color'));
    $primary_color = esc_attr(nine_get_opt('primary_colors'));
    $primary_text_color = esc_attr(nine_get_opt('primary_text'));
    $header_bg_color = esc_attr(nine_get_opt('header_background_colors'));
    $box_color = esc_attr(nine_get_opt('box_color'));

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

    // Output CSS inside a style tag
    echo '<style>' . wp_strip_all_tags($custom_css) . '</style>';
}

// Hook into wp_head to output the custom CSS
add_action('wp_head', 'generate_custom_css');
?>
