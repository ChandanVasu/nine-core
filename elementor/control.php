<?php

class Elementor_Customizations {

    public function __construct() {
        // Hook to add custom widget categories
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        // Hook to register and enqueue editor styles
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_editor_styles' ] );

        // Hook to register custom widget
        add_action( 'elementor/widgets/register', [ $this, 'register_hello_world_widget' ] );
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
        wp_register_style( 'th90-elementor-editor', plugins_url( 'main.css', __FILE__ ) );
        wp_enqueue_style( 'th90-elementor-editor' );
    }

    public function register_hello_world_widget( $widgets_manager ) {
        require_once( __DIR__ . '/widgets/post-grid.php' );
        require_once( __DIR__ . '/block/block-grid-one.php' );
        $widgets_manager->register( new \Grid_Post_One() );
    }
}

new Elementor_Customizations();
