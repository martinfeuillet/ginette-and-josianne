<?php
/**
 * Enqueue styles and scripts for the account details page.
 */
function gj_account_details_enqueue_styles() {
    if (is_account_page()) {
        wp_enqueue_style('gj-account-details-style', get_stylesheet_directory_uri() . '/assets/css/gj-account-details.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-account-details.css'));
        wp_enqueue_script('gj-account-details-script', get_stylesheet_directory_uri() . '/assets/js/gj-account-details.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/gj-account-details.js'), true);
        wp_localize_script('gj-account-details-script', 'wp_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'gj_account_details_enqueue_styles');

/**
 * Include the account details content partial.
 */
function account_details_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-details.php';
}
add_shortcode('account_details_content', 'account_details_content_shortcode');

/**
 * Update user meta data.
 */
function gj_update_user_meta() {
    $formData = $_POST['formData'];
    
    $user_id = get_current_user_id();
    
    
    $moyens_de_paiement = get_user_meta($user_id, 'moyens-de-paiement', true);
    if (!$moyens_de_paiement) {
        $moyens_de_paiement = array();
    }
    
    
    $birth_date_components = [];
    $card_expiry_date_components = [];
    
    foreach ($formData as $key => $value) {
        
        if (in_array($key, ['birth_day', 'birth_month', 'birth_year'])) {
            
            $birth_date_components[$key] = sanitize_text_field($value);
        } elseif (in_array($key, ['card_expiry_month', 'card_expiry_year'])) {
            
            $card_expiry_date_components[$key] = sanitize_text_field($value);
        } elseif (in_array($key, ['card_holder_name', 'card_number'])) {
            
            $moyens_de_paiement[0][$key] = sanitize_text_field($value);
        } else {
            
            update_user_meta($user_id, $key, sanitize_text_field($value));
        }
    }
    
    
    if (isset($birth_date_components['birth_day'], $birth_date_components['birth_month'], $birth_date_components['birth_year'])) {
        $formatted_birth_date = $birth_date_components['birth_day'] . '/' . $birth_date_components['birth_month'] . '/' . $birth_date_components['birth_year'];
        update_user_meta($user_id, 'birth_date', $formatted_birth_date);
    }
    
    if (isset($card_expiry_date_components['card_expiry_month'], $card_expiry_date_components['card_expiry_year'])) {
        $formatted_card_expiry_date = $card_expiry_date_components['card_expiry_month'] . '/' . $card_expiry_date_components['card_expiry_year'];
        $moyens_de_paiement[0]['card_expiry'] = sanitize_text_field($formatted_card_expiry_date);
    }
    
    
    if (!empty($moyens_de_paiement)) {
        update_user_meta($user_id, 'moyens-de-paiement', $moyens_de_paiement);
    }
    
    wp_send_json_success();
    wp_die();
}
add_action('wp_ajax_gj_update_user_meta', 'gj_update_user_meta');
add_action('wp_ajax_nopriv_gj_update_user_meta', 'gj_update_user_meta');


/**
 * Update user password.
 */
function gj_update_user_password() {

    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté pour effectuer cette action.');
        wp_die();
    }


    $user = wp_get_current_user();
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];


    if (!wp_check_password($current_password, $user->data->user_pass, $user->ID)) {
        wp_send_json_error('Le mot de passe actuel est incorrect.');
        wp_die();
    }


    wp_set_password($new_password, $user->ID);

    wp_send_json_success();
    wp_die();
}
add_action('wp_ajax_gj_update_user_password', 'gj_update_user_password');
add_action('wp_ajax_nopriv_gj_update_user_password', 'gj_update_user_password');

/**
 * Check if a value is not empty.
 *
 * @param mixed $value The value to check.
 * @return bool True if the value is not empty, false otherwise.
 */
function is_not_empty($value) {
    if ($value !== '' && $value !== null ){
        return true;
    } else {
        return false;
    }
}

/**
 * ajax call to disconnect the user when he clicks on the logout button
 */

//  add_action('wp_ajax_gj_logout_user', 'gj_logout_user');
// function gj_logout_user() {
//     wp_logout();
//     wp_send_json_success(array(
//         'redirect_url' => home_url()
//     ));
//     wp_die();
// }