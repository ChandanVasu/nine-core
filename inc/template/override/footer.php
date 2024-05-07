<?php


$nine_theme = get_option('nine_theme');

$template_id = esc_attr($nine_theme['header_template_code']);


if (!empty($template_id)) {
    add_action('get_footer', 'override_footer'); // Adding the action only if template_id has a value
}

function override_footer() {
    require HFE_DIR . 'inc/template/footer.php';
    $templates   = [];
    $templates[] = 'footer.php';
    // Avoid running wp_head hooks again.
    remove_all_actions( 'wp_footer' );
    ob_start();
    locate_template( $templates, true );
    ob_get_clean();
 }
