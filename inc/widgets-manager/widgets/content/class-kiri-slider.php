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
class Kiri_Slider extends Widget_Base {

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
		return 'kiri-slider';
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
		return __( 'Kiri Slider', 'cowidgets' );
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
		return 'ce-icon-kiri-slider';
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
		return [ 'ce-kiri-slider' ];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_kiri_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_kiri_slider_controls() {
		\COWIDGETS_Helpers::slidesSelectionSection( $this );
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
			$this->add_control(
				'slider_background_color',
				[
					'label'     => __( 'Background Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => [
						'{{WRAPPER}} .ce-kiri-slider' => 'background-color: {{VALUE}}',
					],
					
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Images Overlay Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.1)',
					'selectors' => [
						'{{WRAPPER}} .ce-kiri-slider .slide-img:after' => 'background-color: {{VALUE}}',
					],
					
				]
			);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-kiri-slider .slide-title a',
			]
		);

		$this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
					'{{WRAPPER}} .ce-kiri-slider' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ce-kiri-slider .slide-title a' => '-webkit-text-stroke-color: {{VALUE}};',
					'{{WRAPPER}} .ce-kiri-slider .slide-title.active a' => 'color: {{VALUE}};'
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
		$slider_type = 'images';
		if( $settings['source_type'] == 'videos' )
			$slider_type = 'videos';

		?>
		<div class="ce-kiri-slider" data-slider-type="<?php echo esc_attr( $slider_type ) ?>">
			<div class="slider-wrapper">
			
			<?php 

			$slides = \COWIDGETS_Helpers::getslidesSelection( $settings );
		
			?>
			
			<div class="images-wrapper">
				<div class="slide-img-wrapper">
				<?php
				$nr = 0;
				if( !empty($slides) ): 
					foreach($slides as $slide): 
						$nr++;

						$extra_class = '';
						$load_lazy = 'data-';
						if( $nr == 1 ){
							$extra_class = 'active';
							$load_lazy = '';
						}
						
						if( $nr > 7 )
							$extra_class = 'next';

						$load_lazy = '';
						
				?>
					<div class="slide-img <?php echo esc_attr( $extra_class ) ?>">
						<?php if( $settings['source_type'] != 'videos' ): ?>
						<img loading="lazy" <?php echo esc_attr($load_lazy) ?>src="<?php echo esc_url( $slide['src'] ) ?>" alt="slide alt" />
						<?php endif; ?>

						<?php if( $settings['source_type'] == 'videos' ): ?>
						<video muted loop <?php if( $nr == 1 ) echo 'autoplay' ?>>
						 	<?php if( $slide['video_media'] && is_array( $slide['video_media'] ) ): ?>
							<source src="<?php echo esc_url( $slide['video_media']['url'] ) ?>" type="<?php echo esc_attr( get_post_mime_type( $slide['video_media']['id'] ) ) ?>">
							<?php endif; ?>
						</video>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
			</div>     
			
			
			<div class="title-wrapper">

			<?php
			$nr = 0;
			if( !empty($slides) ): 
				foreach($slides as $slide): 

					$nr++;

					$extra_class = '';
					if( $nr == 1 )
						$extra_class = 'active';
					
					if( $nr > 7 )
						$extra_class = 'next';
	
			?>
					<?php if( $settings['source_type'] != 'videos' ): ?>
						<div class="slide-title <?php echo esc_attr( $extra_class ) ?> ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="600" data-delay="<?php echo esc_attr( ( ($nr % 7 ) + 1) * 150 ) ?>" data-id="<?php echo esc_attr( $nr ) ?>"><a href="<?php echo esc_url( $slide['permalink'] ) ?>"><?php echo esc_html( $slide['title'] ) ?></a></div>
					<?php endif; ?>

					<?php if( $settings['source_type'] == 'videos' ): ?>
						<div class="slide-title <?php echo esc_attr( $extra_class ) ?> ce-animation ce-animation--bottom-t-top ce-animation-manual" data-speed="600" data-delay="<?php echo esc_attr(( ($nr % 7 ) + 1) * 150 ) ?>" data-id="<?php echo esc_attr( $nr ) ?>"><a href="<?php echo esc_url( $slide['video_permalink']['url'] ) ?>"><?php echo esc_html( $slide['video_title'] ) ?></a></div>
					<?php endif; ?>				

				

				<?php endforeach; ?>
			<?php endif; ?>
			
			</div>  
		</div>

		<div class="project-number">
			<span class="text"><?php esc_html_e('Project', 'cowidgets'); ?></span>
			<span class="actual">1</span>
			<span class="total"> / <?php echo count( $slides ) ?></span>
		</div>
		
		<?php if( $settings['scroll_indicator'] != 'none' ): ?>
		<div class="cl-scroll-indicator style-<?php echo esc_attr( $settings['scroll_indicator'] ) ?>">
			<span class="text"><?php esc_html_e( 'Scroll', 'cowidgets' ); ?></span>
			<svg width="12" height="36" viewBox="0 0 12 36" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M5.4375 0V34.1016L1.35938 29.9531L0.515625 30.8672L5.57812 36H6.42188L11.4844 30.8672L10.6406 30.0234L6.5625 34.1016V0H5.4375Z" fill="white"/>
			</svg>
		</div>
		<?php endif; ?>
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
