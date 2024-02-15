jQuery(document).ready(function ($) {
    $('#wpforms-form-29573').submit(function (e) {
        e.preventDefault();

        let email = $('#wpforms-29573-field_1').val();
        let url = window.location.href;

        // Supprime le slash final s'il existe
        if (url.endsWith('/')) {
            url = url.substring(0, url.length - 1);
        }

        let productSlug = url.substring(url.lastIndexOf('/') + 1);

        $.ajax({
            url: wp_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'update_restock_list',
                email: email,
                product_slug: productSlug
            },
            success: function (response) {
                // Gérer la réponse ici, par exemple afficher un message de succès
                console.log(response);
            }
        });
    });
});
