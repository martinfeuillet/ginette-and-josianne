<?php
require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-dashboard.php');

$current_user_id = get_current_user_id();
$user_meta = get_user_meta($current_user_id);


$member = new YITH_WCMBS_Member( $current_user_id );
$is_member_active = $member->is_member();


$member_plans = new YITH_WCMBS_Member( get_current_user_id() );
$plans = $member->get_plans();

if ( !empty($plans) ) {
    $plan_id = $plans[0]->id;
    $date_timestamp = $plans[0]->end_date;
    $date_formatted = date_i18n( 'j F Y', $date_timestamp );
}

$orders = wc_get_orders(array('customer_id' => $current_user_id));
$total = 0;
$total_shipping = 0;

foreach ($orders as $order) {
    $total += $order->get_total();
    $total_shipping += $order->get_total_shipping();
}

$saved_total = ceil($total * 0.1);
$saved_shipping = ceil($total_shipping * 0.1);

?>

<section class="gj-subscriptions-tab">
    <hr class="gj-subscriptions-tab-vertical-line right">
    <hr class="gj-subscriptions-tab-vertical-line left">
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
        Abonnement
    </p>
    <div class="gj-subscriptions-tab-content-main">
        <div class="gj-subscriptions-tab-content">
            <?php if (!$is_member_active) : ?>
            <div class="gj-subscriptions-tab-content-section gj-no-subscription-content">
                <h3>Mon abonnement</h3>
                <div class="gj-subscriptions-tab-content-subscriptions">
                    <p>Désolé, vous n’avez pas encore d'abonnement.</p>
                    <a class="gj-subscriptions-no-subscription" href="/abonnement/">Je m'abonne dès maintenant !</a>
                </div>
            </div>
            <?php else : ?>
            <div class="gj-subscriptions-tab-content-section gj-subscription-about">
                <div>
                    <h3>Mon abonnement</h3>
                    <p class="gj-subscription-limit-desktop">Date d'expiration : <?php echo $date_formatted; ?></p>
                </div>
                <p>
                    Ici, retrouvez tout vos avantages, économies réalisées depuis le début de votre abonnement.
                </p>
                <div class="gj-subscription-limit-mobile">
                    <p>Date d'expiration : <?php echo $date_formatted; ?></p>
                </div>
            </div>
            <div class="gj-subscriptions-tab-content-section gj-saving-about">
                <h3>Mes économies</h3>
                <p>
                    Découvrez combien vous avez économiser depuis le début de votre abonnement
                </p>
                <div class="gj-saving-about-items">
                    <div class="gj-saving-about-item">
                        <div class="gj-saving-about-item-icon">
                            <img src="/wp-content/uploads/2023/12/SVG_bag-icon.svg" alt="">
                        </div>
                        <div class="gj-saving-about-item-details">
                            <p class="gj-saving-about-item-total">
                                <?php echo $saved_total; ?>€
                            </p>
                            <p>
                                sur mes commandes
                            </p>
                        </div>
                    </div>
                    <div class="gj-saving-about-item">
                        <div class="gj-saving-about-item-icon">
                            <img src="/wp-content/uploads/2023/12/SVG_package-icon.svg" alt="">
                        </div>
                        <div class="gj-saving-about-item-details">
                            <p class="gj-saving-about-item-total">
                                <?php echo $saved_shipping; ?>€
                            </p>
                            <p>
                                sur mes livraisons
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gj-subscriptions-tab-content-section gj-advantage-about">
                <h3>Mes avantages</h3>
                <p>
                    Grâce à votre abonnement vous bénéficiez désormais de plein d’avantages
                </p>
                <div class="gj-advantage-about-items">
                    <div class="gj-advantage-about-item shop-discount">
                        <p class="gj-advantage-about-item-header">
                            -30%
                        </p>
                        <p>
                            Sur toutes la boutique
                        </p>
                    </div>
                    <div class="gj-advantage-about-item content-advantage">
                        <p class="gj-advantage-about-item-header">
                            Accès PREMIUM
                        </p>
                        <p>
                            à tout nos contenus (Recettes, articles, vidéos)
                        </p>
                    </div>
                </div>
            </div>
            <div class="gj-subscriptions-tab-content-section gj-unsubscribe-section">
                <h3>Me désabonner</h3>
                <div class="gj-subscriptions-tab-content-unsubscribe">
                    <p>En vous désabonnant vous perdez dès maintenant tout vos avantages, réductions et accès à nos
                        contenus premium.</p>
                    <button class="gj-subscriptions-no-subscription" type="button">Je me désabonne</button>
                    <input type="hidden" id="membership_plan_id" name="membership_plan_id"
                        value="<?php echo $plan_id; ?>">
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>