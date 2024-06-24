<?php

class Elementor_Customizations {

    public function __construct() {
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'register_editor_styles']);
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    public function add_elementor_widget_categories($elements_manager) {
        $theme_name = sanitize_key(wp_get_theme()->get('Name'));
        
        $new_categories = [
            "{$theme_name}-posts" => [
                'title' => wp_get_theme()->get('Name') . ' - Posts & Taxonomy',
                'icon'  => 'fa fa-plug'
            ],
            "{$theme_name}-widgets" => [
                'title' => wp_get_theme()->get('Name') . ' - General',
                'icon'  => 'fa fa-plug'
            ]
        ];

        $categories = array_merge($new_categories, $elements_manager->get_categories());

        $reflection = new ReflectionClass($elements_manager);
        $property = $reflection->getProperty('categories');
        $property->setAccessible(true);
        $property->setValue($elements_manager, $categories);
    }

    public function register_editor_styles() {
        wp_register_style('nine-elementor-editor', plugins_url('main.css', __FILE__));
        wp_enqueue_style('nine-elementor-editor');
    }

    public function register_widgets($widgets_manager) {
        $widgets = [
            'widgets/date-time.php',
            'widgets/post-grid-one.php',
            'widgets/post-list-one.php',
            'widgets/content.php',
            'widgets/comment.php',
            'widgets/search.php',
            'widgets/title.php',
            'widgets/menu.php',
            'widgets/menu-nav.php',
            'widgets/logo.php',
            'widgets/post-meta.php',
            'widgets/social-share.php',
            'widgets/heading.php',
            'widgets/archive-title.php',
            'widgets/copyright.php',
            'widgets/featured-img.php',
            'widgets/post-list-big.php',
            'block/block-grid-one.php',
            'block/block-list-one.php',
            'block/block-list-big.php',
            'widgets/cat-colleaction.php',
            'widgets/breadcrumbs.php',
            'widgets/post-expert.php'
        ];

        foreach ($widgets as $widget) {
            require_once(__DIR__ . '/' . $widget);
        }

        $widget_classes = [
            'post_grid_one',
            'post_list_one',
            'post_list_big',
            'single_post_content',
            'Single_Title',
            'Copyright_Widget',
            'Block_Heading_Widget',
            'Single_Post_Meta_Widget',
            'Search_Overlay_Widget',
            'single_post_comment',
            'Nine_SocialShare',
            'Site_Logo',
            'Nav_Menu',
            'Nav_Menu_two',
            'Single_Featured_Image',
            'Archive_Post_Title_Widget',
            'Date_And_Time_Module',
            'CategoryCollation',
            'Elementor_Breadcrumbs_Widget',
            'Elementor_Custom_Excerpt_Widget'
        ];

        foreach ($widget_classes as $widget_class) {
            $widgets_manager->register(new $widget_class());
        }
    }
}

new Elementor_Customizations();

