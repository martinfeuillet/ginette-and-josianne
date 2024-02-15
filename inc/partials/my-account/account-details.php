<?php
require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-account-details.php');
$current_user_id = get_current_user_id();
$current_user = get_current_user();
$current_user_meta = get_user_meta($current_user_id);

$serialized_payment_methods = $current_user_meta['moyens-de-paiement'][0];
$payment_methods = unserialize($serialized_payment_methods);

$address_form_to_show = is_not_empty($current_user_meta['shipping_last_name'][0]) || is_not_empty($current_user_meta['billing_last_name'][0]);
$shipping_address_to_show = is_not_empty($current_user_meta['shipping_last_name'][0]);
$billing_address_to_show = is_not_empty($current_user_meta['billing_last_name'][0]);
$payment_methods_to_show = is_not_empty($payment_methods[0]['card_number']);

?>

<section class="gj-account-details-tab">
    <hr class="gj-account-details-tab-vertical-line right">
    <hr class="gj-account-details-tab-vertical-line left">
    <p class="gj-my-account-breadcrumb-trail">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 8 8" fill="none">
            <g clip-path="url(#clip0_1086_2536)">
                <path
                    d="M1.7207 4.00008C1.7207 4.1434 1.77543 4.28676 1.88464 4.39607L5.32454 7.83589C5.54336 8.05471 5.89814 8.05471 6.11686 7.83589C6.33559 7.61716 6.33559 7.26245 6.11686 7.04362L3.07309 4.00008L6.11665 0.956408C6.33538 0.737679 6.33538 0.382923 6.11665 0.164211C5.89792 -0.0547125 5.54326 -0.0547126 5.32444 0.164211L1.88451 3.60398C1.77532 3.71334 1.7207 3.8567 1.7207 4.00008Z"
                    fill="black" fill-opacity="0.8" />
            </g>
            <defs>
                <clipPath id="clip0_1086_2536">
                    <rect width="8" height="8" fill="white" transform="matrix(1 1.74846e-07 1.74846e-07 -1 0 8)" />
                </clipPath>
            </defs>
        </svg>
        Détails du compte
    </p>
    <div class="gj-account-details-tab-content-main">
        <div class="gj-account-details-tab-content">
            <div class="gj-account-details-tab-content-section gj-account-details">
                <div class="gj-account-details-tab-content-section-header">
                    <div>
                        <h3>Mes informations</h3>
                        <p>
                            N’hésitez pas à modifier vos coordonnées ci-dessous pour que votre compte soit parfaitement
                            à jour.
                        </p>
                    </div>
                    <button type="button" class="gj-account-details-tab-content-edit-button" id="account-details">
                        <img src="/wp-content/uploads/2024/01/SVG_edit-icon.svg" alt="">
                        Modifier
                    </button>
                </div>
                <form class="gj-account-about-edit-form" id="account-details-form">
                    <div>
                        <label for="billing_last_name">Nom</label>
                        <p id="billing_last_name" type="text" name="billing_last_name"
                            value="<?php echo $current_user_meta['billing_last_name'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_last_name'][0]; ?>">
                            <?php echo $current_user_meta['billing_last_name'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_first_name">Prénom</label>
                        <p id="billing_first_name" type="billing_text" name="billing_first_name"
                            value="<?php echo $current_user_meta['billing_first_name'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_first_name'][0]; ?>">
                            <?php echo $current_user_meta['billing_first_name'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="birth_date">Date de naissance</label>
                        <p id="birth_date" type="text" name="birth_date"
                            value="<?php echo $current_user_meta['birth_date'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['birth_date'][0]; ?>">
                            <?php echo $current_user_meta['birth_date'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_email">Email</label>
                        <p id="billing_email" type="email" name="billing_email"
                            value="<?php echo $current_user_meta['billing_email'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_email'][0]; ?>">
                            <?php echo $current_user_meta['billing_email'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_phone">Numéro de téléphone</label>
                        <p id="billing_phone" type="tel" name="billing_phone"
                            value="<?php echo $current_user_meta['billing_phone'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_phone'][0]; ?>">
                            <?php echo $current_user_meta['billing_phone'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_address_1">Adresse de facturation</label>
                        <p id="billing_address_1" type="text" name="billing_address_1"
                            value="<?php echo $current_user_meta['billing_address_1'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_address_1'][0]; ?>">
                            <?php echo $current_user_meta['billing_address_1'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_postcode">Code postal</label>
                        <p id="billing_postcode" type="text" name="billing_postcode"
                            value="<?php echo $current_user_meta['billing_postcode'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_postcode'][0]; ?>">
                            <?php echo $current_user_meta['billing_postcode'][0]; ?>
                        </p>
                    </div>
                    <div>
                        <label for="billing_country">Pays</label>
                        <p id="billing_country" type="text" name="billing_country"
                            value="<?php echo $current_user_meta['billing_country'][0]; ?>"
                            placeholder="<?php echo $current_user_meta['billing_country'][0]; ?>">
                            <?php echo $current_user_meta['billing_country'][0]; ?>
                        </p>
                    </div>

                    <button type="button" class="gj-account-details-tab-content-save-button" id="account-details"
                        style="display: none;">
                        Sauvegarder les modifications
                    </button>
                </form>
            </div>
            <div class="gj-account-details-tab-content-section gj-payment-methods">
                <div class="gj-account-details-tab-content-section-header">
                    <div>
                        <h3>Mes moyens de paiements</h3>
                        <p
                            class="<?php echo $payment_methods_to_show ? 'form-hidden' : ''; ?> gj-payment-methods-form-message">
                            Désolé, vous n’avez pas encore enregistrer de moyen de paiement</p>
                    </div>
                    <button type="button" class="gj-account-details-tab-content-edit-button" id="payment-methods">
                        <img src="/wp-content/uploads/2024/01/SVG_edit-icon.svg" alt="">
                        Modifier
                    </button>
                </div>
                <form
                    class="gj-payment-methods-edit-form form-can-be-hidden <?php echo $payment_methods_to_show ? '' : 'form-hidden'; ?>"
                    id="payment-methods-form">
                    <div>
                        <h4>Type de paiement</h4>
                        <span>Carte bancaire</span>
                    </div>
                    <div>
                        <label for="card_holder_name">Nom du titulaire</label>
                        <p type="text" id="card_holder_name" name="card_holder_name"
                            value="<?php echo $payment_methods[0]['card_holder_name']; ?>">
                            <?php echo $payment_methods[0]['card_holder_name']; ?></p>
                    </div>
                    <div>
                        <label for="card_number">Numéro de carte</label>
                        <p type="text" id="card_number" name="card_number"
                            value="<?php echo $payment_methods[0]['card_number']; ?>">
                            <?php echo $payment_methods[0]['card_number']; ?></p>
                    </div>
                    <div>
                        <label for="card_expiry">Date d'expiration</label>
                        <p type="text" id="card_expiry" name="card_expiry"
                            value="<?php echo $payment_methods[0]['card_expiry']; ?>">
                            <?php echo $payment_methods[0]['card_expiry']; ?></p>
                    </div>

                    <button type="button" class="gj-account-details-tab-content-save-button" id="payment-methods"
                        style="display: none;">
                        Sauvegarder les modifications
                    </button>
                </form>
            </div>
            <div class="gj-account-details-tab-content-section gj-address">
                <div class="gj-account-details-tab-content-section-header">
                    <div>
                        <h3>Mes adresses</h3>
                        <p class="<?php echo $address_form_to_show ? 'form-hidden' : ''; ?> gj-address-form-message">
                            Désolé, vous n’avez pas encore enregistrer d’adresses</p>
                    </div>
                    <button type="button" class="gj-account-details-tab-content-edit-button" id="address">
                        <img src="/wp-content/uploads/2024/01/SVG_edit-icon.svg" alt="">
                        Modifier
                    </button>
                </div>
                <form
                    class="gj-address-edit-form form-can-be-hidden <?php echo $address_form_to_show ? '' : 'form-hidden'; ?>"
                    id="address-form">
                    <div>
                        <div
                            class="gj-address-container form-can-be-hidden <?php echo $shipping_address_to_show ? '' : 'form-hidden'; ?>">
                            <div>
                                <h4>Adresse de livraison</h4>
                            </div>
                            <div>
                                <label for="shipping_last_name">Nom</label>
                                <p id="shipping_last_name" type="text" name="shipping_last_name"
                                    value="<?php echo $current_user_meta['shipping_last_name'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_last_name'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_last_name'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_first_name">Prénom</label>
                                <p id="shipping_first_name" type="text" name="shipping_first_name"
                                    value="<?php echo $current_user_meta['shipping_first_name'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_first_name'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_first_name'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_company">Entreprise</label>
                                <p id="shipping_company" type="text" name="shipping_company"
                                    value="<?php echo $current_user_meta['shipping_company'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_company'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_company'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_phone">Numéro de téléphone</label>
                                <p id="shipping_phone" type="tel" name="shipping_phone"
                                    value="<?php echo $current_user_meta['shipping_phone'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_phone'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_phone'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_address_1">Adresse de livraison</label>
                                <p id="shipping_address_1" type="text" name="shipping_address_1"
                                    value="<?php echo $current_user_meta['shipping_address_1'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_address_1'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_address_1'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_address_2">Complément d'adresse</label>
                                <p id="shipping_address_2" type="text" name="shipping_address_2"
                                    value="<?php echo $current_user_meta['shipping_address_2'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_address_2'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_address_2'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_city">Ville</label>
                                <p id="shipping_city" type="text" name="shipping_city"
                                    value="<?php echo $current_user_meta['shipping_city'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_city'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_city'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_postcode">Code postal</label>
                                <p id="shipping_postcode" type="text" name="shipping_postcode"
                                    value="<?php echo $current_user_meta['shipping_postcode'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_postcode'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_postcode'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="shipping_country">Pays</label>
                                <p id="shipping_country" type="text" name="shipping_country"
                                    value="<?php echo $current_user_meta['shipping_country'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['shipping_country'][0]; ?>">
                                    <?php echo $current_user_meta['shipping_country'][0]; ?>
                                </p>
                            </div>
                        </div>
                        <div
                            class="gj-address-container form-can-be-hidden <?php echo $billing_address_to_show ? '' : 'form-hidden'; ?>">
                            <div>
                                <h4>Adresse de facturation</h4>
                            </div>
                            <div>
                                <label for="billing_last_name">Nom</label>
                                <p id="billing_last_name" type="text" name="billing_last_name"
                                    value="<?php echo $current_user_meta['billing_last_name'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_last_name'][0]; ?>">
                                    <?php echo $current_user_meta['billing_last_name'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_first_name">Prénom</label>
                                <p id="billing_first_name" type="text" name="billing_first_name"
                                    value="<?php echo $current_user_meta['billing_first_name'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_first_name'][0]; ?>">
                                    <?php echo $current_user_meta['billing_first_name'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_email">Email</label>
                                <p id="billing_email" type="email" name="billing_email"
                                    value="<?php echo $current_user_meta['billing_email'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_email'][0]; ?>">
                                    <?php echo $current_user_meta['billing_email'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_company">Entreprise</label>
                                <p id="billing_company" type="text" name="billing_company"
                                    value="<?php echo $current_user_meta['billing_company'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_company'][0]; ?>">
                                    <?php echo $current_user_meta['billing_company'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_phone">Numéro de téléphone</label>
                                <p id="billing_phone" type="tel" name="billing_phone"
                                    value="<?php echo $current_user_meta['billing_phone'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_phone'][0]; ?>">
                                    <?php echo $current_user_meta['billing_phone'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_address_1">Adresse de facturation</label>
                                <p id="billing_address_1" type="text" name="billing_address_1"
                                    value="<?php echo $current_user_meta['billing_address_1'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_address_1'][0]; ?>">
                                    <?php echo $current_user_meta['billing_address_1'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_address_2">Complément d'adresse</label>
                                <p id="billing_address_2" type="text" name="billing_address_2"
                                    value="<?php echo $current_user_meta['billing_address_2'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_address_2'][0]; ?>">
                                    <?php echo $current_user_meta['billing_address_2'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_city">Ville</label>
                                <p id="billing_city" type="text" name="billing_city"
                                    value="<?php echo $current_user_meta['billing_city'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_city'][0]; ?>">
                                    <?php echo $current_user_meta['billing_city'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_postcode">Code postal</label>
                                <p id="billing_postcode" type="text" name="billing_postcode"
                                    value="<?php echo $current_user_meta['billing_postcode'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_postcode'][0]; ?>">
                                    <?php echo $current_user_meta['billing_postcode'][0]; ?>
                                </p>
                            </div>
                            <div>
                                <label for="billing_country">Pays</label>
                                <p id="billing_country" type="text" name="billing_country"
                                    value="<?php echo $current_user_meta['billing_country'][0]; ?>"
                                    placeholder="<?php echo $current_user_meta['billing_country'][0]; ?>">
                                    <?php echo $current_user_meta['billing_country'][0]; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="gj-account-details-tab-content-save-button" id="address"
                        style="display: none;">
                        Sauvegarder les modifications
                    </button>
                </form>
            </div>
            <div class="gj-account-details-tab-content-section gj-privacy">
                <div class="gj-account-details-tab-content-section-header">
                    <div>
                        <h3>Confidentialité</h3>
                        <p>
                            Modifiez votre mot de passe
                        </p>
                    </div>
                    <button type="button" class="gj-account-details-tab-content-edit-button" id="privacy">
                        <img src="/wp-content/uploads/2024/01/SVG_edit-icon.svg" alt="">
                        Modifier
                    </button>
                </div>
                <p id="password-form-error-message"></p>
                <form class="gj-privacy-edit-form form-can-be-hidden form-hidden" id="privacy-form">
                    <div>
                        <label for="current_user_password_input">Mot de passe actuel</label>
                        <div class="password-input-container">
                            <input type="password" id="current_user_password_input" name="current_user_password"
                                placeholder="Mot de passe actuel"></input>
                            <button class="show-password-button" type="button" id="current_user_password">
                                <img src="/wp-content/uploads/2024/01/SVG_show-password-icon.svg" alt=""
                                    class="current_user_password_img">
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="new_user_password_input">Nouveau mot de passe</label>
                        <div class="password-input-container">
                            <input type="password" id="new_user_password_input" name="new_user_password"
                                placeholder="Nouveau mot de passe"></input>
                            <button class="show-password-button" type="button" id="new_user_password">
                                <img src="/wp-content/uploads/2024/01/SVG_show-password-icon.svg" alt=""
                                    class="new_user_password_img">
                            </button>
                        </div>
                        <p>8 caractères minimum, 1 caractère minuscule, 1 caractère majuscule, 1 chiffre</p>
                    </div>
                    <div>
                        <label for="new_user_password_2_input">Confirmer le nouveau mot de passe</label>
                        <div class="password-input-container">
                            <input type="password" id="new_user_password_2_input" name="new_user_password_2"
                                placeholder="Nouveau mot de passe"></input>
                            <button class="show-password-button" type="button" id="new_user_password_2">
                                <img src="/wp-content/uploads/2024/01/SVG_show-password-icon.svg" alt=""
                                    class="new_user_password_2_img">
                            </button>
                        </div>
                    </div>

                    <button type="button" class="gj-account-details-tab-content-save-button" id="privacy"
                        style="display: none;">
                        Sauvegarder les modifications
                    </button>

                    <button type="button" class="gj-account-details-tab-content-cancel-button" id="privacy"
                        style="display: none;">
                        Annuler
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>