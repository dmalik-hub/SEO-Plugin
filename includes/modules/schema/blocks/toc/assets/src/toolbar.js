/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { BlockControls } from '@wordpress/block-editor'
import {
	Toolbar,
	ToolbarButton,
} from '@wordpress/components'
import { formatListBullets, formatListNumbered, alignLeft } from '@wordpress/icons'

export default ( { setAttributes } ) => {
	return (
		<BlockControls>
			<Toolbar label={ __( 'Table of Content Options', 'gohigh-seo' ) }>
				<ToolbarButton
					icon={ formatListBullets }
					label={ __( 'Unordered List', 'gohigh-seo' ) }
					onClick={ () => setAttributes( { listStyle: 'ul' } ) }
				/>
				<ToolbarButton
					icon={ formatListNumbered }
					label={ __( 'Ordered List', 'gohigh-seo' ) }
					onClick={ () => setAttributes( { listStyle: 'ol' } ) }
				/>
				<ToolbarButton
					icon={ alignLeft }
					label={ __( 'None', 'gohigh-seo' ) }
					onClick={ () => setAttributes( { listStyle: 'div' } ) }
				/>
			</Toolbar>
		</BlockControls>
	)
}
