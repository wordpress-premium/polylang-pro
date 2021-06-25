/******/ "use strict";
/******/ var __webpack_modules__ = ({

/***/ 176:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* unused harmony exports initializeConfimationModal, initializeLanguageOldValue */
/**
 * @package Polylang
 */

const languagesList = jQuery( '.post_lang_choice' );

// Dialog box for alerting the user about a risky changing.
const initializeConfimationModal = () => {
	// We can't use underscore or lodash in this common code because it depends of the context classic or block editor.
	// Classic editor underscore is loaded, Block editor lodash is loaded.
	const { __ } = wp.i18n;

	// Create dialog container.
	const dialogContainer = jQuery(
		'<div/>',
		{
			id: 'pll-dialog',
			style: 'display:none;'
		}
	).text( __( 'Are you sure you want to change the language of the current content?', 'polylang' ) );

	// Put it after languages list dropdown.
	// PHPCS ignore dialogContainer is a new safe HTML code generated above.
	languagesList.after( dialogContainer ); // phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.after

	const dialogResult = new Promise(
		( confirm, cancel ) => {
			const confirmDialog = ( what ) => { // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent
				switch ( what ) { // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent
					case 'yes':
						// Confirm the new language.
						languagesList.data( 'old-value', languagesList.children( ':selected' ).first().val() );
						confirm();
						break;
					case 'no':
						// Revert to the old language.
						languagesList.val( languagesList.data( 'old-value' ) );
						cancel( 'Cancel' );
						break;
				}
				dialogContainer.dialog( 'close' ); // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent
			} // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent

			// Initialize dialog box in the case a language is selected but not added in the list.
			const dialogOptions = {
				autoOpen: false,
				modal: true,
				draggable: false,
				resizable: false,
				title: __( 'Change language', 'polylang' ),
				minWidth: 600,
				maxWidth: '100%',
				open: function( event, ui ) {
					// Change dialog box position for rtl language
					if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
						jQuery( this ).parent().css(
							{
								right: jQuery( this ).parent().css( 'left' ),
								left: 'auto'
							}
						);
					}
				},
				close: function( event, ui ) {
					// When we're closing the dialog box we need to cancel the language change as we click on Cancel button.
					confirmDialog( 'no' );
				},
				buttons: [
					{
						text: __( 'OK', 'polylang' ),
						click: function( event ) {
							confirmDialog( 'yes' );
						}
					},
					{
						text: __( 'Cancel', 'polylang' ),
						click: function( event ) {
							confirmDialog( 'no' );
						}
					}
				]
			};

			if ( jQuery.ui.version >= '1.12.0' ) {
				Object.assign( dialogOptions, { classes: { 'ui-dialog': 'pll-confirmation-modal' } } );
			} else {
			Object.assign( dialogOptions, { dialogClass: 'pll-confirmation-modal' } ); // jQuery UI 1.11.4 - WP < 5.6
			}

			dialogContainer.dialog( dialogOptions );
		}
	);
	return { dialogContainer, dialogResult };
}

const initializeLanguageOldValue = () => {
	// Keep the old language value to be able to compare to the new one and revert to it if necessary.
	languagesList.attr( 'data-old-value', languagesList.children( ':selected' ).first().val() );
};


/***/ })

/******/ });
/************************************************************************/
/******/ // The module cache
/******/ var __webpack_module_cache__ = {};
/******/ 
/******/ // The require function
/******/ function __webpack_require__(moduleId) {
/******/ 	// Check if module is in cache
/******/ 	if(__webpack_module_cache__[moduleId]) {
/******/ 		return __webpack_module_cache__[moduleId].exports;
/******/ 	}
/******/ 	// Create a new module (and put it into the cache)
/******/ 	var module = __webpack_module_cache__[moduleId] = {
/******/ 		// no module.id needed
/******/ 		// no module.loaded needed
/******/ 		exports: {}
/******/ 	};
/******/ 
/******/ 	// Execute the module function
/******/ 	__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 
/******/ 	// Return the exports of the module
/******/ 	return module.exports;
/******/ }
/******/ 
/************************************************************************/
/******/ /* webpack/runtime/define property getters */
/******/ (() => {
/******/ 	// define getter functions for harmony exports
/******/ 	__webpack_require__.d = (exports, definition) => {
/******/ 		for(var key in definition) {
/******/ 			if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 				Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 			}
/******/ 		}
/******/ 	};
/******/ })();
/******/ 
/******/ /* webpack/runtime/hasOwnProperty shorthand */
/******/ (() => {
/******/ 	__webpack_require__.o = (obj, prop) => Object.prototype.hasOwnProperty.call(obj, prop)
/******/ })();
/******/ 
/************************************************************************/
/******/ // startup
/******/ // Load entry module
/******/ __webpack_require__(176);
/******/ // This entry module used 'exports' so it can't be inlined
