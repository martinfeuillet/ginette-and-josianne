<?php 
/**
 * Enqueue styles for the invoices page.
 */
function gj_invoices_enqueue_styles() {
    if (is_account_page()) {
        wp_enqueue_style('gj-invoices-style', get_stylesheet_directory_uri() . '/assets/css/gj-invoices.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-invoices.css'));
    }
}
add_action('wp_enqueue_scripts', 'gj_invoices_enqueue_styles');

/**
 * Include the account invoices partial.
 */
function invoices_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-invoices.php';
}
add_shortcode('invoices_content', 'invoices_content_shortcode');