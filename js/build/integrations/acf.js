/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 631:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["apiFetch"]; }());

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
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(631);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);
/**
 * WordPress dependencies.
 */

document.addEventListener('onPostLangChoice', e => {
  const fields = [];

  // Adds relationship fields to the fields to be refreshed.
  const relationshipFields = document.querySelectorAll('.acf-field-relationship');
  relationshipFields.forEach(function (relationshipField) {
    const field = relationshipField.getAttribute('data-key');
    fields.push(field);
  });

  // Adds post object fields to the fields to be refreshed.
  const postObjectFields = document.querySelectorAll('.acf-field-post-object');
  postObjectFields.forEach(function (postObjectField) {
    const field = postObjectField.getAttribute('data-key');
    fields.push(field);
  });

  // Adds taxonomy fields to the fields to be refreshed.
  const taxonomyFields = document.querySelectorAll('.acf-field-taxonomy');
  taxonomyFields.forEach(function (taxonomyField) {
    const field = taxonomyField.getAttribute('data-key');
    fields.push(field);
  });
  if (0 < fields.length) {
    const postId = document.getElementById('post_ID').getAttribute('value');
    let nonce = document.querySelector('#_pll_nonce')?.value; // Classic editor.
    if (undefined === nonce) {
      // Block editor.
      nonce = pll_block_editor_plugin_settings.nonce;
    }
    const data = new FormData();
    data.set('action', 'acf_post_lang_choice');
    data.set('lang', encodeURI(e.detail.lang.slug));
    data.set('fields', fields);
    data.set('post_id', postId);
    data.set('_pll_nonce', nonce);
    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
      url: ajaxurl,
      method: 'POST',
      body: data
    }).then(response => {
      response.forEach(function (res) {
        // Data comes from ACF field and server side.
        const field = document.querySelector('.acf-' + res.field_key);
        field.outerHTML = res.field_data;
        acf.do_action('ready_field/type=' + field.getAttribute('data-type'), field);
      });
      if (0 < relationshipFields.length) {
        // We need to reload the choices list for relationship fields (otherwise it remains empty).
        relationshipFields.forEach(function (relationshipField) {
          acf.getField(relationshipField.getAttribute('data-key')).fetch();
        });
      }

      // Reloads the list of posts in `post_object` fields.
      acf.getFields({
        type: 'post_object'
      });
    });
  }
});
})();

this["polylang-pro"] = __webpack_exports__;
/******/ })()
;