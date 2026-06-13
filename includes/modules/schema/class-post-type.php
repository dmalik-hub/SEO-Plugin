<?php
/**
 * The Schema Template Post Type
 *
 * @since      1.0.0
 * @package    RankMath
 * @subpackage RankMathPro
 * @author     RankMath <support@rankmath.com>
 */

namespace GoHighSEO\Schema;

use GoHighSEO\Helper;
use GoHighSEO\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Post_Type class.
 */
class Post_Type {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'init', 'register' );
		$this->action( 'admin_menu', 'add_menu', 11 );
		$this->action( 'parent_file', 'parent_file' );
		$this->action( 'submenu_file', 'submenu_file' );
		$this->action( 'save_post_rank_math_schema', 'save_post', 10, 2 );
	}

	/**
	 * Update the title metadata when the schema template is saved.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function save_post( $post_id, $post ) {
		$schema_meta = current( \GoHighSEO\Schema\DB::get_schemas( $post_id ) );
		if ( empty( $schema_meta['@type'] ) ) {
			return;
		}

		$schema_meta['metadata']['title'] = $post->post_title;
		update_post_meta( $post_id, "rank_math_schema_{$schema_meta['@type']}", $schema_meta );
	}

	/**
	 * Register template post type.
	 */
	public function register() {
		$labels = [
			'name'               => _x( 'Schemas', 'Post Type General Name', 'gohigh-seo' ),
			'singular_name'      => _x( 'Schema', 'Post Type Singular Name', 'gohigh-seo' ),
			'menu_name'          => __( 'Schemas', 'gohigh-seo' ),
			'name_admin_bar'     => __( 'Schema', 'gohigh-seo' ),
			'all_items'          => __( 'All Schemas', 'gohigh-seo' ),
			'add_new'            => __( 'Add New Schema', 'gohigh-seo' ),
			'add_new_item'       => __( 'Add New Schema', 'gohigh-seo' ),
			'new_item'           => __( 'New Schema', 'gohigh-seo' ),
			'edit_item'          => __( 'Edit Schema', 'gohigh-seo' ),
			'update_item'        => __( 'Update Schema', 'gohigh-seo' ),
			'view_item'          => __( 'View Schema', 'gohigh-seo' ),
			'view_items'         => __( 'View Schemas', 'gohigh-seo' ),
			'search_items'       => __( 'Search schemas', 'gohigh-seo' ),
			'not_found'          => __( 'No schema found.', 'gohigh-seo' ),
			'not_found_in_trash' => __( 'No schema found in Trash.', 'gohigh-seo' ),
		];

		$capability = 'rank_math_onpage_snippet';
		$args       = [
			'label'               => __( 'Schema', 'gohigh-seo' ),
			'description'         => __( 'Rank Math Schema Templates', 'gohigh-seo' ),
			'labels'              => $labels,
			'supports'            => [ 'title' ],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => ! current_user_can( 'manage_options' ) && Helper::has_cap( 'onpage_snippet' ),
			'menu_position'       => 5,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
			'capabilities'        => [
				'edit_post'          => $capability,
				'read_post'          => $capability,
				'delete_post'        => $capability,
				'edit_posts'         => $capability,
				'edit_others_posts'  => $capability,
				'publish_posts'      => $capability,
				'read_private_posts' => $capability,
				'create_posts'       => $capability,
			],
			'show_in_rest'        => true,
		];

		register_post_type( 'rank_math_schema', $args );
	}

	/**
	 * Add post type as submenu.
	 */
	public function add_menu() {
		if ( ! Helper::has_cap( 'onpage_snippet' ) ) {
			return;
		}

		add_submenu_page(
			'rank-math',
			esc_html__( 'Schema Templates', 'gohigh-seo' ),
			esc_html__( 'Schema Templates', 'gohigh-seo' ),
			'edit_posts',
			'edit.php?post_type=rank_math_schema'
		);
	}

	/**
	 * Fix parent active menu
	 *
	 * @param  string $file Filename.
	 * @return string
	 */
	public function parent_file( $file ) {
		$screen = get_current_screen();

		if ( in_array( $screen->base, [ 'post', 'edit' ], true ) && 'rank_math_schema' === $screen->post_type ) {
			$file = 'rank-math';
		}

		return $file;
	}

	/**
	 * Fix submenu active menu
	 *
	 * @param  string $file Filename.
	 * @return string
	 */
	public function submenu_file( $file ) {
		$screen = get_current_screen();

		if ( in_array( $screen->base, [ 'post', 'edit' ], true ) && 'rank_math_schema' === $screen->post_type ) {
			$file = 'edit.php?post_type=rank_math_schema';
		}

		return $file;
	}
}
