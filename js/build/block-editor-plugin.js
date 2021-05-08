this["polylang-pro"] =
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 904:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(197);
// EXTERNAL MODULE: external {"this":["wp","apiFetch"]}
var external_this_wp_apiFetch_ = __webpack_require__(839);
var external_this_wp_apiFetch_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_apiFetch_);
// EXTERNAL MODULE: external {"this":["wp","url"]}
var external_this_wp_url_ = __webpack_require__(696);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(804);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/settings.js
/**
 * Module Constants
 *
 * @package Polylang-Pro
 */

const MODULE_KEY = 'pll/metabox';
const MODULE_CORE_EDITOR_KEY = 'core/editor';
const MODULE_CORE_KEY = 'core';
const DEFAULT_STATE = {
	languages: [],
	selectedLanguage: {},
	translatedPosts: {},
	fromPost: null
};


;// CONCATENATED MODULE: ./modules/block-editor/js/block-editor-plugin.js
/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */




/**
 * External dependencies
 */


/**
 * Internal dependencies
 */


/*
 * Specific scripts with block editor
 */
external_this_wp_apiFetch_default().use(
	// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
	( options, next ) => {
		// If options.url is defined, this is not a REST request but a direct call to post.php for legacy metaboxes.
		if ( (0,external_lodash_.isUndefined)( options.url ) ) {
			if ( isSaveRequest( options ) ) {
				options.data.is_block_editor = true;
				if ( ! isCurrentPostRequest( options ) ) {
					options.data.lang = getCurrentLanguage();
				}
			} else {
				addLanguageToRequest( options );
				addIsBlockEditorToRequest( options )
			}
		}
		return next( options );
	}
	// phpcs:enable PEAR.Functions.FunctionCallSignature.Indent
);

/**
 * Is the request concerned the current post type ?
 *
 * Useful when saving a reusable block contained in another post type.
 * Indeed a reusable block is also a post, but its saving request doesn't concern the post currently edited.
 * As we don't know the language of the reusable block when the user triggers the reusable block saving action,
 * we need to pass the current post language to be sure that the reusable block will have a language.
 * 
 * @see https://github.com/polylang/polylang/issues/437 - Reusable block has no language when it's saved from another post type editing.
 *
 * @param {type} options the initial request
 * @returns {Boolean}
 */
function isCurrentPostRequest( options ){
	// Save translation datas is needed for all post types only
	// it's done by verifying options.path matches with one of baseURL of all post types
	// and compare current post id with this sent in the request

	// List of post type baseURLs.
	const postTypeURLs = (0,external_lodash_.map)( (0,external_this_wp_data_.select)( 'core' ).getEntitiesByKind( 'postType' ), (0,external_lodash_.property)( 'baseURL' ) );

	// Id from the post currently edited.
	const postId = (0,external_this_wp_data_.select)( 'core/editor' ).getCurrentPostId();

	// Id from the REST request.
	// options.data never isNil here because it's already verified before in isSaveRequest() function
	const id = options.data.id;

	// Return true
	// if REST request baseURL matches with one of the known post type baseURLs
	// and the id from the post currently edited corresponds on the id passed to the REST request
	// Return false otherwise
	return -1 !== postTypeURLs.findIndex(
		function( element ) {
			return new RegExp( `${ (0,external_lodash_.escapeRegExp)( element ) }` ).test( options.path ); // phpcs:ignore WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
		}
	) && postId === id;
}

/**
 * Is the request for saving ?
 *
 * @param {type} options the initial request
 * @returns {Boolean}
 */
function isSaveRequest( options ){
	// If data is defined we are in a PUT or POST request method otherwise a GET request method
	// Test options.method property isn't efficient because most of REST request which use fetch API doesn't pass this property.
	// So, test options.data is necessary to know if the REST request is to save datas.
	// However test if options.data is undefined isn't sufficient because some REST request pass a null value as the ServerSideRender Gutenberg component.
	if ( ! (0,external_lodash_.isNil)( options.data ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Add language to the request
 *
 * @param {type} options the initial request
 * @returns {undefined}
 */
function addLanguageToRequest( options ){
	const filterLang = (0,external_lodash_.isUndefined)( options.filterLang ) || options.filterLang;
	if ( filterLang ) {
		options.path = (0,external_this_wp_url_.addQueryArgs)(
			options.path,
			{
				lang: getCurrentLanguage()
			}
		);
	}
}

/**
 * Get language from store and fallback in HTML
 *
 * @returns {Element.value}
 */
function getCurrentLanguage(){
	// for the first requests block editor isn't initialized yet
	// so language is getted from a HTML input
	const postLanguage = (0,external_this_wp_data_.select)( MODULE_CORE_EDITOR_KEY ).getEditedPostAttribute( 'lang' )
	if ( ! (0,external_lodash_.isUndefined)( postLanguage ) && postLanguage ) {
		return postLanguage;
	}
	return pll_block_editor_plugin_settings.lang.slug;
}

/**
 * Add is_block_editor parameter to the request in a block editor context
 *
 * @param {type} options the initial request
 * @returns {undefined}
 */
function addIsBlockEditorToRequest( options ){
	options.path = (0,external_this_wp_url_.addQueryArgs)(
		options.path,
		{
			is_block_editor: true
		}
	);
}


/***/ }),

/***/ 804:
/***/ ((module) => {

module.exports = (function() { return this["lodash"]; }());

/***/ }),

/***/ 839:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["apiFetch"]; }());

/***/ }),

/***/ 197:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["data"]; }());

/***/ }),

/***/ 696:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["url"]; }());

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => module['default'] :
/******/ 				() => module;
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => Object.prototype.hasOwnProperty.call(obj, prop)
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	// module exports must be returned from runtime so entry inlining is disabled
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(904);
/******/ })()
;