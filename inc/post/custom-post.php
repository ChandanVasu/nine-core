<?php

// Ensure this code is added to a proper location like functions.php or a custom plugin.

// Class to manage the custom post type
class nine_Custom_Post_Type {

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        add_action('init', [$this, 'register_post_type'], 0);
        add_action('elementor/init', [$this, 'add_elementor_support']);
        
        // Hook to set Elementor Canvas as the default template for `nine_theme`.
        add_action('save_post_nine_theme', [$this, 'set_elementor_canvas_default'], 10, 3);
    }

    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Nine Template', 'Post Type General Name', 'nine-theme' ),
            'singular_name'         => _x( 'Nine Template', 'Post Type Singular Name', 'nine-theme' ),
            'menu_name'             => __( 'Nine Template', 'nine-theme' ),
            'name_admin_bar'        => __( 'Nine Template', 'nine-theme' ),
            'archives'              => __( 'List Archives', 'nine-theme' ),
            'parent_item_colon'     => __( 'Parent List:', 'nine-theme' ),
            'all_items'             => __( 'All Templates', 'nine-theme' ),
            'add_new_item'          => __( 'Add New Template', 'nine-theme' ),
            'add_new'               => __( 'Add New', 'nine-theme' ),
            'new_item'              => __( 'New Nine Theme Template', 'nine-theme' ),
            'edit_item'             => __( 'Edit Nine Theme Template', 'nine-theme' ),
            'update_item'           => __( 'Update Nine Theme Template', 'nine-theme' ),
            'view_item'             => __( 'View Nine Theme Template', 'nine-theme' ),
            'search_items'          => __( 'Search Nine Theme Template', 'nine-theme' ),
            'not_found'             => __( 'Not found', 'nine-theme' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'nine-theme' ),
            
        );

        $args = array(
            'label'                 => __( 'Post List', 'nine-theme' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'public'                => true,
            'rewrite'               => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => true,
            'capability_type'       => 'page',
            'hierarchical'          => false,
            'menu_position'         => 2,
            'menu_icon'             => get_theme_file_uri('Assets/Images/template.svg'),
        );

        register_post_type('nine_theme', $args);
    }

    public function add_elementor_support() {
        add_post_type_support('nine_theme', 'elementor');
    }

    public function set_elementor_canvas_default($post_id, $post, $update) {
        if ($update || wp_is_post_revision($post_id)) {
            return;
        }

        if ($post->post_type === 'nine_theme') {
            update_post_meta($post_id, '_wp_page_template', 'elementor_canvas');
        }
    }
}

nine_Custom_Post_Type::instance();

