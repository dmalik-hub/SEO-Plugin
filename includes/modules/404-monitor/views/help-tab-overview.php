<?php
/**
 * 404 Monitor inline help: "Overview" tab.
 *
 * @package    RankMath
 * @subpackage RankMath\Monitor
 */

use GoHighSEO\KB;

defined( 'ABSPATH' ) || exit;

?>

<p>
	<?php esc_html_e( 'With the 404 monitor you can see where users and search engines are unable to find your content.', 'gohigh-seo' ); ?>
</p>

<p>
	<?php esc_html_e( 'Knowledge Base Articles:', 'gohigh-seo' ); ?>
</p>

<ul>
	<li>
		<a href="<?php echo esc_url( KB::get( '404-monitor', '404 Monitor Help Toggle' ) ); ?>" target="_blank">
			<?php esc_html_e( '404 Monitor', 'gohigh-seo' ); ?>
</a>
	</li>
	<li>
		<a href="<?php echo esc_url( KB::get( '404-monitor-settings', '404 Monitor Help Toggle' ) ); ?>" target="_blank">
			<?php esc_html_e( '404 Monitor Settings', 'gohigh-seo' ); ?>
</a>
	</li>
	<li>
		<a href="<?php echo esc_url( KB::get( 'fix-404', '404 Monitor Help Toggle Fix link' ) ); ?>" target="_blank">
			<?php esc_html_e( 'Fix 404 Errors', 'gohigh-seo' ); ?>
</a>
	</li>
</ul>
