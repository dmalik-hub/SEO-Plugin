<?php
/**
 * The BuddyPress groups settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Settings
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'              => 'bp_group_title',
		'type'            => 'text',
		'name'            => esc_html__( 'Group Title', 'gohigh-seo' ),
		'desc'            => esc_html__( 'Title tag for groups', 'gohigh-seo' ),
		'classes'         => 'rank-math-supports-variables rank-math-title',
		'default'         => '',
		'sanitization_cb' => [ '\GoHighSEO\CMB2', 'sanitize_textfield' ],
		'attributes'      => [ 'data-exclude-variables' => 'seo_title,seo_description' ],
	]
);

$cmb->add_field(
	[
		'id'         => 'bp_group_description',
		'type'       => 'textarea',
		'name'       => esc_html__( 'Group Description', 'gohigh-seo' ),
		'desc'       => esc_html__( 'BuddyPress group description', 'gohigh-seo' ),
		'classes'    => 'rank-math-supports-variables rank-math-description',
		'attributes' => [
			'data-exclude-variables' => 'seo_title,seo_description',
			'rows'                   => 2,
		],
	]
);

$cmb->add_field(
	[
		'id'      => 'bp_group_custom_robots',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Group Robots Meta', 'gohigh-seo' ),
		'desc'    => __( 'Select custom robots meta for Group archive pages. Otherwise the default meta will be used, as set in the Global Meta tab.', 'gohigh-seo' ),
		'options' => [
			'off' => esc_html__( 'Default', 'gohigh-seo' ),
			'on'  => esc_html__( 'Custom', 'gohigh-seo' ),
		],
		'default' => $custom_default,
		'classes' => 'rank-math-advanced-option',
	]
);

$cmb->add_field(
	[
		'id'                => 'bp_group_robots',
		'type'              => 'multicheck',
		'name'              => esc_html__( 'Group Robots Meta', 'gohigh-seo' ),
		'desc'              => esc_html__( 'Custom values for robots meta tag on groups page.', 'gohigh-seo' ),
		'options'           => Helper::choices_robots(),
		'select_all_button' => false,
		'dep'               => [ [ 'bp_group_custom_robots', 'on' ] ],
		'classes'           => 'rank-math-advanced-option',
	]
);

$cmb->add_field(
	[
		'id'              => 'bp_group_advanced_robots',
		'type'            => 'advanced_robots',
		'name'            => esc_html__( 'Group Advanced Robots Meta', 'gohigh-seo' ),
		'sanitization_cb' => [ '\GoHighSEO\CMB2', 'sanitize_advanced_robots' ],
		'dep'             => [ [ 'bp_group_custom_robots', 'on' ] ],
		'classes'         => 'rank-math-advanced-option',
	]
);
