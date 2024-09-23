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
 * Elementor Lana Slider
 *
 * Elementor widget for Lana Slider.
 *
 * @since 1.0.0
 */
class Lana_Slider extends Widget_Base {

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
		return 'lana-slider';
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
		return __( 'Lana Slider', 'cowidgets' );
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
		return 'ce-icon-lana-slider';
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
		return [ 'ce-lana-slider', 'swiper' ];
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
		$this->register_lana_slider_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_lana_slider_controls() {
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
			'pattern_img',
			[
				'label' => __( 'Pattern Img', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );

        $repeater->add_control(
            'pattern_bg',
            [
                'label'     => __( 'Pattern BG', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => [
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
			'description',
			[
				'label' => __( 'Description', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Indicators of shared value, living a fully ethical life with the social return on investment improve the world and activate a dynamic systematic thinking. While best practices save the world and empower communities', 'cowidgets' ),
				'placeholder' => __( 'Type your title here', 'cowidgets' ),
			]
		);

		$repeater->add_control(
			'link',
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
        
        $repeater->add_control(
			'skin',
			[
				'label' => __( 'Slide Skin', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light'	=> __( 'Light', 'cowidgets' ),
					'dark'	=> __( 'Dark', 'cowidgets' )
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
			'section_style_slider',
			[
				'label'     => __( 'Slider', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );  
            
            
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'      => 'title_typography',
                'label'     => 'Title Typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-lana-slider .title h2',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'      => 'desc_typography',
                'label'     => 'Description Typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ce-lana-slider .desc',
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'      => 'nav_typography',
                'label'     => 'Nav & Pagination Typography',
				'separator' => 'before',
				'selectors'  => [
                    '{{WRAPPER}} .ce-lana-slider .project-number',
                    '{{WRAPPER}} .ce-lana-slider .navigation',
                ]
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
		<div class="ce-lana-slider swiper-container">
            <div class="swiper-wrapper">
            
                <?php 
                
                if( !empty($settings['slides']) ): 
                    foreach($settings['slides'] as $slide): 
                        $extra_style = 'background: '.$slide['pattern_bg'].' url('.$slide['pattern_img']['url'].') repeat center';
                ?>
                        <div class="swiper-slide skin-<?php echo esc_attr( $slide['skin'] ) ?>">
                            <div class="slide-wrapper" style="<?php echo esc_attr( $extra_style ) ?>">
                                <div class="image-wrapper">
                                    <img src="<?php echo esc_url( $slide['image']['url'] ) ?>" alt="image" />
                                    <div class="overlay"></div>
                                    
                                </div>
								<div class="content-wrapper">
									<div class="title">
										<h2><a href="<?php echo esc_url( $slide['link']['url'] ) ?>"><?php echo wp_kses_post( $slide['title'] ) ?></a></h2>
									</div>

									<div class="desc">
										<p><?php echo wp_kses_post( $slide['description'] ) ?></p>
									</div>
								</div>
                                
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>

            </div>


            <div class="project-number">
                <span class="text"><?php esc_html_e('Project', 'cowidgets'); ?></span>
                <span class="actual">1</span>
                <span class="total"> of <?php echo count( $settings['slides'] ) ?></span>
            </div>

            <div class="navigation">
                <a href="#" class="next"><?php esc_html_e('Next', 'cowidgets'); ?></a>
                <a href="#" class="prev"><?php esc_html_e('Previous', 'cowidgets'); ?></a>
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
