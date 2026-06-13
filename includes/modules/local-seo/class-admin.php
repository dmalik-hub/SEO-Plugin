<?php
/**
 * The Local_Seo Module
 *
 * @since      1.0.0
 * @package    RankMath
 * @subpackage RankMathPro
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Local_Seo;

use GoHighSEO\KB;
use GoHighSEO\Helper;
use GoHighSEO\Traits\Hooker;
use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\Sitemap\Router;

defined( 'ABSPATH' ) || exit;

/**
 * Admin class.
 */
class Admin {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->filter( 'rank_math/settings/sitemap', 'add_sitemap_settings', 11 );
		$this->filter( 'rank_math/settings/snippet/types', 'add_local_business_schema_type', 10, 2 );
	}
	/**
	 * Add module settings into general optional panel.
	 *
	 * @param array $tabs Array of option panel tabs.
	 *
	 * @return array
	 */
	public function add_sitemap_settings( $tabs ) {
		$sitemap_url      = Router::get_base_url( 'locations.kml' );
		$tabs['kml-file'] = [
			'icon'      => 'rm-icon rm-icon-local-seo',
			'title'     => esc_html__( 'Local Sitemap', 'gohigh-seo' ),
			/* translators: KML File Url */
			'desc'      => wp_kses_post( sprintf( __( 'KML is a file format used to display geographic data in an Earth browser such as Google Earth. More information: <a href="%s" target="_blank">Locations KML</a>', 'gohigh-seo' ), KB::get( 'kml-sitemap', 'Options Panel Sitemap Local Tab' ) ) ),
			/* translators: KML File Url */
			'after_row' => '<div class="notice notice-alt notice-info info inline rank-math-notice"><p>' . sprintf( esc_html__( 'Your Locations KML file can be found here: %s', 'gohigh-seo' ), '<a href="' . $sitemap_url . '" target="_blank">' . $sitemap_url . '</a>' ) . '</p></div>',
			'json'      => [
				'kmlFile' => $sitemap_url,
			],
		];

		return $tabs;
	}

	/**
	 * Add Pro schema types in Schema settings choices array.
	 *
	 * @param array  $types     Schema types.
	 * @param string $post_type Post type.
	 */
	public function add_local_business_schema_type( $types, $post_type ) {
		if ( 'rank_math_locations' === $post_type ) {
			$types = [
				'off'           => esc_html__( 'None', 'gohigh-seo' ),
				'LocalBusiness' => esc_html__( 'Local Business', 'gohigh-seo' ),
			];
		}

		return $types;
	}
}
