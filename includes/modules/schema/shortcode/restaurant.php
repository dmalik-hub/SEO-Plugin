<?php
/**
 * Shortcode - Restaurant
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
		esc_html__( 'Address', 'gohigh-seo' ),
		'address'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Geo Coordinates', 'gohigh-seo' ),
		'geo'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Phone Number', 'gohigh-seo' ),
		'telephone'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Price Range', 'gohigh-seo' ),
		'priceRange'
	);
	?>

	<?php $this->get_opening_hours( 'openingHoursSpecification' ); ?>

	<?php
	$this->get_field(
		esc_html__( 'Serves Cuisine', 'gohigh-seo' ),
		'servesCuisine'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Menu URL', 'gohigh-seo' ),
		'hasMenu'
	);
	?>

</div>
