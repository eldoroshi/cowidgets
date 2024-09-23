<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * CE Site title widget
 *
 * CE widget for site title
 *
 * @since 1.0.0
 */
class Site_Title extends Widget_Base {

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
		return 'ce-site-title';
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
		return __( 'Site Title', 'cowidgets' );
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
		return 'ce-icon-site-title';
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
	 * Register site title controls controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->register_general_content_controls();
		$this->register_heading_typo_content_controls();
	}

	/**
	 * Register Advanced Heading General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'General', 'cowidgets' ),
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
			'icon',
			[
				'label'       => __( 'Icon', 'cowidgets' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ce-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_link',
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
			'heading_link',
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
					'custom_link' => 'custom',
				],
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

		$this->add_responsive_control(
			'heading_text_align',
			[
				'label'        => __( 'Alignment', 'cowidgets' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'cowidgets' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'cowidgets' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'cowidgets' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'cowidgets' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors'    => [
					'{{WRAPPER}} .ce-heading' => 'text-align: {{VALUE}};',
				],
				'prefix_class' => 'hfe%s-heading-align-',
			]
		);
		$this->end_controls_section();
	}


	/**
	 * Register Advanced Heading Typography Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_heading_typo_content_controls() {
		$this->start_controls_section(
			'section_heading_typography',
			[
				'label' => __( 'Title', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .ce-heading a',
			]
		);
		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ce-heading-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-icon i'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-icon svg'     => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'heading_shadow',
				'selector' => '{{WRAPPER}} .ce-heading-text',
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
					'{{WRAPPER}} .ce-heading-text' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __( 'Icon', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'condition' => [
					'icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icons_hover_color',
			[
				'label'     => __( 'Icon Hover Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ce-icon:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .ce-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render Heading output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		$title    = get_bloginfo('name');
	
		$this->add_inline_editing_attributes('heading_title', 'basic');
	
		if (!empty($settings['size'])) {
			$this->add_render_attribute('title', 'class', 'elementor-size-' . esc_attr($settings['size']));
		}
	
		if (!empty($settings['heading_link']['url'])) {
			$this->add_render_attribute('url', 'href', esc_url($settings['heading_link']['url']));
	
			if ($settings['heading_link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}
	
			if (!empty($settings['heading_link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}
			$link = $this->get_render_attribute_string('url');
		}
	
		// Define allowed heading tags
		$allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
		$heading_tag = in_array($settings['heading_tag'], $allowed_tags) ? $settings['heading_tag'] : 'h2';
	
		?>
		<div class="ce-module-content ce-heading-wrapper elementor-widget-heading">
			<?php if (!empty($settings['heading_link']['url']) && 'custom' === $settings['custom_link']) { ?>
				<a <?php echo $link;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php } else { ?>
				<a href="<?php echo esc_url(get_home_url()); ?>">
			<?php } ?>
				<<?php echo esc_attr($heading_tag); ?> class="ce-heading elementor-heading-title elementor-size-<?php echo esc_attr($settings['size']); ?>">
					<?php if ('' !== $settings['icon']['value']) { ?>
						<span class="ce-icon">
							<?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>                  
						</span>
					<?php } ?>
					<span class="ce-heading-text">
						<?php
						if ('' !== $settings['before']) {
							echo wp_kses_post($settings['before']);
						}
						echo wp_kses_post($title);
						if ('' !== $settings['after']) {
							echo wp_kses_post($settings['after']);
						}
						?>
					</span>          
				</<?php echo esc_attr($heading_tag); ?>>
			</a>      
		</div>
		<?php
	}
	
		/**
		 * Render site title output in the editor.
		 *
		 * Written as a Backbone JavaScript template and used to generate the live preview.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
	protected function content_template() {
		?>
		<#
		if ( '' == settings.heading_title ) {
			return;
		}
		if ( '' == settings.size ){
			return;
		}
		if ( '' != settings.heading_link.url ) {
			view.addRenderAttribute( 'url', 'href', settings.heading_link.url );
		}
		var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
		#>
		<div class="ce-module-content ce-heading-wrapper elementor-widget-heading">
				<# if ( '' != settings.heading_link.url ) { #>
					<a {{{ view.getRenderAttributeString( 'url' ) }}} >
				<# } #>
				<{{{ settings.heading_tag }}} class="ce-heading elementor-heading-title elementor-size-{{{ settings.size }}}">
				<# if( '' != settings.icon.value ){ #>
				<span class="ce-icon">
					{{{iconHTML.value}}}					
				</span>
				<# } #>
				<span class="ce-heading-text  elementor-heading-title" data-elementor-setting-key="heading_title" data-elementor-inline-editing-toolbar="basic" >
				<#if ( '' != settings.before ){#>
					{{{ settings.before }}} 
				<#}#>
				<?php echo wp_kses_post( get_bloginfo( 'name' ) ); ?>
				<# if ( '' != settings.after ){#>
					{{{ settings.after }}}
				<#}#>
				</span>
			</{{{ settings.heading_tag }}}>
			<# if ( '' != settings.heading_link.url ) { #>
				</a>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Render site title output in the editor.
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
