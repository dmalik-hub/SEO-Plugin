<?php
/**
 * Analytics Report header template.
 *
 * @package    RankMath
 * @subpackage RankMath\Admin
 */

use GoHighSEO\KB;

defined( 'ABSPATH' ) || exit;

?>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="cta">
	<tbody>
		<tr class="top">
			<td align="left">
				<a href="<?php KB::the( 'seo-email-reporting', 'Email Report CTA' ); ?>"><?php $this->image( 'gohigh-seo.jpg', 540, 422, __( 'Rank Math PRO', 'gohigh-seo' ) ); ?></a>
			</td>
		</tr>
	</tbody>
</table>
