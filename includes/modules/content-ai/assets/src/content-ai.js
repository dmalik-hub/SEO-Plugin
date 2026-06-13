/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { addFilter } from '@wordpress/hooks'

addFilter( 'rank_math_content_ai_credits_notice', 'gohigh-seo', () => {
	return __( 'You have reached the monthly limit for this feature. Please contact your SEO service provider to get more usage.', 'gohigh-seo' )
} )

addFilter( 'rank_math_content_ai_usage_features', 'gohigh-seo', ( features ) => {
	return [
		...features,
		{ key: 'suggest_link_opportunities', label: __( 'Link Opportunities', 'gohigh-seo' ) },
		{ key: 'related_posts', label: __( 'Related Posts', 'gohigh-seo' ) },
		{ key: 'suggest_links', label: __( 'Link Suggestions', 'gohigh-seo' ) },
	]
} )
