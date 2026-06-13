<?php
/**
 * The breadcrumb settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Settings
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$args = [
	'id'      => 'breadcrumbs',
	'type'    => 'toggle',
	'name'    => esc_html__( 'Enable breadcrumbs function', 'gohigh-seo' ),
	'desc'    => esc_html__( 'Turning off breadcrumbs will hide breadcrumbs inserted in template files too.', 'gohigh-seo' ),
	'default' => 'on',
];

if ( current_theme_supports( 'rank-math-breadcrumbs' ) ) {
	$args['force_enable'] = true;
	$args['disabled']     = true;
	$args['desc']         = sprintf(
		// Translators: Code to add support for Rank Math Breadcrumbs.
		esc_html__( 'This option cannot be changed since your theme has added the support for Rank Math Breadcrumbs using: %s', 'gohigh-seo' ),
		"<br /><code>add_theme_support( 'rank-math-breadcrumbs' );</code>"
	);
}
$cmb->add_field( $args );

$dependency = [ [ 'breadcrumbs', 'on' ] ];
$cmb->add_field(
	[
		'id'              => 'breadcrumbs_separator',
		'type'            => 'radio_inline',
		'name'            => esc_html__( 'Separator Character', 'gohigh-seo' ),
		'desc'            => esc_html__( 'Separator character or string that appears between breadcrumb items.', 'gohigh-seo' ),
		'options'         => Helper::choices_separator( Helper::get_settings( 'general.breadcrumbs_separator' ) ),
		'default'         => '-',
		'dep'             => $dependency,
		'sanitization_cb' => [ '\GoHighSEO\CMB2', 'sanitize_htmlentities' ],
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_home',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Show Homepage Link', 'gohigh-seo' ),
		'desc'    => wp_kses_post( __( 'Display homepage breadcrumb in trail.', 'gohigh-seo' ) ),
		'default' => 'on',
		'dep'     => $dependency,
	]
);

$dependency_home   = [ 'relation' => 'and' ] + $dependency;
$dependency_home[] = [ 'breadcrumbs_home', 'on' ];
$cmb->add_field(
	[
		'id'      => 'breadcrumbs_home_label',
		'type'    => 'text',
		'name'    => esc_html__( 'Homepage label', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Label used for homepage link (first item) in breadcrumbs.', 'gohigh-seo' ),
		'default' => esc_html__( 'Home', 'gohigh-seo' ),
		'dep'     => $dependency_home,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_home_link',
		'type'    => 'text',
		'name'    => esc_html__( 'Homepage Link', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Link to use for homepage (first item) in breadcrumbs.', 'gohigh-seo' ),
		'default' => get_home_url(),
		'dep'     => $dependency_home,
	]
);

$cmb->add_field(
	[
		'id'   => 'breadcrumbs_prefix',
		'type' => 'text',
		'name' => esc_html__( 'Prefix Breadcrumb', 'gohigh-seo' ),
		'desc' => esc_html__( 'Prefix for the breadcrumb path.', 'gohigh-seo' ),
		'dep'  => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_archive_format',
		'type'    => 'text',
		'name'    => esc_html__( 'Archive Format', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Format the label used for archive pages.', 'gohigh-seo' ),
		/* translators: placeholder */
		'default' => esc_html__( 'Archives for %s', 'gohigh-seo' ),
		'dep'     => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_search_format',
		'type'    => 'text',
		'name'    => esc_html__( 'Search Results Format', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Format the label used for search results pages.', 'gohigh-seo' ),
		/* translators: placeholder */
		'default' => esc_html__( 'Results for %s', 'gohigh-seo' ),
		'dep'     => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_404_label',
		'type'    => 'text',
		'name'    => esc_html__( '404 label', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Label used for 404 error item in breadcrumbs.', 'gohigh-seo' ),
		'default' => esc_html__( '404 Error: page not found', 'gohigh-seo' ),
		'dep'     => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_remove_post_title',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Hide Post Title', 'gohigh-seo' ),
		'desc'    => wp_kses_post( __( 'Hide Post title from Breadcrumb.', 'gohigh-seo' ) ),
		'default' => 'off',
		'dep'     => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_ancestor_categories',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Show Category(s)', 'gohigh-seo' ),
		'desc'    => esc_html__( 'If category is a child category, show all ancestor categories.', 'gohigh-seo' ),
		'default' => 'off',
		'dep'     => $dependency,
	]
);

$cmb->add_field(
	[
		'id'      => 'breadcrumbs_hide_taxonomy_name',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Hide Taxonomy Name', 'gohigh-seo' ),
		'desc'    => wp_kses_post( __( 'Hide Taxonomy Name from Breadcrumb.', 'gohigh-seo' ) ),
		'default' => 'off',
		'dep'     => $dependency,
	]
);

if ( 'page' === get_option( 'show_on_front' ) && 0 < get_option( 'page_for_posts' ) ) {
	$cmb->add_field(
		[
			'id'      => 'breadcrumbs_blog_page',
			'type'    => 'toggle',
			'name'    => esc_html__( 'Show Blog Page', 'gohigh-seo' ),
			'desc'    => esc_html__( 'Show Blog Page in Breadcrumb.', 'gohigh-seo' ),
			'default' => 'off',
			'dep'     => $dependency,
		]
	);
}
