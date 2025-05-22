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

/***/ 89:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blockEditor"]; }());

/***/ }),

/***/ 545:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blocks"]; }());

/***/ }),

/***/ 959:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["components"]; }());

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

/***/ 567:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["serverSideRender"]; }());

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

// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(75);
// EXTERNAL MODULE: external {"this":["wp","blocks"]}
var external_this_wp_blocks_ = __webpack_require__(545);
// EXTERNAL MODULE: external {"this":["wp","element"]}
var external_this_wp_element_ = __webpack_require__(601);
// EXTERNAL MODULE: external {"this":["wp","blockEditor"]}
var external_this_wp_blockEditor_ = __webpack_require__(89);
// EXTERNAL MODULE: external {"this":["wp","hooks"]}
var external_this_wp_hooks_ = __webpack_require__(873);
// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(959);
// EXTERNAL MODULE: external {"this":["wp","serverSideRender"]}
var external_this_wp_serverSideRender_ = __webpack_require__(567);
var external_this_wp_serverSideRender_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_serverSideRender_);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(419);
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
const SubmenuIcon = () => submenu_isPrimitivesComponents ? /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  width: "12",
  height: "12",
  viewBox: "0 0 12 12",
  fill: "none",
  children: /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_primitives_.Path, {
    d: "M1.50002 4L6.00002 8L10.5 4",
    strokeWidth: "1.5"
  })
}) : 'submenu';
/* harmony default export */ const submenu = (SubmenuIcon);
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










;// ./js/src/blocks/language-switcher-edit.js
/**
 * Language switcher block edit.
 */

/**
 * External dependencies
 */


/**
 * WordPress dependencies
 */


/**
 * Call initialization of pll/metabox store for getting ready some data.
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
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.dropdown,
      checked: dropdown,
      onChange: toggleDropdown
    });
  }
  function ToggleControlShowNames() {
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_names,
      checked: show_names // eslint-disable-line camelcase
      ,
      onChange: toggleShowNames
    });
  }
  function ToggleControlShowFlags() {
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_flags,
      checked: show_flags // eslint-disable-line camelcase
      ,
      onChange: toggleShowFlags
    });
  }
  function ToggleControlForceHome() {
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.force_home,
      checked: force_home // eslint-disable-line camelcase
      ,
      onChange: toggleForceHome
    });
  }
  function ToggleControlHideCurrent() {
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_current,
      checked: hide_current // eslint-disable-line camelcase
      ,
      onChange: toggleHideCurrent
    });
  }
  function ToggleControlHideIfNoTranslations() {
    return /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_if_no_translation,
      checked: hide_if_no_translation // eslint-disable-line camelcase
      ,
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
;// ./js/src/blocks/block.js
/**
 * Register language switcher block.
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
    return /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_element_.Fragment, {
      children: [/*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_blockEditor_.InspectorControls, {
        children: /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_components_.PanelBody, {
          title: panelTitle,
          children: [/*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlDropdown, {}), !dropdown && /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlShowNames, {}), !dropdown && /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlShowFlags, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlForceHome, {}), !dropdown && /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlHideCurrent, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlHideIfNoTranslations, {})]
        })
      }), /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.Disabled, {
        children: /*#__PURE__*/(0,jsx_runtime.jsx)((external_this_wp_serverSideRender_default()), {
          block: "polylang/language-switcher",
          attributes: props.attributes
        })
      })]
    });
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
    return /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_element_.Fragment, {
      children: [/*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_blockEditor_.InspectorControls, {
        children: /*#__PURE__*/(0,jsx_runtime.jsxs)(external_this_wp_components_.PanelBody, {
          title: panelTitle,
          children: [/*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlDropdown, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlShowNames, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlShowFlags, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlForceHome, {}), !dropdown && /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlHideCurrent, {}), /*#__PURE__*/(0,jsx_runtime.jsx)(ToggleControlHideIfNoTranslations, {})]
        })
      }), /*#__PURE__*/(0,jsx_runtime.jsx)(external_this_wp_components_.Disabled, {
        children: /*#__PURE__*/(0,jsx_runtime.jsxs)("div", {
          className: "wp-block-navigation-item",
          children: [/*#__PURE__*/(0,jsx_runtime.jsx)((external_this_wp_serverSideRender_default()), {
            block: navigationLanguageSwitcherName,
            attributes: props.attributes,
            className: 'wp-block-navigation__container block-editor-block-list__layout'
          }), submenuIcon(showSubmenuIcon, openSubmenusOnClick, dropdown)]
        })
      })]
    });
  }
});

/**
 * Apply a callback function on each block of the blocks list.
 *
 * @param {Array}  blocks        The list of blocks to process.
 * @param {Array}  menuItems     The initial menu items from where the blocks are converted to.
 * @param {Object} blocksMapping The mapping between the menu items and their corresponding blocks.
 * @param {mapper} mapper        A callback to change the converted block by another one if necessary
 * @return {Array} Array of blocks updated.
 */
function mapBlockTree(blocks, menuItems, blocksMapping, mapper) {
  /**
   * A function to apply to each block to convert it if necessary by applying the `mapper` filter.
   *
   * @param {Object} block The block to replace or not.
   * @return {Object} The new block potentially replaced by the `mapper`.
   */
  const convertBlock = block => ({
    ...mapper(block, menuItems, blocksMapping),
    innerBlocks: mapBlockTree(block.innerBlocks, menuItems, blocksMapping, mapper)
  });
  return blocks.map(convertBlock);
}

/**
 * A filter to detect the `core/navigation-link` block not correctly converted from the language switcher menu item
 * and convert it to its corresponding `polylang/navigation-language-switcher` block.
 *
 * @callback mapper
 * @param {Object} block         The block converted from the menu item.
 * @param {Array}  menuItems     The initial menu items from where the blocks are converted to.
 * @param {Object} blocksMapping The mapping between the menu items and their corresponding blocks.
 * @return {Object} The block correctly converted.
 */
const blocksFilter = (block, menuItems, blocksMapping) => {
  if (block.name === 'core/navigation-link' && block.attributes?.url === '#pll_switcher') {
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
 * @return {Array} Array of blocks updated.
 */
const menuItemsToBlocksFilter = (blocks, menuItems) => ({
  ...blocks,
  innerBlocks: mapBlockTree(blocks.innerBlocks, menuItems, blocks.mapping, blocksFilter)
});

/**
 * Returns the submenu icon if block parameters allow it.
 *
 * @param {boolean} showSubmenuIcon     Whether to show submenu icon or not.
 * @param {boolean} openSubmenusOnClick Whether the submenu can be open on click or not.
 * @param {boolean} dropdown            Whether the language switcher is in dropdown mode or not.
 * @return {HTMLSpanElement|null} The submenu icon or null.
 */
const submenuIcon = (showSubmenuIcon, openSubmenusOnClick, dropdown) => {
  if ((showSubmenuIcon || openSubmenusOnClick) && dropdown) {
    return /*#__PURE__*/(0,jsx_runtime.jsx)("span", {
      className: "wp-block-navigation__submenu-icon",
      children: /*#__PURE__*/(0,jsx_runtime.jsx)(submenu, {})
    });
  }
  return null;
};

/**
 * Hooks to the classic menu conversion to core/navigation block to be able to convert
 * the language switcher menu item to its corresponding block.
 */
(0,external_this_wp_hooks_.addFilter)('blocks.navigation.__unstableMenuItemsToBlocks', 'polylang/include-language-switcher', menuItemsToBlocksFilter);
;// ./js/src/blocks/index.js
/**
 * Registers Polylang block in the editors and enables attributes controls.
 */

})();

this["polylang-pro"] = __webpack_exports__;
/******/ })()
;