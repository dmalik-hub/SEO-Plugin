<?php
/**
 * Shortcode - Job Posting
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

defined( 'ABSPATH' ) || exit;

$shortcode->get_title();
$shortcode->get_image();
?>
<div class="rank-math-review-data">

	<?php $shortcode->get_description(); ?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Salary', 'gohigh-seo' ),
		'baseSalary.value.value'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Salary Currency', 'gohigh-seo' ),
		'baseSalary.currency'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Payroll', 'gohigh-seo' ),
		'baseSalary.value.unitText'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Date Posted', 'gohigh-seo' ),
		'datePosted'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Posting Expiry Date', 'gohigh-seo' ),
		'validThrough'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Unpublish when expired', 'gohigh-seo' ),
		'unpublish'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Employment Type ', 'gohigh-seo' ),
		'employmentType'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Hiring Organization ', 'gohigh-seo' ),
		'hiringOrganization.name'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Organization URL', 'gohigh-seo' ),
		'hiringOrganization.sameAs'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Organization Logo', 'gohigh-seo' ),
		'hiringOrganization.logo'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Job Type', 'gohigh-seo' ),
		'jobLocationType'
	);
	?>

	<?php
	$locations = $shortcode->get_field_value( 'applicantLocationRequirements' );
	if ( ! empty( $locations ) ) {
		$locations = array_map(
			function ( $location ) {
				return ! empty( $location['name'] ) ? $location['name'] : '';
			},
			$locations
		);

		$shortcode->output_field(
			esc_html__( 'Job Location', 'gohigh-seo' ),
			'<ul><li>' . join( '</li><li>', $locations ) . '</li></ul>'
		);
	}
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Location', 'gohigh-seo' ),
		'jobLocation.address'
	);
	?>

	<?php
	$education = $shortcode->get_field_value( 'educationRequirements' );
	if ( is_array( $education ) && ! empty( $education ) ) {
		$education = array_map(
			function ( $credential ) {
				return ! empty( $credential['credentialCategory'] ) ? ucwords( $credential['credentialCategory'] ) : '';
			},
			$education
		);

		$shortcode->output_field(
			esc_html__( 'Education Required', 'gohigh-seo' ),
			'<ul><li>' . join( '</li><li>', $education ) . '</li></ul>'
		);
	}
	?>

	<?php
	$experience = $shortcode->get_field_value( 'experienceRequirements' );
	if ( is_array( $experience ) && ! empty( $experience['monthsOfExperience'] ) ) {
		$shortcode->output_field(
			esc_html__( 'Experience Required', 'gohigh-seo' ),
			$experience['monthsOfExperience'] . ' ' . esc_html__( 'Months', 'gohigh-seo' )
		);
	}
	?>

</div>
