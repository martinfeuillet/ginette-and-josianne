<?php 
/**
 * Enqueue styles for the dashboard page.
 */
function gj_dashboard_enqueue_styles() {
    if (is_account_page()) {
        wp_enqueue_style('gj-dashboard-style', get_stylesheet_directory_uri() . '/assets/css/gj-dashboard.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-dashboard.css'));
    }
}
add_action('wp_enqueue_scripts', 'gj_dashboard_enqueue_styles');

/**
 * Include the account dashboard partial.
 */
function dashboard_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-dashboard.php';
}
add_shortcode('dashboard_content', 'dashboard_content_shortcode');

/**
 * Include the account header partial.
 */
function my_custom_header_content() {
    if (is_account_page()) {
        include_once get_stylesheet_directory() . '/inc/partials/my-account/account-header.php';
    }
}
add_action('wp_head', 'my_custom_header_content');

/**
 * Get the count of orders for a user.
 *
 * @param int $user_id The ID of the user.
 * @return array The IDs of the orders.
 */
function get_order_count($user_id) {
    $args = array(
        'customer' => $user_id,
        'limit'    => -1,
        'return'   => 'ids',
    );

    $query = new WC_Order_Query($args);
    $orders = $query->get_orders();

    return $orders;
}

/**
 * Translate order status to French.
 *
 * @param string $status The status of the order.
 * @return string The translated status.
 */
function translate_order_status($status) {
    $statuses = array(
        'pending'    => 'En attente',
        'processing' => 'En cours de traitement',
        'on-hold'    => 'En attente',
        'completed'  => 'Expédiée',
        'cancelled'  => 'Annulée',
        'refunded'   => 'Remboursée',
        'failed'     => 'Échouée'
    );

    return isset($statuses[$status]) ? $statuses[$status] : $status;
}