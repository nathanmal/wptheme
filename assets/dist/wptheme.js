/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 486:
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(311);
/* provided dependency */ var jQuery = __webpack_require__(311);
class Lazyloader {
  constructor() {
    console.log('Lazy Loader');

    // Images with lazy loader
    this.images = $('img[data-src]');

    // Elements with lazy load background
    this.backgrounds = $('[data-bg]');

    // Check if intersection observer is supported
    if ("IntersectionObserver" in window) {
      this.lazyloadObserver();
    } else {
      this.lazyloadDetector();
    }
  }
  lazyloadObserver() {
    this.imageObserver = new IntersectionObserver(this.observerCallback);
  }
  observerCallback(entries, observer) {}
  lazyload() {
    this.images.each(this.lazyloadImage);
    this.backgrounds.each(this.lazyloadBackground);
  }
  lazyloadImage(i, element) {}
  lazyloadBackground(i, element) {}
  isVisible(element) {}
  isLoaded(element) {}
}
if (jQuery) jQuery(function ($) {
  new Lazyloader();
});

/***/ }),

/***/ 34:
/***/ (() => {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 379:
/***/ ((module) => {

"use strict";


var stylesInDOM = [];
function getIndexByIdentifier(identifier) {
  var result = -1;
  for (var i = 0; i < stylesInDOM.length; i++) {
    if (stylesInDOM[i].identifier === identifier) {
      result = i;
      break;
    }
  }
  return result;
}
function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];
  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var indexByIdentifier = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3],
      supports: item[4],
      layer: item[5]
    };
    if (indexByIdentifier !== -1) {
      stylesInDOM[indexByIdentifier].references++;
      stylesInDOM[indexByIdentifier].updater(obj);
    } else {
      var updater = addElementStyle(obj, options);
      options.byIndex = i;
      stylesInDOM.splice(i, 0, {
        identifier: identifier,
        updater: updater,
        references: 1
      });
    }
    identifiers.push(identifier);
  }
  return identifiers;
}
function addElementStyle(obj, options) {
  var api = options.domAPI(options);
  api.update(obj);
  var updater = function updater(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap && newObj.supports === obj.supports && newObj.layer === obj.layer) {
        return;
      }
      api.update(obj = newObj);
    } else {
      api.remove();
    }
  };
  return updater;
}
module.exports = function (list, options) {
  options = options || {};
  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];
    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDOM[index].references--;
    }
    var newLastIdentifiers = modulesToDom(newList, options);
    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];
      var _index = getIndexByIdentifier(_identifier);
      if (stylesInDOM[_index].references === 0) {
        stylesInDOM[_index].updater();
        stylesInDOM.splice(_index, 1);
      }
    }
    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ 569:
/***/ ((module) => {

"use strict";


var memo = {};

/* istanbul ignore next  */
function getTarget(target) {
  if (typeof memo[target] === "undefined") {
    var styleTarget = document.querySelector(target);

    // Special case to return head of iframe instead of iframe itself
    if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
      try {
        // This will throw an exception if access to iframe is blocked
        // due to cross-origin restrictions
        styleTarget = styleTarget.contentDocument.head;
      } catch (e) {
        // istanbul ignore next
        styleTarget = null;
      }
    }
    memo[target] = styleTarget;
  }
  return memo[target];
}

/* istanbul ignore next  */
function insertBySelector(insert, style) {
  var target = getTarget(insert);
  if (!target) {
    throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
  }
  target.appendChild(style);
}
module.exports = insertBySelector;

/***/ }),

/***/ 216:
/***/ ((module) => {

"use strict";


/* istanbul ignore next  */
function insertStyleElement(options) {
  var element = document.createElement("style");
  options.setAttributes(element, options.attributes);
  options.insert(element, options.options);
  return element;
}
module.exports = insertStyleElement;

/***/ }),

/***/ 565:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


/* istanbul ignore next  */
function setAttributesWithoutAttributes(styleElement) {
  var nonce =  true ? __webpack_require__.nc : 0;
  if (nonce) {
    styleElement.setAttribute("nonce", nonce);
  }
}
module.exports = setAttributesWithoutAttributes;

/***/ }),

/***/ 795:
/***/ ((module) => {

"use strict";


/* istanbul ignore next  */
function apply(styleElement, options, obj) {
  var css = "";
  if (obj.supports) {
    css += "@supports (".concat(obj.supports, ") {");
  }
  if (obj.media) {
    css += "@media ".concat(obj.media, " {");
  }
  var needLayer = typeof obj.layer !== "undefined";
  if (needLayer) {
    css += "@layer".concat(obj.layer.length > 0 ? " ".concat(obj.layer) : "", " {");
  }
  css += obj.css;
  if (needLayer) {
    css += "}";
  }
  if (obj.media) {
    css += "}";
  }
  if (obj.supports) {
    css += "}";
  }
  var sourceMap = obj.sourceMap;
  if (sourceMap && typeof btoa !== "undefined") {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  }

  // For old IE
  /* istanbul ignore if  */
  options.styleTagTransform(css, styleElement, options.options);
}
function removeStyleElement(styleElement) {
  // istanbul ignore if
  if (styleElement.parentNode === null) {
    return false;
  }
  styleElement.parentNode.removeChild(styleElement);
}

/* istanbul ignore next  */
function domAPI(options) {
  if (typeof document === "undefined") {
    return {
      update: function update() {},
      remove: function remove() {}
    };
  }
  var styleElement = options.insertStyleElement(options);
  return {
    update: function update(obj) {
      apply(styleElement, options, obj);
    },
    remove: function remove() {
      removeStyleElement(styleElement);
    }
  };
}
module.exports = domAPI;

/***/ }),

/***/ 589:
/***/ ((module) => {

"use strict";


/* istanbul ignore next  */
function styleTagTransform(css, styleElement) {
  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css;
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild);
    }
    styleElement.appendChild(document.createTextNode(css));
  }
}
module.exports = styleTagTransform;

/***/ }),

/***/ 311:
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
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";

// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js
var injectStylesIntoStyleTag = __webpack_require__(379);
var injectStylesIntoStyleTag_default = /*#__PURE__*/__webpack_require__.n(injectStylesIntoStyleTag);
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/styleDomAPI.js
var styleDomAPI = __webpack_require__(795);
var styleDomAPI_default = /*#__PURE__*/__webpack_require__.n(styleDomAPI);
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/insertBySelector.js
var insertBySelector = __webpack_require__(569);
var insertBySelector_default = /*#__PURE__*/__webpack_require__.n(insertBySelector);
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js
var setAttributesWithoutAttributes = __webpack_require__(565);
var setAttributesWithoutAttributes_default = /*#__PURE__*/__webpack_require__.n(setAttributesWithoutAttributes);
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/insertStyleElement.js
var insertStyleElement = __webpack_require__(216);
var insertStyleElement_default = /*#__PURE__*/__webpack_require__.n(insertStyleElement);
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/styleTagTransform.js
var styleTagTransform = __webpack_require__(589);
var styleTagTransform_default = /*#__PURE__*/__webpack_require__.n(styleTagTransform);
// EXTERNAL MODULE: ./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[2].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[2].use[2]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[2].use[3]!./node_modules/sass-loader/dist/cjs.js!./assets/src/scss/wptheme.scss
var wptheme = __webpack_require__(34);
var wptheme_default = /*#__PURE__*/__webpack_require__.n(wptheme);
;// CONCATENATED MODULE: ./assets/src/scss/wptheme.scss

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (styleTagTransform_default());
options.setAttributes = (setAttributesWithoutAttributes_default());

      options.insert = insertBySelector_default().bind(null, "head");
    
options.domAPI = (styleDomAPI_default());
options.insertStyleElement = (insertStyleElement_default());

var update = injectStylesIntoStyleTag_default()((wptheme_default()), options);




       /* harmony default export */ const scss_wptheme = ((wptheme_default()) && (wptheme_default()).locals ? (wptheme_default()).locals : undefined);

;// CONCATENATED MODULE: ./assets/src/js/onscroll.js
/* provided dependency */ var $ = __webpack_require__(311);
/* provided dependency */ var jQuery = __webpack_require__(311);
class Onscroll {
  /**
   * Class constructor
   */
  constructor() {
    // Scroll effects
    $(window).on('scroll', this.onWindowScroll.bind(this));

    // Trigger on load
    $(window).trigger('scroll');
  }

  /**
   * Listen for window scroll
   */
  onWindowScroll(e) {
    const top = $(window).scrollTop();
    const threshold = top + $(window).height() * 0.75;
    $('.on-scroll').each(function (e) {
      const t = $(this).offset().top;
      const visible = t && $(this).offset().top < threshold;
      $(this).toggleClass('on-scroll-visible');
    });
  }
}
if (jQuery) jQuery(function ($) {
  new Onscroll();
});
/* harmony default export */ const onscroll = ((/* unused pure expression or super */ null && (Onscroll)));
// EXTERNAL MODULE: ./assets/src/js/lazyloader.js
var lazyloader = __webpack_require__(486);
;// CONCATENATED MODULE: ./assets/src/js/navbar.js
/* provided dependency */ var navbar_$ = __webpack_require__(311);
class Navbar {
  constructor() {
    this.element = navbar_$('nav.navbar');
    this.header = this.element.parent('header');
    this.last = navbar_$(window).scrollTop();

    // Listen for scroll
    navbar_$(window).scroll(this.onScroll.bind(this));

    // Show if hidden mouse hovers
    navbar_$(document).mousemove(this.onMouseMove.bind(this));
    this.header.hover(this.onHeaderHover.bind(this), this.onHeaderLeave.bind(this));

    // $(document).on('click', 'nav.navbar .navbar-toggler', this.onToggleClick.bind(this) );
    // Click on toggler (mobile)
    this.toggler.on('click', this.onToggleClick.bind(this));
  }
  onHeaderHover(e) {
    if (this.shy) this.element.addClass('navbar-show');
  }
  onHeaderLeave(e) {
    if (this.shy) this.element.removeClass('navbar-show');
  }
  onElementClick(e) {
    console.log('Navbar click', e.target);
  }

  /**
   * Toggler click
   */
  onToggleClick(e) {
    console.log('CLICK');
    this.element.toggleClass('navbar-toggled');
  }

  /**
   * Window scroll
   */
  onScroll(e) {
    if (this.fixed && this.shy && !this.toggled) {
      const top = navbar_$(window).scrollTop();
      const dir = top > this.last ? 'down' : 'up';
      this.last = top;
      this.element.toggleClass('navbar-hidden', dir == 'down' && top > this.element.outerHeight());
    }
  }
  get fixed() {
    return this.header.hasClass('header-fixed');
  }
  get shy() {
    return this.element.hasClass('navbar-shy');
  }
  get toggled() {
    return this.element.hasClass('navbar-toggled');
  }
  get toggler() {
    return this.element.find('.navbar-toggler');
  }
  get menu() {
    return this.element.find('.navbar-menu');
  }

  /**
   * Show nav if hovered near it
   */
  onMouseMove(e) {
    if (this.fixed && this.shy && this.element.hasClass('navbar-hidden')) {
      const y = Math.abs(e.pageY - navbar_$(window).scrollTop());
      if (y < this.height) this.element.removeClass('navbar-hidden');
    }
  }
  get height() {
    return this.element.outerHeight();
  }
}
/* harmony default export */ const navbar = ((/* unused pure expression or super */ null && (Navbar)));
;// CONCATENATED MODULE: ./assets/src/js/sidebar.js
/* provided dependency */ var sidebar_$ = __webpack_require__(311);
class Sidebar {
  constructor() {
    this.element = sidebar_$('#sidebar');
    this.inner = this.element.children('.sidebar-inner');
    if (!this.element.length) return;
    if (this.element.hasClass('sidebar-sticky')) {
      sidebar_$(window).on('scroll', this.onWindowScroll.bind(this));
      sidebar_$(window).on('resize', this.onWindowResize.bind(this));
    }
  }
  onWindowScroll(e) {
    const top = sidebar_$(window).scrollTop();
    const wh = sidebar_$(window).height();
    const st = this.element.position().top;
    const p = top - st;

    // this.inner.css({'transform':'translate3d(0,'+top+'px,0)'});
  }

  onWindowResize(e) {}
}
/* harmony default export */ const sidebar = ((/* unused pure expression or super */ null && (Sidebar)));
;// CONCATENATED MODULE: ./assets/src/wptheme.js
/* provided dependency */ var wptheme_jQuery = __webpack_require__(311);
// Theme files




// Import components


class WPTheme {
  /**
   * Theme constructor
   * @type {Object}
   */
  constructor() {
    // init on DOM load
    wptheme_jQuery(this.init.bind(this));
  }

  /**
   * Called when DOM is loaded
   */
  init() {
    console.log('Theme initialized');
  }
}

// Instantiate in global context
window.wptheme = new WPTheme();
})();

/******/ })()
;