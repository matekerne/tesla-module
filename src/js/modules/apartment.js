//import {request} from './request';
export let apartment = (function(){
    var el = '.view-apartment';

    return {
        init: function () {

            this.getApartments(2);

            $.ajax({
                url: "/public/svg/apartments2.html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });

            $(el).each(function(index) {
                var flatId = $(el).attr('id');
                for (key in res) {
                    $('#' + key + el).attr({
                        'data-status': '' + res[key].status + '',
                        'data-type': '' + res[key].type + '',
                        'data-price': '' + parseFloat(res[key].price) + '',
                        'data-windows': '' + res[key].windows + ''
                    });
                }
            });
        },

        getApartments: function (floor) {
            var floor;
            var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
            var data = condition + floor;
            var action = '/module/tesla/apartments';
            var method = 'GET';

            var apartmentInfo = $.ajax({
                url: action,
                type: method,
                data: data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                },

                error: function(e) {

                }

            });
            
            return apartmentInfo;

        }
    }

})();