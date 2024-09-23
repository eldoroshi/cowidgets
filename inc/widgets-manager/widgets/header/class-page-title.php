<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * CE Page Title widget
 *
 * CE widget for Page Title.
 *
 * @since 1.0.0
 */
class Page_Title extends Widget_Base {


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
		return 'page-title';
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
		return __( 'Page Title', 'cowidgets' );
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
		return 'ce-icon-page-title';
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
		return [ 'ce-header-widgets' ];
	}

	/**
	 * Register Page Title controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_content_page_title_controls();
		$this->register_page_title_style_controls();
	}

	/**
	 * Register Page Title General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_content_page_title_controls() {
		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Title', 'cowidgets' ),
			]
		);

		$this->add_control(
			'before',
			[
				'label'   => __( 'Before Title Text', 'cowidgets' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'after',
			[
				'label'   => __( 'After Title Text', 'cowidgets' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'new_page_title_select_icon',
			[
				'label'       => __( 'Select Icon', 'cowidgets' ),
				'type'        => Controls_Manager::ICONS,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'page_title_icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ce-page-title-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'page_custom_link',
			[
				'label'   => __( 'Link', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom'  => __( 'Custom URL', 'cowidgets' ),
					'default' => __( 'Default', 'cowidgets' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'page_heading_link',
			[
				'label'       => __( 'Link', 'cowidgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'cowidgets' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => get_home_url(),
				],
				'condition'   => [
					'page_custom_link' => 'custom',
				],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'HTML Tag', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'cowidgets' ),
					'h2' => __( 'H2', 'cowidgets' ),
					'h3' => __( 'H3', 'cowidgets' ),
					'h4' => __( 'H4', 'cowidgets' ),
					'h5' => __( 'H5', 'cowidgets' ),
					'h6' => __( 'H6', 'cowidgets' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'cowidgets' ),
					'small'   => __( 'Small', 'cowidgets' ),
					'medium'  => __( 'Medium', 'cowidgets' ),
					'large'   => __( 'Large', 'cowidgets' ),
					'xl'      => __( 'XL', 'cowidgets' ),
					'xxl'     => __( 'XXL', 'cowidgets' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'cowidgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'cowidgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'cowidgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'cowidgets' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'cowidgets' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-page-title-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register Page Title Style Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_page_title_style_controls() {
		$this->start_controls_section(
			'section_title_typography',
			[
				'label' => __( 'Title', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .ce-page-title a',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label'     => __( 'Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Color::get_type(),
						'value' => Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .ce-page-title a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .ce-page-title-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .ce-page-title-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_shadow',
					'selector' => '{{WRAPPER}} .elementor-heading-title',
				]
			);

			$this->add_control(
				'blend_mode',
				[
					'label'     => __( 'Blend Mode', 'cowidgets' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''            => __( 'Normal', 'cowidgets' ),
						'multiply'    => 'Multiply',
						'screen'      => 'Screen',
						'overlay'     => 'Overlay',
						'darken'      => 'Darken',
						'lighten'     => 'Lighten',
						'color-dodge' => 'Color Dodge',
						'saturation'  => 'Saturation',
						'color'       => 'Color',
						'difference'  => 'Difference',
						'exclusion'   => 'Exclusion',
						'hue'         => 'Hue',
						'luminosity'  => 'Luminosity',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __( 'Icon', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'page_title_icon_color',
			[
				'label'     => __( 'Icon Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-page-title-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-page-title-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'page_title_icons_hover_color',
			[
				'label'     => __( 'Icon Hover Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-page-title-icon:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-page-title-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render page title widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'page_title', 'basic' );

		if ( ! empty( $settings['page_heading_link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['page_heading_link']['url'] );

			if ( $settings['page_heading_link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['page_heading_link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}
			$link = $this->get_render_attribute_string( 'url' );
		}
		?>		
		<div class="ce-page-title ce-page-title-wrapper elementor-widget-heading">
			<?php if ( '' != $settings['page_heading_link']['url'] && 'custom' === $settings['page_custom_link'] ) { ?>
						<a <?php echo esc_attr( $link ); ?> >
			<?php } else { ?>
						<a href="<?php echo esc_url( get_home_url() ); ?>">
			<?php } ?>
			<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="elementor-heading-title elementor-size-<?php echo esc_attr($settings['size']); ?>">
				<?php if ( '' !== $settings['new_page_title_select_icon']['value'] ) { ?>
						<span class="ce-page-title-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['new_page_title_select_icon'], [ 'aria-hidden' => 'true' ] ); ?>             </span>
				<?php } ?>				
				<?php if ( '' != $settings['before'] ) { ?>
					<?php echo wp_kses_post( $settings['before'] ); ?>
				<?php } ?>

				<?php echo wp_kses_post( get_the_title() ); ?>

				<?php if ( '' != $settings['after'] ) { ?>
					<?php echo wp_kses_post( $settings['after'] ); ?>
				<?php } ?>  
			</<?php echo wp_kses_post( $settings['heading_tag'] ); ?> > 
			</a>    
		</div>
		<?php
	}

	/**
	 * Render page title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		if ( '' == settings.page_title ) {
			return;
		}

		if ( '' != settings.page_heading_link.url ) {
			view.addRenderAttribute( 'url', 'href', settings.page_heading_link.url );
		}
		var iconHTML = elementor.helpers.renderIcon( view, settings.new_page_title_select_icon, { 'aria-hidden': true }, 'i' , 'object' );
		#>
		<div class="ce-page-title ce-page-title-wrapper elementor-widget-heading">
			<# if ( '' != settings.page_heading_link.url ) { #>
					<a {{{ view.getRenderAttributeString( 'url' ) }}} >
			<# } #>
			<{{{ settings.heading_tag }}} class="elementor-heading-title elementor-size-{{{ settings.size }}}">		
				<# if( '' != settings.new_page_title_select_icon.value ){ #>
					<span class="ce-page-title-icon" data-elementor-setting-key="page_title" data-elementor-inline-editing-toolbar="basic">
						{{{iconHTML.value}}}                    
					</span>
				<# } #>
					<# if ( '' != settings.before ) { #>
						{{{ settings.before }}}
					<# } #>
				<?php echo wp_kses_post( get_the_title() ); ?>
					<# if ( '' != settings.after ) { #>
						{{{ settings.after }}}
					<# } #>				
			</{{{ settings.heading_tag }}}>
			<# if ( '' != settings.page_heading_link.url ) { #>
					</a>
			<# } #>			
		</div>
		<?php
	}

	/**
	 * Render page title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * Remove this after Elementor v3.3.0
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		$this->content_template();
	}
}
