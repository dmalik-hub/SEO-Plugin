<?php
/**
 * IndexNow Options: History tab.
 *
 * @since   1.0.56
 * @package Rank_Math
 */

defined( 'ABSPATH' ) || exit;

$history_content  = '';
$history_content .= '<a href="#" id="indexnow_clear_history" class="button alignright hidden">' . esc_html__( 'Clear History', 'gohigh-seo' ) . '</a>';
$history_content .= '<div class="history-filter-links hidden" id="indexnow_history_filters"><a href="#" data-filter="all" class="current">' . esc_html__( 'All', 'gohigh-seo' ) . '</a> | <a href="#" data-filter="manual">' . esc_html__( 'Manual', 'gohigh-seo' ) . '</a> | <a href="#" data-filter="auto">' . esc_html__( 'Auto', 'gohigh-seo' ) . '</a></div>';
$history_content .= '<div class="clear"></div>';
$history_content .= '<table class="wp-list-table widefat striped" id="indexnow_history"><thead><tr><th class="col-date">' . esc_html__( 'Time', 'gohigh-seo' ) . '</th><th class="col-url">' . esc_html__( 'URL', 'gohigh-seo' ) . '</th><th class="col-status">' . esc_html__( 'Response', 'gohigh-seo' ) . '</th></tr></thead><tbody>';
$history_content .= '</tbody></table>';

$cmb->add_field(
	[
		'id'      => 'indexnow_history',
		'type'    => 'raw',
		/* translators: daily quota */
		'content' => $history_content,
	]
);

$help_contents = '';

$help_contents .= '<a href="#" id="indexnow_show_response_codes">' . esc_html__( 'Response Code Help', 'gohigh-seo' ) . '<span class="dashicons dashicons-arrow-down"></span></a>';

$help_contents .= '<table class="wp-list-table widefat striped hidden" id="indexnow_response_codes"><thead><tr><th class="col-response-code">' . esc_html__( 'Response Code', 'gohigh-seo' ) . '</th><th class="col-response-message">' . esc_html__( 'Response Message', 'gohigh-seo' ) . '</th><th class="col-reasons">' . esc_html__( 'Reasons', 'gohigh-seo' ) . '</th></tr></thead><tbody>';
$help_contents .= '<tr><td class="col-response-code">200</td><td class="col-response-message">' . esc_html__( 'OK', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'The URL was successfully submitted to the IndexNow API.', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '<tr><td class="col-response-code">202</td><td class="col-response-message">' . esc_html__( 'Accepted', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'The URL was successfully submitted to the IndexNow API, but the API key will be checked later.', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '<tr><td class="col-response-code">400</td><td class="col-response-message">' . esc_html__( 'Bad Request', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'The request was invalid.', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '<tr><td class="col-response-code">403</td><td class="col-response-message">' . esc_html__( 'Forbidden', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'The key was invalid (e.g. key not found, file found but key not in the file).', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '<tr><td class="col-response-code">422</td><td class="col-response-message">' . esc_html__( 'Unprocessable Entity', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'The URLs don\'t belong to the host or the key is not matching the schema in the protocol.', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '<tr><td class="col-response-code">429</td><td class="col-response-message">' . esc_html__( 'Too Many Requests', 'gohigh-seo' ) . '</td><td class="col-reasons">' . esc_html__( 'Too Many Requests (potential Spam).', 'gohigh-seo' ) . '</td></tr>';
$help_contents .= '</tbody></table>';

$cmb->add_field(
	[
		'id'      => 'indexnow_help',
		'type'    => 'raw',
		/* translators: daily quota */
		'content' => $help_contents,
	]
);
