/**
 * WordPress dependencies.
 */
import apiFetch from '@wordpress/api-fetch';

document.addEventListener( 'onPostLangChoice', ( e ) => {
	const fields = [];

	// Adds relationship fields to the fields to be refreshed.
	const relationshipFields = document.querySelectorAll(
		'.acf-field-relationship'
	);
	relationshipFields.forEach( function ( relationshipField ) {
		const field = relationshipField.getAttribute( 'data-key' );
		fields.push( field );
	} );

	// Adds post object fields to the fields to be refreshed.
	const postObjectFields = document.querySelectorAll(
		'.acf-field-post-object'
	);
	postObjectFields.forEach( function ( postObjectField ) {
		const field = postObjectField.getAttribute( 'data-key' );
		fields.push( field );
	} );

	// Adds taxonomy fields to the fields to be refreshed.
	const taxonomyFields = document.querySelectorAll( '.acf-field-taxonomy' );
	taxonomyFields.forEach( function ( taxonomyField ) {
		const field = taxonomyField.getAttribute( 'data-key' );
		fields.push( field );
	} );

	if ( 0 < fields.length ) {
		const postId = document
			.getElementById( 'post_ID' )
			.getAttribute( 'value' );

		let nonce = document.querySelector( '#_pll_nonce' )?.value; // Classic editor.
		if ( undefined === nonce ) {
			// Block editor.
			nonce = pll_block_editor_plugin_settings.nonce;
		}
		const data = new FormData();
		data.set( 'action', 'acf_post_lang_choice' );
		data.set( 'lang', encodeURI( e.detail.lang.slug ) );
		data.set( 'fields', fields );
		data.set( 'post_id', postId );
		data.set( '_pll_nonce', nonce );

		apiFetch( {
			url: ajaxurl,
			method: 'POST',
			body: data,
		} ).then( ( response ) => {
			response.forEach( function ( res ) {
				// Data comes from ACF field and server side.
				const field = document.querySelector( '.acf-' + res.field_key );

				field.outerHTML = res.field_data;
				acf.do_action(
					'ready_field/type=' + field.getAttribute( 'data-type' ),
					field
				);
			} );

			if ( 0 < relationshipFields.length ) {
				// We need to reload the choices list for relationship fields (otherwise it remains empty).
				relationshipFields.forEach( function ( relationshipField ) {
					acf.getField(
						relationshipField.getAttribute( 'data-key' )
					).fetch();
				} );
			}

			// Reloads the list of posts in `post_object` fields.
			acf.getFields( { type: 'post_object' } );
		} );
	}
} );
