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
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Elementor Portfolio Carousel
 *
 * Elementor widget for Portfolio Carousel.
 *
 * @since 1.0.0
 */
class Video_Play_Button extends Widget_Base {

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
		return 'ce-video-play-button';
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
		return __( 'Video Play Button', 'cowidgets' );
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
		return 'ce-icon-play-button';
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
		return [ 'ce-video-play-button' ];
    }

	/**
	 * Register controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_posts_grid_controls();
	}
	/**
	 * Register General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_posts_grid_controls() {
		
		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => __( 'Item Layout/Style', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'vid_url',
			[
				'label' => __( 'Video URL', 'cowidgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'https://www.youtube.com/watch?v=kxPCFljwJws',
				
			]
        );

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-play',
					'library' => 'solid',
				],
				
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_playbtn',
			[
				'label'     => __( 'Button  Styles', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
            'btnbg_color',
            [
                'label'     => __( 'Play Button Background Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dfe2f3;',
                'selectors' => [
					'{{WRAPPER}} .play-box' => 'background-color: {{VALUE}}',
                ],
                
            ]
		);
		$this->add_control(
            'btnicon_color',
            [
                'label'     => __( 'Play Button Icon Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#5d6cc1;',
                'selectors' => [
					'{{WRAPPER}} .play-box' => 'color: {{VALUE}}',
                ],
                
            ]
		);
		$this->add_control(
			'size',
			[
				'label' => __( 'Button Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 60,
						'max' => 200,
						'step' => 5,
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .play-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $this->add_control(
			'isize',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .play-box' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'lineheight',
			[
				'label' => __( 'Icon Line Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .play-box' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .play-box',
			]
		);
       
		$this->end_controls_section();
		$this->start_controls_section(
			'btnhover',
			[
				'label'     => __( 'Button Hover Styles', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
            'btn_line_colorh',
            [
                'label'     => __( 'Button Background Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dfe2f3;',
                'selectors' => [
					'{{WRAPPER}} .play-box:hover' => 'background-color: {{VALUE}}',
                ],
                
            ]
		);
		$this->add_control(
            'btn_icon_colorh',
            [
                'label'     => __( 'Button Icon Color', 'cowidgets' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#5d6cc1',
                'selectors' => [
					'{{WRAPPER}} .play-box:hover' => 'color: {{VALUE}}',
                ],
                
            ]
		);
		$this->add_control(
			'sizeh',
			[
				'label' => __( 'Button Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 60,
						'max' => 200,
						'step' => 5,
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .play-box:hover' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $this->add_control(
			'isizeh',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .play-box:hover' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadowh',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .play-box:hover',
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
        
        	<a href="<?php echo esc_url($settings['vid_url']) ?>" class=" play-box" data-fancybox="gallery" style="width:<?php echo esc_attr( $settings['size']['size'] ); ?>px;height:<?php echo esc_attr( $settings['size']['size'] ); ?>px;"><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			
		</a>
       
		
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
