<?php
/**
 * Shortcode - Event
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

defined( 'ABSPATH' ) || exit;

$this->get_title();
$this->get_image();

$value      = $this->get_field_value( 'eventAttendanceMode' );
$is_online  = 'Online' === $value;
$is_offline = 'Offline' === $value;

if ( 'MixedEventAttendanceMode' === $value ) {
	$is_online  = true;
	$is_offline = true;
	$value      = esc_html__( 'Online + Offline', 'gohigh-seo' );
}
?>
<div class="rank-math-review-data">

	<?php $this->get_description(); ?>

	<?php
	$this->get_field(
		esc_html__( 'Event Type', 'gohigh-seo' ),
		'@type'
	);
	?>

	<?php
	$this->output_field(
		esc_html__( 'Event Attendance Mode', 'gohigh-seo' ),
		$value
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Event Status', 'gohigh-seo' ),
		'eventStatus'
	);
	?>

	<?php
	if ( $is_offline ) {
		$this->get_field(
			esc_html__( 'Venue Name', 'gohigh-seo' ),
			'location.name'
		);

		$this->get_field(
			esc_html__( 'Venue URL', 'gohigh-seo' ),
			'location.url'
		);

		$this->get_field(
			esc_html__( 'Address', 'gohigh-seo' ),
			'location.address'
		);
	}
	?>

	<?php
	if ( $is_online ) {
		$this->get_field(
			esc_html__( 'Online Event URL', 'gohigh-seo' ),
			'VirtualLocation.url'
		);
	}
	?>

	<?php
	$this->get_field(
		esc_html__( 'Performer', 'gohigh-seo' ),
		'performer.@type'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Performer Name', 'gohigh-seo' ),
		'performer.name'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Performer URL', 'gohigh-seo' ),
		'performer.sameAs'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Start Date', 'gohigh-seo' ),
		'startDate',
		true
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'End Date', 'gohigh-seo' ),
		'endDate',
		true
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Ticket URL', 'gohigh-seo' ),
		'offers.url'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Entry Price', 'gohigh-seo' ),
		'offers.price'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Currency', 'gohigh-seo' ),
		'offers.priceCurrency'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Availability', 'gohigh-seo' ),
		'offers.availability'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Availability Starts', 'gohigh-seo' ),
		'startDate'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Stock Inventory', 'gohigh-seo' ),
		'offers.inventoryLevel'
	);
	?>

	<?php $this->show_ratings(); ?>

</div>
