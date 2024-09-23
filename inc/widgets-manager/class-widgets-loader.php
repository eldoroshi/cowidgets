<?php
/**
 * Widgets loader for Header Footer Elementor.
 *
 * @package     CE
 * @author      CE
 * @copyright   Copyright (c) 2018, CE
 * @link        http://cowidgets.com/
 * @since       CE 1.2.0
 */

namespace COWIDGETS\WidgetsManager;

use Elementor\Plugin;

defined( 'ABSPATH' ) or exit;

/**
 * Set up Widgets Loader class
 */
class Widgets_Loader {

	/**
	 * Instance of Widgets_Loader.
	 *
	 * @since  1.2.0
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Get instance of Widgets_Loader
	 *
	 * @since  1.2.0
	 * @return Widgets_Loader
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Setup actions and filters.
	 *
	 * @since  1.2.0
	 */
	private function __construct() {
		// Register category.
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );

		// Register widgets.
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Add svg support.
		add_filter( 'upload_mimes', [ $this, 'cowidgets_svg_mime_types' ] );
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 1.0.0
	 */
	public static function get_widget_script() {
		$js_files = [
			'ce-nav-menu' => [
				'path'      => 'inc/js/ce-nav-menu.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],
			'ce-kiri-slider' => [
				'path'      => 'inc/js/ce-kiri-slider.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],
			'ce-vjosa-slider' => [
				'path'      => 'inc/js/ce-vjosa-slider.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],
			'ce-hudson-slider' => [
				'path'      => 'inc/js/ce-hudson-slider.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],
			'ce-banas-slider' => [
				'path'      => 'inc/js/ce-banas-slider.js',
				'dep'       => [ 'jquery', 'swiper' ],
				'in_footer' => true,
			],
			'ce-tapi-slider' => [
				'path'      => 'inc/js/ce-tapi-slider.js',
				'dep'       => [ 'jquery', 'swiper' ],
				'in_footer' => true,
			],
			'ce-beas-slider' => [
				'path'      => 'inc/js/ce-beas-slider.js',
				'dep'       => [ 'jquery', 'swiper' ],
				'in_footer' => true,
			],
			'ce-pao-slider' => [
				'path'      => 'inc/js/ce-pao-slider.js',
				'dep'       => [ 'jquery', 'swiper' ],
				'in_footer' => true,
			],
			'ce-lana-slider' => [
				'path'      => 'inc/js/ce-lana-slider.js',
				'dep'       => [ 'jquery', 'swiper' ],
				'in_footer' => true,
			],
			'ce-portfolio-carousel' => [
				'path'      => 'inc/js/ce-portfolio-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-posts-carousel' => [
				'path'      => 'inc/js/ce-posts-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-podcasts-carousel' => [
				'path'      => 'inc/js/ce-podcasts-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-podcasts-shows-carousel' => [
				'path'      => 'inc/js/ce-shows-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-testimonial-carousel' => [
				'path'      => 'inc/js/ce-testimonial-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-staff-carousel' => [
				'path'      => 'inc/js/ce-staff-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-posts-grid' => [
				'path'      => 'inc/js/ce-posts-grid.js',
				'dep'       => [ 'isotope', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-podcasts-grid' => [
				'path'      => 'inc/js/ce-podcasts-grid.js',
				'dep'       => [ 'isotope', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-portfolio-grid' => [
				'path'      => 'inc/js/ce-portfolio-grid.js',
				'dep'       => [ 'ce-global' ],
				'in_footer' => true,
			],
			'ce-products-grid' => [
				'path'      => 'inc/js/ce-products-grid.js',
				'dep'       => [ 'ce-global' ],
				'in_footer' => true,
			],
			'ce-products-carousel' => [
				'path'      => 'inc/js/ce-products-carousel.js',
				'dep'       => [ 'tiny-slider', 'ce-global' ],
				'in_footer' => true,
			],
			'ce-video-play-button' => [
				'path'      => 'inc/js/ce-video-play-button.js',
				'dep'       => [ 'ce-global' ],
				'in_footer' => true,
			],
			'tiny-slider' => [
				'path'      => 'assets/js/lib/tiny-slider.js',
				'dep'       => [],
				'in_footer' => true,
			],
			'isotope' => [
				'path'      => 'assets/js/lib/isotope.pkgd.min.js',
				'dep'       => [],
				'in_footer' => true,
			],
			'ce-price-list' => [
				'path'      => 'inc/js/ce-price-list.js',
				'dep'       => ['jquery'],
				'in_footer' => true,
			],

			/*'ce-cycle-heading' => [
				'path'      => 'inc/js/ce-cycle-heading.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],*/
		];

		return $js_files;
	}

	public static function get_widget_styles() {
		$css_files = [
			'tiny-slider' => [
				'path'      => 'assets/css/lib/tiny-slider.css',
			],
		];

		return $css_files;
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 1.0.0
	 */
	public static function get_widget_list() {
		$header_widget_list = [
			'retina',
			'copyright',
			'copyright-shortcode',
			'navigation-menu',
			'menu-walker',
			'site-title',
			'page-title',
			'site-tagline',
			'site-logo',
			'cart',
		];

		$content_widget_list = [
			'kiri-slider',
			'vjosa-slider',
			'hudson-slider',
			'tapi-slider',
			'pao-slider',
			'banas-slider',
			'lana-slider',
			'beas-slider',
			'ce-portfolio-carousel',
			'ce-posts-carousel',
			
			'ce-portfolio-grid',
			'ce-products-grid',
			
			'ce-products-carousel',
			'ce-testimonial-carousel',
			'ce-staff-carousel',
			'ce-posts-grid',
			'ce-post-navigation',
			'ce-price-list',
			'ce-video-play-button',
			'mailchimp-form',
			
			
		];

		if( apply_filters( 'ce_register_podcast_post_type', false ) ){
			$content_widget_list[] = 'ce-podcasts-carousel';
			$content_widget_list[] = 'ce-podcasts-grid';
			$content_widget_list[] = 'ce-shows';
			$content_widget_list[] = 'ce-featured-podcast';
		}

		$widget_list = [
			'header' => $header_widget_list,
			'content' => $content_widget_list,
		];

		return $widget_list;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function include_widgets_files() {
		$js_files    = $this->get_widget_script();
		$css_files    = $this->get_widget_styles();
		$widget_list = $this->get_widget_list();

		$header_widget_list = $widget_list['header'];
		$content_widget_list = $widget_list['content'];

		if ( ! empty( $header_widget_list ) ) {
			foreach ( $header_widget_list as $handle => $data ) {
				require_once COWIDGETS_DIR . '/inc/widgets-manager/widgets/header/class-' . $data . '.php';
			}
		}

		if ( ! empty( $content_widget_list ) ) {
			foreach ( $content_widget_list as $handle => $data ) {
				require_once COWIDGETS_DIR . '/inc/widgets-manager/widgets/content/class-' . $data . '.php';
			}
		}

		if ( ! empty( $js_files ) ) {
			foreach ( $js_files as $handle => $data ) {
				wp_register_script( $handle, COWIDGETS_URL . $data['path'], $data['dep'], COWIDGETS_VER, $data['in_footer'] );
			}
		}

		if ( ! empty( $css_files ) ) {
			foreach ( $css_files as $handle => $data ) {
				wp_register_style( $handle, COWIDGETS_URL . $data['path'] );
			}
		}

		// Emqueue the widgets style.
		wp_enqueue_style( 'ce-widgets-style', COWIDGETS_URL . 'inc/widgets-css/frontend.css', [], COWIDGETS_VER );
	}

	/**
	 * Provide the SVG support for Retina Logo widget.
	 *
	 * @param array $mimes which return mime type.
	 *
	 * @since  1.2.0
	 * @return $mimes.
	 */
	public function cowidgets_svg_mime_types( $mimes ) {
		// New allowed mime types.
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Register Category
	 *
	 * @since 1.0.0
	 * @param object $this_cat class.
	 */
	public function register_widget_category( $this_cat ) {
		$category = __( 'Codeless Header', 'cowidgets' );

		$this_cat->add_category(
			'ce-header-widgets',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);

		$category = __( 'Codeless Content', 'cowidgets' );

		$this_cat->add_category(
			'ce-content-widgets',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);

		return $this_cat;
	}

	public function register_content_widget_category( $this_cat ) {
		$category = __( 'Codeless Content', 'cowidgets' );

		$this_cat->add_category(
			'ce-content-widgets',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);

		return $this_cat;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files.
		$this->include_widgets_files();
		// Register Header Widgets.
		Plugin::instance()->widgets_manager->register( new Widgets\Retina() );
		Plugin::instance()->widgets_manager->register( new Widgets\Copyright() );
		Plugin::instance()->widgets_manager->register( new Widgets\Navigation_Menu() );
		Plugin::instance()->widgets_manager->register( new Widgets\Page_Title() );
		Plugin::instance()->widgets_manager->register( new Widgets\Site_Title() );
		Plugin::instance()->widgets_manager->register( new Widgets\Site_Tagline() );
		Plugin::instance()->widgets_manager->register( new Widgets\Site_Logo() );

		if ( class_exists( 'woocommerce' ) ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Cart() );
		}

		// Register Content Widgets
		//Sliders
		Plugin::instance()->widgets_manager->register( new Widgets\Kiri_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Vjosa_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Hudson_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Tapi_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Lana_Slider() ); 
		Plugin::instance()->widgets_manager->register( new Widgets\Banas_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Pao_Slider() );
		Plugin::instance()->widgets_manager->register( new Widgets\Beas_Slider() );

		//Portfolio
		Plugin::instance()->widgets_manager->register( new Widgets\Portfolio_Carousel() );
		Plugin::instance()->widgets_manager->register( new Widgets\Portfolio_Grid() );

		Plugin::instance()->widgets_manager->register( new Widgets\Testimonial_Carousel() );
		Plugin::instance()->widgets_manager->register( new Widgets\Staff_Carousel() );

		Plugin::instance()->widgets_manager->register( new Widgets\Posts_Grid() );
		Plugin::instance()->widgets_manager->register( new Widgets\Posts_Carousel() );
		

		Plugin::instance()->widgets_manager->register( new Widgets\Post_Navigation() ); 
		Plugin::instance()->widgets_manager->register( new Widgets\COWIDGETS_Price_List() );
		Plugin::instance()->widgets_manager->register( new Widgets\Video_Play_Button() );

		Plugin::instance()->widgets_manager->register( new Widgets\Products_Grid() );
		Plugin::instance()->widgets_manager->register( new Widgets\Products_Carousel() );
		//Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cycle_Heading() );
		Plugin::instance()->widgets_manager->register( new Widgets\Codeless_Mailchimp_Widget() );
		
		

		if( apply_filters( 'ce_register_podcast_post_type', false ) ){
			
			Plugin::instance()->widgets_manager->register( new Widgets\Podcasts_Carousel() );
			Plugin::instance()->widgets_manager->register( new Widgets\Podcasts_Grid() );
			//Carousel shows
			Plugin::instance()->widgets_manager->register( new Widgets\Podcasts_Shows_Carousel() );
			//Featured Podcast
			Plugin::instance()->widgets_manager->register( new Widgets\Featured_Podcast() );
		}
	}
}

/**
 * Initiate the class.
 */
Widgets_Loader::instance();
