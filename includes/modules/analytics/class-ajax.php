<?php
/**
 * The Analytics AJAX
 *
 * @since      1.4.0
 * @package    RankMathPro
 * @subpackage RankMathPro\modules
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Analytics;

use GoHighSEO\Google\Adsense;
use GoHighSEO\Helpers\Param;
use GoHighSEO\Analytics\Workflow\Base;
use GoHighSEO\Analytics\Workflow\Workflow;

defined( 'ABSPATH' ) || exit;

/**
 * Ajax class.
 */
class Ajax {

	use \GoHighSEO\Traits\Ajax;

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->ajax( 'save_adsense_account', 'save_adsense_account' );
		$this->ajax( 'check_adsense_request', 'check_adsense_request' );
	}

	/**
	 * Check the Google AdSense request.
	 */
	public function check_adsense_request() {
		check_ajax_referer( 'rank-math-ajax-nonce', 'security' );
		$this->has_cap_ajax( 'analytics' );

		$success = Adsense::test_connection();
		if ( false === $success ) {
			$this->error( esc_html__( 'Data import will not work for this service as sufficient permissions are not given.', 'gohigh-seo' ) );
		}

		$this->success();
	}

	/**
	 * Save adsense profile.
	 */
	public function save_adsense_account() {
		$this->verify_nonce( 'rank-math-ajax-nonce' );
		$this->has_cap_ajax( 'analytics' );

		$prev                = get_option( 'rank_math_google_analytic_options', [] );
		$value               = get_option( 'rank_math_google_analytic_options', [] );
		$value['adsense_id'] = Param::post( 'accountID' );

		// Test AdSense connection request.
		if ( ! empty( $value['adsense_id'] ) ) {
			$dates   = Base::get_dates();
			$request = Adsense::get_adsense(
				[
					'account_id' => $value['adsense_id'],
					'start_date' => $dates['start_date'],
					'end_date'   => $dates['end_date'],
				]
			);

			if ( is_wp_error( $request ) ) {
				$this->error( esc_html__( 'Data import will not work for this service as sufficient permissions are not given.', 'gohigh-seo' ) );
			}
		}

		update_option( 'rank_math_google_analytic_options', $value );

		$days = Param::get( 'days', 90, FILTER_VALIDATE_INT );
		Workflow::do_workflow(
			'adsense',
			$days,
			$prev,
			$value
		);

		$this->success();
	}
}
