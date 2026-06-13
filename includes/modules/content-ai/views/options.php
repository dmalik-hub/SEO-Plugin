<?php
/**
 * Content AI general settings.
 *
 * @package    RankMath
 * @subpackage RankMath\ContentAI
 */

use GoHighSEO\Helper;
use GoHighSEO\KB;
use GoHighSEO\Admin\Admin_Helper;

defined( 'ABSPATH' ) || exit;

if ( ! Helper::is_site_connected() ) {
	$cmb->add_field(
		[
			'id'      => 'rank_math_content_ai_settings',
			'type'    => 'raw',
			'content' => '<div id="setting-panel-content-ai" class="rank-math-tab rank-math-options-panel-content exclude">
				<div class="wp-core-ui rank-math-ui connect-wrap">
					<a href="' . Admin_Helper::get_activate_url( Helper::get_settings_url( 'general', 'content-ai' ) ) . '" class="button button-primary button-connect button-animated" name="rank_math_activate">'
					. esc_html__( 'Connect Your Rank Math Account', 'gohigh-seo' )
					. '</a>
				</div>
				<div id="gohigh-seo-cta" class="content-ai-settings">
					<div class="rank-math-cta-box width-100 no-shadow no-padding no-border">
						<h3>' . esc_html__( 'Benefits of Connecting Rank Math Account', 'gohigh-seo' ) . '</h3>
						<ul>
							<li>' . esc_html__( 'Gain Access to 40+ Advanced AI Tools.', 'gohigh-seo' ) . '</li>
							<li>' . esc_html__( 'Experience the Revolutionary AI-Powered Content Editor.', 'gohigh-seo' ) . '</li>
							<li>' . esc_html__( 'Engage with RankBot, Our AI Chatbot, For SEO Advice.', 'gohigh-seo' ) . '</li>
							<li>' . esc_html__( 'Escape the Writer\'s Block Using AI to Write Inside WordPress.', 'gohigh-seo' ) . '</li>
						</ul>
					</div>
				</div>
			</div>',
		]
	);
	return;
}

$cmb->add_field(
	[
		'id'      => 'content_ai_country',
		'type'    => 'select',
		'name'    => esc_html__( 'Default Country', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Content AI tailors keyword research to the target country for highly relevant suggestions. You can override this in individual posts/pages/CPTs.', 'gohigh-seo' ),
		'options' => Helper::choices_contentai_countries(),
		'default' => 'all',
	]
);

$cmb->add_field(
	[
		'id'         => 'content_ai_tone',
		'type'       => 'select',
		'name'       => esc_html__( 'Default Tone', 'gohigh-seo' ),
		'desc'       => esc_html__( 'This feature enables the default primary tone or writing style that characterizes your content. You can override this in individual tools.', 'gohigh-seo' ),
		'default'    => 'Formal',
		'attributes' => ( 'data-s2' ),
		'options'    => [
			'Analytical'     => esc_html__( 'Analytical', 'gohigh-seo' ),
			'Argumentative'  => esc_html__( 'Argumentative', 'gohigh-seo' ),
			'Casual'         => esc_html__( 'Casual', 'gohigh-seo' ),
			'Conversational' => esc_html__( 'Conversational', 'gohigh-seo' ),
			'Creative'       => esc_html__( 'Creative', 'gohigh-seo' ),
			'Descriptive'    => esc_html__( 'Descriptive', 'gohigh-seo' ),
			'Emotional'      => esc_html__( 'Emotional', 'gohigh-seo' ),
			'Empathetic'     => esc_html__( 'Empathetic', 'gohigh-seo' ),
			'Expository'     => esc_html__( 'Expository', 'gohigh-seo' ),
			'Factual'        => esc_html__( 'Factual', 'gohigh-seo' ),
			'Formal'         => esc_html__( 'Formal', 'gohigh-seo' ),
			'Friendly'       => esc_html__( 'Friendly', 'gohigh-seo' ),
			'Humorous'       => esc_html__( 'Humorous', 'gohigh-seo' ),
			'Informal'       => esc_html__( 'Informal', 'gohigh-seo' ),
			'Journalese'     => esc_html__( 'Journalese', 'gohigh-seo' ),
			'Narrative'      => esc_html__( 'Narrative', 'gohigh-seo' ),
			'Objective'      => esc_html__( 'Objective', 'gohigh-seo' ),
			'Opinionated'    => esc_html__( 'Opinionated', 'gohigh-seo' ),
			'Persuasive'     => esc_html__( 'Persuasive', 'gohigh-seo' ),
			'Poetic'         => esc_html__( 'Poetic', 'gohigh-seo' ),
			'Satirical'      => esc_html__( 'Satirical', 'gohigh-seo' ),
			'Story-telling'  => esc_html__( 'Story-telling', 'gohigh-seo' ),
			'Subjective'     => esc_html__( 'Subjective', 'gohigh-seo' ),
			'Technical'      => esc_html__( 'Technical', 'gohigh-seo' ),
		],
	],
);

$cmb->add_field(
	[
		'id'         => 'content_ai_audience',
		'type'       => 'select',
		'name'       => esc_html__( 'Default Audience', 'gohigh-seo' ),
		'desc'       => esc_html__( 'This option lets you set the default audience that usually reads your content. You can override this in individual tools.', 'gohigh-seo' ),
		'default'    => 'General Audience',
		'attributes' => ( 'data-s2' ),
		'options'    => [
			'Activists'                => esc_html__( 'Activists', 'gohigh-seo' ),
			'Artists'                  => esc_html__( 'Artists', 'gohigh-seo' ),
			'Authors'                  => esc_html__( 'Authors', 'gohigh-seo' ),
			'Bargain Hunters'          => esc_html__( 'Bargain Hunters', 'gohigh-seo' ),
			'Bloggers'                 => esc_html__( 'Bloggers', 'gohigh-seo' ),
			'Business Owners'          => esc_html__( 'Business Owners', 'gohigh-seo' ),
			'Collectors'               => esc_html__( 'Collectors', 'gohigh-seo' ),
			'Cooks'                    => esc_html__( 'Cooks', 'gohigh-seo' ),
			'Crafters'                 => esc_html__( 'Crafters', 'gohigh-seo' ),
			'Dancers'                  => esc_html__( 'Dancers', 'gohigh-seo' ),
			'DIYers'                   => esc_html__( 'DIYers', 'gohigh-seo' ),
			'Designers'                => esc_html__( 'Designers', 'gohigh-seo' ),
			'Educators'                => esc_html__( 'Educators', 'gohigh-seo' ),
			'Engineers'                => esc_html__( 'Engineers', 'gohigh-seo' ),
			'Entrepreneurs'            => esc_html__( 'Entrepreneurs', 'gohigh-seo' ),
			'Environmentalists'        => esc_html__( 'Environmentalists', 'gohigh-seo' ),
			'Fashionistas'             => esc_html__( 'Fashionistas', 'gohigh-seo' ),
			'Fitness Enthusiasts'      => esc_html__( 'Fitness Enthusiasts', 'gohigh-seo' ),
			'Foodies'                  => esc_html__( 'Foodies', 'gohigh-seo' ),
			'Gaming Enthusiasts'       => esc_html__( 'Gaming Enthusiasts', 'gohigh-seo' ),
			'Gardeners'                => esc_html__( 'Gardeners', 'gohigh-seo' ),
			'General Audience'         => esc_html__( 'General Audience', 'gohigh-seo' ),
			'Health Enthusiasts'       => esc_html__( 'Health Enthusiasts', 'gohigh-seo' ),
			'Healthcare Professionals' => esc_html__( 'Healthcare Professionals', 'gohigh-seo' ),
			'Indoor Hobbyists'         => esc_html__( 'Indoor Hobbyists', 'gohigh-seo' ),
			'Investors'                => esc_html__( 'Investors', 'gohigh-seo' ),
			'Job Seekers'              => esc_html__( 'Job Seekers', 'gohigh-seo' ),
			'Movie Buffs'              => esc_html__( 'Movie Buffs', 'gohigh-seo' ),
			'Musicians'                => esc_html__( 'Musicians', 'gohigh-seo' ),
			'Outdoor Enthusiasts'      => esc_html__( 'Outdoor Enthusiasts', 'gohigh-seo' ),
			'Parents'                  => esc_html__( 'Parents', 'gohigh-seo' ),
			'Pet Owners'               => esc_html__( 'Pet Owners', 'gohigh-seo' ),
			'Photographers'            => esc_html__( 'Photographers', 'gohigh-seo' ),
			'Podcast Listeners'        => esc_html__( 'Podcast Listeners', 'gohigh-seo' ),
			'Professionals'            => esc_html__( 'Professionals', 'gohigh-seo' ),
			'Retirees'                 => esc_html__( 'Retirees', 'gohigh-seo' ),
			'Russian'                  => esc_html__( 'Russian', 'gohigh-seo' ),
			'Seniors'                  => esc_html__( 'Seniors', 'gohigh-seo' ),
			'Social Media Users'       => esc_html__( 'Social Media Users', 'gohigh-seo' ),
			'Sports Fans'              => esc_html__( 'Sports Fans', 'gohigh-seo' ),
			'Students'                 => esc_html__( 'Students', 'gohigh-seo' ),
			'Tech Enthusiasts'         => esc_html__( 'Tech Enthusiasts', 'gohigh-seo' ),
			'Travelers'                => esc_html__( 'Travelers', 'gohigh-seo' ),
			'TV Enthusiasts'           => esc_html__( 'TV Enthusiasts', 'gohigh-seo' ),
			'Video Creators'           => esc_html__( 'Video Creators', 'gohigh-seo' ),
			'Writers'                  => esc_html__( 'Writers', 'gohigh-seo' ),
		],
	],
);

$cmb->add_field(
	[
		'id'         => 'content_ai_language',
		'type'       => 'select',
		'name'       => esc_html__( 'Default Language', 'gohigh-seo' ),
		'desc'       => esc_html__( 'This option lets you set the default language for content generated using Content AI. You can override this in individual tools.', 'gohigh-seo' ),
		'default'    => Helper::content_ai_default_language(),
		'attributes' => ( 'data-s2' ),
		'options'    => [
			'US English' => esc_html__( 'US English', 'gohigh-seo' ),
			'UK English' => esc_html__( 'UK English', 'gohigh-seo' ),
			'Arabic'     => esc_html__( 'Arabic', 'gohigh-seo' ),
			'Bulgarian'  => esc_html__( 'Bulgarian', 'gohigh-seo' ),
			'Chinese'    => esc_html__( 'Chinese', 'gohigh-seo' ),
			'Czech'      => esc_html__( 'Czech', 'gohigh-seo' ),
			'Danish'     => esc_html__( 'Danish', 'gohigh-seo' ),
			'Dutch'      => esc_html__( 'Dutch', 'gohigh-seo' ),
			'Estonian'   => esc_html__( 'Estonian', 'gohigh-seo' ),
			'Finnish'    => esc_html__( 'Finnish', 'gohigh-seo' ),
			'French'     => esc_html__( 'French', 'gohigh-seo' ),
			'German'     => esc_html__( 'German', 'gohigh-seo' ),
			'Greek'      => esc_html__( 'Greek', 'gohigh-seo' ),
			'Hebrew'     => esc_html__( 'Hebrew', 'gohigh-seo' ),
			'Hungarian'  => esc_html__( 'Hungarian', 'gohigh-seo' ),
			'Indonesian' => esc_html__( 'Indonesian', 'gohigh-seo' ),
			'Italian'    => esc_html__( 'Italian', 'gohigh-seo' ),
			'Japanese'   => esc_html__( 'Japanese', 'gohigh-seo' ),
			'Korean'     => esc_html__( 'Korean', 'gohigh-seo' ),
			'Latvian'    => esc_html__( 'Latvian', 'gohigh-seo' ),
			'Lithuanian' => esc_html__( 'Lithuanian', 'gohigh-seo' ),
			'Norwegian'  => esc_html__( 'Norwegian', 'gohigh-seo' ),
			'Polish'     => esc_html__( 'Polish', 'gohigh-seo' ),
			'Portuguese' => esc_html__( 'Portuguese', 'gohigh-seo' ),
			'Romanian'   => esc_html__( 'Romanian', 'gohigh-seo' ),
			'Russian'    => esc_html__( 'Russian', 'gohigh-seo' ),
			'Slovak'     => esc_html__( 'Slovak', 'gohigh-seo' ),
			'Slovenian'  => esc_html__( 'Slovenian', 'gohigh-seo' ),
			'Spanish'    => esc_html__( 'Spanish', 'gohigh-seo' ),
			'Swedish'    => esc_html__( 'Swedish', 'gohigh-seo' ),
			'Turkish'    => esc_html__( 'Turkish', 'gohigh-seo' ),
		],
	],
);

$post_types = Helper::choices_post_types();
if ( isset( $post_types['attachment'] ) ) {
	unset( $post_types['attachment'] );
}

$cmb->add_field(
	[
		'id'      => 'content_ai_post_types',
		'type'    => 'multicheck_inline',
		'name'    => esc_html__( 'Select Post Type', 'gohigh-seo' ),
		'desc'    => esc_html__( 'Choose the type of posts/pages/CPTs where you want to use Content AI.', 'gohigh-seo' ),
		'options' => $post_types,
		'default' => array_keys( $post_types ),
	]
);

$credits = Helper::get_credits();
if ( Helper::is_site_connected() && false !== $credits ) {
	$update_credits = '<a href="#" class="rank-math-tooltip update-credit">
		<i class="dashicons dashicons-image-rotate"></i>
		<span>' . esc_html__( 'Click to refresh the available credits.', 'gohigh-seo' ) . '</span>
	</a>';

	$refresh_date = Helper::get_content_ai_refresh_date();
	$cmb->add_field(
		[
			'id'      => 'content_ai_credits',
			'type'    => 'raw',
			/* translators: 1. Credits left 2. Buy more credits link */
			'content' => '<div class="cmb-row buy-more-credits rank-math-exclude-from-search">' . $update_credits . sprintf( esc_html__( '%1$s credits left this month. Credits will renew on %2$s or you can upgrade to get more credits %3$s.', 'gohigh-seo' ), '<strong>' . $credits . '</strong>', wp_date( 'Y-m-d g:i a', $refresh_date ), '<a href="' . KB::get( 'content-ai-pricing-tables', 'Buy CAI Credits Options Panel' ) . '" target="_blank">' . esc_html__( 'here', 'gohigh-seo' ) . '</a>' ) . '</div>',
		]
	);
}
