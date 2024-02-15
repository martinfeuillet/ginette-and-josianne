<?php

// require shortcode.php
require_once('inc/ginette-shortcode.php');

require_once 'cure-and-care/cure-and-care.php';

require_once('inc/class/class-gj-restock-product.php');

require_once('inc/class/my-account/class-gj-wishlist.php');

require_once('inc/class/my-account/class-gj-dashboard.php');

require_once('inc/class/my-account/class-gj-orders.php');

require_once('inc/class/my-account/class-gj-invoices.php');

require_once('inc/class/my-account/class-gj-subscriptions.php');

require_once('inc/class/my-account/class-gj-account-details.php');

require_once('inc/class/my-account/class-gj-points-rewards.php');


/* Add Fidelity endpoint*/
function add_fidelity_endpoint()
{
    add_rewrite_endpoint('fidelity', EP_ROOT | EP_PAGES);
}

add_action('init', 'add_fidelity_endpoint');
function fidelity_query_vars($vars)
{
    $vars[] = 'fidelity';
    return $vars;
}

add_filter('query_vars', 'fidelity_query_vars', 0);

function add_fidelity_link_my_account($items)
{
    $items['fidelity'] = 'Fidélité';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'add_fidelity_link_my_account');

function fidelity_content()
{
    include('fidelity.php');
}


add_action('woocommerce_account_fidelity_endpoint', 'fidelity_content');
function change_fidelity_page_title($title)
{
    if (is_wc_endpoint_url('fidelity')) {
        $title = 'Fidelity Program';
    }
    return $title;
}

add_filter('woocommerce_account_fidelity_title', 'change_fidelity_page_title');



function custom_deregister_scripts_and_styles()
{
    wp_deregister_style('ywsl_frontend');
    wp_deregister_style('ywpar_frontend');

    if (is_checkout()) {
        wp_deregister_script('ywpar_frontend');
    }
}
add_action('wp_enqueue_scripts', 'custom_deregister_scripts_and_styles', 100);



/**
 ** activation theme
 **/
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    global $post;

    // Global style
    wp_enqueue_style('child-style', get_stylesheet_uri());
    wp_enqueue_style('gj-global', get_stylesheet_directory_uri() . '/assets/css/global.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/global.css'));

    // Global script
    wp_enqueue_script('ginette-global-js', get_stylesheet_directory_uri() . '/assets/js/global.js', array('jquery'), rand(), true);
    wp_enqueue_script('ginette-rating-js', get_stylesheet_directory_uri() . '/assets/js/rating.js', array('jquery'), rand(), true);




    // CONDITION PER PAGES
    if (is_front_page()) {
        wp_enqueue_style('gj-home-style', get_stylesheet_directory_uri() . '/assets/css/home.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/home.css'));
        wp_enqueue_script('slick-js', "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", array(), false, false);
        wp_enqueue_script('gj-service-slick-call-script', get_stylesheet_directory_uri() . '/assets/js/service-slick-call.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/service-slick-call.js'), true);
    }

    if (is_checkout()) {
        // Désenregistrer la feuille de style globale
        wp_dequeue_style('gj-global', get_stylesheet_directory_uri() . '/assets/css/global.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/global.css'));
    }

    // ARCHIVES
    if (is_shop()) {
        wp_enqueue_style('gj-shop-style', get_stylesheet_directory_uri() . '/assets/css/shop.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/shop.css'));
        wp_enqueue_script('slick-js', "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", array(), false, false);
        wp_enqueue_script('gj-service-slick-call-auto-script', get_stylesheet_directory_uri() . '/assets/js/service-slick-call-auto.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/service-slick-call-auto.js'), true);
    }

    if (is_product_category()) {
        wp_enqueue_style('gj-product-category-style', get_stylesheet_directory_uri() . '/assets/css/product-category.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/product-category.css'));
    }

    // If parent is shop
    if ($post->post_parent == '16') {
        wp_enqueue_style('gj-catalogue-style', get_stylesheet_directory_uri() . '/assets/css/catalogue.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/catalogue.css'));
    }

    // Blog
    if (is_home()) {
        wp_enqueue_style('gj-blog-style', get_stylesheet_directory_uri() . '/assets/css/blog.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/blog.css'));
        wp_enqueue_script('gj-blog-script', get_stylesheet_directory_uri() . '/assets/js/blog.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/blog.js'), true);
    }

    // Blog article
    if (get_post_type() == 'post' && !is_home()) {
        wp_enqueue_style('gj-article-style', get_stylesheet_directory_uri() . '/assets/css/article.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/article.css'));
    }

    if (is_product()) {
        wp_enqueue_style('gj-product-style', get_stylesheet_directory_uri() . '/assets/css/product.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/product.css'));
        wp_enqueue_style('gj-restock-popin-style', get_stylesheet_directory_uri() . '/assets/css/restock-popin.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/restock-popin.css'));
        wp_enqueue_script('gj-product-script', get_stylesheet_directory_uri() . '/assets/js/product.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/product.js'), true);
        wp_enqueue_script('gj-restock-popin-script', get_stylesheet_directory_uri() . '/assets/js/restock-popin.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/restock-popin.js'), true);
        wp_enqueue_script('gj-restock-popin-ajax-script', get_stylesheet_directory_uri() . '/assets/js/restock-popin-ajax.js', array('jquery'), filemtime(get_stylesheet_directory_uri() . '/assets/css/restock-popin-ajax.js'), true);
        wp_localize_script('gj-restock-popin-ajax-script', 'wp_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    if (is_singular('recettes')) {
        wp_enqueue_style('gj-recette-unique-style', get_stylesheet_directory_uri() . '/assets/css/recette-unique.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/recette-unique.css'));
        wp_enqueue_script('gj-recette-script', get_stylesheet_directory_uri() . '/assets/js/recette.js', array('jquery'), filemtime(get_stylesheet_directory_uri() . '/assets/css/recette.js'), true);
        wp_enqueue_script('gj-service-slick-call-auto-script', get_stylesheet_directory_uri() . '/assets/js/service-slick-call-auto.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/service-slick-call-auto.js'), true);
    }

    if (is_singular('specialistes')) {
        wp_enqueue_style('gj-specialiste-unique-style', get_stylesheet_directory_uri() . '/assets/css/specialiste-unique.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/specialiste-unique.css'));
    }

    // PAGES
    if (is_page('recettes')) {
        wp_enqueue_style('gj-recettes-style', get_stylesheet_directory_uri() . '/assets/css/recettes.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/recettes.css'));
        wp_enqueue_script('gj-service-slick-call-auto-script', get_stylesheet_directory_uri() . '/assets/js/service-slick-call-auto.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/service-slick-call-auto.js'), true);
    }

    if (is_page('trouver-un-specialiste')) {
        wp_enqueue_style('gj-trouver-specialiste-style', get_stylesheet_directory_uri() . '/assets/css/trouver-specialiste.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/trouver-specialiste.css'));
    }

    if (is_page('tous-les-specialistes')) {
        wp_enqueue_style('gj-tous-les-specialistes-style', get_stylesheet_directory_uri() . '/assets/css/tous-les-specialistes.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/tous-les-specialistes.css'));
    }

    if (is_page('epicerie')) {
        wp_enqueue_style('gj-epicerie-style', get_stylesheet_directory_uri() . '/assets/css/epicerie.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/epicerie.css'));
    }

    if (is_page('abonnement')) {
        wp_enqueue_style('gj-abonnement-style', get_stylesheet_directory_uri() . '/assets/css/abonnement.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/abonnement.css'));
    }
    if (is_page('fidelity')) {
        wp_enqueue_style('gj-fidelity-style', get_stylesheet_directory_uri() . '/assets/css/fidelity.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/fidelity.css'));
    }

    if (is_page('listedesouhaits')) {
        wp_enqueue_style('gj-custom-wishlist-style', get_stylesheet_directory_uri() . '/assets/css/custom-wishlist.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/custom-wishlist.css'));
    }

    if (is_page('notre-communaute')) {
        wp_enqueue_style('gj-communaute-style', get_stylesheet_directory_uri() . '/assets/css/communaute.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/communaute.css'));
    }

    if (is_page('a-propos')) {
        wp_enqueue_style('gj-a-propos-style', get_stylesheet_directory_uri() . '/assets/css/a-propos.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/a-propos.css'));
    }

    if (is_page('mes-favoris')) {
        wp_enqueue_style('gj-favoris-style', get_stylesheet_directory_uri() . '/assets/css/favoris.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/favoris.css'));
        wp_enqueue_script('gj-favoris-script', get_stylesheet_directory_uri() . '/assets/js/favoris.js', array('jquery'), filemtime(get_stylesheet_directory_uri() . '/assets/css/favoris.js'), true);
    }
// evenements
    if (is_page('evenements')) {
        wp_enqueue_style('gj-blog-style', get_stylesheet_directory_uri() . '/assets/css/blog.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/blog.css'));
        wp_enqueue_style('gj-article-style', get_stylesheet_directory_uri() . '/assets/css/article.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/article.css'));
    }
    if (is_singular('evenements')) {
        wp_enqueue_style('gj-article-style', get_stylesheet_directory_uri() . '/assets/css/article.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/article.css'));
    }
    

    if (is_account_page()) {
        wp_enqueue_style('gj-my-acount-style', get_stylesheet_directory_uri() . '/assets/css/my-account.css', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/my-account.css'));
        //        wp_enqueue_script('gj-favoris-script', get_stylesheet_directory_uri() . '/assets/js/favoris.js', array('jquery'), filemtime(get_stylesheet_directory_uri() . '/assets/css/favoris.js'), true);
        $font_awesome_kit_url = 'https://kit.fontawesome.com/b050931f68.js';
        wp_enqueue_script('font-awesome-kit', $font_awesome_kit_url, array(), null, true);

        wp_enqueue_script('custom-account-script', get_stylesheet_directory_uri() . '/assets/js/custom-account-script.js', array(), '1.0.0');
        wp_localize_script(
            'custom-account-script',
            'myAjax',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'logout_url' => wp_logout_url(home_url())
            )
        );

        wp_enqueue_style('custom-account-style', get_stylesheet_directory_uri() . '/assets/css/custom-account-style.css', array(), '1.0.0');
    }

    if(is_page('trouver-un-specialiste')){
        wp_enqueue_script('ginette-more-tags', get_stylesheet_directory_uri() . '/assets/js/more-tags.js', array(), filemtime(get_stylesheet_directory_uri() . '/assets/css/more-tags.js'), true);
    }

    // Global archive filter
    if ($post->post_parent == 16 || is_page('recettes') || is_page('trouver-un-specialiste') || is_page('tous-les-specialistes')) {
        wp_enqueue_script('gj-global-archive-filter-script', get_stylesheet_directory_uri() . '/assets/js/global-archive-filter.js', array('jquery'), filemtime(get_stylesheet_directory_uri() . '/assets/css/global-archive-filter.js'), true);
    }
}

function register_my_theme_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu')
        )
    );
}
add_action('init', 'register_my_theme_menus');

/** 
 *  SINGLE PRODUCT 
 * Filer WooCommerce Flexslider options - Add Navigation Arrows
 */
function ginette_update_woo_flexslider_options($options)
{
    $options['directionNav'] = true;
    $options['controlNav'] = true;
    $options['prevText'] = "";
    $options['nextText'] = "";
    return $options;
}

function hide_wishlist_link()
{
    if (is_shop() || is_page('catalogue')) {
        echo '<style>
        div.yith-wcwl-wishlistaddedbrowse a,
        div.yith-wcwl-wishlistexistsbrowse a,
        div#yith-wcwl-popup-message {
            display: none !important;
        }
        </style>';
    }
}
add_action('wp_footer', 'hide_wishlist_link');

// Allow to add shortcode to text widget
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

// Remove zoom on product page woo flexslider
function remove_image_zoom_support()
{
    remove_theme_support('wc-product-gallery-zoom');
}
add_action('wp', 'remove_image_zoom_support', 100);
add_filter('woocommerce_single_product_photoswipe_enabled', '__return_false');


function assign_page_template_to_new_blog_post($post_ID, $post, $update)
{
    // Vérifiez si c'est une nouvelle publication et si c'est un article de blog
    if (!$update && $post->post_type === 'post') {
        // Définissez le modèle de page que vous souhaitez assigner
        $page_template = 'wp-custom-template-blog-article';

        // Mettez à jour le champ '_wp_page_template' pour le nouvel article
        update_post_meta($post_ID, '_wp_page_template', $page_template);
    }
}
if (is_admin()) {
    // Utilisez l'action save_post pour déclencher la mise à jour lors de la création d'un nouvel article
    add_action('save_post', 'assign_page_template_to_new_blog_post', 10, 3);
}

function dequeue_plugin_styles()
{
    global $wp_styles;

    // Remplacez ceci par l'URL ou le chemin du répertoire de votre plugin
    $plugin_url = '/plugins/yith-woocommerce-customize-myaccount-page/';

    foreach ($wp_styles->queue as $handle) {
        $style = $wp_styles->registered[$handle];

        // Vérifiez si la feuille de style est chargée depuis le répertoire du plugin
        if (strpos($style->src, $plugin_url) !== false) {
            wp_dequeue_style($handle);
        }
    }
}
add_action('wp_enqueue_scripts', 'dequeue_plugin_styles', 100);

function get_fse_template_content($template_id)
{
    $template_post = get_post($template_id);

    if ($template_post) {
        $template_content = $template_post->post_content;

        // Render the blocks
        $template_content = do_blocks($template_content);
    } else {
        $template_content = 'No template found';
    }

    return $template_content;
}

function add_fse_template_to_header()
{
    $fse_template_id = 906; // Remplacez 906 par l'ID de votre template FSE
    $fse_content = get_fse_template_content($fse_template_id);

    echo $fse_content;
}

add_action('get_header', 'add_fse_template_to_header');

function globalOverlay()
{
    echo '<div class="global-overlay"></div>';
}
add_action('wp_footer', 'globalOverlay');