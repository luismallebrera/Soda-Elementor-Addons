<?php
namespace SODA\Widgets;
// Make sure Elementor is loaded
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Soda_Portfolio_Grid extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'soda-portfolio-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Soda Portfolio Grid', 'soda-plugin' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-justified';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	 public function get_categories() {
 	    return [ 'basic' ];
 	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'soda-plugin' ),
			]
		);

		$this->add_control(
			'enable_filter',
			[
				'label' => __( 'Portfolio Filter', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'st1' => 'Disable',
					'st2' => 'Enable',
				],
				'default' => 'st1',
				'label_block' => true,
			]
		);

		$this->add_control(
			'enable_filter_style',
			[
				'label' => __( 'Filter Style', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'st1' => 'Button',
					'st2' => 'Inline',
				],
				'default' => 'st1',
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'enable_filter_position',
			[
				'label' => __( 'Filter Position', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-cat-fixed-off' => 'Default',
					'ttgr-cat-fixed' => 'Fixed',
				],
				'default' => 'ttgr-cat-fixed-off',
				'label_block' => true,
				'condition' => [
					'enable_filter_style' => 'st1',
				],
			]
		);

		$this->add_control(
			'filter_alt_button',
			[
				'label' => esc_html__( 'Alternative Layout', 'soda-plugin' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'soda-plugin' ),
				'label_off' => esc_html__( 'Off', 'soda-plugin' ),
				'return_value' => 'yes',
				'default' => 'off',
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'enable_filter_position_inline',
			[
				'label' => __( 'Filter Position', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-cat-classic-center-off' => 'Default',
					'ttgr-cat-classic-center' => 'Center',
				],
				'default' => 'ttgr-cat-classic-center-off',
				'label_block' => true,
				'condition' => [
					'enable_filter_style' => 'st2',
				],
			]
		);

		$this->add_control(
			'port_filter_cat_count', [
				'label' => __( 'Number of categories to show', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Number of categories to show in portfolio filter list. e.x: 5', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'port_filter_cat_exclude', [
				'label' => __( 'Exclude Category', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Exclude category from the filter list by the category ID e.x: 6 <br>For multiple catogries ID e.x: 6 7', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'categoryname_exclude', [
				'label' => __( 'Exclude Category Information', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Exclude category information from the post info by the category ID e.x: 6 <br>For multiple categories ID e.x: 6 7', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st1',
				],
			]
		);

		$this->add_control(
			'separator_content_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'postcount', [
				'label' => __( 'Number of posts to show', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Optional.', 'soda-plugin' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'postoffset', [
				'label' => __( 'Post Offset', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Optional.', 'soda-plugin' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'in_post_id', [
				'label' => __( 'Include Post ID', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( '(Optional) Insert post ID to show selected  posts. e.x: 1,2', 'soda-plugin' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'categoryname', [
				'label' => __( 'Include Category', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '' , 'soda-plugin' ),
				'description' => __( 'Display posts by category name. e.x photography.', 'soda-plugin' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'separator_tr_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'text1', [
				'label' => __( 'All', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'All' , 'soda-plugin' ),
				'description' => __( 'Translet Option.', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'text2', [
				'label' => __( 'Close', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Close' , 'soda-plugin' ),
				'description' => __( 'Translet Option.', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'text5', [
				'label' => __( 'Open', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Open' , 'soda-plugin' ),
				'description' => __( 'Translet Option.', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'text3', [
				'label' => __( 'Filter', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Filter' , 'soda-plugin' ),
				'description' => __( 'Translet Option.', 'soda-plugin' ),
				'label_block' => true,
				'condition' => [
					'enable_filter' => 'st2',
				],
			]
		);

		$this->add_control(
			'text4', [
				'label' => __( 'View Project', 'soda-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'View[br]Project' , 'soda-plugin' ),
				'description' => __( 'Translet Option.<br> e.x:View[br]Project', 'soda-plugin' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_portfolio_style',
			[
				'label' => __( 'Portfolio Styles', 'soda-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'port_grid_layout',
			[
				'label' => __( 'Layout', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'st1' => 'Grid Modern',
					'st2' => 'Grid Classic',
					'st3' => 'Grid Creative v.1',
					'st4' => 'Grid Creative v.2',
					'st5' => 'Portrait Mode',
				],
				'default' => 'st1',
				'label_block' => true,
			]
		);

		$this->add_control(
			'port_grid_column_portrait_half',
			[
				'label' => __( 'Portrait Option', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-portrait' => 'Full Portrait',
					'ttgr-portrait-half' => 'Half Portrait',
				],
				'default' => 'ttgr-portrait',
				'label_block' => true,
				'condition' =>  ['port_grid_layout' => ['st5']],
			]
		);

		$this->add_control(
			'port_grid_column_shifted',
			[
				'label' => __( 'Shifted Layout', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-shifted-off' => 'Disable',
					'ttgr-shifted' => 'Enable',
				],
				'default' => 'ttgr-shifted-off',
				'label_block' => true,
				'condition' =>  ['port_grid_layout' => ['st2', 'st5']],
			]
		);

		$this->add_control(
			'port_grid_column_modern',
			[
				'label' => __( 'Grid Mixed Column', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-layout-1-2' => 'Layout 1-2',
					'ttgr-layout-2-1' => 'Layout 2-1',
					'ttgr-layout-2-3' => 'Layout 2-3',
					'ttgr-layout-3-2' => 'Layout 3-2',
					'ttgr-layout-3-4' => 'Layout 3-4',
					'ttgr-layout-4-3' => 'Layout 4-3',
				],
				'default' => 'ttgr-layout-1-2',
				'label_block' => true,
				'condition' => [
					'port_grid_layout' => 'st1',
				],
			]
		);

		$this->add_control(
			'port_grid_column',
			[
				'label' => __( 'Grid Column', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-layouts-1' => '1 Column',
					'ttgr-layout-2' => '2 Column',
					'ttgr-layout-3' => '3 Column',
					'ttgr-layout-4' => '4 Column',
				],
				'default' => 'ttgr-layouts-1',
				'label_block' => true,
				'condition' =>  ['port_grid_layout' => ['st2', 'st5']],
			]
		);

		$this->add_control(
			'port_grid_image_cropp',
			[
				'label' => __( 'Image Cropping', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-not-cropped' => 'Disable',
					'ttgr-cropped' => 'Enable',
				],
				'default' => 'ttgr-not-cropped',
				'label_block' => true,
				'condition' =>  ['port_grid_layout' => ['st2']],
			]
		);

		$this->add_control(
			'cap_po_opt',
			[
				'label' => __( 'Caption Position', 'soda-plugin' ),
				'description' => __( '', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'pgi-cap-inside' => 'Inside Image',
					'pgi-cap-inside pgi-cap-center' => 'Inside Image Center',
					'pgi_cap_outside' => 'Outside Image',
					'pgi_cap_outside pgi-cap-center' => 'Outside Image Center',
				],
				'default' => 'pgi-cap-inside',
				'label_block' => true,
			]
		);

		$this->add_control(
			'img_hover_opt',
			[
				'label' => __( 'Image Hover Effect', 'soda-plugin' ),
				'description' => __( 'Enable/ Disable image hover effect.<br> Behavior depends on block gap.', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'pgi-hover-off' => 'Disable',
					'pgi-hover' => 'Enable',
				],
				'default' => 'pgi-hover-off',
				'label_block' => true,
			]
		);


		$this->add_control(
			'block_gap',
			[
				'label' => __( 'Block Gap', 'soda-plugin' ),
				'description' => __( 'Add space between portfolio items.', 'soda-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ttgr-gap-1' => 'Gap 1',
					'ttgr-gap-2' => 'Gap 2',
					'ttgr-gap-3' => 'Gap 3',
					'ttgr-gap-4' => 'Gap 4',
					'ttgr-gap-5' => 'Gap 5',
					'ttgr-gap-6' => 'Gap 6',
					'ttgr-gap-0' => 'Gap 0',
				],
				'default' => 'ttgr-gap-1',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_filter_nav',
			[
				'label' => __( 'Filter Navigation', 'soda-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_filter_style' => 'st1',
				],
			]
		);

		$this->add_control(
			'filter_nav_item',
			[
				'label' => __( 'Filter Navigation Item', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.ttgr-cat-list > li > a' => 'color: {{VALUE}};',
					'.ttgr-cat-list .ttgr-cat-item::before' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_hover_color',
			[
				'label' => __( 'Filter Navigation Item Hover/ Active', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.ttgr-cat-list > li > a:hover, .ttgr-cat-list > li > a:focus, .ttgr-cat-list > li > a.active' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_hover_rev',
			[
				'label' => __( 'Filter Navigation Item Reveal Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body:not(is-mobile) .ttgr-cat-item > a' => '-webkit-text-fill-color: {{VALUE}}!important;',
				],
				'default' =>'',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Filter Navigation Typography', 'soda-plugin' ),
				'name' => 'nav_item_typography',
				'selector' => '.ttgr-cat-list > li > a, .ttgr-cat-item',
			]
		);

		$this->add_control(
			'filter_nav_ft_bt_color',
			[
				'label' => __( 'Filter Button Background', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body .ttgr-cat-trigger-wrap.ttgr-cat-fixed .ttgr-cat-trigger' => 'background: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_ft_bttxt_color',
			[
				'label' => __( 'Filter Button Text Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body .ttgr-cat-trigger-wrap.ttgr-cat-fixed .ttgr-cat-trigger' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Filter Button Typography', 'soda-plugin' ),
				'name' => 'filter_nav_ft_bttxt_typography',
				'selector' => 'body .ttgr-cat-trigger-wrap.ttgr-cat-fixed .ttgr-cat-trigger',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_filter_nav_inline',
			[
				'label' => __( 'Filter Navigation', 'soda-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_filter_style' => 'st2',
				],
			]
		);

		$this->add_control(
			'filter_nav_item_inline',
			[
				'label' => __( 'Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ttgr-cat-classic-list > li > a' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_hover_color_inline',
			[
				'label' => __( 'Color Hover/ Active', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ttgr-cat-classic-list > li > a:hover, {{WRAPPER}} ul.ttgr-cat-classic-list > li > a.active' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_item_back_inline',
			[
				'label' => __( 'Background Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ttgr-cat-classic-list > li > a' => 'background-color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_control(
			'filter_nav_item_back_active_inline',
			[
				'label' => __( 'Background Color Active/ Hover', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.ttgr-cat-classic-list > li > a:hover, {{WRAPPER}} ul.ttgr-cat-classic-list > li > a.active' => 'background-color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_item_typography_inline',
				'selector' => '{{WRAPPER}} ul.ttgr-cat-classic-list > li > a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'port_item',
			[
				'label' => __( 'Portfolio Items', 'soda-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'port_colors' );

		$this->start_controls_tab(
			'title_colors_normal',
			[
				'label' => esc_html__( 'Title', 'soda-plugin' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #portfolio-grid .pgi-title a' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} #portfolio-grid .pgi-title a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cat_colorss',
			[
				'label' => esc_html__( 'Categories', 'soda-plugin' ),
			]
		);

		$this->add_control(
			'cat_title_color',
			[
				'label' => __( 'Color', 'soda-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #portfolio-grid .pgi-category a' => 'color: {{VALUE}};',
				],
				'default' =>'',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cat_title_typography',
				'selector' => '{{WRAPPER}} #portfolio-grid .pgi-category a',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
protected function render() {
	$settings = $this->get_settings();
?>
<?php
//layout condition start
$port_layout='';
if( $settings['port_grid_layout'] == 'st2' ) {
	$port_layout=''.esc_attr($settings['port_grid_column']).' '.esc_attr($settings['port_grid_image_cropp']).' '.esc_attr($settings['port_grid_column_shifted']).'';
}
else if( $settings['port_grid_layout'] == 'st3' ) {
	$port_layout='ttgr-layout-creative-1 ';
}
else if( $settings['port_grid_layout'] == 'st4' ) {
	$port_layout='ttgr-layout-creative-2 ';
}
else if( $settings['port_grid_layout'] == 'st5' ) {
	$port_layout='  '.esc_attr($settings['port_grid_column']).' '.esc_attr($settings['port_grid_column_shifted']).'  '.esc_attr($settings['port_grid_column_portrait_half']).' ';
}
else {
	$port_layout=''.esc_attr($settings['port_grid_column_modern']).' ';
}
//layout condition start
?>
<div id="portfolio-grid" class="<?php echo esc_attr($settings['cap_po_opt']); ?> <?php echo esc_attr($settings['img_hover_opt']); ?> ">

	<div class="tt-grid <?php echo ($port_layout);?> <?php echo esc_attr($settings['block_gap']); ?>">
		<?php
		//filter start
		if( $settings['enable_filter'] == 'st2' ) { ?>
		<?php
		if(!get_post_meta(get_the_ID(), 'portfolio_category', true)) {
		$portfolio_category = get_terms('portfolio_category', array('exclude' => $settings['port_filter_cat_exclude'], 'number'=>$settings['port_filter_cat_count']));
		if($portfolio_category){
		?>
		<!-- Begin tt-Ggrid top content
		================================ -->
		<div class="tt-grid-top">

			<?php
			//filter style
			if( $settings['enable_filter_style'] == 'st1' ) { ?>
			<!-- Begin tt-Ggrid categories/filter
			====================================== -->
			<div class="tt-grid-categories">

				<!-- Begin tt-Ggrid categories trigger
				=======================================
				* Use class "ttgr-cat-fixed" to enable categories trigger fixed position.
				* Use class "ttgr-cat-colored" to enable categories trigger colored style.
				-->
				<div class="ttgr-cat-trigger-wrap <?php if ( 'yes' === $settings['filter_alt_button'] ) { ?>ttgr-cat-colored<?php };?> <?php echo esc_attr($settings['enable_filter_position']); ?>">
					<div class="ttgr-cat-trigger-holder">
						<a href="#portfolio-grid" class="ttgr-cat-trigger" data-offset="150">
							<div class="ttgr-cat-text hide-cursor">
								<span data-hover="<?php echo esc_attr($settings['text5']); ?>"><?php echo esc_html($settings['text3']); ?></span>
							</div>
						</a> <!-- /.ttgr-cat-trigger -->
					</div> <!-- /.ttgr-cat-trigger-holder -->
				</div>
				<!-- End tt-Ggrid categories trigger -->

				<!-- Begin tt-Ggrid categories nav
				=================================== -->
				<div class="ttgr-cat-nav">
					<div class="ttgr-cat-close-btn"><?php echo esc_html($settings['text2']); ?> <i class="fas fa-times"></i></div> <!-- For mobile devices! -->
					<div class="ttgr-cat-list-holder cursor-close" data-lenis-prevent>
						<div class="ttgr-cat-list-inner">
							<div class="ttgr-cat-list-content">
								<ul class="ttgr-cat-list hide-cursor">
									<li class="ttgr-cat-item"><a href="#" class="active"><?php echo esc_html($settings['text1']); ?></a></li>
									<?php foreach($portfolio_category as $portfolio_cat) { ?>
									<li class="ttgr-cat-item"><a href="#portfolio-grid" data-offset="80" data-filter=".<?php echo esc_attr($portfolio_cat->slug);?>"><?php echo esc_html($portfolio_cat->name);?></a></li>
									<?php };?>
								</ul>
							</div> <!-- /.ttgr-cat-links-content -->
						</div> <!-- /.ttgr-cat-links-inner -->
					</div> <!-- /.ttgr-cat-links-holder -->
				</div>
				<!-- End tt-Ggrid categories nav -->
			</div>
			<!-- End tt-Ggrid categories/filter-->
			<?php } else { ?>
			<!-- Begin tt-Ggrid categories/filter classic
			============================================== -->
			<div class="tt-grid-categories-classic ">

				<!-- Begin tt-Ggrid categories
				===============================
				* Use class "ttgr-cat-classic-center" or "ttgr-cat-classic-right" to align categories (no effect on small screens!). No claa = align left.
				* Use class "ttgr-cat-classic-colored" to enable colored style.
				-->
				<div class="ttgr-cat-classic-nav <?php if ( 'yes' === $settings['filter_alt_button'] ) { ?>ttgr-cat-classic-colored<?php };?> <?php echo esc_attr($settings['enable_filter_position_inline']); ?>">
					<ul class="ttgr-cat-classic-list">
						<li class="ttgr-cat-classic-item"><a href="#portfolio-grid" data-offset="80" class="active"><?php echo esc_html($settings['text1']); ?></a></li>
						<?php foreach($portfolio_category as $portfolio_cat) { ?>
						<li class="ttgr-cat-classic-item"><a href="#portfolio-grid" data-offset="80" data-filter=".<?php echo esc_attr($portfolio_cat->slug);?>"><?php echo esc_html($portfolio_cat->name);?></a></li>
						<?php };?>
					</ul>
				</div>
				<!-- End tt-Ggrid categories-->

			</div>
			<!-- End tt-Ggrid categories/filter classic -->
			<?php } ?>

		</div>
		<!-- End tt-Grid top content -->
		<?php } } };?>

		<!-- Begin tt-Grid items wrap
		============================== -->
		<div class="tt-grid-items-wrap isotope-items-wrap">

			<?php
			global $post, $port_grid_sl_id;
			if ( $settings['in_post_id'] ) {
				$port_grid_sl_id= explode( ',', $settings['in_post_id'] );
			}
			$paged=(get_query_var('paged'))?get_query_var('paged'):1;
			$loop = new \WP_Query( array( 'post_type' => 'portfolio','portfolio_category'=> $settings['categoryname'], 'posts_per_page'=> $settings['postcount'], 'post_status' => 'publish', 'offset' => $settings['postoffset'], 'post__in' => $port_grid_sl_id) );
			while ( $loop->have_posts() ) : $loop->the_post();
			if( $settings['enable_filter'] == 'st2' ) {
				$soda_portfolio_category = wp_get_post_terms($post->ID,'portfolio_category', array('exclude' => $settings['port_filter_cat_exclude']));
			}
			else {
				$soda_portfolio_category = wp_get_post_terms($post->ID,'portfolio_category', array('exclude' => $settings['categoryname_exclude']));
			}
			$soda_class = "";
			$soda_categories = "";
			foreach ($soda_portfolio_category as $soda_item) {
				$soda_class.=esc_attr($soda_item->slug . ' ');
				$soda_categories.='<a href="'.get_category_link($soda_item->term_id).'" class="pgi-category">';
				$soda_categories.=esc_attr($soda_item->name . '  ');
				$soda_categories.='</a>';
			}
			if (has_post_thumbnail( $post->ID ) ):
				$soda_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
				$if_img_light ='';
				if(get_post_meta($post->ID,'soda_port_cover_title_color_opt',true)=='st2'){
				$if_img_light ='pgi-image-is-light';
				}
			?>
				<!-- Begin tt-Grid item
				======================== -->
				<div class="tt-grid-item isotope-item <?php echo esc_attr($soda_class);?>">
					<div class="ttgr-item-inner">

						<!-- Begin portfolio grid item
						===============================
						* Use class "pgi-image-is-light" if needed, it makes the caption visible better if you use light image (only effect if "pgi-cap-inside" is enabled on "portfolio-grid"! Also no effect on small screens!).
						-->
						<div class="portfolio-grid-item <?php echo esc_attr($if_img_light);?>">
							<a href="<?php the_permalink();?>" class="pgi-image-wrap" data-cursor="<?php echo do_shortcode($settings['text4']); ?>">
								<!-- Use class "cover-opacity-*" to set image overlay if needed. For example "cover-opacity-2". Useful if class "pgi-cap-inside" is enabled on "portfolio-grid". Note: It is individual and depends on the image you use. More info about helper classes in file "helper.css". -->
								<div class="pgi-image-holder">
									<div class="pgi-image-inner tt-anim-zoomin">
										<?php if(get_post_meta($post->ID,'soda_port_list_cover',true)=='st2'){ ?>
										<figure class="pgi-video-wrap ttgr-height">
											<video class="pgi-video" loop muted preload="metadata" poster="<?php echo esc_url($soda_image[0]);?>">
												<?php if (( get_post_meta($post->ID,'soda_port_cover_video_path_mp4_opt',true))) { ?>
												<source src="<?php echo get_template_directory_uri();?>/includes/vids/placeholder.mp4"  data-src="<?php echo esc_url(get_post_meta($post->ID,'soda_port_cover_video_path_mp4_opt',true));?>" type="video/mp4">
												<?php };?>
												<?php if (( get_post_meta($post->ID,'soda_port_cover_video_path_webm_opt',true))) { ?>
												<source src="<?php echo get_template_directory_uri();?>/includes/vids/placeholder.webm"  data-src="<?php echo esc_url(get_post_meta($post->ID,'soda_port_cover_video_path_webm_opt',true));?>" type="video/webm">
												<?php } ;?>
											</video>
										</figure>
										<?php } else { ?>
										<figure class="pgi-image ttgr-height">
											<img class="link-item" src="<?php echo esc_url($soda_image[0]);?>" loading="lazy" alt="<?php the_title();?>">
										</figure> <!-- /.pgi-image -->
										<?php };?>
									</div> <!-- /.pgi-image-inner -->
								</div> <!-- /.pgi-image-holder -->
							</a> <!-- /.pgi-image-wrap -->

							<div class="pgi-caption">
								<div class="pgi-caption-inner">
									<h2 class="pgi-title">
										<a href="<?php the_permalink();?>">
										<?php the_title();?>
										</a>
									</h2>
									<div class="pgi-categories-wrap">
										<?php echo do_shortcode($soda_categories);?>
									</div> <!-- /.pli-categories-wrap -->
								</div> <!-- /.pgi-caption-inner -->
							</div> <!-- /.pgi-caption -->
						</div>
						<!-- End portfolio grid item -->

					</div> <!-- /.ttgr-item-inner -->
				</div>
				<!-- End tt-Grid item -->
				<?php
				endif;
				endwhile;
				wp_reset_postdata();?>


		</div>
		<!-- End tt-Grid items wrap  -->

		</div>
		<!-- End tt-Grid -->



</div>
<!-- End portfolio grid -->
<?php
}

}
