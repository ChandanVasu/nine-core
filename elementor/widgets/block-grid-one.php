<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Posts_Load_More_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'posts_load_more';
    }

    public function get_title() {
        return __( 'Posts Load More', 'elementor-posts-load-more' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'elementor-posts-load-more' ),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Posts Per Page', 'elementor-posts-load-more' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => __( 'Load More Button Text', 'elementor-posts-load-more' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Load More', 'elementor-posts-load-more' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $query_args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
        );

        $query = new WP_Query( $query_args );
        ?>

        <div class="posts-load-more-widget">
            <div class="posts-list">
                <?php if ( $query->have_posts() ) : ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <div class="post-item">
                            <h2><?php the_title(); ?></h2>
                            <div class="post-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p><?php _e( 'No posts found', 'elementor-posts-load-more' ); ?></p>
                <?php endif; wp_reset_postdata(); ?>
            </div>
            <div class="load-more-wrapper">
                <button class="load-more-button"><?php echo esc_html( $settings['load_more_text'] ); ?></button>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var page = 2;
                var postsPerPage = <?php echo $settings['posts_per_page']; ?>;
                var buttonText = '<?php echo esc_html( $settings['load_more_text'] ); ?>';
                
                $('.load-more-button').on('click', function() {
                    $.ajax({
                        url: '<?php echo esc_url( rest_url( 'wp/v2/posts' ) ); ?>',
                        type: 'GET',
                        data: {
                            page: page,
                            per_page: postsPerPage
                        },
                        beforeSend: function() {
                            $('.load-more-button').text('Loading...');
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                $.each(response, function(index, post) {
                                    var postItem = '<div class="post-item">';
                                    postItem += '<h2>' + post.title.rendered + '</h2>';
                                    postItem += '<div class="post-content">' + post.excerpt.rendered + '</div>';
                                    postItem += '</div>';
                                    $('.posts-list').append(postItem);
                                });
                                page++;
                                $('.load-more-button').text(buttonText);
                            } else {
                                $('.load-more-button').hide();
                            }
                        }
                    });
                });
            });
        </script>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Posts_Load_More_Widget() );
