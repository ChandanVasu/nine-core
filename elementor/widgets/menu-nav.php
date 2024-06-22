<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;


// Register the custom Elementor widget
class Nav_Menu_two extends \Elementor\Widget_Base {

    // The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
    public function get_name() {
        return 'menu';
    }

    // The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
    public function get_title() {
        return __( 'Menu', 'nine-core' );
    }

    // The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
    public function get_icon() {
        return 'eicon-nav-menu';
    }

    // The get_categories method, lets you set the category of the widget, return the category name as a string.
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    // The _register_controls method is used to add controls to the widget.
    protected function _register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'nine-core' ),
            ]
        );

        $this->add_control(
            'menu',
            [
                'label' => __( 'Menu', 'nine-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_available_menus(),
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // Add Menu Style Section
        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => __( 'Menu Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => __( 'Menu Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .nav-main-menu a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .nav-main-menu a',
            ]
        );

        $this->end_controls_section();
    }

    // A helper method to get available menus
    private function get_available_menus() {
        $menus = wp_get_nav_menus();
        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->term_id ] = $menu->name;
        }

        return $options;
    }

    // The render method is used to display the widget's output on the frontend.
    protected function render() {
        $settings = $this->get_settings_for_display();
        $menu_id = $settings['menu'];

        if ( ! $menu_id ) {
            return;
        }

        
        wp_nav_menu([
            'menu' => $menu_id,
            'menu_id'        => 'nav-main-menu',
            'container'      => 'div',
            'container_class'=> 'nav-main-container',
            'menu_class'     => 'nav-main-menu',
            'fallback_cb'    => false,
        ]);
        

    }
}

