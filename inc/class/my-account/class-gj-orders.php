<?php 
/**
 * Enqueue styles for the orders page.
 */
function gj_orders_enqueue_styles() {
    if (is_account_page()) {
        wp_enqueue_style('gj-orders-style', get_stylesheet_directory_uri() . '/assets/css/gj-orders.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-orders.css'));        
    }
}
add_action('wp_enqueue_scripts', 'gj_orders_enqueue_styles');

/**
 * Include the account orders partial.
 */
function orders_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-orders.php';
}
add_shortcode('orders_content', 'orders_content_shortcode');