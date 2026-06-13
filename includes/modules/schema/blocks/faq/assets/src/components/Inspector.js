/**
 * External dependencies
 */
import { map } from 'lodash'

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { withSelect } from '@wordpress/data'
import { InspectorControls } from '@wordpress/block-editor'
import { PanelBody, SelectControl, TextControl } from '@wordpress/components'

/**
 * Format array of image sizes.
 *
 * @param  {Array} imageSizes Array of image sizes.
 * @return {Array} Formatted array.
 */
const getImageSizeOptions = ( imageSizes ) => {
	return map( imageSizes, ( { name, slug } ) => ( {
		value: slug,
		label: name,
	} ) )
}

/**
 * Adds controls to the editor sidebar to control params.
 *
 * @param {Object} props This component's props.
 */
const Inspector = ( { imageSizes, attributes, setAttributes } ) => {
	const imageSizeOptions = getImageSizeOptions( imageSizes )

	return (
		<InspectorControls key={ 'inspector' }>
			<PanelBody title={ __( 'FAQ Options', 'gohigh-seo' ) }>
				<SelectControl
					label={ __( 'List Style', 'gohigh-seo' ) }
					value={ attributes.listStyle }
					options={ [
						{
							value: '',
							label: __( 'None', 'gohigh-seo' ),
						},
						{
							value: 'numbered',
							label: __( 'Numbered', 'gohigh-seo' ),
						},
						{
							value: 'unordered',
							label: __( 'Unordered', 'gohigh-seo' ),
						},
					] }
					onChange={ ( listStyle ) => {
						setAttributes( { listStyle } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>

				<SelectControl
					label={ __( 'Title Wrapper', 'gohigh-seo' ) }
					value={ attributes.titleWrapper }
					options={ [
						{ value: 'h2', label: __( 'H2', 'gohigh-seo' ) },
						{ value: 'h3', label: __( 'H3', 'gohigh-seo' ) },
						{ value: 'h4', label: __( 'H4', 'gohigh-seo' ) },
						{ value: 'h5', label: __( 'H5', 'gohigh-seo' ) },
						{ value: 'h6', label: __( 'H6', 'gohigh-seo' ) },
						{ value: 'p', label: __( 'P', 'gohigh-seo' ) },
						{ value: 'div', label: __( 'DIV', 'gohigh-seo' ) },
					] }
					onChange={ ( titleWrapper ) => {
						setAttributes( { titleWrapper } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>

				<SelectControl
					label={ __( 'Image Size', 'gohigh-seo' ) }
					value={ attributes.sizeSlug }
					options={ imageSizeOptions }
					onChange={ ( sizeSlug ) => {
						setAttributes( { sizeSlug } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>
			</PanelBody>

			<PanelBody title={ __( 'Styling Options', 'gohigh-seo' ) }>
				<TextControl
					label={ __( 'Title Wrapper CSS Class(es)', 'gohigh-seo' ) }
					value={ attributes.titleCssClasses }
					onChange={ ( titleCssClasses ) => {
						setAttributes( { titleCssClasses } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>

				<TextControl
					label={ __( 'Content Wrapper CSS Class(es)', 'gohigh-seo' ) }
					value={ attributes.contentCssClasses }
					onChange={ ( contentCssClasses ) => {
						setAttributes( { contentCssClasses } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>

				<TextControl
					label={ __( 'List CSS Class(es)', 'gohigh-seo' ) }
					value={ attributes.listCssClasses }
					onChange={ ( listCssClasses ) => {
						setAttributes( { listCssClasses } )
					} }
					__next40pxDefaultSize={ true }
					__nextHasNoMarginBottom={ true }
				/>
			</PanelBody>
		</InspectorControls>
	)
}

export default withSelect( ( select, props ) => {
	const { getSettings } = select( 'core/block-editor' )
	const { imageSizes } = getSettings()

	return {
		...props,
		imageSizes,
	}
} )( Inspector )
