<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class CubePortfolio_Widget extends Widget_Base {
    public function get_name() { return 'soda_cubeportfolio'; }
    public function get_title() { return esc_html__('Soda CubePortfolio', 'soda-elementor-addons'); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return ['soda-addons']; }
            public function get_style_depends() { return [ 'cubeportfolio-css' ]; }
            public function get_script_depends() { return [ 'cubeportfolio-js' ]; }

            protected function register_controls() {
                // Layout Section
                $this->start_controls_section('section_layout', [
                    'label' => esc_html__('Layout', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('portfolio_layout', [
                    'label' => esc_html__('Layout', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'grid',
                    'options' => [
                        'grid' => esc_html__('Grid', 'cubeportfolio-elementor-widget'),
                        'masonry' => esc_html__('Masonry', 'cubeportfolio-elementor-widget'),
                        'landscape' => esc_html__('Landscape', 'cubeportfolio-elementor-widget'),
                        'mosaic' => esc_html__('Mosaic', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                $this->add_responsive_control('portfolio_columns', [
                    'label' => esc_html__('Columns', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                        '5' => '5', '6' => '6', '7' => '7', '8' => '8',
                    ],
                ]);
                $this->end_controls_section();

                // Mosaic pattern for user
                $this->start_controls_section('section_mosaic_pattern', [
                    'label' => esc_html__('Mosaic Pattern', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'condition' => ['portfolio_layout' => 'mosaic'],
                ]);
                $repeater = new \Elementor\Repeater();
                $repeater->add_control('cell_width', [
                    'label' => esc_html__('Cell Width', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 12,
                    'default' => 1,
                ]);
                $repeater->add_control('cell_height', [
                    'label' => esc_html__('Cell Height', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 12,
                    'default' => 1,
                ]);
                $this->add_control('mosaic_pattern', [
                    'label' => esc_html__('Mosaic Grid Cells', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [ 'cell_width' => 4, 'cell_height' => 2 ],
                        [ 'cell_width' => 1, 'cell_height' => 1 ],
                        [ 'cell_width' => 1, 'cell_height' => 1 ],
                        [ 'cell_width' => 2, 'cell_height' => 1 ],
                    ],
                    'title_field' => 'Cell: {cell_width} x {cell_height}',
                    'condition' => ['portfolio_layout' => 'mosaic'],
                ]);
                $this->end_controls_section();

                // Thumbnail Appearance Section
                $this->start_controls_section('section_thumbnail_appearance', [
                    'label' => esc_html__('Thumbnail Appearance', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('show_title', [
                    'label' => esc_html__('Show Title', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'cubeportfolio-elementor-widget'),
                    'label_off' => esc_html__('No', 'cubeportfolio-elementor-widget'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]);
                $this->add_control('show_subtitle', [
                    'label' => esc_html__('Show Sub Title', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'cubeportfolio-elementor-widget'),
                    'label_off' => esc_html__('No', 'cubeportfolio-elementor-widget'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]);
                $this->add_control('content_position', [
                    'label' => esc_html__( 'Content position', 'cubeportfolio-elementor-widget' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'content-under-img',
                    'options' => [
                        'content-under-img' => esc_html__( 'Content Under Image', 'cubeportfolio-elementor-widget' ),
                        'content-overlay'   => esc_html__( 'Content Overlay', 'cubeportfolio-elementor-widget' ),
                    ],
                ]);
                $this->add_control('overlay_caption_animation', [
                    'label' => esc_html__( 'Hover Effect', 'cubeportfolio-elementor-widget' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'default-effect',
                    'options' => [
                        'default-effect' => esc_html__('Default', 'cubeportfolio-elementor-widget'),
                        'boxed-effect'   => esc_html__('Boxed', 'cubeportfolio-elementor-widget'),
                        'ribbon-effect'  => esc_html__('Ribbon', 'cubeportfolio-elementor-widget'),
                    ],
                    'condition' => [ 'content_position' => 'content-overlay' ],
                ]);
                $this->add_control('under_image_caption_animation', [
                    'label' => esc_html__('Hover Effect', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'zoom-effect',
                    'options' => [
                        'no-effect' => esc_html__('None', 'cubeportfolio-elementor-widget'),
                        'zoom-effect' => esc_html__('Zoom', 'cubeportfolio-elementor-widget'),
                    ],
                    'condition' => [ 'content_position' => 'content-under-img' ],
                ]);
                $this->add_control('content_alignment', [
                    'label' => esc_html__('Content alignment', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'default' => 'center',
                    'options' => [
                        'left'      => ['title' => esc_html__('Left', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-left'],
                        'center'    => ['title' => esc_html__('Center', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-center'],
                        'right'     => ['title' => esc_html__('Right', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-right'],
                        'justified' => ['title' => esc_html__('Justified', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-justify'],
                    ],
                    'condition' => [ 'overlay_caption_animation!' => 'ribbon-effect' ],
                ]);
                $this->add_responsive_control('horizontal_space', [
                    'label' => esc_html__('Rows Gap', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => ['size' => 30],
                    'range' => ['px' => ['min' => 0, 'max' => 100]],
                ]);
                $this->add_responsive_control('vertical_space', [
                    'label' => esc_html__('Columns Gap', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => ['size' => 30],
                    'range' => ['px' => ['min' => 0, 'max' => 100]],
                ]);
                $this->end_controls_section();

                // Animation Section
                $this->start_controls_section('layout_animation_section', [
                    'label' => esc_html__('Animation', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('filters_animation', [
                    'label' => esc_html__('Filters Animation', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'fade',
                    'options' => [
                        'fade' => esc_html__('Fade', 'cubeportfolio-elementor-widget'),
                        'slideLeft' => esc_html__('Slide Left', 'cubeportfolio-elementor-widget'),
                        'slideDelay' => esc_html__('Slide Delay', 'cubeportfolio-elementor-widget'),
                        'unfold' => esc_html__('Unfold', 'cubeportfolio-elementor-widget'),
                        'scaleDown' => esc_html__('Scale Down', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                $this->end_controls_section();

                // QUERY Section
                $this->start_controls_section('query_section', [
                    'label' => esc_html__('Query', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('posts_per_page', [
                    'label' => esc_html__('Items to show', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 12,
                ]);
                $this->add_control('orderby', [
                    'label' => esc_html__('Order By', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date' => esc_html__('Date', 'cubeportfolio-elementor-widget'),
                        'title' => esc_html__('Title', 'cubeportfolio-elementor-widget'),
                        'rand' => esc_html__('Random', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                $this->add_control('order', [
                    'label' => esc_html__('Order', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'ASC' => esc_html__('Ascending', 'cubeportfolio-elementor-widget'),
                        'DESC' => esc_html__('Descending', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                $this->end_controls_section();

                // NUEVA SECCION: Estilos para filtro del menú
                $this->start_controls_section('section_filters_style', [
                    'label' => esc_html__('Filtros - Estilos', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'filters_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item',
                    ]
                );
                $this->add_control('filters_color', [
                    'label'     => esc_html__('Color de texto', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_bg_color', [
                    'label'     => esc_html__('Color de fondo', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Border::get_type(),
                    [
                        'name' => 'filters_border',
                        'selector' => '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item',
                    ]
                );
                $this->add_responsive_control('filters_padding', [
                    'label'     => esc_html__('Padding', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'=> ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_control('filters_hover_color', [
                    'label'     => esc_html__('Color texto (Hover)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item:hover' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_hover_bg_color', [
                    'label'     => esc_html__('Fondo (Hover)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item:hover' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_active_color', [
                    'label'     => esc_html__('Color texto (Activo)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item-active' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_active_bg_color', [
                    'label'     => esc_html__('Fondo (Activo)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item-active' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->end_controls_section();

                // Title Style Section
                $this->start_controls_section('section_title_style', [
                    'label' => esc_html__('Title Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'title_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-grid-projects-title',
                    ]
                );
                $this->end_controls_section();

                // Subtitle Style Section
                $this->start_controls_section('section_subtitle_style', [
                    'label' => esc_html__('Subtitle Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'subtitle_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-grid-projects-desc',
                    ]
                );
                $this->end_controls_section();
            }

            protected function render() {
                $settings = $this->get_settings_for_display();
                $widget_id = 'cubeportfolio-' . $this->get_id();

                $plugin_url = plugin_dir_url(__FILE__);
                wp_enqueue_style('cubeportfolio-css', $plugin_url . 'assets/cubeportfolio.min.css', [], '4.5.0');
                wp_enqueue_script('cubeportfolio-js', $plugin_url . 'assets/jquery.cubeportfolio.min.js', ['jquery'], '4.5.0', true);

                // Get Categories
                $categories = get_terms([
                    'taxonomy' => 'portfolio_category',
                    'hide_empty' => true,
                ]);
                echo '<div class="cubeportfolio-widget-container">';
                if (!empty($categories) && !is_wp_error($categories)) {
                    echo '<div id="filters-' . esc_attr($widget_id) . '" class="cbp-l-filters-button">';
                    echo '<div data-filter="*" class="cbp-filter-item-active cbp-filter-item">' . esc_html__('All', 'cubeportfolio-elementor-widget') . '<div class="cbp-filter-counter"></div></div>';
                    foreach ($categories as $cat) {
                        echo '<div data-filter=".' . esc_attr($cat->slug) . '" class="cbp-filter-item">';
                        echo esc_html($cat->name) . '<div class="cbp-filter-counter"></div></div>';
                    }
                    echo '</div>';
                }
                echo '<div id="' . esc_attr($widget_id) . '" class="cubeportfolio-elementor-widget">';

                // QUERY OBJECT FIX (Your fatal error)
                $args = [
                    'post_type' => 'portfolio',
                    'posts_per_page' => isset($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12,
                    'post_status' => 'publish',
                    'orderby' => isset($settings['orderby']) ? sanitize_text_field($settings['orderby']) : 'date',
                    'order' => isset($settings['order']) ? sanitize_text_field($settings['order']) : 'DESC',
                ];
                $query = new WP_Query($args);

                // Build Mosaic cells (for both attributes and JS)
                $mosaic_cells = [];
                $max_width = 1;
                if ($settings['portfolio_layout'] === 'mosaic' && !empty($settings['mosaic_pattern'])) {
                    foreach ($settings['mosaic_pattern'] as $cell) {
                        $w = !empty($cell['cell_width']) ? intval($cell['cell_width']) : 1;
                        $h = !empty($cell['cell_height']) ? intval($cell['cell_height']) : 1;
                        if ($w > $max_width) $max_width = $w;
                        $mosaic_cells[] = [ 'width' => $w, 'height' => $h ];
                    }
                }

                // Output items, giving each mosaic cell the right attributes
                $item_index = 0;
                $pattern_count = count($mosaic_cells);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $item_terms = get_the_terms(get_the_ID(), 'portfolio_category');
                        $desc_names = [];
                        $slug_classes = [];
                        if ($item_terms && !is_wp_error($item_terms)) {
                            foreach ($item_terms as $term) {
                                $desc_names[] = $term->name;
                                $slug_classes[] = $term->slug;
                            }
                        }
                        // Assign mosaic cell for this item (cycle pattern if not enough)
                        $cell = ['width' => 1, 'height' => 1];
                        if ($settings['portfolio_layout'] === 'mosaic' && $pattern_count) {
                            $cell = $mosaic_cells[$item_index % $pattern_count];
                        }
                        ?>
                        <div class="cbp-item <?php echo esc_attr(implode(' ', $slug_classes)); ?>"
                            <?php if ($settings['portfolio_layout'] === 'mosaic') : ?>
                                data-cbp-mosaic-width="<?php echo esc_attr($cell['width']); ?>"
                                data-cbp-mosaic-height="<?php echo esc_attr($cell['height']); ?>"
                            <?php endif; ?>
                        >
                            <div class="cbp-item-wrapper">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="cbp-caption" target="_blank">
                                    <div class="cbp-caption-defaultWrap">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>">
                                    </div>
                                    <div class="cbp-caption-activeWrap"></div>
                                </a>
                                <?php if (!empty($settings['show_title']) && $settings['show_title'] == 'yes'): ?>
                                    <div class="cbp-l-grid-projects-title"><?php the_title(); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($desc_names) && !empty($settings['show_subtitle']) && $settings['show_subtitle'] == 'yes'): ?>
                                    <div class="cbp-l-grid-projects-desc"><?php echo esc_html(implode(' / ', $desc_names)); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        ++$item_index;
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>' . esc_html__('No portfolio items found.', 'cubeportfolio-elementor-widget') . '</p>';
                endif;
                echo '</div></div>';

                $horizontal_gap = isset($settings['horizontal_space']['size']) ? intval($settings['horizontal_space']['size']) : 20;
                $vertical_gap = isset($settings['vertical_space']['size']) ? intval($settings['vertical_space']['size']) : 20;
                $portfolio_columns = ($settings['portfolio_layout'] === 'mosaic' && $max_width) ? $max_width : (
                    isset($settings['portfolio_columns']) ? intval($settings['portfolio_columns']) : 3
                );

                ?>
                <script>
                jQuery(document).ready(function($){
                    $('#<?php echo esc_js($widget_id); ?>').cubeportfolio({
                        filters: '#filters-<?php echo esc_js($widget_id); ?>',
                        layoutMode: '<?php echo esc_js($settings['portfolio_layout']); ?>',
                        defaultFilter: '*',
                        animationType: '<?php echo esc_js($settings['filters_animation']); ?>',
                        gapHorizontal: <?php echo $horizontal_gap; ?>,
                        gapVertical: <?php echo $vertical_gap; ?>,
                        gridAdjustment: 'responsive',
                        <?php if ($settings['portfolio_layout'] === 'mosaic' && !empty($mosaic_cells)): ?>
                        mosaic: <?php echo json_encode($mosaic_cells); ?>,
                        <?php endif; ?>
                        mediaQueries: [
                            { width: 1200, cols: <?php echo $portfolio_columns; ?> }
                        ]
                    });
                });
                </script>
                <?php
        }
}