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