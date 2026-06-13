<?php
/**
 * Blocks general settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'      => 'toc_block_title',
		'type'    => 'text',
		'name'    => esc_html__( 'Table of Contents Title', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Enter the default title to use for the Table of Contents block.', 'gohigh-seo' ),
		'classes' => 'rank-math-advanced-option',
		'default' => esc_html__( 'Table of Contents', 'gohigh-seo' ),
	]
);

$cmb->add_field(
	[
		'id'      => 'toc_block_list_style',
		'type'    => 'select',
		'name'    => esc_html__( 'Table of Contents List style', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Select the default list style for the Table of Contents block.', 'gohigh-seo' ),
		'options' => [
			'div' => esc_html__( 'None', 'gohigh-seo' ),
			'ol'  => esc_html__( 'Numbered', 'gohigh-seo' ),
			'ul'  => esc_html__( 'Unordered', 'gohigh-seo' ),
		],
		'default' => 'ul',
	]
);

$cmb->add_field(
	[
		'id'      => 'toc_block_exclude_headings',
		'name'    => esc_html__( 'Table of Contents Exclude Headings', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Choose the headings to exclude from the Table of Contents block.', 'gohigh-seo' ),
		'type'    => 'multicheck',
		'options' => [
			'h1' => esc_html__( 'Heading H1', 'gohigh-seo' ),
			'h2' => esc_html__( 'Heading H2', 'gohigh-seo' ),
			'h3' => esc_html__( 'Heading H3', 'gohigh-seo' ),
			'h4' => esc_html__( 'Heading H4', 'gohigh-seo' ),
			'h5' => esc_html__( 'Heading H5', 'gohigh-seo' ),
			'h6' => esc_html__( 'Heading H6', 'gohigh-seo' ),
		],
	]
);
