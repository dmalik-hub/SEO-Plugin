<?php
/**
 * Sitemap settings - Authors tab.
 *
 * @package    RankMath
 * @subpackage RankMath\Sitemap
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$roles   = Helper::get_roles();
$default = $roles;
unset( $default['administrator'], $default['editor'], $default['author'] );

$dep = [
	'relation' => 'OR',
	[ 'authors_sitemap', 'on' ],
	[ 'authors_html_sitemap', 'on' ],
];

$cmb->add_field(
	[
		'id'      => 'authors_sitemap',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include in Sitemap', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Include author archives in the XML sitemap.', 'gohigh-seo' ),
		'default' => 'on',
	]
);

$cmb->add_field(
	[
		'id'      => 'authors_html_sitemap',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include in HTML Sitemap', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Include author archives in the HTML sitemap if it\'s enabled.', 'gohigh-seo' ),
		'default' => 'on',
		'classes' => [
			'rank-math-html-sitemap',
			! Helper::get_settings( 'sitemap.html_sitemap' ) ? 'hidden' : '',
		],
	]
);

$cmb->add_field(
	[
		'id'      => 'include_authors_without_posts',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include Authors Without Posts', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Enable this option to include authors in the sitemap even if they have not created any posts. This ensures all author archives are listed, regardless of content availability.', 'gohigh-seo' ),
		'default' => 'off',
		'classes' => 'rank-math-advanced-option cmb2-top-border',
		'dep'     => $dep,
	]
);

$cmb->add_field(
	[
		'id'                => 'exclude_roles',
		'type'              => 'multicheck',
		'name'              => esc_html__( 'Exclude User Roles', 'gohigh-seo' ),
		'desc'              => esc_html__( 'Selected roles will be excluded from the XML &amp; HTML sitemaps.', 'gohigh-seo' ),
		'options'           => $roles,
		'default'           => $default,
		'select_all_button' => false,
		'dep'               => $dep,
	]
);

$cmb->add_field(
	[
		'id'   => 'exclude_users',
		'type' => 'text',
		'name' => esc_html__( 'Exclude Users', 'gohigh-seo' ),
		'desc' => esc_html__( 'Add user IDs, separated by commas, to exclude them from the sitemap.', 'gohigh-seo' ),
		'dep'  => $dep,
	]
);
