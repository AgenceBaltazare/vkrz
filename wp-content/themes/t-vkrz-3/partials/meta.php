<?php if(is_home()): ?>

    <title>
        🔥 VAINKEURZ 👉 Créer et partage tes Tops !
    </title>
    <meta name="description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />
    <meta property="og:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo_twitter.png" />
    <meta property="og:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
    <meta property="og:description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />
    <meta property="og:url" content="https://vainkeurz.com/" />
    <meta name="twitter:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
    <meta name="twitter:description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />
    <meta name="twitter:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo_twitter.png" />

<?php elseif(is_single() && get_post_type() == "tournoi"): ?>

    <?php
    global $id_tournament;
    global $top_url;
    global $top_title;
    global $top_question;
    global $top_img;
    global $top_number;
    $id_tournament = get_the_ID();
    $top_url       = get_the_permalink($id_tournament);
    $top_title     = get_the_title($id_tournament);
    $top_question  = get_field('question_t', $id_tournament);
    $top_img       = get_the_post_thumbnail_url($id_tournament, 'large');
    $top_number    = get_numbers_of_contenders($id_tournament);
    ?>
    <title>
        TOP <?php echo $top_number; ?> : <?php echo $top_title; ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="<?php echo $top_title; ?> : <?php echo $top_question; ?>" />

    <link rel="canonical" href="<?php echo $top_url; ?>" />
    <meta property="og:image" content="<?php echo $top_img; ?>" />
    <meta property="og:title" content="TOP <?php echo $top_number; ?> : <?php echo $top_title; ?>" />
    <meta property="og:description" content="<?php echo $top_question; ?>" />
    <meta property="og:url" content="<?php echo $top_url; ?>" />
    <meta name="twitter:title" content="TOP <?php echo $top_number; ?> - <?php echo $top_title; ?>" />
    <meta name="twitter:description" content="<?php echo $top_question; ?>" />
    <meta name="twitter:image" content="<?php echo $top_img; ?>" />

<?php elseif(is_single() && get_post_type() == "classement"): ?>

    <?php
    global $id_tournament;
    global $top_number;
    global $id_ranking;
    global $top_url;
    global $top_title;
    global $top_question;
    global $top_img;
    global $top_number;
    $id_ranking    = get_the_ID();
    $id_tournament = get_field('id_tournoi_r');
    $top_url       = get_the_permalink($id_tournament);
    $top_title     = get_the_title($id_tournament);
    $top_question  = get_field('question_t', $id_tournament);
    $top_img       = get_the_post_thumbnail_url($id_tournament, 'large');
    $top_number    = get_numbers_of_contenders($id_tournament);
    ?>
    <title>
        TOP <?php echo $top_number; ?> : <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="Découvre mon TOP <?php echo $top_number; ?> à propos de <?php echo get_the_title($id_tournament); ?>" />

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
    if($top_number < 3){
        $api_key = "3I6bGZa3zyHsiZL2toeoagtt";
        $base = "https://on-demand.bannerbear.com/signedurl/nYaKxNMeoDRVW9BXPl/image.jpg";
        $modifications = '[{"name":"h1","text":"TOP '.$top_number.' '.$top_title.'"},{"name":"h2","text":"Voici mon Top 2 👉"},{"name":"h1-question","text":"'.$top_question.'"}, {"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"}]';
    }
    else{
        $api_key    = "3I6bGZa3zyHsiZL2toeoagtt";
        $base       = "https://on-demand.bannerbear.com/signedurl/LR7D41MVLLPVB8OGab/image.jpg";
        $modifications = '[{"name":"h1","text":"TOP '.$top_number.' '.$top_title.'"},{"name":"h2","text":"Voici mon Top 3 👉"},{"name":"h1-question","text":"'.$top_question.'"}, {"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"contenders_3","image_url":"'.$picture_contender_3.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"},{"name":"3","text":"🥉 '.$name_contender_3.'"}]';
    }
    $query = "?modifications=" . rtrim(strtr(base64_encode($modifications), '+/', '-_'), '=');
    $signature = hash_hmac('sha256', $base.$query, $api_key);
    $banner = $base . $query."&s=" . $signature;
    ?>

    <link rel="canonical" href="<?php echo $top_url; ?>" />
    <meta property="og:image" content="<?php echo $banner; ?>" />
    <meta property="og:title" content="TOP <?php echo $top_number; ?> 🏆 <?php echo $top_title; ?> - <?php echo $top_question; ?>" />
    <meta property="og:description" content="Découvre mon Top complet et fais ton propre classement !" />
    <meta property="og:url" content="<?php echo $top_url; ?>" />
    <meta name="twitter:title" content="TOP <?php echo $top_number; ?> 🏆 <?php echo $top_title; ?> - <?php echo $top_question; ?>" />
    <meta name="twitter:description" content="Découvre mon Top complet et fais ton propre classement !" />
    <meta name="twitter:image" content="<?php echo $banner; ?>" />

<?php elseif(is_page(get_page_by_path('elo'))): ?>

    <?php $id_tournament = $_GET['id_top']; ?>
    <title>
        Classement mondial 👉 <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
    </title>
    <meta name="description" content="Classement ELO du tournoi rassemblant les votes du monde entier." />

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
    global $champion;
    ?>
    <title>
        Profil de <?php echo $champion->display_name; ?> sur VAINKEURZ
    </title>
    <meta name="description" content="Tous les TOPs de ce champion et ses statistiques" />

<?php else: ?>

    <title>
        VAINKEURZ 🔥
    </title>

<?php endif; ?>