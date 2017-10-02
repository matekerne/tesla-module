import './modules/navigation';
import './modules/topbar';
import './modules/sidebar';
import './modules/request';
import './modules/apartment';
import './modules/reserve';
import './modules/form';
import './modules/svg';

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
