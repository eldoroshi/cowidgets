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
class Codeless_Mailchimp_Widget extends Widget_Base {

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
		return 'mailchimp-form';
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
		return __( 'Mailchimp Form', 'codeless-elements' );
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
		return [];
	}

	public function get_style_depends() {
		return [];
	}

	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_mailchimp_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_mailchimp_controls() {
		$this->start_controls_section(
			'section_content',
		    [
		    	'label' => 'Settings',
		    ]
		);
		
		$this->add_control(
            'title',
            [
                'label' => __('Title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Sign up for our newsletter!',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub title', 'cowidgets'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Get notified about updates and be the first to get early access to new episodes.',
            ]
        );

        $this->add_control(
			'item_style',
			[
				'label' => __( 'Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'cowidgets' ),
					'light' => __( 'Light Transparent', 'cowidgets' ),
					'dark' => __( 'Dark Transparent', 'cowidgets' ),
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
		$title = !empty( $settings['title'] ) ? $settings['title'] : '';
		$sub_title = !empty( $settings['sub_title'] ) ? $settings['sub_title'] : '';
		$class = !empty( $settings['item_style'] ) ? $settings['item_style'] : 'default';
		?>
		<div class="ce-mailchimp-form <?php echo esc_attr( $class ); ?>">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-5">
					<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
						<div class="ce-head">
							<?php if( !empty( $title ) ){ ?>
								<h2>
									<?php echo esc_html( $title ); ?>
								</h2>
							<?php } ?>
							<?php if( !empty( $sub_title ) ){ ?>
								<p>
									<?php echo esc_html( $sub_title ); ?>
								</p>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-1">
					<div class="ce-form-wrapper">
						<?php					
							$args = array(
							    'post_type'   => 'mc4wp-form',
							    'posts_per_page' => 1,
							);
							$forms = get_posts( $args );
							if( !empty( $forms ) ){
								foreach ($forms as $post) {	
								    echo do_shortcode('[mc4wp_form id="'.esc_attr($post->ID).'"]');
								}
							} else {
								esc_html_e('No form found', 'cowidgets');
							}
						?>
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
