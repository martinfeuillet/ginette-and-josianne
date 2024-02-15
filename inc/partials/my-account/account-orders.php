<?php
require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-dashboard.php');

$current_user_id = get_current_user_id();
$current_user_wishlist = get_user_meta($current_user_id, 'user_post_wishlist', true);



$count_user_wishlist_item = 0;
if (isset($current_user_wishlist['all_post']) && is_array($current_user_wishlist['all_post'])) {
    $count_user_wishlist_item = count($current_user_wishlist['all_post']);
}


$orders = get_order_count($current_user_id);
$order_count = count($orders);
?>

<section class="gj-orders-tab">
    <hr class="gj-orders-tab-vertical-line right">
    <hr class="gj-orders-tab-vertical-line left">
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
        Commandes
    </p>
    <div class="gj-orders-tab-content-main">
        <div class="gj-orders-tab-content">
            <h3>Mes commandes</h3>
            <div class="gj-orders-tab-content-orders">
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

                <div class="gj-orders-tab-content-order">
                    <div class="gj-orders-tab-content-order-data">
                        <div>
                            <p class="gj-orders-tab-content-order-header">ID NUMBERS</p>
                            <a href="<?php echo $order_link; ?>"><?php echo $order_id; ?></a>
                        </div>
                        <div class="gj-orders-tab-content-order-details">
                            <div class="gj-orders-tab-content-order-price">
                                <p class="gj-orders-tab-content-order-header">PRIX</p>
                                <p><?php echo $order_total . ' ' . $order_currency; ?></p>
                            </div>
                            <div class="gj-orders-tab-content-order-status">
                                <p class="gj-orders-tab-content-order-header">STATUS</p>
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
                else : ?>
                <p>Désolé, vous n’avez pas encore de commandes effectuées.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>