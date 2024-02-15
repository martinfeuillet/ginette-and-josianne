(function($) {
    $(document).ready(function() {
        if ($(window).width() <= 767) {
            $('.service__slider-mobile').slick({
                slidesToShow: 2,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2500,
            });
        }
    })
})(jQuery);