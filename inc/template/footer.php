
 <?php
/**
 * Footer file in case of the elementor way
 *
 * @package header-footer-elementor
 * @since 1.2.0
 */
$nine_theme = get_option('nine_theme');

$template_id = ($nine_theme['header_template_code']);
?>
<?php echo do_shortcode ( $template_id );
?> 
<?php do_action( 'hfe_footer_before' ); ?>
<?php do_action( 'hfe_footer' ); ?>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html> 
