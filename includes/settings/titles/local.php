<?php
/**
 * The local SEO settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Local_Seo
 */

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'      => 'knowledgegraph_type',
		'type'    => 'radio_inline',
		'name'    => esc_html__( 'Person or Company', 'gohigh-seo' ),
		'options' => [
			'person'  => esc_html__( 'Person', 'gohigh-seo' ),
			'company' => esc_html__( 'Organization', 'gohigh-seo' ),
		],
		'desc'    => esc_html__( 'Choose whether the site represents a person or an organization.', 'gohigh-seo' ),
		'default' => 'person',
	]
);

$cmb->add_field(
	[
		'id'      => 'website_name',
		'type'    => 'text',
		'name'    => esc_html__( 'Website Name', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Enter the name of your site to appear in search results.', 'gohigh-seo' ),
		'default' => get_bloginfo( 'name' ),
	]
);

$cmb->add_field(
	[
		'id'   => 'website_alternate_name',
		'type' => 'text',
		'name' => esc_html__( 'Website Alternate Name', 'gohigh-seo' ),
		'desc' => esc_html__( 'An alternate version of your site name (for example, an acronym or shorter name).', 'gohigh-seo' ),
	]
);

$cmb->add_field(
	[
		'id'      => 'knowledgegraph_name',
		'type'    => 'text',
		'name'    => esc_html__( 'Person/Organization Name', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Your name or company name intended to feature in Google\'s Knowledge Panel.', 'gohigh-seo' ),
		'default' => get_bloginfo( 'name' ),
	]
);

$cmb->add_field(
	[
		'id'      => 'knowledgegraph_logo',
		'type'    => 'file',
		'name'    => esc_html__( 'Logo', 'gohigh-seo' ),
		'desc'    => __( '<strong>Min Size: 112Χ112px</strong>.<br /> A squared image is preferred by the search engines.', 'gohigh-seo' ),
		'options' => [ 'url' => false ],
	]
);

$cmb->add_field(
	[
		'id'      => 'url',
		'type'    => 'text',
		'name'    => esc_html__( 'URL', 'gohigh-seo' ),
		'desc'    => esc_html__( 'URL of the item.', 'gohigh-seo' ),
		'default' => home_url(),
	]
);
