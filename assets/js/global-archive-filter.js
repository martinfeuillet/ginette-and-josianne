(function ($) {
    $(document).ready(function () {
        /* function addClearIconSearch(){
            $('.global-filter-wrapper .jet-search-filter__input-wrapper').append('<span class="icon" id="clearIcon"></span>');

            var inputField = $(".global-filter-wrapper .jet-search-filter__input-wrapper .jet-search-filter__input");
            var clearIcon = $("#clearIcon");

            // Affiche l'icône quand l'utilisateur commence à écrire
            inputField.on("input", function() {
                var inputValue = $(this).val();
                clearIcon.toggle(!!inputValue); // Affiche l'icône seulement si l'input n'est pas vide
            });

            // Efface le contenu de l'input lorsqu'on clique sur l'icône
            clearIcon.on("click", function() {
                inputField.val("");
                $(this).hide();
            });
        } */

        /* // hide original duplicated checkboxes
        function deleteDuplicateCheckboxes(){
            // Santé digestive
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Santé digestive"]').parent().parent().addClass('remove-filter-checkbox');
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Santé digestive"]').parent().parent().next('.jet-list-tree__children').addClass('remove-filter-checkbox');

            // Librairie
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Librairie"]').parent().parent().addClass('remove-filter-checkbox');
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Librairie"]').parent().parent().next('.jet-list-tree__children').addClass('remove-filter-checkbox');

            // Les cartes cadeaux
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Les cartes cadeaux"]').parent().parent().addClass('remove-filter-checkbox');
            $('.checkbox-product-category .jet-checkboxes-list__input[data-label="Les cartes cadeaux"]').parent().parent().next('.jet-list-tree__children').addClass('remove-filter-checkbox');
        }
        // deleteDuplicateCheckboxes(); */

        // Move filter tags code
        function moveFilterTagsToSelectedFilter(){
            function moveSelectedTags(){
                // select all tag input
                let allSelectedTag = $('.global-filter-group-wrapper .jet-checkboxes-list__input');
                // get the destination div
                var NewSelectedFilterWrapper = $('.selected-filter-wrapper');
                // at each click on an input we clear the selected filter wrapper
                NewSelectedFilterWrapper.empty();
                
                // Créer une structure de données pour stocker les paires (data-label, valeur)
                var existingPairs = {};

                // add old one and new one
                allSelectedTag.each(function(){
                    let selectedID = $(this).val();
                    let selectedLabel = $(this).data('label');
                    var pair = selectedLabel + '|' + selectedID;

                    // prevent multiple same input to create each their new selected tag
                    if (existingPairs[pair]) {
                        // add inactive to all input that come after first one
                        $(this).addClass('inactive');
                    } else {
                        existingPairs[pair] = true;
                    }

                    // only if active 
                    if($(this).is(':checked') && !$(this).hasClass('inactive')){
                        // create selected filter tag remover with the id and the label to retrieve later on delete function
                        NewSelectedFilterWrapper.append('<div class="jet-filter-items-dropdown__active__item" data-value="'+ selectedID +'" data-label="'+ selectedLabel +'">'+ selectedLabel +'<span class="jet-filter-items-dropdown__active__item__remove">×</span></div>')
                    }
                })
            }

            function deleteAllTags(){
                // when click on cloned selected tags
                $('.selected-filter-wrapper .jet-filter-items-dropdown__active__item').on('click', function(){
                    // get data that permit to retrieve the right jetengine original input (id and label)
                    let selectedClonedTagsID = $(this).data('value');
                    let selectedClonedTagsLabel = $(this).data('label');

                    $('.global-filter-group-wrapper .jet-checkboxes-list__input[data-label="' + selectedClonedTagsLabel + '"]').not('.inactive').val(selectedClonedTagsID).click();
                    // Then remove it 
                    $(this).remove(); 
                });
            }

            function synchronizeSameJetCheckboxes(){
                // original to cloned
                setTimeout(function(){
                    // Variable pour suivre si un clic est en cours de simulation afin d'éviter la récursivité (click l'un sur l'autre à l'infini)
                    var isSimulatingClick = false;
                    $('.original-jet-filter-checkboxes .jet-checkboxes-list__input').on('click', function(){
                        let originalCheckboxID = $(this).val();
                        let originalCheckboxLabel = $(this).data('label');
                        let jetDropdownContainer = $(this).parent().parent().parent().parent().parent().parent().parent().parent();

                        // Vérifiez si un clic est en cours de simulation, si oui, arrêtez ici
                        if (isSimulatingClick) {
                            return;
                        }
                        // Désactivez temporairement la gestion des clics pour éviter les click à l'infini
                        isSimulatingClick = true;
                        try {
                            $('.has-cloned-jet-filter-checkboxes .jet-checkboxes-list__input[data-label="' + originalCheckboxLabel + '"]').val(originalCheckboxID).click();
                            $(this).closest('.jet-filter-items-dropdown').addClass('jet-dropdown-open');
                        } finally {
                            // Réactivez la gestion des clics après la simulation
                            isSimulatingClick = false;
                        }
                    })
                }, 200);

                // cloned to original
                setTimeout(function(){
                    var isSimulatingClick = false;
                    $('.has-cloned-jet-filter-checkboxes .jet-checkboxes-list__input').on('click', function(){
                        let clickedInactiveCloneCheckboxID = $(this).val();
                        let clickedInactiveCloneCheckboxLabel = $(this).data('label');

                        if (isSimulatingClick) {
                            return;
                        }
                        isSimulatingClick = true;
                        try {
                            $('.original-jet-filter-checkboxes .jet-checkboxes-list__input[data-label="' + clickedInactiveCloneCheckboxLabel + '"]').not('.inactive').val(clickedInactiveCloneCheckboxID).click();
                            $(this).closest('.jet-filter-items-dropdown').addClass('jet-dropdown-open');
                        } finally {
                            isSimulatingClick = false;
                        }
                    })
                }, 200);
            }
            synchronizeSameJetCheckboxes();

            
            // ON PAGE LOAD
            setTimeout(function(){
                moveSelectedTags();
                deleteAllTags();
            }, 200);
            

            // ON INTERACTION
            $('.global-filter-group-wrapper .jet-checkboxes-list__input').on('click', function(event){
                setTimeout(function(){
                    moveSelectedTags();
                    deleteAllTags();
                }, 200);
            })
            
        }
        moveFilterTagsToSelectedFilter();


        
        /* // Fix jetfilter same checkbox issue. If multiple checbox with same term is set on one page, only the last one filter the listing
        // So we create one checkbox, and we simulate click on it when the other same checkbox item are clicked
        function fixSameTermCheckboxBug(){
            $('.unique-checkbox .jet-checkboxes-list__row .jet-checkboxes-list__input').on('click', function (){
                let jetInactiveUniqueCheckboxLabel = $(this).next().children('.jet-checkboxes-list__label').text().replace(/[\W]+/g, '');
                let originalSelectedCheckboxLabel = $('.jet-filter-items-dropdown__body .jet-checkboxes-list-wrapper .jet-checkboxes-list__row .jet-checkboxes-list__label');
                originalSelectedCheckboxLabel.each(function(){
                    // On retire les caractères spéciaux lors de la comparaison pour éviter les bugs
                    if($(this).text().replace(/[\W]+/g, '') == jetInactiveUniqueCheckboxLabel){    
                        $(this).parent().parent('.jet-checkboxes-list__item').children('.jet-checkboxes-list__input').click();
                    }
                })
                
            })
        }
        fixSameTermCheckboxBug(); */

        /* function moveBlockFilter(){
            let filters = $('.global-filter-groups');
            let defaultPosition = $('.filters-groups-wrapper')
            let newPosition = $('.popup-filtre-groups');
            let isFilterVisible = false;

            // Fonction pour déplacer les filtres à la position d'origine
            function moveToDefaultPosition() {
                filters.appendTo(defaultPosition);
                isFilterVisible = false;
            }

            // Attachez un gestionnaire d'événements au clic sur le bouton
            $('.global-filter-button').on('click', function() {
                // Vérifiez si les filtres sont visibles
                if (isFilterVisible == false) {
                    // Déplacez les filtres à la nouvelle position
                    filters.appendTo(newPosition);
                    isFilterVisible = true;
                }

            });

            $('.close-popup').on('click', function() {
                moveToDefaultPosition();
            })
        }
        moveBlockFilter(); */

        // Change by ajax the total listing result count (with pagination system) 
        function getListingCountAfterJetFilterAjax(){
            // Intercepte la réponse AJAX après la validation du filtre
            $(document).ajaxComplete(function(event, xhr, settings) {
                // on ajoute un délai de 100ms afin que le code ne se lance pas en même temps que celui de smartfilter et que cela crée des bugs
                setTimeout(function(){
                    // Analyse la réponse JSON
                    var response = $.parseJSON(xhr.responseText);
                    // Vérifie si le nombre d'éléments trouvés est disponible dans la réponse
                    if (response.pagination) {
                        console.log(response.pagination);
                        let foundPost = response.pagination.found_posts;
                        // Affiche le nombre d'éléments trouvés
                        $('.listing-count .count-type-total').text(foundPost);
                    }
                }, 500);
            });
        }
        getListingCountAfterJetFilterAjax();

        function updateCheckboxesText(){
            $('.jet-checkboxes-list__input[data-label="Abonnement"]').next('.jet-checkboxes-list__button').children('.jet-checkboxes-list__label').text('VIP');        
        }
        updateCheckboxesText();

        
    })
})(jQuery);