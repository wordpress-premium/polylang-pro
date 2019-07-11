jQuery( document ).ready( function( $ ) {
	var fields = new Array();
	$( '.acf-field-relationship' ).each( function(){
		var field = $( this ).attr( 'data-key' );
		fields.push( field );
	});

	$( '.acf-field-taxonomy' ).each( function(){
		var field = $( this ).attr( 'data-key' );
		fields.push( field );
	});

	if ( 0 != fields.length ) {
		// ajax for changing the post's language in the languages metabox
		$( '.post_lang_choice' ).change( function() {
			var data = {
				action:     'acf_post_lang_choice',
				lang:       $( this ).val(),
				fields:     fields,
				_pll_nonce: $( '#_pll_nonce' ).val()
			}

			$.post( ajaxurl, data , function( response ) {
				var res = wpAjax.parseAjaxResponse( response, 'ajax-response' );
				$.each( res.responses, function() {
					$el = $( '.acf-' + this.what )
					$el.html( this.data );
					acf.do_action( 'ready_field/type=' + $el.data( 'type' ), $el );
				});
			});
		});
	}
});
