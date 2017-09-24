/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modules_apartment__ = __webpack_require__(1);


var App = (function () {
    return {
        init: function () {
            __WEBPACK_IMPORTED_MODULE_0__modules_apartment__["a" /* apartment */].init();
        }
    }
})();

App.init();


/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return apartment; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__request__ = __webpack_require__(2);

let apartment = (function(){
    var el = '.view-apartment';

    return {
        init: function () {

            $.ajax({
                url: "/public/svg/apartments2.html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });

            __WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getApartments(2);

            console.log(__WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */]);

            $('.view-apartment').each(function(index) {
                var flatId = $('.view-apartment').attr('id');
                for (key in __WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getInfo) {
                    $('#' + key + '.view-apartment').attr({
                        'data-status': '' + __WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getInfo[key].status + '',
                        'data-type': '' + __WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getInfo[key].type + '',
                        'data-price': '' + parseFloat(__WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getInfo[key].price) + '',
                        'data-windows': '' + __WEBPACK_IMPORTED_MODULE_0__request__["a" /* request */].getInfo[key].windows + ''
                    });
                }
            });
        }
    }

})();

/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return request; });
var request = (function() {

    return {
        getApartments: function (floor) {
            var floor;
            var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
            var data = condition + floor;
            var action = '/module/tesla/apartments';
            var method = 'GET';

            $.ajax({
                url: action,
                type: method,
                data: data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                    this.getInfo = response;
                    console.log(this.getInfo);
                },

                error: function(e) {

                }

            });
        }
    }


})();

/***/ })
/******/ ]);