<?php
/**
 * COWIDGETS_Codeless_Compat setup
 *
 * @package cowidgets
 */

/**
 * Specular theme compatibility.
 */
class COWIDGETS_Specular_Compat {

	/**
	 * Instance of COWIDGETS_Specular_Compat.
	 *
	 * @var COWIDGETS_Specular_Compat
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new COWIDGETS_Specular_Compat();

			add_action( 'wp', [ self::$instance, 'hooks' ] );
		}

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( cowidgets_header_enabled() ) {
			add_action( 'template_redirect', [ $this, 'specular_setup_header' ], 1 );
			add_action( 'codeless_hook_wrapper_before', 'cowidgets_render_header' );
		}

		if ( cowidgets_footer_enabled() ) {
			add_action( 'template_redirect', [ $this, 'specular_setup_footer' ], 10 );
			add_action( 'codeless_hook_main_after', 'cowidgets_render_footer', 99 );
		}

		if ( cowidgets_is_before_footer_enabled() ) {
			add_action( 'codeless_hook_main_after', 'cowidgets_render_before_footer', 9 );
		}
	}

	/**
	 * Disable header from the theme.
	 */
	public function specular_setup_header() {
		remove_action( 'codeless_hook_wrapper_before', 'codeless_show_header', 0 );
	}

	/**
	 * Disable footer from the theme.
	 */
	public function specular_setup_footer() {
		remove_action( 'codeless_hook_main_after', 'codeless_show_footer', 0 );
	}

}

COWIDGETS_Specular_Compat::instance();