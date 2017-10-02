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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__modules_reserve__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__modules_reserve___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__modules_reserve__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__modules_form__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__modules_form___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__modules_form__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__modules_svg__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__modules_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__modules_svg__);









(function (window) {
    var App = window.App || {};

    function init() {
        Navigation.init();
        //Topbar.init();
        Sidebar.init();
        Apartment.LoadFloor(2);
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

    (function() {
        $(document).on('submit', '#actual-info', function(e) {
            e.preventDefault();

            var form = $(this);
            var action = form.attr('action');
            var method = form.attr('method');

            $('loader').addClass('loading');
            $('#boxApartments').addClass('filter-blur');

            var floor = $('.select-floor').find('.floor').text();

            $.ajax({
                url: action,
                type: method,
                contentType: false,
                cache: false,
                proccessData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response['status'] == 'success') {
                        if(window.location.toString().indexOf('module/tesla/home')>0) {
                            Sidebar.UpdateSidebar();
                            Apartment.LoadFloor(floor);
                        }
                        $('.circle-loader').toggleClass('load-complete');
                        $('.checkmark').toggle();
                        $('loader').find('.success-msg').show();
                        $('loader').find('.success-msg').text(response['message']);
                        setTimeout(function() {
                            $('loader').removeClass('loading');
                            $('.circle-loader').toggleClass('load-complete');
                            $('.checkmark').toggle();
                            $('loader').find('.success-msg').hide();
                            $('loader').find('.success-msg').text();
                            $('#boxApartments').removeClass('filter-blur');
                        }, 800);
                    } else if (response['status'] == 'fail') {
                        $('.circle-loader').toggleClass('load-complete');
                        $('.checkmark').toggle();
                        $('loader').find('.error-msg').show();
                        $('loader').find('.error-msg').text(response['message']);
                        setTimeout(function() {
                            $('loader').removeClass('loading');
                            $('.circle-loader').toggleClass('load-complete failed');
                            $('.checkmark').toggle();
                            $('loader').find('.error-msg').hide();
                            $('loader').find('.error-msg').text();
                            $('#boxApartments').removeClass('filter-blur');
                        }, 800);
                    }
                },

                error: function(e) {

                }
            });
        });
    })();

    Navigation.init = init;
    window.Navigation = Navigation;
})(window);

/***/ }),
/* 2 */
/***/ (function(module, exports) {

(function(window) {

    var Topbar = window.Topbar || {};

    function CheckFloor(floor) {
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
    }

    (function Event(){
        // Переключение этажей на стрелках
        $('.floor-arrow-down').on('click', function(e) {
            e.preventDefault();
            $('.flat-table-row.select-floor').next('.flat-table-row').addClass('select-floor').prev('.flat-table-row').removeClass('select-floor');
            var floor = $('.select-floor').children('.floor').text();
            Apartment.LoadFloor(floor);
            //Req.GetApartments(floor);
        });

        $('.floor-arrow-up').on('click', function(e) {
            e.preventDefault();
            $('.flat-table-row.select-floor').prev('.flat-table-row').addClass('select-floor').next('.flat-table-row').removeClass('select-floor');
            var floor = $('.select-floor').children('.floor').text();
            Apartment.LoadFloor(floor);
            //Req.GetApartments(floor);
        });
        // Переключение этажей на стрелках
    })();


    Topbar.CheckFloor = CheckFloor;
    window.Topbar = Topbar;
})(window);

/***/ }),
/* 3 */
/***/ (function(module, exports) {

(function(window) {

    var Sidebar = window.Sidebar || {};

    function init() {

        $('.flat-table-row:first').addClass('select-floor');

        $('body').on('click', '.flat-table-row', function() {
            $('.flat-table-row').removeClass('select-floor');
            $(this).addClass('select-floor');

            var floor = $(this).find('.floor').text();

            Apartment.LoadFloor(floor);
        });
    }

    function SelectFlat() {
        if ($('.flat-item[data-flat=1]').hasClass('select')) {
            $('.view-apartment[data-type="студия"]').addClass('active-item');
        }

        if ($('.flat-item[data-flat=4]').hasClass('select')) {
            $('.view-apartment[data-type="евро 2-х комнатная"]').addClass('active-item');
        }

        if ($('.flat-item[data-flat=2]').hasClass('select')) {
            $('.view-apartment[data-type="2-х комнатная"]').addClass('active-item');
        }

        if ($('.flat-item[data-flat=3]').hasClass('select')) {
            $('.view-apartment[data-type="3-х комнатная"]').addClass('active-item');
        }
    }

    function UpdateSidebar() {
        var floor = $('.select-floor').find('.floor').text();
        var studio = $('.flat-item[data-flat=1]');
        var euro2x = $('.flat-item[data-flat=4]');
        var flat2x = $('.flat-item[data-flat=2]');
        var flat3x = $('.flat-item[data-flat=3]');
        $('#sidebarCount').load('/../module/tesla/home .flat__body, .flat-table', function () {
            $('.flat-table-row:nth-child(' + floor + ')').addClass('select-floor');
            if (studio.hasClass('select')) {
                $('.flat-item[data-flat=1]').addClass('select');
                $('.flat-table-item[data-flat=1]').addClass('select-flat');
            }

            if (euro2x.hasClass('select')) {
                $('.flat-item[data-flat=4]').addClass('select');
                $('.flat-table-item[data-flat=4]').addClass('select-flat');
            }

            if (flat2x.hasClass('select')) {
                $('.flat-item[data-flat=2]').addClass('select');
                $('.flat-table-item[data-flat=2]').addClass('select-flat');
            }

            if (flat3x.hasClass('select')) {
                $('.flat-item[data-flat=3]').addClass('select');
                $('.flat-table-item[data-flat=3]').addClass('select-flat');
            }

        });
    }

    (function () {
        $('body').on('click', '.flat-item', function() {
            var selectFlat = $(this).data("flat");

            switch (selectFlat) {
                case 1:
                    selectedFlat = "студия";
                    break;
                case 2:
                    selectedFlat = "2-х комнатная";
                    break;
                case 3:
                    selectedFlat = "3-х комнатная";
                    break;
                case 4:
                    selectedFlat = "евро 2-х комнатная";
                    break;
            }

            if ($(this).hasClass('select')) {
                $(this).removeClass('select');
                $('.view-apartment[data-type="' + selectedFlat + '"]').removeClass('active-item');
                $('.flat-table-item[data-flat="' + selectFlat + '"]').removeClass('select-flat');
            } else {
                $(this).addClass('select');
                $('.view-apartment[data-type="' + selectedFlat + '"]').addClass('active-item');
                $('.flat-table-item[data-flat="' + selectFlat + '"]').addClass('select-flat');
            }

        });

    })();

    Sidebar.init = init;
    Sidebar.UpdateSidebar = UpdateSidebar;
    Sidebar.SelectFlat = SelectFlat;
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
                Sidebar.SelectFlat();
                Apartment.Event(data);
                Topbar.CheckFloor(floor);
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
            var whatFloor = '12';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                    //Req.GetApartments(floor);
                }
            });
        } else {
            $('body').removeClass('floor-12');
            var whatFloor = '2';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);

                }
            });
        }

        Req.GetApartments(floor);
        $("#floorInfo #floorMapSchema .floor-schema").attr("src", "/../../public/image/flats/floor/walls" + whatFloor + ".png");
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

            Reserve.ReserveFlat(status, flatId);

            if ($('.buy-panel form div').hasClass('error')) {
                $('.buy-panel form div').removeClass('error');
                $('.buy-panel form div .error-message').remove();
            }

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

    (function () {
        // Появление названий улиц
        setTimeout(function() {
            $('.name-street').addClass('show-street');
        }, 500);
        // Появление названий улиц
    })();

    Apartment.InitApartment = InitApartment;
    Apartment.LoadFloor = LoadFloor;
    Apartment.Event = Event;
    window.Apartment = Apartment;
})(window);

/***/ }),
/* 6 */
/***/ (function(module, exports) {

(function(window) {

    var Reserve = window.Reserve || {};

    function ReserveFlat(status, flatId) {

        if (status == '2') {
            var reservator = $('#reservator').text();
            var userRole = $('#role').text();

            var method = 'GET';
            var action = '/module/tesla/buyer/show';
            var data =  "apartment_id=" + parseInt(flatId);

            $.ajax({
                type: method,
                url: action,
                data: data,

                success: function(data) {
                    var response = $.parseJSON(data);
                    var buyerId;

                    if ((response['status'] == 'success') && (userRole == 3)) {
                        var buyerId = response[0].id;
                        $('body').addClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').removeAttr('disabled');
                        $('input[name="buyer_id"]').val('' + buyerId + '');
                        $('input[name="name"]').val('' + response[0].name + '');
                        $('input[name="surname"]').val('' + response[0].surname + '');
                        $('input[name="phone"]').val('' + response[0].phone + '');
                        $('input[name="email"]').val('' + response[0].email + '');
                    } else if ((response['status'] == 'success') && (userRole == 4)) {

                        if ((response['status'] == 'success') && (reservator == response[0].reservator_id)) {
                            var buyerId = response[0].id;
                            $('body').addClass('get-buy-panel');
                            $('.button-reserve.remove-reserve').removeAttr('disabled');
                            $('input[name="buyer_id"]').val('' + buyerId + '');
                            $('input[name="name"]').val('' + response[0].name + '');
                            $('input[name="surname"]').val('' + response[0].surname + '');
                            $('input[name="phone"]').val('' + response[0].phone + '');
                            $('input[name="email"]').val('' + response[0].email + '');
                        }

                    } else if ((response['status'] == 'fail_amo') && (userRole == 3)) {

                        $('body').removeClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                        document.getElementById('reserve-lead').reset();
                        $('input[name="buyer_id"]').val('');

                        $('loader').addClass('active loading');
                        $('.circle-loader').toggleClass('load-complete failed');
                        $('#boxApartments').addClass('filter-blur');



                        var statusBlock = document.querySelector('.status-block');
                        var errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.innerHTML = response['message'];

                        $('.checkmark').toggle();
                        statusBlock.appendChild(errorMsg);


                    } else if ((response['status'] == 'fail')) {
                        $('body').removeClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                        document.getElementById('reserve-lead').reset();
                        $('input[name="buyer_id"]').val('');
                    }
                },

                error: function(e) {

                }
            });

            $('#floorInfo').removeClass('get-flat-info');

            setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
            }, 150);

        } else if (status == '3') {
            $('body').removeClass('get-buy-panel');
            document.getElementById('reserve-lead').reset();
            $('input[name="buyer_id"]').val('');
            $('#floorInfo').removeClass('get-flat-info');

            setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
            }, 150);
        } else {

            document.getElementById('reserve-lead').reset();
            $('.button-reserve').removeAttr('disabled');
            $('input[name="buyer_id"]').val('');

            $('#floorInfo').addClass('get-flat-display');

            setTimeout( function() {
                $('#floorInfo').addClass('get-flat-info');
            } , 100);
        }
    }

    (function(){
        // Вызов панели
        $('.btn-buy').on('click', function() {
            $('body').addClass('get-buy-panel');
        });
        // Вызов панели

        // Закрытие панели
        $('.close-panel').on('click', function() {
            $('body').removeClass('get-buy-panel');
        });
        // Закрытие панели

        // Бронь в AmoCRM
        $('loader').on('click', function() {
            $('loader').removeClass('active loading');
            $('.circle-loader').toggleClass('load-complete failed');
            $('.checkmark').toggle();
            var errorMsg = document.querySelector('.error-message');

            if (errorMsg.length) {
                errorMsg.parentNode.removeChild(errorMsg);
            }

            $('#boxApartments').removeClass('filter-blur');
        });
        // Бронь в AmoCRM
    })();

    Reserve.ReserveFlat = ReserveFlat;
    window.Reserve = Reserve;
})(window);

/***/ }),
/* 7 */
/***/ (function(module, exports) {

(function(window) {

    var FormPanel = window.FormPanel || {};

    function Validate(form) {
        var elems = form.elements;

        resetError(elems.name.parentNode);
        if (!elems.name.value) {
            showError(elems.name.parentNode, ' Укажите ваше имя.');
        };

        resetError(elems.surname.parentNode);
        if (!elems.surname.value) {
            showError(elems.surname.parentNode, ' Укажите вашу фамилию.');
        };

        resetError(elems.email.parentNode && elems.phone.parentNode);
        var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,3}$/i;
        if (!elems.email.value && !elems.phone.value) {
            showError(elems.email.parentNode, ' Введите email.');
            showError(elems.phone.parentNode, ' Введите номер телефона.');
        } else if (!elems.email.value && elems.phone.value != '') {
            resetError(elems.email.parentNode);
        } else if (!re.test(elems.email.value)) {
            showError(elems.email.parentNode, ' Введенный email некорректный.');
        }


        if ($('.buy-panel form div').hasClass('error')) {
            return false;
        } else {
            return true;
        }
    }

    // Form validation
    function showError(container, errorMessage) {
        container.className = 'error';
        var msgElem = document.createElement('span');
        msgElem.className = "error-message";
        msgElem.innerHTML = errorMessage;
        container.appendChild(msgElem);
    }

    function resetError(container) {
        container.className = '';
        if (container.lastChild.className == "error-message") {
            container.removeChild(container.lastChild);
        }
    }
    // Form validation

    (function() {
        // Input focus
        $('.buy-panel form input').on('focus', function() {
            if ($('.buy-panel form div').hasClass('error')) {
                $('.buy-panel form div').removeClass('error');
                $('.buy-panel form div .error-message').remove();
            }
        });
        // Input focus

        // Phone mask
        $('[name="phone"]').inputmask({
            "mask": "+7 (999)999-99-99"
        });
        // Phone mask

        $('.button-buy').on('click', function() {
            $('#reserve-lead').attr('action', '/module/tesla/apartment/lead');
        });

        $('.button-reserve').on('click', function() {
            $('#reserve-lead').attr('action', '/module/tesla/apartment/reserve');
            if ($(this).hasClass('remove-reserve')) {
                $('#reserve-lead').attr('action', '/module/tesla/apartment/withdraw-reserve');
            }
        });

        $(document).on('submit', '#reserve-lead', function(e) {
            e.preventDefault();
            FormPanel.Validate(this);

            var form = $(this);
            var action = form.attr('action');
            var method = form.attr('method');
            var data = new FormData(form[0]);

            var floor = $('.select-floor').find('.floor').text();

            if (FormPanel.Validate(this) == true) {
                $('.buy-panel').addClass('status-success');
                $.ajax({
                    url: action,
                    type: method,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function(data) {
                        var response = $.parseJSON(data);

                        if (response['status'] == 'fail') {
                            document.getElementById('reserve-lead').reset();
                            $('.circle-loader').toggleClass('load-complete failed');
                            $('.checkmark').toggle();
                            $('.buy-panel').find('.error-msg').show();
                            $('.buy-panel').find('.error-msg').text(response['message']);
                            setTimeout(function() {
                                $('body').removeClass('get-buy-panel');
                            }, 2000);
                            setTimeout(function() {
                                $('.buy-panel').removeClass('status-success');
                                $('.circle-loader').toggleClass('load-complete failed');
                                $('.checkmark').toggle();
                                $('.buy-panel').find('.error-msg').hide();
                            }, 2200);
                        } else if (response['status'] == 'success') {
                            document.getElementById('reserve-lead').reset();
                            $('.circle-loader').toggleClass('load-complete');
                            $('.checkmark').toggle();
                            setTimeout(function() {
                                $('body').removeClass('get-buy-panel');
                            }, 2000);
                            setTimeout(function() {
                                $('.buy-panel').removeClass('status-success');
                                $('.circle-loader').toggleClass('load-complete');
                                $('.checkmark').toggle();
                            }, 2200);
                            setTimeout(function() {
                                Sidebar.UpdateSidebar();
                                Apartment.LoadFloor(floor);
                                $('.view-apartment.select-apartment').removeClass('select-apartment');
                            }, 3000);
                        }
                    },

                    error: function(e) {

                    }
                });
            }
        });
    })();

    FormPanel.Validate = Validate;
    window.FormPanel = FormPanel;
})(window);

/***/ }),
/* 8 */
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