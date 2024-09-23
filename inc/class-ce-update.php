<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'COWIDGETS_Update' ) ) {

	/**
	 * COWIDGETS_Update initial setup
	 *
	 * @since 1.0.0
	 */
	class COWIDGETS_Update {

		/**
		 * Option key for stored version number.
		 *
		 * @since 1.0.0
		 * @var string
		 */
		private $db_option_key = '_ce_db_version';

		/**
		 *  Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Theme Updates.
			if ( is_admin() ) {
				add_action( 'admin_init', [ $this, 'init' ], 5 );
			} else {
				add_action( 'wp', [ $this, 'init' ], 5 );
			}
		}

		/**
		 * Implement theme update logic.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			do_action( 'ce_update_before' );

			if ( ! $this->needs_db_update() ) {
				return;
			}

			$db_version = get_option( $this->db_option_key, false );

			if ( version_compare( $db_version, '1.2.0-beta.2', '<' ) ) {
				$this->setup_default_terget_rules();
			}

			// flush rewrite rules on plugin update.
			flush_rewrite_rules();

			$this->update_db_version();

			do_action( 'ce_update_after' );
		}

		/**
		 * Set default target rules for header, footer, before footers being used before target rules were added to the plugin.
		 *
		 * @since 1.0.0-beta.1
		 * @return void
		 */
		private function setup_default_terget_rules() {
			$default_include_locations = [
				'rule'     => [ 0 => 'basic-global' ],
				'specific' => [],
			];

			$header_id        = $this->get_legacy_template_id( 'type_header' );
			$footer_id        = $this->get_legacy_template_id( 'type_footer' );
			$before_footer_id = $this->get_legacy_template_id( 'type_before_footer' );

			// Header.
			if ( ! empty( $header_id ) ) {
				update_post_meta( $header_id, 'ce_target_include_locations', $default_include_locations );
			}

			// Footer.
			if ( ! empty( $footer_id ) ) {
				update_post_meta( $footer_id, 'ce_target_include_locations', $default_include_locations );
			}

			// Before Footer.
			if ( ! empty( $before_footer_id ) ) {
				update_post_meta( $before_footer_id, 'ce_target_include_locations', $default_include_locations );
			}
		}

		/**
		 * Get header or footer template id based on the meta query.
		 *
		 * @param  String $type Type of the template header/footer.
		 *
		 * @return Mixed  Returns the header or footer template id if found, else returns string ''.
		 */
		public function get_legacy_template_id( $type ) {
			$args = [
				'post_type'    => 'elementor-ce',
				'meta_key'     => 'ce_template_type',
				'meta_value'   => $type,
				'meta_type'    => 'post',
				'meta_compare' => '>=',
				'orderby'      => 'meta_value',
				'order'        => 'ASC',
				'meta_query'   => [
					'relation' => 'OR',
					[
						'key'     => 'ce_template_type',
						'value'   => $type,
						'compare' => '==',
						'type'    => 'post',
					],
				],
			];

			$args     = apply_filters( 'ce_get_template_id_args', $args );
			$template = new WP_Query(
				$args
			);

			if ( $template->have_posts() ) {
				$posts = wp_list_pluck( $template->posts, 'ID' );
				return $posts[0];
			}

			return '';
		}

		/**
		 * Check if db upgrade is required.
		 *
		 * @since 1.0.0
		 * @return true|false True if stored database version is lower than constant; false if otherwise.
		 */
		private function needs_db_update() {
			$db_version = get_option( $this->db_option_key, false );

			if ( false === $db_version || version_compare( $db_version, COWIDGETS_VER ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Update DB version.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function update_db_version() {
			update_option( $this->db_option_key, COWIDGETS_VER );
		}
	}
}

new COWIDGETS_Update();
