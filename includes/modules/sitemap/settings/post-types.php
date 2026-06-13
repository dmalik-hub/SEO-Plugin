<?php
/**
 * Sitemap settings - post type tabs.
 *
 * @package    RankMath
 * @subpackage RankMath\Sitemap
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$attributes        = [];
$current_post_type = $tab['post_type'];
$prefix            = "pt_{$current_post_type}_";

if ( 'attachment' === $current_post_type && Helper::get_settings( 'general.attachment_redirect_urls', true ) ) {
	$cmb->add_field(
		[
			'id'      => 'attachment_redirect_urls_notice',
			'type'    => 'notice',
			'what'    => 'warning',
			/* translators: The settings page link */
			'content' => sprintf( __( 'To configure meta tags for your media attachment pages, you need to first %s to parent.', 'gohigh-seo' ), '<a href="' . esc_url( Helper::get_settings_url( 'general', 'links' ) ) . '">' . esc_html__( 'disable redirect attachments', 'gohigh-seo' ) . '</a>' ),
		]
	);
	$attributes['disabled'] = 'disabled';
}

$cmb->add_field(
	[
		'id'         => $prefix . 'sitemap',
		'type'       => 'toggle',
		'name'       => esc_html__( 'Include in Sitemap', 'gohigh-seo' ),
		'desc'       => esc_html__( 'Include this post type in the XML sitemap.', 'gohigh-seo' ),
		'default'    => 'attachment' === $current_post_type ? 'off' : 'on',
		'attributes' => $attributes,
	]
);

$cmb->add_field(
	[
		'id'         => $prefix . 'html_sitemap',
		'type'       => 'toggle',
		'name'       => esc_html__( 'Include in HTML Sitemap', 'gohigh-seo' ),
		'desc'       => esc_html__( 'Include this post type in the HTML sitemap if it\'s enabled.', 'gohigh-seo' ),
		'default'    => 'attachment' === $current_post_type ? 'off' : 'on',
		'attributes' => $attributes,
		'classes'    => [
			'rank-math-html-sitemap',
			! Helper::get_settings( 'sitemap.html_sitemap' ) ? 'hidden' : '',
		],
	]
);

if ( 'attachment' !== $current_post_type ) {
	$cmb->add_field(
		[
			'id'      => $prefix . 'image_customfields',
			'type'    => 'textarea_small',
			'name'    => esc_html__( 'Image Custom Fields', 'gohigh-seo' ),
			'desc'    => esc_html__( 'Insert custom field (post meta) names which contain image URLs to include them in the sitemaps. Add one per line.', 'gohigh-seo' ),
			'dep'     => [ [ $prefix . 'sitemap', 'on' ] ],
			'classes' => 'rank-math-advanced-option',
		]
	);
}
