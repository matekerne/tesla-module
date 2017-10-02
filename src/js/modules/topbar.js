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
        });

        $('.floor-arrow-up').on('click', function(e) {
            e.preventDefault();
            $('.flat-table-row.select-floor').prev('.flat-table-row').addClass('select-floor').next('.flat-table-row').removeClass('select-floor');
            var floor = $('.select-floor').children('.floor').text();
            Apartment.LoadFloor(floor);
        });
        // Переключение этажей на стрелках
    })();


    Topbar.CheckFloor = CheckFloor;
    window.Topbar = Topbar;
})(window);