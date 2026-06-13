<?php
/**
 * Shortcode - Person
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
		esc_html__( 'Email', 'gohigh-seo' ),
		'email'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Address', 'gohigh-seo' ),
		'address'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Gender', 'gohigh-seo' ),
		'gender'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Job Title', 'gohigh-seo' ),
		'jobTitle'
	);
	?>

</div>
