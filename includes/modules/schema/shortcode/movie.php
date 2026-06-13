<?php
/**
 * Shortcode - Movie
 *
 * @package    RankMath
 * @subpackage RankMath\Schema
 */

defined( 'ABSPATH' ) || exit;

$shortcode->get_title();
$shortcode->get_image();

?>
<div class="rank-math-review-data">

	<?php
	$shortcode->get_field(
		esc_html__( 'Director', 'gohigh-seo' ),
		'director'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Date Created', 'gohigh-seo' ),
		'dateCreated',
		true
	);
	?>

	<?php $shortcode->show_ratings(); ?>
</div>
