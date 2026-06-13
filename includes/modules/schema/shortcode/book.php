<?php
/**
 * Shortcode - Book
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
		esc_html__( 'URL', 'gohigh-seo' ),
		'url'
	);
	?>

	<?php
	$this->get_field(
		esc_html__( 'Author', 'gohigh-seo' ),
		'author.name'
	);
	?>

	<?php
	if ( ! empty( $schema['hasPart'] ) ) {
		$hash = [
			'edition'       => __( 'Edition', 'gohigh-seo' ),
			'name'          => __( 'Name', 'gohigh-seo' ),
			'url'           => __( 'Url', 'gohigh-seo' ),
			'author'        => __( 'Author', 'gohigh-seo' ),
			'isbn'          => __( 'ISBN', 'gohigh-seo' ),
			'datePublished' => __( 'Date Published', 'gohigh-seo' ),
			'bookFormat'    => __( 'Format', 'gohigh-seo' ),
		];
		foreach ( $schema['hasPart'] as $edition ) {
			$this->schema = $edition;
			foreach ( $hash as $key => $label ) {
				$this->get_field( $label, $key );
			}
		}
		$this->schema = $schema;
	}
	?>

	<?php $this->show_ratings(); ?>

</div>
