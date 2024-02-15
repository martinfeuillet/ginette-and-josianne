<?php
/**
 * Enqueue styles and scripts for the subscriptions page.
 */
function gj_subscriptions_enqueue_styles() {
    if (is_account_page()) {
        wp_enqueue_style('gj-subscriptions-style', get_stylesheet_directory_uri() . '/assets/css/gj-subscriptions.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-subscriptions.css'));
        wp_enqueue_script('gj-subscriptions-script', get_stylesheet_directory_uri() . '/assets/js/gj-subscriptions.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/gj-subscriptions.js'), true);
        wp_localize_script('gj-subscriptions-script', 'wp_ajax', array('ajax_url' => admin_url('admin-ajax.php')));    
    }
}
add_action('wp_enqueue_scripts', 'gj_subscriptions_enqueue_styles');

/**
 * Include the account subscriptions partial.
 */
function subscriptions_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-subscriptions.php';
}
add_shortcode('subscriptions_content', 'subscriptions_content_shortcode');

/**
 * Handle the cancellation of a user membership.
 */

function gj_cancel_user_membership() {
    $user_id = get_current_user_id();

    if ($user_id) {
        $member = new YITH_WCMBS_Member( $user_id );
        $plans = $member->get_plans();
        
        if ( !empty($plans) ) {
            $plans[0]->update_status('cancelled');
            $plan_status = $plans[0]->status;
            wp_send_json_success($plan_status);
        }
    } else {
        wp_send_json_error('Aucun plan ou utilisateur trouvé.');
    }

    wp_die();
}
add_action('wp_ajax_gj_cancel_user_membership', 'gj_cancel_user_membership');
add_action('wp_ajax_nopriv_gj_cancel_user_membership', 'gj_cancel_user_membership'); 