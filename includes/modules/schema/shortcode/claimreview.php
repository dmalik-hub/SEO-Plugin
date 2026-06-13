<?php
/**
 * Shortcode - course
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

defined( 'ABSPATH' ) || exit;

$shortcode->get_description( $schema['claimReviewed'] );
$shortcode->get_image();

?>
<div class="rank-math-review-data">

	<?php
	$shortcode->get_field(
		esc_html__( 'URL', 'gohigh-seo' ),
		'url'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Author Name', 'gohigh-seo' ),
		'itemReviewed.author.name'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Published Date', 'gohigh-seo' ),
		'itemReviewed.datePublished'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Appearance Headline', 'gohigh-seo' ),
		'itemReviewed.appearance.headline'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Appearance URL', 'gohigh-seo' ),
		'itemReviewed.appearance.url'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Appearance Author', 'gohigh-seo' ),
		'itemReviewed.appearance.author.name'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Appearance Published Date', 'gohigh-seo' ),
		'itemReviewed.appearance.datePublished'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Alternate Name', 'gohigh-seo' ),
		'reviewRating.alternateName'
	);
	?>

	<?php $shortcode->show_ratings( 'reviewRating.ratingValue' ); ?>
</div>
