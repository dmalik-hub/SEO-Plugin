<?php
/**
 * Shortcode - Recipe
 *
 * @package    RankMathPro
 * @subpackage RankMathPro\Schema
 */

defined( 'ABSPATH' ) || exit;

$shortcode->get_title();
$shortcode->get_image();
?>
<div class="rank-math-review-data">

	<?php $shortcode->get_description(); ?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Type', 'gohigh-seo' ),
		'recipeCategory'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Cuisine', 'gohigh-seo' ),
		'recipeCuisine'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Keywords', 'gohigh-seo' ),
		'keywords'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Recipe Yield', 'gohigh-seo' ),
		'recipeYield'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Calories', 'gohigh-seo' ),
		'nutrition.calories'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Preparation Time', 'gohigh-seo' ),
		'prepTime'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Cooking Time', 'gohigh-seo' ),
		'cookTime'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Total Time', 'gohigh-seo' ),
		'totalTime'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Recipe Video Name', 'gohigh-seo' ),
		'video.name'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Recipe Video Description', 'gohigh-seo' ),
		'video.description'
	);
	?>

	<?php
	$shortcode->get_field(
		esc_html__( 'Recipe Video Thumbnail', 'gohigh-seo' ),
		'video.thumbnailUrl'
	);
	?>

	<?php
	$videoembed = $shortcode->get_field_value( 'video' );
	if ( ! empty( $videoembed ) ) {
		global $wp_embed;
		if ( ! empty( $videoembed['embedUrl'] ) ) {
			echo do_shortcode( $wp_embed->autoembed( $videoembed['embedUrl'] ) );
		} elseif ( ! empty( $videoembed['contentUrl'] ) ) {
			echo do_shortcode( $wp_embed->autoembed( $videoembed['contentUrl'] ) );
		}
	}
	?>

	<?php
	$ingredient = $shortcode->get_field_value( 'recipeIngredient' );
	$shortcode->output_field(
		esc_html__( 'Recipe Ingredients', 'gohigh-seo' ),
		'<ul><li>' . join( '</li><li>', $ingredient ) . '</li></ul>'
	);
	?>

	<?php
	$instructions = $shortcode->get_field_value( 'recipeInstructions' );
	if ( is_string( $instructions ) ) {
		$shortcode->get_field(
			esc_html__( 'Recipe Instructions', 'gohigh-seo' ),
			'recipeInstructions'
		);
	} else {
		// HowTo Array.
		if ( isset( $instructions[0]['@type'] ) && 'HowtoStep' === $instructions[0]['@type'] ) {
			$instructions = wp_list_pluck( $instructions, 'text' );
			$shortcode->output_field(
				esc_html__( 'Recipe Instructions', 'gohigh-seo' ),
				'<ul><li>' . join( '</li><li>', $instructions ) . '</li></ul>'
			);
		}

		// Single HowToSection data.
		if ( ! empty( $instructions['itemListElement'] ) ) {
			$shortcode->output_field(
				esc_html__( 'Recipe Instructions', 'gohigh-seo' ),
				''
			);

			$shortcode->output_field(
				$instructions['name'],
				'<ul><li>' . join( '</li><li>', wp_list_pluck( $instructions['itemListElement'], 'text' ) ) . '</li></ul>'
			);
		}

		// Multiple HowToSection data.
		if ( isset( $instructions[0]['@type'] ) && 'HowToSection' === $instructions[0]['@type'] ) {
			$shortcode->output_field(
				esc_html__( 'Recipe Instructions', 'gohigh-seo' ),
				''
			);

			foreach ( $instructions as $section ) {
				if ( empty( $section['itemListElement'] ) ) {
					continue;
				}

				$data = '';
				foreach ( $section['itemListElement'] as $item ) {
					$url   = ! empty( $item['url'] ) ? $item['url'] : '';
					$name  = ! empty( $item['name'] ) ? $item['name'] : '';
					$image = ! empty( $item['image'] ) ? $item['image']['url'] : '';
					$text  = ! empty( $item['text'] ) ? $item['text'] : '';

					$data .= '<div class="inner-wrapper">';
					$data .= '<div class="content-wrapper">';
					$data .= '<h5><a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $name ) . '</a></h5>';
					$data .= '<p>' . esc_html( $text ) . '</p>';
					$data .= '</div>';
					$data .= '<img src="' . esc_url( $image ) . '" />';
					$data .= '</div>';
				}

				echo '<div class="recipe-instructions-data">';
					$shortcode->output_field(
						$section['name'],
						$data
					);
				echo '</div>';
			}
		}
	}
	?>

	<?php $shortcode->show_ratings(); ?>

</div>
