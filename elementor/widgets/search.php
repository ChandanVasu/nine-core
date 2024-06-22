<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register the custom Elementor widget
class Search_Overlay_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'search_overlay';
    }

    // Widget Title
    public function get_title() {
        return __( 'SEARCH', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-search';
    }

    // Widget Categories
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    // Widget Controls
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'placeholder_text',
            [
                'label' => __( 'Placeholder Text', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Search...', 'nine-core' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );



        $this->add_control(
            'icon_height',
            [
                'label' => __( 'Icon Size', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 128,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon' => 'height: {{SIZE}}{{UNIT}} !important; width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Render Widget Output on the Front End
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="search-icon" style="width: <?php echo $settings['icon_width']['size'] . $settings['icon_width']['unit']; ?>; height: <?php echo $settings['icon_height']['size'] . $settings['icon_height']['unit']; ?>;">
            <a href="#" class="search-icon-link">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </a>
        </div>
        <div class="search-overlay" id="search-overlay">
            <span class="closebtn" id="close-search">&times;</span>
            <div class="search-overlay-content">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="search-field" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit"><?php echo esc_html__( 'Search', 'nine-core' ); ?></button>
                </form>
            </div>
        </div>

        <script>
           
        </script>
        <?php
    }
}
