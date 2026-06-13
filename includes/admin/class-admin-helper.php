<?php
/**
 * Admin helper Functions.
 *
 * This file contains functions needed on the admin screens.
 *
 * @since      2.0.0
 * @package    RankMath
 * @subpackage RankMath\Admin
 * @author     Rank Math <support@rankmath.com>
 */

namespace GoHighSEO\Admin;

use GoHighSEO\Helper;
use GoHighSEO\Admin\Admin_Helper as Free_Admin_Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Admin_Helper class.
 */
class Admin_Helper {

	/**
	 * Get primary term ID.
	 *
	 * @param  int $post_id Post ID.
	 *
	 * @return int
	 */
	public static function get_primary_term_id( $post_id = null ) {
		$taxonomy = self::get_primary_taxonomy( $post_id );
		if ( ! $taxonomy ) {
			return 0;
		}

		$id = get_post_meta( $post_id ? $post_id : get_the_ID(), 'rank_math_primary_' . $taxonomy['name'], true );

		return $id ? absint( $id ) : 0;
	}

	/**
	 * Get current post type.
	 *
	 * @param  int $post_id Post ID.
	 *
	 * @return string
	 */
	public static function get_current_post_type( $post_id = null ) {
		if ( ! $post_id && function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			return isset( $screen->post_type ) ? $screen->post_type : '';
		}

		return get_post_type( $post_id );
	}

	/**
	 * Get primary taxonomy.
	 *
	 * @param  int $post_id Post ID.
	 *
	 * @return bool|array
	 */
	public static function get_primary_taxonomy( $post_id = null ) {
		$taxonomy  = false;
		$post_type = self::get_current_post_type( $post_id );

		/**
		 * Allow disabling the primary term feature.
		 *
		 * @param bool $return True to disable.
		 */
		if ( false === apply_filters( 'rank_math/admin/disable_primary_term', false ) ) {
			$taxonomy = Helper::get_settings( 'titles.pt_' . $post_type . '_primary_taxonomy', false );
		}

		if ( ! $taxonomy ) {
			return false;
		}

		$taxonomy = get_taxonomy( $taxonomy );
		if ( ! $taxonomy ) {
			return false;
		}

		$primary_taxonomy = [
			'title'         => $taxonomy->labels->singular_name,
			'name'          => $taxonomy->name,
			'singularLabel' => $taxonomy->labels->singular_name,
			'restBase'      => ( $taxonomy->rest_base ) ? $taxonomy->rest_base : $taxonomy->name,
		];

		return $primary_taxonomy;
	}

	/**
	 * Check if current plan is business.
	 *
	 * @return boolean
	 */
	public static function is_business_plan() {
		return in_array( self::get_plan(), [ 'business', 'agency' ], true );
	}

	/**
	 * Get current plan.
	 *
	 * @return string
	 */
	public static function get_plan() {
		$registered = Free_Admin_Helper::get_registration_data();

		return isset( $registered['plan'] ) ? $registered['plan'] : 'pro';
	}

	/**
	 * Country.
	 *
	 * @return array
	 */
	public static function choices_countries() {
		return [
			'all' => __( 'Worldwide', 'gohigh-seo' ),
			'AF'  => __( 'Afghanistan', 'gohigh-seo' ),
			'AL'  => __( 'Albania', 'gohigh-seo' ),
			'DZ'  => __( 'Algeria', 'gohigh-seo' ),
			'AS'  => __( 'American Samoa', 'gohigh-seo' ),
			'AD'  => __( 'Andorra', 'gohigh-seo' ),
			'AO'  => __( 'Angola', 'gohigh-seo' ),
			'AI'  => __( 'Anguilla', 'gohigh-seo' ),
			'AQ'  => __( 'Antarctica', 'gohigh-seo' ),
			'AG'  => __( 'Antigua and Barbuda', 'gohigh-seo' ),
			'AR'  => __( 'Argentina', 'gohigh-seo' ),
			'AM'  => __( 'Armenia', 'gohigh-seo' ),
			'AW'  => __( 'Aruba', 'gohigh-seo' ),
			'AU'  => __( 'Australia', 'gohigh-seo' ),
			'AT'  => __( 'Austria', 'gohigh-seo' ),
			'AZ'  => __( 'Azerbaijan', 'gohigh-seo' ),
			'BS'  => __( 'Bahamas', 'gohigh-seo' ),
			'BH'  => __( 'Bahrain', 'gohigh-seo' ),
			'BD'  => __( 'Bangladesh', 'gohigh-seo' ),
			'BB'  => __( 'Barbados', 'gohigh-seo' ),
			'BY'  => __( 'Belarus', 'gohigh-seo' ),
			'BE'  => __( 'Belgium', 'gohigh-seo' ),
			'BZ'  => __( 'Belize', 'gohigh-seo' ),
			'BJ'  => __( 'Benin', 'gohigh-seo' ),
			'BM'  => __( 'Bermuda', 'gohigh-seo' ),
			'BT'  => __( 'Bhutan', 'gohigh-seo' ),
			'BO'  => __( 'Bolivia', 'gohigh-seo' ),
			'BA'  => __( 'Bosnia and Herzegovina', 'gohigh-seo' ),
			'BW'  => __( 'Botswana', 'gohigh-seo' ),
			'BV'  => __( 'Bouvet Island', 'gohigh-seo' ),
			'BR'  => __( 'Brazil', 'gohigh-seo' ),
			'IO'  => __( 'British Indian Ocean Territory', 'gohigh-seo' ),
			'BN'  => __( 'Brunei Darussalam', 'gohigh-seo' ),
			'BG'  => __( 'Bulgaria', 'gohigh-seo' ),
			'BF'  => __( 'Burkina Faso', 'gohigh-seo' ),
			'BI'  => __( 'Burundi', 'gohigh-seo' ),
			'KH'  => __( 'Cambodia', 'gohigh-seo' ),
			'CM'  => __( 'Cameroon', 'gohigh-seo' ),
			'CA'  => __( 'Canada', 'gohigh-seo' ),
			'CV'  => __( 'Cape Verde', 'gohigh-seo' ),
			'KY'  => __( 'Cayman Islands', 'gohigh-seo' ),
			'CF'  => __( 'Central African Republic', 'gohigh-seo' ),
			'TD'  => __( 'Chad', 'gohigh-seo' ),
			'CL'  => __( 'Chile', 'gohigh-seo' ),
			'CN'  => __( 'China', 'gohigh-seo' ),
			'CX'  => __( 'Christmas Island', 'gohigh-seo' ),
			'CC'  => __( 'Cocos (Keeling) Islands', 'gohigh-seo' ),
			'CO'  => __( 'Colombia', 'gohigh-seo' ),
			'KM'  => __( 'Comoros', 'gohigh-seo' ),
			'CG'  => __( 'Congo', 'gohigh-seo' ),
			'CD'  => __( 'Congo, the Democratic Republic of the', 'gohigh-seo' ),
			'CK'  => __( 'Cook Islands', 'gohigh-seo' ),
			'CR'  => __( 'Costa Rica', 'gohigh-seo' ),
			'CI'  => __( "Cote D'ivoire", 'gohigh-seo' ),
			'HR'  => __( 'Croatia', 'gohigh-seo' ),
			'CU'  => __( 'Cuba', 'gohigh-seo' ),
			'CY'  => __( 'Cyprus', 'gohigh-seo' ),
			'CZ'  => __( 'Czech Republic', 'gohigh-seo' ),
			'DK'  => __( 'Denmark', 'gohigh-seo' ),
			'DJ'  => __( 'Djibouti', 'gohigh-seo' ),
			'DM'  => __( 'Dominica', 'gohigh-seo' ),
			'DO'  => __( 'Dominican Republic', 'gohigh-seo' ),
			'EC'  => __( 'Ecuador', 'gohigh-seo' ),
			'EG'  => __( 'Egypt', 'gohigh-seo' ),
			'SV'  => __( 'El Salvador', 'gohigh-seo' ),
			'GQ'  => __( 'Equatorial Guinea', 'gohigh-seo' ),
			'ER'  => __( 'Eritrea', 'gohigh-seo' ),
			'EE'  => __( 'Estonia', 'gohigh-seo' ),
			'ET'  => __( 'Ethiopia', 'gohigh-seo' ),
			'FK'  => __( 'Falkland Islands (Malvinas)', 'gohigh-seo' ),
			'FO'  => __( 'Faroe Islands', 'gohigh-seo' ),
			'FJ'  => __( 'Fiji', 'gohigh-seo' ),
			'FI'  => __( 'Finland', 'gohigh-seo' ),
			'FR'  => __( 'France', 'gohigh-seo' ),
			'GF'  => __( 'French Guiana', 'gohigh-seo' ),
			'PF'  => __( 'French Polynesia', 'gohigh-seo' ),
			'TF'  => __( 'French Southern Territories', 'gohigh-seo' ),
			'GA'  => __( 'Gabon', 'gohigh-seo' ),
			'GM'  => __( 'Gambia', 'gohigh-seo' ),
			'GE'  => __( 'Georgia', 'gohigh-seo' ),
			'DE'  => __( 'Germany', 'gohigh-seo' ),
			'GH'  => __( 'Ghana', 'gohigh-seo' ),
			'GI'  => __( 'Gibraltar', 'gohigh-seo' ),
			'GR'  => __( 'Greece', 'gohigh-seo' ),
			'GL'  => __( 'Greenland', 'gohigh-seo' ),
			'GD'  => __( 'Grenada', 'gohigh-seo' ),
			'GP'  => __( 'Guadeloupe', 'gohigh-seo' ),
			'GU'  => __( 'Guam', 'gohigh-seo' ),
			'GT'  => __( 'Guatemala', 'gohigh-seo' ),
			'GN'  => __( 'Guinea', 'gohigh-seo' ),
			'GW'  => __( 'Guinea-Bissau', 'gohigh-seo' ),
			'GY'  => __( 'Guyana', 'gohigh-seo' ),
			'HT'  => __( 'Haiti', 'gohigh-seo' ),
			'HM'  => __( 'Heard Island and Mcdonald Islands', 'gohigh-seo' ),
			'VA'  => __( 'Holy See (Vatican City State)', 'gohigh-seo' ),
			'HN'  => __( 'Honduras', 'gohigh-seo' ),
			'HK'  => __( 'Hong Kong', 'gohigh-seo' ),
			'HU'  => __( 'Hungary', 'gohigh-seo' ),
			'IS'  => __( 'Iceland', 'gohigh-seo' ),
			'IN'  => __( 'India', 'gohigh-seo' ),
			'ID'  => __( 'Indonesia', 'gohigh-seo' ),
			'IR'  => __( 'Iran, Islamic Republic of', 'gohigh-seo' ),
			'IQ'  => __( 'Iraq', 'gohigh-seo' ),
			'IE'  => __( 'Ireland', 'gohigh-seo' ),
			'IL'  => __( 'Israel', 'gohigh-seo' ),
			'IT'  => __( 'Italy', 'gohigh-seo' ),
			'JM'  => __( 'Jamaica', 'gohigh-seo' ),
			'JP'  => __( 'Japan', 'gohigh-seo' ),
			'JO'  => __( 'Jordan', 'gohigh-seo' ),
			'KZ'  => __( 'Kazakhstan', 'gohigh-seo' ),
			'KE'  => __( 'Kenya', 'gohigh-seo' ),
			'KI'  => __( 'Kiribati', 'gohigh-seo' ),
			'KP'  => __( "Korea, Democratic People's Republic of", 'gohigh-seo' ),
			'KR'  => __( 'Korea, Republic of', 'gohigh-seo' ),
			'KW'  => __( 'Kuwait', 'gohigh-seo' ),
			'KG'  => __( 'Kyrgyzstan', 'gohigh-seo' ),
			'LA'  => __( "Lao People's Democratic Republic", 'gohigh-seo' ),
			'LV'  => __( 'Latvia', 'gohigh-seo' ),
			'LB'  => __( 'Lebanon', 'gohigh-seo' ),
			'LS'  => __( 'Lesotho', 'gohigh-seo' ),
			'LR'  => __( 'Liberia', 'gohigh-seo' ),
			'LY'  => __( 'Libyan Arab Jamahiriya', 'gohigh-seo' ),
			'LI'  => __( 'Liechtenstein', 'gohigh-seo' ),
			'LT'  => __( 'Lithuania', 'gohigh-seo' ),
			'LU'  => __( 'Luxembourg', 'gohigh-seo' ),
			'MO'  => __( 'Macao', 'gohigh-seo' ),
			'MK'  => __( 'Macedonia, the Former Yugosalv Republic of', 'gohigh-seo' ),
			'MG'  => __( 'Madagascar', 'gohigh-seo' ),
			'MW'  => __( 'Malawi', 'gohigh-seo' ),
			'MY'  => __( 'Malaysia', 'gohigh-seo' ),
			'MV'  => __( 'Maldives', 'gohigh-seo' ),
			'ML'  => __( 'Mali', 'gohigh-seo' ),
			'MT'  => __( 'Malta', 'gohigh-seo' ),
			'MH'  => __( 'Marshall Islands', 'gohigh-seo' ),
			'MQ'  => __( 'Martinique', 'gohigh-seo' ),
			'MR'  => __( 'Mauritania', 'gohigh-seo' ),
			'MU'  => __( 'Mauritius', 'gohigh-seo' ),
			'YT'  => __( 'Mayotte', 'gohigh-seo' ),
			'MX'  => __( 'Mexico', 'gohigh-seo' ),
			'FM'  => __( 'Micronesia, Federated States of', 'gohigh-seo' ),
			'MC'  => __( 'Monaco', 'gohigh-seo' ),
			'MN'  => __( 'Mongolia', 'gohigh-seo' ),
			'MS'  => __( 'Montserrat', 'gohigh-seo' ),
			'MA'  => __( 'Morocco', 'gohigh-seo' ),
			'MZ'  => __( 'Mozambique', 'gohigh-seo' ),
			'MM'  => __( 'Myanmar', 'gohigh-seo' ),
			'NA'  => __( 'Namibia', 'gohigh-seo' ),
			'NR'  => __( 'Nauru', 'gohigh-seo' ),
			'NP'  => __( 'Nepal', 'gohigh-seo' ),
			'NL'  => __( 'Netherlands', 'gohigh-seo' ),
			'AN'  => __( 'Netherlands Antilles', 'gohigh-seo' ),
			'NC'  => __( 'New Caledonia', 'gohigh-seo' ),
			'NZ'  => __( 'New Zealand', 'gohigh-seo' ),
			'NI'  => __( 'Nicaragua', 'gohigh-seo' ),
			'NE'  => __( 'Niger', 'gohigh-seo' ),
			'NG'  => __( 'Nigeria', 'gohigh-seo' ),
			'NU'  => __( 'Niue', 'gohigh-seo' ),
			'NF'  => __( 'Norfolk Island', 'gohigh-seo' ),
			'MP'  => __( 'Northern Mariana Islands', 'gohigh-seo' ),
			'NO'  => __( 'Norway', 'gohigh-seo' ),
			'OM'  => __( 'Oman', 'gohigh-seo' ),
			'PK'  => __( 'Pakistan', 'gohigh-seo' ),
			'PW'  => __( 'Palau', 'gohigh-seo' ),
			'PS'  => __( 'Palestinian Territory, Occupied', 'gohigh-seo' ),
			'PA'  => __( 'Panama', 'gohigh-seo' ),
			'PG'  => __( 'Papua New Guinea', 'gohigh-seo' ),
			'PY'  => __( 'Paraguay', 'gohigh-seo' ),
			'PE'  => __( 'Peru', 'gohigh-seo' ),
			'PH'  => __( 'Philippines', 'gohigh-seo' ),
			'PN'  => __( 'Pitcairn', 'gohigh-seo' ),
			'PL'  => __( 'Poland', 'gohigh-seo' ),
			'PT'  => __( 'Portugal', 'gohigh-seo' ),
			'PR'  => __( 'Puerto Rico', 'gohigh-seo' ),
			'QA'  => __( 'Qatar', 'gohigh-seo' ),
			'RE'  => __( 'Reunion', 'gohigh-seo' ),
			'RO'  => __( 'Romania', 'gohigh-seo' ),
			'RU'  => __( 'Russian Federation', 'gohigh-seo' ),
			'RW'  => __( 'Rwanda', 'gohigh-seo' ),
			'SH'  => __( 'Saint Helena', 'gohigh-seo' ),
			'KN'  => __( 'Saint Kitts and Nevis', 'gohigh-seo' ),
			'LC'  => __( 'Saint Lucia', 'gohigh-seo' ),
			'PM'  => __( 'Saint Pierre and Miquelon', 'gohigh-seo' ),
			'VC'  => __( 'Saint Vincent and the Grenadines', 'gohigh-seo' ),
			'WS'  => __( 'Samoa', 'gohigh-seo' ),
			'SM'  => __( 'San Marino', 'gohigh-seo' ),
			'ST'  => __( 'Sao Tome and Principe', 'gohigh-seo' ),
			'SA'  => __( 'Saudi Arabia', 'gohigh-seo' ),
			'SN'  => __( 'Senegal', 'gohigh-seo' ),
			'RS'  => __( 'Serbia', 'gohigh-seo' ),
			'ME'  => __( 'Montenegro', 'gohigh-seo' ),
			'SC'  => __( 'Seychelles', 'gohigh-seo' ),
			'SL'  => __( 'Sierra Leone', 'gohigh-seo' ),
			'SG'  => __( 'Singapore', 'gohigh-seo' ),
			'SK'  => __( 'Slovakia', 'gohigh-seo' ),
			'SI'  => __( 'Slovenia', 'gohigh-seo' ),
			'SB'  => __( 'Solomon Islands', 'gohigh-seo' ),
			'SO'  => __( 'Somalia', 'gohigh-seo' ),
			'ZA'  => __( 'South Africa', 'gohigh-seo' ),
			'GS'  => __( 'South Georgia and the South Sandwich Islands', 'gohigh-seo' ),
			'ES'  => __( 'Spain', 'gohigh-seo' ),
			'LK'  => __( 'Sri Lanka', 'gohigh-seo' ),
			'SD'  => __( 'Sudan', 'gohigh-seo' ),
			'SR'  => __( 'Suriname', 'gohigh-seo' ),
			'SJ'  => __( 'Svalbard and Jan Mayen', 'gohigh-seo' ),
			'SZ'  => __( 'Swaziland', 'gohigh-seo' ),
			'SE'  => __( 'Sweden', 'gohigh-seo' ),
			'CH'  => __( 'Switzerland', 'gohigh-seo' ),
			'SY'  => __( 'Syrian Arab Republic', 'gohigh-seo' ),
			'TW'  => __( 'Taiwan, Province of China', 'gohigh-seo' ),
			'TJ'  => __( 'Tajikistan', 'gohigh-seo' ),
			'TZ'  => __( 'Tanzania, United Republic of', 'gohigh-seo' ),
			'TH'  => __( 'Thailand', 'gohigh-seo' ),
			'TL'  => __( 'Timor-Leste', 'gohigh-seo' ),
			'TG'  => __( 'Togo', 'gohigh-seo' ),
			'TK'  => __( 'Tokelau', 'gohigh-seo' ),
			'TO'  => __( 'Tonga', 'gohigh-seo' ),
			'TT'  => __( 'Trinidad and Tobago', 'gohigh-seo' ),
			'TN'  => __( 'Tunisia', 'gohigh-seo' ),
			'TR'  => __( 'Turkey', 'gohigh-seo' ),
			'TM'  => __( 'Turkmenistan', 'gohigh-seo' ),
			'TC'  => __( 'Turks and Caicos Islands', 'gohigh-seo' ),
			'TV'  => __( 'Tuvalu', 'gohigh-seo' ),
			'UG'  => __( 'Uganda', 'gohigh-seo' ),
			'UA'  => __( 'Ukraine', 'gohigh-seo' ),
			'AE'  => __( 'United Arab Emirates', 'gohigh-seo' ),
			'GB'  => __( 'United Kingdom', 'gohigh-seo' ),
			'US'  => __( 'United States', 'gohigh-seo' ),
			'UM'  => __( 'United States Minor Outlying Islands', 'gohigh-seo' ),
			'UY'  => __( 'Uruguay', 'gohigh-seo' ),
			'UZ'  => __( 'Uzbekistan', 'gohigh-seo' ),
			'VU'  => __( 'Vanuatu', 'gohigh-seo' ),
			'VE'  => __( 'Venezuela', 'gohigh-seo' ),
			'VN'  => __( 'Viet Nam', 'gohigh-seo' ),
			'VG'  => __( 'Virgin Islands, British', 'gohigh-seo' ),
			'VI'  => __( 'Virgin Islands, U.S.', 'gohigh-seo' ),
			'WF'  => __( 'Wallis and Futuna', 'gohigh-seo' ),
			'EH'  => __( 'Western Sahara', 'gohigh-seo' ),
			'YE'  => __( 'Yemen', 'gohigh-seo' ),
			'ZM'  => __( 'Zambia', 'gohigh-seo' ),
			'ZW'  => __( 'Zimbabwe', 'gohigh-seo' ),
		];
	}

	/**
	 * Country.
	 *
	 * @return array
	 */
	public static function choices_countries_3() {
		return [
			'all' => __( 'Worldwide', 'gohigh-seo' ),
			'AFG' => __( 'Afghanistan', 'gohigh-seo' ),
			'ALA' => __( 'Aland Islands', 'gohigh-seo' ),
			'ALB' => __( 'Albania', 'gohigh-seo' ),
			'DZA' => __( 'Algeria', 'gohigh-seo' ),
			'ASM' => __( 'American Samoa', 'gohigh-seo' ),
			'AND' => __( 'Andorra', 'gohigh-seo' ),
			'AGO' => __( 'Angola', 'gohigh-seo' ),
			'AIA' => __( 'Anguilla', 'gohigh-seo' ),
			'ATA' => __( 'Antarctica', 'gohigh-seo' ),
			'ATG' => __( 'Antigua & Barbuda', 'gohigh-seo' ),
			'ARG' => __( 'Argentina', 'gohigh-seo' ),
			'ARM' => __( 'Armenia', 'gohigh-seo' ),
			'ABW' => __( 'Aruba', 'gohigh-seo' ),
			'AUS' => __( 'Australia', 'gohigh-seo' ),
			'AUT' => __( 'Austria', 'gohigh-seo' ),
			'AZE' => __( 'Azerbaijan', 'gohigh-seo' ),
			'BHS' => __( 'Bahamas', 'gohigh-seo' ),
			'BHR' => __( 'Bahrain', 'gohigh-seo' ),
			'BGD' => __( 'Bangladesh', 'gohigh-seo' ),
			'BRB' => __( 'Barbados', 'gohigh-seo' ),
			'BLR' => __( 'Belarus', 'gohigh-seo' ),
			'BEL' => __( 'Belgium', 'gohigh-seo' ),
			'BLZ' => __( 'Belize', 'gohigh-seo' ),
			'BEN' => __( 'Benin', 'gohigh-seo' ),
			'BMU' => __( 'Bermuda', 'gohigh-seo' ),
			'BTN' => __( 'Bhutan', 'gohigh-seo' ),
			'BOL' => __( 'Bolivia', 'gohigh-seo' ),
			'BIH' => __( 'Bosnia & Herzegovina', 'gohigh-seo' ),
			'BWA' => __( 'Botswana', 'gohigh-seo' ),
			'BRA' => __( 'Brazil', 'gohigh-seo' ),
			'IOT' => __( 'British Indian Ocean Territory', 'gohigh-seo' ),
			'VGB' => __( 'British Virgin Islands', 'gohigh-seo' ),
			'BRN' => __( 'Brunei', 'gohigh-seo' ),
			'BGR' => __( 'Bulgaria', 'gohigh-seo' ),
			'BFA' => __( 'Burkina Faso', 'gohigh-seo' ),
			'BDI' => __( 'Burundi', 'gohigh-seo' ),
			'KHM' => __( 'Cambodia', 'gohigh-seo' ),
			'CMR' => __( 'Cameroon', 'gohigh-seo' ),
			'CAN' => __( 'Canada', 'gohigh-seo' ),
			'CPV' => __( 'Cape Verde', 'gohigh-seo' ),
			'BES' => __( 'Caribbean Netherlands', 'gohigh-seo' ),
			'CYM' => __( 'Cayman Islands', 'gohigh-seo' ),
			'CAF' => __( 'Central African Republic', 'gohigh-seo' ),
			'TCD' => __( 'Chad', 'gohigh-seo' ),
			'CHL' => __( 'Chile', 'gohigh-seo' ),
			'CHN' => __( 'China', 'gohigh-seo' ),
			'CXR' => __( 'Christmas Island', 'gohigh-seo' ),
			'COL' => __( 'Colombia', 'gohigh-seo' ),
			'COM' => __( 'Comoros', 'gohigh-seo' ),
			'COG' => __( 'Congo - Brazzaville', 'gohigh-seo' ),
			'COD' => __( 'Congo - Kinshasa', 'gohigh-seo' ),
			'COK' => __( 'Cook Islands', 'gohigh-seo' ),
			'CRI' => __( 'Costa Rica', 'gohigh-seo' ),
			'HRV' => __( 'Croatia', 'gohigh-seo' ),
			'CUB' => __( 'Cuba', 'gohigh-seo' ),
			'CUW' => __( 'Curaçao', 'gohigh-seo' ),
			'CYP' => __( 'Cyprus', 'gohigh-seo' ),
			'CZE' => __( 'Czechia', 'gohigh-seo' ),
			'DNK' => __( 'Denmark', 'gohigh-seo' ),
			'DJI' => __( 'Djibouti', 'gohigh-seo' ),
			'DMA' => __( 'Dominica', 'gohigh-seo' ),
			'DOM' => __( 'Dominican Republic', 'gohigh-seo' ),
			'ECU' => __( 'Ecuador', 'gohigh-seo' ),
			'EGY' => __( 'Egypt', 'gohigh-seo' ),
			'SLV' => __( 'El Salvador', 'gohigh-seo' ),
			'GNQ' => __( 'Equatorial Guinea', 'gohigh-seo' ),
			'ERI' => __( 'Eritrea', 'gohigh-seo' ),
			'EST' => __( 'Estonia', 'gohigh-seo' ),
			'ETH' => __( 'Ethiopia', 'gohigh-seo' ),
			'FLK' => __( 'Falkland Islands (Islas Malvinas)', 'gohigh-seo' ),
			'FRO' => __( 'Faroe Islands', 'gohigh-seo' ),
			'FJI' => __( 'Fiji', 'gohigh-seo' ),
			'FIN' => __( 'Finland', 'gohigh-seo' ),
			'FRA' => __( 'France', 'gohigh-seo' ),
			'GUF' => __( 'French Guiana', 'gohigh-seo' ),
			'PYF' => __( 'French Polynesia', 'gohigh-seo' ),
			'GAB' => __( 'Gabon', 'gohigh-seo' ),
			'GMB' => __( 'Gambia', 'gohigh-seo' ),
			'GEO' => __( 'Georgia', 'gohigh-seo' ),
			'DEU' => __( 'Germany', 'gohigh-seo' ),
			'GHA' => __( 'Ghana', 'gohigh-seo' ),
			'GIB' => __( 'Gibraltar', 'gohigh-seo' ),
			'GRC' => __( 'Greece', 'gohigh-seo' ),
			'GRL' => __( 'Greenland', 'gohigh-seo' ),
			'GRD' => __( 'Grenada', 'gohigh-seo' ),
			'GLP' => __( 'Guadeloupe', 'gohigh-seo' ),
			'GUM' => __( 'Guam', 'gohigh-seo' ),
			'GTM' => __( 'Guatemala', 'gohigh-seo' ),
			'GGY' => __( 'Guernsey', 'gohigh-seo' ),
			'GIN' => __( 'Guinea', 'gohigh-seo' ),
			'GNB' => __( 'Guinea-Bissau', 'gohigh-seo' ),
			'GUY' => __( 'Guyana', 'gohigh-seo' ),
			'HTI' => __( 'Haiti', 'gohigh-seo' ),
			'HND' => __( 'Honduras', 'gohigh-seo' ),
			'HKG' => __( 'Hong Kong', 'gohigh-seo' ),
			'HUN' => __( 'Hungary', 'gohigh-seo' ),
			'ISL' => __( 'Iceland', 'gohigh-seo' ),
			'IND' => __( 'India', 'gohigh-seo' ),
			'IDN' => __( 'Indonesia', 'gohigh-seo' ),
			'IRN' => __( 'Iran', 'gohigh-seo' ),
			'IRQ' => __( 'Iraq', 'gohigh-seo' ),
			'IRL' => __( 'Ireland', 'gohigh-seo' ),
			'IMN' => __( 'Isle of Man', 'gohigh-seo' ),
			'ISR' => __( 'Israel', 'gohigh-seo' ),
			'ITA' => __( 'Italy', 'gohigh-seo' ),
			'JAM' => __( 'Jamaica', 'gohigh-seo' ),
			'JPN' => __( 'Japan', 'gohigh-seo' ),
			'JEY' => __( 'Jersey', 'gohigh-seo' ),
			'JOR' => __( 'Jordan', 'gohigh-seo' ),
			'KAZ' => __( 'Kazakhstan', 'gohigh-seo' ),
			'KEN' => __( 'Kenya', 'gohigh-seo' ),
			'KIR' => __( 'Kiribati', 'gohigh-seo' ),
			'XKK' => __( 'Kosovo', 'gohigh-seo' ),
			'KWT' => __( 'Kuwait', 'gohigh-seo' ),
			'KGZ' => __( 'Kyrgyzstan', 'gohigh-seo' ),
			'LAO' => __( 'Laos', 'gohigh-seo' ),
			'LBN' => __( 'Lebanon', 'gohigh-seo' ),
			'LSO' => __( 'Lesotho', 'gohigh-seo' ),
			'LBR' => __( 'Liberia', 'gohigh-seo' ),
			'LBY' => __( 'Libya', 'gohigh-seo' ),
			'LIE' => __( 'Liechtenstein', 'gohigh-seo' ),
			'LTU' => __( 'Lithuania', 'gohigh-seo' ),
			'LUX' => __( 'Luxembourg', 'gohigh-seo' ),
			'MAC' => __( 'Macau', 'gohigh-seo' ),
			'MKD' => __( 'Macedonia', 'gohigh-seo' ),
			'MDG' => __( 'Madagascar', 'gohigh-seo' ),
			'MWI' => __( 'Malawi', 'gohigh-seo' ),
			'MYS' => __( 'Malaysia', 'gohigh-seo' ),
			'MDV' => __( 'Maldives', 'gohigh-seo' ),
			'MLI' => __( 'Mali', 'gohigh-seo' ),
			'MLT' => __( 'Malta', 'gohigh-seo' ),
			'MHL' => __( 'Marshall Islands', 'gohigh-seo' ),
			'MTQ' => __( 'Martinique', 'gohigh-seo' ),
			'MRT' => __( 'Mauritania', 'gohigh-seo' ),
			'MUS' => __( 'Mauritius', 'gohigh-seo' ),
			'MYT' => __( 'Mayotte', 'gohigh-seo' ),
			'MEX' => __( 'Mexico', 'gohigh-seo' ),
			'FSM' => __( 'Micronesia', 'gohigh-seo' ),
			'MDA' => __( 'Moldova', 'gohigh-seo' ),
			'MCO' => __( 'Monaco', 'gohigh-seo' ),
			'MNG' => __( 'Mongolia', 'gohigh-seo' ),
			'MNE' => __( 'Montenegro', 'gohigh-seo' ),
			'MSR' => __( 'Montserrat', 'gohigh-seo' ),
			'MAR' => __( 'Morocco', 'gohigh-seo' ),
			'MOZ' => __( 'Mozambique', 'gohigh-seo' ),
			'MMR' => __( 'Myanmar (Burma)', 'gohigh-seo' ),
			'NAM' => __( 'Namibia', 'gohigh-seo' ),
			'NRU' => __( 'Nauru', 'gohigh-seo' ),
			'NPL' => __( 'Nepal', 'gohigh-seo' ),
			'NLD' => __( 'Netherlands', 'gohigh-seo' ),
			'NCL' => __( 'New Caledonia', 'gohigh-seo' ),
			'NZL' => __( 'New Zealand', 'gohigh-seo' ),
			'NIC' => __( 'Nicaragua', 'gohigh-seo' ),
			'NER' => __( 'Niger', 'gohigh-seo' ),
			'NGA' => __( 'Nigeria', 'gohigh-seo' ),
			'NIU' => __( 'Niue', 'gohigh-seo' ),
			'NFK' => __( 'Norfolk Island', 'gohigh-seo' ),
			'PRK' => __( 'North Korea', 'gohigh-seo' ),
			'MNP' => __( 'Northern Mariana Islands', 'gohigh-seo' ),
			'NOR' => __( 'Norway', 'gohigh-seo' ),
			'OMN' => __( 'Oman', 'gohigh-seo' ),
			'PAK' => __( 'Pakistan', 'gohigh-seo' ),
			'PLW' => __( 'Palau', 'gohigh-seo' ),
			'PSE' => __( 'Palestine', 'gohigh-seo' ),
			'PAN' => __( 'Panama', 'gohigh-seo' ),
			'PNG' => __( 'Papua New Guinea', 'gohigh-seo' ),
			'PRY' => __( 'Paraguay', 'gohigh-seo' ),
			'PER' => __( 'Peru', 'gohigh-seo' ),
			'PHL' => __( 'Philippines', 'gohigh-seo' ),
			'POL' => __( 'Poland', 'gohigh-seo' ),
			'PRT' => __( 'Portugal', 'gohigh-seo' ),
			'PRI' => __( 'Puerto Rico', 'gohigh-seo' ),
			'QAT' => __( 'Qatar', 'gohigh-seo' ),
			'ROU' => __( 'Romania', 'gohigh-seo' ),
			'RUS' => __( 'Russia', 'gohigh-seo' ),
			'RWA' => __( 'Rwanda', 'gohigh-seo' ),
			'REU' => __( 'Réunion', 'gohigh-seo' ),
			'WSM' => __( 'Samoa', 'gohigh-seo' ),
			'SMR' => __( 'San Marino', 'gohigh-seo' ),
			'SAU' => __( 'Saudi Arabia', 'gohigh-seo' ),
			'SEN' => __( 'Senegal', 'gohigh-seo' ),
			'SRB' => __( 'Serbia', 'gohigh-seo' ),
			'SYC' => __( 'Seychelles', 'gohigh-seo' ),
			'SLE' => __( 'Sierra Leone', 'gohigh-seo' ),
			'SGP' => __( 'Singapore', 'gohigh-seo' ),
			'SXM' => __( 'Sint Maarten', 'gohigh-seo' ),
			'SVK' => __( 'Slovakia', 'gohigh-seo' ),
			'SVN' => __( 'Slovenia', 'gohigh-seo' ),
			'SLB' => __( 'Solomon Islands', 'gohigh-seo' ),
			'SOM' => __( 'Somalia', 'gohigh-seo' ),
			'ZAF' => __( 'South Africa', 'gohigh-seo' ),
			'KOR' => __( 'South Korea', 'gohigh-seo' ),
			'SSD' => __( 'South Sudan', 'gohigh-seo' ),
			'ESP' => __( 'Spain', 'gohigh-seo' ),
			'LKA' => __( 'Sri Lanka', 'gohigh-seo' ),
			'SHN' => __( 'St. Helena', 'gohigh-seo' ),
			'KNA' => __( 'St. Kitts & Nevis', 'gohigh-seo' ),
			'LCA' => __( 'St. Lucia', 'gohigh-seo' ),
			'MAF' => __( 'St. Martin', 'gohigh-seo' ),
			'SPM' => __( 'St. Pierre & Miquelon', 'gohigh-seo' ),
			'VCT' => __( 'St. Vincent & Grenadines', 'gohigh-seo' ),
			'SDN' => __( 'Sudan', 'gohigh-seo' ),
			'SUR' => __( 'Suriname', 'gohigh-seo' ),
			'SJM' => __( 'Svalbard & Jan Mayen', 'gohigh-seo' ),
			'SWZ' => __( 'Swaziland', 'gohigh-seo' ),
			'SWE' => __( 'Sweden', 'gohigh-seo' ),
			'CHE' => __( 'Switzerland', 'gohigh-seo' ),
			'SYR' => __( 'Syria', 'gohigh-seo' ),
			'STP' => __( 'São Tomé & Príncipe', 'gohigh-seo' ),
			'TWN' => __( 'Taiwan', 'gohigh-seo' ),
			'TJK' => __( 'Tajikistan', 'gohigh-seo' ),
			'TZA' => __( 'Tanzania', 'gohigh-seo' ),
			'THA' => __( 'Thailand', 'gohigh-seo' ),
			'TLS' => __( 'Timor-Leste', 'gohigh-seo' ),
			'TGO' => __( 'Togo', 'gohigh-seo' ),
			'TON' => __( 'Tonga', 'gohigh-seo' ),
			'TTO' => __( 'Trinidad & Tobago', 'gohigh-seo' ),
			'TUN' => __( 'Tunisia', 'gohigh-seo' ),
			'TUR' => __( 'Turkey', 'gohigh-seo' ),
			'TKM' => __( 'Turkmenistan', 'gohigh-seo' ),
			'TCA' => __( 'Turks & Caicos Islands', 'gohigh-seo' ),
			'TUV' => __( 'Tuvalu', 'gohigh-seo' ),
			'VIR' => __( 'U.S. Virgin Islands', 'gohigh-seo' ),
			'UGA' => __( 'Uganda', 'gohigh-seo' ),
			'UKR' => __( 'Ukraine', 'gohigh-seo' ),
			'ARE' => __( 'United Arab Emirates', 'gohigh-seo' ),
			'GBR' => __( 'United Kingdom', 'gohigh-seo' ),
			'USA' => __( 'United States', 'gohigh-seo' ),
			'URY' => __( 'Uruguay', 'gohigh-seo' ),
			'UZB' => __( 'Uzbekistan', 'gohigh-seo' ),
			'VUT' => __( 'Vanuatu', 'gohigh-seo' ),
			'VEN' => __( 'Venezuela', 'gohigh-seo' ),
			'VNM' => __( 'Vietnam', 'gohigh-seo' ),
			'WLF' => __( 'Wallis & Futuna', 'gohigh-seo' ),
			'ESH' => __( 'Western Sahara', 'gohigh-seo' ),
			'YEM' => __( 'Yemen', 'gohigh-seo' ),
			'ZMB' => __( 'Zambia', 'gohigh-seo' ),
			'ZWE' => __( 'Zimbabwe', 'gohigh-seo' ),
			'ZZZ' => __( 'Unknown Region', 'gohigh-seo' ),
		];
	}

	/**
	 * Get Keyword Intent for the given Focus Keyword(s).
	 *
	 * @param array  $args      Array of arguments to send to the API.
	 * @param string $endpoint Keyword Intent endpoint.
	 *
	 * @return array|string
	 */
	public static function determine_search_intent( $args, $endpoint = 'keyword_intent' ) {
		$registered = Free_Admin_Helper::get_registration_data();
		$response   = wp_remote_post(
			CONTENT_AI_URL . '/ai/' . $endpoint,
			[
				'body' => array_merge(
					$args,
					[
						'username'       => $registered['username'],
						'api_key'        => $registered['api_key'],
						'site_url'       => $registered['site_url'],
						'plugin_version' => rank_math()->version,
					]
				),
			]
		);

		if ( is_wp_error( $response ) ) {
			return [
				'error' => $response->get_error_message(),
			];
		}

		$response = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! empty( $response['error'] ) ) {
			$errors        = Helper::get_content_ai_errors();
			$error_message = isset( $response['message'] ) ? $response['message'] : esc_html__( 'Could not generate. Please try again later.', 'gohigh-seo' );
			if ( isset( $response['err_key'] ) && isset( $errors[ $response['err_key'] ] ) ) {
				$error_message = $errors[ $response['err_key'] ];
			}

			return [
				'error' => $error_message,
			];
		}

		return current( $response['results'] );
	}

	/**
	 * Update and return the Search Intent
	 *
	 * @param array $intent Search Intent to update.
	 *
	 * @return array
	 */
	public static function get_search_intent( $intent = null ) {
		$stored_search_intent = (array) get_option( 'rank_math_search_intent', [] );
		if ( is_null( $intent ) ) {
			return $stored_search_intent;
		}

		$stored_search_intent = array_merge( $stored_search_intent, $intent );

		update_option( 'rank_math_search_intent', $stored_search_intent, false );

		return $stored_search_intent;
	}

	/**
	 * Check if current user can install the imgagify plugin.
	 *
	 * @return boolean
	 */
	public static function can_activate_imagify() {
		return ! defined( 'IMAGIFY_VERSION' ) && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' );
	}

	/**
	 * Check if AI traffic only is enabled.
	 */
	public static function ai_traffic_enabled() {
		return isset( $_COOKIE['rank_math_analytics_ai_only'] ) && 'true' === sanitize_text_field( wp_unslash( $_COOKIE['rank_math_analytics_ai_only'] ) );
	}

	/**
	 * Get terms from the provided taxonomy.
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param array  $selected Selected values.
	 * @param string $search   Searched term.
	 * @return array
	 */
	public static function get_taxonomy_terms( $taxonomy, $selected = [], $search = '' ) {
		$args = [
			'taxonomy' => $taxonomy,
			'search'   => $search,
			'fields'   => 'id=>name',
			'number'   => 10,
		];

		if ( ! empty( $selected ) ) {
			$args['include'] = $selected;
			unset( $args['number'] );
		}

		$terms = get_terms( $args );
		if ( empty( $terms ) ) {
			return [];
		}

		$data = [];
		foreach ( $terms as $id => $name ) {
			$data[] = [
				'value' => $id,
				'name'  => $name,
			];
		}

		return $data;
	}

	/**
	 * Get exclude terms data for settings based on selected post types.
	 *
	 * @param string $setting_prefix      The setting prefix (e.g., 'news_sitemap' or 'keyword_maps').
	 * @param array  $excluded_post_types Array of excluded post types.
	 * @param string $settings_section    The settings section (e.g., 'general' or 'sitemap').
	 * @return array
	 */
	public static function get_exclude_terms_for_settings( $setting_prefix, $excluded_post_types = [], $settings_section = 'general' ) {
		// Get all public post types, excluding attachment and any excluded post types.
		$all_post_types = get_post_types( [ 'public' => true ], 'names' );
		$post_types     = array_diff( $all_post_types, $excluded_post_types, [ 'attachment' ] );

		if ( empty( $post_types ) ) {
			return [];
		}

		$exclude_terms = [];
		foreach ( $post_types as $post_type ) {
			$taxonomies = Helper::get_object_taxonomies( $post_type, 'objects' );
			if ( empty( $taxonomies ) ) {
				continue;
			}

			$terms = Helper::get_settings( "{$settings_section}.{$setting_prefix}_exclude_{$post_type}_terms", [] );

			$post_type_obj   = get_post_type_object( $post_type );
			$post_type_label = $post_type_obj->labels->singular_name;

			foreach ( $taxonomies as $taxonomy => $data ) {
				if ( empty( $data->show_ui ) ) {
					continue;
				}

				$selected = [];
				if ( isset( $terms[ $taxonomy ] ) ) {
					$selected = $terms[ $taxonomy ];
				}

				if ( isset( $terms[0] ) && isset( $terms[0][ $taxonomy ] ) ) {
					$selected = $terms[0][ $taxonomy ];
				}

				$taxonomy_terms = self::get_taxonomy_terms( $taxonomy, $selected );
				if ( empty( $taxonomy_terms ) ) {
					continue;
				}

				$exclude_terms[ $post_type ][ $taxonomy ] = $taxonomy_terms;
			}
		}

		// Ensure we return an object in JSON, not an array.
		return ! empty( $exclude_terms ) ? $exclude_terms : (object) [];
	}
}
