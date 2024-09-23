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
class Tapi_Slider extends Widget_Base {

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
		return 'tapi-slider';
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
		return __( 'Tapi Slider', 'cowidgets' );
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
		return 'ce-icon-tapi-slider';
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
		return [ 'ce-tapi-slider', 'swiper' ];
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
		$this->register_tapi_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_tapi_slider_controls() {
		$this->start_controls_section(
			'slides_section',
			[
				'label' => __( 'Slides', 'cowidgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default Title', 'cowidgets' ),
				'placeholder' => __( 'Type your title here', 'cowidgets' ),
			]
		);

		$repeater->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Start Now', 'cowidgets' ),
				'placeholder' => __( 'Type your title here', 'cowidgets' ),
			]
		);

		$repeater->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'cowidgets' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_other',
			[
				'label'     => __( 'Other', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'scroll_indicator',
			[
				'label' => __( 'Scroll Indicator', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'right_side_light',
				'options' => [
					'none'				=> __( 'None', 'cowidgets' ),
					'right_side_light'	=> __( 'Right Side Light (dark bg)', 'cowidgets' ),
					'right_side_dark'	=> __( 'Right Side Dark (light bg)', 'cowidgets' ),
					'left_side_light'	=> __( 'Left Side Light (dark bg)', 'cowidgets' ),
					'right_side_dark'	=> __( 'Right Side Dark (light bg)', 'cowidgets' ),
				],
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_slider',
			[
				'label'     => __( 'Slider', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );  
            
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background',
                    'label' => __( 'Background', 'cowidgets' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .ce-tapi-slider',
                ]
            );


			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Images Overlay Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.2)',
					'selectors' => [
						'{{WRAPPER}} .ce-tapi-slider .slide-wrapper .image:after' => 'background-color: {{VALUE}}',
					],
					
				]
			);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-tapi-slider .content h2',
			]
		);

		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
					'{{WRAPPER}} .ce-tapi-slider, {{WRAPPER}} .ce-tapi-slider h2' => 'color: {{VALUE}}',
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
		<div class="ce-tapi-slider swiper-container">
			<div class="slider-wrapper swiper-wrapper">
				<?php
				
				if( !empty( $settings['slides'] ) ):
					foreach( $settings['slides'] as $slide ): ?>
					
					<div class="cl-slide swiper-slide">
						<div class="slide-wrapper">
							<div class="image ce-animation ce-animation--zoom-in ce-animation-manual" data-speed="400" data-delay="0">
								<img src="<?php echo esc_url( $slide['image']['url'] ) ?>" alt="slide alt" />
							</div>
							<div class="content">
								<h2 class="ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="400" data-delay="400"><?php echo wp_kses_post( $slide['title'] ) ?></h2>
								<a href="<?php echo esc_url( $slide['btn_link']['url'] ) ?>"  class="button ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="600" data-delay="400"><span><?php echo esc_html( $slide['btn_text'] ) ?></span><i class="feather feather-arrow-right"></i></a>
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
