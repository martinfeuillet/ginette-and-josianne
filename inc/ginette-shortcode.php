<?php
add_shortcode('specialiste_unique_badge_condition', 'shortcode_specialiste_unique_badge_condition');
function shortcode_specialiste_unique_badge_condition(){
    $remboursables = get_post_meta(get_the_ID(), 'remboursable', true);
    if($remboursables == "Oui"){
        return '<div class="specialiste-unique-mainBlock-badge-wrapper"><span class="specialiste-unique-mainBlock-badge">Prise en charge par votre mutuelle</span></div>';
    }
    // foreach($remboursables as $remboursable => $bool){
    //     if($bool == 'true'){
    //         return '<div class="specialiste-unique-mainBlock-badge-wrapper"><span class="specialiste-unique-mainBlock-badge">Prise en charge par votre mutuelle</span></div>';
    //     }
    // }
}

add_shortcode('listing_recette_tag', 'shortcode_listing_recette_tag');
function shortcode_listing_recette_tag(){
    $cats = get_post_meta(get_the_ID(), 'categorie', true);
    $output = '';
    if(!empty($cats)){
        $output .= '<div class="listing-recette__tag-wrapper">';
        $i = 0;
        foreach ($cats as $cat => $bool){
            if($bool == 'true'){
                $output .= '<span class="listing-recette__tag">' . $cat . '</span>';
                if($i == 3){ // only the four first tags
                    break;
                }

                if($i == 1){ // after second tag if more than 2 tags
                    $output .= '<span class="is-image-wrapper listing-item-see-more-tag"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="white"/><line x1="12.0095" y1="6" x2="12.0095" y2="18" stroke="#CF6D3F"/><line x1="18" y1="12.5" x2="5.99997" y2="12.5" stroke="#CF6D3F"/></svg></span>';
                }
                
                $i++;
            }
        }
        $output .= '</div>';
        return $output;
    }
}

add_shortcode('listing_event_tag', 'shortcode_listing_event_tag');
function shortcode_listing_event_tag(){
    $cats = get_post_meta(get_the_ID(), 'categorie', true);
    $output = '';
    if(!empty($cats)){
        $output .= '<div class="listing-recette__tag-wrapper">';
        $i = 0;
        foreach ($cats as $cat => $bool){
            if($bool == 'true'){
                $output .= '<span class="listing-recette__tag">' . $cat . '</span>';
            }
        }
        
        $output .= '</div>';
        return $output;
    }
}

add_shortcode('produit_certification_dynamique', 'shortcode_produit_certification_dynamique');
function shortcode_produit_certification_dynamique(){
    // PREPARE DATA FOR OUTPUT
    $output = ''; 
    // Get the product tag 
    $terms = get_the_terms( $post->ID, 'product_tag' );
    // Code for certification (left block)
    $tagsArray = array();
    // Code for tags cloud (right block)
    $HTMLtags = "";
    // Loop through tags
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $HTMLtags .= '<a class="tag-cloud-link">' . $term->name . '</a>';
            $tagsArray[] = $term->slug;
        }
    }
    // If product contain certifie low fodmap tag then show the related image
    if (in_array("certifie-low-fodmap", $tagsArray)){
        $HTMLproduct_certif = '
        <div class="product__certification">
            <img src="/wp-content/uploads/2023/09/low-fod.svg" alt="logo certification Low FodMap">
        </div>';
    }

    // DISPLAY DATA
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        $output .= '<div class="product-wrapper__tags">';
            if (in_array("certifie-low-fodmap", $tagsArray)){
                $output .= $HTMLproduct_certif;
            } 
            $output .= '<div class="gj-block__cloud-tag">' . $HTMLtags . ' </div>';
        $output .= '</div>';
        return $output;
    }
}

// A short condition to show a placeholder if there is no image for the recette
add_shortcode('listing_recette_featured_image_placeholder', 'shortcode_listing_recette_featured_image_placeholder');
function shortcode_listing_recette_featured_image_placeholder(){
    $postThumbnailURL = get_the_post_thumbnail_url();
    $output = '';
    if(!empty($postThumbnailURL)){
        $output .= '<img src=" ' . $postThumbnailURL . ' ">';
    } else {
        $output .= '<img src="/wp-content/uploads/woocommerce-placeholder.png">';
    }

    return $output;
}

// A short condition to show a placeholder if there is no image for the recette main listing image on recettes archives
add_shortcode('listing_recette_main_featured_image_placeholder', 'shortcode_listing_recette_main_featured_image_placeholder');
function shortcode_listing_recette_main_featured_image_placeholder(){
    $output = '';
    $image = get_post_meta( get_the_ID(), 'recette-image-principale', true);
    if($image){
        $imageURL = $image;
    } else {
        $imageURL = '/wp-content/uploads/woocommerce-placeholder.png';
    }
    $output .= '<img class="recette-main-image" src="' . $imageURL . '">';
    return $output;
}

// RECETTE UNIQUE DATA OUTPUT
// Image mobile recette
add_shortcode('recette_image_mobile', 'shortcode_recette_image_mobile');
function shortcode_recette_image_mobile(){
    $image = get_post_meta( get_the_id(), 'recette-image-principale-mobile', true);
    if($image){
        $imageURL = $image;
    } else {
        $imageURL = '/wp-content/uploads/woocommerce-placeholder.png';
    }
    return ('<img class="recette-main-image-mobile" src="' . $imageURL . '">');
}

// Temps de préparation
add_shortcode('recette_temps_preparation', 'shortcode_recette_temps_preparation');
function shortcode_recette_temps_preparation(){
    $temps = get_post_meta(get_the_id(), 'temps-recette', true);
    $valeur = get_post_meta(get_the_id(), 'temps-recette-valeur', true);
    $s = '';
    if($temps > 1);{
        $s = 's';
    }
    return ('<p>' . $temps . ' ' . $valeur . $s . ' de préparation </p>');
}

// Nombre de personne
add_shortcode('recette_nombre_personne', 'shortcode_recette_nombre_personne');
function shortcode_recette_nombre_personne(){
    $nombrePersonne = get_post_meta(get_the_id(), 'nombre-de-part', true);
    $s = '';
    if($nombrePersonne > 1);{
        $s = 's';
    }
    return ('<div><span class="recette-nombre-personne">'. $nombrePersonne .'</span> personne'. $s .' / portion'. $s .'</div>');
}

// Fodmap
add_shortcode('recette_fodmap', 'shortcode_recette_fodmap');
function shortcode_recette_fodmap(){
    $data = get_post_meta(get_the_id(), 'niveau-fodmap', true);
    return('
    <div class="recette-preparation-column niveau-fodmap">
            <div class="recette-preparation-col-inner recette-fodmap">
                <div class="fodmap-text">' . $data . '</div>
            </div>
    </div>');

    // // If different from empty
    // if($data){
    //     switch ($data) {
    //         case 'vert':
    //             $url = "/wp-content/uploads/2023/12/vert3.png";
    //             $text = 'Low Fodmap';
    //             break;
    //         case 'orange':
    //             $url = "/wp-content/uploads/2023/12/orange3.png";
    //             $text = 'Medium Fodmap';
    //             break;
    //         case 'rouge':
    //             $url = "/wp-content/uploads/2023/12/rouge3.png";
    //             $text = 'High Fodmap';
    //             break;
    //     }
    //     return('
    //     <div class="recette-preparation-column">
    //         <div class="recette-preparation-col-inner recette-fodmap">
    //             <img src="' . $url . '">
    //             <div class="fodmap-text">' . $text . '</div>
    //         </div>
    //     </div>');
    // } 
}

// Préparation
add_shortcode('recette_preparation', 'shortcode_recette_preparation');
function shortcode_recette_preparation(){
    // $nombreMaxPart = get_post_meta(get_the_ID(), 'nombre-part-max', true);
    $nombreMaxPart = 20;
    $optionLoop = '';
    for($i = 1; $i <= $nombreMaxPart; $i++){
        $optionLoop .= '<option value="' . $i . '">' . $i . '</option>';
    }
    return ('<div class="recette-nombre-part-select"><svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1.5L5 5.5L9 1.5" stroke="#CF6D3F" stroke-width="1.5" stroke-linecap="round"/></svg><select name="nombre-personne-select" id="recette-nombre-personne-select">'. $optionLoop .'</select><svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_13_2904)"><path d="M14.541 16.7084L13.7155 10.5168H13.7385C13.9809 10.5168 14.1774 10.3203 14.1774 10.0778V1.15257C14.1774 0.998337 14.0968 0.856 13.965 0.776595C13.8332 0.697117 13.6697 0.692427 13.5337 0.764223C11.8221 1.66736 10.7506 3.44314 10.7506 5.37898V9.1423C10.7506 9.9013 11.3661 10.5167 12.1252 10.5167H12.2292L11.4037 16.7084C11.3437 17.1603 11.4814 17.6169 11.7815 17.9599C12.0822 18.3029 12.5164 18.5 12.9724 18.5C13.4283 18.5 13.8626 18.3029 14.1633 17.9599C14.4634 17.6169 14.6011 17.1603 14.541 16.7084Z" fill="#CF6D3F"/><path d="M7.66274 0.5C7.32972 0.5 7.06023 0.769495 7.06023 1.10248V4.46804H6.45772V1.10248C6.45772 0.769495 6.18822 0.5 5.8552 0.5C5.52219 0.5 5.25273 0.769495 5.25273 1.10248V4.46804H4.65022V1.10248C4.65018 0.769495 4.38068 0.5 4.0477 0.5C3.71465 0.5 3.44519 0.769495 3.44519 1.10248V4.46804V5.01881V6.54038C3.44519 7.43414 4.16947 8.15842 5.06323 8.15842H5.19678L4.24717 16.7037C4.19658 17.1608 4.34305 17.618 4.64959 17.9611C4.95675 18.3041 5.3951 18.5 5.85524 18.5C6.31538 18.5 6.75369 18.3041 7.06089 17.9611C7.36747 17.618 7.51394 17.1608 7.46331 16.7037L6.51367 8.15846H6.64725C7.54098 8.15846 8.26529 7.43418 8.26529 6.54042V5.01885V4.46807V1.10248C8.26525 0.769495 7.99576 0.5 7.66274 0.5Z" fill="#CF6D3F"/></g><defs><clipPath id="clip0_13_2904"><rect width="18" height="18" fill="white" transform="translate(0 0.5)"/></clipPath></defs></svg></div>');
}

// Recette repeater
add_shortcode('recette_repeater', 'shortcode_recette_repeater');
function shortcode_recette_repeater(){
    $repeaterRecette = get_post_meta(get_the_ID(), 'repeater-recette', true);
    $i = 1;
    $output = '';

    if($repeaterRecette){
        $output .= '<div class="recette-etape-item-wrapper">';
            foreach($repeaterRecette as $recetteItem){
                $text = $recetteItem['recette-texte'];
                $output .= '
                <div class="recette-etape-item">
                    <p class="recette-etape-item-etape"> Étape '. $i .'</p>
                    <p class="recette-etape-item-text">'. $text .'</p>
                </div>';
                $i++;
            }
        $output .= '</div>';
        return ($output);	
    }
}

// Recette vidéo
add_shortcode('recette_video', 'shortcode_recette_video');
function shortcode_recette_video(){
    $url = get_post_meta(get_the_ID(), 'recette-lien-video', true);
    $imageURL = get_post_meta( get_the_ID(), 'recette-image-principale', true);

    $output = '';
    if($url){
        $output .= '<iframe width="560" height="315" src="'. $url .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
    } else {
        $output .= '<img class="recette-main-image" src="' . $imageURL . '">';
    }

    return $output;
}

// recette categorie
add_shortcode('recette_categorie', 'shortcode_recette_categorie');
function shortcode_recette_categorie(){
    $output = '';
    $cats = get_post_meta(get_the_ID(), 'categorie', true);
    $virgule = '';
    if(!empty($cats)){
        $i = 0;
        $output .= '<p class="">';
        foreach ($cats as $cat => $bool){
            if($bool == 'true'){
                $output .= ($virgule . $cat);
                if($i == 1){
                    break;
                }
                $virgule = ", ";
                $i++;
            }
        }
        $output .= '</p>';
        return $output;
    } 
}

// LISTING SPÉCIALISTE
// Type consultation
add_shortcode('listing_specialiste_type_consultation', 'shortcode_listing_specialiste_type_consultation');
function shortcode_listing_specialiste_type_consultation(){
    $type_consultations = get_post_meta(get_the_ID(), 'type-consultation');
    if($type_consultations){
        $output = '<div class="specialiste-badge-rdv-wrapper">';
            foreach($type_consultations as $labels){
                foreach($labels as $label => $key){
                    if($key == 'true'){
                        if($label == 'Téléconsultation'){
                            $output .= '<span class="specialiste-badge-rdv"><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.0625 0.281372H0.9375C0.420625 0.281372 0 0.701997 0 1.21887V10.5314C0 11.0482 0.420625 11.4689 0.9375 11.4689H15.0625C15.5794 11.4689 16 11.0482 16 10.5314V1.21887C16 0.701997 15.5794 0.281372 15.0625 0.281372Z" fill="#CF6D3F"/><path d="M13 13.7814H10.4688V12.4064H5.53125V13.7814H3C2.74125 13.7814 2.53125 13.9914 2.53125 14.2501C2.53125 14.5089 2.74125 14.7189 3 14.7189H13C13.2587 14.7189 13.4688 14.5089 13.4688 14.2501C13.4688 13.9914 13.2587 13.7814 13 13.7814Z" fill="#CF6D3F"/></svg>' . $label . '</span>';
                            }
                        if($label == 'RDV Présentiel'){
                            $output .= '<span class="specialiste-badge-rdv"><svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_99_5091)"><path d="M8 0.500122C5.67378 0.500122 3.78125 2.39265 3.78125 4.71887C3.78125 7.04509 5.67378 8.93762 8 8.93762C10.3262 8.93762 12.2188 7.04509 12.2188 4.71887C12.2188 2.39265 10.3262 0.500122 8 0.500122Z" fill="#CF6D3F"/><path d="M13.2489 11.6937C12.0939 10.521 10.5628 9.87512 8.9375 9.87512H7.0625C5.43725 9.87512 3.90606 10.521 2.75106 11.6937C1.60172 12.8607 0.96875 14.4012 0.96875 16.0314C0.96875 16.2902 1.17862 16.5001 1.4375 16.5001H14.5625C14.8214 16.5001 15.0312 16.2902 15.0312 16.0314C15.0312 14.4012 14.3983 12.8607 13.2489 11.6937Z" fill="#CF6D3F"/></g><defs><clipPath id="clip0_99_5091"><rect width="16" height="16" fill="white" transform="translate(0 0.500122)"/></clipPath></defs></svg>' . $label . '</span>';
                        }
                    }
                }
            }
        $output .= '</div>';
        return $output;
    }
}

// Badge specialité
// add_shortcode('listing_specialiste_badge', 'shortcode_listing_specialiste_badge');
// function shortcode_listing_specialiste_badge(){
//     // Main expertise
//     $domaine_expertise = get_the_terms(get_the_ID(), 'specialiste-domaine-expertise');
//     if($domaine_expertise){
//         $output = '<div class="specialiste-badge-expertise-wrapper">';
//         foreach($domaine_expertise as $expertise){
//             $output .= '<span class="specialiste-badge-expertise">' . $expertise->name . '</span>';
//         }
//         // Secondary expertise
//         $secondary_expertises = get_post_meta(get_the_ID(), 'specialisations-complementaires');
//         foreach($secondary_expertises as $secondary_expertise){
//             foreach($secondary_expertise as $secondary_expertiseChild){
//                 $output .= '<span class="specialiste-badge-expertise">' . $secondary_expertiseChild['nom-specialisation-complementaire'] . '</span>';
//             }
//         }
//         $output .= '</div>';
//         return ($output);
//     }
// }

// Review
add_shortcode('listing_specialiste_review', 'shortcode_listing_specialiste_review');
function shortcode_listing_specialiste_review(){
    $note = get_post_meta(get_the_ID(), 'note-avis-google');
    if($note){
        return('
        <div class="avis-google-dynamic">
            <div>
                <svg width="87" height="13" viewBox="0 0 87 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M46.5366 8.00699L46.6684 7.87855L49.5874 5.03316C49.5875 5.03307 49.5876 5.03299 49.5876 5.03291C49.6213 4.99969 49.632 4.95257 49.6184 4.91093C49.6043 4.86771 49.567 4.83623 49.5221 4.8296C49.522 4.82959 49.5219 4.82959 49.5219 4.82958L45.4866 4.24367L45.3045 4.21723L45.2231 4.05219L43.4184 0.394998L43.4184 0.394985C43.4122 0.38247 43.3838 0.35 43.3118 0.35C43.2398 0.35 43.2114 0.38247 43.2052 0.394985L43.2052 0.394998L41.4005 4.05219L41.319 4.21723L41.1369 4.24367L37.1017 4.82958C37.1016 4.82958 37.1016 4.82959 37.1015 4.8296C37.057 4.83617 37.0193 4.86784 37.0051 4.9112C36.9916 4.95255 37.0026 5.00013 37.0355 5.0325C37.0356 5.03257 37.0356 5.03263 37.0357 5.0327L39.9556 7.87805L40.0874 8.00649L40.0563 8.18788L39.3668 12.2076C39.3668 12.2077 39.3668 12.2077 39.3668 12.2078C39.3592 12.2524 39.3776 12.2974 39.4142 12.3241L39.4148 12.3245C39.4509 12.3509 39.4989 12.3543 39.5381 12.3335L39.5391 12.333L43.1489 10.4355L43.3118 10.3499L43.4746 10.4355L47.085 12.3334L47.0854 12.3337C47.1024 12.3426 47.1212 12.3471 47.1401 12.3471C47.1653 12.3471 47.1896 12.3393 47.2093 12.3249L47.2098 12.3246C47.2464 12.2979 47.2648 12.2529 47.2573 12.2084L46.5366 8.00699ZM46.5366 8.00699L46.5678 8.18835L47.2572 12.2081L46.5366 8.00699Z" stroke="#616060" stroke-width="0.7"/><path d="M64.8614 8.00699L64.9931 7.87855L67.9121 5.03316C67.9122 5.03307 67.9123 5.03299 67.9123 5.03291C67.946 4.99969 67.9567 4.95257 67.9431 4.91093C67.929 4.86771 67.8917 4.83623 67.8468 4.8296C67.8467 4.82959 67.8466 4.82959 67.8466 4.82958L63.8114 4.24367L63.6292 4.21723L63.5478 4.05219L61.7431 0.394998L61.7431 0.394985C61.7369 0.38247 61.7085 0.35 61.6365 0.35C61.5645 0.35 61.5361 0.38247 61.5299 0.394985L61.5299 0.394998L59.7252 4.05219L59.6438 4.21723L59.4616 4.24367L55.4264 4.82958C55.4263 4.82958 55.4263 4.82959 55.4262 4.8296C55.3817 4.83617 55.344 4.86784 55.3298 4.9112C55.3163 4.95255 55.3273 5.00013 55.3602 5.0325C55.3603 5.03257 55.3603 5.03263 55.3604 5.0327L58.2803 7.87805L58.4121 8.00649L58.381 8.18788L57.6915 12.2076C57.6915 12.2077 57.6915 12.2077 57.6915 12.2078C57.6839 12.2524 57.7023 12.2974 57.7389 12.3241L57.7395 12.3245C57.7756 12.3509 57.8236 12.3543 57.8628 12.3335L57.8638 12.333L61.4736 10.4355L61.6365 10.3499L61.7994 10.4355L65.4097 12.3334L65.4101 12.3337C65.4271 12.3426 65.4459 12.3471 65.4648 12.3471C65.49 12.3471 65.5143 12.3393 65.534 12.3249L65.5345 12.3246C65.5712 12.2979 65.5895 12.2529 65.582 12.2084L64.8614 8.00699ZM64.8614 8.00699L64.8925 8.18835L65.5819 12.2081L64.8614 8.00699Z" stroke="#616060" stroke-width="0.7"/><path d="M28.2119 8.00699L28.3437 7.87855L31.2627 5.03316C31.2628 5.03307 31.2628 5.03299 31.2629 5.03291C31.2966 4.99969 31.3073 4.95257 31.2937 4.91093C31.2796 4.86771 31.2423 4.83623 31.1974 4.8296C31.1973 4.82959 31.1972 4.82959 31.1972 4.82958L27.1619 4.24367L26.9798 4.21723L26.8984 4.05219L25.0937 0.394998L25.0937 0.394985C25.0875 0.38247 25.0591 0.35 24.9871 0.35C24.9151 0.35 24.8867 0.38247 24.8805 0.394985L24.8805 0.394998L23.0758 4.05219L22.9943 4.21723L22.8122 4.24367L18.777 4.82958C18.7769 4.82958 18.7769 4.82959 18.7768 4.8296C18.7323 4.83617 18.6946 4.86784 18.6804 4.9112C18.6669 4.95255 18.6779 5.00013 18.7108 5.0325C18.7109 5.03257 18.7109 5.03263 18.711 5.0327L21.6309 7.87805L21.7627 8.00649L21.7316 8.18788L21.0421 12.2076C21.0421 12.2077 21.0421 12.2077 21.0421 12.2078C21.0345 12.2524 21.0528 12.2974 21.0895 12.3241L21.0901 12.3245C21.1262 12.3509 21.1742 12.3543 21.2134 12.3335L21.2144 12.333L24.8242 10.4355L24.9871 10.3499L25.1499 10.4355L28.7602 12.3334L28.7607 12.3337C28.7777 12.3426 28.7965 12.3471 28.8154 12.3471C28.8406 12.3471 28.8649 12.3393 28.8846 12.3249L28.8851 12.3246C28.9217 12.2979 28.9401 12.2529 28.9326 12.2084L28.2119 8.00699ZM28.2119 8.00699L28.243 8.18835L28.9325 12.2081L28.2119 8.00699Z" stroke="#616060" stroke-width="0.7"/><path d="M83.1861 8.00699L83.3178 7.87855L86.2368 5.03316C86.2369 5.03307 86.237 5.03299 86.2371 5.03291C86.2707 4.99969 86.2814 4.95257 86.2678 4.91093C86.2537 4.86771 86.2164 4.83623 86.1715 4.8296C86.1714 4.82959 86.1714 4.82959 86.1713 4.82958L82.1361 4.24367L81.9539 4.21723L81.8725 4.05219L80.0678 0.394998L80.0678 0.394985C80.0616 0.38247 80.0332 0.35 79.9612 0.35C79.8892 0.35 79.8608 0.38247 79.8546 0.394985L79.8546 0.394998L78.0499 4.05219L77.9685 4.21723L77.7863 4.24367L73.7511 4.82958C73.751 4.82958 73.751 4.82959 73.7509 4.8296C73.7064 4.83617 73.6687 4.86784 73.6545 4.9112C73.641 4.95255 73.652 5.00013 73.6849 5.0325C73.685 5.03257 73.6851 5.03263 73.6851 5.0327L76.605 7.87805L76.7368 8.00649L76.7057 8.18788L76.0162 12.2076C76.0162 12.2077 76.0162 12.2077 76.0162 12.2078C76.0086 12.2524 76.027 12.2974 76.0636 12.3241L76.0642 12.3245C76.1003 12.3509 76.1483 12.3543 76.1875 12.3335L76.1885 12.333L79.7983 10.4355L79.9612 10.3499L80.1241 10.4355L83.7344 12.3334L83.7348 12.3337C83.7518 12.3426 83.7706 12.3471 83.7895 12.3471C83.8147 12.3471 83.839 12.3393 83.8588 12.3249L83.8592 12.3246C83.8959 12.2979 83.9142 12.2529 83.9067 12.2084L83.1861 8.00699ZM83.1861 8.00699L83.2172 8.18835L83.9067 12.2081L83.1861 8.00699Z" stroke="#616060" stroke-width="0.7"/><path d="M9.88723 8.00699L10.019 7.87855L12.938 5.03316C12.9381 5.03307 12.9381 5.03299 12.9382 5.03291C12.9719 4.99969 12.9825 4.95257 12.969 4.91093C12.9549 4.86771 12.9176 4.83623 12.8726 4.8296C12.8726 4.82959 12.8725 4.82959 12.8725 4.82958L8.83723 4.24367L8.6551 4.21723L8.57366 4.05219L6.76897 0.394998L6.76896 0.394985C6.76279 0.38247 6.73435 0.35 6.66237 0.35C6.59038 0.35 6.56194 0.38247 6.55577 0.394985L6.55576 0.394998L4.75108 4.05219L4.66963 4.21723L4.4875 4.24367L0.452267 4.82958C0.452207 4.82958 0.452147 4.82959 0.452086 4.8296C0.407563 4.83617 0.369844 4.86784 0.35567 4.9112C0.342154 4.95255 0.353153 5.00013 0.386093 5.0325C0.386161 5.03257 0.386229 5.03263 0.386297 5.0327L3.30617 7.87805L3.43797 8.00649L3.40686 8.18788L2.71738 12.2076C2.71737 12.2077 2.71736 12.2077 2.71735 12.2078C2.7098 12.2524 2.72814 12.2974 2.76479 12.3241L2.76539 12.3245C2.80152 12.3509 2.84946 12.3543 2.88868 12.3335L2.88967 12.333L6.49952 10.4355L6.66238 10.3499L6.82523 10.4355L10.4355 12.3334L10.436 12.3337C10.453 12.3426 10.4718 12.3471 10.4906 12.3471C10.5159 12.3471 10.5402 12.3393 10.5599 12.3249L10.5604 12.3246C10.597 12.2979 10.6154 12.2529 10.6079 12.2084L9.88723 8.00699ZM9.88723 8.00699L9.91834 8.18835L10.6078 12.2081L9.88723 8.00699Z" stroke="#616060" stroke-width="0.7"/></svg>
            </div>
        <p class="avis-google-note">'. array_shift($note) .' sur 5</p>
        <div class="avis-google-logo"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_99_5019)"><path d="M15.3962 6.6092L8.86993 6.60889C8.58174 6.60889 8.34814 6.84245 8.34814 7.13064V9.21548C8.34814 9.50361 8.58174 9.73723 8.86989 9.73723H12.5451C12.1426 10.7816 11.3915 11.6563 10.4332 12.212L12.0003 14.9248C14.5141 13.471 16.0003 10.9201 16.0003 8.06451C16.0003 7.65792 15.9703 7.36726 15.9104 7.03998C15.8648 6.79132 15.649 6.6092 15.3962 6.6092Z" fill="#167EE6"/><path d="M8.0001 12.8697C6.20153 12.8697 4.63141 11.887 3.78813 10.4329L1.07544 11.9964C2.45591 14.389 5.04197 16.0001 8.0001 16.0001C9.45125 16.0001 10.8205 15.6094 12.0001 14.9285V14.9248L10.433 12.212C9.71619 12.6277 8.88669 12.8697 8.0001 12.8697Z" fill="#12B347"/><path d="M12 14.9284V14.9247L10.4329 12.2119C9.71609 12.6276 8.88666 12.8696 8 12.8696V16.0001C9.45116 16.0001 10.8205 15.6094 12 14.9284Z" fill="#0F993E"/><path d="M3.13044 8.00006C3.13044 7.11353 3.37237 6.28413 3.78803 5.56735L1.07534 4.00378C0.390687 5.17963 0 6.54519 0 8.00006C0 9.45494 0.390687 10.8205 1.07534 11.9963L3.78803 10.4328C3.37237 9.716 3.13044 8.8866 3.13044 8.00006Z" fill="#FFD500"/><path d="M8.0001 3.13056C9.17294 3.13056 10.2503 3.54731 11.0917 4.24053C11.2993 4.41153 11.601 4.39918 11.7912 4.20903L13.2684 2.73184C13.4841 2.51609 13.4688 2.16293 13.2383 1.963C11.8284 0.739903 9.99406 0.00012207 8.0001 0.00012207C5.04197 0.00012207 2.45591 1.61128 1.07544 4.00384L3.78813 5.5674C4.63141 4.11325 6.20153 3.13056 8.0001 3.13056Z" fill="#FF4B26"/><path d="M11.0916 4.24053C11.2992 4.41153 11.601 4.39919 11.7911 4.20903L13.2683 2.73184C13.484 2.51609 13.4686 2.16293 13.2382 1.963C11.8283 0.739872 9.99397 0.00012207 8 0.00012207V3.13056C9.17281 3.13056 10.2502 3.54731 11.0916 4.24053Z" fill="#D93F21"/></g><defs><clipPath id="clip0_99_5019"><rect width="16" height="16" fill="white"/></clipPath></defs></svg></div>
        </div>
        ');
    }
}

// CATALOGUE PRODUIT ÉPICERIE
// Display product badge : if the stock is less than 5 product left, display a badge with the number of product that left ELSE just display a badge "new" if the product "created date" field's is inferior to 1 month
add_shortcode('listing_product_epicerie_badge', 'shortcode_listing_product_epicerie_badge');
function shortcode_listing_product_epicerie_badge(){
    $output = '';
    
    // Condition to check low quantity
    $stock_quantity = get_post_meta(get_the_ID(), '_stock', true);
    $stock_statut = get_post_meta(get_the_ID(), '_stock_status', true);

    // Condition to check new product
    $currentDate = date_create(date('Y-m-d'));
    $productDate = date_create(get_the_date('Y-m-d', get_the_ID())); 
    $diff=date_diff($currentDate,$productDate);
    $newProductDiff = $diff->format('%a');

    // first condition -> if product has been created within last 20 days we display the badge "new"
    if($newProductDiff < 20){
        $output = '<p class="listing-product-badge badge-nouveaute" style="font-size:12px">Nouveauté</p>';
    }

    if($stock_statut == 'outofstock'){
        $output = '<p class="listing-product-badge badge-out-of-stock">Rupture de stock !</p><style>.jet-listing-grid__item.jet-listing-dynamic-post-'.get_the_ID().'{opacity: .4 !important; pointer-events: none;}</style>';
    } else if ($stock_quantity == 0){
        $output = '<p class="listing-product-badge badge-out-of-stock">Rupture de stock !</p><style>.jet-listing-grid__item.jet-listing-dynamic-post-'.get_the_ID().'{opacity: .4 !important; pointer-events: none;}</style>';
    } else if($stock_quantity <= 5){
        $output = '<p class="listing-product-badge badge-low-stock"><span class="is-image-wrapper"><svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.4703 6.27077C13.2288 6.27077 13.0328 6.07477 13.0328 5.83327C13.0328 4.15793 12.3808 2.58353 11.1965 1.39877C11.0256 1.22787 11.0256 0.950806 11.1965 0.779907C11.3674 0.609009 11.6445 0.609009 11.8155 0.779907C13.1647 2.12968 13.9078 3.92465 13.9078 5.83327C13.9078 6.07477 13.7118 6.27077 13.4703 6.27077Z" fill="#CF6D3F"/><path d="M1.51172 6.27084C1.27022 6.27084 1.07422 6.07484 1.07422 5.83334C1.07422 3.92473 1.81741 2.12976 3.16719 0.780518C3.33809 0.609619 3.61527 0.609619 3.78616 0.780518C3.95706 0.951416 3.95706 1.22859 3.78616 1.39949C2.60141 2.5836 1.94922 4.158 1.94922 5.83334C1.94922 6.07484 1.75322 6.27084 1.51172 6.27084Z" fill="#CF6D3F"/><path d="M7.49121 14C6.28488 14 5.30371 13.0188 5.30371 11.8125C5.30371 11.571 5.49971 11.375 5.74121 11.375C5.98271 11.375 6.17871 11.571 6.17871 11.8125C6.17871 12.5365 6.76724 13.125 7.49121 13.125C8.21507 13.125 8.80371 12.5365 8.80371 11.8125C8.80371 11.571 8.99971 11.375 9.24121 11.375C9.48271 11.375 9.67871 11.571 9.67871 11.8125C9.67871 13.0188 8.69754 14 7.49121 14Z" fill="#CF6D3F"/><path d="M12.3031 12.25H2.67813C2.11513 12.25 1.65723 11.7921 1.65723 11.2292C1.65723 10.9305 1.78732 10.6476 2.0143 10.4533C2.90147 9.70372 3.40723 8.61414 3.40723 7.45972V5.8333C3.40723 3.58171 5.23894 1.75 7.49063 1.75C9.74222 1.75 11.5739 3.58171 11.5739 5.8333V7.45972C11.5739 8.61414 12.0797 9.70372 12.9611 10.4493C13.1938 10.6476 13.3239 10.9305 13.3239 11.2292C13.3239 11.7921 12.866 12.25 12.3031 12.25ZM7.49063 2.625C5.7213 2.625 4.28223 4.06407 4.28223 5.8333V7.45972C4.28223 8.87187 3.66336 10.2054 2.58478 11.1172C2.56438 11.1347 2.53223 11.1709 2.53223 11.2292C2.53223 11.3085 2.59877 11.375 2.67813 11.375H12.3031C12.3824 11.375 12.4489 11.3085 12.4489 11.2292C12.4489 11.1709 12.4169 11.1347 12.3976 11.1183C11.3178 10.2054 10.6989 8.87187 10.6989 7.45972V5.8333C10.6989 4.06407 9.25986 2.625 7.49063 2.625Z" fill="#CF6D3F"/><path d="M7.49121 2.625C7.24971 2.625 7.05371 2.429 7.05371 2.1875V0.4375C7.05371 0.195999 7.24971 0 7.49121 0C7.73271 0 7.92871 0.195999 7.92871 0.4375V2.1875C7.92871 2.429 7.73271 2.625 7.49121 2.625Z" fill="#CF6D3F"/></svg></span>Plus que ' . $stock_quantity . ' produits !</p>';
    } 

    return $output;
}

// Listing product épicerie price
add_shortcode('listing_epicerie_product_price', 'shortcode_listing_epicerie_product_price');
function shortcode_listing_epicerie_product_price(){
    $price = get_post_meta( get_the_ID(), '_regular_price', true);
    $price = str_replace('.', ',', $price);

    return '<p class="listing-product-epicerie-price"><span>Dès </span>' . $price . ' €</p>';
}

// Listing product short description
add_shortcode('listing_epicerie_product_short_description', 'shortcode_listing_epicerie_product_short_description');
function shortcode_listing_epicerie_product_short_description(){
    $shortDescription = strip_tags(get_the_excerpt());
    
    return '<p class="listing-product-epcierie-short-description">' . $shortDescription . '</p>';
}

// Listing product vidéo
add_shortcode('listing_communaute_video', 'shortcode_listing_communaute_video');
function shortcode_listing_communaute_video(){
    $video = get_post_meta(get_the_ID(), 'video', true);
    return '<div><iframe width="100%" height="165" src="'. $video .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>';
}

// for jetengine query -> get products ids on current user wishlist
add_shortcode('listing_favoris_produits', 'shortcode_listing_favoris_produits');
function shortcode_listing_favoris_produits(){
    $favoris_items = get_user_meta(get_current_user_id(), 'user_post_wishlist', true)['product'];
    $output = '';
    $virgule = '';
    foreach($favoris_items as $item_id => $date_ajout){
        $output .= ($virgule . $item_id);
        $virgule = ', ';
    }

    if($output){
        return $output;
    } else {
        return 'none';
    }
}

// for jetengine query -> get recettes ids on current user wishlist
add_shortcode('listing_favoris_recettes', 'shortcode_listing_favoris_recettes');
function shortcode_listing_favoris_recettes(){
    $favoris_items = get_user_meta(get_current_user_id(), 'user_post_wishlist', true)['recettes'];
    $output = '';
    $virgule = '';
    foreach($favoris_items as $item_id => $date_ajout){
        $output .= ($virgule . $item_id);
        $virgule = ', ';
    }

    if($output){
        return $output;
    } else {
        return 'none';
    }
}

// for jetengine query -> get blog article ids on current user wishlist
add_shortcode('listing_favoris_post', 'shortcode_listing_favoris_post');
function shortcode_listing_favoris_post(){
    $favoris_items = get_user_meta(get_current_user_id(), 'user_post_wishlist', true)['post'];
    $output = '';
    $virgule = '';
    foreach($favoris_items as $item_id => $date_ajout){
        $output .= ($virgule . $item_id);
        $virgule = ', ';
    }

    if($output){
        return $output;
    } else {
        return 'none';
    }
}

// for jetengine query -> get specialist ids on current user wishlist
add_shortcode('listing_favoris_specialistes', 'shortcode_listing_favoris_specialistes');
function shortcode_listing_favoris_specialistes(){
    $favoris_items = get_user_meta(get_current_user_id(), 'user_post_wishlist', true)['specialistes'];
    $output = '';
    $virgule = '';
    foreach($favoris_items as $item_id => $date_ajout){
        $output .= ($virgule . $item_id);
        $virgule = ', ';
    }

    if($output){
        return $output;
    } else {
        return 'none';
    }
}

add_shortcode('productExcerpt', 'shortcode_formatProductExcerpt');
function shortcode_formatProductExcerpt(){
    $excerpt = get_the_excerpt();
    
    return $excerpt;
}

// Informations nutritionnelles sur page produit
add_shortcode('informations_nutritionnelles', 'recuperer_informations_nutritionnelles');
function recuperer_informations_nutritionnelles() {

    $energiekj = get_post_meta(get_the_ID(),"energiekj",true);
    $energiekcal = get_post_meta(get_the_ID(),"energiekcal",true);
    $proteines = get_post_meta(get_the_ID(),"proteines",true);
    $glucides = get_post_meta(get_the_ID(),"glucides",true);
    $sucres = get_post_meta(get_the_ID(),"sucres",true);
    $lipides = get_post_meta(get_the_ID(),"lipides",true);
    $graisses = get_post_meta(get_the_ID(),"graisses-sature",true);
    $fibres = get_post_meta(get_the_ID(),"fibres",true);
    $sel = get_post_meta(get_the_ID(),"sel",true);
    

    $informations = [
        'Energie (kJ)' => $energiekj,
        'Energie (kcal)' => $energiekcal,
        'Protéines (g)' => $proteines,
        'Glucides (g)' => $glucides,
        'Glucides dont sucres (g)' => $sucres,
        'Lipides (g)' => $lipides,
        'Lipides dont graisses saturées (g)' => $graisses,
        'Fibres' => $fibres,
        'Sel (g)' => $sel,
    ];
    
    $output = '<table style="width:100%; border-collapse: collapse;">';
    
    foreach ($informations as $nom => $valeur) {
        $output .= '<tr>';
        $output .= "<td style='border-bottom: 0.5px solid #b4b4b4; padding: 8px; text-align: left;'>{$nom}</td>";
        $output .= "<td style='border-bottom: 0.5px solid #b4b4b4; padding: 8px; text-align: left;'>{$valeur}</td>";
        $output .= '</tr>';
    }
    
    $output .= '</table>';
    
    return $output;
}

// shortcode for single product review listing -> show author and city
add_shortcode('product_review_author', 'shortcode_product_comment_ids');
function shortcode_product_comment_ids() {
    $authorID =  get_comment(get_comment_ID())->user_id;
    $authorName = get_comment_author();
    $billing_city = get_user_meta($authorID, 'billing_city', true);

    $output = $authorName;
    if(!empty($billing_city)){
        $output .= ', ' . $billing_city;
    }
    return('<p>' . $output . '</p>');
}

add_shortcode('product_review_overview', 'shortcode_product_review_overview');
function shortcode_product_review_overview() {
    return '
    <span><svg width="91" height="15" viewBox="0 0 91 15" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M11.6247 14.25C11.5632 14.25 11.5017 14.235 11.4455 14.2042L7.49973 12.0525L3.55398 14.2042C3.42798 14.2732 3.27423 14.2635 3.15723 14.1803C3.04023 14.097 2.98098 13.9545 3.00498 13.8127L3.72348 9.50325L0.859984 6.63975C0.760984 6.54075 0.724984 6.39375 0.767734 6.26025C0.810484 6.12675 0.924484 6.02775 1.06323 6.0045L5.37498 5.286L7.16448 1.707C7.22823 1.58025 7.35798 1.5 7.49973 1.5C7.64148 1.5 7.77198 1.58025 7.83498 1.707L9.62448 5.286L13.9362 6.0045C14.075 6.02775 14.189 6.126 14.2317 6.26025C14.2745 6.3945 14.2392 6.54075 14.1395 6.63975L11.276 9.50325L11.9945 13.8127C12.0177 13.9545 11.9585 14.097 11.8422 14.1803C11.7777 14.226 11.7012 14.25 11.6247 14.25ZM7.49973 11.25C7.56123 11.25 7.62348 11.265 7.67898 11.2957L11.1282 13.1768L10.505 9.4365C10.4847 9.31725 10.5237 9.195 10.61 9.1095L13.0947 6.62475L9.31323 5.99475C9.19473 5.97525 9.09348 5.8995 9.03948 5.79225L7.49973 2.71275L5.95998 5.79225C5.90598 5.8995 5.80473 5.9745 5.68623 5.99475L1.90473 6.62475L4.38948 9.1095C4.47498 9.195 4.51398 9.3165 4.49448 9.4365L3.87123 13.1768L7.32048 11.2957C7.37673 11.265 7.43823 11.25 7.49973 11.25Z" fill="#CF6D3F"/>
    <path d="M30.6247 14.25C30.5632 14.25 30.5017 14.235 30.4455 14.2042L26.4997 12.0525L22.554 14.2042C22.428 14.2732 22.2742 14.2635 22.1572 14.1803C22.0402 14.097 21.981 13.9545 22.005 13.8127L22.7235 9.50325L19.86 6.63975C19.761 6.54075 19.725 6.39375 19.7677 6.26025C19.8105 6.12675 19.9245 6.02775 20.0632 6.0045L24.375 5.286L26.1645 1.707C26.2282 1.58025 26.358 1.5 26.4997 1.5C26.6415 1.5 26.772 1.58025 26.835 1.707L28.6245 5.286L32.9362 6.0045C33.075 6.02775 33.189 6.126 33.2317 6.26025C33.2745 6.3945 33.2392 6.54075 33.1395 6.63975L30.276 9.50325L30.9945 13.8127C31.0177 13.9545 30.9585 14.097 30.8422 14.1803C30.7777 14.226 30.7012 14.25 30.6247 14.25ZM26.4997 11.25C26.5612 11.25 26.6235 11.265 26.679 11.2957L30.1282 13.1768L29.505 9.4365C29.4847 9.31725 29.5237 9.195 29.61 9.1095L32.0947 6.62475L28.3132 5.99475C28.1947 5.97525 28.0935 5.8995 28.0395 5.79225L26.4997 2.71275L24.96 5.79225C24.906 5.8995 24.8047 5.9745 24.6862 5.99475L20.9047 6.62475L23.3895 9.1095C23.475 9.195 23.514 9.3165 23.4945 9.4365L22.8712 13.1768L26.3205 11.2957C26.3767 11.265 26.4382 11.25 26.4997 11.25Z" fill="#CF6D3F"/>
    <path d="M49.6247 14.25C49.5632 14.25 49.5017 14.235 49.4455 14.2042L45.4997 12.0525L41.554 14.2042C41.428 14.2732 41.2742 14.2635 41.1572 14.1803C41.0402 14.097 40.981 13.9545 41.005 13.8127L41.7235 9.50325L38.86 6.63975C38.761 6.54075 38.725 6.39375 38.7677 6.26025C38.8105 6.12675 38.9245 6.02775 39.0632 6.0045L43.375 5.286L45.1645 1.707C45.2282 1.58025 45.358 1.5 45.4997 1.5C45.6415 1.5 45.772 1.58025 45.835 1.707L47.6245 5.286L51.9362 6.0045C52.075 6.02775 52.189 6.126 52.2317 6.26025C52.2745 6.3945 52.2392 6.54075 52.1395 6.63975L49.276 9.50325L49.9945 13.8127C50.0177 13.9545 49.9585 14.097 49.8422 14.1803C49.7777 14.226 49.7012 14.25 49.6247 14.25ZM45.4997 11.25C45.5612 11.25 45.6235 11.265 45.679 11.2957L49.1282 13.1768L48.505 9.4365C48.4847 9.31725 48.5237 9.195 48.61 9.1095L51.0947 6.62475L47.3132 5.99475C47.1947 5.97525 47.0935 5.8995 47.0395 5.79225L45.4997 2.71275L43.96 5.79225C43.906 5.8995 43.8047 5.9745 43.6862 5.99475L39.9047 6.62475L42.3895 9.1095C42.475 9.195 42.514 9.3165 42.4945 9.4365L41.8712 13.1768L45.3205 11.2957C45.3767 11.265 45.4382 11.25 45.4997 11.25Z" fill="#CF6D3F"/>
    <path d="M68.6247 14.25C68.5632 14.25 68.5017 14.235 68.4455 14.2042L64.4997 12.0525L60.554 14.2042C60.428 14.2732 60.2742 14.2635 60.1572 14.1803C60.0402 14.097 59.981 13.9545 60.005 13.8127L60.7235 9.50325L57.86 6.63975C57.761 6.54075 57.725 6.39375 57.7677 6.26025C57.8105 6.12675 57.9245 6.02775 58.0632 6.0045L62.375 5.286L64.1645 1.707C64.2282 1.58025 64.358 1.5 64.4997 1.5C64.6415 1.5 64.772 1.58025 64.835 1.707L66.6245 5.286L70.9362 6.0045C71.075 6.02775 71.189 6.126 71.2317 6.26025C71.2745 6.3945 71.2392 6.54075 71.1395 6.63975L68.276 9.50325L68.9945 13.8127C69.0177 13.9545 68.9585 14.097 68.8422 14.1803C68.7777 14.226 68.7012 14.25 68.6247 14.25ZM64.4997 11.25C64.5612 11.25 64.6235 11.265 64.679 11.2957L68.1282 13.1768L67.505 9.4365C67.4847 9.31725 67.5237 9.195 67.61 9.1095L70.0947 6.62475L66.3132 5.99475C66.1947 5.97525 66.0935 5.8995 66.0395 5.79225L64.4997 2.71275L62.96 5.79225C62.906 5.8995 62.8047 5.9745 62.6862 5.99475L58.9047 6.62475L61.3895 9.1095C61.475 9.195 61.514 9.3165 61.4945 9.4365L60.8712 13.1768L64.3205 11.2957C64.3767 11.265 64.4382 11.25 64.4997 11.25Z" fill="#CF6D3F"/>
    <path d="M87.6247 14.25C87.5632 14.25 87.5017 14.235 87.4455 14.2042L83.4997 12.0525L79.554 14.2042C79.428 14.2732 79.2742 14.2635 79.1572 14.1803C79.0402 14.097 78.981 13.9545 79.005 13.8127L79.7235 9.50325L76.86 6.63975C76.761 6.54075 76.725 6.39375 76.7677 6.26025C76.8105 6.12675 76.9245 6.02775 77.0632 6.0045L81.375 5.286L83.1645 1.707C83.2282 1.58025 83.358 1.5 83.4997 1.5C83.6415 1.5 83.772 1.58025 83.835 1.707L85.6245 5.286L89.9362 6.0045C90.075 6.02775 90.189 6.126 90.2317 6.26025C90.2745 6.3945 90.2392 6.54075 90.1395 6.63975L87.276 9.50325L87.9945 13.8127C88.0177 13.9545 87.9585 14.097 87.8422 14.1803C87.7777 14.226 87.7012 14.25 87.6247 14.25ZM83.4997 11.25C83.5612 11.25 83.6235 11.265 83.679 11.2957L87.1282 13.1768L86.505 9.4365C86.4847 9.31725 86.5237 9.195 86.61 9.1095L89.0947 6.62475L85.3132 5.99475C85.1947 5.97525 85.0935 5.8995 85.0395 5.79225L83.4997 2.71275L81.96 5.79225C81.906 5.8995 81.8047 5.9745 81.6862 5.99475L77.9047 6.62475L80.3895 9.1095C80.475 9.195 80.514 9.3165 80.4945 9.4365L79.8712 13.1768L83.3205 11.2957C83.3767 11.265 83.4382 11.25 83.4997 11.25Z" fill="#CF6D3F"/>
    </svg></span>
    <p>150 avis</p>';
}

function shortcode_product_message_membre() {
    $reduction = get_post_meta(get_the_ID(), 'reduction-membre', true);
    $current_user_id = get_current_user_id();
    $query_args = array(
        'posts_per_page' => '-1',
        'post_type' => 'ywcmbs-membership',
        'post_status' => 'publish',
    );
    $the_query = new WP_Query( $query_args );

    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $subscribed_user_id = (get_post_meta(get_the_ID(), '_user_id', true));
            if($current_user_id == $subscribed_user_id){
                $member = true;
            }
        }
        wp_reset_postdata();
    }

    if($member){
        $output = 'Vous êtes membre : -10%';
    } else {
        $output = 'Devenez membre et obtenez -10%';
    }

    return '<p class="listing-product-membre-message">' . $output . '</p>';
}
add_shortcode('product_message_membre', 'shortcode_product_message_membre');

function shortcode_term_main_image(){
    $category_id = get_queried_object_id();
    $image_id = get_woocommerce_term_meta($category_id, 'thumbnail_id', true);
    if ($image_id) {
        $image_url = wp_get_attachment_url($image_id);
    } else {
        $image_url = '/wp-content/uploads/woocommerce-placeholder.png';
    }

    return '<div class="term-main-image-wrapper is-image-wrapper"><img class="term-main-image" src="' . esc_url($image_url) . '" alt="Image de la catégorie"><div class="overlay-darken"></div></div>';
}
add_shortcode('term_main_image', 'shortcode_term_main_image');

function shortcode_query_jet_engine_unique_review() {
    $current_post_id = get_the_ID();
    $query_args = array(
        'post_type' => 'site-review',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
    );

    $queryResult = array();
    
    $the_query = new WP_Query( $query_args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $data = get_post_meta(get_the_ID(), '_submitted');
            if($data){
                $post_reviewed = $data[0]['_post_id'];
                if(empty($post_reviewed)){ // if the review was exported from csv then the column is "assigned_posts"
                    $post_reviewed = $data[0]['assigned_posts'];
                }
                $review_id = get_the_ID();
                if($post_reviewed == $current_post_id){
                    $queryResult[] = $review_id;
                }
            }
            
        }
        wp_reset_postdata();

        if($queryResult){
            return implode(", ", $queryResult);
        } else {
            return "not found";
        }
    }
}
add_shortcode('query_jet_engine_unique_review', 'shortcode_query_jet_engine_unique_review');

function shortcode_review_rating() {
    $data = get_post_meta(get_the_ID(), '_submitted');
    return '<div class="review-count">' . $data[0]['rating'] . '</div>';
}
add_shortcode('review_rating', 'shortcode_review_rating');

function shortcode_review_author(){
    $first_name = get_the_author_meta('display_name');  
    $output = $first_name;
    if (empty($first_name)) { // if no author display name (bc its an import for exemple) get the post title -> mean real review from real user
        $output = get_the_title();  
    } 
    return $output;
}
add_shortcode('review_author', 'shortcode_review_author');


function shortcode_post_average_rating() {
    $current_post_id = get_the_ID();
    $query_args = array(
        'post_type' => 'site-review',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
    );

    $review_rating = array();
    $the_query = new WP_Query( $query_args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $data = get_post_meta(get_the_ID(), '_submitted');
            $post_reviewed = $data[0]['_post_id'];

            if($post_reviewed == $current_post_id){
                $review_rating[] = $data[0]['rating'];
            }
        }
        wp_reset_postdata();

        if($review_rating){
            $sum = array_sum($review_rating);
            $average = $sum / count($review_rating);
            $average = number_format($average, 1);
            return '<span id="post-average-rating">' . $average . '</span>';
        } else {
            return '0 avis';
        }
    }

}
add_shortcode('post_average_rating', 'shortcode_post_average_rating');

function shortcode_review_popup_total_rating() {
    $title = get_the_title();
    $current_post_id = get_the_ID();

    $query_args = array(
        'post_type' => 'site-review',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
    );

    $queryResult = array();
    
    $the_query = new WP_Query( $query_args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $data = get_post_meta(get_the_ID(), '_submitted');
            $post_reviewed = $data[0]['_post_id'];
            $review_id = get_the_ID();
            if($post_reviewed == $current_post_id){
                $queryResult[] = $review_id;
            }
        }
        wp_reset_postdata();

        if($queryResult){
            $totalCount = count($queryResult);
        }
    }

    return 'Tous les avis sur ' . $title . ' (' . $totalCount . ' avis)';
}
add_shortcode('review_popup_total_rating', 'shortcode_review_popup_total_rating');

function shortcode_recette_review_total_rating() {
    $title = get_the_title();
    $current_post_id = get_the_ID();

    $query_args = array(
        'post_type' => 'site-review',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
    );

    $queryResult = array();
    
    $the_query = new WP_Query( $query_args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $data = get_post_meta(get_the_ID(), '_submitted');
            $post_reviewed = $data[0]['_post_id'];
            $review_id = get_the_ID();
            if($post_reviewed == $current_post_id){
                $queryResult[] = $review_id;
            }
        }
        wp_reset_postdata();

        if($queryResult){
            $totalCount = count($queryResult);
        }
    }

    return $totalCount;
}
add_shortcode('recette_review_total_rating', 'shortcode_recette_review_total_rating');



function shortcode_review_post_button() {
    $current_post_id = get_the_ID();
    $current_user = get_current_user_id();
    $query_args = array(
        'post_type' => 'site-review',
        'post_status' => 'any',
        'posts_per_page' => '-1',
    );

    if (get_post_type() == 'recettes'){
        $type = 'sur cette recette.';
    } else if (get_post_type() == 'specialistes'){
        $type = 'sur ce spécialiste.';
    } 

    $reviewed_post_message = '<p class="text__underline letter-spacing-m trigger-review-form">Rédiger un avis ' . $type . '</p>';

    $the_query = new WP_Query( $query_args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $data = get_post_meta(get_the_ID(), '_submitted');
            $post_reviewed = $data[0]['_post_id'];
            $reviewer_id = $data[0]['author_id'];
            $date = $data[0]['author_id'];
            $status = get_post_status(get_the_ID());

            if($status == 'pending'){
                $reviewed_post_message = '<p class="text__underline letter-spacing-m">Merci d\'avoir déposé votre avis. Celui-ci est en cours de vérification.</p>';
                break;
            } else if($post_reviewed == $current_post_id && $reviewer_id == $current_user && $status == 'publish'){
                $reviewed_post_message = '<p class="text__underline letter-spacing-m">Merci d\'avoir déposé votre avis ' . $type . '</p>';
                break;
            } else {
                $reviewed_post_message = '<p class="text__underline letter-spacing-m trigger-review-form">Rédiger un avis ' . $type . '</p>';
            }
        }
        wp_reset_postdata();
    } 
    
    return $reviewed_post_message;
    
}
add_shortcode('review_post_button', 'shortcode_review_post_button');


function shortcode_membership_price() {
    $current_user_id = get_current_user_id();
    // $query_args = array(
    //     'posts_per_page' => '-1',
    //     'post_type' => 'ywcmbs-membership',
    //     'post_status' => 'publish',
    // );
    // $the_query = new WP_Query( $query_args );

    // if ( $the_query->have_posts() ) {
    //     while ( $the_query->have_posts() ) {
    //         $the_query->the_post();
    //         $subscribed_user_id = (get_post_meta(get_the_ID(), '_user_id', true));
    //         if($current_user_id == $subscribed_user_id){
    //             $member = true;
    //         }
    //     }
    //     wp_reset_postdata();
    // }

    // $product = new WC_Product( get_the_ID() );
    // $price = $product->get_price();
    // return wc_price($price);
}
add_shortcode('membership_price', 'shortcode_membership_price');

function shortcode_membership_recette_or_not() {
    $terms = wp_get_post_terms(get_the_ID(), 'type-de-recette');
    if (!empty($terms)) {
        foreach ($terms as $term) {
            if ($term->slug === 'abonnement') {
                return '<div class="exclu-membre-overlay-wrapper"><div class="exclu-membre-text-wrapper"><svg width="20" height="26" viewBox="0 0 20 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.75 9H17V6.75C17 3.0285 13.9715 0 10.25 0C6.5285 0 3.5 3.0285 3.5 6.75V9H2.75C1.5095 9 0.5 10.0095 0.5 11.25V23.25C0.5 24.4905 1.5095 25.5 2.75 25.5H17.75C18.9905 25.5 20 24.4905 20 23.25V11.25C20 10.0095 18.9905 9 17.75 9ZM5 6.75C5 3.855 7.355 1.5 10.25 1.5C13.145 1.5 15.5 3.855 15.5 6.75V9H5V6.75ZM18.5 23.25C18.5 23.664 18.164 24 17.75 24H2.75C2.336 24 2 23.664 2 23.25V11.25C2 10.836 2.336 10.5 2.75 10.5H17.75C18.164 10.5 18.5 10.836 18.5 11.25V23.25Z" fill="white"/></svg><p class="text-exclu-membre">Exclusivité membre</p></div><div class="exclu-membre-overlay"></div></div>';
            }
        }
    }
}
add_shortcode('membership_recette_or_not', 'shortcode_membership_recette_or_not');


function shortcode_product_review_form_button() {
    $user_id = get_current_user_id();
    $current_product_id = get_the_ID();

    $orders = wc_get_orders(array(
        'customer' => $user_id,
        'status'   => array('completed')
    ));
    foreach ($orders as $order) {
        $items = $order->get_items();
        foreach ($items as $item) {

            if ($item->get_product_id() == $current_product_id) {
                $date_achat = $order->get_date_completed();
                $format_date_achat = $date_achat->date_i18n('j F Y');
            }
        }
    }

    if ($date_achat) {
        return '<div><p class="text__underline letter-spacing-m trigger-review-form">Vous avez acheté ce produit le ' . $format_date_achat . '. Souhaitez-vous rédiger un avis ?</p></div>';
    } 
}
add_shortcode('product_review_form_button', 'shortcode_product_review_form_button');

function shortcode_specialisation_complementaires() {
    $output = '';
    $spe = get_post_meta(get_the_id(), 'specialisations-complementaires', true);
    if($spe){
        $output .= '<div class="specialiste-badge-items is-tags-container">';
        foreach($spe as $value => $bool){
            if($bool == 'true'){
                $output .= '<span class="specialiste-badge is-tag">' . $value . '</span>';
            }
        }
        $output .= '</div>';
    }
    return $output;
}
add_shortcode('specialisation_complementaires', 'shortcode_specialisation_complementaires');

function shortcode_specialiste_booking_button() {
    $link = get_post_meta(get_the_id(), 'old-booking-page-url', true);
    return '
    <div class="wp-block-button specialiste-book-button">
        <a href="'. $link .'" class="wp-block-button__link wp-element-button" rel="nofollow" target="_blank">Je book maintenant</a>
    </div>';
}
add_shortcode('specialiste_booking_button', 'shortcode_specialiste_booking_button');

