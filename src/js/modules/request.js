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