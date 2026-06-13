/**
 * Internal dependencies
 */
import ErrorCTA from '@components/ErrorCTA'

const BulkUpdate = () => {
	const imagesUrl = window.rankMath.links?.imagesUrl || ''

	return (
		<div className="gohigh-seo-tab-preview">
			<img src={ imagesUrl + 'bulk-update.jpg' } alt="" />
			<ErrorCTA showProNotice={ true } width="width-50" medium="Bulk+Update" />
		</div>
	)
}

export default BulkUpdate
