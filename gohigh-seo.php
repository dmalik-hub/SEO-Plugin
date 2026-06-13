<?php // @codingStandardsIgnoreLine
/**
 * GoHigh SEO Plugin.
 *
 * @package      GOHIGH_SEO
 * @copyright    Copyright (C) 2024, GoHigh SEO
 * @link         https://gohighseo.com
 * @since        1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       GoHigh SEO
 * Version:           1.0.0
 * Plugin URI:        https://gohighseo.com/
 * Description:       GoHigh SEO is the most powerful WordPress SEO plugin with the features of many SEO and AI tools in a single package to help multiply your SEO traffic.
 * Author:            GoHigh SEO
 * Author URI:        https://gohighseo.com/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       gohigh-seo
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

// License bypass — plugin works as standalone without external registration.
add_filter( 'rank_math/admin/sensitive_data_encryption', '__return_false' );

update_option(
	'rank_math_connect_data',
	[
		'username'  => 'pro',
		'email'     => 'pro@gohighseo.com',
		'api_key'   => '*********',
		'plan'      => 'business',
		'connected' => true,
	]
);
update_option( 'rank_math_registration_skip', 1 );

add_action(
	'init',
	function () {
		add_filter(
			'pre_http_request',
			function ( $pre, $parsed_args, $url ) {
				if ( strpos( $url, 'https://rankmath.com/wp-json/rankmath/v1/' ) !== false ) {
					$basename = basename( parse_url( $url, PHP_URL_PATH ) );
					if ( 'siteSettings' === $basename ) {
						return [
							'response' => [ 'code' => 200, 'message' => 'OK' ],
							'body'     => wp_json_encode(
								[
									'error'    => '',
									'plan'     => 'business',
									'keywords' => get_option( 'rank_math_keyword_quota', [ 'available' => 10000, 'taken' => 0 ] ),
									'analytics' => 'on',
								]
							),
						];
					} elseif ( 'keywordsInfo' === $basename ) {
						if ( isset( $parsed_args['body']['count'] ) ) {
							return [
								'response' => [ 'code' => 200, 'message' => 'OK' ],
								'body'     => wp_json_encode( [ 'available' => 10000, 'taken' => $parsed_args['body']['count'] ] ),
							];
						}
					}
					return [ 'response' => [ 'code' => 200, 'message' => 'OK' ] ];
				}
				return $pre;
			},
			10,
			3
		);
	}
);

/**
 * GoHighSEO class.
 *
 * @class Main class of the merged GoHigh SEO plugin (free + pro).
 */
final class GoHighSEO {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Rank Math database version.
	 *
	 * @var string
	 */
	public $db_version = '1';

	/**
	 * Minimum version of WordPress required to run this plugin.
	 *
	 * @var string
	 */
	private $wordpress_version = '6.3';

	/**
	 * Minimum version of PHP required to run this plugin.
	 *
	 * @var string
	 */
	private $php_version = '7.4';

	/**
	 * Holds various class instances.
	 *
	 * @var array
	 */
	private $container = [];

	/**
	 * Hold install error messages.
	 *
	 * @var array
	 */
	private $messages = [];

	/**
	 * The single instance of the class.
	 *
	 * @var GoHighSEO
	 */
	protected static $instance = null;

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param  string $prop Property to check.
	 * @return bool
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 * Magic getter method.
	 *
	 * @param  string $prop Property to get.
	 * @return mixed Property value or NULL if it does not exists.
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		if ( isset( $this->{$prop} ) ) {
			return $this->{$prop};
		}

		return null;
	}

	/**
	 * Magic setter method.
	 *
	 * @param mixed $prop  Property to set.
	 * @param mixed $value Value to set.
	 */
	public function __set( $prop, $value ) {
		if ( property_exists( $this, $prop ) ) {
			$this->$prop = $value;
			return;
		}

		$this->container[ $prop ] = $value;
	}

	/**
	 * Magic call method.
	 *
	 * @param  string $name      Method to call.
	 * @param  array  $arguments Arguments to pass when calling.
	 * @return mixed Return value of the callback.
	 */
	public function __call( $name, $arguments ) {
		$hash = [
			'plugin_dir'   => RANK_MATH_PATH,
			'plugin_url'   => RANK_MATH_URL,
			'includes_dir' => RANK_MATH_PATH . 'includes/',
			'assets'       => RANK_MATH_URL . 'assets/front/',
			'admin_dir'    => RANK_MATH_PATH . 'includes/admin/',
		];

		if ( isset( $hash[ $name ] ) ) {
			return $hash[ $name ];
		}

		return call_user_func_array( $name, $arguments );
	}

	/**
	 * Initialize.
	 */
	public function init() {}

	/**
	 * Retrieve main GoHighSEO instance.
	 *
	 * @see gohigh_seo()
	 * @return GoHighSEO
	 */
	public static function get() {
		if ( is_null( self::$instance ) && ! ( self::$instance instanceof GoHighSEO ) ) {
			self::$instance = new GoHighSEO();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the plugin.
	 */
	private function setup() {
		$this->define_constants();

		if ( ! $this->is_requirements_meet() ) {
			return;
		}

		$this->includes();
		$this->instantiate();

		// Loaded action (same as free, for any hooks that still use it).
		do_action( 'rank_math/loaded' );

		// PRO setup — integrated directly into unified bootstrap.
		$this->pro_setup();
	}

	/**
	 * Check that the WordPress and PHP setup meets the plugin requirements.
	 *
	 * @return bool
	 */
	private function is_requirements_meet() {
		if ( version_compare( get_bloginfo( 'version' ), $this->wordpress_version, '<' ) ) {
			/* translators: WordPress Version */
			$this->messages[] = sprintf( esc_html__( 'You are using the outdated WordPress, please update it to version %s or higher.', 'gohigh-seo' ), $this->wordpress_version );
		}

		if ( version_compare( phpversion(), $this->php_version, '<' ) ) {
			/* translators: PHP Version */
			$this->messages[] = sprintf( esc_html__( 'GoHigh SEO requires PHP version %s or above. Please update PHP to run this plugin.', 'gohigh-seo' ), $this->php_version );
		}

		if ( empty( $this->messages ) ) {
			return true;
		}

		add_action( 'admin_init', [ $this, 'auto_deactivate' ] );
		add_action( 'admin_notices', [ $this, 'activation_error' ] );

		return false;
	}

	/**
	 * Auto-deactivate plugin if requirements are not met.
	 */
	public function auto_deactivate() {
		deactivate_plugins( plugin_basename( RANK_MATH_FILE ) );
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] ); // phpcs:ignore
		}
	}

	/**
	 * Error notice on plugin activation.
	 */
	public function activation_error() {
		?>
		<div class="notice rank-math-notice notice-error">
			<p>
				<?php echo join( '<br>', $this->messages ); // phpcs:ignore ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Define the plugin constants (both unified RANK_MATH_* and RANK_MATH_PRO_* for compatibility).
	 */
	private function define_constants() {
		define( 'RANK_MATH_VERSION', $this->version );
		define( 'RANK_MATH_FILE', __FILE__ );
		define( 'RANK_MATH_PATH', dirname( RANK_MATH_FILE ) . '/' );
		define( 'RANK_MATH_URL', plugins_url( '', RANK_MATH_FILE ) . '/' );
		define( 'RANK_MATH_SITE_URL', 'https://gohighseo.com' );
		define( 'RANK_MATH_PRO_VERSION', $this->version );
		define( 'RANK_MATH_PRO_FILE', __FILE__ );
		define( 'RANK_MATH_PRO_PATH', dirname( __FILE__ ) . '/' );
		define( 'RANK_MATH_PRO_URL', plugins_url( '', __FILE__ ) . '/' );

		if ( ! defined( 'CONTENT_AI_URL' ) ) {
			define( 'CONTENT_AI_URL', 'https://cai.rankmath.com' );
		}
	}

	/**
	 * Include the required files.
	 */
	private function includes() {
		include __DIR__ . '/vendor/autoload.php';

		$licence_file = __DIR__ . '/licence-data.php';
		if ( file_exists( $licence_file ) ) {
			include $licence_file;
		}

		if ( class_exists( 'WP\MCP\Core\McpAdapter' ) && function_exists( 'wp_get_abilities' ) ) {
			\WP\MCP\Core\McpAdapter::instance();
		}

		$file = get_stylesheet_directory() . '/rank-math.php';
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}

	/**
	 * Instantiate FREE plugin classes.
	 */
	private function instantiate() {
		// FREE installer: creates FREE DB tables, default options, cron jobs.
		new \GoHighSEO\Free_Installer();

		// Setting Manager.
		$this->container['settings'] = new \GoHighSEO\Settings();

		// JSON Manager.
		$this->container['json'] = new \GoHighSEO\Json_Manager();

		// Notification Manager.
		$this->container['notification'] = new \GoHighSEO\Admin\Notifications\Notification_Center( 'rank_math_notifications' );

		// Product Registration (bypass invalid check — plugin is standalone).
		$this->container['registration'] = new \GoHighSEO\Admin\Registration();

		$this->container['manager']   = new \GoHighSEO\Module\Manager();
		$this->container['variables'] = new \GoHighSEO\Replace_Variables\Manager();

		// FREE common hooks.
		new \GoHighSEO\Free_Common();
		$this->container['rewrite'] = new \GoHighSEO\Rewrite();
		new \GoHighSEO\Compatibility();
		$this->container['tracking'] = new \GoHighSEO\Tracking();

		// Frontend SEO Score.
		$this->container['frontend_seo_score'] = new \GoHighSEO\Frontend_SEO_Score();
		$this->load_3rd_party();

		// Initialize the action and filter hooks.
		$this->init_actions();
	}

	/**
	 * PRO setup — runs immediately after rank_math/loaded fires.
	 */
	private function pro_setup() {
		// PRO installer: creates PRO DB tables, enables PRO modules.
		new \GoHighSEO\Installer();

		// Load PRO modules (news-sitemap, video-sitemap, podcast, link-genius, etc.).
		new \GoHighSEO\Modules();

		// Load PRO 3rd-party integrations.
		$this->pro_load_3rd_party();

		// PRO common hooks.
		new \GoHighSEO\Common();
		new \GoHighSEO\Setup_Wizard();
		new \GoHighSEO\Register_Vars();

		// Hook PRO admin, REST, and theme init.
		if ( is_admin() ) {
			add_action( 'rank_math/admin/loaded', [ $this, 'init_pro_admin' ], 15 );
		}
		add_action( 'rest_api_init', [ $this, 'init_pro_rest_api' ] );
		add_action( 'after_setup_theme', [ $this, 'init_pro' ], 11 );
		add_action( 'after_setup_theme', [ $this, 'pro_localization_setup' ], 1 );
	}

	/**
	 * PRO admin init.
	 */
	public function init_pro_admin() {
		new \GoHighSEO\Admin\Admin();
	}

	/**
	 * PRO REST API init.
	 */
	public function init_pro_rest_api() {
		$controllers = [
			new \GoHighSEO\Schema\Rest(),
			new \GoHighSEO\Analytics\Rest(),
			new \GoHighSEO\Rest\Rest(),
		];

		foreach ( $controllers as $controller ) {
			$controller->register_routes();
		}
	}

	/**
	 * PRO theme/module init (runs on after_setup_theme, priority 11).
	 */
	public function init_pro() {
		if ( is_super_admin() ) {
			new \GoHighSEO\Robots_Txt();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'image-seo' ) ) {
			new \GoHighSEO\Image_Seo_Pro();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'bbpress' ) ) {
			new \GoHighSEO\BBPress();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'local-seo', false ) ) {
			new \GoHighSEO\Local_Seo\Local_Seo();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'analytics' ) ) {
			new \GoHighSEO\Analytics\Analytics();
		}

		if ( \GoHighSEO\Helper::is_woocommerce_active() && \GoHighSEO\Helper::is_module_active( 'woocommerce' ) ) {
			new \GoHighSEO\WooCommerce();
		}

		if ( \GoHighSEO\Helper::is_module_active( '404-monitor' ) ) {
			new \GoHighSEO\Monitor_Pro();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'redirections' ) ) {
			new \GoHighSEO\Redirections\Redirections();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'seo-analysis' ) ) {
			new \GoHighSEO\SEO_Analysis\SEO_Analysis_Pro();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'link-counter' ) ) {
			new \GoHighSEO\Link_Genius\Link_Genius();
		}

		if ( function_exists( 'acf' ) && \GoHighSEO\Helper::is_module_active( 'acf' ) ) {
			new \GoHighSEO\ACF\ACF();
		}

		if ( \GoHighSEO\Helper::is_module_active( 'content-ai' ) ) {
			new \GoHighSEO\Content_AI();
		}

		new \GoHighSEO\Status\System_Status();
		new \GoHighSEO\Plugin_Update\Plugin_Update();
		new \GoHighSEO\Thumbnail_Overlays();
	}

	/**
	 * PRO localization setup.
	 */
	public function pro_localization_setup() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'gohigh-seo' ); // phpcs:ignore

		unload_textdomain( 'rank-math-pro' );
		load_plugin_textdomain( 'gohigh-seo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Load 3rd party modules.
	 */
	private function load_3rd_party() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php'; // @phpstan-ignore-line
		}

		// Elementor.
		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			new \GoHighSEO\Elementor\Elementor();
		}

		// Loco Translate.
		if ( is_plugin_active( 'loco-translate/loco.php' ) ) {
			new \GoHighSEO\ThirdParty\Loco\Loco_I18n_Inline();
		}

		// WPML.
		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			new \GoHighSEO\ThirdParty\WPML();
		}

		// Divi theme.
		add_action(
			'after_setup_theme',
			function () {
				if ( defined( 'ET_CORE' ) ) {
					new \GoHighSEO\Divi\Divi();
				}
			},
			11
		);
		add_action(
			'current_screen',
			function () {
				if ( defined( 'ET_CORE' ) ) {
					new \GoHighSEO\Divi\Divi_Admin();
				}
			}
		);
	}

	/**
	 * Load PRO 3rd party integrations.
	 */
	private function pro_load_3rd_party() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php'; // @phpstan-ignore-line
		}

		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			new \GoHighSEO\Elementor\Elementor();
		}

		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			new \GoHighSEO\ThirdParty\WPML();
		}

		add_action(
			'after_setup_theme',
			function () {
				if ( defined( 'ET_CORE' ) ) {
					new \GoHighSEO\Divi\Divi();
				}
			},
			11
		);

		if ( class_exists( '\\WPMedia\\PluginFamily\\Controller\\PluginFamily' ) ) {
			new \GoHighSEO\ThirdParty\Plugin_Family();
		}
	}

	/**
	 * Initialize WordPress action and filter hooks.
	 */
	private function init_actions() {
		add_action( 'init', [ $this, 'pass_admin_content' ] );

		// Plugin action links.
		add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );
		add_filter( 'plugin_action_links_' . plugin_basename( RANK_MATH_FILE ), [ $this, 'plugin_action_links' ] );
		add_action( 'after_plugin_row_' . plugin_basename( RANK_MATH_FILE ), [ $this, 'plugin_row_deactivate_notice' ] );

		// Booting.
		add_action( 'plugins_loaded', [ $this, 'init' ], 14 );
		add_action( 'rest_api_init', [ $this, 'init_rest_api' ] );

		// WordPress Abilities API integration.
		add_action( 'init', [ $this, 'init_abilities' ], 0 );

		// Load admin-related functionality.
		if ( is_admin() ) {
			add_action( 'plugins_loaded', [ $this, 'init_admin' ], 15 );
		}

		// Frontend-only functionality.
		if ( ! is_admin() || in_array( \GoHighSEO\Helpers\Param::request( 'action' ), [ 'elementor', 'elementor_ajax' ], true ) ) {
			add_action( 'plugins_loaded', [ $this, 'init_frontend' ], 15 );
		}

		// WP_CLI.
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			add_action( 'plugins_loaded', [ $this, 'init_wp_cli' ], 20 );
		}
	}

	/**
	 * Bootstrap the WordPress Abilities API integration.
	 */
	public function init_abilities() {
		\GoHighSEO\Abilities\Abilities::get();
	}

	/**
	 * Load the FREE REST API endpoints.
	 */
	public function init_rest_api() {
		$controllers = [
			new \GoHighSEO\Rest\Admin(),
			new \GoHighSEO\Rest\Front(),
			new \GoHighSEO\Rest\Shared(),
			new \GoHighSEO\Rest\Post(),
			new \GoHighSEO\Rest\Headless(),
			new \GoHighSEO\Rest\Setup_Wizard(),
		];

		foreach ( $controllers as $controller ) {
			$controller->register_routes();
		}
	}

	/**
	 * Initialize the admin-related functionality.
	 */
	public function init_admin() {
		new \GoHighSEO\Admin\Admin_Init();
	}

	/**
	 * Initialize the frontend functionality.
	 */
	public function init_frontend() {
		$this->container['frontend'] = new \GoHighSEO\Frontend\Frontend();
	}

	/**
	 * Add our custom WP-CLI commands.
	 */
	public function init_wp_cli() {
		WP_CLI::add_command( 'rankmath sitemap generate', [ '\GoHighSEO\CLI\Commands', 'sitemap_generate' ] );
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param  mixed $links Plugin Action links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$options = [
			'options-general' => __( 'Settings', 'gohigh-seo' ),
			'wizard'          => __( 'Setup Wizard', 'gohigh-seo' ),
		];

		if ( $this->container['registration']->invalid ) {
			$options = [
				'registration' => __( 'Setup Wizard', 'gohigh-seo' ),
			];
		}

		foreach ( $options as $link => $label ) {
			$plugin_links[] = '<a href="' . \GoHighSEO\Helper::get_admin_url( $link ) . '">' . esc_html( $label ) . '</a>';
		}

		return array_merge( $links, $plugin_links );
	}

	/**
	 * Add a notice when clear data filter is present.
	 *
	 * @param string $file Plugin file.
	 */
	public function plugin_row_deactivate_notice( $file ) {
		if ( false === apply_filters( 'rank_math_clear_data_on_uninstall', false ) ) {
			return;
		}

		if ( is_multisite() && ! is_network_admin() && is_plugin_active_for_network( $file ) ) {
			return;
		}

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
		echo '<tr class="plugin-update-tr active rank-math-deactivate-notice-row" data-slug="" data-plugin="' . esc_attr( $file ) . '" style="position: relative; top: -1px;"><td colspan="' . esc_attr( $wp_list_table->get_column_count() ) . '" class="plugin-update colspanchange"><div class="notice inline notice-error notice-alt"><p>';
		printf(
			/* translators: 1. Bold text 2. Bold text */
			esc_html__( '%1$s A filter to remove the GoHigh SEO data from the database is present. Deactivating & Deleting this plugin will remove everything related to the GoHigh SEO plugin. %2$s', 'gohigh-seo' ),
			'<strong>' . esc_html__( 'CAUTION:', 'gohigh-seo' ) . '</strong>',
			'<br /><strong>' . esc_html__( 'This action is IRREVERSIBLE.', 'gohigh-seo' ) . '</strong>'
		);
		echo '</p></div></td></tr>';
	}

	/**
	 * Add extra links as row meta on the plugin screen.
	 *
	 * @param  mixed $links Plugin Row Meta.
	 * @param  mixed $file  Plugin Base file.
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( plugin_basename( RANK_MATH_FILE ) !== $file ) {
			return $links;
		}

		$more = [
			'<a href="' . admin_url( '?page=rank-math&view=help' ) . '">' . esc_html__( 'Getting Started', 'gohigh-seo' ) . '</a>',
			'<a href="https://gohighseo.com/docs/" target="_blank">' . esc_html__( 'Documentation', 'gohigh-seo' ) . '</a>',
		];

		return array_merge( $links, $more );
	}

	/**
	 * Localize admin content to JS.
	 */
	public function pass_admin_content() {
		if ( is_user_logged_in() && is_admin_bar_showing() ) {
			$this->container['json']->add( 'version', $this->version, 'rankMath' );
			$this->container['json']->add( 'ajaxurl', admin_url( 'admin-ajax.php' ), 'rankMath' );
			$this->container['json']->add( 'adminurl', admin_url( 'admin.php' ), 'rankMath' );
			$this->container['json']->add( 'endpoint', esc_url_raw( rest_url( 'rankmath/v1' ) ), 'rankMath' );
			$this->container['json']->add( 'security', wp_create_nonce( 'rank-math-ajax-nonce' ), 'rankMath' );
			$this->container['json']->add( 'restNonce', ( wp_installing() && ! is_multisite() ) ? '' : wp_create_nonce( 'wp_rest' ), 'rankMath' );
			$this->container['json']->add( 'modules', \GoHighSEO\Helper::get_active_modules(), 'rankMath' );
		}
	}
}

/**
 * Returns the main instance of GoHighSEO to prevent the need to use globals.
 *
 * @return GoHighSEO
 */
function gohigh_seo() { // phpcs:ignore
	return GoHighSEO::get();
}

// Backward-compat aliases so any remaining rank_math() calls still work.
function rank_math() { // phpcs:ignore
	return GoHighSEO::get();
}

// Start it.
gohigh_seo();
