<?php
/**
 * Header file in case of the elementor way
 *
 * @package nine-core
 * @since 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php 
$nine_theme = get_option("nine_theme");
$template_id = $nine_theme["header_template"];
?>

<div>
<?php    // Display the Elementor content if available
    $elementor_content = display_nine_core_content($template_id);
    if ($elementor_content) {
        echo $elementor_content;
    }
    ?>
</div>
</body>
</html>