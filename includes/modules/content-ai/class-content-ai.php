<?php
/**
 * The Content AI module.
 *
 * @since      3.0.25
 * @package    RankMath
 * @subpackage RankMathPro
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO;

use GoHighSEO\ContentAI\Content_AI as Content_AI_Free;
use GoHighSEO\Helper;
use GoHighSEO\Helpers\Param;
use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\Traits\Hooker;


defined( 'ABSPATH' ) || exit;

/**
 * Content_AI class.
 */
class Content_AI {
	use Hooker;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->action( 'admin_enqueue_scripts', 'content_ai_page_scripts', 99 );

		if ( ! Admin_Helper::is_business_plan() || ! Content_AI_Free::can_add_tab() ) {
			return;
		}

		if ( ! Helper::get_current_editor() ) {
			return;
		}

		$this->action( 'rank_math/admin/editor_scripts', 'editor_scripts', 19 );
	}

	/**
	 * Enqueue assets for the Content AI standalone page.
	 *
	 * @return void
	 */
	public function content_ai_page_scripts() {
		if ( 'rank-math-content-ai-page' !== Param::get( 'page' ) ) {
			return;
		}

		wp_enqueue_script(
			'gohigh-seo-content-ai',
			RANK_MATH_PRO_URL . 'includes/modules/content-ai/assets/js/content-ai.js',
			[ 'rank-math-content-ai' ],
			rank_math()->version,
			true
		);
	}

	/**
	 * Enqueue assets for post editors.
	 *
	 * @return void
	 */
	public function editor_scripts() {
		wp_enqueue_script(
			'gohigh-seo-content-ai',
			RANK_MATH_PRO_URL . 'includes/modules/content-ai/assets/js/content-ai.js',
			[ 'rank-math-content-ai' ],
			rank_math()->version,
			true
		);
		wp_set_script_translations( 'gohigh-seo-content-ai', 'gohigh-seo', RANK_MATH_PRO_PATH . 'languages/' );
	}
}
