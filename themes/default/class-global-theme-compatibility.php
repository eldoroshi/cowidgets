<?php
/**
 * Support all themes.
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\Themes;

/**
 * Global theme compatibility.
 */
class Global_Theme_Compatibility {

	/**
	 *  Initiator
	 */
	public function __construct() {
		add_action( 'wp', [ $this, 'hooks' ] );
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( cowidgets_header_enabled() ) {
			// Replace header.php.
			add_action( 'get_header', [ $this, 'option_override_header' ] );

			add_action( 'wp_body_open', [ 'Header_Footer_Elementor', 'get_header_content' ] );
			add_action( 'ce_fallback_header', [ 'Header_Footer_Elementor', 'get_header_content' ] );
		}

		if ( cowidgets_is_before_footer_enabled() ) {
			add_action( 'wp_footer', [ 'Header_Footer_Elementor', 'get_before_footer_content' ], 20 );
		}

		if ( cowidgets_footer_enabled() ) {
			add_action( 'wp_footer', [ 'Header_Footer_Elementor', 'get_footer_content' ], 50 );
		}

		if ( cowidgets_header_enabled() || cowidgets_footer_enabled() ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'force_fullwidth' ] );
		}
	}

	/**
	 * Force full width CSS for the header.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function force_fullwidth() {
		$css = '
		.force-stretched-header {
			width: 100vw;
			position: relative;
			margin-left: -50vw;
			left: 50%;
		}';

		if ( true === cowidgets_header_enabled() ) {
			$css .= 'header#masthead {
				display: none;
			}';
		}

		if ( true === cowidgets_footer_enabled() ) {
			$css .= 'footer#colophon {
				display: none;
			}';
		}

		wp_add_inline_style( 'ce-style', $css );
	}

	/**
	 * Function overriding the header in the wp_body_open way.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function option_override_header() {
		$templates   = [];
		$templates[] = 'header.php';
		locate_template( $templates, true );

		if ( ! did_action( 'wp_body_open' ) ) {
			echo '<div class="force-stretched-header">';
			do_action( 'ce_fallback_header' );
			echo '</div>';
		}
	}
}
new Global_Theme_Compatibility();
