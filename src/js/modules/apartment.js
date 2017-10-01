//import {request} from './request';
(function(window){
    var Apartment = window.Apartment || {};

    function InitApartment(data) {
        var res = $.parseJSON(data),
             el = '.view-apartment';

        for (key in res) {
            $('#' + key + el).attr({
                'data-status': '' + res[key].status + '',
                'data-type': '' + res[key].type + '',
                'data-price': '' + parseFloat(res[key].price) + '',
                'data-windows': '' + res[key].windows + ''
            });
            $('.flat-number.' + key + '').text(res[key].num);
        }

    }

    function LoadFloor(floor) {
        if (floor >= 12) {
            $('body').addClass('floor-12');
            whatFloor = '12';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });
        } else {
            $('body').removeClass('floor-12');
            whatFloor = '2';
            $.ajax({
                url: "/public/svg/apartments" + whatFloor + ".html",
                success: function(data) {
                    $("#apartmentsLayout").html(data);
                }
            });
        }
    }

    function Event(data) {

        var res = $.parseJSON(data);

        $('body').on('click', '.view-apartment', function() {

            var status = $(this).data('status');
            var number = $(this).attr("id");
            var flatId = res[number].id;
            var flatStatus = res[number].status;
            var typeOfApartment = res[number].type;
            var flatFloor = res[number].floor;
            var flatNumber = res[number].num;
            var totalArea = res[number].total_area;
            var livingArea = res[number].factual_area;
            var flatPrice = res[number].price;

            $('.view-apartment').removeClass('select-apartment');
            $(this).addClass('select-apartment');

            switch (flatStatus) {
                case '3':
                    flatStatus = "Продана";
                    $('.form-panel-header').text('Квартира продана');
                    $('.button-reserve').removeClass('remove-reserve');
                    break;
                case '1':
                    flatStatus = "Свободна";
                    $('.button-reserve').text('Бронировать').removeClass('remove-reserve');
                    $('.form-panel-header').text('Купить / бронировать');
                    break;
                case '2':
                    flatStatus = "Забронирована";
                    $('.form-panel-header').text(flatStatus);
                    $('.button-reserve').text('Снять бронь').addClass('remove-reserve');
                    break;
            }

            $('#flatInfo .flat-header').text(typeOfApartment);
            $('#flatInfo .flat-floor span').text(flatFloor);
            $('#flatInfo .flat-number span').text(flatNumber);
            $('#flatInfo .flat-total-area span').text(totalArea);
            $('#flatInfo .flat-living-area span').text(livingArea);
            $('#flatInfo #flatCost').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $('.select-flat-info .flat-status span').text(flatStatus);
            $('.buy-panel form #apartmentId').val(flatId);
            $('.buy-panel form #apartmentNum').val(flatNumber);
            $('#flatInfo .flat-img').attr('src', '/../../public/image/flats/' + totalArea + '/flat.svg');

            // Перенос значений в форму
            $('.select-flat-info .flat-number span').text(flatNumber);
            $('.select-flat-info .flat-type span').text(typeOfApartment);
            $('.select-flat-info .flat-floor span').text(flatFloor);
            $('.select-flat-info .flat-total-area span').text(totalArea);
            $('.select-flat-info .flat-price span').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        });

    }

    Apartment.InitApartment = InitApartment;
    Apartment.LoadFloor = LoadFloor;
    Apartment.Event = Event;
    window.Apartment = Apartment;
})(window);