<?php
/**
 * Theme Include File
 * @package nine-core
 */

/**
 * -------------------------------------------------------------------------
 *  Display Elementor Content
 * -------------------------------------------------------------------------
 */


 if ( ! function_exists( 'display_nine_core_content' ) ) {
    function display_nine_core_content( $post_id ) {
        if ( ! class_exists( 'Elementor\Plugin' ) ) {
            return;
        }

        $pluginElementor = \Elementor\Plugin::instance();
        $response = $pluginElementor->frontend->get_builder_content_for_display( $post_id );

        return $response;
    }
}



/**
 * -------------------------------------------------------------------------
 *  Get posts id array
 * -------------------------------------------------------------------------
 */
if( ! function_exists('nine_get_posts_id') ) {
	function nine_get_posts_id( $post_type = 'post' ) {
		$posts = array();

		$post_lists = array(
			'post_type'        => $post_type,
			'numberposts'      => -1,
			'cache_results'  => false,
		);

		foreach ( get_posts( $post_lists ) as $post ) {
			$posts[$post->ID] = $post->post_title;
		}
		wp_reset_postdata();

		return $posts;
	}
}


// // Add custom CSS to admin area
// function my_custom_admin_css() {
//     echo '
//     <style>
//         #adminmenu #menu-posts-nine_theme .wp-menu-name, #adminmenu .toplevel_page_nine-options .wp-menu-name {
//             color: #01FFDD; 
//         }
//     </style>
//     ';
// }
// add_action( 'admin_head', 'my_custom_admin_css' );




