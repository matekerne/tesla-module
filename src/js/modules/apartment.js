import {request} from './request';
export let apartment = (function(){
    var el = '.view-apartment';

    return {
        init: function () {

            $.ajax({
                url: "/public/svg/apartments2.html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });

            request.getApartments(2);

            console.log(request);

            $('.view-apartment').each(function(index) {
                var flatId = $('.view-apartment').attr('id');
                for (key in request.getInfo) {
                    $('#' + key + '.view-apartment').attr({
                        'data-status': '' + request.getInfo[key].status + '',
                        'data-type': '' + request.getInfo[key].type + '',
                        'data-price': '' + parseFloat(request.getInfo[key].price) + '',
                        'data-windows': '' + request.getInfo[key].windows + ''
                    });
                }
            });
        }
    }

})();