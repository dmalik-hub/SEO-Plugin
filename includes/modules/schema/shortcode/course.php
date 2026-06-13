<?php
/**
 * Shortcode - Course
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

defined( 'ABSPATH' ) || exit;

$this->get_title();
$this->get_image();
?>
<div class="rank-math-review-data">

	<?php $this->get_description(); ?>

	<?php
	$this->get_field(
		esc_html__( 'Course Provider', 'gohigh-seo' ),
		'provider.@type'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Provider Name', 'gohigh-seo' ),
		'provider.name'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Provider URL', 'gohigh-seo' ),
		'provider.sameAs'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Mode', 'gohigh-seo' ),
		'hasCourseInstance.courseMode'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Workload', 'gohigh-seo' ),
		'hasCourseInstance.courseWorkload',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Start Date', 'gohigh-seo' ),
		'hasCourseInstance.courseSchedule.startDate',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'End Date', 'gohigh-seo' ),
		'hasCourseInstance.courseSchedule.endDate',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Duration', 'gohigh-seo' ),
		'hasCourseInstance.courseSchedule.duration',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Repeat Count', 'gohigh-seo' ),
		'hasCourseInstance.courseSchedule.repeatCount',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Repeat Frequency', 'gohigh-seo' ),
		'hasCourseInstance.courseSchedule.repeatFrequency',
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Type', 'gohigh-seo' ),
		'offers.category'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Currency', 'gohigh-seo' ),
		'offers.priceCurrency'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Course Price', 'gohigh-seo' ),
		'offers.price'
	);
	?>

	<?php $this->show_ratings(); ?>

</div>
