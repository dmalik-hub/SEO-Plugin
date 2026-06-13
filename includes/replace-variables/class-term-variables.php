<?php
/**
 * Term variable replacer.
 *
 * @since      1.0.33
 * @package    RankMath
 * @subpackage RankMath\Replace_Variables
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Replace_Variables;

use GoHighSEO\Helpers\Str;
use GoHighSEO\Helpers\Param;

defined( 'ABSPATH' ) || exit;

/**
 * Term_Variables class.
 */
class Term_Variables extends Basic_Variables {

	/**
	 * Setup term variables.
	 */
	public function setup_term_variables() {
		if ( $this->is_term_edit ) {
			$tag_id     = Param::request( 'tag_ID', 0, FILTER_VALIDATE_INT );
			$term       = get_term( $tag_id, $GLOBALS['taxnow'], OBJECT );
			$this->args = $term;
		}

		$this->register_replacement(
			'term',
			[
				'name'        => esc_html__( 'Current Term', 'gohigh-seo' ),
				'description' => esc_html__( 'Current term name', 'gohigh-seo' ),
				'variable'    => 'term',
				'example'     => $this->is_term_edit ? $term->name : esc_html__( 'Example Term', 'gohigh-seo' ),
				'nocache'     => true,
			],
			[ $this, 'get_term' ]
		);

		$this->register_replacement(
			'term_description',
			[
				'name'        => esc_html__( 'Term Description', 'gohigh-seo' ),
				'description' => esc_html__( 'Current term description', 'gohigh-seo' ),
				'variable'    => 'term_description',
				'example'     => $this->is_term_edit ? wp_strip_all_tags( term_description( $term ), true ) : esc_html__( 'Example Term Description', 'gohigh-seo' ),
			],
			[ $this, 'get_term_description' ]
		);

		$this->register_replacement(
			'customterm',
			[
				'name'        => esc_html__( 'Custom Term (advanced)', 'gohigh-seo' ),
				'description' => esc_html__( 'Custom term value.', 'gohigh-seo' ),
				'variable'    => 'customterm(taxonomy-name)',
				'example'     => esc_html__( 'Custom term value', 'gohigh-seo' ),
			],
			[ $this, 'get_custom_term' ]
		);

		$this->register_replacement(
			'customterm_desc',
			[
				'name'        => esc_html__( 'Custom Term description', 'gohigh-seo' ),
				'description' => esc_html__( 'Custom Term description.', 'gohigh-seo' ),
				'variable'    => 'customterm_desc(taxonomy-name)',
				'example'     => esc_html__( 'Custom Term description.', 'gohigh-seo' ),
			],
			[ $this, 'get_custom_term_desc' ]
		);
	}

	/**
	 * Get the term name to use as a replacement.
	 *
	 * @return string|null
	 */
	public function get_term() {
		global $wp_query;

		if ( is_category() || is_tag() || is_tax() ) {
			return $wp_query->queried_object->name;
		}

		return ! empty( $this->args->taxonomy ) && ! empty( $this->args->name ) ? $this->args->name : null;
	}

	/**
	 * Get the term description to use as a replacement.
	 *
	 * @return string|null
	 */
	public function get_term_description() {
		global $wp_query;

		if ( is_category() || is_tag() || is_tax() ) {
			return $wp_query->queried_object->description;
		}

		if ( ! isset( $this->args->term_id ) || empty( $this->args->taxonomy ) ) {
			return null;
		}

		$term_desc = get_term_field( 'description', $this->args->term_id, $this->args->taxonomy );
		return '' !== $term_desc ? Str::truncate( $term_desc, 160 ) : null;
	}

	/**
	 * Get a custom taxonomy term to use as a replacement.
	 *
	 * @param string $taxonomy The name of the taxonomy.
	 *
	 * @return string|null
	 */
	public function get_custom_term( $taxonomy ) {
		return Str::is_non_empty( $taxonomy ) ? $this->get_terms( $this->args->ID, $taxonomy, true, [], 'name' ) : null;
	}

	/**
	 * Get a custom taxonomy term description to use as a replacement.
	 *
	 * @param string $taxonomy The name of the taxonomy.
	 *
	 * @return string|null
	 */
	public function get_custom_term_desc( $taxonomy ) {
		return Str::is_non_empty( $taxonomy ) ? $this->get_terms( $this->args->ID, $taxonomy, true, [], 'description' ) : null;
	}
}
