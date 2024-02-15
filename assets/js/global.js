(function ($) {
    $(document).ready(function () {
        // Ingenius made sticky header
        function headerSticky(){
            if ($(window).width() > 1164) {
                // if scrollTop inferior to 150px, header is default
                if($(this).scrollTop() < 150){
                    $('.sticky-wrapper .site-logo-img img').attr('src', '/wp-content/uploads/2024/01/logo-ginette1.png').attr('srcset', '/wp-content/uploads/2024/01/logo-ginette1.png');
                    $('.sticky-wrapper').removeClass('hidden');
                    $('.sticky-wrapper').removeClass('sticked');
                    $('body').removeClass('header-hidden');
                }
                // if superior to 150 and inferior to 300px 
                else if ($(this).scrollTop() >= 150 && $(this).scrollTop() < 300 && !$('body').hasClass("mobile-menu-active")) {
                    $('.sticky-wrapper').addClass('hidden');
                    $('.sticky-wrapper').removeClass('sticked');
                    $('body').removeClass('header-sticked').addClass('header-hidden');
                }
                // if superior to 300, change logo to smaller and
                else if($(this).scrollTop() >= 300){ 
                    $('.sticky-wrapper .site-logo-img img').attr('src', '/wp-content/uploads/2024/01/logo-ginette-mobile.png').attr('srcset', '/wp-content/uploads/2024/01/logo-ginette-mobile.png');
                    $('.sticky-wrapper').removeClass('hidden');
                    $('.sticky-wrapper').addClass('sticked');
                    $('body').addClass('header-sticked').removeClass('header-hidden');
                } 
            }
        }
        headerSticky();
        $(window).scroll(function(){
            headerSticky();
        });

        // Menu mobile
        function menuMobile(){
            if ($(window).width() < 1164) {
                $('.mega-menu-trigger').on('click', function(){
                    // Fermer tous les autres sous-menus
                    $('.header-nav-items-mobile .header-nav-item-wrapper').not($(this).parent('.header-nav-item-wrapper')).removeClass('active');

                    // Basculer la classe active pour le sous-menu actuel
                    $(this).parent('.header-nav-item-wrapper').toggleClass('active');
                })
    
                $('.burger-menu').on('click', function(){
                    $('body').toggleClass('menu-mobile-is-active');

                    // Close others things
                    $('header').removeClass('search-is-visible');
                    $('.global-overlay').removeClass('is-visible');
                })

                let transitionDelay = 35;
                let allItems = $('.header-nav-items-mobile .header-nav-item-wrapper');
        
                let i = 1;
                $(allItems).each(function(){
                    $(this).css('transition-delay', transitionDelay * i + 'ms');
                    i++;
                })
            }
        }
        menuMobile();

        let addToWL = document.querySelector('.yith-wcwl-add-to-wishlist');
        if (addToWL) {
            document.querySelector('.uagb-block-cb3e7c30').appendChild(addToWL);
        }

        function headerMegaMenuNavChangeonHover(){
            $('.mega-menu-items li').hover(function(){
                let key = $(this).data('header-mega-menu-cat-key');
                $('.header-sub-menu-right-col-cat').hide();
                $('.header-sub-menu-right-col-cat[data-header-mega-menu-cat="'+ key +'"]').show();
            });
        }
        headerMegaMenuNavChangeonHover();

        function globalOverlay(){
            $('.global-overlay').toggleClass('is-visible');
            $('.global-overlay').on('click', function(){
                $('.global-overlay').removeClass('is-visible');
                $('header').removeClass('search-is-visible');
            })
       }

        function triggerCartButton(){
            $('#cart-trigger').on('click', function(){
                jQuery("body").trigger("fkcart_open");

                // close others things
                $('body').removeClass('menu-mobile-is-active');
                $('header').removeClass('search-is-visible');
            })
        }
        triggerCartButton();
        

        function ajaxSearchBarSettings(){
            $('.search-trigger').on('click', function(){
                $('.orig').focus();
                $('header').toggleClass('search-is-visible');
                $('body').toggleClass('search-is-visible');

                globalOverlay();
                if($('body').hasClass('menu-mobile-is-active')){
                    $('body').removeClass('menu-mobile-is-active');
                }
            })

            $(".asp_main_container").on("asp_results_show", function() { 
                let resultItemTerm = $('.resdrg > div.asp_r_term');
                if(resultItemTerm.length == 0){
                    $('.results .resdrg').addClass('no-term-found');
                } else {
                    $('.results .resdrg').removeClass('no-term-found');
                }

                // Ajuste la position verticale de chaque div enfant
                resultItemTerm.each(function(index) {
                    var topPosition = -4 + index * (14 * 2); // Ajuste la valeur selon l'espacement souhaité entre les div
                    $(this).css("top", topPosition + "px");
                });                


                if ($(window).width() <= 767) {
                    $('body #ajaxsearchprores1_1 .asp_r_term').eq(0).css("margin-top", "1.5em");
                }

            });
        }
        ajaxSearchBarSettings();

        function customAjaxAddToCartAnimation(){
            function ajaxCircleAnimation(){
                return '<div class="custom-loading-icon"><div class="loading-icon"><div class="circle"></div></div></div>';
            }
            // Affichez l'icône de chargement sur les boutons d'ajout au panier ajax au début de la requête
            $('.ajax_add_to_cart, .single_add_to_cart_button').on('click', function(e){
                e.preventDefault();
                // if it is a link (spectra add to cart) cancel default
                let clickedAddToCartButton = $(this);
                let defaultText = $(this).text();
                clickedAddToCartButton.text('Ajout...');
                clickedAddToCartButton.append(ajaxCircleAnimation());
    
                $(document).on( "ajaxComplete", function() {
                    setTimeout(function(){
                        // Reset
                        clickedAddToCartButton.text(defaultText);
                    }, 400)
                    
                    // Détachez les gestionnaires d'événements pour éviter toute accumulation
                    $(document).off('ajaxStart ajaxComplete');
                } );
            })
        }
        customAjaxAddToCartAnimation();

        function globalPopupSetting(){
            function scrollOff(){
                $('body').addClass('scrollOff');
            }

            function scrollOn(){
                $('body').removeClass('scrollOff');
            }
    
            function globalHidePopup() {
                $('.global-popup').hide();
                scrollOn();
            }

            // SHOW
            $('.global-filter-button').on('click', function(){
                $('.global-popup-filtre').show().addClass('is-visible');
                scrollOff();
            })

            $('.trigger-all-review-popup').on('click', function(){
                $('#popup-reviews-container').show().addClass('is-visible');
                scrollOff();
            })

            $('.trigger-review-form').on('click', function(){
                $('#popup-review-form-container').show().addClass('is-visible');
                scrollOff();
            })

            // HIDE GLOBALLY
            $('.close-popup, .popup-overlay').on('click', function(){
                $('.global-popup.is-visible').hide().removeClass('is-visible');
                scrollOn();
            });
    
            // Attachez un gestionnaire d'événements à la touche Escape
            $(document).on('keydown', function(e) {
                // Vérifiez si la touche pressée est Escape (code 27)
                if (e.which === 27) {
                    globalHidePopup();
                    scrollOn();
                }
            });
        }
        globalPopupSetting();

        function seeMoreTags(){
            if(!$('body').hasClass('page-id-29017')){
                $('.listing-item-see-more-tag').on('click', function(){
                    $(this).parent('.listing-recette__tag-wrapper').addClass('all-tags-visible');
                    $(this).remove();
                })

                $(".listing-item-see-more-tag:last-child").remove();
            }
        }
        seeMoreTags();

        function hideAllReviewIfNoReview(){
            let reviewListing = $('.block-post-review .jet-listing-not-found.jet-listing-grid__items');
            if(reviewListing.length > 0){
                $('.trigger-all-review-popup').remove();
            }
        }
        hideAllReviewIfNoReview();
        
        function hideBlockIfDynamicContentIsEmpty(){
            $('.dynamic-content').each(function(){
                if($(this).is(':empty')){
                    $(this).closest('.dynamic-content-container, .block-info').remove();
                }
            })
        }
        hideBlockIfDynamicContentIsEmpty();
    })
})(jQuery);