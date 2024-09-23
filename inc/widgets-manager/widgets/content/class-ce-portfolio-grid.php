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
 * Elementor Portfolio Grid
 *
 * Elementor widget for Portfolio Grid.
 *
 * @since 1.0.0
 */
class Portfolio_Grid extends Widget_Base {

	private $source_type;

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
		return 'ce-portfolio-grid';
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
		return __( 'Portfolio Grid', 'cowidgets' );
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
		return 'ce-icon-portfolio-grid';
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
		return [ 'ce-portfolio-grid' ];
    }

	/**
	 * Register controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_portfolio_grid_controls();
	}
	/**
	 * Register General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_portfolio_grid_controls() {
		\COWIDGETS_Helpers::portfolioSelectionSection( $this );
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
				'default' => 'beas',
				'options' => apply_filters( 'ce_load_element_styles', [
					'simple'	=> __( 'Simple', 'cowidgets' ),
					'beas'		=> __( 'Beas', 'cowidgets' ),
					'jasper'	=> __( 'Jasper', 'cowidgets' ),
					'ishmi'		=> __( 'Ishmi', 'cowidgets' ),
					'amber'		=> __( 'Amber', 'cowidgets' ),
					'erzen'		=> __( 'Erzen', 'cowidgets' ),
					'alder'		=> __( 'Alder', 'cowidgets' ),
					'remake'	=> __( 'Remake', 'cowidgets' ),
				] ),
			]
        );

        $this->add_control(
			'module',
			[
				'label' => __( 'Grid Module', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'isotope',
				'options' => [
                    'isotope'	    => __( 'Standard Isotope (with Filters)', 'cowidgets' ),
                    'predefined'	=> __( 'Predefined Blocks (Parallax)', 'cowidgets' ),
                    'justify'	    => __( 'Justify Gallery', 'cowidgets' ),
				],
			]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_size',
				'label'   => __( 'Image Size', 'cowidgets' ),
				'default' => 'medium',
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
                    'item_style' => ['alder']
                ]
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_module',
			[
				'label'     => __( 'Module Options', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'isotope_layout',
			[
				'label' => __( 'Isotope Layout', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'masonry',
				'options' => [
                    'masonry'   => __( 'Masonry', 'cowidgets' ),
                    'fitRows'	=> __( 'FitRows', 'cowidgets' )
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'isotope'
                ]
			]
		);
        
        $this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
                    1				=> __( '1', 'cowidgets' ),
                    2				=> __( '2', 'cowidgets' ),
                    3				=> __( '3', 'cowidgets' ),
                    4				=> __( '4', 'cowidgets' ),
                    5				=> __( '5', 'cowidgets' ),
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => ['isotope']
                ]
			]
        );

        $this->add_responsive_control(
			'space_between',
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
                    'unit' => 'px',
                    'size' => 15
                ],
				'selectors'   => [
					'{{WRAPPER}} .ce-portfolio-grid .ce-portfolio-item' => 'padding: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-portfolio-grid' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}'
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'isotope'
                ]
			]
		);
        $this->add_control(
			'isotope_filters',
			[
				'label' => __( 'Isotope Filters', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0 => __( 'No', 'cowidgets' ),
                    1 => __( 'Yes', 'cowidgets' )
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'isotope'
                ]
			]
		);
		$this->add_control(
			'filters_style',
			[
				'label' => __( 'Filters Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
                    'default' => __( 'Default', 'cowidgets' ),
					'vertical' => __( 'Vertical', 'cowidgets' )
					
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'isotope'
                ]
			]
		);
		$this->add_control(
			'filters_layout',
			[
				'label' => __( 'Isotope Filters Alingment', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    'left' => __( 'Left', 'cowidgets' ),
					'right' => __( 'Right', 'cowidgets' ),
                    'center' => __( 'Center', 'cowidgets' )
					
				],
                'render_type' => 'template',
                'condition' => [
					'module' => 'isotope',
					'filters_style' => 'default'
                ]
			]
		);
		$this->add_control(
			'predefined_blocks',
			[
				'label' => __( 'Predefined Portfolio Blocks', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'block_1',
				'options' => [
                    'block_1' => __( 'Block 1', 'cowidgets' ),
					'block_2' => __( 'Block 2', 'cowidgets' ),
					'block_3' => __( 'Block 3', 'cowidgets' ),
					'block_4' => __( 'Block 4', 'cowidgets' )
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'predefined'
                ]
			]
		);

		$this->add_control(
			'predefined_parallax',
			[
				'label' => __( 'Vertical Parallax', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
                    0 => __( 'No', 'cowidgets' ),
                    1 => __( 'Yes', 'cowidgets' )
				],
                'render_type' => 'template',
                'condition' => [
                    'module' => 'predefined'
                ]
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
				'name' => 'item_title_typography',
				'label' => __( 'Item Title Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-portfolio-item .portfolio-title, body.ce-portfolio-follow-erzen .ce-fixed-follow .portfolio-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'filter_links_typography',
				'label' => __( 'Filter Links Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-filters button',
				'condition' => [
                    'module' => 'predefined'
                ]
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => __( 'Item Title Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-portfolio-item .portfolio-title, body.ce-portfolio-follow-erzen .ce-fixed-follow .portfolio-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_cats_typography',
				'label' => __( 'Item Categories Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-portfolio-item .portfolio-categories, body.ce-portfolio-follow-erzen .ce-fixed-follow .portfolio-categories',
			]
		);

		$this->add_control(
			'item_cats_color',
			[
				'label' => __( 'Item Categories Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-portfolio-item .portfolio-categories, body.ce-portfolio-follow-erzen .ce-fixed-follow .portfolio-categories' => 'color: {{VALUE}}',
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
			'beas_bg_color',
			[
				'label' => __( 'Beas Content BG Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-portfolio-item .entry-content' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'beas'
				]
			]
		);

		$this->add_control(
			'ishmi_number_color',
			[
				'label' => __( 'Ishmi Number Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-portfolio-item .title .number' => 'color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'ishmi'
				]
			]
		);

		$this->add_control(
			'effect_bg_color',
			[
				'label' => __( 'Effect BG Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-portfolio-item .entry-media .post-thumbnail:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => ['ishmi', 'erzen', 'amber']
				]
			]
		);

		$this->add_control(
			'remake_preview_text',
			[
				'label' => __( 'Remake "Preview" text', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
				'default' => esc_html( 'Preview', 'cowidgets' ),
				'condition' => [
					'item_style' => 'remake'
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


	function get_gallery_categories( $items ){
		$categories = [];
		if( $items ){
			foreach( $items as $item ){
				$caption = wp_get_attachment_caption( $item );
				$cat_filtered = strtolower( str_replace( ' ', '-', $caption )  );
				if( ! isset( $categories[$cat_filtered]) )
					$categories[$cat_filtered] = $caption;
			}
		}

		return $categories;
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

        $this->add_render_attribute( 'ce-portfolio-grid', 'class', [ 'ce-portfolio-grid', 'ce-portfolio-style-' . $settings['item_style'] ] );
		$this->add_render_attribute( 'ce-portfolio-grid', 'data-columns', $settings['columns'] );
		$this->add_render_attribute( 'ce-portfolio-grid', 'data-module', $settings['module'] );
		$this->add_render_attribute( 'ce-portfolio-grid', 'data-style', $settings['item_style'] );

		$this->add_render_attribute( 'ce-portfolio-grid', 'class', $settings['source_type'] . '-source_type' );

		if( $settings['item_style'] == 'erzen' )
			$this->add_render_attribute( 'ce-portfolio-grid', 'data-follow', '1' );

		$this->add_render_attribute( 'ce-portfolio-grid', 'data-parallax', $settings['predefined_parallax'] );
        
        if( $settings['module'] == 'isotope' ){
			$this->add_render_attribute( 'ce-portfolio-grid', 'data-layout', $settings['isotope_layout'] );
			
			$gallery_filters = [];
			if( $settings['source_type'] == 'gallery' && $settings['isotope_filters'] ){
				$gallery_filters = $this->get_gallery_categories( $this->get_gallery_image_ids( $settings['items_gallery'] ) );
			}
			$this->add_render_attribute( 'ce-portfolio-grid-wrapper', 'class', 'ce-portfolio-grid-wrapper' );
			$this->add_render_attribute( 'ce-portfolio-grid-wrapper', 'data-filters', $settings['isotope_filters'] );
			$this->add_render_attribute( 'ce-portfolio-grid-wrapper', 'data-filters-style', $settings['filters_style'] );
		}
		
		if( $settings['module'] == 'predefined' ){
			$this->add_render_attribute( 'ce-portfolio-grid', 'class', 'ce-portfolio-predefined--'.$settings['predefined_blocks'] );

			if( $settings['predefined_parallax'] && $settings['predefined_blocks'] == 'block_2'  ){
				$this->add_render_attribute( 'ce-portfolio-item', 'class', 'rellax' );
				$this->add_render_attribute( 'ce-portfolio-item', 'data-rellax-percentage', '0.5' );
				$this->add_render_attribute( 'ce-portfolio-item', 'data-rellax-min', '-100' );
				$this->add_render_attribute( 'ce-portfolio-item', 'data-rellax-max', '100' );
			}

		}

        $this->add_render_attribute( 'ce-portfolio-item', 'class', ['ce-portfolio-item'] );

        if( $settings['ce_animation'] != 'none' ){
            $this->add_render_attribute( 'ce-portfolio-item', 'class', ['ce-animation', 'ce-animation--'.$settings['ce_animation'] ] );
			$this->add_render_attribute( 'ce-portfolio-item', 'data-speed', $settings['ce_animation_speed'] );
			if( $settings['module'] == 'isotope' )
				$this->add_render_attribute( 'ce-portfolio-item', 'class', 'ce-animation-manual' );
        }

        $final_image_size = $settings['image_size_size'];

		if($final_image_size == 'custom'){
			require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';

			$image_dimension = $settings['image_size_custom_dimension'];

			$final_image_size = [
				// Defaults sizes.
				0           => null, // Width.
				1           => null, // Height.

				'bfi_thumb' => true,
				'crop'      => true,
			];

			$has_custom_size = false;
			if ( ! empty( $image_dimension['width'] ) ) {
				$has_custom_size = true;
				$final_image_size[0]   = $image_dimension['width'];
			}

			if ( ! empty( $image_dimension['height'] ) ) {
				$has_custom_size = true;
				$final_image_size[1]   = $image_dimension['height'];
			}

			if ( ! $has_custom_size ) {
				$final_image_size = 'full';
			}
		}

		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-grid-wrapper' ) ); ?>>
		
		<?php
		if ( $settings['isotope_filters'] ) :
			// Define the path to the filter.php file
			$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/filter.php';

			// Validate the file path to ensure it's within the expected directory
			if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/') ) === 0 ) {
				// Include the file if it exists and is within the expected directory
				include( $file_path );
			} else {
				// Handle the error, e.g., show a default message or log the error
				echo 'Invalid file path';
			}
		endif;
		?>

			
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-grid' ) ); ?>>
			
				<?php
					
					if( $settings['source_type'] == 'portfolio' ){ 
						$new_query = array(
							'posts_per_page' => (int) $settings['items_per_page'],
							'post_type' => 'portfolio' 
						);

						if( $settings['items_orderby'] != 'none' ){
							$new_query['orderby'] = $settings['items_orderby']; 
							$new_query['order'] = $settings['items_order'];
						}

						if( is_array( $settings['items_categories'] ) && !empty( $settings['items_categories'] ) ) {
						
							$new_query['tax_query'] = array(
								
								array(
									'taxonomy' => 'portfolio_entries',
									'field' => 'slug',
									'terms' => $settings['items_categories'],
									'operator' => 'IN' 
								) 
							);
						}

						if( !empty( $settings['items_portfolio'] ) ){
							$new_query['ignore_sticky_posts'] = 1;
							$new_query['post__in'] = $settings['items_portfolio'];
							$new_query['ignore_custom_sort'] = true;
						}

						if( !empty( $settings['items_portfolio_exclude'] ) ){
							$new_query['ignore_sticky_posts'] = 1;
							$new_query['post__not_in'] = $settings['items_portfolio_exclude'];
							$new_query['ignore_custom_sort'] = true;
						}
						
					}else if( $settings['source_type'] == 'all_post_types' ) {
						$new_query['post__in'] = $settings['items_posts'];
						
					}else if( $settings['source_type'] == 'gallery' ){

						$new_query = array(
							'post__in' => $this->get_gallery_image_ids( $settings['items_gallery'] ),
							'post_status' => 'any',
							'orderby' => 'post__in',
							'post_type' => 'attachment',
							'posts_per_page' => '-1'
						);

						
					}
					
					
					$the_query = new \WP_Query( $new_query );
				
					if ( is_object( $the_query ) && $the_query->have_posts() ) :
						$counter = 0;

						// used for separate items with columns in HTML
						$column1 = $column2 = $column3 = '';
					
						// Start loop
						while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<?php 
								
								$counter += 1;
								$delay = ( $counter * (int) $settings['ce_animation_delay'] );
								if( $counter > $settings['columns'] )
									$delay = 0;


								$this->add_render_attribute( 'ce-portfolio-item-'.get_the_ID(), 'data-delay', $delay );

								if( $settings['predefined_parallax'] && $settings['predefined_blocks'] == 'block_2' ){
									$this->add_render_attribute( 'ce-portfolio-item-'.get_the_ID(), 'data-rellax-speed', wp_rand(-2,-1) );
									$this->add_render_attribute( 'ce-portfolio-item-'.get_the_ID(), 'data-rellax-mobile-speed', 0);
								}
								

								if( $settings['source_type'] == 'gallery' && $settings['isotope_filters'] ) 
									$this->add_render_attribute( 'ce-portfolio-item-'.get_the_ID(), 'data-caption', strtolower( str_replace( ' ', '-', wp_get_attachment_caption(  ) )  ) );

								if( $settings['source_type'] != 'gallery' && $settings['isotope_filters'] ) 
									$this->add_render_attribute( 'ce-portfolio-item-'.get_the_ID(), 'data-category', strtolower( str_replace(' ', '-', esc_html( wp_strip_all_tags( get_the_term_list( get_the_ID(), 'portfolio_entries', '', ',', '' ) ) ) ) ) );
							?>
							<?php
								if ( $settings['module'] == 'predefined' && $settings['predefined_blocks'] == 'block_3' ) {
									ob_start();
									$sanitized_item_style = sanitize_file_name( $settings['item_style'] );
									$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/' . $sanitized_item_style . '.php';

									if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/') ) === 0 ) {
										include( $file_path );
									} else {
										// Handle the error, e.g., show a default message or log the error
										echo 'Invalid file path';
									}

									if( $counter % 2 ) {
										$column1 .= ob_get_clean();
									} else {
										$column2 .= ob_get_clean();
									}
								} else {
									$sanitized_item_style = sanitize_file_name( $settings['item_style'] );
									$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/' . $sanitized_item_style . '.php';

									if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/portfolio/') ) === 0 ) {
										include( $file_path );
									} else {
										// Handle the error, e.g., show a default message or log the error
										echo 'Invalid file path';
									}
								}
								?>

						<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>

					<?php if( $settings['module'] == 'predefined' & $settings['predefined_blocks'] == 'block_3' ){
						echo '<div class="column1 rellax" data-rellax-speed="-2">';
							echo wp_kses_post($column1);
						echo '</div>';

						echo '<div class="column2 rellax" data-rellax-speed="4">';
							echo wp_kses_post($column2);
						echo '</div>';
					} ?>

					<?php endif; ?>
					
			</div>

		
		</div>
		
		<?php
	}

	

	function get_gallery_image_ids( $gallery ){
		$ids = [];
		
		if( $gallery )
			foreach( $gallery as $item ){
				$ids[] = $item['id'];
			}

		return $ids;
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
