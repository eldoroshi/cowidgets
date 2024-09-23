<?php
/**
 * COWIDGETS_Default_Compat setup
 *
 * @package header-footer-elementor
 */

namespace COWIDGETS\Themes;

/**
 * Codeless theme compatibility.
 */
class COWIDGETS_Default_Compat {

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
			// Replace header.php template.
			add_action( 'get_header', [ $this, 'override_header' ] );

			// Display CE's header in the replaced header.
			add_action( 'ce_header', 'cowidgets_render_header' );
		}

		if ( cowidgets_footer_enabled() || cowidgets_is_before_footer_enabled() ) {
			// Replace footer.php template.
			add_action( 'get_footer', [ $this, 'override_footer' ] );
		}

		if ( cowidgets_footer_enabled() ) {
			// Display CE's footer in the replaced header.
			add_action( 'ce_footer', 'cowidgets_render_footer' );
		}

		if ( cowidgets_is_before_footer_enabled() ) {
			add_action( 'ce_footer_before', [ 'Header_Footer_Elementor', 'get_before_footer_content' ] );
		}
	}

	/**
	 * Function for overriding the header in the elmentor way.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function override_header() {
		require COWIDGETS_DIR . 'themes/default/ce-header.php';
		$templates   = [];
		$templates[] = 'header.php';
		// Avoid running wp_head hooks again.
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	/**
	 * Function for overriding the footer in the elmentor way.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function override_footer() {
		require COWIDGETS_DIR . 'themes/default/ce-footer.php';
		$templates   = [];
		$templates[] = 'footer.php';
		// Avoid running wp_footer hooks again.
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

}

new COWIDGETS_Default_Compat();
