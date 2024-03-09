/******/ "use strict";
var __webpack_exports__ = {};
/**
 * @package Polylang
 */

/**
 * Filters requests for translatable entities.
 * This logic is shared accross all Polylang plugins.
 *
 * @since 3.5
 *
 * @param {APIFetchOptions} options
 * @param {Array} filteredRoutes
 * @param {CallableFunction} filter
 * @returns {APIFetchOptions}
 */
const filterPathMiddleware = ( options, filteredRoutes, filter ) => {
	const cleanPath = options.path.split( '?' )[0].replace(/^\/+|\/+$/g, ''); // Get path without query parameters and trim '/'.

	return Object.values( filteredRoutes ).find( ( path ) => cleanPath === path ) ? filter( options ) : options;
}

/* unused harmony default export */ var __WEBPACK_DEFAULT_EXPORT__ = ((/* unused pure expression or super */ null && (filterPathMiddleware)));

