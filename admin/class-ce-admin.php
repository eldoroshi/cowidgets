<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 *
 * @package  header-footer-elementor
 */

use COWIDGETS\Lib\Codeless_Target_Rules_Fields;

defined( 'ABSPATH' ) or exit;

/**
 * COWIDGETS_Admin setup
 *
 * @since 1.0
 */
class COWIDGETS_Admin {

	/**
	 * Instance of COWIDGETS_Admin
	 *
	 * @var COWIDGETS_Admin
	 */
	private static $_instance = null;

	/**
	 * Instance of COWIDGETS_Admin
	 *
	 * @return COWIDGETS_Admin Instance of COWIDGETS_Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		add_action( 'elementor/init', __CLASS__ . '::load_admin', 0 );

		return self::$_instance;
	}

	/**
	 * Load the icons style in editor.
	 *
	 * @since 1.0.0
	 */
	public static function load_admin() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::cowidgets_admin_enqueue_scripts' );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.0.0
	 * @param string $hook Current page hook.
	 * @access public
	 */
	public static function cowidgets_admin_enqueue_scripts( $hook ) {

		// Register the icons styles.
		wp_register_style(
			'ce-style',
			COWIDGETS_URL . 'assets/css/style.css',
			[],
			COWIDGETS_VER
		);

		wp_enqueue_style( 'ce-style' );
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'cowidgets_posttype' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 50 );
		add_action( 'add_meta_boxes', [ $this, 'cowidgets_register_metabox' ] );
		add_action( 'save_post', [ $this, 'cowidgets_save_meta' ] );
		add_action( 'admin_notices', [ $this, 'location_notice' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_filter( 'manage_elementor-ce_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_elementor-ce_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) && ELEMENTOR_PRO_VERSION > 2.8 ) {
			add_action( 'elementor/editor/footer', [ $this, 'register_ce_epro_script' ], 99 );
		}

		if ( is_admin() ) {
			add_action( 'manage_elementor-ce_posts_custom_column', [ $this, 'column_content' ], 10, 2 );
			add_filter( 'manage_elementor-ce_posts_columns', [ $this, 'column_headings' ] );
		}

		add_action( 'add_meta_boxes', [ $this, 'register_page_metaboxes' ] );
		add_action( 'save_post', [ $this, 'save_page_meta' ] );

		add_action( 'init', [ $this, 'register_custom_post_types' ] );
	}

	/**
	 * Script for Elementor Pro full site editing support.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_ce_epro_script() {
		$ids_array = [
			[
				'id'    => cowidgets_get_header_id(),
				'value' => 'Header',
			],
			[
				'id'    => cowidgets_get_footer_id(),
				'value' => 'Footer',
			],
			[
				'id'    => cowidgets_get_before_footer_id(),
				'value' => 'Before Footer',
			],
		];

		wp_enqueue_script( 'ce-elementor-pro-compatibility', COWIDGETS_URL . 'inc/js/ce-elementor-pro-compatibility.js', [ 'jquery' ], COWIDGETS_VER, true );

		wp_localize_script(
			'ce-elementor-pro-compatibility',
			'ce_admin',
			[
				'ids_array' => wp_json_encode( $ids_array ),
			]
		);
	}

	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['elementor_ce_display_rules'] = __( 'Display Rules', 'cowidgets' );
		$columns['date']                       = __( 'Date', 'cowidgets' );

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @since 1.0.0
	 * @param array $column Name of column.
	 * @param int   $post_id Post id.
	 * @return void
	 */
	public function column_content( $column, $post_id ) {

		if ( 'elementor_ce_display_rules' == $column ) {

			$locations = get_post_meta( $post_id, 'ce_target_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'ce_target_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headers-exclusion-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'ce_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = [];
					foreach ( $users as $user ) {
						$user_label[] = Codeless_Target_Rules_Fields::get_user_by_key( $user );
					}
					echo '<div class="ast-advanced-headers-users-wrap">';
					echo '<strong>Users: </strong>';
					echo join( ', ', wp_kses_post( $user_label ) );
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = [];
		$index          = array_search( 'specifics', $locations['rule'] );
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = Codeless_Target_Rules_Fields::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = Codeless_Target_Rules_Fields::get_location_by_key( $location );
			}
		}

		echo join( ', ', esc_attr( $location_label ) );
	}


	/**
	 * Register Post type for header footer templates
	 */
	public function cowidgets_posttype() {
		$labels = [
			'name'               => __( 'Codeless Elementor Templates', 'cowidgets' ),
			'singular_name'      => __( 'Codeless Template', 'cowidgets' ),
			'menu_name'          => __( 'Codeless Template', 'cowidgets' ),
			'name_admin_bar'     => __( 'Codeless Templates', 'cowidgets' ),
			'add_new'            => __( 'Add New', 'cowidgets' ),
			'add_new_item'       => __( 'Add New Header/Footer/Block', 'cowidgets' ),
			'new_item'           => __( 'New Header/Footer/Block Template', 'cowidgets' ),
			'edit_item'          => __( 'Edit Header/Footer/Block Template', 'cowidgets' ),
			'view_item'          => __( 'View Header/Footer/Block Template', 'cowidgets' ),
			'all_items'          => __( 'All CoWidgets', 'cowidgets' ),
			'search_items'       => __( 'Search Header/Footer/Block Templates', 'cowidgets' ),
			'parent_item_colon'  => __( 'Parent Header/Footer/Block Templates:', 'cowidgets' ),
			'not_found'          => __( 'No Header/Footer/Block Templates found.', 'cowidgets' ),
			'not_found_in_trash' => __( 'No Header/Footer/Block Templates found in Trash.', 'cowidgets' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'thumbnail', 'elementor' ],
		];

		register_post_type( 'elementor-ce', $args );
	}

	/**
	 * Register the admin menu for Header Footer builder.
	 *
	 * @since  1.0.0
	 * @since  1.0.0
	 *         Moved the menu under Appearance -> Header Footer Builder
	 */
	public function register_admin_menu() {
		add_submenu_page(
			'themes.php',
			__( 'Codeless Header/Footer/Block', 'cowidgets' ),
			__( 'Codeless Header/Footer/Block', 'cowidgets' ),
			'edit_pages',
			'edit.php?post_type=elementor-ce'
		);
	}

	/**
	 * Register meta box(es).
	 */
	function cowidgets_register_metabox() {
		add_meta_box(
			'ece-meta-box',
			__( 'CoWidgets options', 'cowidgets' ),
			[
				$this,
				'cowidgets_metabox_render',
			],
			'elementor-ce',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function cowidgets_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['ce_template_type'] ) ? esc_attr( $values['ce_template_type'][0] ) : '';
		$display_on_canvas = isset( $values['display-on-canvas-template'] ) ? true : false;
		$transparent_header = isset( $values['ce_transparent_header'] ) ? true : false;
		$transparent_footer = isset( $values['ce_transparent_footer'] ) ? true : false;

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row type-of-template">
					<td class="ce-options-row-heading">
						<label for="ce_template_type"><?php esc_attr_e( 'Type of Template', 'cowidgets' ); ?></label>
					</td>
					<td class="ce-options-row-content">
						<select name="ce_template_type" id="ce_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php esc_attr_e( 'Select Option', 'cowidgets' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php esc_attr_e( 'Header', 'cowidgets' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php esc_attr_e( 'Before Footer', 'cowidgets' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php esc_attr_e( 'Footer', 'cowidgets' ); ?></option>
							<option value="custom" <?php selected( $template_type, 'custom' ); ?>><?php esc_attr_e( 'Custom Block', 'cowidgets' ); ?></option>
						</select>
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
				<tr class="ce-options-row ce-shortcode">
					<td class="ce-options-row-heading">
						<label for="ce_template_type"><?php esc_attr_e( 'Shortcode', 'cowidgets' ); ?></label>
						<i class="ce-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Copy this shortcode and paste it into your post, page, or text widget content.', 'cowidgets' ); ?>">
						</i>
					</td>
					<td class="ce-options-row-content">
						<span class="ce-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[ce_template id='<?php echo esc_attr( $post->ID ); ?>']" class="ce-large-text code">
						</span>
					</td>
				</tr>

				<tr class="ce-options-row transparent-header">
					<td class="ce-options-row-heading">
						<label for="active-transparent-header">
							<?php esc_attr_e( 'Enable Transparent Header?', 'cowidgets' ); ?>
						</label>
						<i class="ce-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Enabling this option will show the header as transparent header over the Page Content.', 'cowidgets' ); ?>"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="checkbox" id="transparent-header" name="transparent-header" value="1" <?php checked( $transparent_header, true ); ?> />
					</td>
				</tr>
				<tr class="ce-options-row transparent-footer">
					<td class="ce-options-row-heading">
						<label for="active-transparent-footer">
							<?php esc_attr_e( 'Enable Transparent & Sticky Footer?', 'cowidgets' ); ?>
						</label>
						<i class="ce-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Enabling this option will show the footer as transparent footer over the Page Content and sticky on page bottom', 'cowidgets' ); ?>"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="checkbox" id="transparent-footer" name="transparent-footer" value="1" <?php checked( $transparent_footer, true ); ?> />
					</td>
				</tr>
				<tr class="ce-options-row enable-for-canvas">
					<td class="ce-options-row-heading">
						<label for="display-on-canvas-template">
							<?php esc_attr_e( 'Enable Layout for Elementor Canvas Template?', 'cowidgets' ); ?>
						</label>
						<i class="ce-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Enabling this option will display this layout on pages using Elementor Canvas Template.', 'cowidgets' ); ?>"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="checkbox" id="display-on-canvas-template" name="display-on-canvas-template" value="1" <?php checked( $display_on_canvas, true ); ?> />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 *
	 * @since  1.0.0
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		Codeless_Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'ce_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'ce_target_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'ce_target_user_roles', true );
		?>
		<tr class="bsf-target-rules-row ce-options-row">
			<td class="bsf-target-rules-row-heading ce-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'cowidgets' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should appear.', 'cowidgets' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content ce-options-row-content">
				<?php
				Codeless_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-location',
					[
						'title'          => __( 'Display Rules', 'cowidgets' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'cowidgets' ),
					],
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row ce-options-row">
			<td class="bsf-target-rules-row-heading ce-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'cowidgets' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'This Advanced Header will not appear at these locations.', 'cowidgets' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content ce-options-row-content">
				<?php
				Codeless_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-exclusion',
					[
						'title'          => __( 'Exclude On', 'cowidgets' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'cowidgets' ),
						'rule_type'      => 'exclude',
					],
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row ce-options-row">
			<td class="bsf-target-rules-row-heading ce-options-row-heading">
				<label><?php esc_html_e( 'User Roles', 'cowidgets' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Display custom template based on user role.', 'cowidgets' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content ce-options-row-content">
				<?php
				Codeless_Target_Rules_Fields::target_user_role_settings_field(
					'bsf-target-rules-users',
					[
						'title'          => __( 'Users', 'cowidgets' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add User Rule', 'cowidgets' ),
					],
					$users
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function cowidgets_save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = Codeless_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-location' );
		$target_exclusion = Codeless_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-exclusion' );
		$target_users     = [];

		if ( isset( $_POST['bsf-target-rules-users'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['bsf-target-rules-users'] );
		}

		update_post_meta( $post_id, 'ce_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'ce_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'ce_target_user_roles', $target_users );

		if ( isset( $_POST['ce_template_type'] ) ) {
			update_post_meta( $post_id, 'ce_template_type', sanitize_text_field( $_POST['ce_template_type'] ) );
		}

		if ( isset( $_POST['display-on-canvas-template'] ) ) {
			update_post_meta( $post_id, 'display-on-canvas-template', sanitize_text_field( $_POST['display-on-canvas-template'] ) );
		} else {
			delete_post_meta( $post_id, 'display-on-canvas-template' );
		}

		if( isset( $_POST['transparent-header'] ) ) {
			update_post_meta( $post_id, 'ce_transparent_header', sanitize_text_field( $_POST['transparent-header'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_transparent_header' );
		}

		if( isset( $_POST['transparent-footer'] ) ) {
			update_post_meta( $post_id, 'ce_transparent_footer', sanitize_text_field( $_POST['transparent-footer'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_transparent_footer' );
		}
	}

	/**
	 * Display notice when editing the header or footer when there is one more of similar layout is active on the site.
	 *
	 * @since 1.0.0
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'elementor-ce' != $post->post_type ) {
			return;
		}

		$template_type = get_post_meta( $post->ID, 'ce_template_type', true );

		if ( '' !== $template_type ) {
			$templates = CoWidgets::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID != $templates[0] ) {
				$post_title        = '<strong>' . get_the_title( $templates[0] ) . '</strong>';
				$template_location = '<strong>' . $this->template_location( $template_type ) . '</strong>';
				/* Translators: Post title, Template Location */
				$message = sprintf( __( 'Template %1$s is already assigned to the location %2$s', 'cowidgets' ), $post_title, $template_location );

				echo '<div class="error"><p>';
				echo esc_html( $message );
				echo '</p></div>';
			}
		}
	}

	/**
	 * Convert the Template name to be added in the notice.
	 *
	 * @since  1.0.0
	 *
	 * @param  String $template_type Template type name.
	 *
	 * @return String $template_type Template type name.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( str_replace( 'type_', '', $template_type ) );

		return $template_type;
	}

	/**
	 * Don't display the elementor header footer templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'elementor-ce' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @since  1.0.0
	 *
	 * @param  String $single_template Single template.
	 */
	function load_canvas_template( $single_template ) {
		global $post;

		if ( 'elementor-ce' == $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'cowidgets' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="ce-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[ce_template id='<?php echo esc_attr( $post_id ); ?>']" class="ce-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}




	function register_custom_post_types(){
		if( apply_filters( 'ce_register_portfolio_post_type', true ) ){
			$this->register_portfolio_post_type();
			add_action( 'add_meta_boxes', [ $this, 'register_portfolio_metaboxes' ] );
			add_action( 'save_post', [ $this, 'save_portfolio_meta' ] );
		}

		if( apply_filters( 'ce_register_testimonial_post_type', true ) ){
			$this->register_testimonial_post_type();
			add_action( 'add_meta_boxes', [ $this, 'register_testimonial_metaboxes' ] );
			add_action( 'save_post', [ $this, 'save_testimonial_meta' ] );
		}

		if( apply_filters( 'ce_register_staff_post_type', true ) ){
			$this->register_staff_post_type();
			add_action( 'add_meta_boxes', [ $this, 'register_staff_metaboxes' ] );
			add_action( 'save_post', [ $this, 'save_staff_meta' ] );
		}

		if( apply_filters( 'ce_register_podcast_post_type', false ) ){
			$this->register_podcast_post_type();
			/*add_action( 'add_meta_boxes', [ $this, 'register_podcast_metaboxes' ] );
			add_action( 'save_post', [ $this, 'save_podcast_meta' ] );*/
		}
	}


	public function register_portfolio_post_type() {

		$labels = array(
			'name' => _x('Portfolio Items', 'post type general name', 'cowidgets'),
			'singular_name' => _x('Portfolio Entry', 'post type singular name', 'cowidgets'),
			'add_new' => _x('Add New', 'portfolio', 'cowidgets'),
			'add_new_item' => __('Add New Portfolio Entry', 'cowidgets'),
			'edit_item' => __('Edit Portfolio Entry', 'cowidgets'),
			'new_item' => __('New Portfolio Entry', 'cowidgets'),
			'view_item' => __('View Portfolio Entry', 'cowidgets'),
			'search_items' => __('Search Portfolio Entries', 'cowidgets'),
			'not_found' =>  __('No Portfolio Entries found', 'cowidgets'),
			'not_found_in_trash' => __('No Portfolio Entries found in Trash', 'cowidgets'), 
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'rewrite' => array(
				'slug'=> apply_filters( 'ce_portfolio_slug', 'portfolio' ),
				'with_front' => true
			),
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'supports' => array('title','thumbnail','excerpt','editor')
		);

		register_post_type( 'portfolio' , $args );
	
		register_taxonomy( "portfolio_entries", 
	
			array( "portfolio" ), 
			array(
				"hierarchical" => true, 
				"label" => esc_attr__( "Portfolio Categories", 'cowidgets' ),
				"singular_label" => esc_attr__( "Portfolio Categories", 'cowidgets' ), 
				'rewrite' => array(
					'slug'=> apply_filters( 'ce_portfolio_cat_slug', 'portfolio_entries' ),
					'with_front' => true
				),
				"query_var" => true
	
			)
		);  
	}


	public function register_portfolio_metaboxes() {
		add_meta_box(
			'ce-portfolio-metabox',
			__( 'CoWidgets Options', 'cowidgets' ),
			[
				$this,
				'portfolio_metaboxes_render',
			],
			'portfolio',
			'normal',
			'high'
		);
	}

	public function portfolio_metaboxes_render( $post ){
		$values            = get_post_custom( $post->ID );
		$portfolio_custom_link     = isset( $values['ce_portfolio_custom_link'] ) ? esc_attr( $values['ce_portfolio_custom_link'][0] ) : '';
	
		// We'll use this nonce field  lateron when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row type-of-template">
					<td class="ce-options-row-heading">
						<label for="ce_template_type"><?php esc_attr_e( 'Portfolio Custom Link', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="Leave empty to use the default WP permalinks"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="text" id="portfolio-custom-link" name="ce_portfolio_custom_link" value="<?php echo esc_attr( $portfolio_custom_link ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}


	public function save_portfolio_meta( $post_id ){
		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if( isset( $_POST['ce_portfolio_custom_link'] ) ) {
			update_post_meta( $post_id, 'ce_portfolio_custom_link', sanitize_text_field( $_POST['ce_portfolio_custom_link'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_portfolio_custom_link' );
		}
	}



	/* Testimonial */


	public function register_testimonial_post_type() {

		$labels = array(
			'name' => _x('Testimonial Items', 'post type general name', 'cowidgets'),
			'singular_name' => _x('Testimonial Entry', 'post type singular name', 'cowidgets'),
			'add_new' => _x('Add New', 'testimonial', 'cowidgets'),
			'add_new_item' => __('Add New Testimonial Entry', 'cowidgets'),
			'edit_item' => __('Edit Testimonial Entry', 'cowidgets'),
			'new_item' => __('New Testimonial Entry', 'cowidgets'),
			'view_item' => __('View Testimonial Entry', 'cowidgets'),
			'search_items' => __('Search Testimonial Entries', 'cowidgets'),
			'not_found' =>  __('No Testimonial Entries found', 'cowidgets'),
			'not_found_in_trash' => __('No Testimonial Entries found in Trash', 'cowidgets'), 
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'rewrite' => array(
				'slug'=> apply_filters( 'ce_testimonial_slug', 'testimonial' ),
				'with_front' => true
			),
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'supports' => array('title','thumbnail','excerpt','editor')
		);

		register_post_type( 'testimonial' , $args );
	
		register_taxonomy( "testimonial_entries", 
	
			array( "testimonial" ), 
			array(
				"hierarchical" => true, 
				"label" => esc_attr__( "Testimonial Categories", 'cowidgets' ),
				"singular_label" => esc_attr__( "Testimonial Categories", 'cowidgets' ), 
				"rewrite" => true,
				"query_var" => true
	
			)
		);  
	}



	public function register_testimonial_metaboxes() {
		add_meta_box(
			'ce-testimonial-metabox',
			__( 'CoWidgets Options', 'cowidgets' ),
			[
				$this,
				'testimonial_metaboxes_render',
			],
			'testimonial',
			'normal',
			'high'
		);
	}

	public function testimonial_metaboxes_render( $post ){
		
		$values            = get_post_custom( $post->ID );
		$testimonial_position     = isset( $values['ce_testimonial_position'] ) ? esc_attr( $values['ce_testimonial_position'][0] ) : '';
		
		// We'll use this nonce field  lateron when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row type-of-template">
					<td class="ce-options-row-heading">
						<label for="ce_template_type"><?php esc_attr_e( 'Testimonial Work Position', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="Work position or company name here."></i>
					</td>
					<td class="ce-options-row-content">
						<input type="text" id="testimonial-position" name="ce_testimonial_position" value="<?php echo esc_attr( $testimonial_position ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function save_testimonial_meta( $post_id ){
		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if( isset( $_POST['ce_testimonial_position'] ) ) {
			update_post_meta( $post_id, 'ce_testimonial_position', sanitize_text_field( $_POST['ce_testimonial_position'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_testimonial_position' );
		}
	}



	/* Staff */



	public function register_staff_post_type() {

		$labels = array(
			'name' => _x('Staff Items', 'post type general name', 'cowidgets'),
			'singular_name' => _x('Staff Entry', 'post type singular name', 'cowidgets'),
			'add_new' => _x('Add New', 'staff', 'cowidgets'),
			'add_new_item' => __('Add New Staff Entry', 'cowidgets'),
			'edit_item' => __('Edit Staff Entry', 'cowidgets'),
			'new_item' => __('New Staff Entry', 'cowidgets'),
			'view_item' => __('View Staff Entry', 'cowidgets'),
			'search_items' => __('Search Staff Entries', 'cowidgets'),
			'not_found' =>  __('No Staff Entries found', 'cowidgets'),
			'not_found_in_trash' => __('No Staff Entries found in Trash', 'cowidgets'), 
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'rewrite' => array(
				'slug'=> apply_filters( 'ce_staff_slug', 'staff' ),
				'with_front' => true
			),
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'supports' => array('title','thumbnail','excerpt','editor'),
			'show_in_rest' => false,
		);

		register_post_type( 'staff' , $args );
	
		register_taxonomy( "staff_entries", 
	
			array( "staff" ), 
			array(
				"hierarchical" => true, 
				"label" => esc_attr__( "Staff Categories", 'cowidgets' ),
				"singular_label" => esc_attr__( "Staff Categories", 'cowidgets' ), 
				"rewrite" 		=> true,
				"query_var" 	=> true,	
				'show_in_rest' 	=> false,			
	
			)
		);  
	}



	public function register_staff_metaboxes() {
		add_meta_box(
			'ce-staff-metabox',
			__( 'CoWidgets Options', 'cowidgets' ),
			[
				$this,
				'staff_metaboxes_render',
			],
			'staff',
			'normal',
			'high'
		);
	}

	public function staff_metaboxes_render( $post ){
		
		$values            = get_post_custom( $post->ID );
		$staff_position     = isset( $values['ce_staff_position'] ) ? esc_attr( $values['ce_staff_position'][0] ) : '';
		$staff_custom_link     = isset( $values['ce_staff_custom_link'] ) ? esc_attr( $values['ce_staff_custom_link'][0] ) : '';

		$social_facebook     = isset( $values['ce_staff_social_facebook'] ) ? esc_attr( $values['ce_staff_social_facebook'][0] ) : '';
		$social_twitter     = isset( $values['ce_staff_social_twitter'] ) ? esc_attr( $values['ce_staff_social_twitter'][0] ) : '';
		$social_instagram    = isset( $values['ce_staff_social_instagram'] ) ? esc_attr( $values['ce_staff_social_instagram'][0] ) : '';
		$social_linkedin     = isset( $values['ce_staff_social_linkedin'] ) ? esc_attr( $values['ce_staff_social_linkedin'][0] ) : '';
		$social_pinterest     = isset( $values['ce_staff_social_pinterest'] ) ? esc_attr( $values['ce_staff_social_pinterest'][0] ) : '';

		
		// We'll use this nonce field  lateron when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row">
					<td class="ce-options-row-heading">
						<label for="staff-position"><?php esc_attr_e( 'Staff Work Position', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="Work position or company name here."></i>
					</td>
					<td class="ce-options-row-content">
						<input type="text" id="staff-position" name="ce_staff_position" value="<?php echo esc_attr( $staff_position ); ?>" />
					</td>
				</tr>
				<tr class="ce-options-row">
					<td class="ce-options-row-heading">
						<label for="staff-custom-link"><?php esc_attr_e( 'Staff Custom Link', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="Leave empty to use the default WP permalinks"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="text" id="staff-custom-link" name="ce_staff_custom_link" value="<?php echo esc_attr( $staff_custom_link ); ?>" />
					</td>
				</tr>
				<tr class="ce-options-row">
					<td class="ce-options-row-heading">
						<label for="staff-socials"><?php esc_attr_e( 'Staff Socials', 'cowidgets' ); ?></label>
					</td>
					<td class="ce-options-row-content">
						<div style="margin-bottom:10px;">
							<label style="min-width:150px; display:inline-block;" for="staff-facebook"><?php esc_attr_e( 'Facebook', 'cowidgets' ); ?></label>
							<input type="text" id="staff-facebook" name="ce_staff_social_facebook" value="<?php echo esc_attr( $social_facebook ); ?>" />
						</div>

						<div style="margin-bottom:10px;">
							<label style="min-width:150px; display:inline-block;" for="staff-twitter"><?php esc_attr_e( 'Twitter', 'cowidgets' ); ?></label>
							<input type="text" id="staff-twitter" name="ce_staff_social_twitter" value="<?php echo esc_attr( $social_twitter ); ?>" />
						</div>

						<div style="margin-bottom:10px;">
							<label style="min-width:150px; display:inline-block;" for="staff-pinterest"><?php esc_attr_e( 'Pinterest', 'cowidgets' ); ?></label>
							<input type="text" id="staff-pinterest" name="ce_staff_social_pinterest" value="<?php echo esc_attr( $social_pinterest ); ?>" />
						</div>

						<div style="margin-bottom:10px;">
							<label style="min-width:150px; display:inline-block;" for="staff-linkedin"><?php esc_attr_e( 'Linkedin', 'cowidgets' ); ?></label>
							<input type="text" id="staff-linkedin" name="ce_staff_social_linkedin" value="<?php echo esc_attr( $social_linkedin ); ?>" />
						</div>

						<div style="margin-bottom:10px;">
							<label style="min-width:150px; display:inline-block;" for="staff-instagram"><?php esc_attr_e( 'Instagram', 'cowidgets' ); ?></label>
							<input type="text" id="staff-instagram" name="ce_staff_social_instagram" value="<?php echo esc_attr( $social_instagram ); ?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function save_staff_meta( $post_id ){
		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if( isset( $_POST['ce_staff_position'] ) ) {
			update_post_meta( $post_id, 'ce_staff_position', sanitize_text_field( $_POST['ce_staff_position'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_position' );
		}

		if( isset( $_POST['ce_staff_custom_link'] ) ) {
			update_post_meta( $post_id, 'ce_staff_custom_link', sanitize_text_field( $_POST['ce_staff_custom_link'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_custom_link' );
		}

		if( isset( $_POST['ce_staff_social_facebook'] ) ) {
			update_post_meta( $post_id, 'ce_staff_social_facebook', sanitize_text_field( $_POST['ce_staff_social_facebook'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_social_facebook' );
		}

		if( isset( $_POST['ce_staff_social_twitter'] ) ) {
			update_post_meta( $post_id, 'ce_staff_social_twitter', sanitize_text_field( $_POST['ce_staff_social_twitter'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_social_twitter' );
		}

		if( isset( $_POST['ce_staff_social_instagram'] ) ) {
			update_post_meta( $post_id, 'ce_staff_social_instagram', sanitize_text_field( $_POST['ce_staff_social_instagram'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_social_instagram' );
		}

		if( isset( $_POST['ce_staff_social_pinterest'] ) ) {
			update_post_meta( $post_id, 'ce_staff_social_pinterest', sanitize_text_field( $_POST['ce_staff_social_pinterest'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_social_pinterest' );
		}

		if( isset( $_POST['ce_staff_social_linkedin'] ) ) {
			update_post_meta( $post_id, 'ce_staff_social_linkedin', sanitize_text_field( $_POST['ce_staff_social_linkedin'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_staff_social_linkedin' );
		}
	}



	/* Podcast */

	public function register_podcast_post_type() {

		$labels = array(
			'name' => _x('Podcast Episodes', 'post type general name', 'cowidgets'),
			'singular_name' => _x('Podcast Episode', 'post type singular name', 'cowidgets'),
			'add_new' => _x('Add New', 'portfolio', 'cowidgets'),
			'add_new_item' => __('Add New Podcast Episode', 'cowidgets'),
			'edit_item' => __('Edit Podcast Episode', 'cowidgets'),
			'new_item' => __('New Podcast Episode', 'cowidgets'),
			'view_item' => __('View Podcast Episode', 'cowidgets'),
			'search_items' => __('Search Podcast Episodes', 'cowidgets'),
			'not_found' =>  __('No Podcast Episodes found', 'cowidgets'),
			'not_found_in_trash' => __('No Podcast Episodes found in Trash', 'cowidgets'), 
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'rewrite' => array(
				'slug'=> apply_filters( 'ce_podcast_slug', 'episode' ),
				'with_front' => true
			),
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'supports' => array('title','thumbnail','excerpt','editor', 'comments'),
			'show_in_rest' => true,
		);

		register_post_type( 'podcast' , $args );
	
		register_taxonomy( "podcast_shows", 
	
			array( "podcast" ), 
			array(
				"hierarchical" => true, 
				"label" => esc_attr__( "Podcast Shows", 'cowidgets' ),
				"singular_label" => esc_attr__( "Podcast Show", 'cowidgets' ), 
				'rewrite' => array(
					'slug'=> apply_filters( 'ce_podcast_show_slug', 'show' ),
					'with_front' => true
				),
				"query_var" => true,
				'show_in_rest'      => true,
	
			)
		); 

		register_taxonomy( "podcast_tags", 
	
			array( "podcast" ), 
			array(
				"hierarchical" => false, 
				"label" => esc_attr__( "Podcast Tags", 'cowidgets' ),
				"singular_label" => esc_attr__( "Podcast Tag", 'cowidgets' ), 
				'rewrite' => array(
					'slug'=> apply_filters( 'ce_podcast_tag_slug', 'show-tag' ),
					'with_front' => true
				),
				"query_var" => true,
				'show_in_rest'      => true,
	
			)
		); 
	}


	/*public function register_podcast_metaboxes() {
		add_meta_box(
			'ce-portfolio-metabox',
			__( 'CoWidgets Options', 'cowidgets' ),
			[
				$this,
				'portfolio_metaboxes_render',
			],
			'portfolio',
			'normal',
			'high'
		);
	}

	public function portfolio_metaboxes_render( $post ){
		$values            = get_post_custom( $post->ID );
		$portfolio_custom_link     = isset( $values['ce_portfolio_custom_link'] ) ? esc_attr( $values['ce_portfolio_custom_link'][0] ) : '';
	
		// We'll use this nonce field  lateron when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row type-of-template">
					<td class="ce-options-row-heading">
						<label for="ce_template_type"><?php esc_attr_e( 'Portfolio Custom Link', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="Leave empty to use the default WP permalinks"></i>
					</td>
					<td class="ce-options-row-content">
						<input type="text" id="portfolio-custom-link" name="ce_portfolio_custom_link" value="<?php echo esc_attr( $portfolio_custom_link ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}


	public function save_portfolio_meta( $post_id ){
		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if( isset( $_POST['ce_portfolio_custom_link'] ) ) {
			update_post_meta( $post_id, 'ce_portfolio_custom_link', sanitize_text_field( $_POST['ce_portfolio_custom_link'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_portfolio_custom_link' );
		}
	}*/



	public function register_page_metaboxes() {
		add_meta_box(
			'ce-page-metabox',
			__( 'CoWidgets Options', 'cowidgets' ),
			[
				$this,
				'page_metaboxes_render',
			],
			'page',
			'normal',
			'high'
		);
	}

	public function page_metaboxes_render($post){
		$values            = get_post_custom( $post->ID );
		$horizontal_scroll     = isset( $values['ce_horizontal_scroll'] ) ? esc_attr( $values['ce_horizontal_scroll'][0] ) : '';
	

		// We'll use this nonce field  lateron when saving.
		wp_nonce_field( 'ce_meta_nounce', 'ce_meta_nounce' );
		?>
		<table class="ce-options-table widefat">
			<tbody>
				<tr class="ce-options-row">
					<td class="ce-options-row-heading">
						<label for="horizontal-scroll"><?php esc_attr_e( 'Horizontal Scroll', 'cowidgets' ); ?></label>
						<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="By activating, all elementor sections will be transforming to horizontal slider sections."></i>
					</td>
					<td class="ce-options-row-content">
						<select name="ce_horizontal_scroll" id="horizontal-scroll">
							<option value="no" <?php selected( $horizontal_scroll, 'no' ); ?>><?php esc_attr_e( 'No', 'cowidgets' ); ?></option>
							<option value="yes" <?php selected( $horizontal_scroll, 'yes' ); ?>><?php esc_attr_e( 'Yes', 'cowidgets' ); ?></option>
						</select>
					</td>
				</tr>
			
			</tbody>
		</table>
		<?php
	}

	public function save_page_meta( $post_id ){
		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ce_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ce_meta_nounce'], 'ce_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if( isset( $_POST['ce_horizontal_scroll'] ) ) {
			update_post_meta( $post_id, 'ce_horizontal_scroll', sanitize_text_field( $_POST['ce_horizontal_scroll'] ) );
		}else{
			delete_post_meta( $post_id, 'ce_horizontal_scroll' );
		}

		
	}
}

COWIDGETS_Admin::instance();
