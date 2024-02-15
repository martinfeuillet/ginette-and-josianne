<?php
require_once(get_stylesheet_directory() . '/inc/class/my-account/class-gj-wishlist.php');
$current_user_id = get_current_user_id();
$current_user_wishlist = get_user_meta(get_current_user_id(), 'user_post_wishlist', true);

$all_post = $current_user_wishlist ? $current_user_wishlist['all_post'] : null;

if (!empty($current_user_wishlist) && !empty($all_post)) {
    $not_empty = true;
}

echo '<pre>';
print_r($current_user_wishlist);
echo '</pre>';

$member = new YITH_WCMBS_Member( $current_user_id );
$is_member_active = $member->is_member();

?>
<section class="gj-wishlist-tab" style="">
    <hr class="gj-wishlist-tab-vertical-line right">
    <hr class="gj-wishlist-tab-vertical-line left">
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
        Ma liste d'envies
    </p>
    <?php if ($not_empty) { ?>
    <div class="gj-wishlist-tab-content-global">
        <div class="gj-wishlist-tab-content-header">
            <div class="gj-wishlist-tab-content-filters">
                <?php
                        foreach ($current_user_wishlist as $post_type => $post_list) :
                            $post_type_name = ($post_type === 'product' ? 'Produits' : ($post_type === 'all_post' ? 'Tous' : $post_type));
                            ?>
                <a class="gj-wishlist-tab-content-filter <?php echo $post_type === 'all_post' ? 'filter-active' : ''; ?>"
                    type="button" id="<?php echo $post_type; ?>"><?php echo ucfirst($post_type_name); ?></a>
                <input type="hidden" id="<?php echo $post_type . '-posts'; ?>"
                    value="<?php echo count($current_user_wishlist[$post_type]); ?>">
                <input type="hidden" id="is_member_input" name="is_member_input"
                    value="<?php echo $is_member_active; ?>">
                <?php endforeach; ?>
            </div>
            <h2 class="gj-wishlist-tab-content-title">Ajoutés récemment</h2>
        </div>
        <?php foreach ($current_user_wishlist as $post_type => $post_list) :
                    uasort($post_list, function($a, $b) {
                        return strcmp($b, $a);
                    });

                
                    $first_three_posts = array_slice($post_list, 0, 3, true);
                    $remaining_posts = array_slice($post_list, 3, 8, true);
                    ?>
        <div class="gj-wishlist-tab-content <?php echo $post_type === 'all_post' ? 'tab-content-active' : ''; ?>"
            id="gj-posts-<?php echo $post_type; ?>">
            <div class="gj-wishlist-tab-content-first-three-posts">
            </div>

            <?php if ($is_member_active) { ?>
            <article class="gj-wishlist-bump">
                <div class="gj-wishlist-bump-inner-div">
                    <div class="gj-wishlist-bump-part left">
                        <h3>
                            Découvrir nos nouveautés
                        </h3>
                        <p>
                            Lorem ipsum dolor si amet.
                        </p>
                        <a href="/boutique/catalogue" class="gj-wishlist-tab-content-subscribe">Découvrir les nouveautés
                            !</a>
                    </div>
                    <aside class="gj-wishlist-bump-part right">
                        <img src="/wp-content/uploads/2023/11/Chill-tonic.jpg" alt="">
                    </aside>
                </div>
            </article>
            <?php } else { ?>
            <article class="gj-wishlist-bump">
                <div class="gj-wishlist-bump-inner-div">
                    <div class="gj-wishlist-bump-part left">
                        <h3>
                            Envie de bénéficier d'avantage et de faire des économies ?
                        </h3>
                        <p>
                            Abonne-toi et profites de 30% de réduction sur la boutique toute l'année et un tarif de
                            livraison unique
                        </p>
                        <a href="/abonnement/" class="gj-wishlist-tab-content-subscribe">Je m'abonne dès maintenant
                            !</a>
                    </div>
                    <aside class="gj-wishlist-bump-part right">
                        <img src="/wp-content/uploads/2023/09/boutique-section-2-2a-min.webp" alt="">
                    </aside>
                </div>
            </article>
            <?php } ?>

            <div class="gj-wishlist-tab-content-remaining-posts">
            </div>
        </div>
        <?php
                endforeach;
                ?>
    </div>
    <div id="gj-wishlist-pagination-controls">

    </div>
    <?php } else { ?>
    <h2 class="gj-empty-wishlist">Votre liste d'envies est vide !</h2>
    <?php } ?>
</section>