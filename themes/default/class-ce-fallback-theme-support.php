<?php
/**
 * CE Fallback Theme Support.
 *
 * Add theme compatibility for all the WordPress themes.
 *
 * @since 1.0.0
 * @package hfe
 */

namespace COWIDGETS\Themes;

/**
 * Class CE Theme Fallback support.
 *
 * @since 1.0.0
 */
class COWIDGETS_Fallback_Theme_Support {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->setup_fallback_support();
		add_action( 'admin_menu', [ $this, 'cowidgets_register_settings_page' ] );
		add_action( 'admin_init', [ $this, 'cowidgets_admin_init' ] );
		add_action( 'admin_head', [ $this, 'cowidgets_global_css' ] );
		add_filter( 'views_edit-elementor-ce', [ $this, 'cowidgets_settings' ], 10, 1 );
	}

	/**
	 * Adds CSS to Hide the extra submenu added for the settings tab.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function cowidgets_global_css() {
		wp_enqueue_style( 'ce-admin-style', COWIDGETS_URL . 'admin/assets/css/ece-admin.css', [], COWIDGETS_VER );
	}

	/**
	 * Adds a tab in plugin submenu page.
	 *
	 * @since 1.0.0
	 * @param string $views to add tab to current post type view.
	 *
	 * @return mixed
	 */
	public function cowidgets_settings( $views ) {
		$this->cowidgets_tabs();
		return $views;
	}


	/**
	 * Function for registering the settings api.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function cowidgets_admin_init() {
		register_setting( 'ce-plugin-options', 'cowidgets_compatibility_option' );
		add_settings_section( 'ce-options', __( 'Add Theme Support', 'cowidgets' ), [ $this, 'cowidgets_compatibility_callback' ], 'Settings' );
		add_settings_field( 'ce-way', 'Methods to Add Theme Support', [ $this, 'cowidgets_compatibility_option_callback' ], 'Settings', 'ce-options' );
	}

	/**
	 * Call back function for the ssettings api function add_settings_section
	 *
	 * This function can be used to add description of the settings sections
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function cowidgets_compatibility_callback() {
		/* translators: 1: line break tag */
		echo wp_kses( 
			__( 'The Elementor - Header, Footer & Blocks plugin needs compatibility with your current theme to work smoothly.<br><br>Following are two methods that enable theme support for the plugin.<br><br>Method 1 is selected by default and that works fine with almost all themes. In case you face any issue with the header or footer template, try choosing Method 2.', 'cowidgets' ), 
			array( 
				'br' => array() 
			) 
		);
	}
	

	/**
	 * Call back function for the ssettings api function add_settings_field
	 *
	 * This function will contain the markup for the input feilds that we can add.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function cowidgets_compatibility_option_callback() {
		$ce_radio_button = get_option( 'ce_compatibility_option', '1' );
			wp_enqueue_style( 'ce-admin-style', COWIDGETS_URL . 'admin/assets/css/ece-admin.css', [], COWIDGETS_VER );
		?>

		<label>
			<input type="radio" name="ce_compatibility_option" value= 1 <?php checked( $ce_radio_button, 1 ); ?> > <div class="ce_radio_options"><?php esc_html_e( ' Method 1 (Recommended)', 'cowidgets' ); ?></div>
			<p class="description"><?php esc_html_e( 'This method replaces your theme\'s header (header.php) & footer (footer.php) template with plugin\'s custom templates.', 'cowidgets' ); ?></p><br>
		</label>
		<label>
			<input type="radio" name="ce_compatibility_option" value= 2 <?php checked( $ce_radio_button, 2 ); ?> > <div class="ce_radio_options"><?php esc_html_e( 'Method 2', 'cowidgets' ); ?></div>
			<p class="description">
				<?php
				echo sprintf(
					esc_html( "This method hides your theme's header & footer template with CSS and displays custom templates from the plugin.", 'cowidgets' ),
					'<br>'
				);
				?>
			</p><br>
		</label>
		<p class="description">
			<?php
			$plugin_link = '<a href="https://codeless.co">plugin</a>';
			$message = sprintf(
				/* translators: %s: link to the plugin */
				__( 'Sometimes above methods might not work well with your theme. In this case, contact your theme author and request them to add support for the %s.', 'cowidgets' ),
				$plugin_link
			);
			echo wp_kses_post( $message );
			?>
		</p>



		<?php
	}

	/**
	 * Setup Theme Support.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function setup_fallback_support() {
		$ce_compatibility_option = get_option( 'ce_compatibility_option', '1' );

		if ( '1' === $ce_compatibility_option ) {
			require COWIDGETS_DIR . 'themes/default/class-ce-default-compat.php';
		} elseif ( '2' === $ce_compatibility_option ) {
			require COWIDGETS_DIR . 'themes/default/class-global-theme-compatibility.php';
		}
	}

	/**
	 * Show a settings page incase of unsupported theme.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cowidgets_register_settings_page() {
		add_submenu_page(
			'themes.php',
			__( 'Settings', 'cowidgets' ),
			__( 'Settings', 'cowidgets' ),
			'manage_options',
			'ce-settings',
			[ $this, 'cowidgets_settings_page' ]
		);
	}

	/**
	 * Settings page.
	 *
	 * Call back function for add submenu page function.
	 *
	 * @since 1.0.0
	 */
	public function cowidgets_settings_page() {
		echo '<h1 class="ce-heading-inline">';
		esc_attr_e( 'Elementor - Header, Footer & Blocks ', 'cowidgets' );
		echo '</h1>';

		?>
		<h2 class="nav-tab-wrapper">
			<?php
			$tabs       = [
				'ce_templates' => [
					'name' => __( 'All templates', 'cowidgets' ),
					'url'  => admin_url( 'edit.php?post_type=elementor-ce' ),
				],
				'ce_settings'  => [
					'name' => __( 'Theme Support', 'cowidgets' ),
					'url'  => admin_url( 'themes.php?page=ce-settings' ),
				],
			];
			$active_tab = 'ce-settings' == isset( $_GET['page'] ) && $_GET['page'] ? 'ce_settings' : 'ce_templates';
			foreach ( $tabs as $tab_id => $tab ) {
				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';
				echo '<a href="' . esc_url( $tab['url'] ) . '" class="nav-tab' . esc_attr($active) . '">';
				echo esc_html( $tab['name'] );
				echo '</a>';
			}
			?>
		</h2>
		<br />
		<?php
		$ce_radio_button = get_option( 'ce_compatibility_option', '1' );
		?>
		<form action="options.php" method="post">
			<?php settings_fields( 'ce-plugin-options' ); ?>
			<?php do_settings_sections( 'Settings' ); ?>
			<?php submit_button(); ?>
		</form></div>
		<?php
	}

	/**
	 * Function for adding tabs
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function cowidgets_tabs() {
		?>
		<h2 class="nav-tab-wrapper">
			<?php
			$tabs       = [
				'ce_templates' => [
					'name' => __( 'All templates', 'cowidgets' ),
					'url'  => admin_url( 'edit.php?post_type=elementor-ce' ),
				],
				'ce_settings'  => [
					'name' => __( 'Theme Support', 'cowidgets' ),
					'url'  => admin_url( 'themes.php?page=ce-settings' ),
				],
			];
			$active_tab = 'ce-settings' == isset( $_GET['page'] ) && $_GET['page'] ? 'ce_settings' : 'ce_templates';
			foreach ( $tabs as $tab_id => $tab ) {
				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $tab['url'] ) . '" class="nav-tab' . esc_attr( $active ) . '">';
				echo esc_html( $tab['name'] );
				echo '</a>';
			}

			?>
		</h2>
		<br />
		<?php
	}

}

new COWIDGETS_Fallback_Theme_Support();
