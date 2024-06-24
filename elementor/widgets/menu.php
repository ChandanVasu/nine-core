<?php
/**
 * Elementor Widget For Nine Theme
 * @package nine-core
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;


// Register the custom Elementor widget
class Nav_Menu extends \Elementor\Widget_Base {

    // The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
    public function get_name() {
        return 'navmenu';
    }

    // The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
    public function get_title() {
        return __( 'Nav Menu', 'nine-core' );
    }

    // The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
    public function get_icon() {
        return 'eicon-menu-bar';
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

        $this->add_responsive_control(
            'menu',
            [
                'label' => __( 'Menu', 'nine-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_available_menus(),
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'close_icon',
            [
                'label' => esc_html__( 'Close Icon', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Add Icon Style Section
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __( 'Icon Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .el-menu-icon-wrapper svg, {{WRAPPER}} .el-close-icon-wrapper svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-menu-icon-wrapper svg, {{WRAPPER}} .el-close-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
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

        $this->add_responsive_control(
            'menu_color',
            [
                'label' => __( 'Menu Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .el-nav-menu a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'label' => __( 'Typography', 'nine-core' ),
                'selector' => '{{WRAPPER}} .el-nav-menu a',
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

        ?>
        <div class="el-nav-menu-widget">
            <div class="el-menu-icon-wrapper">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </div>

            <div class='el-nav-menu-box'>
                <div class="el-nav-menu-wrapper">
                    <div class="el-nine-menu-logo logo-image">
                        <?php
                        if ( has_custom_logo() ) {
                            the_custom_logo();
                        } else {
                        ?>
                            <h1 class="nine-menu-text-logo logo-text">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                            <p class="nine-menu-text-description">
                                <?php bloginfo( 'description' ); ?>
                            </p>
                        <?php
                        }
                        ?>
                        <div class="el-close-icon-wrapper">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['close_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    </div>

                    <?php
                    wp_nav_menu([
                        'menu' => $menu_id,
                        'menu_class' => 'el-nav-menu',
                        'container' => '',
                    ]);
                    ?>
                </div>
                <script>
                    
                </script>
            </div>
        </div>
        <?php
    }
}

