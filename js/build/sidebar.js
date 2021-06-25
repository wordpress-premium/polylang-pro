this["polylang-pro"] =
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 506:
/***/ ((module) => {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;

/***/ }),

/***/ 575:
/***/ ((module) => {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;

/***/ }),

/***/ 913:
/***/ ((module) => {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;

/***/ }),

/***/ 713:
/***/ ((module) => {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;

/***/ }),

/***/ 754:
/***/ ((module) => {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;

/***/ }),

/***/ 205:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var setPrototypeOf = __webpack_require__(489);

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;

/***/ }),

/***/ 585:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = __webpack_require__(8);

var assertThisInitialized = __webpack_require__(506);

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;

/***/ }),

/***/ 489:
/***/ ((module) => {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;

/***/ }),

/***/ 8:
/***/ ((module) => {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ 757:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(666);


/***/ }),

/***/ 392:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"this":["wp","element"]}
var external_this_wp_element_ = __webpack_require__(2);
// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(197);
// EXTERNAL MODULE: external {"this":["wp","plugins"]}
var external_this_wp_plugins_ = __webpack_require__(601);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(804);
// EXTERNAL MODULE: external {"this":["wp","editPost"]}
var external_this_wp_editPost_ = __webpack_require__(219);
// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(57);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/classCallCheck.js
var classCallCheck = __webpack_require__(575);
var classCallCheck_default = /*#__PURE__*/__webpack_require__.n(classCallCheck);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/createClass.js
var createClass = __webpack_require__(913);
var createClass_default = /*#__PURE__*/__webpack_require__.n(createClass);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/inherits.js
var inherits = __webpack_require__(205);
var inherits_default = /*#__PURE__*/__webpack_require__.n(inherits);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js
var possibleConstructorReturn = __webpack_require__(585);
var possibleConstructorReturn_default = /*#__PURE__*/__webpack_require__.n(possibleConstructorReturn);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/getPrototypeOf.js
var getPrototypeOf = __webpack_require__(754);
var getPrototypeOf_default = /*#__PURE__*/__webpack_require__.n(getPrototypeOf);
// EXTERNAL MODULE: external {"this":["wp","apiFetch"]}
var external_this_wp_apiFetch_ = __webpack_require__(839);
var external_this_wp_apiFetch_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_apiFetch_);
// EXTERNAL MODULE: external {"this":["wp","url"]}
var external_this_wp_url_ = __webpack_require__(696);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/defineProperty.js
var defineProperty = __webpack_require__(713);
var defineProperty_default = /*#__PURE__*/__webpack_require__.n(defineProperty);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/assertThisInitialized.js
var assertThisInitialized = __webpack_require__(506);
var assertThisInitialized_default = /*#__PURE__*/__webpack_require__.n(assertThisInitialized);
// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(587);
// EXTERNAL MODULE: external {"this":["wp","compose"]}
var external_this_wp_compose_ = __webpack_require__(390);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/confirmation-modal/index.js









function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { defineProperty_default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * Wordpress dependencies
 *
 * @package Polylang-Pro
 */






var ConfirmationModal = /*#__PURE__*/function (_Component) {
  inherits_default()(ConfirmationModal, _Component);

  var _super = _createSuper(ConfirmationModal);

  function ConfirmationModal() {
    var _this;

    classCallCheck_default()(this, ConfirmationModal);

    _this = _super.apply(this, arguments);
    _this.confirmButton = (0,external_this_wp_element_.createRef)();
    return _this;
  }

  createClass_default()(ConfirmationModal, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      this.confirmButton.current.focus();
    }
  }, {
    key: "render",
    value: function render() {
      var _this$props = this.props,
          idPrefix = _this$props.idPrefix,
          title = _this$props.title,
          updateState = _this$props.updateState,
          handleChange = _this$props.handleChange,
          children = _this$props.children; // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

      return (0,external_this_wp_element_.createElement)(external_this_wp_components_.Modal, {
        title: title,
        className: "confirmBox",
        onRequestClose: updateState,
        shouldCloseOnEsc: false,
        shouldCloseOnClickOutside: false,
        focusOnMount: false
      }, children, (0,external_this_wp_element_.createElement)(external_this_wp_components_.ButtonGroup, {
        className: "buttons"
      }, (0,external_this_wp_element_.createElement)(external_this_wp_components_.Button, {
        id: "".concat(idPrefix, "_confirm"),
        ref: this.confirmButton,
        isPrimary: true,
        onClick: function onClick(event) {
          handleChange(event);
          updateState();
        }
      }, (0,external_this_wp_i18n_.__)('OK', 'polylang-pro')), (0,external_this_wp_element_.createElement)(external_this_wp_components_.Button, {
        id: "".concat(idPrefix, "_cancel"),
        isSecondary: true,
        onClick: function onClick() {
          return updateState();
        }
      }, (0,external_this_wp_i18n_.__)('Cancel', 'polylang-pro')))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
    }
  }]);

  return ConfirmationModal;
}(external_this_wp_element_.Component);
/**
 * Control the execution of a component's function with a confirmation modal.
 *
 * @param {string} idPrefix Used to identify the modal's buttons. {@see ConfirmationModal.render()}
 * @param {React.Component} ModalContent Component which contains the content displayed in the confirmation modal.
 * @param {handleChangeCallback} handleChangeCallback Action triggered when we valid the confirmation modal by clicking the confirmation button.
 *
 * @return {Function} Higher-order component.
 */


var withConfirmation = function withConfirmation(idPrefix, ModalContent, handleChangeCallback) {
  return (0,external_this_wp_compose_.createHigherOrderComponent)(
  /**
   * @function Higher-Order Component
   *
   * @param {React.Component} WrappedComponent The component which needs a confirmation to change to its new value.
   * @param {string} WrappedComponent.labelConfirmationModal Used for both WrappedComponent and ConfirmationModal titles.
   * @param {WrappedComponent.getChangeValueCallback} WrappedComponent.getChangeValue
   * @param {WrappedComponent.bypassConfirmationCallback} WrappedComponent.bypassConfirmation
   * @return {WPComponent}
   */
  function (WrappedComponent) {
    var enhanceComponent = /*#__PURE__*/function (_Component2) {
      inherits_default()(enhanceComponent, _Component2);

      var _super2 = _createSuper(enhanceComponent);

      // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent
      function enhanceComponent() {
        var _this2;

        classCallCheck_default()(this, enhanceComponent);

        _this2 = _super2.apply(this, arguments);
        _this2.state = {
          isOpen: false,
          changeValue: null
        };
        _this2.handleChange = _this2.handleChange.bind(assertThisInitialized_default()(_this2));
        return _this2;
      }

      createClass_default()(enhanceComponent, [{
        key: "handleChange",
        value: function handleChange(event) {
          var changeValue = WrappedComponent.getChangeValue(event);

          if (!(0,external_lodash_.isUndefined)(WrappedComponent.bypassConfirmation) && WrappedComponent.bypassConfirmation(this.props.translationData)) {
            handleChangeCallback(changeValue);
          } else {
            this.setState({
              isOpen: true,
              changeValue: changeValue
            });
          }
        }
      }, {
        key: "render",
        value: function render() {
          var _this3 = this;

          var passThroughProps = this.props;
          var wrappedComponentProps = Object.assign({}, _objectSpread({}, passThroughProps), {
            handleChange: this.handleChange
          }); // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

          return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(WrappedComponent, wrappedComponentProps), this.state.isOpen && (0,external_this_wp_element_.createElement)(ConfirmationModal, {
            title: WrappedComponent.labelConfirmationModal,
            idPrefix: idPrefix,
            handleChange: function handleChange() {
              return handleChangeCallback(_this3.state.changeValue);
            },
            updateState: function updateState() {
              return _this3.setState({
                isOpen: false,
                changeValue: null
              });
            }
          }, (0,external_this_wp_element_.createElement)(ModalContent, null))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
        }
      }]);

      return enhanceComponent;
    }(external_this_wp_element_.Component);

    ; // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

    enhanceComponent.bypassConfirmation = WrappedComponent.bypassConfirmation;
    enhanceComponent.getChangeValue = WrappedComponent.getChangeValue;
    return enhanceComponent; // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent
  }, 'withConfirmation');
};
/**
 * Callback to trigger the action to change the value in the Component wrapped by the withConfirmation HOC.
 *
 * @callback handleChangeCallback
 * @param {string} changeValue The value computed by {@see WrappedComponent.getChangeValueCallback}
 */

/**
 * Callback to retrieve the value to change from the Component wrapped by the withConfirmation HOC.
 *
 * @callback WrappedComponent.getChangeValueCallback
 * @param {Event} event A DOM triggered by the wrapped component.
 */

/**
 * Optional callback to check whether the Component wrapped by the withConfirmation HOC need to open the confirmation modal or not.
 *
 * @callback WrappedComponent.bypassConfirmationCallback
 * @param {Object} [translationData] A entry which represents the translation of the current post in a language {@see PLL_REST_Post::get_translations_table()}.
 */


/* harmony default export */ const confirmation_modal = (withConfirmation);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/settings.js
/**
 * Module Constants
 *
 * @package Polylang-Pro
 */
var MODULE_KEY = 'pll/metabox';
var MODULE_CORE_EDITOR_KEY = 'core/editor';
var MODULE_CORE_KEY = 'core';
var DEFAULT_STATE = {
  languages: [],
  selectedLanguage: {},
  translatedPosts: {},
  fromPost: null
};

;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/utils.js
/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */



/**
 * Convert array of object to a map
 *
 * @param {type} array to convert
 * @param {type} key in the object used as key to build map
 * @returns {Map}
 */

function convertArrayToMap(array, key) {
  var map = new Map();
  array.reduce(function (accumulator, currentValue) {
    accumulator.set(currentValue[key], currentValue);
    return accumulator;
  }, map);
  return map;
}
/**
 * Convert map to an associative array
 *
 * @param {Map} map to convert
 * @returns {Object}
 */

function convertMapToObject(map) {
  var object = {};
  map.forEach(function (value, key, map) {
    var obj = this;
    this[key] = (0,external_lodash_.isBoolean)(value) ? value.toString() : value;
  }, object);
  return object;
}
/**
 * Return the post type URL for REST API calls
 *
 * @param {string} post type name
 * @returns {string}
 */

function getPostsUrl(name) {
  var postTypes = select('core').getEntitiesByKind('postType');
  var postType = find(postTypes, {
    name: name
  });
  return postType.baseURL;
}
/**
 * Get all query string parameters and convert them in a URLSearchParams object
 *
 * @returns {object}
 */

function getSearchParams() {
  // Variable window.location.search is just read for creating and returning a URLSearchParams object to be able to manipulate it more easily
  if (!(0,external_lodash_.isEmpty)(window.location.search)) {
    // phpcs:ignore WordPressVIPMinimum.JS.Window.location
    return new URLSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location
  } else {
    return null;
  }
}
/**
 * Get selected language
 *
 * @param string Post language code
 * @returns {Object} Selected Language
 */

function getSelectedLanguage(lang) {
  var languages = (0,external_this_wp_data_.select)(MODULE_KEY).getLanguages(); // Pick up this language as selected in languages list

  return languages.get(lang);
}
/**
 * Get translated posts
 *
 * @param array ids of translated posts
 * @returns {Map}
 */

function getTranslatedPosts(translations, translations_table, lang) {
  var translationsTable = getTranslationsTable(translations_table, lang);
  var fromPost = (0,external_this_wp_data_.select)(MODULE_KEY).getFromPost();
  var translatedPosts = new Map(Object.entries([]));

  if (!(0,external_lodash_.isUndefined)(translations)) {
    translatedPosts = new Map(Object.entries(translations));
  } // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
  // If we come from another post for creating a new one, we have to update translated posts from the original post
  // to be able to update translations attribute of the post


  if (!(0,external_lodash_.isNil)(fromPost) && !(0,external_lodash_.isNil)(fromPost.id)) {
    translationsTable.forEach(function (translationData, lang) {
      if (!(0,external_lodash_.isNil)(translationData.translated_post) && !(0,external_lodash_.isNil)(translationData.translated_post.id)) {
        translatedPosts.set(lang, translationData.translated_post.id);
      }
    });
  } // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent


  return translatedPosts;
}
/**
 * Get synchronized posts
 *
 * @param array ids of synchronized posts
 * @returns {Map}
 */

function getSynchronizedPosts(pll_sync_post) {
  var synchronizedPosts = new Map(Object.entries([]));

  if (!(0,external_lodash_.isUndefined)(pll_sync_post)) {
    synchronizedPosts = new Map(Object.entries(pll_sync_post));
  }

  return synchronizedPosts;
}
/**
 * Get translations table
 *
 * @param object translations table datas
 * @param string language code
 * @returns {Map}
 */

function getTranslationsTable(translationsTableDatas, lang) {
  var translationsTable = new Map(Object.entries([])); // get translations table datas from post

  if (!(0,external_lodash_.isUndefined)(translationsTableDatas)) {
    // Build translations table map with language slug as key
    translationsTable = new Map(Object.entries(translationsTableDatas));
  }

  return translationsTable;
}
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/switcher/index.js







function switcher_createSuper(Derived) { var hasNativeReflectConstruct = switcher_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function switcher_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */







/**
 * Internal dependencies
 */





var Switcher = /*#__PURE__*/function (_Component) {
  inherits_default()(Switcher, _Component);

  var _super = switcher_createSuper(Switcher);

  function Switcher() {
    classCallCheck_default()(this, Switcher);

    return _super.apply(this, arguments);
  }

  createClass_default()(Switcher, [{
    key: "render",
    value: function render() {
      var _this = this;

      var languages = (0,external_this_wp_data_.select)(MODULE_KEY).getLanguages();
      var lang = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
      var selectedLanguage = getSelectedLanguage(lang); // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter, PEAR.Functions.FunctionCallSignature.Indent

      return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)("p", null, (0,external_this_wp_element_.createElement)("strong", null, (0,external_this_wp_i18n_.__)("Language", "polylang-pro"))), (0,external_this_wp_element_.createElement)("label", {
        className: "screen-reader-text",
        htmlFor: "pll_post_lang_choice"
      }, (0,external_this_wp_i18n_.__)("Language", "polylang-pro")), (0,external_this_wp_element_.createElement)("div", {
        id: "select-post-language"
      }, (0,external_this_wp_element_.createElement)("span", {
        className: "pll-select-flag"
      }, !(0,external_lodash_.isEmpty)(selectedLanguage.flag_url) ? (0,external_this_wp_element_.createElement)("span", {
        className: "pll-select-flag"
      }, (0,external_this_wp_element_.createElement)("img", {
        src: selectedLanguage.flag_url,
        alt: selectedLanguage.name,
        title: selectedLanguage.name,
        className: "flag"
      })) : (0,external_this_wp_element_.createElement)("abbr", null, selectedLanguage.slug, (0,external_this_wp_element_.createElement)("span", {
        className: "screen-reader-text"
      }, selectedLanguage.name))), (0,external_this_wp_element_.createElement)("select", {
        value: selectedLanguage.slug,
        onChange: function onChange(event) {
          return _this.props.handleChange(event);
        },
        id: "pll_post_lang_choice",
        name: "pll_post_lang_choice",
        className: "post_lang_choice"
      }, Array.from(languages.values()).map(function (_ref) {
        var slug = _ref.slug,
            name = _ref.name,
            w3c = _ref.w3c;
        return (0,external_this_wp_element_.createElement)("option", {
          value: slug,
          lang: w3c,
          key: slug
        }, name);
      })))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter, PEAR.Functions.FunctionCallSignature.Indent
    }
  }], [{
    key: "bypassConfirmation",
    value: function bypassConfirmation() {
      var editor = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY);
      return !editor.getEditedPostAttribute('title') && !editor.getEditedPostContent() && !editor.getEditedPostAttribute('excerpt');
    }
  }, {
    key: "getChangeValue",
    value: function getChangeValue(event) {
      return event.target.value;
    }
    /**
     * Manage language choice in the dropdown list
     *
     * @param language New language slug.
     */

  }, {
    key: "handleLanguageChange",
    value: function handleLanguageChange(language) {
      var oldLanguageSlug = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
      var postId = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPostId();
      var languages = (0,external_this_wp_data_.select)(MODULE_KEY).getLanguages();
      var newLanguage = languages.get(language);
      var oldSelectedLanguage = getSelectedLanguage(oldLanguageSlug);
      var pll_sync_post = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('pll_sync_post');
      var synchronizedPosts = getSynchronizedPosts(pll_sync_post);
      var translations_table = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
      var translations = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations');
      var translatedPosts = getTranslatedPosts(translations, translations_table, oldSelectedLanguage.slug);
      var translationsTable = getTranslationsTable(translations_table, oldSelectedLanguage.slug); // The translated post of the previous selected language must be deleted

      translatedPosts.delete(oldSelectedLanguage.slug); // Replace translated post for the new language

      translatedPosts.set(newLanguage.slug, postId); // The current post is synchronized itself and synchronization must be deleted for the previous language
      // to ensure it will be not synchronized with the new language

      synchronizedPosts.delete(oldSelectedLanguage.slug); // Update translations table
      // Add old selected language datas - only datas needed just to update visually the metabox

      var oldTranslationData = translationsTable.get(oldSelectedLanguage.slug);
      translationsTable.set(oldSelectedLanguage.slug, {
        can_synchronize: oldTranslationData.can_synchronize,
        lang: oldTranslationData.lang,
        links: {
          add_link: oldTranslationData.links.add_link
        }
      }); // Update some new language datas from the old selected language datas

      var newTranslationData = translationsTable.get(newLanguage.slug);
      translationsTable.set(newLanguage.slug, {
        can_synchronize: newTranslationData.can_synchronize,
        lang: newTranslationData.lang,
        links: oldTranslationData.links,
        translated_post: oldTranslationData.translated_post
      }); // Update the global javascript variable for maintaining it updated outside block editor context

      pll_block_editor_plugin_settings = newLanguage; // And save changes in store

      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        lang: newLanguage.slug
      });
      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        pll_sync_post: convertMapToObject(synchronizedPosts)
      });
      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        translations: convertMapToObject(translatedPosts)
      });
      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        translations_table: convertMapToObject(translationsTable)
      }); // Need to save post for recalculating permalink

      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).savePost();
      Switcher.forceLanguageSave(oldSelectedLanguage.slug);
      Switcher.invalidateParentPagesStoredInCore();
    }
    /**
     * Even if no content has been written, Polylang back-end code needs the correct language to send back the correct metadatas. (e.g.: Attachable Medias).
     *
     * @since 3.0
     *
     * @param {string} lang A language slug.
     */

  }, {
    key: "forceLanguageSave",
    value: function forceLanguageSave(lang) {
      var editor = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY);

      if (!editor.getEditedPostAttribute('title') && !editor.getEditedPostContent() && !editor.getEditedPostAttribute('excerpt')) {
        external_this_wp_apiFetch_default()({
          path: (0,external_this_wp_url_.addQueryArgs)("wp/v2/posts/".concat(editor.getCurrentPostId()), // phpcs:ignore WordPress.WhiteSpace.OperatorSpacing
          {
            lang: lang
          }),
          method: 'POST'
        });
      }
    }
    /**
     * Invalidate resolution of parent page attribute request to redo it
     * and refresh the list of pages filtered with the right language
     */

  }, {
    key: "invalidateParentPagesStoredInCore",
    value: function invalidateParentPagesStoredInCore() {
      // invalidate cache on parent pages attribute
      // arguments must be exactly the same as the getEntityRecords done in the parent pages component of the editor
      var postId = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPostId();
      var postTypeSlug = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('type');
      var query = {
        per_page: -1,
        exclude: postId,
        parent_exclude: postId,
        orderby: 'menu_order',
        order: 'asc'
      };
      (0,external_this_wp_data_.dispatch)('core/data').invalidateResolution('core', 'getEntityRecords', ['postType', postTypeSlug, query]);
    }
  }]);

  return Switcher;
}(external_this_wp_element_.Component);

Switcher.labelConfirmationModal = (0,external_this_wp_i18n_.__)('Change language', 'polylang-pro');

var ModalContent = function ModalContent() {
  // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
  return (0,external_this_wp_element_.createElement)("p", null, (0,external_this_wp_i18n_.__)('Are you sure you want to change the language of the current content?', 'polylang-pro')); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
};

var SwitcherWithConfirmation = confirmation_modal('pll_change_lang', ModalContent, Switcher.handleLanguageChange)(Switcher);
/* harmony default export */ const switcher = (SwitcherWithConfirmation);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/typeof.js
var helpers_typeof = __webpack_require__(8);
var typeof_default = /*#__PURE__*/__webpack_require__.n(helpers_typeof);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/duplicate-button/index.js









function duplicate_button_createSuper(Derived) { var hasNativeReflectConstruct = duplicate_button_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function duplicate_button_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */







var DuplicateButton = /*#__PURE__*/function (_Component) {
  inherits_default()(DuplicateButton, _Component);

  var _super = duplicate_button_createSuper(DuplicateButton);

  function DuplicateButton() {
    var _this;

    classCallCheck_default()(this, DuplicateButton);

    _this = _super.apply(this, arguments);
    var currentUser = (0,external_this_wp_data_.select)(MODULE_KEY).getCurrentUser();
    _this.postType = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPostType();
    _this.state = {
      isDuplicateActive: _this.isDuplicateActive(currentUser),
      currentUser: currentUser
    };
    _this.handleDuplicateContentChange = _this.handleDuplicateContentChange.bind(assertThisInitialized_default()(_this));
    _this.setState = _this.setState.bind(assertThisInitialized_default()(_this));
    return _this;
  }
  /**
   * Read if content duplicate tool is active or not
   *
   * @param {type} user
   * @returns {Boolean}
   */


  createClass_default()(DuplicateButton, [{
    key: "isDuplicateActive",
    value: function isDuplicateActive(user) {
      if (undefined === typeof_default()(user.pll_duplicate_content) || undefined === typeof_default()(user.pll_duplicate_content[this.postType])) {
        return false;
      }

      return user.pll_duplicate_content[this.postType];
    }
    /**
     * Manage Duplicate content change by clicking on the icon
     *
     * @param {type} event
     */

  }, {
    key: "handleDuplicateContentChange",
    value: function handleDuplicateContentChange(event) {
      var currentUser = this.state.currentUser; // If pll_duplicate_content user meta is a string, it have never been created
      // So we initialize it as an object

      if ((0,external_lodash_.isString)(currentUser.pll_duplicate_content)) {
        currentUser.pll_duplicate_content = {};
      }

      currentUser.pll_duplicate_content[this.postType] = !this.state.isDuplicateActive; // update component state

      this.setState({
        currentUser: currentUser,
        isDuplicateActive: !this.state.isDuplicateActive
      }); // and update currentUser in store

      (0,external_this_wp_data_.dispatch)(MODULE_KEY).setCurrentUser({
        pll_duplicate_content: currentUser.pll_duplicate_content
      }, true);
    }
  }, {
    key: "render",
    value: function render() {
      var isDuplicateActive = this.state.isDuplicateActive;
      /* translators: accessibility text */

      var duplicateButtonText = this.state.isDuplicateActive ? (0,external_this_wp_i18n_.__)('Deactivate the content duplication', 'polylang-pro') : (0,external_this_wp_i18n_.__)('Activate the content duplication', 'polylang-pro'); // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

      return (0,external_this_wp_element_.createElement)(external_this_wp_components_.IconButton, {
        id: "pll-duplicate",
        className: "pll-button ".concat(isDuplicateActive && "wp-ui-text-highlight"),
        onClick: this.handleDuplicateContentChange,
        icon: "admin-page",
        label: duplicateButtonText
      }, (0,external_this_wp_element_.createElement)("span", {
        className: "screen-reader-text"
      }, duplicateButtonText)); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
    }
  }]);

  return DuplicateButton;
}(external_this_wp_element_.Component);

/* harmony default export */ const duplicate_button = (DuplicateButton);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/synchronization-button/index.js







function synchronization_button_createSuper(Derived) { var hasNativeReflectConstruct = synchronization_button_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function synchronization_button_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */





/**
 * Internal dependencies
 */





var SynchronizationButton = /*#__PURE__*/function (_Component) {
  inherits_default()(SynchronizationButton, _Component);

  var _super = synchronization_button_createSuper(SynchronizationButton);

  function SynchronizationButton() {
    classCallCheck_default()(this, SynchronizationButton);

    return _super.apply(this, arguments);
  }
  /**
   * Manage synchronziation with translated posts
   *
   * @param {type} event
   */


  createClass_default()(SynchronizationButton, [{
    key: "render",
    value: function render() {
      var _this = this;

      var pll_sync_post = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('pll_sync_post');
      var synchronizedPosts = getSynchronizedPosts(pll_sync_post);
      var translationData = this.props.translationData;
      var isSynchronized = !(0,external_lodash_.isEmpty)(synchronizedPosts) && synchronizedPosts.has(translationData.lang.slug);
      var highlightButtonClass = isSynchronized && 'wp-ui-text-highlight';
      var synchronizeButtonText = isSynchronized ? (0,external_this_wp_i18n_.__)("Don't synchronize this post", 'polylang-pro') : (0,external_this_wp_i18n_.__)('Synchronize this post', 'polylang-pro'); // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

      return (0,external_this_wp_element_.createElement)(external_this_wp_components_.IconButton, {
        icon: "controls-repeat",
        label: synchronizeButtonText,
        id: "pll_sync_post[".concat(translationData.lang.slug, "]"),
        className: "pll-button ".concat(highlightButtonClass),
        onClick: function onClick(event) {
          _this.props.handleChange(event);
        }
      }, (0,external_this_wp_element_.createElement)("span", {
        className: "screen-reader-text"
      }, synchronizeButtonText)); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
    }
  }], [{
    key: "handleSynchronizationChange",
    value: function handleSynchronizationChange(language) {
      var pll_sync_post = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('pll_sync_post');
      var synchronizedPosts = getSynchronizedPosts(pll_sync_post);

      if (synchronizedPosts.has(language)) {
        synchronizedPosts.delete(language);
      } else {
        synchronizedPosts.set(language, true);
      } // and store the new value


      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        pll_sync_post: convertMapToObject(synchronizedPosts)
      }); // simulate a post modification to change status of the publish/update button

      (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
        title: (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('title')
      });
    }
  }, {
    key: "bypassConfirmation",
    value: function bypassConfirmation(translationData) {
      var pll_sync_post = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('pll_sync_post');
      var synchronizedPosts = getSynchronizedPosts(pll_sync_post);
      var isSynchronized = !(0,external_lodash_.isEmpty)(synchronizedPosts) && synchronizedPosts.has(translationData.lang.slug);
      var isTranslated = !(0,external_lodash_.isUndefined)(translationData.translated_post) && !(0,external_lodash_.isNil)(translationData.translated_post.id);
      return isSynchronized || !isTranslated;
    }
  }, {
    key: "getChangeValue",
    value: function getChangeValue(event) {
      return event.currentTarget.id.match(/\[(.[^[]+)\]/i)[1];
    }
  }]);

  return SynchronizationButton;
}(external_this_wp_element_.Component);

SynchronizationButton.labelConfirmationModal = (0,external_this_wp_i18n_.__)('Synchronize this post', 'polylang-pro');

var synchronization_button_ModalContent = function ModalContent() {
  // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
  return (0,external_this_wp_element_.createElement)("p", null, (0,external_this_wp_i18n_.__)('You are about to overwrite an existing translation. Are you sure you want to proceed?', 'polylang-pro')); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
};

var SynchronizationButtonWithConfirmation = confirmation_modal('pll_sync_post', synchronization_button_ModalContent, SynchronizationButton.handleSynchronizationChange)(SynchronizationButton); // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine

/* harmony default export */ const synchronization_button = (SynchronizationButtonWithConfirmation);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/add-edit-link/index.js


/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */





/**
 * Internal dependencies
 */



var AddEditLink = function AddEditLink(_ref) {
  var translationData = _ref.translationData;
  var isTranslated = !(0,external_lodash_.isUndefined)(translationData.translated_post) && !(0,external_lodash_.isNil)(translationData.translated_post.id);
  var currentUserCanEdit = !(0,external_lodash_.isUndefined)(translationData.links) && !(0,external_lodash_.isNil)(translationData.links.edit_link);
  var translationIcon = 'plus';
  /* translators: accessibility text, %s is a native language name. For example Deutsch for German or Français for french. */

  var translationScreenReaderText = (0,external_this_wp_i18n_.sprintf)((0,external_this_wp_i18n_.__)('Add a translation in %s', 'polylang-pro'), translationData.lang.name);
  var translationUrl = decodeURI(translationData.links.add_link);

  if (isTranslated) {
    translationIcon = 'edit';
    /* translators: accessibility text, %s is a native language name. For example Deutsch for German or Français for french. */

    translationScreenReaderText = (0,external_this_wp_i18n_.sprintf)((0,external_this_wp_i18n_.__)('Edit the translation in %s', 'polylang-pro'), translationData.lang.name);
    translationUrl = decodeURI(translationData.links.edit_link);
  } // if the current user can't edit return nothing


  if (!currentUserCanEdit && isTranslated) {
    return null;
  } // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter


  return (0,external_this_wp_element_.createElement)(external_this_wp_components_.IconButton, {
    href: translationUrl,
    icon: translationIcon,
    label: translationScreenReaderText
  }, (0,external_this_wp_element_.createElement)("span", {
    className: "screen-reader-text"
  }, translationScreenReaderText)); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
};

/* harmony default export */ const add_edit_link = (AddEditLink);
// EXTERNAL MODULE: ./node_modules/classnames/index.js
var classnames = __webpack_require__(184);
var classnames_default = /*#__PURE__*/__webpack_require__.n(classnames);
;// CONCATENATED MODULE: ./node_modules/dom-scroll-into-view/dist-web/index.js
function _typeof(obj) {
  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function (obj) {
      return typeof obj;
    };
  } else {
    _typeof = function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function dist_web_ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);

  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    if (enumerableOnly) symbols = symbols.filter(function (sym) {
      return Object.getOwnPropertyDescriptor(object, sym).enumerable;
    });
    keys.push.apply(keys, symbols);
  }

  return keys;
}

function _objectSpread2(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};

    if (i % 2) {
      dist_web_ownKeys(source, true).forEach(function (key) {
        _defineProperty(target, key, source[key]);
      });
    } else if (Object.getOwnPropertyDescriptors) {
      Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
    } else {
      dist_web_ownKeys(source).forEach(function (key) {
        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
      });
    }
  }

  return target;
}

var RE_NUM = /[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source;

function getClientPosition(elem) {
  var box;
  var x;
  var y;
  var doc = elem.ownerDocument;
  var body = doc.body;
  var docElem = doc && doc.documentElement; // 根据 GBS 最新数据，A-Grade Browsers 都已支持 getBoundingClientRect 方法，不用再考虑传统的实现方式

  box = elem.getBoundingClientRect(); // 注：jQuery 还考虑减去 docElem.clientLeft/clientTop
  // 但测试发现，这样反而会导致当 html 和 body 有边距/边框样式时，获取的值不正确
  // 此外，ie6 会忽略 html 的 margin 值，幸运地是没有谁会去设置 html 的 margin

  x = box.left;
  y = box.top; // In IE, most of the time, 2 extra pixels are added to the top and left
  // due to the implicit 2-pixel inset border.  In IE6/7 quirks mode and
  // IE6 standards mode, this border can be overridden by setting the
  // document element's border to zero -- thus, we cannot rely on the
  // offset always being 2 pixels.
  // In quirks mode, the offset can be determined by querying the body's
  // clientLeft/clientTop, but in standards mode, it is found by querying
  // the document element's clientLeft/clientTop.  Since we already called
  // getClientBoundingRect we have already forced a reflow, so it is not
  // too expensive just to query them all.
  // ie 下应该减去窗口的边框吧，毕竟默认 absolute 都是相对窗口定位的
  // 窗口边框标准是设 documentElement ,quirks 时设置 body
  // 最好禁止在 body 和 html 上边框 ，但 ie < 9 html 默认有 2px ，减去
  // 但是非 ie 不可能设置窗口边框，body html 也不是窗口 ,ie 可以通过 html,body 设置
  // 标准 ie 下 docElem.clientTop 就是 border-top
  // ie7 html 即窗口边框改变不了。永远为 2
  // 但标准 firefox/chrome/ie9 下 docElem.clientTop 是窗口边框，即使设了 border-top 也为 0

  x -= docElem.clientLeft || body.clientLeft || 0;
  y -= docElem.clientTop || body.clientTop || 0;
  return {
    left: x,
    top: y
  };
}

function getScroll(w, top) {
  var ret = w["page".concat(top ? 'Y' : 'X', "Offset")];
  var method = "scroll".concat(top ? 'Top' : 'Left');

  if (typeof ret !== 'number') {
    var d = w.document; // ie6,7,8 standard mode

    ret = d.documentElement[method];

    if (typeof ret !== 'number') {
      // quirks mode
      ret = d.body[method];
    }
  }

  return ret;
}

function getScrollLeft(w) {
  return getScroll(w);
}

function getScrollTop(w) {
  return getScroll(w, true);
}

function getOffset(el) {
  var pos = getClientPosition(el);
  var doc = el.ownerDocument;
  var w = doc.defaultView || doc.parentWindow;
  pos.left += getScrollLeft(w);
  pos.top += getScrollTop(w);
  return pos;
}

function _getComputedStyle(elem, name, computedStyle_) {
  var val = '';
  var d = elem.ownerDocument;
  var computedStyle = computedStyle_ || d.defaultView.getComputedStyle(elem, null); // https://github.com/kissyteam/kissy/issues/61

  if (computedStyle) {
    val = computedStyle.getPropertyValue(name) || computedStyle[name];
  }

  return val;
}

var _RE_NUM_NO_PX = new RegExp("^(".concat(RE_NUM, ")(?!px)[a-z%]+$"), 'i');

var RE_POS = /^(top|right|bottom|left)$/;
var CURRENT_STYLE = 'currentStyle';
var RUNTIME_STYLE = 'runtimeStyle';
var LEFT = 'left';
var PX = 'px';

function _getComputedStyleIE(elem, name) {
  // currentStyle maybe null
  // http://msdn.microsoft.com/en-us/library/ms535231.aspx
  var ret = elem[CURRENT_STYLE] && elem[CURRENT_STYLE][name]; // 当 width/height 设置为百分比时，通过 pixelLeft 方式转换的 width/height 值
  // 一开始就处理了! CUSTOM_STYLE.height,CUSTOM_STYLE.width ,cssHook 解决@2011-08-19
  // 在 ie 下不对，需要直接用 offset 方式
  // borderWidth 等值也有问题，但考虑到 borderWidth 设为百分比的概率很小，这里就不考虑了
  // From the awesome hack by Dean Edwards
  // http://erik.eae.net/archives/2007/07/27/18.54.15/#comment-102291
  // If we're not dealing with a regular pixel number
  // but a number that has a weird ending, we need to convert it to pixels
  // exclude left right for relativity

  if (_RE_NUM_NO_PX.test(ret) && !RE_POS.test(name)) {
    // Remember the original values
    var style = elem.style;
    var left = style[LEFT];
    var rsLeft = elem[RUNTIME_STYLE][LEFT]; // prevent flashing of content

    elem[RUNTIME_STYLE][LEFT] = elem[CURRENT_STYLE][LEFT]; // Put in the new values to get a computed value out

    style[LEFT] = name === 'fontSize' ? '1em' : ret || 0;
    ret = style.pixelLeft + PX; // Revert the changed values

    style[LEFT] = left;
    elem[RUNTIME_STYLE][LEFT] = rsLeft;
  }

  return ret === '' ? 'auto' : ret;
}

var getComputedStyleX;

if (typeof window !== 'undefined') {
  getComputedStyleX = window.getComputedStyle ? _getComputedStyle : _getComputedStyleIE;
}

function each(arr, fn) {
  for (var i = 0; i < arr.length; i++) {
    fn(arr[i]);
  }
}

function isBorderBoxFn(elem) {
  return getComputedStyleX(elem, 'boxSizing') === 'border-box';
}

var BOX_MODELS = ['margin', 'border', 'padding'];
var CONTENT_INDEX = -1;
var PADDING_INDEX = 2;
var BORDER_INDEX = 1;
var MARGIN_INDEX = 0;

function swap(elem, options, callback) {
  var old = {};
  var style = elem.style;
  var name; // Remember the old values, and insert the new ones

  for (name in options) {
    if (options.hasOwnProperty(name)) {
      old[name] = style[name];
      style[name] = options[name];
    }
  }

  callback.call(elem); // Revert the old values

  for (name in options) {
    if (options.hasOwnProperty(name)) {
      style[name] = old[name];
    }
  }
}

function getPBMWidth(elem, props, which) {
  var value = 0;
  var prop;
  var j;
  var i;

  for (j = 0; j < props.length; j++) {
    prop = props[j];

    if (prop) {
      for (i = 0; i < which.length; i++) {
        var cssProp = void 0;

        if (prop === 'border') {
          cssProp = "".concat(prop + which[i], "Width");
        } else {
          cssProp = prop + which[i];
        }

        value += parseFloat(getComputedStyleX(elem, cssProp)) || 0;
      }
    }
  }

  return value;
}
/**
 * A crude way of determining if an object is a window
 * @member util
 */


function isWindow(obj) {
  // must use == for ie8

  /* eslint eqeqeq:0 */
  return obj != null && obj == obj.window;
}

var domUtils = {};
each(['Width', 'Height'], function (name) {
  domUtils["doc".concat(name)] = function (refWin) {
    var d = refWin.document;
    return Math.max( // firefox chrome documentElement.scrollHeight< body.scrollHeight
    // ie standard mode : documentElement.scrollHeight> body.scrollHeight
    d.documentElement["scroll".concat(name)], // quirks : documentElement.scrollHeight 最大等于可视窗口多一点？
    d.body["scroll".concat(name)], domUtils["viewport".concat(name)](d));
  };

  domUtils["viewport".concat(name)] = function (win) {
    // pc browser includes scrollbar in window.innerWidth
    var prop = "client".concat(name);
    var doc = win.document;
    var body = doc.body;
    var documentElement = doc.documentElement;
    var documentElementProp = documentElement[prop]; // 标准模式取 documentElement
    // backcompat 取 body

    return doc.compatMode === 'CSS1Compat' && documentElementProp || body && body[prop] || documentElementProp;
  };
});
/*
 得到元素的大小信息
 @param elem
 @param name
 @param {String} [extra]  'padding' : (css width) + padding
 'border' : (css width) + padding + border
 'margin' : (css width) + padding + border + margin
 */

function getWH(elem, name, extra) {
  if (isWindow(elem)) {
    return name === 'width' ? domUtils.viewportWidth(elem) : domUtils.viewportHeight(elem);
  } else if (elem.nodeType === 9) {
    return name === 'width' ? domUtils.docWidth(elem) : domUtils.docHeight(elem);
  }

  var which = name === 'width' ? ['Left', 'Right'] : ['Top', 'Bottom'];
  var borderBoxValue = name === 'width' ? elem.offsetWidth : elem.offsetHeight;
  var computedStyle = getComputedStyleX(elem);
  var isBorderBox = isBorderBoxFn(elem);
  var cssBoxValue = 0;

  if (borderBoxValue == null || borderBoxValue <= 0) {
    borderBoxValue = undefined; // Fall back to computed then un computed css if necessary

    cssBoxValue = getComputedStyleX(elem, name);

    if (cssBoxValue == null || Number(cssBoxValue) < 0) {
      cssBoxValue = elem.style[name] || 0;
    } // Normalize '', auto, and prepare for extra


    cssBoxValue = parseFloat(cssBoxValue) || 0;
  }

  if (extra === undefined) {
    extra = isBorderBox ? BORDER_INDEX : CONTENT_INDEX;
  }

  var borderBoxValueOrIsBorderBox = borderBoxValue !== undefined || isBorderBox;
  var val = borderBoxValue || cssBoxValue;

  if (extra === CONTENT_INDEX) {
    if (borderBoxValueOrIsBorderBox) {
      return val - getPBMWidth(elem, ['border', 'padding'], which);
    }

    return cssBoxValue;
  }

  if (borderBoxValueOrIsBorderBox) {
    var padding = extra === PADDING_INDEX ? -getPBMWidth(elem, ['border'], which) : getPBMWidth(elem, ['margin'], which);
    return val + (extra === BORDER_INDEX ? 0 : padding);
  }

  return cssBoxValue + getPBMWidth(elem, BOX_MODELS.slice(extra), which);
}

var cssShow = {
  position: 'absolute',
  visibility: 'hidden',
  display: 'block'
}; // fix #119 : https://github.com/kissyteam/kissy/issues/119

function getWHIgnoreDisplay(elem) {
  var val;
  var args = arguments; // in case elem is window
  // elem.offsetWidth === undefined

  if (elem.offsetWidth !== 0) {
    val = getWH.apply(undefined, args);
  } else {
    swap(elem, cssShow, function () {
      val = getWH.apply(undefined, args);
    });
  }

  return val;
}

function css(el, name, v) {
  var value = v;

  if (_typeof(name) === 'object') {
    for (var i in name) {
      if (name.hasOwnProperty(i)) {
        css(el, i, name[i]);
      }
    }

    return undefined;
  }

  if (typeof value !== 'undefined') {
    if (typeof value === 'number') {
      value += 'px';
    }

    el.style[name] = value;
    return undefined;
  }

  return getComputedStyleX(el, name);
}

each(['width', 'height'], function (name) {
  var first = name.charAt(0).toUpperCase() + name.slice(1);

  domUtils["outer".concat(first)] = function (el, includeMargin) {
    return el && getWHIgnoreDisplay(el, name, includeMargin ? MARGIN_INDEX : BORDER_INDEX);
  };

  var which = name === 'width' ? ['Left', 'Right'] : ['Top', 'Bottom'];

  domUtils[name] = function (elem, val) {
    if (val !== undefined) {
      if (elem) {
        var computedStyle = getComputedStyleX(elem);
        var isBorderBox = isBorderBoxFn(elem);

        if (isBorderBox) {
          val += getPBMWidth(elem, ['padding', 'border'], which);
        }

        return css(elem, name, val);
      }

      return undefined;
    }

    return elem && getWHIgnoreDisplay(elem, name, CONTENT_INDEX);
  };
}); // 设置 elem 相对 elem.ownerDocument 的坐标

function setOffset(elem, offset) {
  // set position first, in-case top/left are set even on static elem
  if (css(elem, 'position') === 'static') {
    elem.style.position = 'relative';
  }

  var old = getOffset(elem);
  var ret = {};
  var current;
  var key;

  for (key in offset) {
    if (offset.hasOwnProperty(key)) {
      current = parseFloat(css(elem, key)) || 0;
      ret[key] = current + offset[key] - old[key];
    }
  }

  css(elem, ret);
}

var util = _objectSpread2({
  getWindow: function getWindow(node) {
    var doc = node.ownerDocument || node;
    return doc.defaultView || doc.parentWindow;
  },
  offset: function offset(el, value) {
    if (typeof value !== 'undefined') {
      setOffset(el, value);
    } else {
      return getOffset(el);
    }
  },
  isWindow: isWindow,
  each: each,
  css: css,
  clone: function clone(obj) {
    var ret = {};

    for (var i in obj) {
      if (obj.hasOwnProperty(i)) {
        ret[i] = obj[i];
      }
    }

    var overflow = obj.overflow;

    if (overflow) {
      for (var _i in obj) {
        if (obj.hasOwnProperty(_i)) {
          ret.overflow[_i] = obj.overflow[_i];
        }
      }
    }

    return ret;
  },
  scrollLeft: function scrollLeft(w, v) {
    if (isWindow(w)) {
      if (v === undefined) {
        return getScrollLeft(w);
      }

      window.scrollTo(v, getScrollTop(w));
    } else {
      if (v === undefined) {
        return w.scrollLeft;
      }

      w.scrollLeft = v;
    }
  },
  scrollTop: function scrollTop(w, v) {
    if (isWindow(w)) {
      if (v === undefined) {
        return getScrollTop(w);
      }

      window.scrollTo(getScrollLeft(w), v);
    } else {
      if (v === undefined) {
        return w.scrollTop;
      }

      w.scrollTop = v;
    }
  },
  viewportWidth: 0,
  viewportHeight: 0
}, domUtils);

function scrollIntoView(elem, container, config) {
  config = config || {}; // document 归一化到 window

  if (container.nodeType === 9) {
    container = util.getWindow(container);
  }

  var allowHorizontalScroll = config.allowHorizontalScroll;
  var onlyScrollIfNeeded = config.onlyScrollIfNeeded;
  var alignWithTop = config.alignWithTop;
  var alignWithLeft = config.alignWithLeft;
  var offsetTop = config.offsetTop || 0;
  var offsetLeft = config.offsetLeft || 0;
  var offsetBottom = config.offsetBottom || 0;
  var offsetRight = config.offsetRight || 0;
  allowHorizontalScroll = allowHorizontalScroll === undefined ? true : allowHorizontalScroll;
  var isWin = util.isWindow(container);
  var elemOffset = util.offset(elem);
  var eh = util.outerHeight(elem);
  var ew = util.outerWidth(elem);
  var containerOffset;
  var ch;
  var cw;
  var containerScroll;
  var diffTop;
  var diffBottom;
  var win;
  var winScroll;
  var ww;
  var wh;

  if (isWin) {
    win = container;
    wh = util.height(win);
    ww = util.width(win);
    winScroll = {
      left: util.scrollLeft(win),
      top: util.scrollTop(win)
    }; // elem 相对 container 可视视窗的距离

    diffTop = {
      left: elemOffset.left - winScroll.left - offsetLeft,
      top: elemOffset.top - winScroll.top - offsetTop
    };
    diffBottom = {
      left: elemOffset.left + ew - (winScroll.left + ww) + offsetRight,
      top: elemOffset.top + eh - (winScroll.top + wh) + offsetBottom
    };
    containerScroll = winScroll;
  } else {
    containerOffset = util.offset(container);
    ch = container.clientHeight;
    cw = container.clientWidth;
    containerScroll = {
      left: container.scrollLeft,
      top: container.scrollTop
    }; // elem 相对 container 可视视窗的距离
    // 注意边框, offset 是边框到根节点

    diffTop = {
      left: elemOffset.left - (containerOffset.left + (parseFloat(util.css(container, 'borderLeftWidth')) || 0)) - offsetLeft,
      top: elemOffset.top - (containerOffset.top + (parseFloat(util.css(container, 'borderTopWidth')) || 0)) - offsetTop
    };
    diffBottom = {
      left: elemOffset.left + ew - (containerOffset.left + cw + (parseFloat(util.css(container, 'borderRightWidth')) || 0)) + offsetRight,
      top: elemOffset.top + eh - (containerOffset.top + ch + (parseFloat(util.css(container, 'borderBottomWidth')) || 0)) + offsetBottom
    };
  }

  if (diffTop.top < 0 || diffBottom.top > 0) {
    // 强制向上
    if (alignWithTop === true) {
      util.scrollTop(container, containerScroll.top + diffTop.top);
    } else if (alignWithTop === false) {
      util.scrollTop(container, containerScroll.top + diffBottom.top);
    } else {
      // 自动调整
      if (diffTop.top < 0) {
        util.scrollTop(container, containerScroll.top + diffTop.top);
      } else {
        util.scrollTop(container, containerScroll.top + diffBottom.top);
      }
    }
  } else {
    if (!onlyScrollIfNeeded) {
      alignWithTop = alignWithTop === undefined ? true : !!alignWithTop;

      if (alignWithTop) {
        util.scrollTop(container, containerScroll.top + diffTop.top);
      } else {
        util.scrollTop(container, containerScroll.top + diffBottom.top);
      }
    }
  }

  if (allowHorizontalScroll) {
    if (diffTop.left < 0 || diffBottom.left > 0) {
      // 强制向上
      if (alignWithLeft === true) {
        util.scrollLeft(container, containerScroll.left + diffTop.left);
      } else if (alignWithLeft === false) {
        util.scrollLeft(container, containerScroll.left + diffBottom.left);
      } else {
        // 自动调整
        if (diffTop.left < 0) {
          util.scrollLeft(container, containerScroll.left + diffTop.left);
        } else {
          util.scrollLeft(container, containerScroll.left + diffBottom.left);
        }
      }
    } else {
      if (!onlyScrollIfNeeded) {
        alignWithLeft = alignWithLeft === undefined ? true : !!alignWithLeft;

        if (alignWithLeft) {
          util.scrollLeft(container, containerScroll.left + diffTop.left);
        } else {
          util.scrollLeft(container, containerScroll.left + diffBottom.left);
        }
      }
    }
  }
}

/* harmony default export */ const dist_web = (scrollIntoView);
//# sourceMappingURL=index.js.map

// EXTERNAL MODULE: external {"this":["wp","htmlEntities"]}
var external_this_wp_htmlEntities_ = __webpack_require__(664);
// EXTERNAL MODULE: external {"this":["wp","keycodes"]}
var external_this_wp_keycodes_ = __webpack_require__(750);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/translation-input/index.js








function translation_input_createSuper(Derived) { var hasNativeReflectConstruct = translation_input_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function translation_input_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * External dependencies
 *
 * @package Polylang-Pro
 */



/**
 * WordPress dependencies
 */










/**
 * Internal dependencies
 */

 // Since TranslationInput is rendered in the context of other inputs, but should be
// considered a separate modal node, prevent keyboard events from propagating
// as being considered from the input.

var stopEventPropagation = function stopEventPropagation(event) {
  return event.stopPropagation();
};

var TranslationInput = /*#__PURE__*/function (_Component) {
  inherits_default()(TranslationInput, _Component);

  var _super = translation_input_createSuper(TranslationInput);

  function TranslationInput() {
    var _this;

    classCallCheck_default()(this, TranslationInput);

    _this = _super.apply(this, arguments);
    _this.onChange = _this.onChange.bind(assertThisInitialized_default()(_this));
    _this.onKeyDown = _this.onKeyDown.bind(assertThisInitialized_default()(_this));
    _this.bindListNode = _this.bindListNode.bind(assertThisInitialized_default()(_this));
    _this.updateSuggestions = (0,external_lodash_.throttle)(_this.updateSuggestions.bind(assertThisInitialized_default()(_this)), 200);
    _this.suggestionNodes = [];
    _this.state = {
      posts: [],
      showSuggestions: false,
      selectedSuggestion: null
    };
    return _this;
  }

  createClass_default()(TranslationInput, [{
    key: "componentDidUpdate",
    value: function componentDidUpdate() {
      var _this2 = this;

      var _this$state = this.state,
          showSuggestions = _this$state.showSuggestions,
          selectedSuggestion = _this$state.selectedSuggestion; // only have to worry about scrolling selected suggestion into view
      // when already expanded

      if (showSuggestions && selectedSuggestion !== null && !this.scrollingIntoView) {
        this.scrollingIntoView = true;
        dist_web(this.suggestionNodes[selectedSuggestion], this.listNode, {
          onlyScrollIfNeeded: true
        });
        setTimeout(function () {
          _this2.scrollingIntoView = false; // phpcs:ignore PEAR.Functions.FunctionCallSignature.Indent
        }, 100);
      }
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      delete this.suggestionsRequest;
    }
  }, {
    key: "bindListNode",
    value: function bindListNode(ref) {
      this.listNode = ref;
    }
  }, {
    key: "bindSuggestionNode",
    value: function bindSuggestionNode(index) {
      var _this3 = this;

      return function (ref) {
        _this3.suggestionNodes[index] = ref;
      };
    }
  }, {
    key: "updateSuggestions",
    value: function updateSuggestions(value) {
      var _this4 = this;

      var noControl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

      // Show the suggestions after typing at least 2 characters
      // and also for URLs
      if (value.length < 2 && !noControl) {
        this.setState({
          showSuggestions: false,
          selectedSuggestion: null,
          loading: false
        });
        return;
      }

      this.setState({
        selectedSuggestion: null,
        loading: true
      });
      var postId = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPostId();
      var postType = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPostType();
      var postLanguageSlug = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
      var translationLanguageSlug = this.props.translationData.lang.slug; // language for the suggestion

      var request = external_this_wp_apiFetch_default()({
        path: (0,external_this_wp_url_.addQueryArgs)('/pll/v1/untranslated-posts', {
          search: value,
          include: postId,
          untranslated_in: postLanguageSlug,
          lang: translationLanguageSlug,
          type: postType,
          is_block_editor: true
        }),
        filterLang: false // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact

      }); // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine

      request.then(function (posts) {
        // A fetch Promise doesn't have an abort option. It's mimicked by
        // comparing the request reference in on the instance, which is
        // reset or deleted on subsequent requests or unmounting.
        if (_this4.suggestionsRequest !== request) {
          return;
        }

        _this4.setState({
          posts: posts,
          showSuggestions: true,
          loading: false
        });

        if (!!posts.length) {
          // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact, WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
          _this4.props.debouncedSpeak((0,external_this_wp_i18n_.sprintf)(
          /* translators: accessibility text. %d is a number of posts. */
          (0,external_this_wp_i18n_._n)('%d result found, use up and down arrow keys to navigate.', '%d results found, use up and down arrow keys to navigate.', posts.length, 'polylang-pro'), posts.length), 'assertive');
        } else {
          // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact

          /* translators: accessibility text */
          _this4.props.debouncedSpeak((0,external_this_wp_i18n_.__)('No results.', 'polylang-pro'), 'assertive');
        } // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact

      }).catch(function () {
        if (_this4.suggestionsRequest === request) {
          _this4.setState({
            loading: false
          });
        }
      }); // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine

      this.suggestionsRequest = request;
    }
  }, {
    key: "onChange",
    value: function onChange(event) {
      var inputValue = event.target.value;
      var translatedPosts = this.props.translatedPosts;
      var translationsTable = this.props.translationsTable;
      var language = this.props.translationData.lang;
      this.props.onChange({
        value: inputValue,
        translatedPosts: translatedPosts,
        translationsTable: translationsTable,
        language: language
      });
      this.updateSuggestions(inputValue);
    }
  }, {
    key: "onKeyDown",
    value: function onKeyDown(event) {
      var _this$state2 = this.state,
          showSuggestions = _this$state2.showSuggestions,
          selectedSuggestion = _this$state2.selectedSuggestion,
          posts = _this$state2.posts,
          loading = _this$state2.loading;
      var inputValue = event.target.value;
      var doUpdateSuggestions = false; // If the suggestions are not shown or loading, we shouldn't handle the arrow keys
      // We shouldn't preventDefault to allow block arrow keys navigation

      if (!showSuggestions || !posts.length || loading) {
        switch (event.keyCode) {
          case external_this_wp_keycodes_.SPACE:
            var ctrlKey = event.ctrlKey,
                shiftKey = event.shiftKey,
                altKey = event.altKey,
                metaKey = event.metaKey;

            if (ctrlKey && !(shiftKey || altKey || metaKey)) {
              inputValue = '';
              doUpdateSuggestions = true;
            }

            break;

          case external_this_wp_keycodes_.BACKSPACE:
            if ((0,external_lodash_.isEmpty)(inputValue)) {
              doUpdateSuggestions = true;
            }

            break;
        }

        if (doUpdateSuggestions) {
          this.updateSuggestions(inputValue, true);
        }

        return;
      }

      switch (event.keyCode) {
        case external_this_wp_keycodes_.UP:
          {
            event.stopPropagation();
            event.preventDefault();
            var previousIndex = !selectedSuggestion ? posts.length - 1 : selectedSuggestion - 1;
            this.setState({
              selectedSuggestion: previousIndex
            });
            break;
          }

        case external_this_wp_keycodes_.DOWN:
          {
            event.stopPropagation();
            event.preventDefault();
            var nextIndex = selectedSuggestion === null || selectedSuggestion === posts.length - 1 ? 0 : selectedSuggestion + 1;
            this.setState({
              selectedSuggestion: nextIndex
            });
            break;
          }

        case external_this_wp_keycodes_.ENTER:
          {
            if (this.state.selectedSuggestion !== null) {
              event.stopPropagation();
              var post = this.state.posts[this.state.selectedSuggestion];
              this.selectLink(post);
            }

            break;
          }

        case external_this_wp_keycodes_.ESCAPE:
          {
            event.stopPropagation();
            this.setState({
              selectedSuggestion: null,
              showSuggestions: false
            });
            break;
          }
      }
    }
  }, {
    key: "selectLink",
    value: function selectLink(post) {
      var translationsTable = this.props.translationsTable;
      var translatedPosts = this.props.translatedPosts;
      var language = this.props.translationData.lang;
      this.props.onChange({
        value: post.title.rendered,
        post: post,
        translatedPosts: translatedPosts,
        translationsTable: translationsTable,
        language: language
      });
      this.setState({
        selectedSuggestion: null,
        showSuggestions: false
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this5 = this;

      var _this$props = this.props,
          _this$props$value = _this$props.value,
          value = _this$props$value === void 0 ? '' : _this$props$value,
          _this$props$autoFocus = _this$props.autoFocus,
          autoFocus = _this$props$autoFocus === void 0 ? true : _this$props$autoFocus,
          instanceId = _this$props.instanceId,
          translationData = _this$props.translationData;
      var language = translationData.lang;
      var _this$state3 = this.state,
          showSuggestions = _this$state3.showSuggestions,
          posts = _this$state3.posts,
          selectedSuggestion = _this$state3.selectedSuggestion,
          loading = _this$state3.loading;
      var currentUserCanEdit = !(0,external_lodash_.isUndefined)(translationData.links) && ((0,external_lodash_.isUndefined)(translationData.links.edit_link) || !(0,external_lodash_.isUndefined)(translationData.links.edit_link) && !(0,external_lodash_.isNull)(translationData.links.edit_link)); // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

      return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)("div", {
        className: "translation-input"
      }, (0,external_this_wp_element_.createElement)("input", {
        lang: language.w3c,
        dir: language.is_rtl ? 'rtl' : 'ltr',
        style: {
          direction: language.is_rtl ? 'rtl' : 'ltr'
        },
        autoFocus: autoFocus,
        disabled: !currentUserCanEdit,
        type: "text",
        "aria-label":
        /* translators: accessibility text */
        (0,external_this_wp_i18n_.__)('URL', 'polylang-pro'),
        required: true,
        value: value,
        onChange: this.onChange,
        onInput: stopEventPropagation,
        placeholder: (0,external_this_wp_i18n_.__)('Start typing the post title', 'polylang-pro'),
        onKeyDown: this.onKeyDown,
        role: "combobox",
        "aria-expanded": showSuggestions,
        "aria-autocomplete": "list",
        "aria-owns": "translation-input-suggestions-".concat(instanceId),
        "aria-activedescendant": selectedSuggestion !== null ? "translation-input-suggestion-".concat(instanceId, "-").concat(selectedSuggestion) : undefined
      }), loading && (0,external_this_wp_element_.createElement)(external_this_wp_components_.Spinner, null)), showSuggestions && !!posts.length && (0,external_this_wp_element_.createElement)(external_this_wp_components_.Popover, {
        position: "bottom",
        noArrow: true,
        focusOnMount: false
      }, (0,external_this_wp_element_.createElement)("div", {
        className: "translation-input__suggestions",
        id: "translation-input-suggestions-".concat(instanceId),
        ref: this.bindListNode,
        role: "listbox"
      }, posts.map(function (post, index) {
        return (0,external_this_wp_element_.createElement)("button", {
          key: post.id,
          role: "option",
          tabIndex: "-1",
          id: "translation-input-suggestion-".concat(instanceId, "-").concat(index),
          ref: _this5.bindSuggestionNode(index),
          className: classnames_default()('translation-input__suggestion', {
            'is-selected': index === selectedSuggestion
          }),
          onClick: function onClick() {
            return _this5.selectLink(post);
          },
          "aria-selected": index === selectedSuggestion
        }, (0,external_this_wp_htmlEntities_.decodeEntities)(post.title.rendered) || (0,external_this_wp_i18n_.__)('(no title)', 'polylang-pro'));
      })))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
    }
  }]);

  return TranslationInput;
}(external_this_wp_element_.Component);

/* harmony default export */ const translation_input = ((0,external_this_wp_components_.withSpokenMessages)((0,external_this_wp_compose_.withInstanceId)(TranslationInput)));
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/translations-table/index.js


/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */



/**
 * Internal dependencies
 */







var onChange = function onChange(_ref) {
  var value = _ref.value,
      _ref$post = _ref.post,
      post = _ref$post === void 0 ? null : _ref$post,
      translatedPosts = _ref.translatedPosts,
      translationsTable = _ref.translationsTable,
      language = _ref.language;
  var translationData = translationsTable.get(language.slug);

  if ((0,external_lodash_.isEmpty)(post)) {
    translationData.translated_post = {
      id: null,
      title: value
    };
    translationData.links = {
      add_link: translationData.links.add_link
    }; // unlink translation

    translatedPosts.delete(language.slug);
  } else {
    translatedPosts.set(language.slug, post.id);
    translationData.translated_post = {
      id: post.id,
      title: post.title.rendered
    };
    translationData.links.edit_link = post.edit_link;
  } // update translations table in store


  translationsTable.set(language.slug, translationData);
  (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
    translations: convertMapToObject(translatedPosts)
  }); // simulate a post modification to change status of the publish/update button

  (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
    title: (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('title')
  });
};

var TranslationsTable = function TranslationsTable(_ref2) {
  var selectedLanguage = _ref2.selectedLanguage,
      translationsTable = _ref2.translationsTable,
      translatedPosts = _ref2.translatedPosts,
      synchronizedPosts = _ref2.synchronizedPosts,
      handleSynchronizationChange = _ref2.handleSynchronizationChange;
  // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter, Generic.Formatting.MultipleStatementAlignment.IncorrectWarning
  return (0,external_this_wp_element_.createElement)("div", {
    id: "post-translations",
    className: "translations"
  }, (0,external_this_wp_element_.createElement)("p", null, (0,external_this_wp_element_.createElement)("strong", null, (0,external_this_wp_i18n_.__)("Translations", "polylang-pro"))), (0,external_this_wp_element_.createElement)("table", null, (0,external_this_wp_element_.createElement)("tbody", null, Array.from(translationsTable.values()).map( // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine
  function (translationData) {
    var isSynchronized = !(0,external_lodash_.isEmpty)(synchronizedPosts) && synchronizedPosts.has(translationData.lang.slug);
    var isTranslated = !(0,external_lodash_.isUndefined)(translationData.translated_post) && !(0,external_lodash_.isNil)(translationData.translated_post.id);
    var synchronizeButtonText = isSynchronized ? (0,external_this_wp_i18n_.__)("Don't synchronize this post", 'polylang-pro') : (0,external_this_wp_i18n_.__)('Synchronize this post', 'polylang-pro');
    return selectedLanguage.slug !== translationData.lang.slug && (0,external_this_wp_element_.createElement)("tr", {
      key: translationData.lang.slug
    }, (0,external_this_wp_element_.createElement)("th", {
      className: "pll-language-column"
    }, !(0,external_lodash_.isEmpty)(translationData.lang.flag) ? (0,external_this_wp_element_.createElement)("span", {
      className: "pll-select-flag flag"
    }, (0,external_this_wp_element_.createElement)("img", {
      src: translationData.lang.flag_url,
      alt: translationData.lang.name,
      title: translationData.lang.name
    })) : (0,external_this_wp_element_.createElement)("abbr", null, translationData.lang.slug, (0,external_this_wp_element_.createElement)("span", {
      className: "screen-reader-text"
    }, translationData.lang.name))), (0,external_this_wp_element_.createElement)("td", {
      className: "pll-edit-column pll-column-icon"
    }, (0,external_this_wp_element_.createElement)(add_edit_link, {
      translationData: translationData
    })), (0,external_this_wp_element_.createElement)("td", {
      className: "pll-sync-column pll-column-icon"
    }, translationData.can_synchronize && (0,external_this_wp_element_.createElement)(synchronization_button, {
      translationData: translationData
    })), (0,external_this_wp_element_.createElement)("td", {
      className: "pll-translation-column"
    }, (0,external_this_wp_element_.createElement)("label", {
      className: "screen-reader-text",
      htmlFor: "tr_lang_".concat(translationData.lang.slug)
    },
    /* translators: accessibility text */
    (0,external_this_wp_i18n_.__)('Translation', 'polylang-pro')), (0,external_this_wp_element_.createElement)(translation_input, {
      id: "htr_lang_".concat(translationData.lang.slug),
      autoFocus: false,
      translationsTable: translationsTable,
      translatedPosts: translatedPosts,
      translationData: translationData,
      value: !(0,external_lodash_.isUndefined)(translationData.translated_post) ? translationData.translated_post.title : '',
      onChange: onChange
    }))); // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine
  })))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter, Generic.Formatting.MultipleStatementAlignment.IncorrectWarning
};

/* harmony default export */ const translations_table = (TranslationsTable);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/metabox/index.js







function metabox_createSuper(Derived) { var hasNativeReflectConstruct = metabox_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = getPrototypeOf_default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = getPrototypeOf_default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return possibleConstructorReturn_default()(this, result); }; }

function metabox_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */


/**
 * Internal dependencies
 */







var MetaBox = /*#__PURE__*/function (_Component) {
  inherits_default()(MetaBox, _Component);

  var _super = metabox_createSuper(MetaBox);

  function MetaBox() {
    classCallCheck_default()(this, MetaBox);

    return _super.apply(this, arguments);
  }
  /**
   * Render the language metabox
   */


  createClass_default()(MetaBox, [{
    key: "render",
    value: function render() {
      // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
      return (0,external_this_wp_element_.createElement)("div", {
        className: "components-panel__body is-opened"
      }, (0,external_this_wp_element_.createElement)("form", {
        className: "pll-metabox-location"
      }, (0,external_this_wp_element_.createElement)(switcher, null), (0,external_this_wp_element_.createElement)(duplicate_button, null), (0,external_this_wp_element_.createElement)(translations_table, {
        selectedLanguage: this.props.selectedLanguage,
        translationsTable: this.props.translationsTable,
        synchronizedPosts: this.props.synchronizedPosts,
        translatedPosts: this.props.translatedPosts
      }))); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
    }
  }]);

  return MetaBox;
}(external_this_wp_element_.Component); // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent, PEAR.Functions.FunctionCallSignature.EmptyLine

/**
 * High Order Component to wrap polylang sidebar component
 */


var wrapLanguagesPanel = function wrapLanguagesPanel(select) {
  var lang = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
  var translations_table = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
  var translations = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations');
  var pll_sync_post = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('pll_sync_post');
  var selectedLanguage = getSelectedLanguage(lang);
  var translationsTable = getTranslationsTable(translations_table, lang);
  var translatedPosts = getTranslatedPosts(translations, translations_table, lang);
  var synchronizedPosts = getSynchronizedPosts(pll_sync_post);
  return {
    selectedLanguage: selectedLanguage,
    translationsTable: translationsTable,
    translatedPosts: translatedPosts,
    synchronizedPosts: synchronizedPosts
  };
};

var MetaBoxWatch = (0,external_this_wp_data_.withSelect)(wrapLanguagesPanel)(MetaBox);
/* harmony default export */ const metabox = (MetaBoxWatch);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/sidebar/index.js


/**
 * WordPress dependencies
 *
 * @package Polylang-Pro
 */


/**
 * Internal Dependencies
 */

 // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

var Sidebar = function Sidebar() {
  return (0,external_this_wp_element_.createElement)(external_this_wp_editPost_.PluginSidebar, {
    name: "polylang-sidebar",
    title: (0,external_this_wp_i18n_.__)('Languages', 'polylang-pro')
  }, (0,external_this_wp_element_.createElement)(metabox, null));
}; // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter


/* harmony default export */ const sidebar = (Sidebar);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/components/menu-item/index.js


/**
 * @package Polylang-Pro
 */

 // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter

var MenuItem = function MenuItem() {
  return (0,external_this_wp_element_.createElement)(external_this_wp_editPost_.PluginSidebarMoreMenuItem, {
    target: "polylang-sidebar"
  }, (0,external_this_wp_i18n_.__)("Languages", "polylang-pro"));
}; // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter


/* harmony default export */ const menu_item = (MenuItem);
// EXTERNAL MODULE: ./node_modules/@babel/runtime/regenerator/index.js
var regenerator = __webpack_require__(757);
var regenerator_default = /*#__PURE__*/__webpack_require__.n(regenerator);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/store/index.js



function store_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function store_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { store_ownKeys(Object(source), true).forEach(function (key) { defineProperty_default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { store_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */



/**
 * Internal dependencies
 */



var actions = {
  setLanguages: function setLanguages(languages) {
    return {
      type: 'SET_LANGUAGES',
      languages: languages
    };
  },
  setCurrentUser: function setCurrentUser(currentUser) {
    var save = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    return {
      type: 'SET_CURRENT_USER',
      currentUser: currentUser,
      save: save
    };
  },
  setFromPost: function setFromPost(fromPost) {
    return {
      type: 'SET_FROM_POST',
      fromPost: fromPost
    };
  },
  fetchFromAPI: function fetchFromAPI(options) {
    return {
      type: 'FETCH_FROM_API',
      options: options
    };
  }
};
var store = (0,external_this_wp_data_.registerStore)(MODULE_KEY, {
  reducer: function reducer() {
    var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : DEFAULT_STATE;
    var action = arguments.length > 1 ? arguments[1] : undefined;

    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    switch (action.type) {
      case 'SET_LANGUAGES':
        return store_objectSpread(store_objectSpread({}, state), {}, {
          languages: action.languages
        });

      case 'SET_CURRENT_USER':
        if (action.save) {
          updateCurrentUser(action.currentUser);
        }

        return store_objectSpread(store_objectSpread({}, state), {}, {
          currentUser: action.currentUser
        });

      case 'SET_FROM_POST':
        return store_objectSpread(store_objectSpread({}, state), {}, {
          fromPost: action.fromPost
        });

      default:
        return state;
    } // phpcs:enable Generic.WhiteSpace.ScopeIndent.IncorrectExact

  },
  selectors: {
    getLanguages: function getLanguages(state) {
      return state.languages;
    },
    getCurrentUser: function getCurrentUser(state) {
      return state.currentUser;
    },
    getFromPost: function getFromPost(state) {
      return state.fromPost;
    }
  },
  actions: actions,
  controls: {
    FETCH_FROM_API: function FETCH_FROM_API(action) {
      return external_this_wp_apiFetch_default()(store_objectSpread({}, action.options));
    }
  },
  resolvers: {
    getLanguages: /*#__PURE__*/regenerator_default().mark(function getLanguages() {
      var path, languages;
      return regenerator_default().wrap(function getLanguages$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              path = '/pll/v1/languages';
              _context.next = 3;
              return actions.fetchFromAPI({
                path: path,
                filterLang: false
              });

            case 3:
              languages = _context.sent;
              return _context.abrupt("return", actions.setLanguages(convertArrayToMap(languages, 'slug')));

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, getLanguages);
    }),
    getCurrentUser: /*#__PURE__*/regenerator_default().mark(function getCurrentUser() {
      var path, currentUser;
      return regenerator_default().wrap(function getCurrentUser$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              path = '/wp/v2/users/me';
              _context2.next = 3;
              return actions.fetchFromAPI({
                path: path,
                filterLang: true
              });

            case 3:
              currentUser = _context2.sent;
              return _context2.abrupt("return", actions.setCurrentUser(currentUser));

            case 5:
            case "end":
              return _context2.stop();
          }
        }
      }, getCurrentUser);
    })
  }
});
/**
 * Initialize some store data to ensure data is ready before displaying metabox
 */

function initializeStore() {
  // Call to getLanguages to force call to resolvers and initialize state.
  var languages = (0,external_this_wp_data_.select)(MODULE_KEY).getLanguages(); // Call to getCurrentUser to force call to resolvers and initialize state.

  var currentUser = (0,external_this_wp_data_.select)(MODULE_KEY).getCurrentUser(); // Save url params espacially when a new translation is creating.

  saveURLParams();
}
/**
 * Set a promise for waiting for the current post has been fully loaded and languages list is correctly initialized before making other processes.
 */

var initializeLanguages = new Promise(function (resolve, reject) {
  var unsubscribe = (0,external_this_wp_data_.subscribe)(function () {
    var languages = (0,external_this_wp_data_.select)(MODULE_KEY).getLanguages();
    var currentPost = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getCurrentPost();

    if (!(0,external_lodash_.isEmpty)(currentPost) && languages.size > 0) {
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
  var searchParams = getSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location

  if (null !== searchParams) {
    (0,external_this_wp_data_.dispatch)(MODULE_KEY).setFromPost({
      id: wp.sanitize.stripTagsAndEncodeText(searchParams.get('from_post')),
      postType: wp.sanitize.stripTagsAndEncodeText(searchParams.get('post_type')),
      newLanguage: wp.sanitize.stripTagsAndEncodeText(searchParams.get('new_lang'))
    });
  }
}
/**
 * Save current user when it is wondered
 *
 * @param {object} currentUser
 */

function updateCurrentUser(currentUser) {
  external_this_wp_apiFetch_default()({
    path: '/wp/v2/users/me',
    data: currentUser,
    method: 'POST'
  });
}

/* harmony default export */ const sidebar_store = ((/* unused pure expression or super */ null && (store)));
// EXTERNAL MODULE: external {"this":["wp","primitives"]}
var external_this_wp_primitives_ = __webpack_require__(684);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/translation.js


/**
 * Translation icon
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var translation = isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M11 7H9.49c-.63 0-1.25.3-1.59.7L7 5H4.13l-2.39 7h1.69l.74-2H7v4H2c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h7c1.1 0 2 .9 2 2v2zM6.51 9H4.49l1-2.93zM10 8h7c1.1 0 2 .9 2 2v7c0 1.1-.9 2-2 2h-7c-1.1 0-2-.9-2-2v-7c0-1.1.9-2 2-2zm7.25 5v-1.08h-3.17V9.75h-1.16v2.17H9.75V13h1.28c.11.85.56 1.85 1.28 2.62-.87.36-1.89.62-2.31.62-.01.02.22.97.2 1.46.84 0 2.21-.5 3.28-1.15 1.09.65 2.48 1.15 3.34 1.15-.02-.49.2-1.44.2-1.46-.43 0-1.49-.27-2.38-.63.7-.77 1.14-1.77 1.25-2.61h1.36zm-3.81 1.93c-.5-.46-.85-1.13-1.01-1.93h2.09c-.17.8-.51 1.47-1 1.93l-.04.03s-.03-.02-.04-.03z"
})) : 'translation';
/* harmony default export */ const library_translation = (translation);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/index.js
/**
 * Icons library
 *
 * @package Polylang-Pro
 */

;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/index.js


/**
 * Import styles
 *
 * @package Polylang-Pro
 */

/**
 * WordPress Dependencies
 */





/**
 * Internal dependencies
 */







/**
 * Call initialization of pll/metabox store for getting ready some datas
 */

initializeStore();

var PolylangSidebar = function PolylangSidebar() {
  // phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
  return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(sidebar, null), (0,external_this_wp_element_.createElement)(menu_item, null)); // phpcs:enable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
};

initializeLanguages.then(function () {
  // If we come from another post for creating a new one, we have to update translations from the original post.
  var fromPost = (0,external_this_wp_data_.select)(MODULE_KEY).getFromPost();

  if (!(0,external_lodash_.isNil)(fromPost) && !(0,external_lodash_.isNil)(fromPost.id)) {
    var lang = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
    var translations = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations');
    var translations_table = (0,external_this_wp_data_.select)(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
    var translatedPosts = getTranslatedPosts(translations, translations_table, lang);
    (0,external_this_wp_data_.dispatch)(MODULE_CORE_EDITOR_KEY).editPost({
      translations: convertMapToObject(translatedPosts)
    });
  }
  /**
   * Register plugin polylang-sidebar
   */


  (0,external_this_wp_plugins_.registerPlugin)("polylang-sidebar", {
    icon: library_translation,
    render: PolylangSidebar
  });
});

/***/ }),

/***/ 184:
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg) && arg.length) {
				var inner = classNames.apply(null, arg);
				if (inner) {
					classes.push(inner);
				}
			} else if (argType === 'object') {
				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ 666:
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
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

/***/ 587:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["components"]; }());

/***/ }),

/***/ 390:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["compose"]; }());

/***/ }),

/***/ 197:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["data"]; }());

/***/ }),

/***/ 219:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["editPost"]; }());

/***/ }),

/***/ 2:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["element"]; }());

/***/ }),

/***/ 664:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["htmlEntities"]; }());

/***/ }),

/***/ 57:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["i18n"]; }());

/***/ }),

/***/ 750:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["keycodes"]; }());

/***/ }),

/***/ 601:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["plugins"]; }());

/***/ }),

/***/ 684:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["primitives"]; }());

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
/******/ 	return __webpack_require__(392);
/******/ })()
;