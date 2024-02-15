<?php

?>
<style>
    div.woocommerce-MyAccount-content > p {
        display: none !important;
    }
</style>
<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="gj-view-order-content">
    <hr class="gj-view-order-vertical-line right">
    <hr class="gj-view-order-vertical-line left">
    <a href="/mon-compte/orders/" class="gj-my-account-breadcrumb-trail-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 8 8" fill="none">
            <g clip-path="url(#clip0_1086_2536)">
                <path d="M1.7207 4.00008C1.7207 4.1434 1.77543 4.28676 1.88464 4.39607L5.32454 7.83589C5.54336 8.05471 5.89814 8.05471 6.11686 7.83589C6.33559 7.61716 6.33559 7.26245 6.11686 7.04362L3.07309 4.00008L6.11665 0.956408C6.33538 0.737679 6.33538 0.382923 6.11665 0.164211C5.89792 -0.0547125 5.54326 -0.0547126 5.32444 0.164211L1.88451 3.60398C1.77532 3.71334 1.7207 3.8567 1.7207 4.00008Z" fill="black" fill-opacity="0.8"/>
            </g>
            <defs>
                <clipPath id="clip0_1086_2536">
                <rect width="8" height="8" fill="white" transform="matrix(1 1.74846e-07 1.74846e-07 -1 0 8)"/>
                </clipPath>
            </defs>
        </svg> 
        Mes Commandes
    </a>
    <section class="woocommerce-order-details">
        <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

        <h2 class="woocommerce-order-details__title">Détails de la commande #<?php echo $order_id ?></h2>

        <section class="gj-view-order-content-table">
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    do_action( 'woocommerce_order_details_before_order_table_items', $order );

                    foreach ( $order_items as $item_id => $item ) {
                        $product = $item->get_product();

                        wc_get_template(
                            'order/order-details-item.php',
                            array(
                                'order'              => $order,
                                'item_id'            => $item_id,
                                'item'               => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                'product'            => $product,
                            )
                        );
                    }

                    do_action( 'woocommerce_order_details_after_order_table_items', $order );
                    ?>
                </tbody>

                <tfoot>
                    <!-- Sous-total -->
                    <tr>
                        <th><?php esc_html_e( 'Subtotal:', 'woocommerce' ); ?></th>
                        <td><?php echo wp_kses_post( $order->get_subtotal_to_display() ); ?></td>
                    </tr>

                    <!-- Remise -->
                    <?php if ( $order->get_total_discount() > 0 ) : ?>
                        <tr>
                            <th><?php esc_html_e( 'Discount:', 'woocommerce' ); ?></th>
                            <td>-<?php echo wp_kses_post( wc_price( $order->get_total_discount() ) ); ?></td>
                        </tr>
                    <?php endif; ?>

                    <!-- Mode d'expédition -->
                    <?php foreach ( $order->get_shipping_methods() as $shipping_method ) : ?>
                        <tr>
                            <th><?php esc_html_e( 'Shipping:', 'woocommerce' ); ?></th>
                            <td><?php echo wp_kses_post( $shipping_method->get_total() ); echo get_woocommerce_currency_symbol($order->get_currency()) ?> via <?php echo wp_kses_post( $shipping_method->get_name() ); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Total -->
                    <tr>
                        <th><?php esc_html_e( 'Total:', 'woocommerce' ); ?></th>
                        <td><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                    </tr>
                    
                    <?php if ( $order->get_customer_note() ) : ?>
                        <tr>
                            <th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
                            <td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
                        </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
        </section>

        <?php //  do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
    </section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
// do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
?>
</section>
