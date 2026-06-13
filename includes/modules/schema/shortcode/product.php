<?php
/**
 * Shortcode - Product
 *
 * @since      2.7.0
 * @package    RankMathPro
 * @subpackage RankMathPro\Schema
 */

defined( 'ABSPATH' ) || exit;

$shortcode->get_title();
$shortcode->get_image();

$offers         = $shortcode->get_field_value( 'offers' );
$positive_notes = $shortcode->get_field_value( 'review.positiveNotes' );
$negative_notes = $shortcode->get_field_value( 'review.negativeNotes' );
?>
<div class="rank-math-review-data">

	<?php $shortcode->get_description(); ?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Product SKU', 'gohigh-seo' ),
		'sku'
	);
	?>

	<?php
	$brand = $shortcode->get_field_value( 'brand' );
	if ( ! empty( $brand['url'] ) && ! empty( $brand['name'] ) ) {
		?>
			<p>
				<strong><?php echo esc_html__( 'Product Brand', 'gohigh-seo' ); ?>: </strong>
				<a href="<?php echo esc_url( $brand['url'] ); ?>"><?php echo esc_html( $brand['name'] ); ?></a>
			</p>
		<?php
	} else {
			$shortcode->get_field(
				esc_html__( 'Product Brand', 'gohigh-seo' ),
				'brand.name'
			);
	}
	?>

	<?php
	if (
		! empty( $offers['price'] ) ||
		(
			empty( $positive_notes ) &&
			empty( $negative_notes )
		)
	) {
		?>

		<?php
		$shortcode->get_field(
			esc_html__( 'Product Currency', 'gohigh-seo' ),
			'offers.priceCurrency'
		);
		?>

		<?php
		$shortcode->get_field(
			esc_html__( 'Product Price', 'gohigh-seo' ),
			'offers.price'
		);
		?>

		<?php
		$shortcode->get_field(
			esc_html__( 'Price Valid Until', 'gohigh-seo' ),
			'offers.priceValidUntil'
		);
		?>

		<?php
		$shortcode->get_field(
			esc_html__( 'Product In-Stock', 'gohigh-seo' ),
			'offers.availability'
		);
		?>

	<?php } ?>

	<?php $shortcode->show_ratings(); ?>

</div>
