(function($) {
    $(document).ready(function() {
        if ($(window).width() <= 767) {
            $(document).ready(function(){
                $('.service__slider-mobile').slick();
            });
        }
    })
})(jQuery);