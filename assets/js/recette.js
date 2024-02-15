(function($) {
    $(document).ready(function() {
        let select = $('#recette-nombre-personne-select');
        $('.ingredient-list ul li').each(function () {
            let ingredientQtyNumber = $(this);
            var texteLi = $(this).text();
            var nombres = texteLi.match(/\d+/g);
            if (nombres !== null) {
                select.on('change', function handleChange(event) {
                    for (var i = 0; i < nombres.length; i++) {
                        let selectedValue = event.target.value;
                        var nombreOriginal = parseInt(nombres[i]);
                        var multipliedNumber = nombreOriginal * selectedValue;
                    }
                    newIngredientQty = texteLi.replace(nombreOriginal, multipliedNumber);
                    ingredientQtyNumber.text(newIngredientQty);
                });
            }
        });

        // Sélectionne toutes les listes ul avec la classe "etape-liste"
        $(".recette-content ul").each(function(index) {
            // Récupère tous les éléments li dans cette liste ul
            var listItems = $(this).find("li");

            liIndex = -1;
            // Itère sur chaque élément li et ajoute le texte "Étape X" où X est l'index + 1
            listItems.each(function(liIndex) {
                
                $(this).prepend("<span class='stage-class'>Étape " + (liIndex + 1) + "</span><br>");
            });
        });

    })
})(jQuery);