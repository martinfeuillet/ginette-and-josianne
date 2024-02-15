<?php

require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-dashboard.php');

$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
if ( $current_user->exists() ) {
    $user_name = get_user_meta($current_user_id, 'first_name', true);
    $user_avatar = get_avatar( $current_user->ID );
}

$current_user_wishlist = get_user_meta($current_user_id, 'user_post_wishlist', true);

$count_user_wishlist_item = 0;
if (isset($current_user_wishlist['all_post']) && is_array($current_user_wishlist['all_post'])) {
    $count_user_wishlist_item = count($current_user_wishlist['all_post']);
}


$orders = get_order_count($current_user_id);
$order_count = count($orders);

$member = new YITH_WCMBS_Member( $current_user_id );
$is_member_active = $member->is_member();

?>

<section class="gj-dashboard-tab">
    <hr class="gj-dashboard-tab-vertical-line right">
    <hr class="gj-dashboard-tab-vertical-line left">
    <div class="gj-dashboard-tab-header-user">
        <div class="gj-dashboard-tab-user-details">
            <h1>Mon Compte</h1>
            <?php echo $user_avatar; ?>
            <div>
                <p>
                    Hello <?php echo $user_name; ?>
                </p>
                <p class="gj-dashboard-tab-header-strong">
                    Bienvenue dans ton espace
                </p>
            </div>
        </div>
    </div>
    <div class="gj-dashboard-tab-content-main">
        <div class="gj-dashboard-tab-content content-1">
            <div class="gj-dashboard-tab-content-header">
                <div>
                    <h2>Accèdez à votre agenda en ligne</h2>
                    <p>Prenez rendez-vous en quelques clics grâce à notre calendrier en ligne</p>
                </div>
                <a href="#">Lien vers l'agenda</a>
            </div>
            <?php if ($is_member_active) { ?>
            <article class="gj-dashboard-bump">
                <div class="gj-dashboard-bump-inner-div">
                    <div class="gj-dashboard-bump-part left">
                        <h3>
                            Découvrir nos nouveautés
                        </h3>
                        <p>
                            Lorem ipsum dolor si amet.
                        </p>
                        <a href="/boutique/catalogue" class="gj-dashboard-tab-content-subscribe">Découvrir les
                            nouveautés !</a>
                    </div>
                    <aside class="gj-dashboard-bump-part right">
                        <img src="/wp-content/uploads/2023/11/Chill-tonic.jpg" alt="">
                    </aside>
                </div>
            </article>
            <?php } else { ?>
            <article class="gj-dashboard-bump">
                <div class="gj-dashboard-bump-inner-div">
                    <div class="gj-dashboard-bump-part left">
                        <h3>
                            Envie de bénéficier d'avantage et de faire des économies ?
                        </h3>
                        <p>
                            Abonne-toi et profites de 30% de réduction sur la boutique toute l'année et un tarif de
                            livraison unique
                        </p>
                        <a href="/abonnement/" class="gj-dashboard-tab-content-subscribe">Je m'abonne dès maintenant
                            !</a>
                    </div>
                    <aside class="gj-dashboard-bump-part right">
                        <img src="/wp-content/uploads/2023/09/boutique-section-2-2a-min.webp" alt="">
                    </aside>
                </div>
            </article>
            <?php } ?>
        </div>
        <div class="gj-dashboard-tab-content content-2">
            <div class="gj-dashboard-tab-content-div-1">
                <div class="gj-dashboard-tab-content-icon">
                    <img src="/wp-content/uploads/2023/12/SVG_bag-icon.svg" alt="">
                </div>
                <div class="gj-dashboard-tab-content-details">
                    <p class="gj-dashboard-tab-content-details-number"><?php echo $order_count; ?></p>
                    <p class="gj-dashboard-tab-content-details-type">commandes</p>
                    <a href="/mon-compte/orders/">Voir mes commandes ></a>
                </div>
            </div>
            <div class="gj-dashboard-tab-content-div-2">
                <div class="gj-dashboard-tab-content-icon">
                    <img src="/wp-content/uploads/2023/12/SVG_heart-icon.svg" alt="">
                </div>
                <div class="gj-dashboard-tab-content-details">
                    <p class="gj-dashboard-tab-content-details-number"><?php echo $count_user_wishlist_item; ?></p>
                    <p class="gj-dashboard-tab-content-details-type">articles wishlist</p>
                    <a href="/mon-compte/my-wishlist/">Voir ma wishlist ></a>
                </div>
            </div>
            <div class="gj-dashboard-tab-content-div-3">
                <div class="gj-dashboard-tab-content-icon">
                    <img src="/wp-content/uploads/2023/12/SVG_fidelity-card.svg" alt="">
                </div>
                <div class="gj-dashboard-tab-content-details">
                    <p class="gj-dashboard-tab-content-details-number"><?php
    $user_id = get_current_user_id();

    $total_points = get_user_meta( $user_id, '_ywpar_user_total_points', true );

    $total_points = !empty($total_points) ? $total_points : 0;

    echo $total_points;
?></p>
                    <a href="/mon-compte/fidelity/">Gagner des points ></a>
                </div>
            </div>
        </div>
        <div class="gj-dashboard-tab-content content-3">
            <h3>Mes commandes</h3>
            <div class="gj-dashboard-tab-content-orders">
                <?php 
                if ($order_count > 0) :
                    $counter = 0; 
                    foreach ($orders as $order_id) :
                        $order = wc_get_order($order_id);
                        $order_total = $order->get_total();
                        $order_currency = get_woocommerce_currency_symbol($order->get_currency());
                        $order_status = $order->get_status();
                        $order_link = '/mon-compte/view-order/' . $order_id;
                        ?>

                <div class="gj-dashboard-tab-content-order">
                    <div class="gj-dashboard-tab-content-order-data">
                        <div>
                            <p class="gj-dashboard-tab-content-order-header">ID NUMBERS</p>
                            <a href="<?php echo $order_link; ?>"><?php echo $order_id; ?></a>
                        </div>
                        <div class="gj-dashboard-tab-content-order-details">
                            <div class="gj-dashboard-tab-content-order-price">
                                <p class="gj-dashboard-tab-content-order-header">PRIX</p>
                                <p><?php echo $order_total . ' ' . $order_currency; ?></p>
                            </div>
                            <div class="gj-dashboard-tab-content-order-status">
                                <p class="gj-dashboard-tab-content-order-header">STATUS</p>
                                <p><?php echo translate_order_status($order_status); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                        $counter++;
                        if ($counter >= 3) {
                            break; 
                        }
                        ?>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>