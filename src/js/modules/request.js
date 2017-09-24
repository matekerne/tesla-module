export var request = (function() {

    return {
        getApartments: function (floor) {
            var floor;
            var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
            var data = condition + floor;
            var action = '/module/tesla/apartments';
            var method = 'GET';

            window.result;

            $.ajax({
                url: action,
                type: method,
                data: data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                    window.result = response;
                },

                error: function(e) {

                }

            });

        }
    }


})();