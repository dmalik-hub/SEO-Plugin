<?php
/**
 * The htaccess settings.
 *
 * @package    RankMath
 * @subpackage RankMath\Settings
 */

use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\Helper;

defined( 'ABSPATH' ) || exit;

$data = Admin_Helper::get_htaccess_data();

if ( false === $data ) {
	$cmb->add_field(
		[
			'id'      => 'htaccess_not_found',
			'type'    => 'notice',
			'what'    => 'error',
			'content' => esc_html__( '.htaccess file not found.', 'gohigh-seo' ),
		]
	);
	return;
}

$attrs = [
	'value'      => $data['content'],
	'readonly'   => 'readonly',
	'data-gramm' => 'false',
];

if ( ! $data['writable'] || ! Helper::is_edit_allowed() ) {
	$cmb->add_field(
		[
			'id'      => 'htaccess_not_writable',
			'type'    => 'notice',
			'what'    => 'error',
			'content' => esc_html__( '.htaccess file is not writable.', 'gohigh-seo' ),
		]
	);
} else {

	$consent_checkbox = '<br><br><label><input type="checkbox" name="htaccess_accept_changes" id="htaccess_accept_changes" value="1"> <strong>' . esc_html__( 'I understand the risks and I want to edit the file', 'gohigh-seo' ) . '</strong></label>';

	$cmb->add_field(
		[
			'id'      => 'htaccess_accept_changes',
			'type'    => 'notice',
			'what'    => 'error',
			'content' => wp_kses_post( __( 'Be careful when editing the htaccess file, it is easy to make mistakes and break your site. If that happens, you can restore the file to its state <strong>before the last edit</strong> by replacing the htaccess file with the backup copy created by Rank Math in the same directory (<em>.htaccess_back_xxxxxx</em>) using an FTP client.', 'gohigh-seo' ) ) . $consent_checkbox,
			'classes' => 'rank-math-notice',
		]
	);
}
$cmb->add_field(
	[
		'id'         => 'htaccess_content',
		'type'       => 'textarea',
		'classes'    => 'rank-math-code-box',
		'save_field' => false,
		'attributes' => $attrs,
	]
);
