(function ($) {
    $(document).ready(function () {
        function moreLessTags(){
            var tagsContainer = $('.is-tags-container');
            var itemShowDefault = 1;

            tagsContainer.each(function(){
                var parentTagsContainer = $(this);
                var tags = $(this).children('.is-tag');
                // hide all after second
                tags.filter(':gt(' + itemShowDefault + ')').hide();

                if (tags.length > itemShowDefault + 1 && parentTagsContainer.find('.show-more-tags, .show-less-tags').length === 0) {
                    $('<span class="more-less-tags-btn show-more-tags">+</span>').appendTo(parentTagsContainer);
                }

                parentTagsContainer.off('click', '.show-more-tags').on('click', '.show-more-tags', function() {
                    tags.show();
                    $(this).text('-').toggleClass("show-more-tags show-less-tags");
                });
        
                parentTagsContainer.off('click', '.show-less-tags').on('click', '.show-less-tags', function() {
                    tags.filter(':gt(' + itemShowDefault + ')').hide();
                    parentTagsContainer.find('.show-less-tags').text('+').toggleClass("show-more-tags show-less-tags");
                });
            })
        }
        moreLessTags();

        // $(document).on( 'jet-engine/listing-grid/after-load-more', (evt, element, response)=>{
        //     if(response.success) {
        //         moreLessTags();
        //     }
        // });

        $(document).ajaxComplete(function(event, xhr, settings) {
            setTimeout(function(){
                moreLessTags();            
            }, 200);
        })

        

        
    })
})(jQuery);