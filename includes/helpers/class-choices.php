<?php
/**
 * The Choices helpers.
 *
 * @since      0.9.0
 * @package    RankMath
 * @subpackage RankMath\Helpers
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Helpers;

use GoHighSEO\Helper;
use GoHighSEO\Admin\Admin_Helper;
use GoHighSEO\Helpers\DB as DB_Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Choices class.
 */
trait Choices {

	/**
	 * Gets list of overlay images for the social thumbnail.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param  string $output Output type.
	 * @return array
	 */
	public static function choices_overlay_images( $output = 'object' ) {
		$uri = rank_math()->plugin_url() . 'assets/admin/img/';
		$dir = rank_math()->plugin_dir() . 'assets/admin/img/';

		/**
		 * Allow developers to add/remove overlay images.
		 *
		 * @param array $images Image data as array of arrays.
		 */
		$list = apply_filters(
			'rank_math/social/overlay_images',
			[
				'play' => [
					'name' => esc_html__( 'Play icon', 'gohigh-seo' ),
					'url'  => $uri . 'icon-play.png',
					'path' => $dir . 'icon-play.png',
				],
				'gif'  => [
					'name' => esc_html__( 'GIF icon', 'gohigh-seo' ),
					'url'  => $uri . 'icon-gif.png',
					'path' => $dir . 'icon-gif.png',
				],
			]
		);

		// Allow custom positions.
		foreach ( $list as $name => $data ) {
			$list[ $name ]['position'] = apply_filters( 'rank_math/social/overlay_image_position', 'middle_center', $name );
		}

		return 'names' === $output ? wp_list_pluck( $list, 'name' ) : $list;
	}

	/**
	 * Get robot choices.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_robots() {
		return [
			'index'        => esc_html__( 'Index', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Instructs search engines to index and show these pages in the search results.', 'gohigh-seo' ) ),
			'noindex'      => esc_html__( 'No Index', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Prevents pages from being indexed and displayed in search engine result pages', 'gohigh-seo' ) ),
			'nofollow'     => esc_html__( 'No Follow', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Prevents search engines from following links on the pages', 'gohigh-seo' ) ),
			'noarchive'    => esc_html__( 'No Archive', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Prevents search engines from showing Cached links for pages', 'gohigh-seo' ) ),
			'noimageindex' => esc_html__( 'No Image Index', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Prevents images on a page from being indexed by Google and other search engines', 'gohigh-seo' ) ),
			'nosnippet'    => esc_html__( 'No Snippet', 'gohigh-seo' ) . Admin_Helper::get_tooltip( esc_html__( 'Prevents a snippet from being shown in the search results', 'gohigh-seo' ) ),
		];
	}

	/**
	 * Get separator choices.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_separator() {
		return [
			'-'       => '-',
			'&ndash;' => '–',
			'&mdash;' => '—',
			'&raquo;' => '»',
			'|'       => '|',
			'&bull;'  => '•',
		];
	}

	/**
	 * Get all accessible post types as choices.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param boolean $force_refresh Whether to force a fresh call to get_post_types() even if the value is cached. Default false.
	 *
	 * @return array
	 */
	public static function choices_post_types( $force_refresh = false ) {
		static $choices_post_types;

		if ( ! isset( $choices_post_types ) || $force_refresh ) {
			$choices_post_types = Helper::get_accessible_post_types();
			$choices_post_types = \array_map(
				function ( $post_type ) {
					$object = get_post_type_object( $post_type );
					return $object->label;
				},
				$choices_post_types
			);
		}

		return $choices_post_types;
	}

	/**
	 * Get all post types.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_any_post_types() {

		$post_types = self::choices_post_types();
		unset( $post_types['attachment'] );

		return [ 'any' => esc_html__( 'Any', 'gohigh-seo' ) ] + $post_types + [ 'comments' => esc_html( translate( 'Comments' ) ) ]; // phpcs:ignore
	}

	/**
	 * Get business types as choices.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param  bool $none Add none option to list.
	 * @return array
	 */
	public static function choices_business_types( $none = false ) {
		$data = apply_filters(
			'rank_math/json_ld/business_types',
			[
				[
					'label' => 'Organization',
					'child' => [
						[ 'label' => 'Airline' ],
						[ 'label' => 'Consortium' ],
						[ 'label' => 'Corporation' ],
						[
							'label' => 'Educational Organization',
							'child' => [
								[ 'label' => 'College Or University' ],
								[ 'label' => 'Elementary School' ],
								[ 'label' => 'High School' ],
								[ 'label' => 'Middle School' ],
								[ 'label' => 'Preschool' ],
								[ 'label' => 'School' ],
							],
						],
						[ 'label' => 'Funding Scheme' ],
						[ 'label' => 'Government Organization' ],
						[ 'label' => 'Library System' ],
						[
							'label' => 'Local Business',
							'child' => [
								[ 'label' => 'Animal Shelter' ],
								[ 'label' => 'Archive Organization' ],
								[
									'label' => 'Automotive Business',
									'child' => [
										[ 'label' => 'Auto Body Shop' ],
										[ 'label' => 'Auto Dealer' ],
										[ 'label' => 'Auto Parts Store' ],
										[ 'label' => 'Auto Rental' ],
										[ 'label' => 'Auto Repair' ],
										[ 'label' => 'Auto Wash' ],
										[ 'label' => 'Gas Station' ],
										[ 'label' => 'Motorcycle Dealer' ],
										[ 'label' => 'Motorcycle Repair' ],
									],
								],
								[ 'label' => 'Child Care' ],
								[ 'label' => 'Dry Cleaning Or Laundry' ],
								[
									'label' => 'Emergency Service',
									'child' => [
										[ 'label' => 'Fire Station' ],
										[ 'label' => 'Hospital' ],
										[ 'label' => 'Police Station' ],
									],
								],
								[ 'label' => 'Employment Agency' ],
								[
									'label' => 'Entertainment Business',
									'child' => [
										[ 'label' => 'Adult Entertainment' ],
										[ 'label' => 'Amusement Park' ],
										[ 'label' => 'Art Gallery' ],
										[ 'label' => 'Casino' ],
										[ 'label' => 'Comedy Club' ],
										[ 'label' => 'Movie Theater' ],
										[ 'label' => 'Night Club' ],
									],
								],
								[
									'label' => 'Financial Service',
									'child' => [
										[ 'label' => 'Accounting Service' ],
										[ 'label' => 'Automated Teller' ],
										[ 'label' => 'Bank Or CreditUnion' ],
										[ 'label' => 'Insurance Agency' ],
									],
								],
								[
									'label' => 'Food Establishment',
									'child' => [
										[ 'label' => 'Bakery' ],
										[ 'label' => 'Bar Or Pub' ],
										[ 'label' => 'Brewery' ],
										[ 'label' => 'Cafe Or CoffeeShop' ],
										[ 'label' => 'Distillery' ],
										[ 'label' => 'Fast Food Restaurant' ],
										[ 'label' => 'IceCream Shop' ],
										[ 'label' => 'Restaurant' ],
										[ 'label' => 'Winery' ],
									],
								],
								[
									'label' => 'Government Office',
									'child' => [
										[ 'label' => 'Post Office' ],
									],
								],
								[
									'label' => 'Health And Beauty Business',
									'child' => [
										[ 'label' => 'Beauty Salon' ],
										[ 'label' => 'Day Spa' ],
										[ 'label' => 'Hair Salon' ],
										[ 'label' => 'Health Club' ],
										[ 'label' => 'Nail Salon' ],
										[ 'label' => 'Tattoo Parlor' ],
									],
								],
								[
									'label' => 'Home And Construction Business',
									'child' => [
										[ 'label' => 'Electrician' ],
										[ 'label' => 'General Contractor' ],
										[ 'label' => 'HVAC Business' ],
										[ 'label' => 'House Painter' ],
										[ 'label' => 'Locksmith' ],
										[ 'label' => 'Moving Company' ],
										[ 'label' => 'Plumber' ],
										[ 'label' => 'Roofing Contractor' ],
									],
								],
								[ 'label' => 'Internet Cafe' ],
								[
									'label' => 'Legal Service',
									'child' => [
										[ 'label' => 'Notary' ],
									],
								],
								[ 'label' => 'Library' ],
								[
									'label' => 'Lodging Business',
									'child' => [
										[ 'label' => 'Bed And Breakfast' ],
										[ 'label' => 'Campground' ],
										[ 'label' => 'Hostel' ],
										[ 'label' => 'Hotel' ],
										[ 'label' => 'Motel' ],
										[
											'label' => 'Resort',
											'child' => [
												[ 'label' => 'Ski Resort' ],
											],
										],
									],
								],
								[
									'label' => 'Medical Business',
									'child' => [
										[ 'label' => 'Community Health' ],
										[ 'label' => 'Dentist' ],
										[ 'label' => 'Dermatology' ],
										[ 'label' => 'Diet Nutrition' ],
										[ 'label' => 'Emergency' ],
										[ 'label' => 'Geriatric' ],
										[ 'label' => 'Gynecologic' ],
										[ 'label' => 'Medical Clinic' ],
										[ 'label' => 'Optician' ],
										[ 'label' => 'Pharmacy' ],
										[ 'label' => 'Physician' ],
									],
								],
								[ 'label' => 'Professional Service' ],
								[ 'label' => 'Radio Station' ],
								[ 'label' => 'Real Estate Agent' ],
								[ 'label' => 'Recycling Center' ],
								[ 'label' => 'Self Storage' ],
								[ 'label' => 'Shopping Center' ],
								[
									'label' => 'Sports Activity Location',
									'child' => [
										[ 'label' => 'Bowling Alley' ],
										[ 'label' => 'Exercise Gym' ],
										[ 'label' => 'Golf Course' ],
										[ 'label' => 'Health Club' ],
										[ 'label' => 'Public Swimming Pool' ],
										[ 'label' => 'Ski Resort' ],
										[ 'label' => 'Sports Club' ],
										[ 'label' => 'Stadium Or Arena' ],
										[ 'label' => 'Tennis Complex' ],
									],
								],
								[
									'label' => 'Store',
									'child' => [
										[ 'label' => 'Auto Parts Store' ],
										[ 'label' => 'Bike Store' ],
										[ 'label' => 'Book Store' ],
										[ 'label' => 'Clothing Store' ],
										[ 'label' => 'Computer Store' ],
										[ 'label' => 'Convenience Store' ],
										[ 'label' => 'Department Store' ],
										[ 'label' => 'Electronics Store' ],
										[ 'label' => 'Florist' ],
										[ 'label' => 'Furniture Store' ],
										[ 'label' => 'Garden Store' ],
										[ 'label' => 'Grocery Store' ],
										[ 'label' => 'Hardware Store' ],
										[ 'label' => 'Hobby Shop' ],
										[ 'label' => 'Home Goods Store' ],
										[ 'label' => 'Jewelry Store' ],
										[ 'label' => 'Liquor Store' ],
										[ 'label' => 'Mens Clothing Store' ],
										[ 'label' => 'Mobile Phone Store' ],
										[ 'label' => 'Movie Rental Store' ],
										[ 'label' => 'Music Store' ],
										[ 'label' => 'Office Equipment Store' ],
										[ 'label' => 'Outlet Store' ],
										[ 'label' => 'Pawn Shop' ],
										[ 'label' => 'Pet Store' ],
										[ 'label' => 'Shoe Store' ],
										[ 'label' => 'Sporting GoodsStore' ],
										[ 'label' => 'Tire Shop' ],
										[ 'label' => 'Toy Store' ],
										[ 'label' => 'Wholesale Store' ],
									],
								],
								[ 'label' => 'Television Station' ],
								[ 'label' => 'Tourist Information Center' ],
								[ 'label' => 'Travel Agency' ],
							],
						],
						[
							'label' => 'Medical Organization',
							'child' => [
								[ 'label' => 'Diagnostic Lab' ],
								[ 'label' => 'Veterinary Care' ],
							],
						],
						[ 'label' => 'NGO' ],
						[
							'label' => 'Online Business',
							'child' => [
								[ 'label' => 'Online Store' ],
							],
						],
						[ 'label' => 'News Media Organization' ],
						[
							'label' => 'Performing Group',
							'child' => [
								[ 'label' => 'Dance Group' ],
								[ 'label' => 'Music Group' ],
								[ 'label' => 'Theater Group' ],
							],
						],
						[
							'label' => 'Project',
							'child' => [
								[ 'label' => 'Funding Agency' ],
								[ 'label' => 'Research Project' ],
							],
						],
						[
							'label' => 'Sports Organization',
							'child' => [
								[ 'label' => 'Sports Team' ],
							],
						],
						[ 'label' => 'Workers Union' ],
					],
				],
			]
		);

		$business = [];
		if ( $none ) {
			$business['off'] = 'None';
		}

		foreach ( $data as $item ) {
			$business[ str_replace( ' ', '', $item['label'] ) ] = $item['label'];

			if ( isset( $item['child'] ) ) {
				self::indent_child_elements( $business, $item['child'] );
			}
		}

		return $business;
	}

	/**
	 * Get Schema types as choices.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param  bool   $none      Add none option to the list.
	 * @param  string $post_type Post type.
	 * @return array
	 */
	public static function choices_rich_snippet_types( $none = false, $post_type = '' ) {
		$types = [
			'article'    => esc_html__( 'Article', 'gohigh-seo' ),
			'book'       => esc_html__( 'Book', 'gohigh-seo' ),
			'course'     => esc_html__( 'Course', 'gohigh-seo' ),
			'event'      => esc_html__( 'Event', 'gohigh-seo' ),
			'jobposting' => esc_html__( 'Job Posting', 'gohigh-seo' ),
			'music'      => esc_html__( 'Music', 'gohigh-seo' ),
			'product'    => esc_html__( 'Product', 'gohigh-seo' ),
			'recipe'     => esc_html__( 'Recipe', 'gohigh-seo' ),
			'restaurant' => esc_html__( 'Restaurant', 'gohigh-seo' ),
			'video'      => esc_html__( 'Video', 'gohigh-seo' ),
			'person'     => esc_html__( 'Person', 'gohigh-seo' ),
			'service'    => esc_html__( 'Service', 'gohigh-seo' ),
			'software'   => esc_html__( 'Software Application', 'gohigh-seo' ),
		];

		if ( ! empty( self::get_review_posts() ) ) {
			$types['review'] = esc_html__( 'Review (Unsupported)', 'gohigh-seo' );
		}

		if ( $none ) {
			$label = is_string( $none ) ? $none : esc_html__( 'None', 'gohigh-seo' );
			$types = [ 'off' => $label ] + $types;
		}

		/**
		 * Allow developers to add/remove Schema type choices.
		 *
		 * @param array  $types     Schema types.
		 * @param string $post_type Post type.
		 */
		return apply_filters( 'rank_math/settings/snippet/types', $types, $post_type );
	}

	/**
	 * Get the redirection types.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_redirection_types() {
		return [
			'301' => esc_html__( '301 Permanent Move', 'gohigh-seo' ),
			'302' => esc_html__( '302 Temporary Move', 'gohigh-seo' ),
			'307' => esc_html__( '307 Temporary Redirect', 'gohigh-seo' ),
			'410' => esc_html__( '410 Content Deleted', 'gohigh-seo' ),
			'451' => esc_html__( '451 Content Unavailable for Legal Reasons', 'gohigh-seo' ),
		];
	}

	/**
	 * Get comparison types.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_comparison_types() {
		return [
			'exact'    => esc_html__( 'Exact', 'gohigh-seo' ),
			'contains' => esc_html__( 'Contains', 'gohigh-seo' ),
			'start'    => esc_html__( 'Starts With', 'gohigh-seo' ),
			'end'      => esc_html__( 'End With', 'gohigh-seo' ),
			'regex'    => esc_html__( 'Regex', 'gohigh-seo' ),
		];
	}

	/**
	 * Get Post type icons.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_post_type_icons() {
		/**
		 * Allow developer to change post types icons.
		 *
		 * @param array $icons Array of available icons.
		 */
		return apply_filters(
			'rank_math/post_type_icons',
			[
				'default'    => 'rm-icon rm-icon-post',
				'post'       => 'rm-icon rm-icon-post',
				'page'       => 'rm-icon rm-icon-page',
				'attachment' => 'rm-icon rm-icon-attachment',
				'product'    => 'rm-icon rm-icon-cart',
				'web-story'  => 'rm-icon rm-icon-stories',
			]
		);
	}

	/**
	 * Get Taxonomy icons.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return array
	 */
	public static function choices_taxonomy_icons() {
		/**
		 * Allow developer to change taxonomies icons.
		 *
		 * @param array $icons Array of available icons.
		 */
		return apply_filters(
			'rank_math/taxonomy_icons',
			[
				'default'     => 'rm-icon rm-icon-category',
				'category'    => 'rm-icon rm-icon-category',
				'post_tag'    => 'rm-icon rm-icon-tag',
				'product_cat' => 'rm-icon rm-icon-category',
				'product_tag' => 'rm-icon rm-icon-tag',
				'post_format' => 'rm-icon rm-icon-post-format',
			]
		);
	}

	/**
	 * Function to get posts having review schema type selected.
	 */
	public static function get_review_posts() {
		global $wpdb;

		static $posts = null;

		if ( true === boolval( get_option( 'rank_math_review_posts_converted' ) ) ) {
			return false;
		}

		if ( ! is_null( $posts ) ) {
			return $posts;
		}

		$posts = get_transient( 'rank_math_any_review_posts' );
		if ( false !== $posts ) {
			return $posts;
		}

		$meta_query = new \WP_Meta_Query(
			[
				'relation' => 'AND',
				[
					'key'   => 'rank_math_rich_snippet',
					'value' => 'review',
				],
			]
		);

		$meta_query = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$posts      = DB_Helper::get_col( "SELECT {$wpdb->posts}.ID FROM $wpdb->posts {$meta_query['join']} WHERE 1=1 {$meta_query['where']} AND ({$wpdb->posts}.post_status = 'publish')" );

		if ( 0 === count( $posts ) ) {
			update_option( 'rank_math_review_posts_converted', true );
			return false;
		}

		set_transient( 'rank_math_any_review_posts', $posts, DAY_IN_SECONDS );

		return $posts;
	}

	/**
	 * Phones types for schema.
	 *
	 * @return array
	 */
	public static function choices_phone_types() {
		return [
			'customer support'    => esc_html__( 'Customer Service', 'gohigh-seo' ),
			'technical support'   => esc_html__( 'Technical Support', 'gohigh-seo' ),
			'billing support'     => esc_html__( 'Billing Support', 'gohigh-seo' ),
			'bill payment'        => esc_html__( 'Bill Payment', 'gohigh-seo' ),
			'sales'               => esc_html__( 'Sales', 'gohigh-seo' ),
			'reservations'        => esc_html__( 'Reservations', 'gohigh-seo' ),
			'credit card support' => esc_html__( 'Credit Card Support', 'gohigh-seo' ),
			'emergency'           => esc_html__( 'Emergency', 'gohigh-seo' ),
			'baggage tracking'    => esc_html__( 'Baggage Tracking', 'gohigh-seo' ),
			'roadside assistance' => esc_html__( 'Roadside Assistance', 'gohigh-seo' ),
			'package tracking'    => esc_html__( 'Package Tracking', 'gohigh-seo' ),
		];
	}

	/**
	 * Additional Organization details for schema.
	 *
	 * @return array
	 */
	public static function choices_additional_organization_info() {
		return [
			'legalName'            => esc_html__( 'Legal Name', 'gohigh-seo' ),
			'foundingDate'         => esc_html__( 'Founding Date', 'gohigh-seo' ),
			'iso6523Code'          => esc_html__( 'ISO 6523 Code', 'gohigh-seo' ),
			'duns'                 => esc_html__( 'DUNS', 'gohigh-seo' ),
			'leiCode'              => esc_html__( 'LEI Code', 'gohigh-seo' ),
			'naics'                => esc_html__( 'NAICS Code', 'gohigh-seo' ),
			'globalLocationNumber' => esc_html__( 'Global Location Number', 'gohigh-seo' ),
			'vatID'                => esc_html__( 'VAT ID', 'gohigh-seo' ),
			'taxID'                => esc_html__( 'Tax ID', 'gohigh-seo' ),
			'numberOfEmployees'    => esc_html__( 'Number of Employees', 'gohigh-seo' ),
		];
	}

	/**
	 * Function to indent child business types..
	 *
	 * @param array $business Business types array.
	 * @param array $item     Array of child data.
	 * @param int   $level    Nesting level of the current iteration.
	 */
	private static function indent_child_elements( &$business, $item, $level = 1 ) {
		foreach ( $item as $child ) {
			$business[ str_replace( ' ', '', $child['label'] ) ] = str_repeat( '&mdash; ', $level ) . $child['label'];

			if ( isset( $child['child'] ) ) {
				self::indent_child_elements( $business, $child['child'], ( $level + 1 ) );
			}
		}
	}

	/**
	 * Country.
	 *
	 * @return array
	 */
	public static function choices_contentai_countries() {
		return [
			'all'      => esc_html__( 'Worldwide', 'gohigh-seo' ),
			'ar_DZ'    => esc_html__( 'Algeria', 'gohigh-seo' ),
			'es_AR'    => esc_html__( 'Argentina', 'gohigh-seo' ),
			'hy_AM'    => esc_html__( 'Armenia', 'gohigh-seo' ),
			'en_AU'    => esc_html__( 'Australia', 'gohigh-seo' ),
			'de_AT'    => esc_html__( 'Austria', 'gohigh-seo' ),
			'tr_AZ'    => esc_html__( 'Azerbaijan', 'gohigh-seo' ),
			'ar_BH'    => esc_html__( 'Bahrain', 'gohigh-seo' ),
			'en_BD'    => esc_html__( 'Bangladesh', 'gohigh-seo' ),
			'ru_BY'    => esc_html__( 'Belarus', 'gohigh-seo' ),
			'de_BE'    => esc_html__( 'Belgium', 'gohigh-seo' ),
			'es_BO'    => esc_html__( 'Bolivia, Plurinational State Of', 'gohigh-seo' ),
			'pt_BR'    => esc_html__( 'Brazil', 'gohigh-seo' ),
			'bg_BG'    => esc_html__( 'Bulgaria', 'gohigh-seo' ),
			'vi_KH'    => esc_html__( 'Cambodia', 'gohigh-seo' ),
			'en_CA'    => esc_html__( 'Canada', 'gohigh-seo' ),
			'es_CL'    => esc_html__( 'Chile', 'gohigh-seo' ),
			'es_CO'    => esc_html__( 'Colombia', 'gohigh-seo' ),
			'es_CR'    => esc_html__( 'Costa Rica', 'gohigh-seo' ),
			'hr_HR'    => esc_html__( 'Croatia', 'gohigh-seo' ),
			'el_CY'    => esc_html__( 'Cyprus', 'gohigh-seo' ),
			'cs_CZ'    => esc_html__( 'Czechia', 'gohigh-seo' ),
			'da_DK'    => esc_html__( 'Denmark', 'gohigh-seo' ),
			'es_EC'    => esc_html__( 'Ecuador', 'gohigh-seo' ),
			'ar_EG'    => esc_html__( 'Egypt', 'gohigh-seo' ),
			'es_SV'    => esc_html__( 'El Salvador', 'gohigh-seo' ),
			'et_EE'    => esc_html__( 'Estonia', 'gohigh-seo' ),
			'fi_FI'    => esc_html__( 'Finland', 'gohigh-seo' ),
			'fr_FR'    => esc_html__( 'France', 'gohigh-seo' ),
			'de_DE'    => esc_html__( 'Germany', 'gohigh-seo' ),
			'en_GH'    => esc_html__( 'Ghana', 'gohigh-seo' ),
			'el_GR'    => esc_html__( 'Greece', 'gohigh-seo' ),
			'es_GT'    => esc_html__( 'Guatemala', 'gohigh-seo' ),
			'en_HK'    => esc_html__( 'Hong Kong', 'gohigh-seo' ),
			'hu_HU'    => esc_html__( 'Hungary', 'gohigh-seo' ),
			'hi_IN'    => esc_html__( 'India', 'gohigh-seo' ),
			'id_ID'    => esc_html__( 'Indonesia', 'gohigh-seo' ),
			'en_IE'    => esc_html__( 'Ireland', 'gohigh-seo' ),
			'iw_IL'    => esc_html__( 'Israel', 'gohigh-seo' ),
			'it_IT'    => esc_html__( 'Italy', 'gohigh-seo' ),
			'ja_JP'    => esc_html__( 'Japan', 'gohigh-seo' ),
			'ar_JO'    => esc_html__( 'Jordan', 'gohigh-seo' ),
			'ru_KZ'    => esc_html__( 'Kazakhstan', 'gohigh-seo' ),
			'en_KE'    => esc_html__( 'Kenya', 'gohigh-seo' ),
			'ko_KR'    => esc_html__( 'Korea, Republic Of', 'gohigh-seo' ),
			'lv_LV'    => esc_html__( 'Latvia', 'gohigh-seo' ),
			'lt_LT'    => esc_html__( 'Lithuania', 'gohigh-seo' ),
			'tr_MK'    => esc_html__( 'Macedonia, The Former Yugoslav Republic Of', 'gohigh-seo' ),
			'en_MY'    => esc_html__( 'Malaysia', 'gohigh-seo' ),
			'en_MT'    => esc_html__( 'Malta', 'gohigh-seo' ),
			'es_MX'    => esc_html__( 'Mexico', 'gohigh-seo' ),
			'ar_MA'    => esc_html__( 'Morocco', 'gohigh-seo' ),
			'mnw_MM'   => esc_html__( 'Myanmar', 'gohigh-seo' ),
			'nl_NL'    => esc_html__( 'Netherlands', 'gohigh-seo' ),
			'en_NZ'    => esc_html__( 'New Zealand', 'gohigh-seo' ),
			'es_NI'    => esc_html__( 'Nicaragua', 'gohigh-seo' ),
			'en_NG'    => esc_html__( 'Nigeria', 'gohigh-seo' ),
			'no_NO'    => esc_html__( 'Norway', 'gohigh-seo' ),
			'en_PK'    => esc_html__( 'Pakistan', 'gohigh-seo' ),
			'es_PY'    => esc_html__( 'Paraguay', 'gohigh-seo' ),
			'es_PE'    => esc_html__( 'Peru', 'gohigh-seo' ),
			'en_PH'    => esc_html__( 'Philippines', 'gohigh-seo' ),
			'pl_PL'    => esc_html__( 'Poland', 'gohigh-seo' ),
			'pt_PT'    => esc_html__( 'Portugal', 'gohigh-seo' ),
			'ro_RO'    => esc_html__( 'Romania', 'gohigh-seo' ),
			'ru_RU'    => esc_html__( 'Russian Federation', 'gohigh-seo' ),
			'ar_SA'    => esc_html__( 'Saudi Arabia', 'gohigh-seo' ),
			'fr_SN'    => esc_html__( 'Senegal', 'gohigh-seo' ),
			'hr_RS'    => esc_html__( 'Serbia', 'gohigh-seo' ),
			'en_SG'    => esc_html__( 'Singapore', 'gohigh-seo' ),
			'sk_SK'    => esc_html__( 'Slovakia', 'gohigh-seo' ),
			'sl_SI'    => esc_html__( 'Slovenia', 'gohigh-seo' ),
			'en_ZA'    => esc_html__( 'South Africa', 'gohigh-seo' ),
			'es_ES'    => esc_html__( 'Spain', 'gohigh-seo' ),
			'en_LK'    => esc_html__( 'Sri Lanka', 'gohigh-seo' ),
			'sv_SE'    => esc_html__( 'Sweden', 'gohigh-seo' ),
			'de_CH'    => esc_html__( 'Switzerland', 'gohigh-seo' ),
			'zh-TW_TW' => esc_html__( 'Taiwan', 'gohigh-seo' ),
			'th_TH'    => esc_html__( 'Thailand', 'gohigh-seo' ),
			'ar_TN'    => esc_html__( 'Tunisia', 'gohigh-seo' ),
			'tr_TR'    => esc_html__( 'Turkey', 'gohigh-seo' ),
			'ru_UA'    => esc_html__( 'Ukraine', 'gohigh-seo' ),
			'ar_AE'    => esc_html__( 'United Arab Emirates', 'gohigh-seo' ),
			'en_GB'    => esc_html__( 'United Kingdom', 'gohigh-seo' ),
			'en_US'    => esc_html__( 'United States Of America', 'gohigh-seo' ),
			'es_UY'    => esc_html__( 'Uruguay', 'gohigh-seo' ),
			'es_VE'    => esc_html__( 'Venezuela, Bolivarian Republic Of', 'gohigh-seo' ),
			'vi_VN'    => esc_html__( 'Viet Nam', 'gohigh-seo' ),
		];
	}
}
