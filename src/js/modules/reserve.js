(function(window) {

    var Reserve = window.Reserve || {};

    function ReserveFlat(status, flatId) {

        if (status == '2') {
            var reservator = $('#reservator').text();
            var userRole = $('#role').text();

            var method = 'GET';
            var action = '/module/tesla/buyer/show';
            var data =  "apartment_id=" + parseInt(flatId);

            $.ajax({
                type: method,
                url: action,
                data: data,

                success: function(data) {
                    var response = $.parseJSON(data);
                    var buyerId;

                    if ((response['status'] == 'success') && (userRole == 3)) {
                        var buyerId = response[0].id;
                        $('body').addClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').removeAttr('disabled');
                        $('input[name="buyer_id"]').val('' + buyerId + '');
                        $('input[name="name"]').val('' + response[0].name + '');
                        $('input[name="surname"]').val('' + response[0].surname + '');
                        $('input[name="phone"]').val('' + response[0].phone + '');
                        $('input[name="email"]').val('' + response[0].email + '');
                    } else if ((response['status'] == 'success') && (userRole == 4)) {

                        if ((response['status'] == 'success') && (reservator == response[0].reservator_id)) {
                            var buyerId = response[0].id;
                            $('body').addClass('get-buy-panel');
                            $('.button-reserve.remove-reserve').removeAttr('disabled');
                            $('input[name="buyer_id"]').val('' + buyerId + '');
                            $('input[name="name"]').val('' + response[0].name + '');
                            $('input[name="surname"]').val('' + response[0].surname + '');
                            $('input[name="phone"]').val('' + response[0].phone + '');
                            $('input[name="email"]').val('' + response[0].email + '');
                        }

                    } else if ((response['status'] == 'fail_amo') && (userRole == 3)) {

                        $('body').removeClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                        document.getElementById('reserve-lead').reset();
                        $('input[name="buyer_id"]').val('');

                        $('loader').addClass('active loading');
                        $('.circle-loader').toggleClass('load-complete failed');
                        $('#boxApartments').addClass('filter-blur');



                        var statusBlock = document.querySelector('.status-block');
                        var errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.innerHTML = response['message'];

                        $('.checkmark').toggle();
                        statusBlock.appendChild(errorMsg);


                    } else if ((response['status'] == 'fail')) {
                        $('body').removeClass('get-buy-panel');
                        $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                        document.getElementById('reserve-lead').reset();
                        $('input[name="buyer_id"]').val('');
                    }
                },

                error: function(e) {

                }
            });

            $('#floorInfo').removeClass('get-flat-info');

            setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
            }, 150);

        } else if (status == '3') {
            $('body').removeClass('get-buy-panel');
            document.getElementById('reserve-lead').reset();
            $('input[name="buyer_id"]').val('');
            $('#floorInfo').removeClass('get-flat-info');

            setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
            }, 150);
        } else {

            document.getElementById('reserve-lead').reset();
            $('.button-reserve').removeAttr('disabled');
            $('input[name="buyer_id"]').val('');

            $('#floorInfo').addClass('get-flat-display');

            setTimeout( function() {
                $('#floorInfo').addClass('get-flat-info');
            } , 100);
        }
    }

    (function(){
        // Вызов панели
        $('.btn-buy').on('click', function() {
            $('body').addClass('get-buy-panel');
        });
        // Вызов панели

        // Закрытие панели
        $('.close-panel').on('click', function() {
            $('body').removeClass('get-buy-panel');
        });
        // Закрытие панели

        // Бронь в AmoCRM
        $('loader').on('click', function() {
            $('loader').removeClass('active loading');
            $('.circle-loader').toggleClass('load-complete failed');
            $('.checkmark').toggle();
            var errorMsg = document.querySelector('.error-message');

            if (errorMsg.length) {
                errorMsg.parentNode.removeChild(errorMsg);
            }

            $('#boxApartments').removeClass('filter-blur');
        });
        // Бронь в AmoCRM
    })();

    Reserve.ReserveFlat = ReserveFlat;
    window.Reserve = Reserve;
})(window);