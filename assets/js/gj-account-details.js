(function ($) {
  "use strict";

  /**
   *  Initializes event listeners for account details page.
   */
  function initialize() {
    $(".gj-account-details-tab-content-edit-button")
      .off("click")
      .on("click", setEditButton);
    $(".gj-account-details-tab-content-save-button")
      .off("click")
      .on("click", setSaveButton);
    $(".gj-account-details-tab-content-cancel-button")
      .off("click")
      .on("click", cancelEditMode);
    $(".show-password-button")
      .off("click")
      .on("click", function () {
        togglePasswordInputType($(this).attr("id"));
      });
  }

  /**
   *  Triggered when the 'Edit' button is clicked. Prepares and shows the form for editing.
   */
  function setEditButton() {
    const buttonId = $(this).attr("id");
    const $formToEdit = $("#" + buttonId + "-form");
    $formToEdit.removeClass("form-hidden");

    if (buttonId === "address") {
      $(".gj-address-container").removeClass("form-hidden");
      toggleToEditMode($formToEdit, $(this));
    } else if (buttonId === "privacy") {
      hideOtherSections(buttonId);
      toggleButtonDisplay("none", "flex", "flex");
      // toggleButtonText($(this), 'Enregistrer');
    } else {
      toggleToEditMode($formToEdit, $(this));
    }
  }

  /**
   *  Triggered when the 'Edit' button is clicked. Prepares and shows the form for editing.
   */
  function setSaveButton() {
    const buttonId = $(this).attr("id");
    const $formToEdit = $("#" + buttonId + "-form");

    if (buttonId === "privacy") {
      const currentPassword = $("#current_user_password_input").val().trim();
      const newPassword = $("#new_user_password_input").val().trim();
      const confirmNewPassword = $("#new_user_password_2_input").val().trim();

      console.log(currentPassword, newPassword, confirmNewPassword);

      if (validatePasswords(currentPassword, newPassword, confirmNewPassword)) {
        updatePassword($formToEdit, buttonId, currentPassword, newPassword);
      }
    } else {
      updateFormMeta($formToEdit, $(this));
    }
  }

  /**
   * Makes an AJAX call to update the user's password with the provided new password.
   * @param {jQuery} $form - The jQuery object representing the form.
   * @param {string} buttonId - The ID of the button.
   * @param {string} currentPassword - The current password.
   * @param {string} newPassword - The new password.
   */
  function updatePassword($form, buttonId, currentPassword, newPassword) {
    console.log("update password");
    $.ajax({
      url: wp_ajax.ajax_url,
      type: "POST",
      data: {
        action: "gj_update_user_password",
        currentPassword: currentPassword,
        newPassword: newPassword,
      },
      success: (response) =>
        handlePasswordUpdateResponse(response, $form, buttonId),
      error: (error) => console.error("Erreur de mise à jour:", error),
    });
  }

  /**
   * Handles the response from the password update AJAX call.
   * @param {object} response - The response from the AJAX call.
   * @param {jQuery} $form - The jQuery object representing the form.
   * @param {string} buttonId - The ID of the button.
   */
  function handlePasswordUpdateResponse(response, $form, buttonId) {
    if (response.success) {
      showAllSections();
      $("#password-form-error-message").css("display", "none");
      $form.addClass("form-hidden");
    } else {
      $("#password-form-error-message").text(
        response.data || "Une erreur inconnue est survenue."
      );
    }
  }

  /**
   * Validates the new password against certain rules.
   * @param {string} current - The current password.
   * @param {string} newPass - The new password.
   * @param {string} confirmNew - The confirmed new password.
   * @returns {boolean} - True if the validation passes, false otherwise.
   */
  function validatePasswords(current, newPass, confirmNew) {
    console.log("Validate Password");
    // console.log(current, newPass, confirmNew)
    if (newPass !== confirmNew) {
      $("#password-form-error-message").text(
        "Les mots de passe ne correspondent pas !"
      );
      return false;
    } else if (newPass === current) {
      $("#password-form-error-message").text(
        "Le nouveau mot de passe ne peut pas être le même que le mot de passe actuel."
      );
      return false;
    }

    let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (!regex.test(newPass)) {
      $("#password-form-error-message").text(
        "Le nouveau mot de passe doit contenir 8 caractères minimum, 1 caractère minuscule, 1 caractère majuscule, et 1 chiffre."
      );
      return false;
    }

    return true;
  }

  /**
   * Makes an AJAX call to update the user's metadata with the provided form data.
   * @param {jQuery} $formToEdit - The jQuery object representing the form to be edited.
   * @param {jQuery} $button - The jQuery object representing the button.
   */
  function updateFormMeta($formToEdit, $button) {
    let formData = {};
    $formToEdit.find(".editable-field").each(function () {
      let $input = $(this);
      formData[$input.attr("name")] = $input.val();
    });

    console.log(formData);

    $.ajax({
      url: wp_ajax.ajax_url,
      type: "POST",
      data: {
        action: "gj_update_user_meta",
        formData: formData,
      },
      success: function (response) {
        if (response.success) {
          console.log("Mise à jour réussie:", response);
          toggleToViewMode($formToEdit, $button, false);
        } else {
          console.error("Erreur de mise à jour:", response);
        }
      },
      error: function (error) {
        console.error("Erreur de mise à jour:", error);
      },
    });
  }

  /**
   * Checks whether to hide or show the forms based on whether all fields are empty.
   * @param {jQuery} containers - The jQuery objects representing the containers.
   * @param {string} formId - The ID of the form.
   */
  function checkAndToggleFormVisibility(containers, formId) {
    containers.each(function () {
      let allEmpty = true;

      $(this)
        .find(".editable-field")
        .each(function () {
          let value = $(this).val().trim();
          if (value !== "") {
            allEmpty = false;
            return false;
          }
        });

      if (allEmpty && $(this).hasClass("form-can-be-hidden")) {
        $(this).addClass("form-hidden");
        $(".gj-" + formId + "-message").removeClass("form-hidden");
      } else {
        $(this).removeClass("form-hidden");
        $(".gj-" + formId + "-message").addClass("form-hidden");
      }
    });
  }

  /**
   * Switches the form to edit mode, making the fields editable.
   * @param {jQuery} $form - The jQuery object representing the form.
   * @param {jQuery} $button - The jQuery object representing the button.
   */
  function toggleToEditMode($form, $button) {
    hideOtherSections($button.attr("id"));

    $form.find("p").each(function () {
      const $p = $(this);
      const value = $p.text().trim();
      const name = $p.attr("name");
      const inputType = getInputType(name);

      const $input = $("<input>", {
        type: inputType,
        id: name,
        name: name,
        value: value,
        placeholder: getInputPlaceholder(value, name),
        class: "editable-field",
      });

      if (name === "birth_date") {
        editBirthDate(value);
      } else if (name === "card_expiry") {
        editCardExpiryDate(value);
      } else {
        $p.replaceWith($input);
      }
    });

    // toggleButtonText($button, 'Enregistrer');
    toggleButtonDisplay("none", "flex", "flex");
    initialize();
  }

  /**
   * Switches the form back to view mode, making the fields non-editable.
   * @param {jQuery} $form - The jQuery object representing the form.
   * @param {jQuery} $button - The jQuery object representing the button.
   * @param {boolean} revertChanges - Whether to revert changes or not.
   */
  function toggleToViewMode($form, $button, revertChanges = false) {
    let allEmpty = true;

    if ($form.attr("id") === "address-form") {
      checkAndToggleFormVisibility(
        $(".gj-address-container"),
        $form.attr("id")
      );
    }

    // toggleButtonText($button, 'Modifier');
    if ($button.attr("id") === "account-details") {
      saveBirthDate();
    } else if ($button.attr("id") === "payment-methods") {
      saveCardExpiryDate();
    }

    $form.find(".editable-field").each(function () {
      const $input = $(this);
      const value = revertChanges ? $input.attr("placeholder") : $input.val();
      const name = $input.attr("name");

      if (value !== "") {
        allEmpty = false;
      }

      const $p = $("<p>", {
        id: name,
        name: name,
        text: value,
      });

      $input.replaceWith($p);
    });

    if (allEmpty && $form.hasClass("form-can-be-hidden")) {
      $form.addClass("form-hidden");
      $(".gj-" + $form.attr("id") + "-message").removeClass("form-hidden");
    } else {
      $form.removeClass("form-hidden");
      console.log($form.attr("id"));
      $(".gj-" + $form.attr("id") + "-message").addClass("form-hidden");
    }

    toggleButtonDisplay("flex", "none", "none");
    showAllSections();
    initialize();
  }

  /**
   * Determines the input type based on the field name.
   * @param {string} name - The name of the field.
   * @returns {string} - The type of the input.
   */
  function getInputType(name) {
    if (name === "user_email") {
      return "email";
    } else if (
      name.includes("phone") ||
      name.includes("post_code") ||
      name.includes("card_number")
    ) {
      return "tel";
    } else if (name.includes("password")) {
      return "password";
    }
    return "text";
  }

  /**
   * Provides a placeholder for the input based on the field name.
   * @param {string} value - The value of the input.
   * @param {string} name - The name of the field.
   * @returns {string} - The placeholder for the input.
   */
  function getInputPlaceholder(value, name) {
    if (value === "") {
      switch (name) {
        case "billing_last_name":
        case "shipping_last_name":
          return "Doe";

        case "billing_first_name":
        case "shipping_first_name":
          return "John";

        case "birth_date":
          return "JJ/MM/AAAA";

        case "billing_email":
          return "email@example.com";

        case "billing_phone":
        case "shipping_phone":
          return "0123456789";

        case "billing_address_1":
        case "shipping_address_1":
          return "66 Rue Miromesnil";

        case "billing_address_2":
        case "shipping_address_2":
          return "Bâtiment A";

        case "billing_postcode":
        case "shipping_postcode":
          return "75008";

        case "billing_country":
        case "shipping_country":
          return "France";

        case "card_holder_name":
          return "John DOE";

        case "card_number":
          return "**** **** **** ****";

        case "card_expiry":
          return "MM/AA";

        case "billing_company":
        case "shipping_company":
          return "Ginette et Josianne";

        case "billing_city":
        case "shipping_city":
          return "Paris";

        default:
          input.attr("placeholder", "N/A");
      }
    } else {
      return value;
    }
  }

  /**
   *  Saves the birth date after editing.
   */
  function saveBirthDate() {
    let birthDay = $("#birth_day").val();
    let birthMonth = $("#birth_month").val();
    let birthYear = $("#birth_year").val();

    $("#birth_date").replaceWith(`
            <p id="birth_date" type="text" name="birth_date">
                ${birthDay}/${birthMonth}/${birthYear}
            </p>
        `);
  }

  /**
   * Makes birth date fields editable.
   * @param {string} value - The current birth date value.
   */
  function editBirthDate(value) {
    let birthDateP = $("#birth_date");
    let birthDate = value.split("/");

    console.log(birthDate);

    let day = birthDate.length > 0 && birthDate[0] ? birthDate[0] : "";
    let month = birthDate.length > 1 && birthDate[1] ? birthDate[1] : "";
    let year = birthDate.length > 2 && birthDate[2] ? birthDate[2] : "";

    birthDateP.replaceWith(`
			<div class="birth-date-input-container" id="birth_date">
				<div>
					<input class="editable-field" type="number" name="birth_day" id="birth_day" placeholder="JJ" value="${day}" />
					<label for="birth_day">Jour</label>
				</div>
				<div>
					<input class="editable-field" type="number" name="birth_month" id="birth_month" placeholder="MM" value="${month}" />
					<label for="birth_month">Mois</label>
				</div>
				<div class="birth-date-year">
					<input class="editable-field" type="number" name="birth_year" id="birth_year" placeholder="AAAA" value="${year}" />
					<label for="birth_year">Année</label>
				</div>
			</div>
		`);
  }

  /**
   *  Saves the card expiry date after editing.
   */
  function saveCardExpiryDate() {
    let cardExpiryMonth = $("#card_expiry_month").val();
    let cardExpiryYear = $("#card_expiry_year").val();

    $("#card_expiry").replaceWith(`
            <p id="card_expiry" type="text" name="card_expiry">
                ${cardExpiryMonth}/${cardExpiryYear}
            </p>
        `);
  }
  /**
   * Makes card expiry date fields editable.
   * @param {string} value - The current card expiry date value.
   */
  function editCardExpiryDate(value) {
    let cardExpiryDateP = $("#card_expiry");
    let cardExpiryDate = value.split("/");

    console.log(cardExpiryDate);

    let month =
      cardExpiryDate.length > 0 && cardExpiryDate[0] ? cardExpiryDate[0] : "";
    let year =
      cardExpiryDate.length > 1 && cardExpiryDate[1] ? cardExpiryDate[1] : "";

    cardExpiryDateP.replaceWith(`
			<div class="card-expiry-input-container" id="card_expiry">
				<div>
					<input class="editable-field" type="number" name="card_expiry_month" id="card_expiry_month" placeholder="MM" value="${month}" />
					<label for="card_expiry_month">Mois</label>
				</div>
				<div class="card_expiry_year">
					<input class="editable-field" type="number" name="card_expiry_year" id="card_expiry_year" placeholder="AAAA" value="${year}" />
					<label for="card_expiry_year">Année</label>
				</div>
			</div>
		`);
  }

  /**
   * Toggles the text of a button between 'Edit' and 'Save'.
   * @param {jQuery} $button - The jQuery object representing the button.
   * @param {string} newText - The new text for the button.
   */
  function toggleButtonText($button, newText) {
    $button
      .text(newText)
      .toggleClass(
        "gj-account-details-tab-content-save-button gj-account-details-tab-content-edit-button"
      );
    initialize();
  }

  // Toggles the display of edit, save, and cancel buttons.
  function toggleButtonDisplay(
    newEditButtonStyle,
    newSaveButtonStyle,
    newCancelButtonStyle
  ) {
    $(".gj-account-details-tab-content-edit-button").css(
      "display",
      newEditButtonStyle
    );
    $(".gj-account-details-tab-content-save-button").css(
      "display",
      newSaveButtonStyle
    );
    $(".gj-account-details-tab-content-cancel-button").css(
      "display",
      newCancelButtonStyle
    );
    initialize();
  }

  /**
   * Formats a date string into a specific format.
   * @param {string} value - The date string to be formatted.
   * @returns {string} - The formatted date string.
   */
  function formatDateString(value) {
    value = value.replace(/\D/g, "");
    if (value.length >= 2) {
      value = value.substring(0, 2) + "/" + value.substring(2);
    }
    if (value.length >= 5) {
      value = value.substring(0, 5) + "/" + value.substring(5, 9);
    }
    return value;
  }

  /**
   * Formats an expiry date string into a specific format.
   * @param {string} value - The expiry date string to be formatted.
   * @returns {string} - The formatted expiry date string.
   */
  function formatExpiryString(value) {
    value = value.replace(/\D/g, "");
    if (value.length >= 2) {
      value = value.substring(0, 2) + "/" + value.substring(2, 4);
    }
    return value;
  }

  /**
   *  Shows all sections on the page.
   */
  function showAllSections() {
    $(".gj-account-details-tab-content-section")
      .css("display", "")
      .removeClass("triggered-form");
  }

  /**
   * Hides all sections except for the one being edited.
   * @param {string} buttonId - The ID of the button.
   */
  function hideOtherSections(buttonId) {
    const $otherSections = $(".gj-account-details-tab-content-section").not(
      ".gj-" + buttonId
    );

    console.log($otherSections);
    $otherSections.css("display", "none");

    $(".gj-" + buttonId)
      .css("display", "flex")
      .addClass("triggered-form");
  }

  /**
   *  Cancels edit mode and reverts any unsaved changes.
   */
  function cancelEditMode() {
    showAllSections();
    toggleButtonDisplay("flex", "none", "none");
    $("#password-form-error-message").css("display", "none");
    $("#privacy-form").addClass("form-hidden");
  }

  /**
   * Toggles the password input type between text and password.
   * @param {string} buttonId - The ID of the button.
   */
  function togglePasswordInputType(buttonId) {
    let passwordField = $("#" + buttonId + "_input");

    let button = $("." + buttonId + "_img");
    console.log(passwordField);

    if (passwordField.attr("type") === "password") {
      passwordField.attr("type", "text");
      button.attr(
        "src",
        "/wp-content/uploads/2024/01/SVG_hide-password-icon.svg"
      );
      passwordField.attr("type", "password");
      button.attr(
        "src",
        "/wp-content/uploads/2024/01/SVG_show-password-icon.svg"
      );
    }
  }

  /**
   * add logout url to the logout button
   */
  function addLogoutUrlToLogoutButton() {
    let logoutButton = document.querySelector(".yith-se-deconnecter");
    if (myAjax.logout_url) {
      logoutButton.href = myAjax.logout_url;
    }
  }

  addLogoutUrlToLogoutButton();

  initialize();
})(jQuery);
