<!-- account-header.php -->
<?php
$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
if ( $current_user->exists() ) {
    $user_name = get_user_meta($current_user_id, 'first_name', true); 
    $user_avatar = get_avatar( $current_user->ID );
}
?>
<div class="gj-account-custom-header">
    <div class="gj-account-custom-header-logo">
        <a href="/">
            <img src="/wp-content/uploads/2023/09/logo-ginette.svg" alt="">
        </a>
    </div>
    <div class="gj-account-custom-header-user">
        <div class="gj-account-custom-header-user-details">
            <?php echo $user_avatar; ?>
            <div>
                <p>
                    Hello <?php echo $user_name; ?>
                </p>
                <p class="gj-account-custom-header-strong">
                    Bienvenue dans ton espace
                </p>
            </div>
        </div>
        <div class="gj-account-custom-header-user-search">

        </div>
    </div>
</div>

<div class="gj-account-custom-mobile-header">
    <div class="gj-account-custom-mobile-header-menu">
        <hr class="top-bar">
        <hr class="mid-bar">
        <hr class="bottom-bar">
    </div>
    <a href="/">
        <img src="/wp-content/uploads/2023/09/logo-mobile.svg" alt="">
    </a>
    <?php echo $user_avatar; ?>
</div>