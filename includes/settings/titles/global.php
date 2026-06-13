<?php
/**
 * The general settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Settings
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'                => 'robots_global',
		'type'              => 'multicheck',
		'name'              => esc_html__( 'Robots Meta', 'gohigh-seo' ),
		'desc'              => esc_html__( 'Default values for robots meta tag. These can be changed for individual posts, taxonomies, etc.', 'gohigh-seo' ),
		'options'           => Helper::choices_robots(),
		'default'           => [ 'index' ],
		'classes'           => 'rank-math-robots-data',
		'select_all_button' => false,
	]
);

$cmb->add_field(
	[
		'id'              => 'advanced_robots_global',
		'type'            => 'advanced_robots',
		'name'            => esc_html__( 'Advanced Robots Meta', 'gohigh-seo' ),
		'sanitization_cb' => [ '\GoHighSEO\CMB2', 'sanitize_advanced_robots' ],
		'classes'         => 'rank-math-advanced-option',
	]
);

$cmb->add_field(
	[
		'id'      => 'noindex_empty_taxonomies',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Noindex Empty Category and Tag Archives', 'gohigh-seo' ),
		'desc'    => wp_kses_post( __( 'Setting empty archives to <code>noindex</code> is useful for avoiding indexation of thin content pages and dilution of page rank. As soon as a post is added, the page is updated to <code>index</code>.', 'gohigh-seo' ) ),
		'default' => 'on',
		'classes' => 'rank-math-advanced-option',
	]
);

$cmb->add_field(
	[
		'id'              => 'title_separator',
		'type'            => 'radio_inline',
		'name'            => esc_html__( 'Separator Character', 'gohigh-seo' ),
		'desc'            => wp_kses_post( __( 'You can use the separator character in titles by inserting <code>%separator%</code> or <code>%sep%</code> in the title fields.', 'gohigh-seo' ) ), // phpcs:ignore
		'options'         => Helper::choices_separator( Helper::get_settings( 'titles.title_separator' ) ),
		'default'         => '-',
		'attributes'      => [ 'data-preview' => 'title' ],
		'sanitization_cb' => [ '\GoHighSEO\CMB2', 'sanitize_separator' ],
	]
);

if ( ! current_theme_supports( 'title-tag' ) ) {
	$cmb->add_field(
		[
			'id'      => 'rewrite_title',
			'type'    => 'toggle',
			'name'    => esc_html__( 'Rewrite Titles', 'gohigh-seo' ),
			'desc'    => esc_html__( 'Your current theme doesn\'t support title-tag. Enable this option to rewrite page, post, category, search and archive page titles.', 'gohigh-seo' ),
			'default' => 'off',
		]
	);
}

$cmb->add_field(
	[
		'id'      => 'capitalize_titles',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Capitalize Titles', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Automatically capitalize the first character of each word in the titles.', 'gohigh-seo' ),
		'default' => 'off',
	]
);

$cmb->add_field(
	[
		'id'      => 'open_graph_image',
		'type'    => 'file',
		'name'    => esc_html__( 'OpenGraph Thumbnail', 'gohigh-seo' ),
		'desc'    => esc_html__( 'When a featured image or an OpenGraph Image is not set for individual posts/pages/CPTs, this image will be used as a fallback thumbnail when your post is shared on Facebook. The recommended image size is 1200 x 630 pixels.', 'gohigh-seo' ),
		'options' => [ 'url' => false ],
		'class'   => 'button-primary',
	]
);

$cmb->add_field(
	[
		'id'      => 'twitter_card_type',
		'type'    => 'select',
		'name'    => esc_html__( 'Twitter Card Type', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Card type selected when creating a new post. This will also be applied for posts without a card type selected.', 'gohigh-seo' ),
		'options' => [
			'summary_large_image' => esc_html__( 'Summary Card with Large Image', 'gohigh-seo' ),
			'summary_card'        => esc_html__( 'Summary Card', 'gohigh-seo' ),
		],
		'default' => 'summary_large_image',
		'classes' => 'rank-math-advanced-option',
	]
);
