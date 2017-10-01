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

    Navigation.init = init;
    window.Navigation = Navigation;
})(window);