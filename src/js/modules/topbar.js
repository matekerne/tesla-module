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