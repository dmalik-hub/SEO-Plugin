<?php
/**
 * The Version Control View to be used on Network Admin.
 *
 * @package    RankMath
 * @subpackage RankMath\Version_Control
 */

namespace GoHighSEO;

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

if ( Rollback_Version::should_rollback() ) {
	$rollback = new Rollback_Version();
	$rollback->rollback();
	return;
}

echo '<div id="rank-math-version-control-wrapper"></div>';
