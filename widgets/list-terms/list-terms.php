<?php

namespace Braine\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) {
    exit;
}

class ListTerms_Braine extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('braine-list-terms', plugins_url('/assets/css/list-terms.css', __FILE__), ['elementor-frontend']);
    }

    public function get_style_depends() {
        return ['braine-list-terms'];
    }

    public function get_name() {
        return 'braine-list-terms';
    }

    public function get_title() {
        return 'Lista de Termos';
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return ['braine'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'configuration_section',
            [
                'label' => __('Configurações', 'list-terms-braine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Get all public post types as object
        $get_post_types = get_post_types(
            [
                'public' => true
            ],
            'names'
        );

        // Format array for get_object_taxonomies
        $formated_for_get_object_taxonomies = [];
        foreach($get_post_types as $current_taxonomy):
            $formated_for_get_object_taxonomies[] = $current_taxonomy;
        endforeach;

        $get_taxonomies = get_object_taxonomies($formated_for_get_object_taxonomies, 'objects');

        // Format array for Elementor Control
        $formated_for_elementor = [];
        foreach($get_taxonomies as $current_taxonomy):
            $formated_for_elementor[$current_taxonomy->name] = "{$current_taxonomy->labels->name} - {$current_taxonomy->name}";
        endforeach;

        $this->add_control(
            'selected_taxonomy',
            [
                'label' => __('Tipo de Taxonomia', 'list-terms-braine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => array_key_first($formated_for_elementor),
                'options' => $formated_for_elementor,
            ]
        );

        $default_icon = [
            'value' => 'far fa-check-circle',
            'library' => 'fa-regular',
        ];

        $this->add_control(
            'selected_item_icon',
            [
                'label' => __('Ícone antes do Item', 'elementor-pro'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'item_icon',
                'default' => $default_icon,
            ]
        );

        $this->end_controls_section();

        // Icon Style
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __('Ícone', 'elementor-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_icon_color',
            [
                'label' => __('Icon Color', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item i.braine-list-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .braine-list-terms .braine-list-item svg.braine-list-icon' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_icon_spacing',
            [
                'label' => __('Spacing', 'elementor-pro'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 15,
                    ],
                ],
                'condition' => [
                    'list_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item .braine-list-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Styles

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Item da Lista', 'elementor-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'list_item_padding',
            [
                'label' => __('Padding', 'elementor-pro'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'item_gap',
            [
                'label' => __('Gap', 'elementor-pro'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'divisor_padding_link_color',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->start_controls_tabs('link_item_style_color');

        $this->start_controls_tab(
            'list_item_link',
            [
                'label' => __('Normal', 'elementor-pro'),
            ]
        );

        $this->add_control(
            'list_item_color',
            [
                'label' => __('Item Color', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_list_item_color',
            [
                'label' => __('Background', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0c0c0c',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_item_link_hover',
            [
                'label' => __('Hover', 'elementor-pro'),
            ]
        );

        $this->add_control(
            'hover_list_item_color',
            [
                'label' => __('Hover Item Color', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_background_list_item_color',
            [
                'label' => __('Hover Background', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#202020',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_item_link_active',
            [
                'label' => __('Active', 'elementor-pro'),

            ]
        );

        $this->add_control(
            'current_list_item_color',
            [
                'label' => __('Active Item Color', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item.current-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_background_list_item_color',
            [
                'label' => __('Active Item Background', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#202020',
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item.current-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'divisor_link_color_typography',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'list_item_typography',

                'selector' => '{{WRAPPER}} .braine-list-terms .braine-list-item a',

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'active_list_item_typography',
                'label' => __('Active Typography', 'elementor-pro'),
                'selector' => '{{WRAPPER}} .braine-list-terms .braine-list-item.current-item a',
            ]
        );

        $this->add_control(
            'divisor_typography_divisor',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'list_divider',
            [
                'label' => __('Divider', 'elementor-pro'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label' => __('Style', 'elementor-pro'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => __('Solid', 'elementor-pro'),
                    'double' => __('Double', 'elementor-pro'),
                    'dotted' => __('Dotted', 'elementor-pro'),
                    'dashed' => __('Dashed', 'elementor-pro'),
                ],
                'default' => 'solid',
                'condition' => [
                    'list_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item' => 'border-bottom-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => __('Color', 'elementor-pro'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'list_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_weight',
            [
                'label' => __('Weight', 'elementor-pro'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'condition' => [
                    'list_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .braine-list-terms .braine-list-item' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id_element = $this->get_id();

        $get_posts_by_taxonomy = get_terms([
            'taxonomy' => $settings['selected_taxonomy']
        ]);

        if(count($get_posts_by_taxonomy) > 0):

            echo "<ul class='id-{$id_element} braine-list-terms'>";
            foreach($get_posts_by_taxonomy as $category_by_taxonomy):
                global $wp;

                $category_link = get_category_link($category_by_taxonomy->term_id);

                // Add class on current item
                $current_item = home_url(add_query_arg([], $wp->request)) . "/" == $category_link ? 'current-item' : '';

                echo "<li class='{$current_item} braine-list-item'><a href='" . $category_link . "' title='" . get_the_title() . "'>";
                if($settings['selected_item_icon']):
                    Icons_Manager::render_icon($settings['selected_item_icon'], ['aria-hidden' => 'true', 'class' => 'braine-list-icon']);
                endif;
                echo $category_by_taxonomy->name;
                echo "</a></li>";

                // Reset Post Data for prevent bugs
                wp_reset_postdata();
            endforeach;
            echo "</ul>";
        else:
            echo __('Nenhum post cadastrado', 'list-terms-braine');
        endif;
    }
}
