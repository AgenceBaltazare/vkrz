<?php if(is_home()): ?>

    <title>
        🔥 VAINKEURZ 👉 Créer et partage tes Tops !
    </title>
    <meta name="description" content="Meilleur site de la galaxie d'après la NASA pour faire ses Tops." />
    <meta property="og:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/share/share_vkrz_banner.jpg" />
    <meta property="og:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
    <meta property="og:description" content="Meilleur site de la galaxie d'après la NASA pour faire ses Tops." />
    <meta property="og:url" content="https://vainkeurz.com/" />
    <meta name="twitter:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
    <meta name="twitter:description" content="Meilleur site de la galaxie d'après la NASA pour faire ses Tops." />
    <meta name="twitter:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/share/share_vkrz_banner.jpg" />

<?php elseif(is_single() && get_post_type() == "tournoi"): ?>

    <?php
        global $top_infos;
        global $id_top;
        global $id_ranking;
        $top_infos = get_top_infos($id_top);
    ?>
    <title>
        TOP <?php echo $top_infos['top_number']; ?> : <?php echo $top_infos['top_title']; ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="<?php echo $top_infos['top_title']; ?> : <?php echo $top_infos['top_question']; ?>" />
    <link rel="canonical" href="<?php echo $top_infos['top_url']; ?>" />
    <meta property="og:image" content="<?php echo $top_infos['top_img']; ?>" />
    <meta property="og:title" content="TOP <?php echo $top_infos['top_number']; ?> : <?php echo $top_infos['top_title']; ?>" />
    <meta property="og:description" content="<?php echo $top_infos['top_question']; ?>" />
    <meta property="og:url" content="<?php echo $top_infos['top_url']; ?>" />
    <meta name="twitter:title" content="TOP <?php echo $top_infos['top_number']; ?> - <?php echo $top_infos['top_title']; ?>" />
    <meta name="twitter:description" content="<?php echo $top_infos['top_question']; ?>" />
    <meta name="twitter:image" content="<?php echo $top_infos['top_img']; ?>" />

<?php elseif(is_single() && get_post_type() == "classement"): ?>

    <?php
    global $top_infos;
    global $id_top;
    global $id_ranking;
    $id_ranking    = get_the_ID();
    $id_top        = get_field('id_tournoi_r');
    $top_infos     = get_top_infos($id_top, $id_ranking);
    ?>
    <title>
        TOP <?php echo $top_infos['top_number']; ?> : <?php echo $top_infos['top_title']; ?> - <?php the_field( 'question_t', $id_top ); ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="Découvre mon TOP <?php echo $top_infos['top_number']; ?> à propos de <?php echo $top_infos['top_title']; ?>" />

    <?php
    $user_top3  = get_user_ranking($id_ranking);
    $l=1;
    foreach($user_top3 as $top => $p) {

        if ($l == 1) {
            $picture_contender_1 = get_the_post_thumbnail_url($top, 'medium');
            $name_contender_1    = get_the_title($top);
        } elseif ($l == 2) {
            $picture_contender_2 = get_the_post_thumbnail_url($top, 'medium');
            $name_contender_2    = get_the_title($top);
        } elseif ($l == 3) {
            $picture_contender_3 = get_the_post_thumbnail_url($top, 'medium');
            $name_contender_3    = get_the_title($top);
        }

        $l++; if($l==4) break;
    }
    if($top_infos['top_number'] < 3){
        $api_key = "3I6bGZa3zyHsiZL2toeoagtt";
        $base = "https://on-demand.bannerbear.com/signedurl/nYaKxNMeoDRVW9BXPl/image.jpg";
        $modifications = '[{"name":"h1","text":"TOP '.$top_infos['top_number'].' '.$top_infos['top_title'].'"},{"name":"h2","text":"Voici mon Top 2 👉"},{"name":"h1-question","text":"'.$top_infos['top_question'].'"}, {"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"}]';
    }
    else{
        $api_key    = "3I6bGZa3zyHsiZL2toeoagtt";
        $base       = "https://on-demand.bannerbear.com/signedurl/LR7D41MVLLPVB8OGab/image.jpg";
        $modifications = '[{"name":"background","image_url":"'.$top_infos['top_cover'].'"},{"name":"h1-2","text":"TOP '.$top_infos['top_number'].' '.$top_infos['top_title'].'"},{"name":"h1","text":"TOP '.$top_infos['top_number'].' '.$top_infos['top_title'].'"},{"name":"h2","text":"VOICI MON TOP 3 👉"},{"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"contenders_3","image_url":"'.$picture_contender_3.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"},{"name":"3","text":"🥉 '.$name_contender_3.'"},{"name":"h1-question-2","text":"'.$top_infos['top_question'].'"},{"name":"h1-question","text":"'.$top_infos['top_question'].'"}]';
    }
    $query = "?modifications=" . rtrim(strtr(base64_encode($modifications), '+/', '-_'), '=');
    $signature = hash_hmac('sha256', $base.$query, $api_key);
    $banner = $base . $query."&s=" . $signature;
    ?>

    <link rel="canonical" href="<?php echo get_the_permalink($id_ranking); ?>" />
    <meta property="og:image" content="<?php echo $banner; ?>" />
    <meta property="og:title" content="TOP <?php echo $top_infos['top_number']; ?> 🏆 <?php echo $top_infos['top_title']; ?> - <?php echo $top_infos['top_question']; ?>" />
    <meta property="og:description" content="Découvre mon Top et fais ton propre classement !" />
    <meta property="og:url" content="<?php echo get_the_permalink($id_ranking); ?>" />
    <meta name="twitter:title" content="TOP <?php echo $top_infos['top_number']; ?> 🏆 <?php echo $top_infos['top_title']; ?> - <?php echo $top_infos['top_question']; ?>" />
    <meta name="twitter:description" content="Découvre mon Top et fais ton propre classement !" />
    <meta name="twitter:image" content="<?php echo $banner; ?>" />

<?php elseif(is_page(get_page_by_path('elo'))): ?>

    <?php 
    global $top_infos;
    $id_top     = $_GET['id_top'];
    $top_infos  = get_top_infos($id_top);
    ?>
    <title>
        Top mondial 🌎  <?php echo $top_infos['top_title']; ?> - <?php echo $top_infos['top_question']; ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="Classement ELO du tournoi rassemblant les votes du monde entier." />

<?php elseif(is_page(get_page_by_path('liste-des-tops'))): ?>

    <?php 
    global $top_infos;
    $id_top     = $_GET['id_top'];
    $top_infos  = get_top_infos($id_top);
    ?>
    <title>
        Tous les Tops 👉 <?php echo $top_infos['top_title']; ?> - <?php echo $top_infos['top_question']; ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="Découvre tous les Tops générés sur VAINKEURZ" />

<?php elseif(is_archive() && !is_author()): ?>

    <?php
    global $current_cat;
    global $cat_name;
    global $cat_id;
    $current_cat = get_queried_object();
    $cat_name    = $current_cat->name;
    $cat_id      = $current_cat->term_id;
    ?>
    <title>
        Tous les Tops <?php echo $cat_name; ?> <?php the_field('icone_cat', 'term_'.$cat_id); ?> sur VAINKEURZ
    </title>
    <meta name="description" content="<?php echo $current_cat->description; ?>" />

<?php elseif(is_author()): ?>

    <?php
    global $vainkeur_id;
    global $vainkeur_info;
    global $vainkeur_tops;
    $vainkeur            = get_user_by('slug', get_query_var('author_name'));
    $vainkeur_id         = $vainkeur->ID;
    if(is_user_logged_in() && env() != "local") {
        if (false === ( $vainkeur_tops = get_transient( 'user_'.$vainkeur_id.'_get_user_tops' ) )) {
            $vainkeur_tops   = get_user_tops($vainkeur_id);
            set_transient( 'user_'.$user_id.'_get_user_tops', $vainkeur_tops, DAY_IN_SECONDS );
        } else {
            $vainkeur_tops = get_transient( 'user_'.$vainkeur_id.'_get_user_tops' );
        }
    } 
    else {
        $vainkeur_tops   = get_user_tops($vainkeur_id);
    }
    $vainkeur_info       = deal_vainkeur_entry($vainkeur_id);
    ?>
    <title>
        Profil de <?php echo $vainkeur_info['pseudo']; ?> sur VAINKEURZ
    </title>
    <link rel="canonical" href="<?php echo get_author_posts_url($vainkeur_id); ?>" />
    <meta name="description" content="Tous les Tops de <?php echo $vainkeur_info['pseudo']; ?> et ses statistiques." />
    <meta property="og:image" content="<?php echo $vainkeur_info['avatar']; ?> ?>" />
    <meta property="og:title" content="Profil VAINKEURZ de <?php echo $vainkeur_info['pseudo']; ?>" />
    <meta property="og:description" content="Tous les Tops de <?php echo $vainkeur_info['pseudo']; ?> et ses statistiques." />
    <meta property="og:url" content="<?php echo get_author_posts_url($vainkeur_id); ?>" />
    <meta name="twitter:title" content="Profil VAINKEURZ de <?php echo $vainkeur_info['pseudo']; ?>" />
    <meta name="twitter:description" content="Tous les Tops de <?php echo $vainkeur_info['pseudo']; ?> et ses statistiques." />
    <meta name="twitter:image" content="<?php echo $vainkeur_info['avatar']; ?>" />

<?php elseif(is_page()): ?>

    <title>
        <?php
            if(get_field('titre_seo')){
                the_field('titre_seo');
            }
            else{
                the_title();
            }
        ?>
    </title>
    <meta name="description" content="
        <?php
        if(get_field('description_seo')){
            the_field('description_seo');
        }
        else{
            the_excerpt();
        }
        ?>
    "/>

<?php else: ?>

    <title>
        VAINKEURZ 🔥
    </title>

<?php endif; ?>