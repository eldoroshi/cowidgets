<?php
/**
 * Calling copyright shortcode.
 *
 * @package Copyright
 * @author Brainstorm Force
 */

namespace COWIDGETS\WidgetsManager\Widgets;

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Helper class for the Copyright.
 *
 * @since 1.0.0
 */
class Copyright_Shortcode {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_shortcode( 'ce_current_year', [ $this, 'display_current_year' ] );
		add_shortcode( 'ce_site_title', [ $this, 'display_site_title' ] );
	}

	/**
	 * Get the ce_current_year Details.
	 *
	 * @return array $ce_current_year Get Current Year Details.
	 */
	public function display_current_year() {

		$ce_current_year = gmdate( 'Y' );
		$ce_current_year = do_shortcode( shortcode_unautop( $ce_current_year ) );
		if ( ! empty( $ce_current_year ) ) {
			return $ce_current_year;
		}
	}

	/**
	 * Get site title of Site.
	 *
	 * @return string.
	 */
	public function display_site_title() {

		$ce_site_title = get_bloginfo( 'name' );

		if ( ! empty( $ce_site_title ) ) {
			return $ce_site_title;
		}
	}

}

new Copyright_Shortcode();
