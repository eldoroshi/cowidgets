<?php
/**
 * Elementor Classes.
 *
 * @package CoWidgets
 */

namespace COWIDGETS\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

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
class Podcasts_Grid extends Widget_Base {

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
		return 'ce-podcasts-grid';
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
		return __( 'Podcasts Grid', 'cowidgets' );
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
		return 'ce-icon-posts-grid';
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
		return [ 'ce-podcasts-grid' ];
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
		\COWIDGETS_Helpers::podcastsSelectionSection( $this );
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
					'box2'	=> __( 'Default', 'cowidgets' ),
					'box3'	=> __( 'Box', 'cowidgets' ),
					'list'	=> __( 'List', 'cowidgets' ),
					'box4'	=> __( 'Lateral Image', 'cowidgets' ),
					'modern'	=> __( 'Modern', 'cowidgets' )
				] ),
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
			'columns',
			[
				'label' => __( 'Columns', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
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

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'masonry',
				'options' => [
                    'masonry'				=> __( 'Masonry', 'cowidgets' ),
                    'fitRows'				=> __( 'fitRows', 'cowidgets' )
				],
				'render_type' => 'template'
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
				'default'     => [],
				'selectors'   => [
					'{{WRAPPER}} .ce-podcasts-grid .ce-post-item' => 'padding: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-podcasts-grid' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}'
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'entry_content',
			[
				'label' => __( 'Content?', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'excerpt',
				'options' => [
                    'excerpt'				=> __( 'Excerpt', 'cowidgets' ),
					'content'				=> __( 'Content', 'cowidgets' ),
					'none'					=> __( 'None', 'cowidgets' ),
				],
				'render_type' => 'template'
			]
		);

		$this->add_responsive_control(
			'content_limit',
			[
				'label'       => __( 'Content Limit', 'cowidgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [],
				'range'       => [
						'max' => 500,
						'min' => 10,
				],
				'default'     => [],
				'render_type' => 'template',
				'condition' => [
					'entry_content' => 'excerpt'
				]
			]
		);

		$this->add_control(
			'entry_readmore',
			[
				'label' => __( '"Continue Reading"?', 'cowidgets' ),
				'description' => __( 'Works only when style has a "Continue Reading" button by default', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
                    0				=> __( 'No', 'cowidgets' ),
					1				=> __( 'Yes', 'cowidgets' )
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'user_icon',
			[
				'label'       => __( 'User Icon', 'cowidgets' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default'     => [
					'value'   => 'feather feather-user',
					'library' => 'feather',
				],
			]
		);

		$this->add_control(
			'date_icon',
			[
				'label'       => __( 'Date Icon', 'cowidgets' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default'     => [
					'value'   => 'feather feather-clock',
					'library' => 'feather',
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
				'name' => 'item_title_typography',
				'label' => __( 'Item Title Typography', 'plugin-domain' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .ce-post-item .entry-title',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => __( 'Item Title Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .entry-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_meta_typography',
				'label' => __( 'Item Meta Typography', 'cowidgets' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .ce-post-item .entry-meta-single',
			]
		);

		$this->add_control(
			'item_meta_color',
			[
				'label' => __( 'Item Meta Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .entry-meta-single' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_content_typography',
				'label' => __( 'Item Content Typography', 'cowidgets' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .ce-post-item .entry-content',
			]
		);

		$this->add_control(
			'item_content_color',
			[
				'label' => __( 'Item Content Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .entry-content' => 'color: {{VALUE}}',
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


		$this->end_controls_section();
        
		\COWIDGETS_Helpers::animationSection( $this );
		
		$this->start_controls_section(
			'section_pagination',
			[
				'label'     => __( 'Pagination', 'cowidgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'	=> __( 'None', 'cowidgets' ),
					'numbers'	=> __( 'Numbers', 'cowidgets' ),
					'next_prev'	=> __( 'Next/Prev', 'cowidgets' ),
					'load_more'	=> __( 'Load More', 'cowidgets' ),
					'infinity_scroll' => __( 'Infinity Scroll', 'cowidgets' )
				],
			]
        );
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

        $this->add_render_attribute( 'ce-podcasts-grid', 'class', [ 'ce-podcasts-grid', 'ce-post-style-' . $settings['item_style'] ] );
		$this->add_render_attribute( 'ce-podcasts-grid', 'data-columns', $settings['columns'] );
		$this->add_render_attribute( 'ce-podcasts-grid', 'data-layout', $settings['layout'] );
       
   

        if( $settings['ce_animation'] != 'none' ){
            $this->add_render_attribute( 'ce-post-item', 'data-speed', $settings['ce_animation_speed'] );
            
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
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-podcasts-grid' ) ); ?>>
          
			<?php	
					if( $settings['entry_content'] == 'excerpt' && $settings['content_limit']['size'] != '' )
						add_filter( 'excerpt_length', function(){
							$settings = $this->get_settings_for_display();
							return $settings['content_limit']['size'];
						}, 999 );

                    
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                    $new_query = array(
       					 'post_type'        => 'podcast',
        				 'posts_per_page'   => (int) $settings['items_per_page'],
        				 'paged'            => $paged,
        
    				);


					if( $settings['items_orderby'] != 'none' ){
						$new_query['orderby'] = $settings['items_orderby'];
						$new_query['order'] = $settings['items_order'];
					}

                    if( is_array( $settings['items_categories'] ) && !empty( $settings['items_categories'] ) ) {
                    
                        $new_query['tax_query'] = array(
                            
                            array(
                                'taxonomy' => 'podcast_shows',
                                'field' => 'slug',
                                'terms' => $settings['items_categories'],
                                'operator' => 'IN' 
                            ) 
                        );
                    }

                    if( !empty( $settings['posts'] ) ){
                        $new_query['ignore_sticky_posts'] = 1;
                        $new_query['post__in'] = $settings['posts'];
                        $new_query['ignore_custom_sort'] = true;
					}
					
                

                $the_query = new \WP_Query( $new_query );
                
                if ( is_object( $the_query ) && $the_query->have_posts() ) :
					$counter = 0;
                    // Start loop
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                    	$episode = get_post_meta( get_the_ID(), 'ce_episode', true );
                    ?>
						<?php 
							$counter += 1;
							$delay = ( $counter * (int) $settings['ce_animation_delay'] );
							if( $counter > $settings['columns'] )
								$delay = 0;

							$this->add_render_attribute( 'ce-post-item-'.get_the_ID(), 'class', array_merge( ['ce-post-item', 'ce-animation', 'ce-animation--'.$settings['ce_animation'], 'ce-animation-manual'], get_post_class( '', get_the_ID() )  ) );
							$this->add_render_attribute( 'ce-post-item-'.get_the_ID(), 'data-delay', $delay );
						?>
					
					<?php
						// Sanitize the item_style parameter
						$sanitized_item_style = sanitize_file_name( $settings['item_style'] );

						// Construct the file path
						$file_path = COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/podcast/' . $sanitized_item_style . '.php';

						// Validate the file path to ensure it's within the expected directory
						if ( realpath($file_path) && strpos( realpath($file_path), realpath(COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/partials/podcast/') ) === 0 ) {
							// Include the file if it exists and is within the expected directory
							include( $file_path );
						} else {
							// Handle the error, e.g., show a default message or log the error
							echo 'Invalid file path';
						}
						?>

                    <?php endwhile; ?>

                    </div>

			       
                    <?php

				      /* echo '<div class="cl-blog-pagination">';*/
    
    					$pagination_style = $settings['pagination'];

					   codeless_podcast_pagination($the_query, $pagination_style);

			        ?>

                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
			
		

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
}
