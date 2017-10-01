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