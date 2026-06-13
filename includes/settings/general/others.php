<?php
/**
 * The misc settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Settings
 */

use GoHighSEO\KB;
use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'      => 'headless_support',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Headless CMS Support', 'gohigh-seo' ),
		// Translators: placeholder is a link to "Read more".
		'desc'    => sprintf( esc_html__( 'Enable this option to register a REST API endpoint that returns the HTML meta tags for a given URL. %s', 'gohigh-seo' ), '<a href="' . KB::get( 'headless-support', 'Others Tab KB Link' ) . '">' . esc_html__( 'Read more', 'gohigh-seo' ) . '</a>' ),
		'default' => 'off',
	]
);

$cmb->add_field(
	[
		'id'      => 'frontend_seo_score',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Show SEO Score to Visitors', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Proudly display the calculated SEO Score as a badge on the front end. It can be disabled for specific posts in the post editor.', 'gohigh-seo' ),
		'default' => 'off',
	]
);

$cmb->add_field(
	[
		'id'         => 'frontend_seo_score_post_types',
		'type'       => 'multicheck',
		'name'       => esc_html__( 'SEO Score Post Types', 'gohigh-seo' ),
		'options'    => Helper::choices_post_types(),
		'default_cb' => '\\GoHighSEO\\Frontend_SEO_Score::post_types_field_default',
		'dep'        => [ [ 'frontend_seo_score', 'on' ] ],
	]
);

$cmb->add_field(
	[
		'id'      => 'frontend_seo_score_template',
		'type'    => 'radio_inline',
		'name'    => esc_html__( 'SEO Score Template', 'gohigh-seo' ),
		'desc'    => sprintf( esc_html__( 'Change the styling for the front end SEO score badge.', 'gohigh-seo' ), '<code>nofollow</code>' ),
		'options' => [
			'circle' => esc_html__( 'Circle', 'gohigh-seo' ),
			'square' => esc_html__( 'Square', 'gohigh-seo' ),
		],
		'default' => 'circle',
		'dep'     => [ [ 'frontend_seo_score', 'on' ] ],
	]
);

$cmb->add_field(
	[
		'id'      => 'frontend_seo_score_position',
		'type'    => 'radio_inline',
		'name'    => esc_html__( 'SEO Score Position', 'gohigh-seo' ),
		'desc'    => sprintf(
			/* translators: 1.SEO Score Shortcode 2. SEO Score function */
			esc_html__( 'Display the badges automatically, or insert the %1$s shortcode in your posts and the %2$s template tag in your theme template files.', 'gohigh-seo' ),
			'<code>[rank_math_seo_score]</code>',
			'<code>&lt;?php&nbsp;rank_math_the_seo_score();&nbsp;?&gt;</code>'
		),
		'classes' => 'nob',
		'default' => 'top',
		'options' => [
			'bottom' => esc_html__( 'Below Content', 'gohigh-seo' ),
			'top'    => esc_html__( 'Above Content', 'gohigh-seo' ),
			'both'   => esc_html__( 'Above & Below Content', 'gohigh-seo' ),
			'custom' => esc_html__( 'Custom (use shortcode)', 'gohigh-seo' ),
		],
		'dep'     => [ [ 'frontend_seo_score', 'on' ] ],
	]
);

$cmb->add_field(
	[
		'id'      => 'support_rank_math',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Support Us with a Link', 'gohigh-seo' ),
		/* Translators: %s is the word "nofollow" code tag and second one for the filter link */
		'desc'    => sprintf( esc_html__( 'If you are showing the SEO scores on the front end, this option will insert a %1$s backlink to RankMath.com to show your support. You can change the link & the text by using this %2$s.', 'gohigh-seo' ), '<code>follow</code>', '<a href="' . KB::get( 'change-seo-score-backlink', 'Options Panel Support Us' ) . '" target="_blank">' . __( 'filter', 'gohigh-seo' ) . '</a>' ),
		'default' => 'on',
		'dep'     => [ [ 'frontend_seo_score', 'on' ] ],
	]
);

if ( current_user_can( 'manage_options' ) ) {
	$cmb->add_field(
		[
			'id'         => 'usage_tracking',
			'type'       => 'toggle',
			'name'       => esc_html__( 'Usage Tracking', 'gohigh-seo' ),
			'desc'       => esc_html__( 'Share anonymous usage data to help us improve Rank Math. No personal info is collected.', 'gohigh-seo' ) . ' <a href="' . KB::get( 'usage-policy', 'Others Tab KB Link' ) . '" target="_blank">' . esc_html__( 'Learn more about what data is and isn\'t tracked.', 'gohigh-seo' ) . '</a>',
			'default'    => 'off',
			'save_field' => false,
			'escape_cb'  => function () {
				return get_option( 'rank_math_mixpanel_optin', false ) ? 'on' : 'off';
			},
		]
	);
}

$cmb->add_field(
	[
		'id'   => 'rss_before_content',
		'type' => 'textarea_small',
		'name' => esc_html__( 'RSS Before Content', 'gohigh-seo' ),
		'desc' => esc_html__( 'Add content before each post in your site feeds.', 'gohigh-seo' ),
	]
);

$cmb->add_field(
	[
		'id'   => 'rss_after_content',
		'type' => 'textarea_small',
		'name' => esc_html__( 'RSS After Content', 'gohigh-seo' ),
		'desc' => esc_html__( 'Add content after each post in your site feeds.', 'gohigh-seo' ),
	]
);

$cmb->add_field(
	[
		'id'   => 'rank_math_rss_vars',
		'type' => 'raw',
		'file' => rank_math()->includes_dir() . 'settings/general/rss-vars-table.php',
	]
);
