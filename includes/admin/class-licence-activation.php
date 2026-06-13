<?php
/**
 * License Activation Handler
 *
 * Handles the site registration process with RankMath.com using the API key and username
 * defined in the licence-data.php file. This class is responsible for sending the
 * registration request, managing the response, and storing activation status.
 *
 * @since      3.0.88
 * @package    RankMathPro
 * @subpackage RankMathPro\Admin
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Admin;

use GoHighSEO\Helper;
use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\KB;
use GoHighSEO\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Licence_Activation class.
 */
class Licence_Activation {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'admin_init', 'init', 1 );
	}

	/**
	 * Init function.
	 */
	public function init() {
		// Early bail if site is connected or the licence file doesn't exists.
		if (
			Helper::is_site_connected() ||
			! $this->get_licence_file()
		) {
			return;
		}

		// Early Bail if constants required to register site are not defined.
		if (
			! defined( 'RANK_MATH_LICENCE_KEY' ) ||
			! RANK_MATH_LICENCE_KEY ||
			! defined( 'RANK_MATH_LICENCE_USER' ) ||
			! RANK_MATH_LICENCE_USER
		) {
			$this->delete_licence_file();
			return;
		}

		update_option(
			'rank_math_reseller_data',
			[
				'username' => RANK_MATH_LICENCE_USER,
				'api_key'  => RANK_MATH_LICENCE_KEY,
			],
			false
		);

		$this->enroll_site( RANK_MATH_LICENCE_USER, RANK_MATH_LICENCE_KEY );
		$this->delete_licence_file();
	}

	/**
	 * On plugin activation call enroll site endpoint.
	 */
	public static function activate_licence() {
		$reseller_data = get_option( 'rank_math_reseller_data', [] );
		if ( empty( $reseller_data ) ) {
			return;
		}

		self::enroll_site( $reseller_data['username'], $reseller_data['api_key'] );
	}

	/**
	 * Function to enroll site on plugin activation or when Licence file exists in the plugin
	 *
	 * @param string $username Username.
	 * @param string $api_key  API key.
	 */
	private static function enroll_site( $username, $api_key ) {
		$params   = [
			'site_url' => untrailingslashit( is_multisite() ? network_site_url() : home_url() ),
			'username' => $username,
			'api_key'  => $api_key,
		];
		$response = wp_remote_post(
			add_query_arg( 'v', RANK_MATH_PRO_VERSION, 'https://rankmath.com/wp-json/rankmath/v1/enrollSite/' ),
			[
				'body' => $params,
			]
		);

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) {
			self::add_error_notice();

			return false;
		}

		$response_body = wp_remote_retrieve_body( $response );
		$result        = json_decode( $response_body, true );
		if ( ! empty( $result['error'] ) ) {
			self::add_error_notice( $result['error'] );
			return false;
		}

		if ( isset( $result['error'] ) ) {
			unset( $result['error'] );
		}

		$result['connected'] = true;

		Admin_Helper::get_registration_data( $result );

		return true;
	}

	/**
	 * Get the licence data file.
	 */
	private function get_licence_file() {
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php'; // @phpstan-ignore-line
		}

		global $wp_filesystem;
		if ( is_null( $wp_filesystem ) ) {
			return false;
		}

		$licence_file = RANK_MATH_PRO_PATH . 'licence-data.php';
		return $wp_filesystem->exists( $licence_file ) ? $licence_file : false;
	}

	/**
	 * Delete the licence file.
	 */
	private function delete_licence_file() {
		global $wp_filesystem;
		$wp_filesystem->delete( $this->get_licence_file() );
	}

	/**
	 * Add error notice.
	 *
	 * @param string $err_key Error key.
	 */
	private static function add_error_notice( $err_key = '' ) {
		$default_error = __( 'Unable to validate Rank Math SEO registration data.', 'gohigh-seo' ) .
		' <a href="' . esc_url( Admin_Helper::get_activate_url() ) . '">' . __( 'Please try reconnecting.', 'gohigh-seo' ) . '</a> ' .
		sprintf(
			/* translators: KB Link */
			__( 'If the issue persists, please try the solution described in our Knowledge Base article: %s', 'gohigh-seo' ),
			'<a href="' . KB::get( 'unable-to-encrypt', 'Registration Data' ) . '" target="_blank">' . __( '[3. Unable to Encrypt]', 'gohigh-seo' ) . '</a>'
		);
		$errors = [
			'not_found'    => '<strong>' . esc_html__( 'Activation failed: ', 'gohigh-seo' ) . '</strong>' . esc_html__( 'Site not recognized or not registered with your license - please contact your Reseller.', 'gohigh-seo' ),
			'invalid_user' => '<strong>' . esc_html__( 'Activation failed: ', 'gohigh-seo' ) . '</strong>' . esc_html__( 'Invalid username or API key - please contact your Reseller.', 'gohigh-seo' ),
			'banned_user'  => '<strong>' . esc_html__( 'Activation denied: ', 'gohigh-seo' ) . '</strong>' . esc_html__( 'Your account has been banned - please contact your Reseller for assistance.', 'gohigh-seo' ),
			'banned_site'  => '<strong>' . esc_html__( 'Activation denied: ', 'gohigh-seo' ) . '</strong>' . esc_html__( 'This website is blocked from using the plugin - please contact your Reseller.', 'gohigh-seo' ),
		];

		$error = ! empty( $errors[ $err_key ] ) ? $errors[ $err_key ] : $default_error;

		Helper::add_notification(
			$error,
			[
				'type'    => 'error',
				'classes' => 'is-dismissible',
			]
		);
	}
}
