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
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * CE Cart Widget
 *
 * @since 1.0.0
 */
class Cart extends Widget_Base {

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
		return 'ce-cart';
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
		return __( 'Cart', 'cowidgets' );
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
		return 'ce-icon-menu-cart';
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
	 * Register cart controls controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->register_general_content_controls();
		$this->register_cart_typo_content_controls();
	}

	/**
	 * Register Menu Cart General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Menu Cart', 'cowidgets' ),
			]
		);

		$this->add_control(
			'ce_cart_type',
			[
				'label'   => __( 'Type', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'cowidgets' ),
					'custom'  => __( 'Custom', 'cowidgets' ),
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'        => __( 'Icon', 'cowidgets' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'bag-light'  => __( 'Bag Light', 'cowidgets' ),
					'bag-medium' => __( 'Bag Medium', 'cowidgets' ),
					'bag-solid'  => __( 'Bag Solid', 'cowidgets' ),
				],
				'default'      => 'bag-light',
				'prefix_class' => 'toggle-icon--',
				'condition'    => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'items_indicator',
			[
				'label'        => __( 'Items Count', 'cowidgets' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'none'   => __( 'None', 'cowidgets' ),
					'bubble' => __( 'Bubble', 'cowidgets' ),
				],
				'prefix_class' => 'ce-menu-cart--items-indicator-',
				'default'      => 'bubble',
				'condition'    => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_subtotal',
			[
				'label'        => __( 'Show Total Price', 'cowidgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cowidgets' ),
				'label_off'    => __( 'No', 'cowidgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'ce-menu-cart--show-subtotal-',
				'condition'    => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'hide_empty_indicator',
			[
				'label'        => __( 'Hide Empty', 'cowidgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cowidgets' ),
				'label_off'    => __( 'No', 'cowidgets' ),
				'return_value' => 'hide',
				'prefix_class' => 'ce-menu-cart--empty-indicator-',
				'description'  => __( 'This will hide the items count until the cart is empty', 'cowidgets' ),
				'condition'    => [
					'items_indicator!' => 'none',
					'ce_cart_type'    => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => __( 'Alignment', 'cowidgets' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'cowidgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'cowidgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'cowidgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Register Menu Cart Typography Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_cart_typo_content_controls() {
		$this->start_controls_section(
			'section_heading_typography',
			[
				'label' => __( 'Menu Cart', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'toggle_button_typography',
				'scheme'    => Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .ce-menu-cart__toggle .elementor-button',
				'condition' => [
					'ce_cart_type' => 'custom',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label'     => __( 'Size', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-masthead-custom-menu-items .ce-site-header-cart .ce-site-header-cart-li ' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'ce_cart_type' => 'default',
				],
			]
		);
		$this->add_control(
			'toggle_button_border_width',
			[
				'label'      => __( 'Border Width', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'    => '1',
					'bottom' => '1',
					'left'   => '1',
					'right'  => '1',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button,{{WRAPPER}} .ce-cart-menu-wrap-default .count:after,.ce-cart-menu-wrap-default .count' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'toggle_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
					'unit'   => 'px',
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button,{{WRAPPER}} .ce-cart-menu-wrap-default .count:after,.ce-cart-menu-wrap-default .count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'toggle_button_padding',
			[
				'label'      => __( 'Padding', 'cowidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->start_controls_tabs( 'toggle_button_colors' );

		$this->start_controls_tab(
			'toggle_button_normal_colors',
			[
				'label' => __( 'Normal', 'cowidgets' ),
			]
		);

		$this->add_control(
			'toggle_button_text_color',
			[
				'label'     => __( 'Text Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button,{{WRAPPER}} .ce-cart-menu-wrap-default span.count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_icon_color',
			[
				'label'     => __( 'Icon Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'toggle_button_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button,{{WRAPPER}} .ce-cart-menu-wrap-default span.count' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_border_color',
			[
				'label'     => __( 'Border Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button,{{WRAPPER}} .ce-cart-menu-wrap-default .count:after,.ce-cart-menu-wrap-default .count' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_button_hover_colors',
			[
				'label' => __( 'Hover', 'cowidgets' ),
			]
		);

		$this->add_control(
			'toggle_button_hover_text_color',
			[
				'label'     => __( 'Text Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button:hover,{{WRAPPER}} .ce-cart-menu-wrap-default span.count:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_hover_icon_color',
			[
				'label'     => __( 'Icon Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button:hover .elementor-button-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'toggle_button_hover_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button:hover,{{WRAPPER}} .ce-cart-menu-wrap-default span.count:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button:hover,{{WRAPPER}} .ce-cart-menu-wrap-default:hover .count:after,.ce-cart-menu-wrap-default:hover .count' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'toggle_icon_size',
			[
				'label'      => __( 'Icon Size', 'cowidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'ce_cart_type' => 'custom',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'toggle_icon_spacing',
			[
				'label'      => __( 'Icon Spacing', 'cowidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size-units' => [ 'px', 'em' ],
				'selectors'  => [
					'body:not(.rtl) {{WRAPPER}} .ce-menu-cart__toggle .elementor-button-text' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .ce-menu-cart__toggle .elementor-button-text' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'ce_cart_type' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __( 'Items Count', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon[value]!'     => '',
					'items_indicator!' => 'none',
					'ce_cart_type'    => 'custom',
				],
			]
		);

		$this->add_control(
			'items_indicator_text_color',
			[
				'label'     => __( 'Text Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button-icon[data-counter]:before' => 'color: {{VALUE}}',
				],
				'condition' => [
					'items_indicator!' => 'none',
				],
			]
		);

		$this->add_control(
			'items_indicator_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button-icon[data-counter]:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'items_indicator' => 'bubble',
				],
			]
		);

		$this->add_control(
			'items_indicator_distance',
			[
				'label'     => __( 'Distance', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'em',
				],
				'range'     => [
					'em' => [
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-menu-cart__toggle .elementor-button-icon[data-counter]:before' => 'right: -{{SIZE}}{{UNIT}}; top: -{{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'items_indicator' => 'bubble',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Menu Cart output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings();
		global $woocommerce;

		if ( empty( $woocommerce ) ) {
			return;
		}
		?>

		<div class="ce-masthead-custom-menu-items woocommerce-custom-menu-item">
			<div id="ce-site-header-cart" class="ce-site-header-cart ce-menu-cart-with-border">
				<div class="ce-site-header-cart-li current-menu-item">
				<?php if ( 'default' === $settings['ce_cart_type'] ) { ?>
				<a class="ce-cart-container" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="View your shopping cart">
					<div class="ce-cart-menu-wrap-<?php echo esc_attr($settings['ce_cart_type']); ?>">
						<span class="count">
							<?php
							echo esc_html( empty( $woocommerce->cart ) ? 0 : $woocommerce->cart->cart_contents_count );
							?>
						</span>
					</div>
				</a>
				<?php } else { ?>
						<div class="ce-menu-cart__toggle elementor-button-wrapper">
							<a id="ce-menu-cart__toggle_button" href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="elementor-button">
								<span class="elementor-button-text">
									<?php
									echo empty( $woocommerce->cart ) ? 0 : wp_kses_post( $woocommerce->cart->get_cart_total() );
									?>
								</span>
								<span class="elementor-button-icon" data-counter="<?php echo esc_attr( ( empty( $woocommerce->cart ) ) ? 0 : $woocommerce->cart->cart_contents_count ); ?>">
									<i class="eicon" aria-hidden="true"></i>
									<span class="elementor-screen-only"><?php esc_attr_e( 'Cart', 'cowidgets' ); ?></span>
								</span>
							</a>
						</div>
					<?php } ?>            
				</div>
			</div>
		</div> 
		<?php
	}

	/**
	 * Render Menu Cart output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
	}

	/**
	 * Render cart output in the editor.
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
