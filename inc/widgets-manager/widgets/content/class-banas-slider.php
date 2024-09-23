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
 * Elementor Banas Slider
 *
 * Elementor widget for Kiri Slider.
 *
 * @since 1.0.0
 */
class Banas_Slider extends Widget_Base {

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
		return 'banas-slider';
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
		return __( 'Banas Slider', 'codeless-elements' );
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
		return 'ce-icon-banas-slider';
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
		return [ 'ce-banas-slider' ];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_banas_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_banas_slider_controls() {
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
			'title',
			[
				'label' => __( 'Title', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default Title', 'codeless-elements' ),
				'placeholder' => __( 'Type your title here', 'codeless-elements' ),
			]
        );
        
        $repeater->add_control(
			'desc',
			[
				'label' => __( 'Description', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Text', 'codeless-elements' ),
				'placeholder' => __( 'Type your title here', 'codeless-elements' ),
			]
		);

		$repeater->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Case Study', 'codeless-elements' ),
				'placeholder' => __( 'Type your title here', 'codeless-elements' ),
			]
		);

		$repeater->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'codeless-elements' ),
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
				'label' => __( 'Slides', 'codeless-elements' ),
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
				'label'     => __( 'Other', 'codeless-elements' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'scroll_indicator',
			[
				'label' => __( 'Scroll Indicator', 'codeless-elements' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'right_side_light',
				'options' => [
					'none'				=> __( 'None', 'codeless-elements' ),
					'right_side_light'	=> __( 'Right Side Light (dark bg)', 'codeless-elements' ),
					'right_side_dark'	=> __( 'Right Side Dark (light bg)', 'codeless-elements' ),
					'left_side_light'	=> __( 'Left Side Light (dark bg)', 'codeless-elements' ),
					'right_side_dark'	=> __( 'Right Side Dark (light bg)', 'codeless-elements' ),
				],
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
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background',
                    'label' => __( 'Background', 'codeless-elements' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .ce-banas-slider, {{WRAPPER}} .ce-banas-slider .cl-slide',
                ]
            );


			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Images Overlay Color', 'codeless-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.2)',
					'selectors' => [
						'{{WRAPPER}} .ce-banas-slider .overlay' => 'background-color: {{VALUE}}',
					],
					
				]
			);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-banas-slider .content h2',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'desc_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-banas-slider .content .desc',
			]
		);

		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'codeless-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
					'{{WRAPPER}} .ce-banas-slider .content h2 a, {{WRAPPER}} .ce-banas-slider .content .desc p,  {{WRAPPER}} .ce-banas-slider .view-project, {{WRAPPER}} .ce-banas-slider .pagination a, {{WRAPPER}} .ce-banas-slider .scroll span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ce-banas-slider .pagination a:before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .ce-banas-slider .pagination a:before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .ce-banas-slider .scroll svg path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ce-banas-slider .content h2 a:hover' => 'color: {{VALUE}} !important'
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
        <div class="ce-banas-slider swiper-container">
            <!-- Additional required wrapper -->
            <div class="slider-wrapper swiper-wrapper">
                <?php 
                    if( !empty( $settings['slides'] ) ):
					    foreach( $settings['slides'] as $slide ): ?>
                        <div class="cl-slide swiper-slide">
                            <div class="image-wrapper">
                                <img src="<?php echo esc_url( $slide['image']['url'] ) ?>" alt="image" />
								<div class="overlay"></div>
                            </div>

                            <div class="content">
                                <h2><a href="<?php echo esc_url( $slide['btn_link']['url'] ) ?>"><?php echo esc_html( $slide['title'] ) ?></a></h2>
                                <div class="desc">
                                    <p><?php echo wp_kses_post( $slide['desc'] ) ?></p>
                                </div>

                                <a class="view-project" href="<?php echo esc_url( $slide['btn_link']['url'] ) ?>"><?php echo esc_html($slide['btn_text']) ?><i class="feather feather-arrow-right"></i></a>
                            </div>         
                        </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
            </div>


            <div class="pagination">
                
            </div>
        
            <div class="scroll">
                <span class="text"><?php esc_html_e('Scroll', 'remake'); ?></span>
                <svg width="12" height="36" viewBox="0 0 12 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.4375 0V34.1016L1.35938 29.9531L0.515625 30.8672L5.57812 36H6.42188L11.4844 30.8672L10.6406 30.0234L6.5625 34.1016V0H5.4375Z" fill="white"/>
                </svg>
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
