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
 * Elementor Posts Carousel
 *
 * Elementor widget for Posts Carousel.
 *
 * @since 1.0.0
 */
class Podcasts_Carousel extends Widget_Base {

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
		return 'ce-podcasts-carousel';
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
		return __( 'Podcasts Carousel', 'cowidgets' );
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
		return 'ce-icon-posts-carousel';
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
		return [ 'ce-podcasts-carousel', 'tiny-slider' ];
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
		$this->register_podcasts_carousel_controls();
	}
	/**
	 * Register General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_podcasts_carousel_controls() {
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
				'default' => 'box',
				'options' => apply_filters( 'ce_load_element_styles', [
					'box' => __( 'Box', 'cowidgets' ),
					'box2' => __( 'Box 2', 'cowidgets' ),
					'box3' => __( 'Box 3', 'cowidgets' ),
					'box4' => __( 'Box 4', 'cowidgets' )
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
			'height',
			[
				'label'       => __( 'Height', 'cowidgets' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
				'range'       => [
					'px' => [
						'max' => 2500,
						'min' => 100,
					],
				],
				'default'     => [
					'size' => 700,
					'unit' => 'px',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .ce-podcasts-carousel article' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ce-podcasts-carousel article .post-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'item_style' => 'rowan'
				]
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
                    '{{WRAPPER}} .ce-podcasts-carousel .tns-item' => 'vertical-align: {{VALUE}}',
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
				'name' => 'item_title_typography',
				'label' => __( 'Item Title Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
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

        $this->add_render_attribute( 'ce-podcasts-carousel', 'class', [ 'ce-podcasts-carousel', 'ce-post-style-' . $settings['item_style'] ] );
		$this->add_render_attribute( 'ce-podcasts-carousel', 'data-columns', $settings['columns'] );
        $this->add_render_attribute( 'ce-podcasts-carousel', 'data-autoplay', $settings['autoplay'] );
        $this->add_render_attribute( 'ce-podcasts-carousel', 'data-slide-by', ( $settings['slide_by'] == 'page' ? $settings['columns'] : $settings['slide_by'] ) );
        $this->add_render_attribute( 'ce-podcasts-carousel', 'data-loop', $settings['loop'] );
        $this->add_render_attribute( 'ce-podcasts-carousel', 'data-gutter', $settings['gutter']['size'] );
        $this->add_render_attribute( 'ce-podcasts-carousel', 'data-center', $settings['center'] );
		$this->add_render_attribute( 'ce-podcasts-carousel', 'data-mouse-drag', $settings['mouse_drag'] );
		$this->add_render_attribute( 'ce-podcasts-carousel', 'data-edge-padding-side', $settings['edge_padding_side'] );
		$this->add_render_attribute( 'ce-podcasts-carousel', 'data-carousel-controls', $settings['carousel_controls'] );

        $this->add_render_attribute( 'ce-post-item', 'class', ['ce-post-item'] );

        if( $settings['ce_animation'] != 'none' ){
            $this->add_render_attribute( 'ce-post-item', 'class', ['ce-animation', 'ce-animation--'.$settings['ce_animation'], 'ce-animation-manual' ] );
            $this->add_render_attribute( 'ce-post-item', 'data-speed', $settings['ce_animation_speed'] );
            
        }

        if( isset( $settings['edge_padding'] ) && !empty( $settings['edge_padding'] ) )
            $this->add_render_attribute( 'ce-podcasts-carousel', 'data-edge-padding', $settings['edge_padding']['size'] );

        if( isset( $settings['start_index'] ) && !empty( $settings['start_index'] ) )
            $this->add_render_attribute( 'ce-podcasts-carousel', 'data-start-index', $settings['start_index'] );
        
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
		<?php if( $settings['carousel_controls'] ){ ?>
			<?php if( $settings['item_style'] == 'box3' || $settings['item_style'] == 'box4' ){ ?>
				<div class="container">
			<?php } ?>
				<div class="ce-carousel-head">
	                <div class="ce-podcasts-carousel-controls">
	                    <a href="#" class="ce-prev"><i class="feather feather-arrow-left"></i></a>
	                    <a href="#" class="ce-next"><i class="feather feather-arrow-right"></i></a>
	                </div>
	                <div class="clearfix"></div>
				</div>
			<?php if( $settings['item_style'] == 'box3' || $settings['item_style'] == 'box4' ){ ?>
				</div>
			<?php } ?>
		<?php } ?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-podcasts-carousel' ) ); ?>>

            <?php
                
                    $new_query = array(
                    	'post_type' => 'podcast',
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
                    	$episode = get_post_meta( get_the_ID(), 'ce_episode', true );
                    	?>
						<?php 
							$counter += 1;
							$delay = ( $counter * (int) $settings['ce_animation_delay'] );
							if( $counter > $settings['columns'] )
								$delay = 0;


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
