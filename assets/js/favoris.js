(function ($) {
    $(document).ready(function () {
        function ShowAllBlock(){
            $('.favoris-listing-block').addClass('visible');
            $('.favoris-listing-block').removeClass('hidden');
        }

        function ShowHideContentFromUrl(){
            setTimeout(function(){
                // get anchor and remove "#"
                var hash = $(location).attr('hash').replace('#', '');     
                $('.favoris-listing-block').each(function(){
                    var block_listing_id = $(this).attr('id');
                    // if button is not show all, add "block-" to retrieve the block targetted using the anchor from the url
                    if(hash != ''){
                        var target = 'block-' + hash;  
                        if(target == block_listing_id){
                            $(this).addClass('visible'); 
                            $(this).removeClass('hidden');
                        } else {
                            $(this).removeClass('visible'); 
                            $(this).addClass('hidden');
                        }
                    } else {
                        ShowAllBlock();
                    }
                })


                //
                $('.search-favoris').each(function(){
                    var search = $(this);
                    // if button is not show all, add "block-" to retrieve the block targetted using the anchor from the url
                    if(hash != ''){
                        var target = 'search-' + hash;  
                        if(search.hasClass(target)){
                            $(this).addClass('visible'); 
                            $(this).removeClass('hidden');
                        } else {
                            $(this).removeClass('visible'); 
                            $(this).addClass('hidden');
                        }
                    } else {
                        $('.search-favoris-produits').addClass('visible');
                    }
                })
            }, 100);
        }

        function tabItem(){
            let tabItem = $('.favoris-tab-button');
            $(tabItem).on('click', function(){
                tabItem.removeClass('active');
                $(this).addClass('active');
                ShowHideContentFromUrl();

            })

            // on page load, add active to the current tab
            pageloadhash = $(location).attr('hash');
            $('.favoris-tab-button a').each(function(){
                if(pageloadhash == $(this).attr('href')){
                    $(this).parent().addClass('active');
                } else if($(this).attr('href') == '#'){
                    $(this).parent().addClass('active');
                }
            })

            ShowHideContentFromUrl();
            ShowAllBlock();
        }
        tabItem();

    })
})(jQuery);