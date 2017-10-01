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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modules_navigation__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modules_navigation___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__modules_navigation__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__modules_topbar__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__modules_topbar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__modules_topbar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__modules_sidebar__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__modules_sidebar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__modules_sidebar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__modules_request__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__modules_request___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__modules_request__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__modules_apartment__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__modules_apartment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__modules_apartment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__modules_svg__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__modules_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__modules_svg__);







(function (window) {
    var App = window.App || {};

    function init() {
        Navigation.init();
        Topbar.init();
        Sidebar.init();
        Apartment.LoadFloor(2);
        Req.GetApartments(2);
    }

    App.init = init;
    window.App = App;
})(window);

App.init();


/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function (window) {
    var Navigation = window.Navigation || {};

    function init() {
        // Навигация
        $('.navigation-section').on('click', function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $('.navigation-section').removeClass('active');
                $(this).addClass('active');
            }

            if ($('.navigation-section').hasClass('active')) {
                $('loader').addClass('active');
                $('#boxApartments').addClass('filter-blur');
            } else {
                $('loader').removeClass('active');
                $('#boxApartments').removeClass('filter-blur');
            }

            $('loader').click(function() {
                $('loader').removeClass('active');
                $('#boxApartments').removeClass('filter-blur');
                $('.navigation-section').removeClass('active');
            });
        });
        // Навигация
    }

    Navigation.init = init;
    window.Navigation = Navigation;
})(window);

/***/ }),
/* 2 */
/***/ (function(module, exports) {

(function(window) {

    var Topbar = window.Topbar || {};

    function init() {
        var floor = $('.floor__number .number-text').text();

        if (floor === '2') {
            $('.floor-arrow-up').removeClass('active');
            $('.floor-arrow-down').addClass('active');
        } else if (floor === '16') {
            $('.floor-arrow-down').removeClass('active');
            $('.floor-arrow-up').addClass('active');
        } else {
            $('.floor-arrow-up').addClass('active');
            $('.floor-arrow-down').addClass('active');
        }

        // Переключение этажей на стрелках
        $('.floor-arrow-down').on('click', function(e) {
            e.preventDefault();
            nextFloor();
        });

        $('.floor-arrow-up').on('click', function(e) {
            e.preventDefault();
            prevFloor();
        });

        function nextFloor() {
            $('.flat-table-row.select-floor').removeClass('select-floor').next('.flat-table-row').addClass('select-floor');
            var floor = $('.select-floor').children('.floor').text();
            console.log(floor);
            //Req.GetApartments(floor);
        }

        function prevFloor(e) {
            $('.flat-table-row.select-floor').prev('.flat-table-row').addClass('select-floor').next('.flat-table-row').removeClass('select-floor');
            var floor = $('.select-floor').children('.floor').text();
            console.log(floor);
            //Req.GetApartments(floor);
        }
        // Переключение этажей на стрелках
    }

    Topbar.init = init;
    window.Topbar = Topbar;
})(window);

/***/ }),
/* 3 */
/***/ (function(module, exports) {

(function(window) {

    var Sidebar = window.Sidebar || {};

    function init() {

        $('.flat-table-row:first').addClass('select-floor');

        $('.flat-table-row').on('click', function() {
            $('.flat-table-row').removeClass('select-floor');
            $(this).addClass('select-floor');

            var floor = $(this).find('.floor').text();

            /*if (floor == 2) {
                $('.floor-arrow-up').removeClass('active');
                $('.floor-arrow-down').addClass('active');
            } else if (floor == 16) {
                $('.floor-arrow-down').removeClass('active');
                $('.floor-arrow-up').addClass('active');
            } else {
                $('.floor-arrow-up').addClass('active');
                $('.floor-arrow-down').addClass('active');
            }*/

            Req.GetApartments(floor);
        });
    }

    Sidebar.init = init;
    window.Sidebar = Sidebar;
})(window);

/***/ }),
/* 4 */
/***/ (function(module, exports) {

(function(window) {

    var Req = window.Req || {};

    function GetApartments(floor) {
        var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
        var data = condition + floor;
        var action = '/module/tesla/apartments';
        var method = 'GET';

        var floorInfoText = $('.floor__number .number-text');
        var floorNumber = $('.select-floor').find('.flat-table-item:first').text();
        floorNumber = floorNumber.replace(/\D/g, '');
        floorInfoText.text(floor);

        $.ajax({
            url: action,
            type: method,
            data: data,
            contentType: false,
            cache: false,
            processData: false,

            success: function(data) {

                Apartment.InitApartment(data);
                Apartment.Event(data);
                Topbar.init();
            },

            error: function(e) {

            }

        });
    }

    Req.GetApartments = GetApartments;
    window.Req = Req;
})(window);

/***/ }),
/* 5 */
/***/ (function(module, exports) {

//import {request} from './request';
(function(window){
    var Apartment = window.Apartment || {};

    function InitApartment(data) {
        var res = $.parseJSON(data),
             el = '.view-apartment';

        for (key in res) {
            $('#' + key + el).attr({
                'data-status': '' + res[key].status + '',
                'data-type': '' + res[key].type + '',
                'data-price': '' + parseFloat(res[key].price) + '',
                'data-windows': '' + res[key].windows + ''
            });
            $('.flat-number.' + key + '').text(res[key].num);
        }

    }

    function LoadFloor(floor) {
        if (floor >= 12) {
            $('body').addClass('floor-12');
            whatFloor = '12';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });
        } else {
            $('body').removeClass('floor-12');
            whatFloor = '2';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });
        }
    }

    function Event(data) {

        var res = $.parseJSON(data);

        $('body').on('click', '.view-apartment', function() {

            var status = $(this).data('status');
            var number = $(this).attr("id");
            var flatId = res[number].id;
            var flatStatus = res[number].status;
            var typeOfApartment = res[number].type;
            var flatFloor = res[number].floor;
            var flatNumber = res[number].num;
            var totalArea = res[number].total_area;
            var livingArea = res[number].factual_area;
            var flatPrice = res[number].price;

            $('.view-apartment').removeClass('select-apartment');
            $(this).addClass('select-apartment');

            switch (flatStatus) {
                case '3':
                    flatStatus = "Продана";
                    $('.form-panel-header').text('Квартира продана');
                    $('.button-reserve').removeClass('remove-reserve');
                    break;
                case '1':
                    flatStatus = "Свободна";
                    $('.button-reserve').text('Бронировать').removeClass('remove-reserve');
                    $('.form-panel-header').text('Купить / бронировать');
                    break;
                case '2':
                    flatStatus = "Забронирована";
                    $('.form-panel-header').text(flatStatus);
                    $('.button-reserve').text('Снять бронь').addClass('remove-reserve');
                    break;
            }

            $('#flatInfo .flat-header').text(typeOfApartment);
            $('#flatInfo .flat-floor span').text(flatFloor);
            $('#flatInfo .flat-number span').text(flatNumber);
            $('#flatInfo .flat-total-area span').text(totalArea);
            $('#flatInfo .flat-living-area span').text(livingArea);
            $('#flatInfo #flatCost').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $('.select-flat-info .flat-status span').text(flatStatus);
            $('.buy-panel form #apartmentId').val(flatId);
            $('.buy-panel form #apartmentNum').val(flatNumber);
            $('#flatInfo .flat-img').attr('src', '/../../public/image/flats/' + totalArea + '/flat.svg');

            // Перенос значений в форму
            $('.select-flat-info .flat-number span').text(flatNumber);
            $('.select-flat-info .flat-type span').text(typeOfApartment);
            $('.select-flat-info .flat-floor span').text(flatFloor);
            $('.select-flat-info .flat-total-area span').text(totalArea);
            $('.select-flat-info .flat-price span').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        });

    }

    Apartment.InitApartment = InitApartment;
    Apartment.LoadFloor = LoadFloor;
    Apartment.Event = Event;
    window.Apartment = Apartment;
})(window);

/***/ }),
/* 6 */
/***/ (function(module, exports) {

// Замена img на SVG
$(function() {
    jQuery('img.svg').each(function() {
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Check if the viewport is set, else we gonna set it if we can.
            if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });
});

/***/ })
/******/ ]);