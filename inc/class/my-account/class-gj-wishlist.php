<?php
/**
 * Enqueue styles and scripts for the wishlist feature.
 */
function gj_wishlist_enqueue_styles() {
    wp_enqueue_style('gj-wishlist-style', get_stylesheet_directory_uri() . '/assets/css/gj-wishlist.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/gj-wishlist.css'));
    wp_enqueue_script('gj-wishlist-script', get_stylesheet_directory_uri() . '/assets/js/gj-wishlist.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/gj-wishlist.js'), true);
    wp_localize_script('gj-wishlist-script', 'wp_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'gj_wishlist_enqueue_styles');

/**
 * Shortcode for displaying wishlist content.
 */
function wishlist_content_shortcode() {
    include_once get_stylesheet_directory() . '/inc/partials/my-account/account-wishlist.php';
}
add_shortcode('wishlist_content', 'wishlist_content_shortcode');

/**
 * Shortcode for displaying the add to wishlist button.
 *
 * @return string HTML markup for the add to wishlist button.
 */
function add_wishlist_button() {
    global $post;
    $user_id = get_current_user_id();
    $wishlist = get_user_meta($user_id, 'user_post_wishlist', true);
    if ($wishlist) {
        $in_wishlist = array_key_exists($post->ID, $wishlist['all_post']);
    } else {
        add_user_meta($user_id, 'user_post_wishlist', array());
        $in_wishlist = array();
    }
    $add_to_wishlist_img_url = '/wp-content/uploads/2023/11/heart-regular.svg';
    $see_wishlist_img_url = '/wp-content/uploads/2023/12/heart-solid-1.svg';
    if ($in_wishlist) {
        $wishlist_url = site_url('/mon-compte/my-wishlist/');
        return '<a class="gj-post-in-wishlist" data-post-id="' . $post->ID . '" href="'. $wishlist_url .'">
        <img src="' . $see_wishlist_img_url . '" alt="Voir la wishlist" title="Voir la liste de souhait">
        </a>';
    } else {
        return '<a class="gj-add-to-wishlist" data-post-id="' . $post->ID . '">
        <img src="' . $add_to_wishlist_img_url . '" alt="Ajouter à la wishlist">
        </a>';
    }
    
}
add_shortcode('add_wishlist_button', 'add_wishlist_button');

/**
 * Call the wishlist button.
 */
function call_wishlist_button() {
    global $post;
    $user_id = get_current_user_id();
    $wishlist = get_user_meta($user_id, 'user_post_wishlist', true);
    if ($wishlist) {
        $in_wishlist = array_key_exists($post->ID, $wishlist['all_post']);
    } else {
        add_user_meta($user_id, 'user_post_wishlist', array());
        $in_wishlist = array();
    }
    $add_to_wishlist_img_url = '/wp-content/uploads/2023/11/heart-regular.svg';
    $see_wishlist_img_url = '/wp-content/uploads/2023/12/heart-solid-1.svg';
    if ($in_wishlist) {
        $wishlist_url = site_url('/mon-compte/my-wishlist/');
        echo '<a class="gj-post-in-wishlist" data-post-id="' . $post->ID . '" href="'. $wishlist_url .'">
                <img src="' . $see_wishlist_img_url . '" alt="Voir la wishlist" title="Voir la liste de souhait">
            </a>';
    } else {
        echo '<a class="gj-add-to-wishlist" data-post-id="' . $post->ID . '">
                <img src="' . $add_to_wishlist_img_url . '" alt="Ajouter à la wishlist">
            </a>';
    }
}

/**
 * AJAX handler for adding a post to the wishlist.
 */
function add_post_to_wishlist() {

    if (!is_user_logged_in()) {
        wp_send_json_error(array('redirect_url' => '/mon-compte'));
        return;
    }
    $user_id = get_current_user_id();
    $post_id = $_POST['post_id'];


    $wishlist = get_user_meta($user_id, 'user_post_wishlist', true);
    if (!$wishlist) {
        $wishlist = array();
    }


    $post_type = get_post_type($post_id);

    if (!array_key_exists('all_post', $wishlist)) {
        $wishlist['all_post'] = array();
    }


    if (!array_key_exists($post_type, $wishlist)) {
        $wishlist[$post_type] = array();
    }


    $timestamp = current_time('mysql');
    if (!array_key_exists($post_id, $wishlist['all_post'])) {
        $wishlist['all_post'][$post_id] = $timestamp;
    } else {
        unset($wishlist['all_post'][$post_id]);
    }

    if (!array_key_exists($post_id, $wishlist[$post_type])) {
        $wishlist[$post_type][$post_id] = $timestamp;
    } else {
        unset($wishlist[$post_type][$post_id]);
    }


    update_user_meta($user_id, 'user_post_wishlist', $wishlist);
    wp_send_json_success();
}
add_action('wp_ajax_add_post_to_wishlist', 'add_post_to_wishlist');
add_action('wp_ajax_nopriv_add_post_to_wishlist', 'add_post_to_wishlist');

/**
 * AJAX handler for deleting a post from the wishlist.
 */
function delete_post_from_wishlist() {

    if (!is_user_logged_in()) {
        wp_send_json_error(array('redirect_url' => wp_login_url()));
        return;
    }
    $user_id = get_current_user_id();
    $post_id = $_POST['post_id'];


    $wishlist = get_user_meta($user_id, 'user_post_wishlist', true);
    if (!$wishlist) {
        wp_send_json_error(array('message' => 'Wishlist vide'));
        return;
    }


    $post_type = get_post_type($post_id);


    if (isset($wishlist['all_post'][$post_id])) {
        unset($wishlist['all_post'][$post_id]);
    }
    if (isset($wishlist[$post_type][$post_id])) {
        unset($wishlist[$post_type][$post_id]);
    }

    if (isset($wishlist[$post_type]) && empty($wishlist[$post_type])) {
        unset($wishlist[$post_type]);
    }

    update_user_meta($user_id, 'user_post_wishlist', $wishlist);

    wp_send_json_success(array('message' => 'Post supprimé de la wishlist'));
}
add_action('wp_ajax_delete_post_from_wishlist', 'delete_post_from_wishlist');
add_action('wp_ajax_nopriv_delete_post_from_wishlist', 'delete_post_from_wishlist');

/**
 * AJAX handler for loading filtered wishlist posts.
 */
function load_filtered_wishlist_posts_ajax_handler() {
    $user_id = get_current_user_id();
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 'all_post';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 12;

    $user_wishlist = get_user_meta($user_id, 'user_post_wishlist', true);
    $post_ids = !empty($user_wishlist[$filter]) ? $user_wishlist[$filter] : [];

    arsort($post_ids);

    $total_posts = count($post_ids);
    $total_pages = ceil($total_posts / $posts_per_page);
    $offset = ($paged - 1) * $posts_per_page;
    $paged_post_ids = array_slice(array_keys($post_ids), $offset, $posts_per_page);

    $post_data = array();
    foreach ($paged_post_ids as $post_id) {
        $post_type = get_post_type($post_id);
        if ($post_type == 'product') {
            $product = wc_get_product($post_id);
            $raw_price = $product->get_price();
            $formatted_price = wc_format_decimal($raw_price, wc_get_price_decimals());

            if ($product) {
                $post_data[] = array(
                    'type' => 'product',
                    'id' => $product->get_id(),
                    'name' => $product->get_name(),
                    'permalink' => get_permalink($product->get_id()),
                    'thumbnail' => get_the_post_thumbnail_url($product->get_id()),
                    'price' => $formatted_price,
                
                    'excerpt' => get_the_excerpt($product->get_id()),
                    'add_to_cart_url' => $product->add_to_cart_url(),
                    'add_to_cart_text' => $product->single_add_to_cart_text(),
                );
            }
        } elseif ($post_type == 'recettes') {
            $post = get_post($post_id);
            $post_meta = get_post_meta($post_id, 'categorie', true);
        
            $post_data[] = array(
                'type' => 'recette',
                'id' => $post_id,
                'permalink' => get_permalink($post_id),
                'thumbnail' => get_the_post_thumbnail_url($post_id),
                'title' => get_the_title($post_id),
                'excerpt' => get_the_excerpt($post_id),
                'categories' => $post_meta
            );
        }

    }
    // delete_user_meta($user_id, 'user_post_wishlist');
    wp_send_json_success(['posts' => $post_data, 'max_pages' => $total_pages, 'current_page' => $paged]);
}
add_action('wp_ajax_load_filtered_wishlist_posts', 'load_filtered_wishlist_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_filtered_wishlist_posts', 'load_filtered_wishlist_posts_ajax_handler');