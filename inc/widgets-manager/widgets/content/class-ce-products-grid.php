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
class Products_Grid extends Widget_Base {

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
		return 'ce-products-grid';
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
		return __( 'Products Grid', 'cowidgets' );
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
		return 'ce-icon-products-grid';
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
		return [ 'ce-products-grid' ];
    }

	/**
	 * Register controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_products_grid_controls();
	}
	/**
	 * Register General Controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_products_grid_controls() {
		\COWIDGETS_Helpers::productsQuerySection( $this );
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
                    'module' => 'isotope'
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
                    'module' => 'isotope'
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


        $this->add_render_attribute( 'ce-products-grid', 'class', [ 'ce-products-grid', 'ce-products-style-' . $settings['item_style'] ] );

		?>
		
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-products-grid' ) ); ?>>
		
			<?php 
				$shortcode = '[products limit="' . $settings['number'] . '" '; 
				$shortcode .= 'columns="' . $settings['columns'] . '" ';
				if( $settings['query'] == 'featured' )
					$shortcode .= 'visibility="featured" ';
				else if( $settings['query'] == 'sale' )
					$shortcode .= 'on_sale="true" ';
				else if( $settings['query'] == 'best' )
					$shortcode .= 'best_selling="true" ';
				else if( $settings['query'] == 'top' )
					$shortcode .= 'top_rated="true" ';

				

				if( !empty( $settings['product_cat'] ) && is_array( $settings['product_cat'] ) ){
					$shortcode .= 'category="'.implode(',', $settings['product_cat']) . '" ';
				}
				if( !empty( $settings['product_tag'] ) && is_array( $settings['product_tag'] ) ){
					$shortcode .= 'tag="'.implode(',', $settings['product_tag']) . '" ';
				}

				if( !empty( $settings['product_ids'] ) && is_array( $settings['product_ids'] ) ){
					$shortcode .= 'ids="'.implode(',', $settings['product_ids']) . '" ';
				}

				$shortcode .= 'orderby="'.$settings['orderby'].'" order="'.$settings['order'].'" ';
				
					
				$shortcode .= ' ]';

				//var_dump( $shortcode );

				echo do_shortcode( $shortcode );
			?>

			
			
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
