<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Widget Name: Site Logo
 */
class Site_Logo extends Widget_Base {

    public function get_name() {
        return 'site_logo';
    }

    public function get_title() {
        return __( 'Site Logo', 'nine-core' );
    }

    public function get_icon() {
        return 'eicon-logo'; // Change 'eicon-logo' to your desired icon class
    }

    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'logo_image',
            [
                'label' => __( 'Choose Logo Image', 'nine-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
    
        $this->add_control(
            'logo_url',
            [
                'label' => __( 'Logo Link URL', 'nine-core' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://example.com', 'nine-core' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                ],
                'description' => __( 'Enter the URL where clicking the logo will navigate.', 'nine-core' ),
            ]
        );
    
        $this->add_control(
            'logo_alt',
            [
                'label' => __( 'Logo Alt Text', 'nine-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Site Logo', 'nine-core' ),
                'placeholder' => __( 'Enter alt text for the logo', 'nine-core' ),
            ]
        );
    
        $this->add_control(
            'logo_width',
            [
                'label' => __( 'Logo Width', 'nine-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '',
                'description' => __( 'Set the width of the logo in pixels (px). Leave empty for default.', 'nine-core' ),
            ]
        );
    
        $this->add_control(
            'logo_height',
            [
                'label' => __( 'Logo Height', 'nine-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '',
                'description' => __( 'Set the height of the logo in pixels (px). Leave empty for default.', 'nine-core' ),
            ]
        );
    
        $this->end_controls_section();
    }
    

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        if ( has_custom_logo() && empty( $settings['logo_image']['url'] ) ) {
            the_custom_logo();
        } else {
            $logo_image_url = ! empty( $settings['logo_image']['url'] ) ? $settings['logo_image']['url'] : '';
            $logo_alt = ! empty( $settings['logo_alt'] ) ? $settings['logo_alt'] : get_bloginfo( 'name' );
            $logo_width = ! empty( $settings['logo_width'] ) ? 'width="' . esc_attr( $settings['logo_width'] ) . '"' : '';
            $logo_height = ! empty( $settings['logo_height'] ) ? 'height="' . esc_attr( $settings['logo_height'] ) . '"' : '';
            $logo_link_url = ! empty( $settings['logo_url']['url'] ) ? $settings['logo_url']['url'] : home_url( '/' );
    
            if ( ! empty( $logo_image_url ) ) {
                echo '<a href="' . esc_url( $logo_link_url ) . '">';
                echo '<img src="' . esc_url( $logo_image_url ) . '" alt="' . esc_attr( $logo_alt ) . '" ' . $logo_width . ' ' . $logo_height . '>';
                echo '</a>';
            } else {
                ?>
                <h1 class="nine-menu-text-logo logo-text">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </h1>
                <?php
            }
        }
    }
    


}

Plugin::instance()->widgets_manager->register_widget_type( new Site_Logo() );
