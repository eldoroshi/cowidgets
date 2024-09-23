<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\WidgetsManager\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Nav Menu.
 */
class Navigation_Menu extends Widget_Base {


	/**
	 * Menu index.
	 *
	 * @access protected
	 * @var $nav_menu_index
	 */
	protected $nav_menu_index = 1;

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
		return 'navigation-menu';
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
		return __( 'Navigation Menu', 'cowidgets' );
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
		return 'ce-icon-navigation-menu';
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
	 * Retrieve the list of scripts the navigation menu depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'ce-nav-menu' ];
	}

	/**
	 * Retrieve the menu index.
	 *
	 * Used to get index of nav menu.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return string nav index.
	 */
	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	/**
	 * Retrieve the list of available menus.
	 *
	 * Used to get the list of available menus.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return array get WordPress menus list.
	 */
	private function get_available_menus() {

		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Check if the Elementor is updated.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean if Elementor updated.
	 */
	public static function is_elementor_updated() {
		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Register Nav Menu controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->register_general_content_controls();
		$this->register_style_content_controls();
		$this->register_dropdown_content_controls();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'Menu', 'cowidgets' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'cowidgets' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					/* translators: %s Nav menu URL */
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'cowidgets' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s Nav menu URL */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'cowidgets' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'menu_last_item',
			[
				'label'   => __( 'Last Menu Item', 'cowidgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'Default', 'cowidgets' ),
					'cta'  => __( 'Button', 'cowidgets' ),
				],
				'default' => 'none',
			]
		);

		$this->end_controls_section();

			$this->start_controls_section(
				'section_layout',
				[
					'label' => __( 'Layout', 'cowidgets' ),
				]
			);

			$this->add_control(
				'layout',
				[
					'label'   => __( 'Layout', 'cowidgets' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => __( 'Horizontal', 'cowidgets' ),
						'vertical'   => __( 'Vertical', 'cowidgets' ),
						'flyout'     => __( 'Flyout', 'cowidgets' ),
					],
				]
			);

			$this->add_control(
				'text_orientation',
				[
					'label'   => __( 'Text Orientation', 'cowidgets' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => __( 'Horizontal', 'cowidgets' ),
						'vertical'   => __( 'Vertical', 'cowidgets' )
					],
					'condition'    => [
						'layout' => [ 'horizontal' ],
					],
				]
			);

			$this->add_control(
				'navmenu_align',
				[
					'label'        => __( 'Alignment', 'cowidgets' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => __( 'Left', 'cowidgets' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'cowidgets' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'   => [
							'title' => __( 'Right', 'cowidgets' ),
							'icon'  => 'eicon-h-align-right',
						],
						'justify' => [
							'title' => __( 'Justify', 'cowidgets' ),
							'icon'  => 'eicon-h-align-stretch',
						],
					],
					'default'      => 'left',
					'condition'    => [
						'layout' => [ 'horizontal', 'vertical' ],
					],
					'prefix_class' => 'ce-nav-menu__align-',
				]
			);

			$this->add_control(
				'flyout_inner_style',
				[
					'label'       => __( 'Flyout Inner Style', 'cowidgets' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'default',
					'label_block' => false,
					'options'     => [
						'default' => __( 'Default', 'cowidgets' ),
						'hudson'   => __( 'Hudson', 'cowidgets' ),
					],
					'render_type' => 'template',
					'condition'   => [
						'layout' => 'flyout',
					],
					'prefix_class' => 'ce-flyout-inner-',
				]
			);

			$this->add_control(
				'flyout_layout',
				[
					'label'     => __( 'Flyout Orientation', 'cowidgets' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'  => __( 'Left', 'cowidgets' ),
						'right' => __( 'Right', 'cowidgets' ),
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'flyout_type',
				[
					'label'       => __( 'Appear Effect', 'cowidgets' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'normal',
					'label_block' => false,
					'options'     => [
						'normal' => __( 'Slide', 'cowidgets' ),
						'push'   => __( 'Push', 'cowidgets' ),
					],
					'render_type' => 'template',
					'condition'   => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_responsive_control(
				'hamburger_align',
				[
					'label'                => __( 'Hamburger Align', 'cowidgets' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'center',
					'options'              => [
						'left'   => [
							'title' => __( 'Left', 'cowidgets' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'cowidgets' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'cowidgets' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors_dictionary' => [
						'left'   => 'margin-right: auto',
						'center' => 'margin: 0 auto',
						'right'  => 'margin-left: auto',
					],
					'selectors'            => [
						'{{WRAPPER}} .ce-nav-menu__toggle,
						{{WRAPPER}} .ce-nav-menu-icon' => '{{VALUE}}',
					],
					'default'              => 'center',
					'condition'            => [
						'layout' => [ 'flyout' ],
					],
					'label_block'          => false,
				]
			);

			$this->add_responsive_control(
				'hamburger_menu_align',
				[
					'label'        => __( 'Menu Items Align', 'cowidgets' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'flex-start'    => [
							'title' => __( 'Left', 'cowidgets' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'        => [
							'title' => __( 'Center', 'cowidgets' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'      => [
							'title' => __( 'Right', 'cowidgets' ),
							'icon'  => 'eicon-h-align-right',
						],
						'space-between' => [
							'title' => __( 'Justify', 'cowidgets' ),
							'icon'  => 'eicon-h-align-stretch',
						],
					],
					'default'      => 'space-between',
					'condition'    => [
						'layout' => [ 'flyout' ],
					],
					'selectors'    => [
						'{{WRAPPER}} li.menu-item a' => 'justify-content: {{VALUE}};',
						'{{WRAPPER}} li.elementor-button-wrapper' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}.ce-menu-item-flex-end li.elementor-button-wrapper' => 'text-align: right;',
					],
					'prefix_class' => 'ce-menu-item-',
				]
			);

			$this->add_control(
				'submenu_icon',
				[
					'label'        => __( 'Submenu Icon', 'cowidgets' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'arrow',
					'options'      => [
						'none'   => __( 'None', 'cowidgets' ),
						'arrow'   => __( 'Arrows', 'cowidgets' ),
						'plus'    => __( 'Plus Sign', 'cowidgets' ),
						'classic' => __( 'Classic', 'cowidgets' ),
					],
					'prefix_class' => 'ce-submenu-icon-',
				]
			);

			$this->add_control(
				'submenu_animation',
				[
					'label'        => __( 'Submenu Animation', 'cowidgets' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => [
						'none'     => __( 'Default', 'cowidgets' ),
						'slide_up' => __( 'Slide Up', 'cowidgets' ),
					],
					'prefix_class' => 'ce-submenu-animation-',
					'condition'    => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_control(
				'heading_responsive',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => __( 'Responsive', 'cowidgets' ),
					'separator' => 'before',
					'condition' => [
						'layout' => [ 'horizontal', 'vertical' ],
					],
				]
			);

		$this->add_control(
			'dropdown',
			[
				'label'        => __( 'Breakpoint', 'cowidgets' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tablet',
				'options'      => [
					'mobile' => __( 'Mobile (767px >)', 'cowidgets' ),
					'tablet' => __( 'Tablet (1023px >)', 'cowidgets' ),
					'none'   => __( 'None', 'cowidgets' ),
				],
				'prefix_class' => 'ce-nav-menu__breakpoint-',
				'condition'    => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'resp_align',
			[
				'label'                => __( 'Alignment', 'cowidgets' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => __( 'Left', 'cowidgets' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'cowidgets' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'cowidgets' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => 'center',
				'description'          => __( 'This is the alignement of menu icon on selected responsive breakpoints.', 'cowidgets' ),
				'condition'            => [
					'layout'    => [ 'horizontal', 'vertical' ],
					'dropdown!' => 'none',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .ce-nav-menu__toggle' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'full_width_dropdown',
			[
				'label'        => __( 'Full Width', 'cowidgets' ),
				'description'  => __( 'Enable this option to stretch the Sub Menu to Full Width.', 'cowidgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cowidgets' ),
				'label_off'    => __( 'No', 'cowidgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'dropdown!' => 'none',
					'layout!'   => 'flyout',
				],
				'render_type'  => 'template',
			]
		);

		if ( $this->is_elementor_updated() ) {
			$this->add_control(
				'dropdown_icon',
				[
					'label'       => __( 'Menu Icon', 'cowidgets' ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => 'true',
					'default'     => [
						'value'   => 'fas fa-align-justify',
						'library' => 'fa-solid',
					],
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		} else {
			$this->add_control(
				'dropdown_icon',
				[
					'label'       => __( 'Icon', 'cowidgets' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => 'true',
					'default'     => 'feather feather-menu',
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		}

		if ( $this->is_elementor_updated() ) {
			$this->add_control(
				'dropdown_close_icon',
				[
					'label'       => __( 'Close Icon', 'cowidgets' ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => 'true',
					'default'     => [
						'value'   => 'feather feather-x',
						'library' => 'feather',
					],
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		} else {
			$this->add_control(
				'dropdown_close_icon',
				[
					'label'       => __( 'Close Icon', 'cowidgets' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => 'true',
					'default'     => 'fa fa-close',
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label'     => __( 'Main Menu', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_flyout_menu_item',
			[
				'label'       => __( 'Flyout Box Width', 'cowidgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', '%'],
				'range'       => [
					'px' => [
						'max' => 500,
						'min' => 100,
					],
				],
				'default'     => [
					'size' => 300,
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .ce-flyout-wrapper .ce-side' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-flyout-open.left'  => 'left: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-flyout-open.right' => 'right: -{{SIZE}}{{UNIT}}',
				],
				'condition'   => [
					'layout' => 'flyout',
				],
				'render_type' => 'template',
			]
		);

			$this->add_responsive_control(
				'padding_flyout_menu_item',
				[
					'label'     => __( 'Flyout Box Padding', 'cowidgets' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'default'   => [
						'size' => 30,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .ce-flyout-content' => 'padding: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_menu_item',
				[
					'label'      => __( 'Horizontal Padding', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.ce-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .menu-item a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 20px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-nav-menu__layout-vertical .menu-item ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 40px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-nav-menu__layout-vertical .menu-item ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 60px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-nav-menu__layout-vertical .menu-item ul ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 80px );padding-right: {{SIZE}}{{UNIT}};',
						],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_menu_item',
				[
					'label'      => __( 'Vertical Padding', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.ce-menu-item, {{WRAPPER}} .menu-item a.ce-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'menu_space_between',
				[
					'label'      => __( 'Space Between', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'body:not(.rtl) {{WRAPPER}} .ce-nav-menu__layout-horizontal .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
						'body.rtl {{WRAPPER}} .ce-nav-menu__layout-horizontal .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} nav:not(.ce-nav-menu__layout-horizontal) .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'(tablet)body:not(.rtl) {{WRAPPER}}.ce-nav-menu__breakpoint-tablet .ce-nav-menu__layout-horizontal .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px',
						'(mobile)body:not(.rtl) {{WRAPPER}}.ce-nav-menu__breakpoint-mobile .ce-nav-menu__layout-horizontal .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px',
						'(tablet)body {{WRAPPER}} nav.ce-nav-menu__layout-vertical .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: 0px',
						'(mobile)body {{WRAPPER}} nav.ce-nav-menu__layout-vertical .ce-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: 0px',
					],
					
				]
			);

			$this->add_responsive_control(
				'menu_row_space',
				[
					'label'      => __( 'Row Spacing', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'body:not(.rtl) {{WRAPPER}} .ce-nav-menu__layout-horizontal .ce-nav-menu > li.menu-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_responsive_control(
				'menu_top_space',
				[
					'label'      => __( 'Menu Item Top Spacing', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .ce-flyout-wrapper nav' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'bg_color_flyout',
				[
					'label'     => __( 'Background Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .ce-flyout-content' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .ce-flyout-content .ce-nav-menu' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'flyout_hudson_color',
				[
					'label'     => __( 'Flyout Hudson Widgets Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => [
						'{{WRAPPER}} .ce-flyout-content' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ce-flyout-content ul li' => 'color: {{VALUE}}',
					],
					'condition' => [
						'layout' => 'flyout',
						'flyout_inner_style' => 'hudson'
					],
				]
			);

			$this->add_control(
				'flyout_hudson_search_bg',
				[
					'label'     => __( 'Flyout Hudson Search Field Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#eeeeee',
					'selectors' => [
						'{{WRAPPER}} .ce-flyout-content .ce-flyout-search-area input' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'layout' => 'flyout',
						'flyout_inner_style' => 'hudson'
					],
				]
			);

			$this->add_control(
				'pointer',
				[
					'label'     => __( 'Link Hover Effect', 'cowidgets' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'        => __( 'None', 'cowidgets' ),
						'underline'   => __( 'Underline', 'cowidgets' ),
						'overline'    => __( 'Overline', 'cowidgets' ),
						'double-line' => __( 'Double Line', 'cowidgets' ),
						'framed'      => __( 'Framed', 'cowidgets' ),						
						'text'        => __( 'Text', 'cowidgets' ),
						'small_underline'        => __( 'Small Underline', 'cowidgets' ),
						'small_point'      => __( 'Small Point', 'cowidgets' ),
					],
					'condition' => [
						'layout' => [ 'horizontal' ],
					],
				]
			);

		$this->add_control(
			'animation_line',
			[
				'label'     => __( 'Animation', 'cowidgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'     => 'Fade',
					'slide'    => 'Slide',
					'grow'     => 'Grow',
					'drop-in'  => 'Drop In',
					'drop-out' => 'Drop Out',
					'none'     => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label'     => __( 'Frame Animation', 'cowidgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'    => 'Fade',
					'grow'    => 'Grow',
					'shrink'  => 'Shrink',
					'draw'    => 'Draw',
					'corners' => 'Corners',
					'none'    => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label'     => __( 'Animation', 'cowidgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'grow',
				'options'   => [
					'grow'   => 'Grow',
					'shrink' => 'Shrink',
					'sink'   => 'Sink',
					'float'  => 'Float',
					'skew'   => 'Skew',
					'rotate' => 'Rotate',
					'none'   => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => 'text',
				],
			]
		);

		$this->add_control(
			'style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'menu_typography',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} a.ce-menu-item, {{WRAPPER}} a.ce-sub-menu-item',
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

				$this->start_controls_tab(
					'tab_menu_item_normal',
					[
						'label' => __( 'Normal', 'cowidgets' ),
					]
				);

					$this->add_control(
						'color_menu_item',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Color::get_type(),
								'value' => Color::COLOR_3,
							],
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item, {{WRAPPER}} .sub-menu a.ce-sub-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item',
						[
							'label'     => __( 'Background Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item, {{WRAPPER}} .sub-menu, {{WRAPPER}} nav.ce-dropdown' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_menu_item_hover',
					[
						'label' => __( 'Hover', 'cowidgets' ),
					]
				);

					$this->add_control(
						'color_menu_item_hover',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item:hover,
								{{WRAPPER}} .sub-menu a.ce-sub-menu-item:hover,
								{{WRAPPER}} .menu-item.current-menu-item a.ce-menu-item,
								{{WRAPPER}} .menu-item a.ce-menu-item.highlighted,
								{{WRAPPER}} .menu-item a.ce-menu-item:focus' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item_hover',
						[
							'label'     => __( 'Background Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item:hover,
								{{WRAPPER}} .sub-menu a.ce-sub-menu-item:hover,
								{{WRAPPER}} .menu-item.current-menu-item a.ce-menu-item,
								{{WRAPPER}} .menu-item a.ce-menu-item.highlighted,
								{{WRAPPER}} .menu-item a.ce-menu-item:focus' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

					$this->add_control(
						'pointer_color_menu_item_hover',
						[
							'label'     => __( 'Link Hover Effect Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							],
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .ce-nav-menu-layout:not(.ce-pointer__framed) .menu-item.parent a.ce-menu-item:before,
								{{WRAPPER}} .ce-pointer__small_underline nav > ul > li:before,
								{{WRAPPER}} .ce-nav-menu-layout:not(.ce-pointer__framed) .menu-item.parent a.ce-menu-item:after' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ce-nav-menu-layout:not(.ce-pointer__framed) .menu-item.parent .sub-menu .ce-has-submenu-container a:after' => 'background-color: unset',
								'{{WRAPPER}} .ce-pointer__framed .menu-item.parent a.ce-menu-item:before,
								{{WRAPPER}} .ce-pointer__framed .menu-item.parent a.ce-menu-item:after' => 'border-color: {{VALUE}}',
							],
							'condition' => [
								'pointer!' => [ 'none', 'text' ],
								'layout!'  => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_menu_item_active',
					[
						'label' => __( 'Active', 'cowidgets' ),
					]
				);

					$this->add_control(
						'color_menu_item_active',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item.current-menu-item a.ce-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item_active',
						[
							'label'     => __( 'Background Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item.current-menu-item a.ce-menu-item' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

					$this->add_control(
						'pointer_color_menu_item_active',
						[
							'label'     => __( 'Link Hover Effect Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .ce-nav-menu:not(.ce-pointer__framed) .menu-item.parent.current-menu-item a.ce-menu-item:before,
								{{WRAPPER}} .ce-nav-menu:not(.ce-pointer__framed) .menu-item.parent.current-menu-item a.ce-menu-item:after' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ce-nav-menu:not(.ce-pointer__framed) .menu-item.parent .sub-menu .ce-has-submenu-container a.current-menu-item:after' => 'background-color: unset',
								'{{WRAPPER}} .ce-pointer__framed .menu-item.parent.current-menu-item a.ce-menu-item:before,
								{{WRAPPER}} .ce-pointer__framed .menu-item.parent.current-menu-item a.ce-menu-item:after' => 'border-color: {{VALUE}}',
							],
							'condition' => [
								'pointer!' => [ 'none', 'text' ],
								'layout!'  => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_dropdown_content_controls() {

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => __( 'Dropdown', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'dropdown_description',
				[
					'raw'             => __( '<b>Note:</b> On desktop, below style options will apply to the submenu. On mobile, this will apply to the entire menu.', 'cowidgets' ),
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
					'condition'       => [
						'layout!' => [
							'flyout',
						],
					],
				]
			);

			$this->start_controls_tabs( 'tabs_dropdown_item_style' );

				$this->start_controls_tab(
					'tab_dropdown_item_normal',
					[
						'label' => __( 'Normal', 'cowidgets' ),
					]
				);

					$this->add_control(
						'color_dropdown_item',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .sub-menu a.ce-sub-menu-item, 
								{{WRAPPER}} .elementor-menu-toggle,
								{{WRAPPER}} nav.ce-dropdown li a.ce-menu-item,
								{{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'background_color_dropdown_item',
						[
							'label'     => __( 'Background Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#fff',
							'selectors' => [
								'{{WRAPPER}} .sub-menu,
								{{WRAPPER}} nav.ce-dropdown,
								{{WRAPPER}} nav.ce-dropdown .menu-item a.ce-menu-item,
								{{WRAPPER}} nav.ce-dropdown .menu-item a.ce-sub-menu-item,
								{{WRAPPER}} .ce-has-megamenu .ce-megamenu-wrapper' => 'background-color: {{VALUE}}',

							],
							'separator' => 'none',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_dropdown_item_hover',
					[
						'label' => __( 'Hover', 'cowidgets' ),
					]
				);

					$this->add_control(
						'color_dropdown_item_hover',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .ce-has-megamenu .sub-menu li > a.ce-sub-menu-item:hover, 
								{{WRAPPER}} .ce-has-no-megamenu .sub-menu a.ce-sub-menu-item:hover,
								{{WRAPPER}} .elementor-menu-toggle:hover,
								{{WRAPPER}} nav.ce-dropdown li a.ce-menu-item:hover,
								{{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item:hover' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'background_color_dropdown_item_hover',
						[
							'label'     => __( 'Background Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .ce-has-megamenu .sub-menu li > a.ce-sub-menu-item:hover, 
								{{WRAPPER}} .ce-has-no-megamenu .sub-menu a.ce-sub-menu-item:hover,
								{{WRAPPER}} nav.ce-dropdown li a.ce-menu-item:hover,
								{{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item:hover' => 'background-color: {{VALUE}}',
							],
							'separator' => 'none',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'dropdown_typography',
					'scheme'    => Typography::TYPOGRAPHY_4,
					'separator' => 'before',
					'selector'  => '
							{{WRAPPER}} .sub-menu li a.ce-sub-menu-item,
							{{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item,
							{{WRAPPER}} nav.ce-dropdown li a.ce-menu-item',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'dropdown_border',
					'selector' => '{{WRAPPER}} nav.ce-nav-menu__layout-horizontal .sub-menu, 
							{{WRAPPER}} nav:not(.ce-nav-menu__layout-horizontal) .sub-menu.sub-menu-open,
							{{WRAPPER}} nav.ce-dropdown',
				]
			);

			$this->add_responsive_control(
				'dropdown_border_radius',
				[
					'label'      => __( 'Border Radius', 'cowidgets' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .sub-menu'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .sub-menu li.menu-item:first-child' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
						'{{WRAPPER}} .sub-menu li.menu-item:last-child' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};'
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'dropdown_box_shadow',
					'exclude'   => [
						'box_shadow_position',
					],
					'selector'  => '{{WRAPPER}}.ce-nav-menu__breakpoint-tablet .ce-nav-menu .ce-has-no-megamenu .sub-menu,
									{{WRAPPER}}.ce-nav-menu__breakpoint-mobile .ce-nav-menu .ce-has-no-megamenu .sub-menu,
									{{WRAPPER}}.ce-nav-menu__breakpoint-tablet .ce-nav-menu .ce-has-megamenu .ce-megamenu-wrapper,
									{{WRAPPER}}.ce-nav-menu__breakpoint-mobile .ce-nav-menu .ce-has-megamenu .ce-megamenu-wrapper,
								{{WRAPPER}} nav.ce-dropdown',
					'separator' => 'after',
				]
			);

			$this->add_responsive_control(
				'width_dropdown_item',
				[
					'label'     => __( 'Dropdown Width (px)', 'cowidgets' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'default'   => [
						'size' => '220',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .ce-has-no-megamenu ul.sub-menu' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_dropdown_item',
				[
					'label'      => __( 'Horizontal Padding', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .sub-menu li a.ce-sub-menu-item,
						{{WRAPPER}} nav.ce-dropdown li a.ce-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 20px );padding-right: {{SIZE}}{{UNIT}};',
						
						'{{WRAPPER}} .ce-flyout-container .menu-item ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 40px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-flyout-container .menu-item ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 60px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-flyout-container .menu-item ul ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 80px );padding-right: {{SIZE}}{{UNIT}};',

						'{{WRAPPER}} .ce-dropdown .menu-item ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 40px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-dropdown .menu-item ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 60px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ce-dropdown .menu-item ul ul ul ul a.ce-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 80px );padding-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_dropdown_item',
				[
					'label'      => __( 'Vertical Padding', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .ce-has-no-megamenu .sub-menu a.ce-sub-menu-item,
						 {{WRAPPER}} nav.ce-dropdown li a.ce-menu-item,
						 {{WRAPPER}} nav.ce-dropdown li a.ce-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_megamenu_item',
				[
					'label'      => __( 'Megamenu Vertical Padding', 'cowidgets' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default'    => [
						'size' => 10,
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .ce-has-megamenu .sub-menu a.ce-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'distance_from_menu',
				[
					'label'     => __( 'Top Distance', 'cowidgets' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} nav.ce-nav-menu__layout-horizontal ul.sub-menu' => 'margin-top: {{SIZE}}px;',
						'{{WRAPPER}} .ce-dropdown.menu-is-active' => 'margin-top: {{SIZE}}px;',
					],
					'condition' => [
						'layout' => [ 'horizontal', 'vertical' ],
					],
				]
			);

			$this->add_control(
				'heading_dropdown_divider',
				[
					'label'     => __( 'Divider', 'cowidgets' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'dropdown_divider_border',
				[
					'label'       => __( 'Border Style', 'cowidgets' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'solid',
					'label_block' => false,
					'options'     => [
						'none'   => __( 'None', 'cowidgets' ),
						'solid'  => __( 'Solid', 'cowidgets' ),
						'double' => __( 'Double', 'cowidgets' ),
						'dotted' => __( 'Dotted', 'cowidgets' ),
						'dashed' => __( 'Dashed', 'cowidgets' ),
					],
					'selectors'   => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.ce-dropdown li.menu-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'divider_border_color',
				[
					'label'     => __( 'Border Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#c4c4c4',
					'selectors' => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.ce-dropdown li.menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);

			$this->add_control(
				'dropdown_divider_width',
				[
					'label'     => __( 'Border Width', 'cowidgets' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'default'   => [
						'size' => '1',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.ce-dropdown li.menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_toggle',
			[
				'label' => __( 'Menu Trigger & Close Icon', 'cowidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'toggle_style_normal',
			[
				'label' => __( 'Normal', 'cowidgets' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.ce-nav-menu-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-nav-menu-icon' => 'background-color: {{VALUE}}; padding: 0.35em;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_hover',
			[
				'label' => __( 'Hover', 'cowidgets' ),
			]
		);

		$this->add_control(
			'toggle_hover_color',
			[
				'label'     => __( 'Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.ce-nav-menu-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_hover_background_color',
			[
				'label'     => __( 'Background Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-nav-menu-icon:hover' => 'background-color: {{VALUE}}; padding: 0.35em;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_size',
			[
				'label'     => __( 'Icon Size', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-nav-menu-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_border_width',
			[
				'label'     => __( 'Border Width', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-nav-menu-icon' => 'border-width: {{SIZE}}{{UNIT}}; padding: 0.35em;',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius',
			[
				'label'      => __( 'Border Radius', 'cowidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ce-nav-menu-icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'close_color_flyout',
			[
				'label'     => __( 'Close Icon Color', 'cowidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .ce-flyout-close' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout' => 'flyout',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'close_flyout_size',
			[
				'label'     => __( 'Close Icon Size', 'cowidgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ce-flyout-close' => 'height: {{SIZE}}px; width: {{SIZE}}px; font-size: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
				'condition' => [
					'layout' => 'flyout',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'style_button',
			[
				'label'     => __( 'Button', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_last_item' => 'cta',
				],
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'label'    => __( 'Typography', 'cowidgets' ),
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button',
				]
			);
			$this->add_responsive_control(
				'padding',
				[
					'label'      => __( 'Padding', 'cowidgets' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( '_button_style' );

				$this->start_controls_tab(
					'_button_normal',
					[
						'label' => __( 'Normal', 'cowidgets' ),
					]
				);

					$this->add_control(
						'all_text_color',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_color',
							'label'          => __( 'Background Color', 'cowidgets' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button',
							'fields_options' => [
								'color' => [
									'scheme' => [
										'type'  => Color::get_type(),
										'value' => Color::COLOR_4,
									],
								],
							],
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'     => 'all_border',
							'label'    => __( 'Border', 'cowidgets' ),
							'selector' => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button',
						]
					);

					$this->add_control(
						'all_border_radius',
						[
							'label'      => __( 'Border Radius', 'cowidgets' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'all_button_hover',
					[
						'label' => __( 'Hover', 'cowidgets' ),
					]
				);

					$this->add_control(
						'all_hover_color',
						[
							'label'     => __( 'Text Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_hover_color',
							'label'          => __( 'Background Color', 'cowidgets' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button:hover',
							'fields_options' => [
								'color' => [
									'scheme' => [
										'type'  => Color::get_type(),
										'value' => Color::COLOR_4,
									],
								],
							],
						]
					);

					$this->add_control(
						'all_border_hover_color',
						[
							'label'     => __( 'Border Hover Color', 'cowidgets' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .menu-item a.ce-menu-item.elementor-button:hover',
							'separator' => 'after',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Nav Menu output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$args = [
			'echo'        => false,
			'menu'        => $settings['menu'],
			'menu_class'  => 'ce-nav-menu',
			'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
			'walker'      => new Menu_Walker,
		];

		$menu_html = wp_nav_menu( $args );

		if ( 'flyout' === $settings['layout'] ) {

			$this->add_render_attribute( 'ce-flyout', 'class', 'ce-flyout-wrapper' );
			if ( 'cta' === $settings['menu_last_item'] ) {

				$this->add_render_attribute( 'ce-flyout', 'data-last-item', $settings['menu_last_item'] );
			}

			$this->add_render_attribute( 'ce-flyout', 'class', $settings['flyout_inner_style'] );
			

			?>
			<div class="ce-nav-menu__toggle elementor-clickable ce-flyout-trigger" tabindex="0">
					<div class="ce-nav-menu-icon"> 
						<?php if( $settings['dropdown_icon']['library'] != 'svg' ){ ?>  
							<?php if ( $this->is_elementor_updated() ) { ?>
								<i class="<?php echo esc_attr( $settings['dropdown_icon']['value'] ); ?>" aria-hidden="true" tabindex="0"></i>
							<?php } else { ?>
								<i class="<?php echo esc_attr( $settings['dropdown_icon'] ); ?>" aria-hidden="true" tabindex="0"></i>
							<?php } ?>
						<?php }else{
							if( isset( $settings['dropdown_icon']['value']['url'] ) ){
								$svg_url = esc_url( $settings['dropdown_icon']['value']['url'] );
								$svg_content = wp_remote_get( $svg_url );
								if ( $svg_content ) {
									echo wp_kses_post( $svg_content );
								}
							}
						} ?>
					</div>
			</div>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-flyout' ) ); ?> >
				<div class="ce-flyout-overlay elementor-clickable"></div>
				<div class="ce-flyout-container">
					<div id="ce-flyout-content-id-<?php echo esc_attr( $this->get_id() ); ?>" class="ce-side ce-flyout-<?php echo esc_attr( $settings['flyout_layout'] ); ?> ce-flyout-open" data-width="<?php echo esc_attr( $settings['width_flyout_menu_item']['size'] ); ?>" data-layout="<?php echo wp_kses_post( $settings['flyout_layout'] ); ?>" data-flyout-type="<?php echo wp_kses_post( $settings['flyout_type'] ); ?>">
						<div class="ce-flyout-content push">						
							<nav <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-nav-menu' ) ); ?>><?php echo wp_kses_post($menu_html); ?></nav>
							<div class="elementor-clickable ce-flyout-close" tabindex="0">
								<?php if( $settings['dropdown_icon']['library'] != 'svg' ){ ?>  
									<?php if ( $this->is_elementor_updated() ) { ?>
										<i class="<?php echo esc_attr( $settings['dropdown_close_icon']['value'] ); ?>" aria-hidden="true" tabindex="0"></i>
									<?php } else { ?>
										<i class="<?php echo esc_attr( $settings['dropdown_close_icon'] ); ?>" aria-hidden="true" tabindex="0"></i>
									<?php } ?>
								<?php }else{
					
									if( isset( $settings['dropdown_close_icon']['value']['url'] ) ){
										$svg_loaded = wp_remote_get( $settings['dropdown_close_icon']['value']['url'] );
										echo $svg_loaded;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
								} ?>
							</div>

							<?php if( $settings['flyout_inner_style'] == 'hudson' ): ?>
								<div class="ce-flyout-widget-area">
										<?php if( is_active_sidebar( 'overlay-menu' ) ) dynamic_sidebar( 'overlay-menu' ) ?>
								</div>
								
								<div class="ce-flyout-search-area">
									<?php get_search_form() ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>				
			<?php
		} else {
			$this->add_render_attribute(
				'ce-main-menu',
				'class',
				[
					'ce-nav-menu',
					'ce-layout-' . $settings['layout'],
					'ce-text-orientation-' . $settings['text_orientation']
				]
			);

			$this->add_render_attribute( 'ce-main-menu', 'class', 'ce-nav-menu-layout' );

			$this->add_render_attribute( 'ce-main-menu', 'class', $settings['layout'] );

			$this->add_render_attribute( 'ce-main-menu', 'data-layout', $settings['layout'] );



			$this->add_render_attribute( 'ce-main-menu', 'data-container-width', apply_filters( 'ce_megamenu_container', '1170' ) );

			if ( 'cta' === $settings['menu_last_item'] ) {

				$this->add_render_attribute( 'ce-main-menu', 'data-last-item', $settings['menu_last_item'] );
			}

			if ( $settings['pointer'] ) {
				if ( 'horizontal' === $settings['layout'] || 'vertical' === $settings['layout'] ) {
					$this->add_render_attribute( 'ce-main-menu', 'class', 'ce-pointer__' . $settings['pointer'] );

					if ( in_array( $settings['pointer'], [ 'double-line', 'underline', 'overline' ], true ) ) {
						$key = 'animation_line';
						$this->add_render_attribute( 'ce-main-menu', 'class', 'ce-animation__' . $settings[ $key ] );
					} elseif ( 'framed' === $settings['pointer'] || 'text' === $settings['pointer'] ) {
						$key = 'animation_' . $settings['pointer'];
						$this->add_render_attribute( 'ce-main-menu', 'class', 'ce-animation__' . $settings[ $key ] );
					}
				}
			}

			$this->add_render_attribute(
				'ce-nav-menu',
				'class',
				[
					'ce-nav-menu__layout-' . $settings['layout'],
					'ce-nav-menu__submenu-' . $settings['submenu_icon'],
				]
			);
			$dropdown_icon = $settings['dropdown_icon']['library'] != 'svg' ? $settings['dropdown_icon'] : 'show-drop-icon';
			$dropdown_close_icon = $settings['dropdown_close_icon']['library'] != 'svg' ? $settings['dropdown_close_icon'] : 'show-close-icon';
			
			
			$this->add_render_attribute( 'ce-nav-menu', 'data-toggle-icon', $dropdown_icon );

			$this->add_render_attribute( 'ce-nav-menu', 'data-close-icon', $dropdown_close_icon );

			$this->add_render_attribute( 'ce-nav-menu', 'data-full-width', $settings['full_width_dropdown'] );

			?>
			<div <?php echo $this->get_render_attribute_string( 'ce-main-menu' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="ce-nav-menu__toggle elementor-clickable">
					<div class="ce-nav-menu-icon">
						<?php if( $settings['dropdown_icon']['library'] != 'svg' ){ ?>  
							<?php if ( $this->is_elementor_updated() ) { ?>
								<i class="<?php echo esc_attr( $settings['dropdown_icon']['value'] ); ?>" aria-hidden="true" tabindex="0"></i>
							<?php } else { ?>
								<i class="<?php echo esc_attr( $settings['dropdown_icon'] ); ?>" aria-hidden="true" tabindex="0"></i>
							<?php } ?>
						<?php }else{
							?>
							<i class="" data-for="dropdown-icon-svg" aria-hidden="true" tabindex="0">
							<?php
							if( isset( $settings['dropdown_icon']['value']['url'] ) ){
								$svg_loaded = wp_remote_get( $settings['dropdown_icon']['value']['url'] );
								echo $svg_loaded; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}?>
							</i>
							<i class="" data-for="dropdown-icon-close-svg"  aria-hidden="true" tabindex="0">
							<?php
							if( isset( $settings['dropdown_close_icon']['value']['url'] ) ){
								$svg_loaded = wp_remote_get( $settings['dropdown_close_icon']['value']['url'] );
								echo $svg_loaded; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}?>
							</i>
							<?php
						} ?>
					</div>
				</div>
				
				<nav <?php echo $this->get_render_attribute_string( 'ce-nav-menu' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $menu_html;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></nav>              
			</div>
			<?php
		}
	}
}

