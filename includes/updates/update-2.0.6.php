<?php //phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase -- This filename format is intentionally used to match the plugin version.
/**
 * The Updates routine for version 2.0.6.
 *
 * @since      2.0.6
 * @package    RankMathPro
 * @subpackage RankMathPro\Updates
 * @author     Rank Math <support@rankmath.com>
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * This code is needed to flush the new rewrite rules we added to fix the Code Validation issue.
 */
function rank_math_2_0_6_flush_rewrite_rules() {
	flush_rewrite_rules();
}

rank_math_2_0_6_flush_rewrite_rules();
