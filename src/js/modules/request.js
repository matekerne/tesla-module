export var request = (function() {

    return {
        getApartments: function (floor) {
            var floor;
            var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
            var data = condition + floor;
            var action = '/module/tesla/apartments';
            var method = 'GET';

            $.ajax({
                url: action,
                type: method,
                data: data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                    this.getInfo = response;
                    console.log(this.getInfo);
                },

                error: function(e) {

                }

            });
        }
    }


})();