<?php
/**
 * Sitemap settings - taxonomy tabs.
 *
 * @package    RankMath
 * @subpackage RankMath\Sitemap
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$taxonomy_name = $tab['taxonomy'];
$prefix        = "tax_{$taxonomy_name}_";
$is_enabled    = 'category' === $taxonomy_name ? 'on' : 'off';

$cmb->add_field(
	[
		'id'      => $prefix . 'sitemap',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include in Sitemap', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Include archive pages for terms of this taxonomy in the XML sitemap.', 'gohigh-seo' ),
		'default' => $is_enabled,
	]
);

$cmb->add_field(
	[
		'id'      => $prefix . 'html_sitemap',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include in HTML Sitemap', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Include archive pages for terms of this taxonomy in the HTML sitemap.', 'gohigh-seo' ),
		'default' => $is_enabled,
		'classes' => [
			'rank-math-html-sitemap',
			! Helper::get_settings( 'sitemap.html_sitemap' ) ? 'hidden' : '',
		],
	]
);

$cmb->add_field(
	[
		'id'      => $prefix . 'include_empty',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Include Empty Terms', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Include archive pages of terms that have no posts associated.', 'gohigh-seo' ),
		'default' => 'off',
		'dep'     => [ [ $prefix . 'sitemap', 'on' ] ],
		'classes' => 'rank-math-advanced-option',
	]
);
