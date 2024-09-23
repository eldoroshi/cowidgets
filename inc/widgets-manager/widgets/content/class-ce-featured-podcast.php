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
class Featured_Podcast extends Widget_Base {

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
		return 'ce-featured-podcasts-grid';
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
		return __( 'Featured Podcast', 'cowidgets' );
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
		return [ 'ce-featured-podcasts-grid' ];
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
				'default' => 'featured',
				'options' => apply_filters( 'ce_load_element_styles', [
					'featured'	=> __( 'Featured', 'cowidgets' )
				] ),
			]
        );

        $this->add_control(
			'layout_style',
			[
				'label' => __( 'Layout Style', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => apply_filters( 'ce_load_element_styles', [
					'dark'	=> __( 'Dark', 'cowidgets' ),
					'light'	=> __( 'Light', 'cowidgets' ),
				] ),
			]
        );

        $this->add_control(
			'show_btns',
			[
				'label' => __( 'Show Subscribe Buttons', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'cowidgets' ),
				'label_off' => __( 'Hide', 'cowidgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'browse_text',
			[
				'label' => __( 'Browse Button Text', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Browse All', 'cowidgets'),
				
			]
        );

        $this->add_control(
			'browse_link',
			[
				'label' => __( 'Browse Button Link', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('#', 'cowidgets'),
				
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
					'{{WRAPPER}} .ce-featured-podcasts-grid .ce-post-item' => 'padding: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-featured-podcasts-grid' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}'
				],
				'render_type' => 'template'
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
				'selector' => '{{WRAPPER}} .entry-featured-podcast h5',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => __( 'Item Title Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .entry-featured-podcast h5' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_meta_typography',
				'label' => __( 'Item Meta Typography', 'cowidgets' ),
				'scheme' => Typography::TYPOGRAPHY_1,
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
				'scheme' => Typography::TYPOGRAPHY_1,
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

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_readmore_typography',
				'label' => __( '"Continue Reading" Typography', 'cowidgets' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ce-post-item .entry-readmore',
			]
		);

		$this->add_control(
			'item_readmore_color',
			[
				'label' => __( '"Continue Reading" Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item a.entry-readmore' => 'color: {{VALUE}}',
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

		$this->add_control(
			'adair_social_color',
			[
				'label' => __( 'Adair Socials Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .ce-share-buttons' => 'color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'adair'
				]
			]
		);

		$this->add_control(
			'adair_footer_borders',
			[
				'label' => __( 'Adair Footer Border Color', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .entry-footer' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'adair'
				]
			]
		);

		$this->add_control(
			'birk_wrapper_bg',
			[
				'label' => __( 'Birk Wrapper BG', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .ce-post-item .entry-wrapper-content' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'item_style' => 'birk'
				]
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

        $this->add_render_attribute( 'ce-featured-podcasts-grid', 'class', [ 'ce-featured-podcasts-grid', 'ce-post-style-' . $settings['item_style'] ] );
        $this->add_render_attribute( 'ce-featured-podcasts-grid', 'class', [ 'ce-featured-podcasts-grid', 'ce-post-style-' . $settings['layout_style'] ] );
		$this->add_render_attribute( 'ce-featured-podcasts-grid', 'data-columns', $settings['columns'] );
		$this->add_render_attribute( 'ce-featured-podcasts-grid', 'data-layout', $settings['layout'] );
       
   

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

		$browse_text = '';
		$browse_link = '';
		if( !empty( $settings['browse_text'] ) && !empty( $settings['browse_link'] ) ){
			$browse_text = $settings['browse_text'];
			$browse_link = $settings['browse_link'];
		}

		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-featured-podcasts-grid' ) ); ?>>

			<?php	


                    $new_query = array(
                    	'post_type'  		=> 'podcast',
                        'posts_per_page' => (int) $settings['items_per_page'],
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
                    	$season  = get_post_meta( get_the_ID(), 'ce_season', true );
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
