<?php
/**
 * Plugin Name: Cowidgets - Elementor Addons
 * Plugin URI:  https://cowidgets.com
 * Description: Elementor Widgets for Sliders, Portfolio, Posts, Header & Footer Builder for your WordPress website using Elementor Page Builder for free.
 * Author:      Codeless
 * Author URI:  https://codeless.co
 * Text Domain: cowidgets
 * Domain Path: /languages
 * Version: 1.2.0
 *
 * @package         cowidgets
 */

define( 'COWIDGETS_VER', '1.2.0' );
define( 'COWIDGETS_DIR', plugin_dir_path( __FILE__ ) );
define( 'COWIDGETS_URL', plugins_url( '/', __FILE__ ) );
define( 'COWIDGETS_PATH', plugin_basename( __FILE__ ) );

/**
 * Load the class loader.
 */
require_once COWIDGETS_DIR . '/inc/class-cowidgets.php';

/**
 * Load the Plugin Class.
 */
function cowidgets_init() {
	CoWidgets::instance();
}

add_action( 'plugins_loaded', 'COWIDGETS_init' );

// Register the widget
add_action( 'wp_dashboard_setup', 'cl_builder_dashboard_widgets' );

if( !function_exists('cl_builder_dashboard_widgets') ){
	function cl_builder_dashboard_widgets() {
		wp_add_dashboard_widget(
			'codeless_co_news_widget',         // Widget slug.
			'Codeless Blog & Resources',         // Title.
			'codeless_news_widget_function' // Display function.
		);

		global $wp_meta_boxes;
		$widget = $wp_meta_boxes['dashboard']['normal']['core']['codeless_co_news_widget'];
		unset($wp_meta_boxes['dashboard']['normal']['core']['codeless_co_news_widget']);
		array_unshift($wp_meta_boxes['dashboard']['normal']['core'], $widget);
	}
}
if( !function_exists( 'codeless_news_widget_function' ) ){
	// Create the widget output
	function codeless_news_widget_function() {
		$rss = fetch_feed( 'https://codeless.co/feed/' ); // Replace with your blog URL.
		echo '<p>Want to learn more about our Codeless WordPress products and tutorials? Check our <a href="https://codeless.co/">blog</a>.</p>';
		if ( ! is_wp_error( $rss ) ) {
			$maxitems = $rss->get_item_quantity( 10 ); // Change the number of posts to display.
			$rss_items = $rss->get_items( 0, $maxitems );
			
			echo '<ul>';
			if ( $maxitems == 0 ) {
				echo '<li>No items.</li>';
			} else {
				foreach ( $rss_items as $item ) {
					echo '<li><a href="' . esc_url( $item->get_permalink() ) . '">' . esc_html( $item->get_title() ) . '</a></li>';
				}
			}
			echo '</ul>';
		}
	}
	
}