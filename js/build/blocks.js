/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 991:
/***/ ((module) => {

module.exports = (function() { return this["lodash"]; }());

/***/ }),

/***/ 538:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blockEditor"]; }());

/***/ }),

/***/ 733:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blocks"]; }());

/***/ }),

/***/ 893:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["components"]; }());

/***/ }),

/***/ 576:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["compose"]; }());

/***/ }),

/***/ 15:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["data"]; }());

/***/ }),

/***/ 293:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["element"]; }());

/***/ }),

/***/ 761:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["hooks"]; }());

/***/ }),

/***/ 122:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["i18n"]; }());

/***/ }),

/***/ 776:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["primitives"]; }());

/***/ }),

/***/ 169:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["serverSideRender"]; }());

/***/ }),

/***/ 470:
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
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
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
/******/ 				() => (module['default']) :
/******/ 				() => (module);
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
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
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
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"this":["wp","element"]}
var external_this_wp_element_ = __webpack_require__(293);
// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(122);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(991);
// EXTERNAL MODULE: external {"this":["wp","compose"]}
var external_this_wp_compose_ = __webpack_require__(576);
// EXTERNAL MODULE: external {"this":["wp","hooks"]}
var external_this_wp_hooks_ = __webpack_require__(761);
// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(15);
// EXTERNAL MODULE: external {"this":["wp","blockEditor"]}
var external_this_wp_blockEditor_ = __webpack_require__(538);
// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(893);
// EXTERNAL MODULE: external {"this":["wp","primitives"]}
var external_this_wp_primitives_ = __webpack_require__(776);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/duplication.js

/**
 * Duplication icon - admin-page Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const duplication = isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M6 15v-13h10v13h-10zM5 16h8v2h-10v-13h2v11z"
})) : 'admin-page';
/* harmony default export */ const library_duplication = ((/* unused pure expression or super */ null && (duplication)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/pencil.js

/**
 * Pencil icon - edit Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const pencil_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const pencil = pencil_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M13.89 3.39l2.71 2.72c0.46 0.46 0.42 1.24 0.030 1.64l-8.010 8.020-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.030c0.39-0.39 1.22-0.39 1.68 0.070zM11.16 6.18l-5.59 5.61 1.11 1.11 5.54-5.65zM8.19 14.41l5.58-5.6-1.070-1.080-5.59 5.6z"
})) : 'edit';
/* harmony default export */ const library_pencil = ((/* unused pure expression or super */ null && (pencil)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/plus.js

/**
 * Plus icon - plus Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const plus_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const plus = plus_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M17 7v3h-5v5h-3v-5h-5v-3h5v-5h3v5h5z"
})) : 'plus';
/* harmony default export */ const library_plus = ((/* unused pure expression or super */ null && (plus)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/synchronization.js

/**
 * Synchronization icon - controls-repeat Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const synchronization_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const synchronization = synchronization_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M5 7v3l-2 1.5v-6.5h11v-2l4 3.010-4 2.99v-2h-9zM15 13v-3l2-1.5v6.5h-11v2l-4-3.010 4-2.99v2h9z"
})) : 'controls-repeat';
/* harmony default export */ const library_synchronization = ((/* unused pure expression or super */ null && (synchronization)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/translation.js

/**
 * Translation icon - translation Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const translation_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const translation = translation_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M11 7H9.49c-.63 0-1.25.3-1.59.7L7 5H4.13l-2.39 7h1.69l.74-2H7v4H2c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h7c1.1 0 2 .9 2 2v2zM6.51 9H4.49l1-2.93zM10 8h7c1.1 0 2 .9 2 2v7c0 1.1-.9 2-2 2h-7c-1.1 0-2-.9-2-2v-7c0-1.1.9-2 2-2zm7.25 5v-1.08h-3.17V9.75h-1.16v2.17H9.75V13h1.28c.11.85.56 1.85 1.28 2.62-.87.36-1.89.62-2.31.62-.01.02.22.97.2 1.46.84 0 2.21-.5 3.28-1.15 1.09.65 2.48 1.15 3.34 1.15-.02-.49.2-1.44.2-1.46-.43 0-1.49-.27-2.38-.63.7-.77 1.14-1.77 1.25-2.61h1.36zm-3.81 1.93c-.5-.46-.85-1.13-1.01-1.93h2.09c-.17.8-.51 1.47-1 1.93l-.04.03s-.03-.02-.04-.03z"
})) : 'translation';
/* harmony default export */ const library_translation = (translation);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/trash.js

/**
 * Trash icon - trash Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const trash_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const trash = trash_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M12 4h3c.6 0 1 .4 1 1v1H3V5c0-.6.5-1 1-1h3c.2-1.1 1.3-2 2.5-2s2.3.9 2.5 2zM8 4h3c-.2-.6-.9-1-1.5-1S8.2 3.4 8 4zM4 7h11l-.9 10.1c0 .5-.5.9-1 .9H5.9c-.5 0-.9-.4-1-.9L4 7z"
})) : 'trash';
/* harmony default export */ const library_trash = ((/* unused pure expression or super */ null && (trash)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/star.js

/**
 * Star icon - star-filled Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


const star_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const star = star_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "m10 1 3 6 6 .75-4.12 4.62L16 19l-6-3-6 3 1.13-6.63L1 7.75 7 7z"
})) : 'star-filled';
/* harmony default export */ const library_star = ((/* unused pure expression or super */ null && (star)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/submenu.js

/**
 * Submenu icon
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */

/**
 * External dependencies
 */

const submenu_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
const SubmenuIcon = () => submenu_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  width: "12",
  height: "12",
  viewBox: "0 0 12 12",
  fill: "none"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M1.50002 4L6.00002 8L10.5 4",
  strokeWidth: "1.5"
})) : 'submenu';
/* harmony default export */ const submenu = (SubmenuIcon);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/index.js
/**
 * Icons library
 *
 * @package Polylang-Pro
 */









;// CONCATENATED MODULE: ./modules/block-editor/js/components/language-flag.js

/**
 * @package Polylang-Pro
 */

/**
 * External dependencies.
 */


/**
 * Internal dependencies.
 */


/**
 * Display a flag icon for a given language.
 *
 * @since 3.1
 * @since 3.2 Now its own component.
 *
 * @param {Object} A language object.
 *
 * @return {Object}
 */
function LanguageFlag(_ref) {
  let {
    language
  } = _ref;
  return !(0,external_lodash_.isNil)(language) ? !(0,external_lodash_.isEmpty)(language.flag_url) ? (0,external_this_wp_element_.createElement)("span", {
    className: "pll-select-flag"
  }, (0,external_this_wp_element_.createElement)("img", {
    src: language.flag_url,
    alt: language.name,
    title: language.name,
    className: "flag"
  })) : (0,external_this_wp_element_.createElement)("abbr", null, language.slug, (0,external_this_wp_element_.createElement)("span", {
    className: "screen-reader-text"
  }, language.name)) : (0,external_this_wp_element_.createElement)("span", {
    className: "pll-translation-icon"
  }, library_translation);
}
/* harmony default export */ const language_flag = (LanguageFlag);
;// CONCATENATED MODULE: ./modules/block-editor/js/components/language-dropdown.js

/**
 * @package Polylang-Pro
 */

// External dependencies


/**
 * Displays a dropdown to select a language.
 *
 * @since 3.1
 *
 * @param {Function} handleChange Callback to be executed when language changes.
 * @param {mixed} children Child components to be used as select options.
 * @param {Object} selectedLanguage An object representing a Polylang Language. Default to null.
 * @param {string} Default value to be selected if the selected language is not provided. Default to an empty string.
 *
 * @return {Object} A dropdown selector for languages.
 */
function LanguageDropdown(_ref) {
  let {
    handleChange,
    children,
    selectedLanguage = null,
    defaultValue = ''
  } = _ref;
  const selectedLanguageSlug = selectedLanguage?.slug ? selectedLanguage.slug : defaultValue;
  return (0,external_this_wp_element_.createElement)("div", {
    id: "select-post-language"
  }, (0,external_this_wp_element_.createElement)(language_flag, {
    language: selectedLanguage
  }), children && (0,external_this_wp_element_.createElement)("select", {
    value: selectedLanguageSlug,
    onChange: event => handleChange(event),
    id: "pll_post_lang_choice",
    name: "pll_post_lang_choice",
    className: "post_lang_choice"
  }, children));
}

/**
 * Map languages objects as options for a <select> tag.
 *
 * @since 3.1
 *
 * @param {mixed} languages An iterable object containing languages objects.
 *
 * @return {Object} A list of <option> tags to be used in a <select> tag.
 */
function LanguagesOptionsList(_ref2) {
  let {
    languages
  } = _ref2;
  return Array.from(languages.values()).map(_ref3 => {
    let {
      slug,
      name,
      w3c
    } = _ref3;
    return (0,external_this_wp_element_.createElement)("option", {
      value: slug,
      lang: w3c,
      key: slug
    }, name);
  });
}

;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/settings.js
/**
 * Module Constants
 *
 * @package Polylang-Pro
 */

const settings_MODULE_KEY = 'pll/metabox';
const settings_MODULE_CORE_EDITOR_KEY = 'core/editor';
const settings_MODULE_SITE_EDITOR_KEY = 'core/edit-site';
const settings_MODULE_POST_EDITOR_KEY = 'core/edit-post';
const settings_MODULE_CORE_KEY = 'core';
const DEFAULT_STATE = {
  languages: [],
  selectedLanguage: {},
  translatedPosts: {},
  fromPost: null,
  currentTemplatePart: {}
};
const UNTRANSLATABLE_POST_TYPE = (/* unused pure expression or super */ null && (['wp_template', 'wp_global_styles']));
const POST_TYPE_WITH_TRASH = (/* unused pure expression or super */ null && (['page']));
const settings_TEMPLATE_PART_SLUG_SEPARATOR = '___'; // Its value must be synchronized with its equivalent in PHP @see PLL_FSE_Template_Slug::SEPARATOR
const settings_TEMPLATE_PART_SLUG_CHECK_LANGUAGE_PATTERN = '[a-z_-]+'; // Its value must be synchronized with it equivalent in PHP @see PLL_FSE_Template_Slug::SEPARATOR

// EXTERNAL MODULE: external {"this":["wp","url"]}
var external_this_wp_url_ = __webpack_require__(470);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/utils.js
/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */





/**
 * Internal dependencies
 */


/**
 * Converts array of object to a map.
 *
 * @param {array} array Array to convert.
 * @param {*}     key   The key in the object used as key to build the map.
 * @returns {Map}
 */
function convertArrayToMap(array, key) {
  const map = new Map();
  array.reduce(function (accumulator, currentValue) {
    accumulator.set(currentValue[key], currentValue);
    return accumulator;
  }, map);
  return map;
}

/**
 * Converts map to an associative array.
 *
 * @param {Map} map The map to convert.
 * @returns {Object}
 */
function utils_convertMapToObject(map) {
  const object = {};
  map.forEach(function (value, key, map) {
    const obj = this;
    this[key] = isBoolean(value) ? value.toString() : value;
  }, object);
  return object;
}

/**
 * Checks whether the current screen is block-based post type editor.
 *
 * @returns {boolean} True if block editor for post type; false otherwise.
 */
function isPostTypeBlockEditor() {
  return !!document.getElementById('editor');
}

/**
 * Checks whether the current screen is the block-based widgets editor.
 *
 * @returns {boolean} True if we are in the widgets block editor; false otherwise.
 */
function isWidgetsBlockEditor() {
  return !!document.getElementById('widgets-editor');
}

/**
 * Checks whether the current screen is the customizer widgets editor.
 *
 * @returns {boolean} True if we are in the customizer widgets editor; false otherwise.
 */
function isWidgetsCustomizerEditor() {
  return !!document.getElementById('customize-controls');
}

/**
 * Checks whether the current screen is the site editor.
 * Takes in account if Gutenberg is activated.
 *
 * @returns {boolean} True if site editor screen, false otherwise.
 */
function isSiteBlockEditor() {
  return !!(document.getElementById('site-editor') || document.getElementById('edit-site-editor'));
}

/**
 * Returns the post type URL for REST API calls or undefined if the user hasn't the rights.
 *
 * @param {string} name The post type name.
 * @returns {string|undefined}
 */
function getPostsUrl(name) {
  const postTypes = select('core').getEntitiesByKind('postType');
  const postType = find(postTypes, {
    name
  });
  return postType?.baseURL;
}

/**
 * Gets all query string parameters and convert them in a URLSearchParams object.
 *
 * @returns {Object}
 */
function utils_getSearchParams() {
  // Variable window.location.search is just read for creating and returning a URLSearchParams object to be able to manipulate it more easily.
  if (!isEmpty(window.location.search)) {
    // phpcs:ignore WordPressVIPMinimum.JS.Window.location
    return new URLSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location
  } else {
    return null;
  }
}

/**
 * Gets selected language.
 *
 * @param {string} lang The post language code.
 * @returns {Object} The selected language.
 */
function getSelectedLanguage(lang) {
  const languages = select(MODULE_KEY).getLanguages();
  // Pick up this language as selected in languages list
  return languages.get(lang);
}

/**
 * Gets the default language.
 *
 * @returns {Object} The default Language.
 */
function getDefaultLanguage() {
  const languages = select(MODULE_KEY).getLanguages();
  return Array.from(languages.values()).find(lang => lang.is_default);
}

/**
 * Checks if the given language is the default one.
 *
 * @param {string} lang The language code to compare with.
 * @returns {boolean} True if the given language is the default one.
 */
function isDefaultLanguage(lang) {
  return lang === getDefaultLanguage().slug;
}

/**
 * Gets translated posts.
 *
 * @param {Object}                  translations       The translated posts object with language codes as keys and ids as values.
 * @param {Object.<string, Object>} translations_table The translations table data with language codes as keys and data object as values.
 * @returns {Map}
 */
function utils_getTranslatedPosts(translations, translations_table, lang) {
  const translationsTable = getTranslationsTable(translations_table, lang);
  const fromPost = select(MODULE_KEY).getFromPost();
  let translatedPosts = new Map(Object.entries([]));
  if (!isUndefined(translations)) {
    translatedPosts = new Map(Object.entries(translations));
  }
  // If we come from another post for creating a new one, we have to update translated posts from the original post
  // to be able to update translations attribute of the post
  if (!isNil(fromPost) && !isNil(fromPost.id)) {
    translationsTable.forEach((translationData, lang) => {
      if (!isNil(translationData.translated_post) && !isNil(translationData.translated_post.id)) {
        translatedPosts.set(lang, translationData.translated_post.id);
      }
    });
  }
  return translatedPosts;
}

/**
 * Gets synchronized posts.
 *
 * @param {Object.<string, boolean>} pll_sync_post The synchronized posts object with language codes as keys and boolean values to say if the post is synchronized or not.
 * @returns {Map}
 */
function getSynchronizedPosts(pll_sync_post) {
  let synchronizedPosts = new Map(Object.entries([]));
  if (!isUndefined(pll_sync_post)) {
    synchronizedPosts = new Map(Object.entries(pll_sync_post));
  }
  return synchronizedPosts;
}

/**
 * Gets translations table.
 *
 * @param {Object.<string, Object>} translationsTableDatas The translations table data object with language codes as keys and data object as values.
 * @returns {Map}
 */
function getTranslationsTable(translationsTableDatas) {
  let translationsTable = new Map(Object.entries([]));
  // get translations table datas from post
  if (!isUndefined(translationsTableDatas)) {
    // Build translations table map with language slug as key
    translationsTable = new Map(Object.entries(translationsTableDatas));
  }
  return translationsTable;
}

/**
 * Checks if the given request is for saving.
 *
 * @param {Object} options The initial request.
 * @returns {Boolean} True if the request is for saving.
 */
function isSaveRequest(options) {
  // If data is defined we are in a PUT or POST request method otherwise a GET request method
  // Test options.method property isn't efficient because most of REST request which use fetch API doesn't pass this property.
  // So, test options.data is necessary to know if the REST request is to save datas.
  // However test if options.data is undefined isn't sufficient because some REST request pass a null value as the ServerSideRender Gutenberg component.
  if (!isNil(options.data)) {
    return true;
  } else {
    return false;
  }
}

/**
 * Checks if the given request concerns the current post type.
 *
 * Useful when saving a reusable block contained in another post type.
 * Indeed a reusable block is also a post, but its saving request doesn't concern the post currently edited.
 * As we don't know the language of the reusable block when the user triggers the reusable block saving action,
 * we need to pass the current post language to be sure that the reusable block will have a language.
 *
 * @see https://github.com/polylang/polylang/issues/437 - Reusable block has no language when it's saved from another post type editing.
 *
 * @param {Object} options the initial request
 * @returns {boolean} True if the request concerns the current post.
 */
function isCurrentPostRequest(options) {
  // Saving translation data is needed only for all post types.
  // It's done by verifying options.path matches with one of baseURL of all post types
  // and compare current post id with this sent in the request.

  // List of post type baseURLs.
  const postTypeURLs = map(select('core').getEntitiesByKind('postType'), property('baseURL'));

  // Id from the post currently edited.
  const postId = select('core/editor').getCurrentPostId();

  // Id from the REST request.
  // options.data never isNil here because it's already verified before in isSaveRequest() function.
  const id = options.data.id;

  // Return true
  // if REST request baseURL matches with one of the known post type baseURLs
  // and the id from the post currently edited corresponds on the id passed to the REST request
  // Return false otherwise
  return -1 !== postTypeURLs.findIndex(function (element) {
    return new RegExp(`${escapeRegExp(element)}`).test(options.path);
  }) && postId === id;
}

/**
 * Checks if the given REST request is for the creation of a new template part translation.
 *
 * @param {Object} options The initial request.
 * @returns {Boolean} True if the request concerns a template part translation creation.
 */
function isTemplatePartTranslationCreationRequest(options) {
  return 'POST' === options.method && options.path.match(/^\/wp\/v2\/template-parts(?:\/|\?|$)/) && !isNil(options.data.from_post) && !isNil(options.data.lang);
}

/**
 * Checks if the given REST request is for the creation of a new template part.
 *
 * @param {Object} options The initial request.
 * @returns {Boolean} True if the request concerns a template part creation.
 */
function isNewTemplatePartCreationRequest(options) {
  return 'POST' === options.method && options.path.match(/^\/wp\/v2\/template-parts(?:\/|\?|$)/) && isNil(options.data.from_post) && isNil(options.data.lang);
}

/**
 * Adds language as query string parameter to the given request.
 *
 * @param {Object} options         The initial request.
 * @param {string} currentLanguage The language code to add to the request.
 */
function addLanguageToRequest(options, currentLanguage) {
  const hasLangArg = hasQueryArg(options.path, 'lang');
  const filterLang = isUndefined(options.filterLang) || options.filterLang;
  if (filterLang && !hasLangArg) {
    options.path = addQueryArgs(options.path, {
      lang: currentLanguage
    });
  }
}

/**
 * Adds `include_untranslated` parameter to the request.
 *
 * @param {Object} options The initial request.
 * @returns {void}
 */
function addIncludeUntranslatedParam(options) {
  options.path = addQueryArgs(options.path, {
    include_untranslated: true
  });
}

/**
 * Use addIncludeUntranslatedParam if the given page is a template part page.
 * Or if the template editing mode is enabled inside post editing.
 *
 * @param {Object} options The initial request.
 * @returns {void}
 */
function maybeRequireIncludeUntranslatedTemplate(options) {
  const params = new URL(document.location).searchParams;
  const postType = params.get('postType');
  const postId = params.get('postId');
  const isEditingTemplate = select(MODULE_POST_EDITOR_KEY)?.isEditingTemplate();
  if ("wp_template_part" === postType && !isNil(postId) || isEditingTemplate) {
    addIncludeUntranslatedParam(options);
  }
}

/**
 * Returns true if the given post is a template part, false otherwise.
 *
 * @param {Object} post A post object.
 * @returns {boolean} Whether it is a template part or not.
 */
function isTemplatePart(post) {
  return 'wp_template_part' === post.type;
}

/**
 * Returns the current post type considering the Site Editor or Post Editor.
 *
 * @returns {string} The current post type.
 */
function getCurrentPostType() {
  if (isSiteBlockEditor()) {
    return select(MODULE_SITE_EDITOR_KEY).getEditedPostType();
  }
  return select(MODULE_CORE_EDITOR_KEY).getCurrentPostType();
}

/**
 * Returns a regular expression ready to use to perform search and replace.
 *
 * @returns {RegExp} The regular expression.
 */
function getLangSlugRegex() {
  let languageCheckPattern = TEMPLATE_PART_SLUG_CHECK_LANGUAGE_PATTERN;
  const languages = select(MODULE_KEY).getLanguages();
  const languageSlugs = Array.from(languages.keys());
  if (!isEmpty(languageSlugs)) {
    languageCheckPattern = languageSlugs.join('|');
  }
  return new RegExp(`${TEMPLATE_PART_SLUG_SEPARATOR}(?:${languageCheckPattern})$`);
}
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/store/utils.js
/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */




/**
 * Internal dependencies
 */



/**
 * Wait for the whole post block editor context has been initialized: current post loaded and languages list initialized.
 */
const isBlockPostEditorContextInitialized = () => {
  if (isNil(select(MODULE_CORE_EDITOR_KEY))) {
    return Promise.reject("Polylang languages panel can't be initialized because block editor isn't fully initialized.");
  }

  // save url params espacially when a new translation is creating
  saveURLParams();
  // call to getCurrentUser to force call to resolvers and initialize state
  const currentUser = select(MODULE_KEY).getCurrentUser();

  /**
   * Set a promise for waiting for the current post has been fully loaded before making other processes.
   */
  const isCurrentPostLoaded = new Promise(function (resolve) {
    let unsubscribe = subscribe(function () {
      const currentPost = select(MODULE_CORE_EDITOR_KEY).getCurrentPost();
      if (!isEmpty(currentPost)) {
        unsubscribe();
        resolve();
      }
    });
  });

  // Wait for current post has been loaded and languages list initialized.
  return Promise.all([isCurrentPostLoaded, isLanguagesinitialized()]).then(function () {
    // If we come from another post for creating a new one, we have to update translations from the original post.
    const fromPost = select(MODULE_KEY).getFromPost();
    if (!isNil(fromPost) && !isNil(fromPost.id)) {
      const lang = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
      const translations = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations');
      const translations_table = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
      const translatedPosts = getTranslatedPosts(translations, translations_table, lang);
      dispatch(MODULE_CORE_EDITOR_KEY).editPost({
        translations: convertMapToObject(translatedPosts)
      });
    }
  });
};

/**
 * Wait for the whole site editor context to be initialized: current template loaded and languages list initialized.
 */
const isSiteEditorContextInitialized = () => {
  // save url params espacially when a new translation is creating
  saveURLParams();
  // call to getCurrentUser to force call to resolvers and initialize state
  const currentUser = select(MODULE_KEY).getCurrentUser();

  /**
   * Set a promise to wait for the current template to be fully loaded before making other processes.
   * It allows to see if both Site Editor and Core stores are available (@see getCurrentPostFromDataStore()).
   */
  const isTemplatePartLoaded = new Promise(function (resolve) {
    let unsubscribe = subscribe(function () {
      const store = select(MODULE_SITE_EDITOR_KEY);
      if (store) {
        unsubscribe();
        resolve();
      }
    });
  });
  return Promise.all([isTemplatePartLoaded, isLanguagesinitialized()]);
};

/**
 * Returns a promise fulfilled when the languages list is correctly initialized before making other processes.
 */
const isLanguagesinitialized = () => new Promise(function (resolve) {
  let unsubscribe = (0,external_this_wp_data_.subscribe)(function () {
    const languages = (0,external_this_wp_data_.select)(settings_MODULE_KEY)?.getLanguages();
    if (languages?.size > 0) {
      unsubscribe();
      resolve();
    }
  });
});

/**
 * Save query string parameters from URL. They could be needed after
 * They could be null if they does not exist
 */
function saveURLParams() {
  // Variable window.location.search isn't use directly
  // Function getSearchParams return an URLSearchParams object for manipulating each parameter
  // Each of them are sanitized below
  const searchParams = getSearchParams();
  if (null !== searchParams) {
    dispatch(MODULE_KEY).setFromPost({
      id: wp.sanitize.stripTagsAndEncodeText(searchParams.get('from_post')),
      postType: wp.sanitize.stripTagsAndEncodeText(searchParams.get('post_type')),
      newLanguage: wp.sanitize.stripTagsAndEncodeText(searchParams.get('new_lang'))
    });
  }
}
const getEditedPostContextWithLegacy = () => {
  const siteEditorSelector = select(MODULE_SITE_EDITOR_KEY);

  /**
   * Return null when called from our apiFetch middleware without a properly loaded store.
   */
  if (!siteEditorSelector) {
    return null;
  }
  const _context = {
    postId: siteEditorSelector.getEditedPostId(),
    postType: siteEditorSelector.getEditedPostType()
  };
  if (siteEditorSelector.hasOwnProperty('getEditedPostContext')) {
    const context = siteEditorSelector.getEditedPostContext();
    return context?.postType && context?.postId ? context : _context;
  }

  /**
   * Backward compatibility with WordPress < 6.3 where `getEditedPostContext()` doesn't exist yet.
   */
  return _context;
};

/**
 * Gets the current post using the Site Editor store and the Core store.
 *
 * @returns {object|null} The current post object, `null` if none found.
 */
const getCurrentPostFromDataStore = () => {
  const editedContext = getEditedPostContextWithLegacy();
  return null === editedContext ? null : select(MODULE_CORE_KEY).getEntityRecord('postType', editedContext.postType, editedContext.postId);
};
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/attributes.js

/**
 * Add blocks attributes
 *
 *  @package Polylang-Pro
 */

/**
 * WordPress Dependencies
 */









/**
 * Internal dependencies
 */




if (isWidgetsBlockEditor() || isWidgetsCustomizerEditor()) {
  const LanguageAttribute = {
    type: 'string',
    default: 'every'
  };
  const addLangChoiceAttribute = function (settings, name) {
    const unallowedBlockNames = ['core/widget-area', 'core/legacy-widget'];
    if (unallowedBlockNames.find(element => element === name)) {
      return settings;
    }
    settings.attributes = (0,external_lodash_.assign)(settings.attributes, {
      pll_lang: LanguageAttribute
    });
    return settings;
  };
  (0,external_this_wp_hooks_.addFilter)('blocks.registerBlockType', 'pll/lang-choice', addLangChoiceAttribute);
  const withInspectorControls = (0,external_this_wp_compose_.createHigherOrderComponent)(BlockEdit => {
    return props => {
      const languages = (0,external_this_wp_data_.select)(settings_MODULE_KEY).getLanguages();
      const {
        pll_lang
      } = props.attributes;
      const isLanguageFilterable = !(0,external_lodash_.isNil)(pll_lang);
      const selectedLanguage = languages.get(pll_lang);
      return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(BlockEdit, props), isLanguageFilterable && (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
        title: (0,external_this_wp_i18n_.__)('Languages', 'polylang-pro')
      }, (0,external_this_wp_element_.createElement)("label", null, (0,external_this_wp_i18n_.__)('The block is displayed for:', 'polylang-pro')), (0,external_this_wp_element_.createElement)(LanguageDropdown, {
        selectedLanguage: selectedLanguage,
        handleChange: langChoiceEvent => {
          const langChoice = langChoiceEvent.currentTarget.value;
          props.setAttributes({
            pll_lang: langChoice
          });
        },
        defaultValue: LanguageAttribute.default
      }, (0,external_this_wp_element_.createElement)("option", {
        value: LanguageAttribute.default
      }, (0,external_this_wp_i18n_.__)('All languages', 'polylang-pro'), " "), (0,external_this_wp_element_.createElement)(LanguagesOptionsList, {
        languages: languages
      })))));
    };
  }, "withInspectorControl");
  isLanguagesinitialized().then(function () {
    (0,external_this_wp_hooks_.addFilter)('editor.BlockEdit', 'pll/lang-choice-with-inspector-controls', withInspectorControls);
  });
}
// EXTERNAL MODULE: external {"this":["wp","blocks"]}
var external_this_wp_blocks_ = __webpack_require__(733);
// EXTERNAL MODULE: external {"this":["wp","serverSideRender"]}
var external_this_wp_serverSideRender_ = __webpack_require__(169);
var external_this_wp_serverSideRender_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_serverSideRender_);
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/language-switcher-edit.js

/**
 * @package Polylang-Pro
 */

/**
 * External dependencies
 */


/**
 * WordPress dependencies
 */


/**
 * Call initialization of pll/metabox store for getting ready some datas
 */

const i18nAttributeStrings = pll_block_editor_blocks_settings;
function createLanguageSwitcherEdit(props) {
  const createToggleAttribute = function (propName) {
    return () => {
      const value = props.attributes[propName];
      const {
        setAttributes
      } = props;
      let updatedAttributes = {
        [propName]: !value
      };
      let forcedAttributeName;
      let forcedAttributeUnchecked;

      // Both show_names and show_flags attributes can't be unchecked together.
      switch (propName) {
        case 'show_names':
          forcedAttributeName = 'show_flags';
          forcedAttributeUnchecked = !props.attributes[forcedAttributeName];
          break;
        case 'show_flags':
          forcedAttributeName = 'show_names';
          forcedAttributeUnchecked = !props.attributes[forcedAttributeName];
          break;
      }
      if ('show_names' === propName || 'show_flags' === propName) {
        if (value && forcedAttributeUnchecked) {
          updatedAttributes = (0,external_lodash_.assign)(updatedAttributes, {
            [forcedAttributeName]: forcedAttributeUnchecked
          });
        }
      }
      setAttributes(updatedAttributes);
    };
  };
  const toggleDropdown = createToggleAttribute('dropdown');
  const toggleShowNames = createToggleAttribute('show_names');
  const toggleShowFlags = createToggleAttribute('show_flags');
  const toggleForceHome = createToggleAttribute('force_home');
  const toggleHideCurrent = createToggleAttribute('hide_current');
  const toggleHideIfNoTranslation = createToggleAttribute('hide_if_no_translation');
  const {
    dropdown,
    show_names,
    show_flags,
    force_home,
    hide_current,
    hide_if_no_translation
  } = props.attributes;
  function ToggleControlDropdown() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.dropdown,
      checked: dropdown,
      onChange: toggleDropdown
    });
  }
  function ToggleControlShowNames() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_names,
      checked: show_names,
      onChange: toggleShowNames
    });
  }
  function ToggleControlShowFlags() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_flags,
      checked: show_flags,
      onChange: toggleShowFlags
    });
  }
  function ToggleControlForceHome() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.force_home,
      checked: force_home,
      onChange: toggleForceHome
    });
  }
  function ToggleControlHideCurrent() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_current,
      checked: hide_current,
      onChange: toggleHideCurrent
    });
  }
  function ToggleControlHideIfNoTranslations() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_if_no_translation,
      checked: hide_if_no_translation,
      onChange: toggleHideIfNoTranslation
    });
  }
  return {
    ToggleControlDropdown,
    ToggleControlShowNames,
    ToggleControlShowFlags,
    ToggleControlForceHome,
    ToggleControlHideCurrent,
    ToggleControlHideIfNoTranslations
  };
}
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/block.js

/**
 * Register language switcher block.
 *
 *  @package Polylang-Pro
 */

/**
 * WordPress Dependencies
 */








/**
 * External dependencies
 */


/**
 * Internal dependencies
 */


const blocktitle = (0,external_this_wp_i18n_.__)('Language switcher', 'polylang-pro');
const descriptionTitle = (0,external_this_wp_i18n_.__)('Add a language switcher to allow your visitors to select their preferred language.', 'polylang-pro');
const panelTitle = (0,external_this_wp_i18n_.__)('Language switcher settings', 'polylang-pro');

// Register the Language Switcher block as first level block in Block Editor.
(0,external_this_wp_blocks_.registerBlockType)('polylang/language-switcher', {
  title: blocktitle,
  description: descriptionTitle,
  icon: library_translation,
  category: 'widgets',
  example: {},
  edit: props => {
    const {
      dropdown
    } = props.attributes;
    const {
      ToggleControlDropdown,
      ToggleControlShowNames,
      ToggleControlShowFlags,
      ToggleControlForceHome,
      ToggleControlHideCurrent,
      ToggleControlHideIfNoTranslations
    } = createLanguageSwitcherEdit(props);
    return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
      title: panelTitle
    }, (0,external_this_wp_element_.createElement)(ToggleControlDropdown, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlShowNames, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlShowFlags, null), (0,external_this_wp_element_.createElement)(ToggleControlForceHome, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlHideCurrent, null), (0,external_this_wp_element_.createElement)(ToggleControlHideIfNoTranslations, null))), (0,external_this_wp_element_.createElement)(external_this_wp_components_.Disabled, null, (0,external_this_wp_element_.createElement)((external_this_wp_serverSideRender_default()), {
      block: "polylang/language-switcher",
      attributes: props.attributes
    })));
  }
});

// Register the Language Switcher block as child block of core/navigation block.
const navigationLanguageSwitcherName = 'polylang/navigation-language-switcher';
(0,external_this_wp_blocks_.registerBlockType)(navigationLanguageSwitcherName, {
  title: blocktitle,
  description: descriptionTitle,
  icon: library_translation,
  category: 'widgets',
  parent: ['core/navigation'],
  attributes: {
    dropdown: {
      type: 'boolean',
      default: false
    },
    show_names: {
      type: 'boolean',
      default: true
    },
    show_flags: {
      type: 'boolean',
      default: false
    },
    force_home: {
      type: 'boolean',
      default: false
    },
    hide_current: {
      type: 'boolean',
      default: false
    },
    hide_if_no_translation: {
      type: 'boolean',
      default: false
    }
  },
  transforms: {
    from: [{
      type: 'block',
      blocks: ['core/navigation-link'],
      transform: () => (0,external_this_wp_blocks_.createBlock)(navigationLanguageSwitcherName)
    }]
  },
  usesContext: ['textColor', 'customTextColor', 'backgroundColor', 'customBackgroundColor', 'overlayTextColor', 'customOverlayTextColor', 'overlayBackgroundColor', 'customOverlayBackgroundColor', 'fontSize', 'customFontSize', 'showSubmenuIcon', 'openSubmenusOnClick', 'style'],
  example: {},
  edit: props => {
    const {
      dropdown
    } = props.attributes;
    const {
      showSubmenuIcon,
      openSubmenusOnClick
    } = props.context;
    const {
      ToggleControlDropdown,
      ToggleControlShowNames,
      ToggleControlShowFlags,
      ToggleControlForceHome,
      ToggleControlHideCurrent,
      ToggleControlHideIfNoTranslations
    } = createLanguageSwitcherEdit(props);
    return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
      title: panelTitle
    }, (0,external_this_wp_element_.createElement)(ToggleControlDropdown, null), (0,external_this_wp_element_.createElement)(ToggleControlShowNames, null), (0,external_this_wp_element_.createElement)(ToggleControlShowFlags, null), (0,external_this_wp_element_.createElement)(ToggleControlForceHome, null), (0,external_this_wp_element_.createElement)(ToggleControlHideCurrent, null), (0,external_this_wp_element_.createElement)(ToggleControlHideIfNoTranslations, null))), (0,external_this_wp_element_.createElement)(external_this_wp_components_.Disabled, null, (0,external_this_wp_element_.createElement)("div", {
      className: "wp-block-navigation-item"
    }, (0,external_this_wp_element_.createElement)((external_this_wp_serverSideRender_default()), {
      block: navigationLanguageSwitcherName,
      attributes: props.attributes,
      className: 'wp-block-navigation__container block-editor-block-list__layout'
    }), submenuIcon(showSubmenuIcon, openSubmenusOnClick, dropdown))));
  }
});

/**
 * Apply a callback function on each block of the blocks list.
 *
 * @param {Array}  blocks        The list of blocks to process.
 * @param {Array}  menuItems     The initial menu items from where the blocks are converted to.
 * @param {Object} blocksMapping The mapping between the menu items and their corresponding blocks.
 * @param {mapper} mapper        A callback to change the converted block by another one if necessary
 * @returns {Array} Array of blocks updated.
 */
function mapBlockTree(blocks, menuItems, blocksMapping, mapper) {
  /**
   * A function to apply to each block to convert it if necessary by applying the `mapper` filter.
   *
   * @param {Object} block The block to replace or not.
   * @returns {Object} The new block potentially replaced by the `mapper`.
  */
  const convertBlock = block => ({
    ...mapper(block, menuItems, blocksMapping),
    innerBlocks: mapBlockTree(block.innerBlocks, menuItems, blocksMapping, mapper)
  });
  return blocks.map(convertBlock);
}

/**
 * A filter to detect the `core/navigation-link` block not correctly converted from the langauge switcher menu item
 * and convert it to its corresponding `polylang/navigation-language-switcher` block.
 *
 * @callback mapper
 * @param {Object} block         The block converted from the menu item.
 * @param {Array}  menuItems     The initial menu items from where the blocks are converted to.
 * @param {Object} blocksMapping The mapping between the menu items and their corresponding blocks.
 * @returns {Object} The block correctly converted.
 */
const blocksFilter = (block, menuItems, blocksMapping) => {
  if (block.name === "core/navigation-link" && block.attributes?.url === "#pll_switcher") {
    const menuItem = (0,external_lodash_.find)(menuItems, {
      url: '#pll_switcher'
    }); // Get the corresponding menu item.
    const attributes = menuItem.meta._pll_menu_item; // Get its options.
    const newBlock = (0,external_this_wp_blocks_.createBlock)(navigationLanguageSwitcherName, attributes);
    blocksMapping[menuItem.id] = newBlock.clientId; // Update the blocks mapping.
    return newBlock;
  }
  return block;
};

/**
 * A filter callback hooked to `blocks.navigation.__unstableMenuItemsToBlocks`.
 *
 * @param {Array} blocks    The list of blocks to process.
 * @param {Array} menuItems The initial menu items from where the blocks are converted to.
 * @returns {Array} Array of blocks updated.
 */
const menuItemsToBlocksFilter = (blocks, menuItems) => ({
  ...blocks,
  innerBlocks: mapBlockTree(blocks.innerBlocks, menuItems, blocks.mapping, blocksFilter)
});

/**
 * Returns the submenu icon if block parameters allow it.
 *
 * @param {bool} showSubmenuIcon     Whether to show submenu icon or not.
 * @param {bool} openSubmenusOnClick Whether the submenu can be open on click or not.
 * @param {bool} dropdown            Whether the language switcher is in dropdown mode or not.
 * @returns The submenu icon or null.
 */
const submenuIcon = (showSubmenuIcon, openSubmenusOnClick, dropdown) => {
  if ((showSubmenuIcon || openSubmenusOnClick) && dropdown) {
    return (0,external_this_wp_element_.createElement)("span", {
      className: "wp-block-navigation__submenu-icon"
    }, (0,external_this_wp_element_.createElement)(submenu, null));
  }
  return null;
};

/**
 * Hooks to the classic menu conversion to core/navigation block to be able to convert
 * the language switcher menu item to its corresponding block.
 */
(0,external_this_wp_hooks_.addFilter)('blocks.navigation.__unstableMenuItemsToBlocks', 'polylang/include-language-switcher', menuItemsToBlocksFilter);
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/index.js
/**
 * Handles language switcher block and attributes.
 *
 *  @package Polylang-Pro
 */

/**
 * Internal dependencies
 */


})();

this["polylang-pro"] = __webpack_exports__;
/******/ })()
;