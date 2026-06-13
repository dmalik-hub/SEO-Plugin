<?php
/**
 * Rest class for News Sitemap.
 *
 * @since      3.0.57
 * @package    RankMath
 * @subpackage RankMath\Rest
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Sitemap\News_Sitemap;

use WP_Error;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Controller;
use GoHighSEO\Helper;
use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\Sitemap\News_Sitemap_Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Rest class.
 */
class Rest extends WP_REST_Controller {
	/**
	 * Constructor.
	 */
	public function __construct() {
		register_rest_route(
			\GoHighSEO\Rest\Rest_Helper::BASE . '/sitemap',
			'/getTerms',
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'get_terms' ],
				'permission_callback' => [ $this, 'has_permission' ],
				'args'                => $this->validate_args(),
			]
		);
	}

	/**
	 * Determines if the current user can manage sitemap.
	 *
	 * @return true
	 */
	public function has_permission() {
		if ( ! Helper::has_cap( 'sitemap' ) ) {
			return new WP_Error(
				'rest_cannot_access',
				__( 'Sorry, only authenticated users can research the keyword.', 'gohigh-seo' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Rest callback to get the terms.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_terms( WP_REST_Request $request ) {
		return Admin_Helper::get_taxonomy_terms( $request->get_param( 'taxonomy' ), [], $request->get_param( 'search' ) );
	}

	/**
	 * Validate getTerms endpoint arguments.
	 *
	 * @return array
	 */
	public function validate_args() {
		return [
			'taxonomy' => [
				'type'              => 'string',
				'required'          => true,
				'description'       => esc_html__( 'Taxonomy to look for terms', 'gohigh-seo' ),
				'validate_callback' => [ '\\GoHighSEO\\Rest\\Rest_Helper', 'is_param_empty' ],
			],
			'search'   => [
				'type'              => 'string',
				'required'          => true,
				'description'       => esc_html__( 'Searched string', 'gohigh-seo' ),
				'validate_callback' => [ '\\GoHighSEO\\Rest\\Rest_Helper', 'is_param_empty' ],
			],
		];
	}
}
