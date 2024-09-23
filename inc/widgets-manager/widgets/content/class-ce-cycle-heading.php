<?php
/**
 * Elementor Classes.
 *
 * @package CoWidgets
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Elementor Kiri Slider
 *
 * Elementor widget for Kiri Slider.
 *
 * @since 1.0.0
 */
class Cycle_Heading extends Widget_Base {

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
		return 'ce-cycle-heading';
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
		return __( 'Cycle Heading', 'cowidgets' );
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
		return 'ce-icon-cycle-heading';
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
		return [ 'ce-content-widgets' ];
	}

	public function get_script_depends() {
		return [ 'ce-cycle-heading' ];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_cycle_heading_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_cycle_heading_controls() {
		$this->start_controls_section(
			'Cycle Headings',
			[
				'label' => __( 'Headings', 'cowidgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();


        
        $repeater->add_control(
			'desc',
			[
				'label' => __( 'Content', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Remake website', 'cowidgets' ),
				'placeholder' => __( 'Type your description here', 'cowidgets' ),
			]
		);


		$this->add_control(
			'headings',
			[
				'label' => __( 'Cycle Contents', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					
				]
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_slider',
			[
				'label'     => __( 'Style', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );  
            
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-cycle-heading .first-line span',
			]
		);

		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
					'{{WRAPPER}} .ce-cycle-heading .content' => 'color: {{VALUE}}',
                ],
                
            ]
        );

		$this->end_controls_section();
	}

	/**
	 * Render Copyright output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="ce-cycle-heading">
			<div class="wrapper">

					
					<div class="ce-heading">
                        <div class="content">
                            <div class="first-line">Re <div class="ul-wrapper"><ul>
									<li>make</li>
									<li>do</li>
									<li>new</li>
									<li>set</li>
									<li>boot</li>
									<li>fuel</li>
									<li>ward</li>
									<li>claim</li>
									<li>bound</li>
									<li>affirm</li>
									<li>deem</li>
									<li>grow</li>
								</ul></div>
                            </div>
							<div class="second-line"><div class="ul-wrapper"><ul>
								<li>your portfolio</li>
								<li>your website</li>
								<li>your UX</li>
								<li>your target</li>
								<li>your pixels</li>
								<li>your whitespace</li>
								<li>your audience</li>
								<li>your business</li>
								<li>thru' your hurdles</li>
								<li>your clients</li>
								<li>your hardwork</li>
								<li>your hunger</li>
							</ul>
                            </div>
                        </div>
                    </div>
					
				
            </div>
		</div>
		<?php
	}

	/**
	 * Render shortcode widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {}

	/**
	 * Render shortcode output in the editor.
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
