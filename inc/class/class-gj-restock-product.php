<?php
add_filter( 'woocommerce_single_product_carousel_options', 'ginette_update_woo_flexslider_options' );

/**
 * Add a class to the restock popin if the product is out of stock.
 */
function add_restock_popin_class() {
    if ( is_product() ) {
        global $product;

        if ( $product->get_stock_quantity() === 0 || $product->get_stock_status() === 'outofstock' ) {
            ?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const body = document.querySelector('body');
    const popin = document.querySelector('div.uagb-block-bd6454cc');

    if (popin) {
        popin.classList.add('restock-popin-active');
        body.classList.add('restock-popin-active');
    }
});
</script>
<?php
        }
    }
}
add_action( 'wp_footer', 'add_restock_popin_class' );

/**
 * Update the restock list.
 */
function update_restock_list() {
    $product_slug = sanitize_text_field($_POST['product_slug']);
    $email = sanitize_email($_POST['email']);

    $product_post = get_page_by_path($product_slug, OBJECT, 'product');

    if ($product_post && !empty($email)) {
        $product_id = $product_post->ID;
        $product_url = get_permalink($product_id);
        $product_name = $product_post->post_title;
        $product_thumbnail = get_the_post_thumbnail_url($product_id);

    

        $restock_list = get_post_meta($product_id, 'restock_contact_list', true);
        $restock_list = $restock_list ? explode(',', $restock_list) : [];

        if (!in_array($email, $restock_list)) {
            $restock_list[] = $email;
            update_post_meta($product_id, 'restock_contact_list', implode(',', $restock_list));

        

            include_once get_stylesheet_directory() . '/inc/partials/emails/gj-product-out-of-stock.php';
            $user_info = array(
                'from' => 'Ginette Et Josianne <noreply@ginetteetjosianne.com>',
                'to' => $email,
            
                'subject' => 'En attendant le réapprovisionnement de votre produit',
                'message' => send_out_of_stock_email($product_url, $product_name, $product_thumbnail)
            );

            $headers = 'From:' . $user_info['from'] . "\r\n";
            $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

            wp_mail($user_info['to'], $user_info['subject'], $user_info['message'], $headers);
        
        }

        wp_send_json_success(['message' => 'Email ajouté avec succès']);
    
    } else {
        wp_send_json_error(['message' => 'Produit introuvable ou email manquant']);
    }

    wp_die();
}
add_action('wp_ajax_update_restock_list', 'update_restock_list');
add_action('wp_ajax_nopriv_update_restock_list', 'update_restock_list');

/**
 * Check if a product is back in stock and send emails to users who were waiting for it.
 *
 * @param int $product_id The ID of the product.
 * @param WC_Product $product The product object.
 */
function gj_check_and_send_stock_update_emails($product_id, $product) {
    if ($product->is_in_stock()) {
        $restock_list = get_post_meta($product_id, 'restock_contact_list', true);
        if (!empty($restock_list)) {
            $restock_emails = explode(',', $restock_list);

            $product_url = get_permalink($product_id);
            $product_name = get_the_title($product_id);
            $product_thumbnail = get_the_post_thumbnail_url($product_id);

            foreach ($restock_emails as $email) {
            

                include_once get_stylesheet_directory() . '/inc/partials/emails/gj-product-back-in-stock.php';
                $user_info = array(
                    'from' => 'Ginette Et Josianne <noreply@ginetteetjosianne.com>',
                    'to' => $email,
                
                    'subject' => 'Votre produit est de retour',
                    'message' => send_back_in_stock_email($product_name, $product_url, $product_thumbnail)
                );
    
                $headers = 'From:' . $user_info['from'] . "\r\n";
                $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    
                wp_mail($user_info['to'], $user_info['subject'], $user_info['message'], $headers);
            }

            delete_post_meta($product_id, 'restock_contact_list');
        }
    }
}
add_action('woocommerce_update_product', 'gj_check_and_send_stock_update_emails', 10, 2);