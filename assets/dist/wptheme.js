/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/lazyloader.js":
/*!*************************************!*\
  !*** ./assets/src/js/lazyloader.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ \"jquery\");\nclass Lazyloader {\n  constructor() {\n    console.log('Lazy Loader'); // Images with lazy loader\n\n    this.images = $('img[data-src]'); // Elements with lazy load background\n\n    this.backgrounds = $('[data-bg]'); // Check if intersection observer is supported\n\n    if (\"IntersectionObserver\" in window) {\n      this.lazyloadObserver();\n    } else {\n      this.lazyloadDetector();\n    }\n  }\n\n  lazyloadObserver() {\n    this.imageObserver = new IntersectionObserver(this.observerCallback);\n  }\n\n  observerCallback(entries, observer) {}\n\n  lazyload() {\n    this.images.each(this.lazyloadImage);\n    this.backgrounds.each(this.lazyloadBackground);\n  }\n\n  lazyloadImage(i, element) {}\n\n  lazyloadBackground(i, element) {}\n\n  isVisible(element) {}\n\n  isLoaded(element) {}\n\n}\n\nif (jQuery) jQuery(function ($) {\n  new Lazyloader();\n});\n\n//# sourceURL=webpack://wptheme/./assets/src/js/lazyloader.js?");

/***/ }),

/***/ "./assets/src/js/navbar.js":
/*!*********************************!*\
  !*** ./assets/src/js/navbar.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\nclass Navbar {\n  constructor() {\n    this.element = $('nav.navbar');\n    this.header = this.element.parent('header');\n    this.last = $(window).scrollTop(); // Listen for scroll\n\n    $(window).scroll(this.onScroll.bind(this)); // Show if hidden mouse hovers\n\n    $(document).mousemove(this.onMouseMove.bind(this));\n    this.header.hover(this.onHeaderHover.bind(this), this.onHeaderLeave.bind(this)); // $(document).on('click', 'nav.navbar .navbar-toggler', this.onToggleClick.bind(this) );\n    // Click on toggler (mobile)\n\n    this.toggler.on('click', this.onToggleClick.bind(this));\n  }\n\n  onHeaderHover(e) {\n    if (this.shy) this.element.addClass('navbar-show');\n  }\n\n  onHeaderLeave(e) {\n    if (this.shy) this.element.removeClass('navbar-show');\n  }\n\n  onElementClick(e) {\n    console.log('Navbar click', e.target);\n  }\n  /**\n   * Toggler click\n   */\n\n\n  onToggleClick(e) {\n    console.log('CLICK');\n    this.element.toggleClass('navbar-toggled');\n  }\n  /**\n   * Window scroll\n   */\n\n\n  onScroll(e) {\n    if (this.fixed && this.shy && !this.toggled) {\n      const top = $(window).scrollTop();\n      const dir = top > this.last ? 'down' : 'up';\n      this.last = top;\n      this.element.toggleClass('navbar-hidden', dir == 'down' && top > this.element.outerHeight());\n    }\n  }\n\n  get fixed() {\n    return this.header.hasClass('header-fixed');\n  }\n\n  get shy() {\n    return this.element.hasClass('navbar-shy');\n  }\n\n  get toggled() {\n    return this.element.hasClass('navbar-toggled');\n  }\n\n  get toggler() {\n    return this.element.find('.navbar-toggler');\n  }\n\n  get menu() {\n    return this.element.find('.navbar-menu');\n  }\n  /**\n   * Show nav if hovered near it\n   */\n\n\n  onMouseMove(e) {\n    if (this.fixed && this.shy && this.element.hasClass('navbar-hidden')) {\n      const y = Math.abs(e.pageY - $(window).scrollTop());\n      if (y < this.height) this.element.removeClass('navbar-hidden');\n    }\n  }\n\n  get height() {\n    return this.element.outerHeight();\n  }\n\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Navbar);\n\n//# sourceURL=webpack://wptheme/./assets/src/js/navbar.js?");

/***/ }),

/***/ "./assets/src/js/onscroll.js":
/*!***********************************!*\
  !*** ./assets/src/js/onscroll.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ \"jquery\");\nclass Onscroll {\n  /**\n   * Class constructor\n   */\n  constructor() {\n    // Scroll effects\n    $(window).on('scroll', this.onWindowScroll.bind(this)); // Trigger on load\n\n    $(window).trigger('scroll');\n  }\n  /**\n   * Listen for window scroll\n   */\n\n\n  onWindowScroll(e) {\n    const top = $(window).scrollTop();\n    const threshold = top + $(window).height() * 0.75;\n    $('.on-scroll').each(function (e) {\n      const t = $(this).offset().top;\n      const visible = t && $(this).offset().top < threshold;\n      $(this).toggleClass('on-scroll-visible');\n    });\n  }\n\n}\n\nif (jQuery) jQuery(function ($) {\n  new Onscroll();\n});\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Onscroll);\n\n//# sourceURL=webpack://wptheme/./assets/src/js/onscroll.js?");

/***/ }),

/***/ "./assets/src/js/sidebar.js":
/*!**********************************!*\
  !*** ./assets/src/js/sidebar.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\nclass Sidebar {\n  constructor() {\n    this.element = $('#sidebar');\n    this.inner = this.element.children('.sidebar-inner');\n    if (!this.element.length) return;\n\n    if (this.element.hasClass('sidebar-sticky')) {\n      $(window).on('scroll', this.onWindowScroll.bind(this));\n      $(window).on('resize', this.onWindowResize.bind(this));\n    }\n  }\n\n  onWindowScroll(e) {\n    const top = $(window).scrollTop();\n    const wh = $(window).height();\n    const st = this.element.position().top;\n    const p = top - st; // this.inner.css({'transform':'translate3d(0,'+top+'px,0)'});\n  }\n\n  onWindowResize(e) {}\n\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Sidebar);\n\n//# sourceURL=webpack://wptheme/./assets/src/js/sidebar.js?");

/***/ }),

/***/ "./assets/src/wptheme.js":
/*!*******************************!*\
  !*** ./assets/src/wptheme.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _scss_wptheme_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scss/wptheme.scss */ \"./assets/src/scss/wptheme.scss\");\n/* harmony import */ var _js_onscroll_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/onscroll.js */ \"./assets/src/js/onscroll.js\");\n/* harmony import */ var _js_lazyloader_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./js/lazyloader.js */ \"./assets/src/js/lazyloader.js\");\n/* harmony import */ var _js_lazyloader_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_js_lazyloader_js__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _js_navbar__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./js/navbar */ \"./assets/src/js/navbar.js\");\n/* harmony import */ var _js_sidebar_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./js/sidebar.js */ \"./assets/src/js/sidebar.js\");\n/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ \"jquery\");\n// Theme files\n\n\n // Import components\n\n\n\n\nclass WPTheme {\n  /**\n   * Theme constructor\n   * @type {Object}\n   */\n  constructor() {\n    // init on DOM load\n    jQuery(this.init.bind(this));\n  }\n  /**\n   * Called when DOM is loaded\n   */\n\n\n  init() {\n    console.log('Theme initialized');\n  }\n\n} // Instantiate in global context\n\n\nwindow.wptheme = new WPTheme();\n\n//# sourceURL=webpack://wptheme/./assets/src/wptheme.js?");

/***/ }),

/***/ "./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[2].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[2].use[2]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[2].use[3]!./node_modules/sass-loader/dist/cjs.js!./assets/src/scss/wptheme.scss":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[2].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[2].use[2]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[2].use[3]!./node_modules/sass-loader/dist/cjs.js!./assets/src/scss/wptheme.scss ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (() => {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack://wptheme/./assets/src/scss/wptheme.scss?./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet%5B1%5D.rules%5B2%5D.use%5B1%5D!./node_modules/css-loader/dist/cjs.js??ruleSet%5B1%5D.rules%5B2%5D.use%5B2%5D!./node_modules/postcss-loader/dist/cjs.js??ruleSet%5B1%5D.rules%5B2%5D.use%5B3%5D!./node_modules/sass-loader/dist/cjs.js");

/***/ }),

/***/ "./assets/src/scss/wptheme.scss":
/*!**************************************!*\
  !*** ./assets/src/scss/wptheme.scss ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ \"./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ \"./node_modules/style-loader/dist/runtime/styleDomAPI.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ \"./node_modules/style-loader/dist/runtime/insertBySelector.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ \"./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ \"./node_modules/style-loader/dist/runtime/insertStyleElement.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ \"./node_modules/style-loader/dist/runtime/styleTagTransform.js\");\n/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[2].use[1]!../../../node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[2].use[2]!../../../node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[2].use[3]!../../../node_modules/sass-loader/dist/cjs.js!./wptheme.scss */ \"./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[2].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[2].use[2]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[2].use[3]!./node_modules/sass-loader/dist/cjs.js!./assets/src/scss/wptheme.scss\");\n/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};\n/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6__) if(__WEBPACK_IMPORT_KEY__ !== \"default\") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6__[__WEBPACK_IMPORT_KEY__]\n/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);\n\n      \n      \n      \n      \n      \n      \n      \n      \n      \n\nvar options = {};\n\noptions.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());\noptions.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());\n\n      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, \"head\");\n    \noptions.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());\noptions.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());\n\nvar update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()((_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6___default()), options);\n\n\n\n\n       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6___default()) && (_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6___default().locals) ? (_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_2_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_2_use_2_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_2_use_3_node_modules_sass_loader_dist_cjs_js_wptheme_scss__WEBPACK_IMPORTED_MODULE_6___default().locals) : undefined);\n\n\n//# sourceURL=webpack://wptheme/./assets/src/scss/wptheme.scss?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module) => {

"use strict";
eval("\n\nvar stylesInDOM = [];\n\nfunction getIndexByIdentifier(identifier) {\n  var result = -1;\n\n  for (var i = 0; i < stylesInDOM.length; i++) {\n    if (stylesInDOM[i].identifier === identifier) {\n      result = i;\n      break;\n    }\n  }\n\n  return result;\n}\n\nfunction modulesToDom(list, options) {\n  var idCountMap = {};\n  var identifiers = [];\n\n  for (var i = 0; i < list.length; i++) {\n    var item = list[i];\n    var id = options.base ? item[0] + options.base : item[0];\n    var count = idCountMap[id] || 0;\n    var identifier = \"\".concat(id, \" \").concat(count);\n    idCountMap[id] = count + 1;\n    var indexByIdentifier = getIndexByIdentifier(identifier);\n    var obj = {\n      css: item[1],\n      media: item[2],\n      sourceMap: item[3],\n      supports: item[4],\n      layer: item[5]\n    };\n\n    if (indexByIdentifier !== -1) {\n      stylesInDOM[indexByIdentifier].references++;\n      stylesInDOM[indexByIdentifier].updater(obj);\n    } else {\n      var updater = addElementStyle(obj, options);\n      options.byIndex = i;\n      stylesInDOM.splice(i, 0, {\n        identifier: identifier,\n        updater: updater,\n        references: 1\n      });\n    }\n\n    identifiers.push(identifier);\n  }\n\n  return identifiers;\n}\n\nfunction addElementStyle(obj, options) {\n  var api = options.domAPI(options);\n  api.update(obj);\n\n  var updater = function updater(newObj) {\n    if (newObj) {\n      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap && newObj.supports === obj.supports && newObj.layer === obj.layer) {\n        return;\n      }\n\n      api.update(obj = newObj);\n    } else {\n      api.remove();\n    }\n  };\n\n  return updater;\n}\n\nmodule.exports = function (list, options) {\n  options = options || {};\n  list = list || [];\n  var lastIdentifiers = modulesToDom(list, options);\n  return function update(newList) {\n    newList = newList || [];\n\n    for (var i = 0; i < lastIdentifiers.length; i++) {\n      var identifier = lastIdentifiers[i];\n      var index = getIndexByIdentifier(identifier);\n      stylesInDOM[index].references--;\n    }\n\n    var newLastIdentifiers = modulesToDom(newList, options);\n\n    for (var _i = 0; _i < lastIdentifiers.length; _i++) {\n      var _identifier = lastIdentifiers[_i];\n\n      var _index = getIndexByIdentifier(_identifier);\n\n      if (stylesInDOM[_index].references === 0) {\n        stylesInDOM[_index].updater();\n\n        stylesInDOM.splice(_index, 1);\n      }\n    }\n\n    lastIdentifiers = newLastIdentifiers;\n  };\n};\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/insertBySelector.js":
/*!********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/insertBySelector.js ***!
  \********************************************************************/
/***/ ((module) => {

"use strict";
eval("\n\nvar memo = {};\n/* istanbul ignore next  */\n\nfunction getTarget(target) {\n  if (typeof memo[target] === \"undefined\") {\n    var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself\n\n    if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {\n      try {\n        // This will throw an exception if access to iframe is blocked\n        // due to cross-origin restrictions\n        styleTarget = styleTarget.contentDocument.head;\n      } catch (e) {\n        // istanbul ignore next\n        styleTarget = null;\n      }\n    }\n\n    memo[target] = styleTarget;\n  }\n\n  return memo[target];\n}\n/* istanbul ignore next  */\n\n\nfunction insertBySelector(insert, style) {\n  var target = getTarget(insert);\n\n  if (!target) {\n    throw new Error(\"Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.\");\n  }\n\n  target.appendChild(style);\n}\n\nmodule.exports = insertBySelector;\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/insertBySelector.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/insertStyleElement.js":
/*!**********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/insertStyleElement.js ***!
  \**********************************************************************/
/***/ ((module) => {

"use strict";
eval("\n\n/* istanbul ignore next  */\nfunction insertStyleElement(options) {\n  var element = document.createElement(\"style\");\n  options.setAttributes(element, options.attributes);\n  options.insert(element, options.options);\n  return element;\n}\n\nmodule.exports = insertStyleElement;\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/insertStyleElement.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js ***!
  \**********************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";
eval("\n\n/* istanbul ignore next  */\nfunction setAttributesWithoutAttributes(styleElement) {\n  var nonce =  true ? __webpack_require__.nc : 0;\n\n  if (nonce) {\n    styleElement.setAttribute(\"nonce\", nonce);\n  }\n}\n\nmodule.exports = setAttributesWithoutAttributes;\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/styleDomAPI.js":
/*!***************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/styleDomAPI.js ***!
  \***************************************************************/
/***/ ((module) => {

"use strict";
eval("\n\n/* istanbul ignore next  */\nfunction apply(styleElement, options, obj) {\n  var css = \"\";\n\n  if (obj.supports) {\n    css += \"@supports (\".concat(obj.supports, \") {\");\n  }\n\n  if (obj.media) {\n    css += \"@media \".concat(obj.media, \" {\");\n  }\n\n  var needLayer = typeof obj.layer !== \"undefined\";\n\n  if (needLayer) {\n    css += \"@layer\".concat(obj.layer.length > 0 ? \" \".concat(obj.layer) : \"\", \" {\");\n  }\n\n  css += obj.css;\n\n  if (needLayer) {\n    css += \"}\";\n  }\n\n  if (obj.media) {\n    css += \"}\";\n  }\n\n  if (obj.supports) {\n    css += \"}\";\n  }\n\n  var sourceMap = obj.sourceMap;\n\n  if (sourceMap && typeof btoa !== \"undefined\") {\n    css += \"\\n/*# sourceMappingURL=data:application/json;base64,\".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), \" */\");\n  } // For old IE\n\n  /* istanbul ignore if  */\n\n\n  options.styleTagTransform(css, styleElement, options.options);\n}\n\nfunction removeStyleElement(styleElement) {\n  // istanbul ignore if\n  if (styleElement.parentNode === null) {\n    return false;\n  }\n\n  styleElement.parentNode.removeChild(styleElement);\n}\n/* istanbul ignore next  */\n\n\nfunction domAPI(options) {\n  var styleElement = options.insertStyleElement(options);\n  return {\n    update: function update(obj) {\n      apply(styleElement, options, obj);\n    },\n    remove: function remove() {\n      removeStyleElement(styleElement);\n    }\n  };\n}\n\nmodule.exports = domAPI;\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/styleDomAPI.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/styleTagTransform.js":
/*!*********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/styleTagTransform.js ***!
  \*********************************************************************/
/***/ ((module) => {

"use strict";
eval("\n\n/* istanbul ignore next  */\nfunction styleTagTransform(css, styleElement) {\n  if (styleElement.styleSheet) {\n    styleElement.styleSheet.cssText = css;\n  } else {\n    while (styleElement.firstChild) {\n      styleElement.removeChild(styleElement.firstChild);\n    }\n\n    styleElement.appendChild(document.createTextNode(css));\n  }\n}\n\nmodule.exports = styleTagTransform;\n\n//# sourceURL=webpack://wptheme/./node_modules/style-loader/dist/runtime/styleTagTransform.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

"use strict";
module.exports = jQuery;

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
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/src/wptheme.js");
/******/ 	
/******/ })()
;