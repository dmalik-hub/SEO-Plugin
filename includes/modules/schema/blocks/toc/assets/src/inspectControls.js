/**
 * External dependencies
 */
import { map, includes, toUpper } from 'lodash'

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { InspectorControls } from '@wordpress/block-editor'
import {
	PanelBody,
	SelectControl,
	CheckboxControl,
} from '@wordpress/components'

export default ( { attributes, setAttributes, excludeHeadings, setExcludeHeadings } ) => {
	return (
		<InspectorControls>
			<PanelBody title={ __( 'Settings', 'gohigh-seo' ) }>

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

				<br />
				<h3>{ __( 'Exclude Headings', 'gohigh-seo' ) }</h3>
				<div className="rank-math-toc-exclude-headings">
					{
						map( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ], ( value ) => {
							return (
								<CheckboxControl
									key={ value }
									label={ __( 'Heading ', 'gohigh-seo' ) + toUpper( value ) }
									checked={ includes( excludeHeadings, value ) }
									onChange={ ( newVlaue ) => setExcludeHeadings( value, newVlaue ) }
									__nextHasNoMarginBottom={ true }
								/>
							)
						} )
					}
				</div>
			</PanelBody>
		</InspectorControls>
	)
}
