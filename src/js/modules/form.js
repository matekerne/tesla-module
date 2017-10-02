(function(window) {

    var FormPanel = window.FormPanel || {};

    function Validate(form) {
        var elems = form.elements;

        resetError(elems.name.parentNode);
        if (!elems.name.value) {
            showError(elems.name.parentNode, ' Укажите ваше имя.');
        };

        resetError(elems.surname.parentNode);
        if (!elems.surname.value) {
            showError(elems.surname.parentNode, ' Укажите вашу фамилию.');
        };

        resetError(elems.email.parentNode && elems.phone.parentNode);
        var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,3}$/i;
        if (!elems.email.value && !elems.phone.value) {
            showError(elems.email.parentNode, ' Введите email.');
            showError(elems.phone.parentNode, ' Введите номер телефона.');
        } else if (!elems.email.value && elems.phone.value != '') {
            resetError(elems.email.parentNode);
        } else if (!re.test(elems.email.value)) {
            showError(elems.email.parentNode, ' Введенный email некорректный.');
        }


        if ($('.buy-panel form div').hasClass('error')) {
            return false;
        } else {
            return true;
        }
    }

    // Form validation
    function showError(container, errorMessage) {
        container.className = 'error';
        var msgElem = document.createElement('span');
        msgElem.className = "error-message";
        msgElem.innerHTML = errorMessage;
        container.appendChild(msgElem);
    }

    function resetError(container) {
        container.className = '';
        if (container.lastChild.className == "error-message") {
            container.removeChild(container.lastChild);
        }
    }
    // Form validation

    (function() {
        // Input focus
        $('.buy-panel form input').on('focus', function() {
            if ($('.buy-panel form div').hasClass('error')) {
                $('.buy-panel form div').removeClass('error');
                $('.buy-panel form div .error-message').remove();
            }
        });
        // Input focus

        // Phone mask
        $('[name="phone"]').inputmask({
            "mask": "+7 (999)999-99-99"
        });
        // Phone mask

        $('.button-buy').on('click', function() {
            $('#reserve-lead').attr('action', '/module/tesla/apartment/lead');
        });

        $('.button-reserve').on('click', function() {
            $('#reserve-lead').attr('action', '/module/tesla/apartment/reserve');
            if ($(this).hasClass('remove-reserve')) {
                $('#reserve-lead').attr('action', '/module/tesla/apartment/withdraw-reserve');
            }
        });

        $(document).on('submit', '#reserve-lead', function(e) {
            e.preventDefault();
            FormPanel.Validate(this);

            var form = $(this);
            var action = form.attr('action');
            var method = form.attr('method');
            var data = new FormData(form[0]);

            var floor = $('.select-floor').find('.floor').text();

            if (FormPanel.Validate(this) == true) {
                $('.buy-panel').addClass('status-success');
                $.ajax({
                    url: action,
                    type: method,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function(data) {
                        var response = $.parseJSON(data);

                        if (response['status'] == 'fail') {
                            document.getElementById('reserve-lead').reset();
                            $('.circle-loader').toggleClass('load-complete failed');
                            $('.checkmark').toggle();
                            $('.buy-panel').find('.error-msg').show();
                            $('.buy-panel').find('.error-msg').text(response['message']);
                            setTimeout(function() {
                                $('body').removeClass('get-buy-panel');
                            }, 2000);
                            setTimeout(function() {
                                $('.buy-panel').removeClass('status-success');
                                $('.circle-loader').toggleClass('load-complete failed');
                                $('.checkmark').toggle();
                                $('.buy-panel').find('.error-msg').hide();
                            }, 2200);
                        } else if (response['status'] == 'success') {
                            document.getElementById('reserve-lead').reset();
                            $('.circle-loader').toggleClass('load-complete');
                            $('.checkmark').toggle();
                            setTimeout(function() {
                                $('body').removeClass('get-buy-panel');
                            }, 2000);
                            setTimeout(function() {
                                $('.buy-panel').removeClass('status-success');
                                $('.circle-loader').toggleClass('load-complete');
                                $('.checkmark').toggle();
                            }, 2200);
                            setTimeout(function() {
                                Sidebar.UpdateSidebar();
                                Apartment.LoadFloor(floor);
                                $('.view-apartment.select-apartment').removeClass('select-apartment');
                            }, 3000);
                        }
                    },

                    error: function(e) {

                    }
                });
            }
        });
    })();

    FormPanel.Validate = Validate;
    window.FormPanel = FormPanel;
})(window);