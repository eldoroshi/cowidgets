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
 * Elementor Post Navigation
 *
 * Elementor widget for Post Navigation.
 *
 * @since 1.0.0
 */
class Post_Navigation extends Widget_Base {

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
		return 'ce-post-navigation';
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
		return __( 'Post Navigation', 'cowidgets' );
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
		return 'ce-icon-post-navigation';
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

	
	/**
	 * Register Copyright controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_post_navigation_controls();
	}
	/**
	 * Register Copyright General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_post_navigation_controls() {

		$this->start_controls_section(
			'section_content_other',
			[
				'label'     => __( 'Navigation Options', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'style',
			[
				'label' => __( 'Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'lark',
				'options' => apply_filters( 'ce_load_element_styles', [
					'lark'	=> __( 'Lark', 'cowidgets' )
				] ),
			]
        );

        $this->add_control(
			'back_to',
			[
				'label' => __( 'Back To', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
					1	=> __( 'Yes', 'cowidgets' )
                ],
			]
        );

        $this->add_control(
			'back_to_link',
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
                'condition' => [
                    'back_to' => '1'
                ]
            ]
            
        );

        $this->add_control(
			'back_to_text',
			[
				'label' => __( 'Back To Text', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'All Projects', 'cowidgets' ),
                'placeholder' => __( 'Type your title here', 'cowidgets' ),
                'condition' => [
                    'back_to' => '1'
                ]
            ]
            
		);


        $this->add_control(
			'same_term',
			[
                'label' => __( 'In the same term?', 'cowidgets' ),
                'description' => __( 'If true, will show the next/prev post of the same category as the actual post.', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
					1	=> __( 'Yes', 'cowidgets' )
                ]
			]
        );
		

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_style',
			[
				'label'     => __( 'Navigation Style', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'label_typography',
                    'label'     => 'Label Typography',
                    'separator' => 'before',
                    'selector'  => '{{WRAPPER}} .ce-post-navigation .item-label',
                ]
            );

			$this->add_control(
				'label_color',
				[
					'label'     => __( 'Label Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => [
						'{{WRAPPER}} .ce-post-navigation .item-label' => 'color: {{VALUE}}',
					],
					
				]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'title_typography',
                    'label'     => 'Post Title Typography',
                    'separator' => 'before',
                    'selector'  => '{{WRAPPER}} .ce-post-navigation .item-title',
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label'     => __( 'Title Color', 'cowidgets' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => [
						'{{WRAPPER}} .ce-post-navigation .item-title' => 'color: {{VALUE}}',
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
        $this->add_render_attribute( 'ce-post-navigation', 'class', [ 'ce-post-navigation', 'ce-post-navigation-style-' . $settings['style'] ] );

		// Sanitize the style parameter
		$sanitized_style = sanitize_file_name( $settings['style'] );

		// Construct the file path
		$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/post-navigation/' . $sanitized_style . '.php';

		// Validate the file path to ensure it's within the expected directory
		if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/post-navigation/') ) === 0 ) {
			// Include the file if it exists and is within the expected directory
			include( $file_path );
		} else {
			// Handle the error, e.g., show a default message or log the error
			echo 'Invalid file path';
		}


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
