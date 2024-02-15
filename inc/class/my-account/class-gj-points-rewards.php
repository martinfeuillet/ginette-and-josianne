<?php 

/* Points For subscription */

function award_points_for_product_purchase( $order_id ) {
    $product_id = 32596; 
    $points_to_award = 20;

    $order = wc_get_order( $order_id );

    foreach ( $order->get_items() as $item_id => $item ) {
        if ( $item->get_product_id() == $product_id ) {
            $user_id = $order->get_user_id();

            global $wpdb;
            $current_points = get_user_meta( $user_id, '_ywpar_user_total_points', true );
            $new_points = $current_points + $points_to_award;
            update_user_meta( $user_id, '_ywpar_user_total_points', $new_points );
            $wpdb->insert(
                $wpdb->prefix . 'yith_ywpar_points_log',
                array(
                    'user_id'      => $user_id,
                    'action'       => 'product_purchase',
                    'order_id'     => $order_id,
                    'amount'       => $points_to_award,
                    'date_earning' => current_time('mysql'),
                    'description'  => 'Abonnement'
                ),
                array('%d', '%s', '%d', '%d', '%s', '%s')
            );

            update_post_meta( $order_id, '_points_awarded', 'yes' );
        }
    }
}

add_action( 'woocommerce_order_status_completed', 'award_points_for_product_purchase', 10, 1 );

/* registeration anniversary */

if ( ! wp_next_scheduled( 'daily_user_anniversary_check' ) ) {
    wp_schedule_event( time(), 'daily', 'daily_user_anniversary_check' );
  }
  
  add_action( 'daily_user_anniversary_check', 'check_user_registration_anniversaries' );
  
function check_user_registration_anniversaries() {
    global $wpdb;

    $users = get_users(); 
    $current_date = current_time('Y-m-d'); 

    foreach ( $users as $user ) {
        $registration_date = date('Y-m-d', strtotime($user->user_registered)); 
        $anniversary_date = date('Y-m-d', strtotime('+1 year', strtotime($registration_date))); 

        if ( $current_date === $anniversary_date ) {
            $user_id = $user->ID;
            $points = 5;
            $action_name = 'registration_anniversary';

            $current_points = get_user_meta($user_id, '_ywpar_user_total_points', true);
            $new_points = $current_points + $points;
            update_user_meta($user_id, '_ywpar_user_total_points', $new_points);

            $wpdb->insert(
                $wpdb->prefix . 'yith_ywpar_points_log',
                array(
                    'user_id'      => $user_id,
                    'action'       => $action_name,
                    'order_id'     => 0,
                    'amount'       => $points,
                    'date_earning' => current_time('mysql'),
                    'description'  => 'Anniversaire d’inscription'
                ),
                array('%d', '%s', '%d', '%d', '%s', '%s')
            );
        }
    }
}




/*newsletter points*/

function on_newsletter_signup( $fields, $entry, $form_data ) {
    if ( $form_data['id'] != 36434 ) {
        return;
    }

    $user_email = $fields[2]['value']; 
    $user = get_user_by( 'email', $user_email );

    if ( !$user ) {
        return;
    }

    $user_id = $user->ID;
    global $wpdb;
    $points = 5;
    $current_time = current_time('mysql');
    $action_name = 'newsletter_signup';

    $has_signed_up = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}yith_ywpar_points_log WHERE user_id = %d AND action = %s",
        $user_id,
        $action_name
    ));
    
    if ( $has_signed_up > 0 ) {
        return;
    }
    
    $current_points = get_user_meta($user_id, '_ywpar_user_total_points', true);
    $new_points = $current_points + $points;
    update_user_meta($user_id, '_ywpar_user_total_points', $new_points);

    $wpdb->insert(
        $wpdb->prefix . 'yith_ywpar_points_log',
        array(
            'user_id'      => $user_id,
            'action'       => $action_name,
            'order_id'     => 0,
            'amount'       => $points,
            'date_earning' => $current_time,
            'description'  => 'Newsletter'
        ),
        array('%d', '%s', '%d', '%d', '%s', '%s')
    );

}

add_action( 'wpforms_process_complete', 'on_newsletter_signup', 10, 3 );


/* instagram points*/


function increase_user_points_and_log() {
    if (is_user_logged_in()) {
        global $wpdb;
        $user_id = get_current_user_id();
        $points = 5;
        $current_time = current_time('mysql');
        $action_name = 'instagram';

        $has_gained_points = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}yith_ywpar_points_log WHERE user_id = %d AND action = %s",
            $user_id,
            $action_name
        ));

        if ($has_gained_points > 0) {
            echo 'Vous avez déjà gagné des points pour cette action.';
        } else {
            $current_points = get_user_meta($user_id, '_ywpar_user_total_points', true);
            $new_points = $current_points + $points;
            update_user_meta($user_id, '_ywpar_user_total_points', $new_points);
            $wpdb->insert(
                $wpdb->prefix . 'yith_ywpar_points_log',
                array(
                    'user_id'      => $user_id,
                    'action'       => $action_name,
                    'order_id'     => 0,
                    'amount'       => $points,
                    'date_earning' => $current_time,
                    'description'  => 'Instagram'
                ),
                array('%d', '%s', '%d', '%d', '%s', '%s')
            );
            
            echo 'Points mis à jour et enregistrés';
        }
    } else {
        echo 'Utilisateur non connecté';
    }
    wp_die(); 
}
add_action('wp_ajax_increase_points_and_log', 'increase_user_points_and_log');


