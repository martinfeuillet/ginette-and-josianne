(function ($) {
    $(document).ready(function () {
        $('.blog-filter-wrapper .jet-checkboxes-list-wrapper').prepend('<div class="jet-checkboxes-list__button filter-button-all checked"><span class="jet-checkboxes-list__label">Tous</span></div>');

        let allFilterInput = $('.jet-checkboxes-list-wrapper .jet-checkboxes-list__row .jet-checkboxes-list__input');
        let allFilterButton = $('.jet-checkboxes-list-wrapper .jet-checkboxes-list__button');

        allFilterInput.on('click', function(){
            allFilterInput.each(function(){
                if($(this).is(':checked')){
                    $('.filter-button-all').removeClass('checked');
                    return false;
                } else {
                    $('.filter-button-all').addClass('checked');
                }
            })
        })

        $('.filter-button-all').on('click', function(){
            $('.filter-button-all').addClass('checked');
            allFilterInput.each(function(){
                if($(this).is(':checked')){
                    $(this).next().click();
                }
            })
        })
    })
})(jQuery);