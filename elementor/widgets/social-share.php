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
class Nine_SocialShare extends \Elementor\Widget_Base{

    // The get_name() method returns a widget name that will be used in the code.
    public function get_name() {
        return 'socialshare';
    }

    // The get_title() method returns the widget title that will be displayed as the widget label.
    public function get_title() {
        return __( 'Post Share', 'nine-core' );
    }

    // The get_icon() method sets the widget icon.
    public function get_icon() {
        return 'eicon-share';
    }

    // The get_categories method sets the category of the widget.
    public function get_categories() {
        return [ sanitize_key( wp_get_theme()->get('Name') ) . '-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'nine-core' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'social_share',
            [
                'label' => __( 'Social Share Buttons', 'nine-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'facebook'  => __( 'Facebook', 'nine-core' ),
                    'twitter' => __( 'Twitter', 'nine-core' ),
                    'google'  => __( 'Google Plus', 'nine-core' ),
                    'pinterest' => __( 'Pinterest', 'nine-core' ),
                    'linkedin'  => __( 'Linkedin', 'nine-core' ),
                    'buffer' => __( 'Buffer', 'nine-core' ),
                    'digg'  => __( 'Digg', 'nine-core' ),
                    'reddit' => __( 'Reddit', 'nine-core' ),
                    'tumbleupon'  => __( 'Tumbleupon', 'nine-core' ),
                    'tumblr' => __( 'Tumblr', 'nine-core' ),
                    'vk' => __( 'Vk', 'nine-core' ),
                    'email' => __( 'Email', 'nine-core' ),
                    'print' => __( 'Print', 'nine-core' ),
                ],
                'default' => [ 'facebook', 'twitter', 'pinterest', 'linkedin' ],
            ]
        );

        $this->add_control(
            'social_shape',
            [
                'label' => __( 'Shape', 'nine-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'rounded',
                'options' => [
                    'rounded'  => __( 'Rounded', 'nine-core' ),
                    'square' => __( 'Square', 'nine-core' ),
                    'circle' => __( 'Circle', 'nine-core' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __( 'Alignment', 'nine-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'nine-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'nine-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'nine-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
                'toggle' => true,
            ]
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'icon_section',
            [
                'label' => __( 'Icon', 'nine-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'select_color',
            [
                'label' => __( 'Color', 'nine-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default_color',
                'options' => [
                    'default_color'  => __( 'Official Color', 'nine-core' ),
                    'custom_color' => __( 'Custom', 'nine-core' ),
                ],
            ]
        );

        $this->add_control(
            'social_bgcolor',
            [
                'label' => __( 'Primary Color', 'nine-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'select_color' => 'custom_color',
                ],
            ]
        );

        $this->add_control(
            'social_color',
            [
                'label' => __( 'Secondary Color', 'nine-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'select_color' => 'custom_color',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_size',
            [
                'label' => __( 'Size', 'nine-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_padding',
            [
                'label' => __( 'Padding', 'nine-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_space',
            [
                'label' => __( 'Spacing', 'nine-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'social_border_radius',
            [
                'label' => __( 'Border Radius', 'nine-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .nine-social-share a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        global $post;
        // Get current page URL
        $postURL = urlencode(get_permalink());

        // Get current page title
        $postTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');

        // Get Post Thumbnail for Pinterest
        $postThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

        // Construct sharing URLs
        $share_urls = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $postURL,
            'twitter' => 'https://twitter.com/intent/tweet?text=' . $postTitle . '&amp;url=' . $postURL . '&amp;via=' . get_bloginfo('name'),
            'google' => 'https://plus.google.com/share?url=' . $postURL,
            'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . $postURL . '&amp;media=' . $postThumbnail[0] . '&amp;description=' . $postTitle,
            'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $postURL . '&amp;title=' . $postTitle,
            'buffer' => 'https://bufferapp.com/add?url=' . $postURL . '&amp;text=' . $postTitle,
            'digg' => 'https://www.digg.com/submit?url=' . $postURL,
            'reddit' => 'https://reddit.com/submit?url=' . $postURL . '&amp;title=' . $postTitle,
            'tumbleupon' => 'https://www.stumbleupon.com/submit?url=' . $postURL . '&amp;title=' . $postTitle,
            'tumblr' => 'https://www.tumblr.com/share/link?url=' . $postURL . '&amp;title=' . $postTitle,
            'vk' => 'https://vk.com/share.php?url=' . $postURL,
            'email' => 'mailto:?Subject=' . $postTitle . '&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 ' . $postURL,
            'print' => 'javascript:window.print()'
        ];

        echo '<div class="nine-social-share clearfix shape-' . $settings['social_shape'] . '">';
        foreach ($settings['social_share'] as $item) {
            if (isset($share_urls[$item])) {
                $icon_class = 'fab fa-' . ($item === 'google' ? 'google-plus-g' : $item);
                echo '<a class="share-' . $item . '" href="' . esc_url($share_urls[$item]) . '" target="_blank"><i class="' . esc_attr($icon_class) . '"></i></a>';
            }
        }
        echo '</div>';
    }

    protected function content_template() {}
}
