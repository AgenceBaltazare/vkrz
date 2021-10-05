<?php
global $user_id;
global $uuiduser;
global $id_vainkeur;
global $id_ranking;
global $id_top;
global $is_next_duel;
global $top_infos;
global $utm;
global $user_infos;
global $user_tops;
$user_id       = get_user_logged_id();
$utm           = deal_utm();
$id_top        = get_the_ID();
$user_tops     = get_user_tops();
$uuiduser      = deal_uuiduser();
$user_infos    = deal_vainkeur_entry();
$id_vainkeur   = $user_infos['id_vainkeur'];
if ($id_vainkeur) {
    $current_id_vainkeur = $id_vainkeur;
}
$id_ranking    = get_user_ranking_id($id_top, $uuiduser);
if ($id_ranking) {
    extract(get_next_duel($id_ranking, $id_top, $current_id_vainkeur));
    if (!$is_next_duel) {
        wp_redirect(get_the_permalink($id_ranking));
    }
}
get_header();
$top_datas          = get_top_data($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
?>

<div class="content_marqueblanche">
    <div class="row">
        <div class="col-2 logo_marqueblanche">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/logo-gdp.png" alt="">
        </div>
        <div class="col-8 content_top">
            <div class="bouton_start">
                <p>
                    Génère ton classement Germaine des prés !
                </p>
            </div>
            <h2>
                Quelle culotte préfères-tu ?
            </h2>
            <div class="row align-items-center">
                <div class="col-5 produit">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/2.png" alt="">
                    <p>
                        Germaine fushia/orange
                    </p>
                </div>
                <div class="col-2 versus">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/versus.svg" alt="">
                </div>
                <div class="col-5 produit">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/2.png" alt="">
                    <p>
                        Germaine céladon/lilas
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<?php get_footer(); ?>