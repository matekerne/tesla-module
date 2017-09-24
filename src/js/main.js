import {apartment} from './modules/apartment';

var App = (function () {
    return {
        init: function () {
            apartment.init();
        }
    }
})();

App.init();
