<?php

class Elementor_Customizations {

    public function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_editor_styles' ] );

        add_action( 'elementor/widgets/register', [ $this, 'nine_all_widget' ] );
    }

    public function add_elementor_widget_categories( $elements_manager ) {
        $categories = [];
        
        $categories[ sanitize_key( wp_get_theme()->name ) . '-posts'] = [
            'title' => wp_get_theme()->name . ' - Posts & Taxonomy',
            'icon'  => 'fa fa-plug'
        ];
        $categories[ sanitize_key( wp_get_theme()->name ) . '-widgets'] = [
            'title' => wp_get_theme()->name . ' - General',
            'icon'  => 'fa fa-plug'
        ];

        $old_categories = $elements_manager->get_categories();
        $categories = array_merge( $categories, $old_categories );

        $set_categories = function ( $categories ) {
            $this->categories = $categories;
        };

        $set_categories->call( $elements_manager, $categories );
    }

    public function register_editor_styles() {
        wp_register_style( 'nine-elementor-editor', plugins_url( 'main.css', __FILE__ ) );
        wp_enqueue_style( 'nine-elementor-editor' );
    }

    public function nine_all_widget( $widgets_manager ) {
        require_once( __DIR__ . '/widgets/post-grid-one.php' );
        require_once( __DIR__ . '/widgets/post-list-one.php' );
        require_once( __DIR__ . '/widgets/content.php' );
        require_once( __DIR__ . '/widgets/comment.php' );
        require_once( __DIR__ . '/widgets/title.php' );
        require_once( __DIR__ . '/widgets/post-meta.php' );
        require_once( __DIR__ . '/widgets/heading.php' );
        require_once( __DIR__ . '/widgets/copyright.php' );
        require_once( __DIR__ . '/widgets/featured-img.php' );
        require_once( __DIR__ . '/widgets/post-list-big.php' );
        require_once( __DIR__ . '/block/block-grid-one.php' );
        require_once( __DIR__ . '/block/block-list-one.php' );
        require_once( __DIR__ . '/block/block-list-big.php' );

        $widgets_manager->register( new \post_grid_one() );
        $widgets_manager->register( new \post_list_one() );
        $widgets_manager->register( new \post_list_big() );
        $widgets_manager->register( new \single_post_content() );
        $widgets_manager->register( new \Single_Title() );
        $widgets_manager->register( new \Copyright_Widget() );
        $widgets_manager->register( new \Block_Heading_Widget() );
        $widgets_manager->register( new \Single_Post_Meta_Widget() );
    }
}

new Elementor_Customizations();
