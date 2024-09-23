<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 *
 * @package cowidgets
 */

// Use amazing Codeless_Target_Rules_Fields
use COWIDGETS\Lib\Codeless_Target_Rules_Fields;

/**
 * Class Header_Footer_Elementor
 */
class CoWidgets {

	/**
	 * Current theme template
	 *
	 * @var String
	 */
	public $template;

	/**
	 * Instance of Elemenntor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 */
	private static $elementor_instance;

	/**
	 * Instance of COWIDGETS_Admin
	 *
	 * @var CoWidgets_Admin
	 */
	private static $_instance = null;

	/**
	 * Instance of CoWidgets
	 *
	 * @return CoWidgets Instance of CoWidgets
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	/**
	 * Constructor
	 */
	function __construct() {
		$this->template = get_template();

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
			self::$elementor_instance = Elementor\Plugin::instance();

			$this->includes();
			$this->load_textdomain();
			if ( 'livecast' == $this->template ) {
				require COWIDGETS_DIR . 'themes/livecast/class-ce-livecast-compat.php';
			}else if ( 'remake' == $this->template ) {
				require COWIDGETS_DIR . 'themes/remake/class-ce-remake-compat.php';
			}else if ( 'specular' == $this->template ) {
					require COWIDGETS_DIR . 'themes/specular/class-ce-specular-compat.php';
			} else {
				add_action( 'init', [ $this, 'setup_unsupported_theme' ] );
			}

			// Scripts and styles.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

			add_filter( 'body_class', [ $this, 'body_class' ] );
			add_action( 'switch_theme', [ $this, 'reset_unsupported_theme_notice' ] );
			add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'add_megamenu_support' ], 9, 5 );
			add_action( 'wp_update_nav_menu_item', [ $this, 'save_megamenu_support' ], 10, 2 );

			add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'additional_icons' ], 9999999, 1 );
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'editor_custom_css' ] );
			add_shortcode( 'ce_template', [ $this, 'render_template' ] );

			add_filter( 'attachment_fields_to_edit', [ $this, 'add_permalink_media' ], 10, 2 );
			add_filter( 'attachment_fields_to_save', [ $this, 'save_permalink_media' ], 10, 2 );


		} else {
			add_action( 'admin_notices', [ $this, 'elementor_not_available' ] );
			add_action( 'network_admin_notices', [ $this, 'elementor_not_available' ] );
		}
	}

	public function editor_custom_css(){
		
		wp_enqueue_style( 'ce-custom-editor-css', COWIDGETS_URL . 'assets/css/ce-editor.css', [], COWIDGETS_VER );

	}

	/**
	 * Reset the Unsupported theme nnotice after a theme is switched.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function reset_unsupported_theme_notice() {
		delete_user_meta( get_current_user_id(), 'unsupported-theme' );
	}


	/**
	 * Prints the admin notics when Elementor is not installed or activated.
	 */
	public function elementor_not_available() {
		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
			$url = network_admin_url() . 'plugins.php?s=elementor';
		} else {
			$url = network_admin_url() . 'plugin-install.php?s=elementor&tab=search&type=term';
		}

		echo '<div class="notice notice-error">';
		/* translators: 1: opening strong tag, 2: closing strong tag, 3: opening anchor tag, 4: closing anchor tag */
		echo '<p>' . wp_kses(
			sprintf(
				/* translators: 1: opening strong tag, 2: closing strong tag, 3: opening anchor tag, 4: closing anchor tag */
				__('The %1$sCoWidgets%2$s plugin requires %3$sElementor%4$s plugin installed & activated.', 'cowidgets'),
				'<strong>', '</strong>',
				'<a href="' . esc_url($url) . '">', '</a>'
			),
			array(
				'strong' => array(),
				'a' => array(
					'href' => array()
				)
			)
		) . '</p>';

	}

	/**
	 * Loads the globally required files for the plugin.
	 */
	public function includes() {
		require_once COWIDGETS_DIR . 'inc/class-ce-helpers.php';

		require_once COWIDGETS_DIR . 'admin/class-ce-admin.php';

		require_once COWIDGETS_DIR . 'inc/ce-functions.php';

		// Load Elementor Canvas Compatibility.
		require_once COWIDGETS_DIR . 'inc/class-ce-elementor-canvas-compat.php';

		// Load Target rules.
		require_once COWIDGETS_DIR . 'inc/lib/target-rule/class-codeless-target-rules-fields.php';

		// Setup upgrade routines.
		require_once COWIDGETS_DIR . 'inc/class-ce-update.php';

		// Load custom elementor widgets.
		require COWIDGETS_DIR . 'inc/widgets-manager/class-widgets-loader.php';

	}

	public function add_megamenu_support( $item_id, $item, $depth, $args, $id ) {
		if( $depth != 0 ) {
			return;
		}
		
		wp_nonce_field( 'ce_megamenu_nonce', '_ce_megamenu_nonce' );
		$ce_megamenu = get_post_meta( $item_id, '_ce_megamenu', true );
	
		?>
		<p class="field-megamenu description">
			<label for="ce_megamenu-<?php echo esc_attr( $item_id ); ?>">
				<input type="checkbox" id="ce_megamenu-<?php echo esc_attr( $item_id ); ?>" value="yes" name="ce_megamenu[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $ce_megamenu, 'yes' ); ?> />
				<?php esc_html_e( 'Activate megamenu for this item', 'text-domain' ); ?>
			</label>
		</p>
		<?php
	}
	

	public function save_megamenu_support( $menu_id, $menu_item_db_id ){
		// Verify this came from our screen and with proper authorization.
		if ( ! isset( $_POST['_ce_megamenu_nonce'] ) || ! wp_verify_nonce( $_POST['_ce_megamenu_nonce'], 'ce_megamenu_nonce' ) ) {
			return $menu_id;
		}

		if ( isset( $_POST['ce_megamenu'][$menu_item_db_id]  ) ) {
			$sanitized_data = sanitize_text_field( $_POST['ce_megamenu'][$menu_item_db_id] );
			update_post_meta( $menu_item_db_id, '_ce_megamenu', $sanitized_data );
		} else {
			delete_post_meta( $menu_item_db_id, '_ce_megamenu' );
		}
	}

	/**
	 * Loads textdomain for the plugin.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'cowidgets' );
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ce-style', COWIDGETS_URL . 'assets/css/cowidgets.css', [], COWIDGETS_VER );
		wp_enqueue_style( 'feather', COWIDGETS_URL . 'assets/css/lib/feather.css', [], '1.0.0' );
		wp_enqueue_script( 'ce-global', COWIDGETS_URL . 'assets/js/ce-global.js', ['jquery'], COWIDGETS_VER );
		if ( ! wp_script_is( 'swiper', 'registered' ) )
			wp_enqueue_script( 'swiper', COWIDGETS_URL . 'assets/js/lib/swiper.min.js', [], COWIDGETS_VER );
		else
			wp_enqueue_script( 'swiper' );
		wp_localize_script( 'ce-global', 'ce_global', [
			'lib_js' => COWIDGETS_URL . 'assets/js/lib/'
		] );

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}

		if ( cowidgets_header_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( cowidgets_get_header_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( cowidgets_get_header_id() );
			}

			$css_file->enqueue();
		}

		if ( cowidgets_footer_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( cowidgets_get_footer_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( cowidgets_get_footer_id() );
			}

			$css_file->enqueue();
		}

		if ( cowidgets_is_before_footer_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( cowidgets_get_before_footer_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( cowidgets_get_before_footer_id() );
			}
			$css_file->enqueue();
		}
	}

	/**
	 * Load admin styles on header footer elementor edit screen.
	 */
	public function enqueue_admin_scripts() { 
		global $pagenow;
		$screen = get_current_screen();

		if ( ( ( 'elementor-ce' == $screen->id || 'portfolio' == $screen->id || 'testimonial' == $screen->id || 'page' == $screen->id || 'staff' == $screen->id ) && ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) ) || ( 'edit.php' == $pagenow && 'edit-elementor-ce' == $screen->id ) ) {
			wp_enqueue_style( 'ce-admin-style', COWIDGETS_URL . 'admin/assets/css/ce-admin.css', [], COWIDGETS_VER );
			wp_enqueue_script( 'ce-admin-script', COWIDGETS_URL . 'admin/assets/js/ce-admin.js', [], COWIDGETS_VER );
		}
	}

	/**
	 * Adds classes to the body tag conditionally.
	 *
	 * @param  Array $classes array with class names for the body tag.
	 *
	 * @return Array          array with class names for the body tag.
	 */
	public function body_class( $classes ) {
		
		if ( cowidgets_header_enabled() || get_the_ID() == cowidgets_get_header_id() ) {
			$classes[] = 'ce-header';

			$transparent_header = get_post_meta( (int) cowidgets_get_header_id(), 'ce_transparent_header' );
			
			if( $transparent_header )
				$classes[] = 'ce-header--transparent';
		}

		if ( cowidgets_footer_enabled() || get_the_ID() == cowidgets_get_footer_id() ) {
			$classes[] = 'ce-footer';
			$transparent_footer = get_post_meta( (int) cowidgets_get_footer_id(), 'ce_transparent_footer', true );
			if( $transparent_footer )
				$classes[] = 'ce-footer--transparent';
		}

		if( get_post_meta( get_the_ID(), 'ce_horizontal_scroll', true ) == 'yes' )
			$classes[] = 'ce-horizontal-scroll-page';

		$classes[] = 'ce-template-' . $this->template;
		$classes[] = 'ce-stylesheet-' . get_stylesheet();

		return $classes;
	}

	public function additional_icons( $icons ){
		$new_icons = apply_filters( 'ce_custom_icons', [] );
		
		return array_merge( $icons, $new_icons );
	}

	/**
	 * Display Unsupported theme notice if the current theme does add support for 'cowidgets'
	 *
	 * @since  1.0.3
	 */
	public function setup_unsupported_theme() {
		if ( ! current_theme_supports( 'cowidgets' ) ) {
			require_once COWIDGETS_DIR . 'themes/default/class-ce-fallback-theme-support.php';
		}
	}

	/**
	 * Prints the Header content.
	 */
	public static function get_header_content() {
		echo $elementor_instance->frontend->get_builder_content_for_display( cowidgets_get_header_id() );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Prints the Footer content.
	 */
	public static function get_footer_content() {
		echo "<div class='footer-width-fixer'>";
		echo self::$elementor_instance->frontend->get_builder_content_for_display( cowidgets_get_footer_id() );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}

	/**
	 * Prints the Before Footer content.
	 */
	public static function get_before_footer_content() {
		echo "<div class='footer-width-fixer'>";
		echo self::$elementor_instance->frontend->get_builder_content_for_display( cowidgets_get_before_footer_id() );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}

	/**
	 * Get option for the plugin settings
	 *
	 * @param  mixed $setting Option name.
	 * @param  mixed $default Default value to be received if the option value is not stored in the option.
	 *
	 * @return mixed.
	 */
	public static function get_settings( $setting = '', $default = '' ) {
		if ( 'type_header' == $setting || 'type_footer' == $setting || 'type_before_footer' == $setting ) {
			$templates = self::get_template_id( $setting );

			$template = ! is_array( $templates ) ? $templates : $templates[0];

			$template = apply_filters( "ce_get_settings_{$setting}", $template );

			return $template;
		}
	}

	/**
	 * Get header or footer template id based on the meta query.
	 *
	 * @param  String $type Type of the template header/footer.
	 *
	 * @return Mixed       Returns the header or footer template id if found, else returns string ''.
	 */
	public static function get_template_id( $type ) {
		$option = [
			'location'  => 'ce_target_include_locations',
			'exclusion' => 'ce_target_exclude_locations',
			'users'     => 'ce_target_user_roles',
		];

		$ce_templates = Codeless_Target_Rules_Fields::get_instance()->get_posts_by_conditions( 'elementor-ce', $option );

		foreach ( $ce_templates as $template ) {
			if ( get_post_meta( absint( $template['id'] ), 'ce_template_type', true ) === $type ) {
				return $template['id'];
			}
		}

		return '';
	}

	/**
	 * Callback to shortcode.
	 *
	 * @param array $atts attributes for shortcode.
	 */
	public function render_template( $atts ) {
		$atts = shortcode_atts(
			[
				'id' => '',
			],
			$atts,
			'ce_template'
		);

		$id = ! empty( $atts['id'] ) ? apply_filters( 'ce_render_template_id', intval( $atts['id'] ) ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $id );
		} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
			// Load elementor styles.
			$css_file = new \Elementor\Post_CSS_File( $id );
		}
			$css_file->enqueue();

		return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
	}

	function add_permalink_media ( $form_fields, $post ) {
    
		$form_fields['ce_permalink'] = array(
			'label' => esc_attr('Permalink', 'folie'),
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'ce_permalink', true ),
		);
	
		return $form_fields;
	
	}
	
	
	function save_permalink_media ( $post, $attachment ) {
			
		if( isset( $attachment['ce_permalink'] ) )
			update_post_meta( $post['ID'], 'ce_permalink', $attachment['ce_permalink'] );
	   
		return $post;
	
	}

}
