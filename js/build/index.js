/******/ "use strict";
/******/ // The require scope
/******/ var __webpack_require__ = {};
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
/******/ 	__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ })();
/******/ 
/************************************************************************/
var __webpack_exports__ = {};
/* unused harmony export ajaxFilter */
/**
 * @package Polylang
 */

/**
 * Adds data to all ajax requests made with jQuery.
 *
 * @since 3.7
 *
 * @param {Object} data The data to add.
 * @returns {void}
 */
function ajaxFilter( data ) {
	if ( 'undefined' === typeof jQuery || ! data ) {
		return;
	}

	const dataStr = jQuery.param( data );

	jQuery.ajaxPrefilter( function ( options ) {
		if ( -1 === options.url.indexOf( ajaxurl ) && -1 === ajaxurl.indexOf( options.url ) ) {
			return;
		}

		if (
			'undefined' === typeof options.data ||
			null === options.data ||
			'string' === typeof options.data && '' === options.data.trim()
		) {
			// An empty string or null/undefined.
			options.data = dataStr;
		} else if ( 'string' === typeof options.data ) {
			// A non-empty string: can be a JSON string or a query string.
			try {
				options.data = JSON.stringify( Object.assign( JSON.parse( options.data ), data ) );
			} catch ( exception ) {
				// A non-empty non-JSON string is considered a query string.
				options.data = `${ options.data }&${ dataStr }`;
			}
		} else if ( jQuery.isPlainObject( options.data ) ) {
			// An object.
			options.data = Object.assign( options.data, data );
		}
	} );
}

