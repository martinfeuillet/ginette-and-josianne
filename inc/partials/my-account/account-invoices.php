<?php
require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-dashboard.php');

$current_user_id = get_current_user_id();
$current_user_wishlist = get_user_meta($current_user_id, 'user_post_wishlist', true);

$count_user_wishlist_item = 0;
if (isset($current_user_wishlist['all_post']) && is_array($current_user_wishlist['all_post'])) {
    $count_user_wishlist_item = count($current_user_wishlist['all_post']);
}

$orders = get_order_count($current_user_id);

$orders_count = count($orders);

?>
<section class="gj-invoices-tab">
    <hr class="gj-invoices-tab-vertical-line right">
    <hr class="gj-invoices-tab-vertical-line left">
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
        Factures
    </p>
    <div class="gj-invoices-tab-content-main">
        <div class="gj-invoices-tab-content">
            <h3>Mes factures</h3>
            <div class="gj-invoices-tab-content-invoices">
                <?php 
                if ($orders_count > 0) :
                    foreach ($orders as $order_id) :
                        $order = wc_get_order($order_id);
                        if(!$order) {
                            continue;
                        }
                        
                        $order_total = $order->get_total();
                        $order_currency = get_woocommerce_currency_symbol($order->get_currency());
                        $order_date = $order->get_date_created()->format('d/m/Y'); 
                        $order_link = '/mon-compte/view-order/' . $order_id;
                    
                        $document = ywpi_get_order_document_by_type($order_id, 'invoice');
                        if ($document) {
                            $pdf_invoice = new YITH_WooCommerce_Pdf_Invoice();
                            if (!$document->generated()) {
                                $pdf_invoice = new YITH_WooCommerce_Pdf_Invoice();
                                $pdf_invoice->create_document($order_id, 'invoice');
                            }
                        
                            $download_invoice_link = $pdf_invoice->get_action_url('download', 'invoice', $order_id);
                        }                        
                        ?>

                <div class="gj-invoices-tab-content-invoice">
                    <div class="gj-invoices-tab-content-invoice-data">
                        <div class="gj-invoices-tab-content-invoice-details">
                            <div class="gj-invoices-tab-content-invoice-small-container">
                                <p class="gj-invoices-tab-content-invoice-header">ID NUMBERS</p>
                                <a href="<?php echo $order_link; ?>"><?php echo $order_id; ?></a>
                            </div>
                            <div class="gj-invoices-tab-content-invoice-small-container">
                                <p class="gj-invoices-tab-content-invoice-header">PRIX</p>
                                <p><?php echo $order_total . ' ' . $order_currency; ?></p>
                            </div>
                            <div class="gj-invoices-tab-content-invoice-large-container">
                                <p class="gj-invoices-tab-content-invoice-header">DATE DE TRANSACTION</p>
                                <p><?php echo $order_date; ?></p>
                            </div>
                        </div>
                        <div class="gj-invoices-tab-content-invoice-download">
                            <a href="/wp-content/uploads/ywpi-pdf-invoice/Invoices/Invoice_<?php echo $order_id; ?>.pdf"
                                class="gj-download-invoice-button" download>
                                Télécharger
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none">
                                    <path
                                        d="M3.415 13.5H12.585C12.9599 13.4987 13.319 13.3492 13.5841 13.0841C13.8492 12.819 13.9987 12.4599 14 12.085V11C14 10.8674 13.9473 10.7402 13.8536 10.6464C13.7598 10.5527 13.6326 10.5 13.5 10.5C13.3674 10.5 13.2402 10.5527 13.1464 10.6464C13.0527 10.7402 13 10.8674 13 11V12.085C13 12.1951 12.9563 12.3006 12.8784 12.3784C12.8006 12.4563 12.6951 12.5 12.585 12.5H3.415C3.30494 12.5 3.19938 12.4563 3.12155 12.3784C3.04372 12.3006 3 12.1951 3 12.085V11C3 10.8674 2.94732 10.7402 2.85355 10.6464C2.75979 10.5527 2.63261 10.5 2.5 10.5C2.36739 10.5 2.24021 10.5527 2.14645 10.6464C2.05268 10.7402 2 10.8674 2 11V12.085C2.00132 12.4599 2.15082 12.819 2.4159 13.0841C2.68098 13.3492 3.04012 13.4987 3.415 13.5Z"
                                        fill="black" />
                                    <path
                                        d="M8 2.5C7.8674 2.5 7.74022 2.55268 7.64645 2.64645C7.55268 2.74021 7.5 2.86739 7.5 3V9.53L4.79 7.595C4.73649 7.55692 4.676 7.52975 4.61199 7.51504C4.54797 7.50034 4.48169 7.49838 4.41692 7.50929C4.35215 7.5202 4.29016 7.54377 4.2345 7.57863C4.17884 7.6135 4.13059 7.65899 4.0925 7.7125C4.05442 7.76601 4.02725 7.8265 4.01254 7.89052C3.99784 7.95453 3.99589 8.02082 4.0068 8.08558C4.01771 8.15035 4.04127 8.21234 4.07614 8.268C4.111 8.32367 4.15649 8.37192 4.21 8.41L7.13 10.5C7.38453 10.682 7.6896 10.7799 8.0025 10.7799C8.31541 10.7799 8.62048 10.682 8.875 10.5L11.795 8.415C11.9031 8.33809 11.9762 8.22139 11.9982 8.09058C12.0202 7.95978 11.9894 7.82558 11.9125 7.7175C11.8356 7.60942 11.7189 7.53633 11.5881 7.51429C11.4573 7.49226 11.3231 7.52309 11.215 7.6L8.5 9.53V3C8.5 2.86739 8.44733 2.74021 8.35356 2.64645C8.25979 2.55268 8.13261 2.5 8 2.5Z"
                                        fill="black" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php
                    endforeach;
                else : ?>
                    <p>Désolé, vous n’avez pas encore de commandes effectuées.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</section>