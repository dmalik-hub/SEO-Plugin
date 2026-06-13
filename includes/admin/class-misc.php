<?php
/**
 * Miscellaneous admin related functionality.
 *
 * @since      1.0
 * @package    RankMathPro
 * @subpackage RankMathPro\Admin
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Admin;

use GoHighSEO\Traits\Hooker;
use GoHighSEO\Admin\Admin_Helper as ProAdminHelper;

defined( 'ABSPATH' ) || exit;

/**
 * Misc admin class.
 *
 * @codeCoverageIgnore
 */
class Misc {

	use Hooker;

	/**
	 * Register hooks.
	 */
	public function __construct() {
		$this->filter( 'rank_math/pro_badge', 'header_pro_badge' );
	}

	/**
	 * Check and print the license type as a badge in the header of Rank Math's setting pages.
	 */
	public static function header_pro_badge() {
		$plan = ProAdminHelper::get_plan();
		return '<span class="gohigh-seo-badge ' . esc_attr( $plan ) . '">' . esc_html( $plan ) . '</span>';
	}
}
