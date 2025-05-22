/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 20:
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";
var __webpack_unused_export__;
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var f=__webpack_require__(677),k=Symbol.for("react.element"),l=Symbol.for("react.fragment"),m=Object.prototype.hasOwnProperty,n=f.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,p={key:!0,ref:!0,__self:!0,__source:!0};
function q(c,a,g){var b,d={},e=null,h=null;void 0!==g&&(e=""+g);void 0!==a.key&&(e=""+a.key);void 0!==a.ref&&(h=a.ref);for(b in a)m.call(a,b)&&!p.hasOwnProperty(b)&&(d[b]=a[b]);if(c&&c.defaultProps)for(b in a=c.defaultProps,a)void 0===d[b]&&(d[b]=a[b]);return{$$typeof:k,type:c,key:e,ref:h,props:d,_owner:n.current}}__webpack_unused_export__=l;exports.jsx=q;exports.jsxs=q;


/***/ }),

/***/ 848:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


if (true) {
  module.exports = __webpack_require__(20);
} else {}


/***/ }),

/***/ 677:
/***/ ((module) => {

module.exports = (function() { return this["React"]; }());

/***/ }),

/***/ 419:
/***/ ((module) => {

module.exports = (function() { return this["lodash"]; }());

/***/ }),

/***/ 631:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["apiFetch"]; }());

/***/ }),

/***/ 89:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blockEditor"]; }());

/***/ }),

/***/ 959:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["components"]; }());

/***/ }),

/***/ 897:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["compose"]; }());

/***/ }),

/***/ 987:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["data"]; }());

/***/ }),

/***/ 601:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["element"]; }());

/***/ }),

/***/ 873:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["hooks"]; }());

/***/ }),

/***/ 75:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["i18n"]; }());

/***/ }),

/***/ 933:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["primitives"]; }());

/***/ }),

/***/ 172:
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
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";

// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(987);
// EXTERNAL MODULE: external {"this":["wp","url"]}
var external_this_wp_url_ = __webpack_require__(172);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(419);
;// ./js/src/editors/common/settings.js
/**
 * Module Constants
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
const settings_TEMPLATE_PART_SLUG_SEPARATOR = '___'; // Its value must be synchronized with its equivalent in PHP @see PLL_FSE_Template_Slug::SEPARATOR.
const settings_TEMPLATE_PART_SLUG_CHECK_LANGUAGE_PATTERN = '[a-z][a-z0-9_-]*'; // Its value must be synchronized with it equivalent in PHP @see PLL_FSE_Template_Slug::SEPARATOR.

;// ./js/src/editors/common/store/utils.js
/**
 * WordPress Dependencies
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

  // save url params especially when a new translation is creating
  saveURLParams();
  // call to getCurrentUser to force call to resolvers and initialize state
  select(MODULE_KEY).getCurrentUser();

  /**
   * Set a promise for waiting for the current post has been fully loaded before making other processes.
   */
  const isCurrentPostLoaded = new Promise(function (resolve) {
    const unsubscribe = subscribe(function () {
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
      const translationTable = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
      const translatedPosts = getTranslatedPosts(translations, translationTable, lang);
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
  // save url params especially when a new translation is creating
  saveURLParams();
  // call to getCurrentUser to force call to resolvers and initialize state
  select(MODULE_KEY).getCurrentUser();

  /**
   * Set a promise to wait for the current template to be fully loaded before making other processes.
   * It allows to see if both Site Editor and Core stores are available (@see getCurrentPostFromDataStore()).
   */
  const isTemplatePartLoaded = new Promise(function (resolve) {
    const unsubscribe = subscribe(function () {
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
  const unsubscribe = (0,external_this_wp_data_.subscribe)(function () {
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
 * @return {object|null} The current post object, `null` if none found.
 */
const utils_getCurrentPostFromDataStore = () => {
  const editedContext = getEditedPostContextWithLegacy();
  return null === editedContext ? null : select(MODULE_CORE_KEY).getEntityRecord('postType', editedContext.postType, editedContext.postId);
};
;// ./js/src/editors/common/utils.js
/**
 * WordPress Dependencies
 */




/**
 * Internal dependencies
 */



/**
 * Converts array of object to a map.
 *
 * @param {Array} array Array to convert.
 * @param {*}     key   The key in the object used as key to build the map.
 * @return {Map} Converted array.
 */
function convertArrayToMap(array, key) {
  const arrayMap = new Map();
  array.reduce(function (accumulator, currentValue) {
    accumulator.set(currentValue[key], currentValue);
    return accumulator;
  }, arrayMap);
  return arrayMap;
}

/**
 * Converts map to an associative array.
 *
 * @param {Map} mapToConvert The map to convert.
 * @return {Object} Converted map.
 */
function utils_convertMapToObject(mapToConvert) {
  const object = {};
  mapToConvert.forEach(function (value, key) {
    this[key] = isBoolean(value) ? value.toString() : value;
  }, object);
  return object;
}

/**
 * Checks whether the current screen is the site editor.
 * Takes in account if Gutenberg is activated.
 *
 * @return {boolean} True if site editor screen, false otherwise.
 */
function isSiteBlockEditor() {
  return !!(document.getElementById('site-editor') || document.getElementById('edit-site-editor'));
}

/**
 * Returns the post type URL for REST API calls or undefined if the user hasn't the rights.
 *
 * @param {string} name The post type name.
 * @return {string|undefined} URL of the given post type, undefined if not available.
 */
function getPostsUrl(name) {
  const postTypes = select('core').getEntitiesConfig('postType');
  const postType = find(postTypes, {
    name
  });
  return postType?.baseURL;
}

/**
 * Gets all query string parameters and convert them in a URLSearchParams object.
 *
 * @return {URLSearchParams|null} Search parameters object, null if none.
 */
function utils_getSearchParams() {
  // Variable window.location.search is just read for creating and returning a URLSearchParams object to be able to manipulate it more easily.
  // eslint-disable-next-line prettier/prettier
  if (!isEmpty(window.location.search)) {
    // phpcs:ignore WordPressVIPMinimum.JS.Window.location
    return new URLSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location
  }
  return null;
}

/**
 * Gets selected language.
 *
 * @param {string} lang The post language code.
 * @return {Object|null} The selected language, null otherwise.
 */
function getSelectedLanguage(lang) {
  const languages = select(MODULE_KEY).getLanguages();
  // Pick up this language as selected in languages list
  if (languages) {
    return languages.get(lang);
  }
  return null;
}

/**
 * Gets the default language.
 *
 * @return {Object} The default Language.
 */
function getDefaultLanguage() {
  const languages = select(MODULE_KEY).getLanguages();
  return Array.from(languages.values()).find(lang => lang.is_default);
}

/**
 * Checks if the given language is the default one.
 *
 * @param {string} lang The language code to compare with.
 * @return {boolean} True if the given language is the default one.
 */
function isDefaultLanguage(lang) {
  return lang === getDefaultLanguage().slug;
}

/**
 * Gets translated posts.
 *
 * @param {Object}                  translations          The translated posts object with language codes as keys and ids as values.
 * @param {Object.<string, Object>} translationsTableData The translations table data with language codes as keys and data object as values.
 * @param {string}                  lang                  The language slug.
 * @return {Map} Map of the translated posts.
 */
function utils_getTranslatedPosts(translations, translationsTableData, lang) {
  const translationsTable = getTranslationsTable(translationsTableData, lang);
  const fromPost = select(MODULE_KEY).getFromPost();
  let translatedPosts = new Map(Object.entries([]));
  if (!isUndefined(translations)) {
    translatedPosts = new Map(Object.entries(translations));
  }
  // If we come from another post for creating a new one, we have to update translated posts from the original post
  // to be able to update translations attribute of the post
  if (!isNil(fromPost) && !isNil(fromPost.id)) {
    translationsTable.forEach((translationData, languageSlug) => {
      if (!isNil(translationData.translated_post) && !isNil(translationData.translated_post.id)) {
        translatedPosts.set(languageSlug, translationData.translated_post.id);
      }
    });
  }
  return translatedPosts;
}

/**
 * Gets synchronized posts.
 *
 * @param {Object.<string, boolean>} syncPosts The synchronized posts object with language codes as keys and boolean values to say if the post is synchronized or not.
 * @return {Map} Map of synchronized posts.
 */
function getSynchronizedPosts(syncPosts) {
  let synchronizedPosts = new Map(Object.entries([]));
  if (!isUndefined(syncPosts)) {
    synchronizedPosts = new Map(Object.entries(syncPosts));
  }
  return synchronizedPosts;
}

/**
 * Gets translations table.
 *
 * @param {Object.<string, Object>} translationsTableData The translations table data object with language codes as keys and data object as values.
 * @return {Map} Map of the translation table.
 */
function getTranslationsTable(translationsTableData) {
  let translationsTable = new Map(Object.entries([]));
  // get translations table data from post
  if (!isUndefined(translationsTableData)) {
    // Build translations table map with language slug as key
    translationsTable = new Map(Object.entries(translationsTableData));
  }
  return translationsTable;
}

/**
 * Checks if the given request is for saving.
 *
 * @param {Object} options The initial request.
 * @return {boolean} True if the request is for saving.
 */
function isSaveRequest(options) {
  // If data is defined we are in a PUT or POST request method otherwise a GET request method
  // Test options.method property isn't efficient because most of REST request which use fetch API doesn't pass this property.
  // So, test options.data is necessary to know if the REST request is to save data.
  // However test if options.data is undefined isn't sufficient because some REST request pass a null value as the ServerSideRender Gutenberg component.
  if (!isNil(options.data)) {
    return true;
  }
  return false;
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
 * @return {boolean} True if the request concerns the current post.
 */
function isCurrentPostRequest(options) {
  // Saving translation data is needed only for all post types.
  // It's done by verifying options.path matches with one of baseURL of all post types
  // and compare current post id with this sent in the request.

  // List of post type baseURLs.
  const postTypeURLs = map(select('core').getEntitiesConfig('postType'), property('baseURL'));

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
 * @return {boolean} True if the request concerns a template part translation creation.
 */
function isTemplatePartTranslationCreationRequest(options) {
  return 'POST' === options.method && options.path.match(/^\/wp\/v2\/template-parts(?:\/|\?|$)/) && !isNil(options.data.from_post) && !isNil(options.data.lang);
}

/**
 * Checks if the given REST request is for the creation of a new template part.
 *
 * @param {Object} options The initial request.
 * @return {boolean} True if the request concerns a template part creation.
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
  const hasLangArg = (0,external_this_wp_url_.hasQueryArg)(options.path, 'lang');
  const filterLang = (0,external_lodash_.isUndefined)(options.filterLang) || options.filterLang;
  if (filterLang && !hasLangArg) {
    options.path = (0,external_this_wp_url_.addQueryArgs)(options.path, {
      lang: currentLanguage
    });
  }
}

/**
 * Adds `include_untranslated` parameter to the request.
 *
 * @param {Object} options The initial request.
 * @return {void}
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
 * @return {void}
 */
function maybeRequireIncludeUntranslatedTemplate(options) {
  const params = new URL(document.location).searchParams;
  const postType = params.get('postType');
  const postId = params.get('postId');
  const isEditingTemplate = select(MODULE_POST_EDITOR_KEY)?.isEditingTemplate();
  if ('wp_template_part' === postType && !isNil(postId) || isEditingTemplate) {
    addIncludeUntranslatedParam(options);
  }
}

/**
 * Returns true if the given post is a template part, false otherwise.
 *
 * @param {Object} post A post object.
 * @return {boolean} Whether it is a template part or not.
 */
function isTemplatePart(post) {
  return 'wp_template_part' === post.type;
}

/**
 * Returns the current post type considering the Site Editor or Post Editor.
 *
 * @return {string} The current post type.
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
 * @return {RegExp} The regular expression.
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

/**
 * Adds parameters according to the context of the request.
 *
 * @since 3.5
 *
 * @param {APIFetchOptions} options The options of the request.
 * @return {APIFetchOptions} The modified options of the request.
 */
function addParametersToRequest(options) {
  const currentLangSlug = getCurrentLanguageSlug();

  // `POST` or `PUT` request.
  if (isSaveRequest(options)) {
    /**
     * Use default language for new template part that doesn't exist in any language,
     * otherwise use the current language.
     */
    if (isNewTemplatePartCreationRequest(options)) {
      addLanguageToRequest(options, getDefaultLanguage()?.slug);
    }
    if (!isCurrentPostRequest(options) && !isTemplatePartTranslationCreationRequest(options)) {
      addLanguageToRequest(options, currentLangSlug);
    }
    maybeAddLangSuffixToTemplatePart(options, currentLangSlug);
    return options;
  }
  const currentPostType = getCurrentPostType();

  // Current language is set to default when editing templates.
  if ('wp_template' === currentPostType) {
    addLanguageToRequest(options, getDefaultLanguage()?.slug);
  }
  const templatePartListRegex = new RegExp(/^\/wp\/v2\/template-parts\/?(?:\?.*)?$/);

  // Template part list request.
  if (templatePartListRegex.test(options.path)) {
    maybeRequireIncludeUntranslatedTemplate(options);
  }

  // All kinds of requests.
  addLanguageToRequest(options, currentLangSlug);
  return options;
}

/**
 * Gets language from store or a fallback javascript global variable.
 *
 * @return {string} The language slug.
 */
function getCurrentLanguageSlug() {
  if (isUndefined(select(MODULE_CORE_EDITOR_KEY))) {
    // Return ASAP to avoid issues later.
    return pll_block_editor_plugin_settings.lang.slug;
  }

  // Post block editor case.
  const postLanguage = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
  if (!isUndefined(postLanguage) && postLanguage) {
    return postLanguage;
  }

  // Returns the default lang if the current location is a template part list
  // and update pll_block_editor_plugin_settings at the same time.
  const params = new URL(document.location).searchParams;
  const postType = params.get('postType');
  const postId = params.get('postId');
  if ('wp_template_part' === postType && isNil(postId)) {
    pll_block_editor_plugin_settings.lang = getDefaultLanguage();
    return pll_block_editor_plugin_settings.lang.slug;
  }

  // FSE template editor case.
  const template = getCurrentPostFromDataStore();
  const templateLanguage = template?.lang;
  if (!isUndefined(templateLanguage) && templateLanguage) {
    return templateLanguage;
  }

  // For the first requests block editor isn't initialized yet.
  // So language is retrieved from a javascript global variable initialized server-side.
  return pll_block_editor_plugin_settings.lang.slug;
}

/**
 * Adds the language suffix to a template part only during creation.
 *
 * @param {Object} options  Object representing a REST request.
 * @param {string} langSlug The Language slug to add.
 * @return {void}
 */
function maybeAddLangSuffixToTemplatePart(options, langSlug) {
  const restBaseUrl = getPostsUrl('wp_template_part');
  if (isUndefined(restBaseUrl)) {
    // The user hasn't the rights to edit template part.
    return;
  }
  const templatePartURLRegExp = new RegExp(escapeRegExp(restBaseUrl));
  if ('POST' === options.method && templatePartURLRegExp.test(options.path)) {
    const languages = select(MODULE_KEY).getLanguages();
    const language = languages.get(langSlug);
    if (!language.is_default) {
      // No suffix for default language.
      const langSuffix = TEMPLATE_PART_SLUG_SEPARATOR + langSlug;
      options.data.slug += langSuffix;
    }
  }
}
// EXTERNAL MODULE: external {"this":["wp","apiFetch"]}
var external_this_wp_apiFetch_ = __webpack_require__(631);
var external_this_wp_apiFetch_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_apiFetch_);
;// ./js/src/packages/middlewares/filter-path.js
/**
 * Filters requests for translatable entities.
 * This logic is shared across all Polylang plugins.
 *
 * @since 3.5
 *
 * @param {APIFetchOptions}                           options
 * @param {Array}                                     filteredRoutes
 * @param {function(APIFetchOptions):APIFetchOptions} filter
 * @return {APIFetchOptions} Modified REST request options.
 */
const filterPathMiddleware = (options, filteredRoutes, filter) => {
  const cleanPath = options.path.split('?')[0].replace(/^\/+|\/+$/g, ''); // Get path without query parameters and trim '/'.

  return Object.values(filteredRoutes).find(path => cleanPath === path) ? filter(options) : options;
};
/* harmony default export */ const filter_path = (filterPathMiddleware);
;// ./js/src/packages/middlewares/editors-requests-filter.js
/**
 * WordPress dependencies.
 */


/*
 * Internal dependencies.
 */


/**
 * Safely filters requests for translatable entities in block editor type screens.
 * Ensures that `pllFilteredRoutes` has been well defined on server side and
 * that the filtered request is a REST one.
 *
 * @param {function(APIFetchOptions):APIFetchOptions} filterCallback
 */
const editorsRequestsFilter = filterCallback => {
  external_this_wp_apiFetch_default().use((options, next) => {
    /*
     * If options.url is defined, this is not a REST request but a direct call to post.php for legacy metaboxes.
     * If `filteredRoutes` is not defined, return early.
     */
    if ('undefined' !== typeof options.url || 'undefined' === typeof pllFilteredRoutes) {
      return next(options);
    }
    return next(filter_path(options, pllFilteredRoutes, filterCallback));
  });
};
/* harmony default export */ const editors_requests_filter = (editorsRequestsFilter);
;// ./js/src/packages/middlewares/index.js
/**
 * Available Middlewares.
 */



// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(75);
// EXTERNAL MODULE: external {"this":["wp","compose"]}
var external_this_wp_compose_ = __webpack_require__(897);
// EXTERNAL MODULE: external {"this":["wp","hooks"]}
var external_this_wp_hooks_ = __webpack_require__(873);
// EXTERNAL MODULE: external {"this":["wp","element"]}
var external_this_wp_element_ = __webpack_require__(601);
// EXTERNAL MODULE: external {"this":["wp","blockEditor"]}
var external_this_wp_blockEditor_ = __webpack_require__(89);
// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(959);
// EXTERNAL MODULE: external {"this":["wp","primitives"]}
var external_this_wp_primitives_ = __webpack_require__(933);
// EXTERNAL MODULE: ./node_modules/react/jsx-runtime.js
var jsx_runtime = __webpack_require__(848);
;// ./js/src/packages/icons/library/duplication.js
/**
 * Duplication icon - admin-page Dashicon.
 */

/**
 * WordPress dependencies
 */


const isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const duplication = isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M6 15v-13h10v13h-10zM5 16h8v2h-10v-13h2v11z"
  })
}) : 'admin-page';
/* harmony default export */ const library_duplication = ((/* unused pure expression or super */ null && (duplication)));
;// ./js/src/packages/icons/library/pencil.js
/**
 * Pencil icon - edit Dashicon.
 */

/**
 * WordPress dependencies
 */


const pencil_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const pencil = pencil_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M13.89 3.39l2.71 2.72c0.46 0.46 0.42 1.24 0.030 1.64l-8.010 8.020-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.030c0.39-0.39 1.22-0.39 1.68 0.070zM11.16 6.18l-5.59 5.61 1.11 1.11 5.54-5.65zM8.19 14.41l5.58-5.6-1.070-1.080-5.59 5.6z"
  })
}) : 'edit';
/* harmony default export */ const library_pencil = ((/* unused pure expression or super */ null && (pencil)));
;// ./js/src/packages/icons/library/plus.js
/**
 * Plus icon - plus Dashicon.
 */

/**
 * WordPress dependencies
 */


const plus_isPrimitivesComponents = 'undefined' !== typeof wp.primitive;
const plus = plus_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M17 7v3h-5v5h-3v-5h-5v-3h5v-5h3v5h5z"
  })
}) : 'plus';
/* harmony default export */ const library_plus = ((/* unused pure expression or super */ null && (plus)));
;// ./js/src/packages/icons/library/synchronization.js
/**
 * Synchronization icon - controls-repeat Dashicon.
 */

/**
 * WordPress dependencies
 */


const synchronization_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const synchronization = synchronization_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M5 7v3l-2 1.5v-6.5h11v-2l4 3.010-4 2.99v-2h-9zM15 13v-3l2-1.5v6.5h-11v2l-4-3.010 4-2.99v2h9z"
  })
}) : 'controls-repeat';
/* harmony default export */ const library_synchronization = ((/* unused pure expression or super */ null && (synchronization)));
;// ./js/src/packages/icons/library/translation.js
/**
 * Translation icon - translation Dashicon.
 */

/**
 * WordPress dependencies
 */


const translation_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const translation = translation_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M11 7H9.49c-.63 0-1.25.3-1.59.7L7 5H4.13l-2.39 7h1.69l.74-2H7v4H2c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h7c1.1 0 2 .9 2 2v2zM6.51 9H4.49l1-2.93zM10 8h7c1.1 0 2 .9 2 2v7c0 1.1-.9 2-2 2h-7c-1.1 0-2-.9-2-2v-7c0-1.1.9-2 2-2zm7.25 5v-1.08h-3.17V9.75h-1.16v2.17H9.75V13h1.28c.11.85.56 1.85 1.28 2.62-.87.36-1.89.62-2.31.62-.01.02.22.97.2 1.46.84 0 2.21-.5 3.28-1.15 1.09.65 2.48 1.15 3.34 1.15-.02-.49.2-1.44.2-1.46-.43 0-1.49-.27-2.38-.63.7-.77 1.14-1.77 1.25-2.61h1.36zm-3.81 1.93c-.5-.46-.85-1.13-1.01-1.93h2.09c-.17.8-.51 1.47-1 1.93l-.04.03s-.03-.02-.04-.03z"
  })
}) : 'translation';
/* harmony default export */ const library_translation = (translation);
;// ./js/src/packages/icons/library/trash.js
/**
 * Trash icon - trash Dashicon.
 */

/**
 * WordPress dependencies
 */


const trash_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const trash = trash_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M12 4h3c.6 0 1 .4 1 1v1H3V5c0-.6.5-1 1-1h3c.2-1.1 1.3-2 2.5-2s2.3.9 2.5 2zM8 4h3c-.2-.6-.9-1-1.5-1S8.2 3.4 8 4zM4 7h11l-.9 10.1c0 .5-.5.9-1 .9H5.9c-.5 0-.9-.4-1-.9L4 7z"
  })
}) : 'trash';
/* harmony default export */ const library_trash = ((/* unused pure expression or super */ null && (trash)));
;// ./js/src/packages/icons/library/star.js
/**
 * Star icon - star-filled Dashicon.
 */

/**
 * WordPress dependencies
 */


const star_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const star_star = star_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "m10 1 3 6 6 .75-4.12 4.62L16 19l-6-3-6 3 1.13-6.63L1 7.75 7 7z"
  })
}) : 'star-filled';
/* harmony default export */ const library_star = ((/* unused pure expression or super */ null && (star_star)));
;// ./js/src/packages/icons/library/submenu.js
/**
 * Submenu icon
 */

/**
 * WordPress dependencies
 */


const submenu_isPrimitivesComponents = 'undefined' !== typeof wp.primitives;
const SubmenuIcon = () => submenu_isPrimitivesComponents ? /*#__PURE__*/_jsx(SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  width: "12",
  height: "12",
  viewBox: "0 0 12 12",
  fill: "none",
  children: /*#__PURE__*/_jsx(Path, {
    d: "M1.50002 4L6.00002 8L10.5 4",
    strokeWidth: "1.5"
  })
}) : 'submenu';
/* harmony default export */ const submenu = ((/* unused pure expression or super */ null && (SubmenuIcon)));
;// ./js/src/packages/icons/library/default-lang.js
/**
 * WordPress dependencies
 */



/**
 * Internal dependencies
 */


const DefaultLangIcon = () => /*#__PURE__*/_jsxs(_Fragment, {
  children: [/*#__PURE__*/_jsx(Icon, {
    icon: star,
    className: "pll-default-lang-icon"
  }), /*#__PURE__*/_jsx("span", {
    className: "screen-reader-text",
    children: __('Default language.', 'polylang-pro')
  })]
});
/* harmony default export */ const default_lang = ((/* unused pure expression or super */ null && (DefaultLangIcon)));
;// ./js/src/packages/icons/index.js
/**
 * Icons library
 */










;// ./js/src/packages/components/library/language-flag.js
/* eslint-disable import/no-extraneous-dependencies */
/**
 * External dependencies.
 */


/**
 * Internal dependencies.
 */


/**
 * Displays a flag icon for a given language.
 *
 * @since 3.1
 * @since 3.2 Now its own component.
 *
 * @param {Object} props          LanguageFlag props.
 * @param {Object} props.language Language object for the flag.
 *
 * @return {React.Component} Flag component.
 */

function LanguageFlag({
  language
}) {
  if (!(0,external_lodash_.isNil)(language)) {
    return !(0,external_lodash_.isEmpty)(language.flag_url) ? /*#__PURE__*/(0,jsx_runtime.jsx)("span", {
      className: "pll-select-flag",
      children: /*#__PURE__*/(0,jsx_runtime.jsx)("img", {
        src: language.flag_url,
        alt: language.name,
        title: language.name,
        className: "flag"
      })
    }) : /*#__PURE__*/(0,jsx_runtime.jsxs)("abbr", {
      children: [language.slug, /*#__PURE__*/(0,jsx_runtime.jsx)("span", {
        className: "screen-reader-text",
        children: language.name
      })]
    });
  }
  return /*#__PURE__*/(0,jsx_runtime.jsx)("span", {
    className: "pll-translation-icon",
    children: library_translation
  });
}
/* harmony default export */ const language_flag = (LanguageFlag);
;// ./js/src/packages/components/library/language-dropdown.js
/*
 * Internal dependencies.
 */


/**
 * Displays a dropdown to select a language.
 *
 * @since 3.1
 *
 * @param {Object}          props                  LanguageDropdown props.
 * @param {Function}        props.handleChange     Callback to be executed when language changes.
 * @param {React.Component} props.children         Child components to be used as select options.
 * @param {Object}          props.selectedLanguage An object representing a Polylang Language. Default to null.
 * @param {string}          props.defaultValue     Value to be selected if the selected language is not provided. Default to an empty string.
 *
 * @return {Object} A dropdown selector for languages.
 */

function LanguageDropdown({
  handleChange,
  children,
  selectedLanguage = null,
  defaultValue = ''
}) {
  const selectedLanguageSlug = selectedLanguage?.slug ? selectedLanguage.slug : defaultValue;
  return /*#__PURE__*/(0,jsx_runtime.jsxs)("div", {
    id: "select-post-language",
    children: [/*#__PURE__*/(0,jsx_runtime.jsx)(language_flag, {
      language: selectedLanguage
    }), children && /*#__PURE__*/(0,jsx_runtime.jsx)("select", {
      value: selectedLanguageSlug,
      onChange: event => handleChange(event),
      id: "pll_post_lang_choice",
      name: "pll_post_lang_choice",
      className: "post_lang_choice",
      children: children
    })]
  });
}

/**
 * Maps languages objects as options for a <select> tag.
 *
 * @since 3.1
 *
 * @param {Object} props           LanguagesOptionsList props.
 * @param {Object} props.languages An iterable object containing languages objects.
 *
 * @return {Object} A list of <option> tags to be used in a <select> tag.
 */
function LanguagesOptionsList({
  languages
}) {
  return Array.from(languages.values()).map(({
    slug,
    name,
    w3c
  }) => /*#__PURE__*/(0,jsx_runtime.jsx)("option", {
    value: slug,
    lang: w3c,
    children: name
  }, slug));
}

;// ./js/src/packages/components/index.js
/**
 * UI Components Library
 */




;// ./js/src/editors/common/store/index.js
/**
 * WordPress Dependencies
 */



/**
 * Internal dependencies
 */


const actions = {
  setLanguages(languages) {
    return {
      type: 'SET_LANGUAGES',
      languages
    };
  },
  setCurrentUser(currentUser, save = false) {
    return {
      type: 'SET_CURRENT_USER',
      currentUser,
      save
    };
  },
  setFromPost(fromPost) {
    return {
      type: 'SET_FROM_POST',
      fromPost
    };
  },
  fetchFromAPI(options) {
    return {
      type: 'FETCH_FROM_API',
      options
    };
  }
};
const store = (0,external_this_wp_data_.createReduxStore)(settings_MODULE_KEY, {
  reducer(state = DEFAULT_STATE, action) {
    switch (action.type) {
      case 'SET_LANGUAGES':
        return {
          ...state,
          languages: action.languages
        };
      case 'SET_CURRENT_USER':
        if (action.save) {
          updateCurrentUser(action.currentUser).then(currentUser => {
            action.currentUser = currentUser;
            return {
              ...state,
              currentUser: action.currentUser
            };
          });
        }
        return {
          ...state,
          currentUser: action.currentUser
        };
      case 'SET_FROM_POST':
        return {
          ...state,
          fromPost: action.fromPost
        };
      case 'SET_CURRENT_TEMPLATE_PART':
        return {
          ...state,
          currentTemplatePart: action.currentTemplatePart
        };
      default:
        return state;
    }
  },
  selectors: {
    getLanguages(state) {
      return state.languages;
    },
    getCurrentUser(state) {
      return state.currentUser;
    },
    getFromPost(state) {
      return state.fromPost;
    }
  },
  actions,
  controls: {
    FETCH_FROM_API(action) {
      return external_this_wp_apiFetch_default()({
        ...action.options
      });
    }
  },
  resolvers: {
    *getLanguages() {
      const path = '/pll/v1/languages';
      const languages = yield actions.fetchFromAPI({
        path,
        filterLang: false
      });
      return actions.setLanguages(convertArrayToMap(languages, 'slug'));
    },
    *getCurrentUser() {
      const path = '/wp/v2/users/me';
      const currentUser = yield actions.fetchFromAPI({
        path,
        filterLang: true
      });
      return actions.setCurrentUser(currentUser);
    }
  }
});
(0,external_this_wp_data_.register)(store);

/**
 * Save current user when it is wondered.
 *
 * @param {Object} currentUser
 * @return {Object} The current user updated.
 */
function updateCurrentUser(currentUser) {
  return Promise.resolve(external_this_wp_apiFetch_default()({
    path: '/wp/v2/users/me',
    data: currentUser,
    method: 'POST'
  }));
}
;// ./js/src/editors/widget/language-attribute-control.js
/**
 * Add blocks attributes
 */

/**
 * WordPress Dependencies
 */









/**
 * Internal dependencies
 */




/*
 * Loads Polylang Redux store, used for languages.
 */


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
    return /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_element_.Fragment, {
      children: [/*#__PURE__*/(0,jsx_runtime.jsx)(BlockEdit, {
        ...props
      }), isLanguageFilterable && /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_blockEditor_.InspectorControls, {
        children: /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_components_.PanelBody, {
          title: (0,external_this_wp_i18n_.__)('Languages', 'polylang-pro'),
          children: [/*#__PURE__*/(0,jsx_runtime.jsx)("label", {
            htmlFor: "pll_post_lang_choice",
            children: (0,external_this_wp_i18n_.__)('The block is displayed for:', 'polylang-pro')
          }), /*#__PURE__*/(0,jsx_runtime.jsxs)(LanguageDropdown, {
            selectedLanguage: selectedLanguage,
            handleChange: langChoiceEvent => {
              const langChoice = langChoiceEvent.currentTarget.value;
              props.setAttributes({
                pll_lang: langChoice
              });
            },
            defaultValue: LanguageAttribute.default,
            children: [/*#__PURE__*/(0,jsx_runtime.jsxs)("option", {
              value: LanguageAttribute.default,
              children: [(0,external_this_wp_i18n_.__)('All languages', 'polylang-pro'), ' ']
            }), /*#__PURE__*/(0,jsx_runtime.jsx)(LanguagesOptionsList, {
              languages: languages
            })]
          })]
        })
      })]
    });
  };
}, 'withInspectorControl');
isLanguagesinitialized().then(function () {
  (0,external_this_wp_hooks_.addFilter)('editor.BlockEdit', 'pll/lang-choice-with-inspector-controls', withInspectorControls);
});
;// ./js/src/editors/widget/index.js
/**
 * Internal dependencies.
 */



/*
 * Loads language attribute feature for widget blocks.
 */

editors_requests_filter(
/**
 * Adds default language parameter to a given request.
 *
 * @since 3.5
 *
 * @param {APIFetchOptions} options REST request options.
 * @return {APIFetchOptions} Modified REST request options.
 */
function (options) {
  if ('undefined' !== typeof pll_block_editor_plugin_settings) {
    addLanguageToRequest(options, pll_block_editor_plugin_settings.lang.slug);
  }
  return options;
});
})();

this["polylang-pro"] = __webpack_exports__;
/******/ })()
;