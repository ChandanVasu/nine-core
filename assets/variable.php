<?php
function generate_custom_css() {
    // Retrieve theme options using nine_opt_check
    $body_bg_color = esc_attr(nine_opt_check('body_bg_color'));
    $primary_color = esc_attr(nine_opt_check('primary_colors'));
    $primary_text_color = esc_attr(nine_opt_check('primary_text'));
    $header_background_color = esc_attr(nine_opt_check('header_background_colors'));
    $box_color = esc_attr(nine_opt_check('box_color'));

    // Define CSS rules with PHP variables
    $custom_css = "
    :root {
        --body-background-color: {$body_bg_color};
        --primary-color: {$primary_color};
        --primary-text-color: {$primary_text_color};
        --header-background-color: {$header_background_color};
        --box-color: {$box_color};
    }
    ";

    // Output CSS inside a style tag
    echo '<style>' . $custom_css . '</style>';
}

// Adding to wp_head for inline CSS
add_action('wp_head', 'generate_custom_css');

