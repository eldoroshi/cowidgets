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
 * Elementor Staff Carousel
 *
 * Elementor widget for Staff Carousel.
 *
 * @since 1.0.0
 */
class Staff_Carousel extends Widget_Base {

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
		return 'ce-staff-carousel';
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
		return __( 'Staff Carousel', 'cowidgets' );
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
		return 'ce-icon-staff-carousel';
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
		return [ 'ce-staff-carousel', 'tiny-slider' ];
    }
    
    public function get_style_depends() {		
        return [ 'tiny-slider' ];
    }

	/**
	 * Register controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_staff_carousel_controls();
	}
	/**
	 * Register General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_staff_carousel_controls() {
		\COWIDGETS_Helpers::staffSelectionSection( $this );
		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => __( 'Item Layout/Style', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);	

		$this->add_control(
			'item_style',
			[
				'label' => __( 'Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => apply_filters( 'ce_load_element_styles', [
					'default'	=> __( 'Default', 'cowidgets' ),
					'beas'	=> __( 'Beas', 'cowidgets' ),
					'modern'	=> __( 'modern', 'cowidgets' ),
				] ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_size',
				'label'   => __( 'Image Size', 'cowidgets' ),
				'default' => 'full',
			]
		);
        
        $this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
                    1				=> __( '1', 'cowidgets' ),
                    2				=> __( '2', 'cowidgets' ),
                    3				=> __( '3', 'cowidgets' ),
                    4				=> __( '4', 'cowidgets' ),
                    5				=> __( '5', 'cowidgets' ),
                    6				=> __( '6', 'cowidgets' ),
                    7				=> __( '7', 'cowidgets' ),
				],
				'render_type' => 'template'
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_carousel',
			[
				'label'     => __( 'Carousel Options', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'slide_by',
			[
				'label' => __( 'Slide By', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
                    '1'				=> __( '1', 'cowidgets' ),
                    'page'			=> __( 'Page', 'cowidgets' ),
				],
			]
        );

        $this->add_control(
			'mode',
			[
				'label' => __( 'Mode', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
                    'carousel'	=> __( 'Carousel', 'cowidgets' ),
                    'gallery'	=> __( 'Gallery', 'cowidgets' ),
				],
			]
        );
        
        $this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
        );

        $this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
        );

        

        $this->add_control(
			'center',
			[
				'label' => __( 'Center', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
        );

        $this->add_control(
			'mouse_drag',
			[
				'label' => __( 'Mouse Drag', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
		);
		
		$this->add_control(
			'carousel_controls',
			[
				'label' => __( 'Prev/Next Buttons', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
        );

        $this->add_control(
			'vertical_align',
			[
				'label' => __( 'Items Vertical Align', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
                    'top'	    => __( 'Top', 'cowidgets' ),
                    'middle'	=> __( 'Middle', 'cowidgets' ),
                    'bottom'	=> __( 'Bottom', 'cowidgets' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-staff-carousel .tns-item' => 'vertical-align: {{VALUE}}',
                ],

                'render_type' => 'template'
			]
        );

        $this->add_control(
			'start_index',
			[
				'label' => __( 'Start Index', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '0',
			]
        );
        
        $this->add_control(
			'gutter',
			[
				'label'       => __( 'Space between items', 'cowidgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
				'range'       => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'default'     => [
					'size' => 15,
					'unit' => 'px',
				],
				'render_type' => 'template',
			]
        );


        
        $this->add_control(
			'edge_padding',
			[
				'label'       => __( 'Space on the outside', 'cowidgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
				'range'       => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'default'     => [],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'edge_padding_side',
			[
				'label'       => __( 'Space on the outside only one side', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0	=> __( 'No', 'cowidgets' ),
                    1	=> __( 'Yes', 'cowidgets' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Global', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'global_important_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'This section contains global styling options of this element. Some of this options should not work on specific selected styles. Please check the section below for style-specific options.', 'cowidgets' ),
				'content_classes' => 'important_note'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'staff_name_typography',
				'label' => __( 'Staff Name Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-staff-item .team-name',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => __( 'Staff Name Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item .team-name' => 'color: {{VALUE}}',
				],
			]
        );
        
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'staff_position_typography',
				'label' => __( 'Staff Work Position Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-staff-item .team-position',
			]
		);

		$this->add_control(
			'staff_position_color',
			[
				'label' => __( 'Staff Work Position Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item .team-position' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'staff_social_color',
			[
				'label' => __( 'Staff Socials Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item .team-socials a' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_specific_style',
			[
				'label'     => __( 'Style-specific', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'specific_important_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'This section contains style-specific options, these options may disappear when you change selected item-style', 'cowidgets' ),
				'content_classes' => 'important_note'
			]
		);

		do_action( 'ce_load_style_specific_options', $this );

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Separator Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item .data' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'beas'
				]
			]
        );

        $this->add_control(
			'quote_color',
			[
				'label' => __( 'Quote SVG Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item svg path' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'beas'
				]
			]
		);
        
        $this->add_control(
			'nav_item_color',
			[
				'label' => __( 'Prev/Next Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-staff-item .ce-staff-carousel-controls a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'beas'
				]
			]
		);


		$this->end_controls_section();
        
        \COWIDGETS_Helpers::animationSection( $this );
	}

	function set_source_type( $source ){
		$this->source_type = $source;
	}

	function get_source_type(){
		return $this->source_type;
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

		$this->set_source_type( $settings['source_type'] );

        $this->add_render_attribute( 'ce-staff-carousel', 'class', [ 'ce-staff-carousel', 'ce-staff-style-' . $settings['item_style'] ] );
		$this->add_render_attribute( 'ce-staff-carousel', 'data-columns', $settings['columns'] );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-autoplay', $settings['autoplay'] );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-slide-by', ( $settings['slide_by'] == 'page' ? $settings['columns'] : $settings['slide_by'] ) );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-loop', $settings['loop'] );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-gutter', $settings['gutter']['size'] );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-center', $settings['center'] );
        $this->add_render_attribute( 'ce-staff-carousel', 'data-mode', $settings['mode'] );
		$this->add_render_attribute( 'ce-staff-carousel', 'data-mouse-drag', $settings['mouse_drag'] );
		$this->add_render_attribute( 'ce-staff-carousel', 'data-edge-padding-side', $settings['edge_padding_side'] );
		$this->add_render_attribute( 'ce-staff-carousel', 'data-carousel-controls', $settings['carousel_controls'] );

        $this->add_render_attribute( 'ce-staff-item', 'class', ['ce-staff-item'] );

        if( $settings['ce_animation'] != 'none' ){
            $this->add_render_attribute( 'ce-staff-item', 'class', ['ce-animation', 'ce-animation--'.$settings['ce_animation'], 'ce-animation-manual' ] );
            $this->add_render_attribute( 'ce-staff-item', 'data-speed', $settings['ce_animation_speed'] );
            
        }

        if( isset( $settings['edge_padding'] ) && !empty( $settings['edge_padding'] ) )
            $this->add_render_attribute( 'ce-staff-carousel', 'data-edge-padding', $settings['edge_padding']['size'] );

        if( isset( $settings['start_index'] ) && !empty( $settings['start_index'] ) )
            $this->add_render_attribute( 'ce-staff-carousel', 'data-start-index', $settings['start_index'] );
        

		?>
		<?php if( $settings['carousel_controls'] ){ ?>
			<div class="ce-carousel-head">
                <div class="ce-staff-carousel-controls">
                    <a href="#" class="ce-prev"><i class="feather feather-arrow-left"></i></a>
                    <a href="#" class="ce-next"><i class="feather feather-arrow-right"></i></a>
                </div>            	
			</div>
		<?php } ?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-staff-carousel' ) ); ?>>

            <?php
                
                if( $settings['source_type'] == 'staff' ){ 
                    $new_query = array(
                        'posts_per_page' => (int) $settings['items_per_page'],
                        'post_type' => 'staff' 
                    );

					if( $settings['items_orderby'] != 'none' ){
						$new_query['orderby'] = $settings['items_orderby'];
						$new_query['order'] = $settings['items_order'];
					}

                    if( is_array( $settings['items_categories'] ) && !empty( $settings['items_categories'] ) ) {
                    
                        $new_query['tax_query'] = array(
                            
                            array(
                                'taxonomy' => 'staff_entries',
                                'field' => 'slug',
                                'terms' => $settings['items_categories'],
                                'operator' => 'IN' 
                            ) 
                        );
                    }

                    if( !empty( $settings['items_staff'] ) ){
                        $new_query['ignore_sticky_posts'] = 1;
                        $new_query['post__in'] = $settings['items_staff'];
                        $new_query['ignore_custom_sort'] = true;
					}
					
                }else if( $settings['source_type'] == 'all_post_types' ) {
					$new_query['post__in'] = $settings['items_posts'];
					
                }

                $the_query = new \WP_Query( $new_query );
                
                if ( is_object( $the_query ) && $the_query->have_posts() ) :
					$counter = 0;
                    // Start loop
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<?php 
							$counter += 1;
							$delay = ( $counter * (int) $settings['ce_animation_delay'] );
							if( $counter > $settings['columns'] )
								$delay = 0;


							$this->add_render_attribute( 'ce-staff-item-'.get_the_ID(), 'data-delay', $delay );
						?>
                        <?php
						// Sanitize the item_style parameter
						$sanitized_item_style = sanitize_file_name( $settings['item_style'] );

						// Construct the file path
						$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/staff/' . $sanitized_item_style . '.php';

						// Validate the file path to ensure it's within the expected directory
						if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/staff/') ) === 0 ) {
							// Include the file if it exists and is within the expected directory
							include( $file_path );
						} else {
							// Handle the error, e.g., show a default message or log the error
							echo 'Invalid file path';
						}
						?>

                    <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
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
