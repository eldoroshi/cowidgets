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
class Beas_Slider extends Widget_Base {

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
		return 'beas-slider';
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
		return __( 'Beas Slider', 'codeless-elements' );
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
		return 'ce-icon-beas-slider';
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
		return [ 'ce-beas-slider', 'swiper' ];
	}

	public function get_style_depends() {
		return [ 'swiper' ];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_beas_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_beas_slider_controls() {
		$this->start_controls_section(
			'slides_section',
			[
				'label' => __( 'Slides', 'codeless-elements' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Text', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default Title', 'codeless-elements' ),
				'placeholder' => __( 'Type your title here', 'codeless-elements' ),
			]
		);

		

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'codeless-elements' ),
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
				'label'     => __( 'Slider', 'codeless-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );  
            

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-beas-slider .content',
			]
		);

		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'codeless-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
					'{{WRAPPER}} .ce-beas-slider, {{WRAPPER}} .ce-beas-slider .content' => 'color: {{VALUE}}',
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
		<div class="ce-beas-slider swiper-container">
			<div class="slider-wrapper swiper-wrapper">
				<?php
				
				if( !empty( $settings['slides'] ) ):
					foreach( $settings['slides'] as $slide ): ?>
					
					<div class="cl-slide swiper-slide">
						<div class="slide-wrapper">
							<div class="image ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="400" data-delay="0">
								<img src="<?php echo esc_url( $slide['image']['url'] ) ?>" alt="slide alt" />
							</div>
							<div class="content">
								<div class="ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="500" data-delay="300"><?php echo wp_kses_post( $slide['text'] ) ?></div>
							</div>
						</div>
					</div>
					
					<?php endforeach;
				endif; ?>
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
