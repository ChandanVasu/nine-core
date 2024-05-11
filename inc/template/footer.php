<?php
/**
 * Footer file for Elementor-based content
 *
 * @package nine-core
 * @since 1.2.0
 */

// Get the Elementor template ID from theme options
$nine_theme = get_option("nine_theme");
$template_id = $nine_theme["footer_template"];
?>

<div>
    <?php
    // Display the Elementor content if available
    $elementor_content = display_nine_core_content($template_id);
    if ($elementor_content) {
        echo $elementor_content;
    }
    ?>
</div>

<?php wp_footer(); ?>

</body>
</html>
