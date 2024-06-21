<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register the custom Elementor widget
class single_post_comment extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'single_post_comment';
    }

    // Widget Title
    public function get_title() {
        return __( 'COMMENT', 'nine-core' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-comments';
    }

    // Widget Category
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    // Register widget controls
    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'nine-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Comments', 'nine-core' ),
            ]
        );

        $this->end_controls_section();
    }

    // Render widget output on the frontend
    protected function render() {
        global $post;

        if ( ! $post ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        ?>

        <div class="single-post-comments">
            <h3><?php echo esc_html( $settings['title'] ); ?></h3>
            <?php
            if ( comments_open( $post->ID ) ) {
                comments_template();
            } else {
                echo '<p>' . __( 'Comments will be displayed here.', 'nine-core' ) . '</p>';
            }
            ?>
        </div>

        <?php
    }

}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \single_post_comment() );
