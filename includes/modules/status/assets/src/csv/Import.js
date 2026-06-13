/* global confirm, ajaxurl */
/**
 * External Dependencies
 */
import jQuery from 'jquery'
import { isEmpty } from 'lodash'

/**
 * WordPress Dependencies
 */
import { __, sprintf } from '@wordpress/i18n'
import apiFetch from '@wordpress/api-fetch'
import { FormFileUpload } from '@wordpress/components'
import { useState, useEffect } from '@wordpress/element'

/**
 * Internal Dependencies
 */
import { Button, CheckboxControl, Notice } from '@rank-math/components'

const refreshProgress = ( setProgress ) => {
	jQuery.ajax( {
		url: ajaxurl,
		type: 'GET',
		dataType: 'html',
		data: { action: 'csv_import_progress', _ajax_nonce: rankMath.csvProgressNonce },
	} )
		.done( ( data ) => {
			setProgress(
				{
					status: 'processing',
					content: data,
				}
			)
			if ( jQuery( data ).find( '#csv-import-progress-value' ).length ) {
				setTimeout( () => ( refreshProgress( setProgress ) ), 3000 )
			} else {
				setProgress(
					{
						status: 'completed',
						content: data,
					}
				)
			}
		} )
}

/**
 * Import Rank Math settings.
 */
export default ( { data } ) => {
	const [ importFile, setImportFile ] = useState( false )
	const [ noOverwrite, setOverwrite ] = useState( true )
	const [ importProgress, setProgress ] = useState( data.importProgress )

	useEffect( () => {
		if ( ! isEmpty( importProgress ) ) {
			refreshProgress( setProgress )
		}
	}, [] )

	return (
		<div
			id="rank-math-import-form"
			className="rank-math-import-csv-form field-form"
		>
			{
				isEmpty( importProgress ) &&
				<>
					<div>
						<label htmlFor="csv-import-me">
							<strong>{ __( 'CSV File', 'gohigh-seo' ) }</strong>
						</label>
					</div>

					<div>
						<FormFileUpload
							accept=".csv"
							onChange={ ( event ) => setImportFile( event.currentTarget.files[ 0 ] ) }
							__next40pxDefaultSize
							__nextHasNoMarginBottom
						>
							<span className="import-file-button">{ __( 'Choose File', 'gohigh-seo' ) }</span>
							{ importFile && <span>{ importFile.name }</span> }
						</FormFileUpload>
						<br />
						<span className="validation-message">
							{ __( 'Please select a file to import.', 'gohigh-seo' ) }
						</span>
					</div>

					<div>
						<CheckboxControl
							label={ __( 'Do not overwrite existing data', 'gohigh-seo' ) }
							help={ __( 'Check this to import meta fields only if their current meta value is empty.', 'gohigh-seo' ) }
							checked={ noOverwrite }
							onChange={ setOverwrite }
						/>
					</div>

					{
						importFile &&
						<div>
							<Notice status="warning" className="notice-connect-disabled">
								<span
									dangerouslySetInnerHTML={ {
										__html: sprintf(
											// Translators: Bold text.
											__(
												'%s It is recommended to save a database backup before using this option because importing malformed CSV can result in loss of data.',
												'gohigh-seo'
											),
											`<strong>${ __( 'Warning:', 'gohigh-seo' ) }</strong>`,
										),
									} }
								/>
							</Notice>
						</div>
					}
				</>
			}
			{
				! isEmpty( importProgress ) &&
				<div id="csv-import-progress-details">
					<span
						dangerouslySetInnerHTML={ {
							__html: importProgress.content,
						} }
					/>
				</div>
			}
			<footer>
				{
					isEmpty( importProgress ) &&
					<Button
						variant="primary"
						disabled={ importFile === false }
						onClick={ () => {
							// eslint-disable-next-line no-alert
							if ( ! confirm( __( 'Are you sure you want to import meta data from this CSV file?', 'gohigh-seo' ) ) ) {
								return
							}

							setProgress(
								{
									status: 'processing',
									content: __( 'Import process has started, this may take a few moments to complete.', 'gohigh-seo' ),
								}
							)

							const formData = new FormData()
							formData.append( 'csv-import-me', importFile )
							formData.append( 'no_overwrite', noOverwrite )

							apiFetch( {
								method: 'POST',
								headers: {},
								path: '/rankmath/v1/importCSV',
								body: formData,
							} )
								.catch( ( error ) => {
									alert( error.message )
								} )
								.then( ( response ) => {
									if ( ! response || ! response.success ) {
										setProgress( {} )
										alert( response.message )
										return
									}

									setImportFile( false )
									if ( ! response.success ) {
										alert( response.message )
										return
									}

									setProgress(
										{
											status: 'processing',
											content: response.message,
										}
									)
									setTimeout( () => ( refreshProgress( setProgress ) ), 3000 )
								} )
						} }
					>
						{ __( 'Import', 'gohigh-seo' ) }
					</Button>
				}
				{
					! isEmpty( importProgress ) && importProgress.status !== 'completed' &&
					<>
						<Button
							isDestructive={ true }
							className="button-link-delete csv-import-cancel"
							onClick={ () => {
								// eslint-disable-next-line no-alert
								if ( ! confirm( __( 'Are you sure you want to stop the import process?', 'gohigh-seo' ) ) ) {
									return
								}

								apiFetch( {
									method: 'POST',
									headers: {},
									path: '/rankmath/v1/cancelCsvImport',
								} )
									.catch( ( error ) => {
										alert( error.message )
									} )
									.then( ( response ) => {
										if ( response.type === 'error' ) {
											setProgress(
												{
													status: 'error',
													content: response.message,
												}
											)
											setTimeout( () => ( refreshProgress( setProgress ) ), 3000 )
											return
										}

										setProgress( {} )
									} )
							} }
						>
							{ __( 'Cancel Import', 'gohigh-seo' ) }
						</Button>
						<span className="input-loading"></span>
					</>
				}
			</footer>
		</div>
	)
}
