(function (window) {
    var Navigation = window.Navigation || {};

    function init() {
        // Навигация
        $('.navigation-section').on('click', function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $('.navigation-section').removeClass('active');
                $(this).addClass('active');
            }

            if ($('.navigation-section').hasClass('active')) {
                $('loader').addClass('active');
                $('#boxApartments').addClass('filter-blur');
            } else {
                $('loader').removeClass('active');
                $('#boxApartments').removeClass('filter-blur');
            }

            $('loader').click(function() {
                $('loader').removeClass('active');
                $('#boxApartments').removeClass('filter-blur');
                $('.navigation-section').removeClass('active');
            });
        });
        // Навигация
    }

    (function() {
        $(document).on('submit', '#actual-info', function(e) {
            e.preventDefault();

            var form = $(this);
            var action = form.attr('action');
            var method = form.attr('method');

            $('loader').addClass('loading');
            $('#boxApartments').addClass('filter-blur');

            var floor = $('.select-floor').find('.floor').text();

            $.ajax({
                url: action,
                type: method,
                contentType: false,
                cache: false,
                proccessData: false,

                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response['status'] == 'success') {
                        if(window.location.toString().indexOf('module/tesla/home')>0) {
                            Sidebar.UpdateSidebar();
                            Apartment.LoadFloor(floor);
                        }
                        $('.circle-loader').toggleClass('load-complete');
                        $('.checkmark').toggle();
                        $('loader').find('.success-msg').show();
                        $('loader').find('.success-msg').text(response['message']);
                        setTimeout(function() {
                            $('loader').removeClass('loading');
                            $('.circle-loader').toggleClass('load-complete');
                            $('.checkmark').toggle();
                            $('loader').find('.success-msg').hide();
                            $('loader').find('.success-msg').text();
                            $('#boxApartments').removeClass('filter-blur');
                        }, 800);
                    } else if (response['status'] == 'fail') {
                        $('.circle-loader').toggleClass('load-complete');
                        $('.checkmark').toggle();
                        $('loader').find('.error-msg').show();
                        $('loader').find('.error-msg').text(response['message']);
                        setTimeout(function() {
                            $('loader').removeClass('loading');
                            $('.circle-loader').toggleClass('load-complete failed');
                            $('.checkmark').toggle();
                            $('loader').find('.error-msg').hide();
                            $('loader').find('.error-msg').text();
                            $('#boxApartments').removeClass('filter-blur');
                        }, 800);
                    }
                },

                error: function(e) {

                }
            });
        });
    })();

    Navigation.init = init;
    window.Navigation = Navigation;
})(window);