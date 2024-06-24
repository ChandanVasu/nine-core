<?php
/**
 * Date and Time Module
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Date_And_Time_Module extends \Elementor\Widget_Base {

    public function get_name() {
        return 'dateTime';
    }

    // Widget Title
    public function get_title() {
        return __('Date And Time', 'nine-core');
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-date';
    }

    // Widget Category
    public function get_categories() {
        return [sanitize_key(wp_get_theme()->get('Name')) . '-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'general_section',
            [
                'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );


        $this->add_control(
			'items_orientation',
			[
				'label' => esc_html__( 'Items Orientation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal'
					],
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-vertical'
					]
				],
				'default' => 'horizontal',
				'toggle' => false
			]
		);

        $this->add_responsive_control(
			'elements_align',
			[
				'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::CHOOSE,
				'options'   =>  [
					'left'  =>  [
						'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-left'
					],
					'center'    => [
						'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon'  =>  'eicon-text-align-center'
					],
					'right' =>  [
						'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon'  =>   'eicon-text-align-right'
					]
				],
				'default'   =>  'left',
				'toggle'    =>  false,
                'frontend_available' => true,
				'selectors' =>  [
					'{{WRAPPER}}'   =>  'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'separator_text',
            [
                'label' =>  esc_html__( 'Seperator', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  '/',
                'label_block'   =>  false
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_section',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => apply_filters( 'nekit_date_time_icon_condition_filter', [
                    'elements_align'    => 'pro'
                ])
            ]
        );

        $this->add_control(
            'show_date_time_icon',
            [
                'label' =>  esc_html__( 'Show date time icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  => 'yes',
                'default'   => 'yes'
            ]
        );

		$this->add_control(
			'date_time_icon',
			[
				'label' =>  esc_html__( 'Date Time Icon', 'news-kit-elementor-addons' ),
                'label_block'   => false,
				'type'  =>  \Elementor\Controls_Manager::ICONS,
				'skin'	=>  'inline',
                'recommended'	=> [
					'fa-solid'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass'],
					'fa-regular'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass']
				],
                'exclude_inline_options'    =>  'svg',
				'default'   =>    [
					'value' =>  'far fa-clock',
					'library'   =>  'fa-regular'
				]
			]
		);

        $this->add_responsive_control(
            'date_time_icon_size',
            [
                'label' =>  esc_html__( 'Icon Size', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>  [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  11
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   =>  'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'date_time_icon_distance',
            [
                'label' =>  esc_html__( 'Icon Distance', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'range' =>   [
                    'px'    =>  [
                        'min'   =>  0,
                        'max'   =>  1000,
                        'step'  =>  1
                    ]
                ], 
                'default'   =>  [
                    'unit'  =>  'px',
                    'size'  =>  4
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   =>  'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        
        $this->end_controls_section();

        $this->start_controls_section(
            'time_section',
            [
                'label' =>  esc_html__('Time', 'news-kit-elementor-addons'),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_time_count',
            [
                'label' =>  esc_html__( 'Show time', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'date_section',
            [
                'label' =>  esc_html__( 'Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_date_count',
            [
                'label' =>  esc_html__( 'Show date', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off' =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'date_format',
            [
                'label' =>  esc_html__( 'Date Format', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'M d, Y',
                'options'   => apply_filters( 'nekit_date_time_format_filter', [
                    'Y/m/d' =>  date('Y/m/d'),
                    'M d, Y'    =>  date('M d, Y')
                ])
            ]
        );

        $this->add_control(
			'date_position',
			[
				'label' =>  esc_html__( 'Date Position', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SELECT,
                'default'   =>  'after',
                'options'   =>  [
                    'after' =>  esc_html__( 'After', 'news-kit-elementor-addons' ),
                    'before'    =>  esc_html__( 'Before', 'news-kit-elementor-addons' )
                ]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'general_styles_section',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'date_time_background_color',
                'types'  =>  ['classic', 'gradient'],
                'exclude'   =>  ['image'],
                'selector'  => '{{WRAPPER}} .date-and-time-wrap'
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .date-and-time-wrap'
			]
		);

        $this->add_control(
            'border_radius',
            [
                'label' =>  esc_html__( 'Border Radius (px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  500,
                'step'  =>  1,
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'widget_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>   \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'custom' ],
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'widget_margin',
            [
                'label' =>  esc_html__('Margin', 'news-kit-elementor-addons'),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  ['px', '%', 'em', 'custom'],
                'selectors' =>  [
                    '{{WRAPPER}} .date-and-time-wrap'   =>  'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_icon_section',
            [
                'label' =>  esc_html__( 'Icon', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => apply_filters( 'nekit_date_time_icon_condition_filter', [
                    'elements_align'    => 'pro'
                ])
            ]
        );

        $this->add_control(
            'date_time_icon_color',
            [
                'label' =>  esc_html__( 'Icon Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' =>  [
                    '{{WRAPPER}} .date-time-icon'   => 'color : {{VALUE}}',
                    '{{WRAPPER}} .separator-icon i'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_time_section',
            [
                'label' =>  esc_html__( 'Time', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'name'  =>  'style_time_typography',
                'fields_options'    =>  [
                    'typography'    => [
                        'default'   =>    'custom'
                    ],
                    'font_family'   =>    [
                        'default'   =>  'Jost'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  13
                        ]
                    ],
                    'font_weight'   =>  [
                        'default'   =>  500
                    ]
                ],
                'selector'  =>   '{{WRAPPER}} .time-count'
            ]
        );

        $this->add_control(
            'time_color',
            [
                'label' =>  esc_html__( 'Time Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' =>  [
                    '{{WRAPPER}} .time-count'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'date_style_section',
            [
                'label' =>  esc_html__( 'Date', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' =>  esc_html__( 'Typography', 'news-kit-elementor-addons' ),
                'name'  =>  'date_typography',
                'fields_options'    =>  [
                    'typography'    => [
                        'default'   =>  'custom'
                    ],
                    'font_family'   =>  [
                        'default'   =>  'Jost'
                    ],
                    'font_size' =>  [
                        'default'   =>  [
                            'unit'  =>  'px',
                            'size'  =>  13
                        ]
                    ],
                    'font_weight'   =>  [
                        'default'   =>  500
                    ]
                ],
                'selector' => '{{WRAPPER}} .date-count'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' =>  esc_html__( 'Date color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#8A8A8C',
                'selectors' => [
                    '{{WRAPPER}} .date-count, {{WRAPPER}} .date-and-time-wrap .separator'   => 'color : {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();
    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        $current_time = current_time('timestamp');
        $date_format = !empty($settings['date_format']) ? $settings['date_format'] : 'M d, Y';

        $time_html = '';
        if ('yes' === $settings['show_time_count']) {
            $time_html = '<span class="time-count">' . date_i18n('h:i A', $current_time) . '</span>';
        }

        $date_html = '';
        if ('yes' === $settings['show_date_count']) {
            $date_html = '<span class="date-count">' . date_i18n($date_format, $current_time) . '</span>';
        }

        $icon_html = '';
        if ('yes' === $settings['show_date_time_icon'] && !empty($settings['date_time_icon']['value'])) {
            $icon_html = '<i class="date-time-icon ' . esc_attr($settings['date_time_icon']['value']) . '"></i>';
        }

        $separator = !empty($settings['separator_text']) ? '<span class="separator-text">' . esc_html($settings['separator_text']) . '</span>' : '';

        $date_position_class = 'date-time-wrap';
        if ('before' === $settings['date_position']) {
            $date_position_class .= ' nekit-date-before';
        }

        ?>
        <div class="<?php echo esc_attr($date_position_class); ?>">
            <?php echo $icon_html; ?>
            <?php echo $time_html . $separator . $date_html; ?>
        </div>
        <?php
    }


}

