<?php
/**
 * The Wizard pages helper.
 *
 * @since      1.0.3
 * @package    RankMath
 * @subpackage RankMath\Traits
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Traits;

use GoHighSEO\Helper as GlobalHelper;
use GoHighSEO\Helpers\Security;

defined( 'ABSPATH' ) || exit;

/**
 * Wizard class.
 */
trait Wizard {
	/**
	 * Is the page is current page.
	 *
	 * @return boolean
	 */
	public function is_current_page() {
		$page = isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ? filter_input( INPUT_GET, 'page' ) : false;
		return $page === $this->slug;
	}
}
