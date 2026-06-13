<?php
/**
 * 404 Monitor general settings.
 *
 * @since      0.9.0
 * @package    RankMath
 * @subpackage RankMath\Monitor
 * @author     Rank Math <support@rankmath.com>
 */

use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$cmb->add_field(
	[
		'id'      => '404_advanced_monitor',
		'type'    => 'notice',
		'what'    => 'error',
		'content' => esc_html__( 'If you have hundreds of 404 errors, your error log might increase quickly. Only choose this option if you have a very few 404s and are unable to replicate the 404 error on a particular URL from your end.', 'gohigh-seo' ),
		'dep'     => [ [ '404_monitor_mode', 'advanced' ] ],
	]
);

$cmb->add_field(
	[
		'id'      => '404_monitor_mode',
		'type'    => 'radio_inline',
		'name'    => esc_html__( 'Mode', 'gohigh-seo' ),
		'desc'    => esc_html__( 'The Simple mode only logs URI and access time, while the Advanced mode creates detailed logs including additional information such as the Referer URL.', 'gohigh-seo' ),
		'options' => [
			'simple'   => esc_html__( 'Simple', 'gohigh-seo' ),
			'advanced' => esc_html__( 'Advanced', 'gohigh-seo' ),
		],
		'default' => 'simple',
	]
);

$cmb->add_field(
	[
		'id'         => '404_monitor_limit',
		'type'       => 'text',
		'name'       => esc_html__( 'Log Limit', 'gohigh-seo' ),
		'desc'       => esc_html__( 'Sets the max number of rows in a log. Set to 0 to disable the limit.', 'gohigh-seo' ),
		'default'    => '100',
		'attributes' => [ 'type' => 'number' ],
	]
);

$monitor_exclude = $cmb->add_field(
	[
		'id'      => '404_monitor_exclude',
		'type'    => 'group',
		'name'    => esc_html__( 'Exclude Paths', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Enter URIs or keywords you wish to prevent from getting logged by the 404 monitor.', 'gohigh-seo' ),
		'options' => [
			'add_button'    => esc_html__( 'Add another', 'gohigh-seo' ),
			'remove_button' => esc_html__( 'Remove', 'gohigh-seo' ),
		],
		'classes' => 'cmb-group-text-only',
	]
);

$cmb->add_group_field(
	$monitor_exclude,
	[
		'id'   => 'exclude',
		'type' => 'text',
	]
);

$cmb->add_group_field(
	$monitor_exclude,
	[
		'id'      => 'comparison',
		'type'    => 'select',
		'options' => Helper::choices_comparison_types(),
	]
);

$cmb->add_field(
	[
		'id'      => '404_monitor_ignore_query_parameters',
		'type'    => 'toggle',
		'name'    => esc_html__( 'Ignore Query Parameters', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Turn ON to ignore all query parameters (the part after a question mark in a URL) when logging 404 errors.', 'gohigh-seo' ),
		'default' => 'off',
	]
);
