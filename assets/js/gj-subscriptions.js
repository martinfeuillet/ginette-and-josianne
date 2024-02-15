(function ($) {
  "use strict";
  console.log("Script loaded");

  $(function () {
    /**
     * Attach click event listener to elements with class '.gj-subscriptions-no-subscription'.
     */
    $(".gj-subscriptions-no-subscription").on("click", cancelSubscriptionEvent);

    /**
     * Handles the click event to cancel a user's subscription.
     */
    function cancelSubscriptionEvent() {
      $.ajax({
        url: wp_ajax.ajax_url, // Assurez-vous que wp_ajax.ajax_url est bien défini.
        type: "POST",
        data: {
          action: "gj_cancel_user_membership",
          nonce: wp_ajax.nonce, // Ajoutez un nonce pour la sécurité, assurez-vous de le localiser dans votre script PHP.
        },
        success: (response) => handleCancelSubscriptionResponse(response),
        error: (error) => console.error("Erreur lors de l'annulation:", error),
      });
    }

    /**
     * Handles the response from the server after trying to cancel a subscription.
     */
    function handleCancelSubscriptionResponse(response) {
      // Vérifiez que la réponse est bien celle attendue. Parfois, vous devrez peut-être faire response.data.status ou quelque chose de similaire.
      if (
        response.success &&
        (response.data === "paused" ||
          response.data === "suspended" ||
          response.data === "cancelled" ||
          response.data === "expired")
      ) {
        window.location.reload(); // Recharge la page pour voir les changements.
      } else {
        // Gérer les cas où la requête a réussi mais l'opération a échoué.
        console.error("Échec de l'annulation:", response.data);
      }
    }
  });
})(jQuery);
