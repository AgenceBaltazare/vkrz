<?php
global $type_top;
extract($battle_vars);
?>
<div class="row align-items-center justify-content-center contenders-containers battle-marqueblanche">
    <div class="col-sm-5 col-12">
        <div class="bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
            <div class="contender_zone animate__animated animate__slideInDown" data-id-winner="<?= $contender_1 ?>" data-id-looser="<?= $contender_2 ?>" data-id-top="<?= $id_top ?>" data-id-ranking="<?= $id_ranking ?>" id="c_1">
                <?php if (get_field('visuel_cover_t', $id_top)) : ?>
                    <?php $illu = get_the_post_thumbnail_url($contender_1, 'full'); ?>
                    <div class="cov-illu contender-1-votes-twitch" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                <?php else : ?>
                    <?php if (get_field('visuel_instagram_contender', $contender_1)) : ?>
                        <img src="<?php the_field('visuel_instagram_contender', $contender_1); ?>" alt="" class="img-fluid contender-1-votes-twitch">
                    <?php else : ?>
                        <?php echo get_the_post_thumbnail($contender_1, 'full', array('class' => 'img-fluid contender-1-votes-twitch')); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_top)) : ?>
                    <h2 id="contender-1" class="title-contender">
                        <?php echo get_the_title($contender_1); ?>
                    </h2>
                <?php endif; ?>
            </div>
        </div>
        <?php if (get_field('lien_vers_contender', $contender_1)) : ?>
            <div class="next-bloc next-bloc1">
                <a href="<?php the_field('lien_vers_contender', $contender_1); ?>" class="seemore" target="_blank">
                    <?php if (get_field('choix_de_licone_contender', $contender_1) == "shop") : ?>
                        Acheter
                    <?php elseif (get_field('choix_de_licone_contender', $contender_1) == "info") : ?>
                        Découvrir
                    <?php endif; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-sm-2">
        <?php if (isset($nb_user_votes) && $nb_user_votes != "") : ?>
            <?php if (!get_field('marqueblanche_t', $id_top)) : ?>
                <div class="display_votes d-none d-sm-block">
                    <h6>
                        <?php if ($nb_user_votes == 0) : ?>
                            Aucun vote encore
                        <?php elseif ($nb_user_votes == 1) : ?>
                            🖖 1er vote
                        <?php else : ?>
                            <?php echo $nb_user_votes; ?> votes
                        <?php endif; ?>
                    </h6>
                </div>
            <?php else : ?>
                <div class="display_votes d-none d-sm-block">
                    <h6 class="txt_votes_marqueblanche">
                        <?php if ($nb_user_votes == 0) : ?>
                            Aucun vote encore
                        <?php elseif ($nb_user_votes == 1) : ?>
                            🖖 1er vote
                        <?php else : ?>
                            <?php echo $nb_user_votes; ?> votes
                        <?php endif; ?>
                    </h6>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (get_field('versus_t_sponso', $id_top)) : ?>
            <h4 class="text-center versus">
                <?php echo wp_get_attachment_image(get_field('versus_t_sponso', $id_top), 'large', '', array('class' => 'img-fluid')); ?>
            </h4>
        <?php else : ?>
            <h4 class="text-center versus">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/vainkeurz-eclair.svg" alt="" class="img-fluid">
            </h4>
        <?php endif; ?>
    </div>

    <div class="col-sm-5 col-12">
        <div class="bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
            <div class="contender_zone animate__animated animate__slideInUp" data-id-winner="<?= $contender_2 ?>" data-id-looser="<?= $contender_1 ?>" data-id-top="<?= $id_top ?>" data-id-ranking="<?= $id_ranking ?>" id="c_2">
                <?php if (get_field('visuel_cover_t', $id_top)) : ?>
                    <?php $illu = get_the_post_thumbnail_url($contender_2, 'full'); ?>
                    <div class="cov-illu contender-2-votes-twitch" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                <?php else : ?>
                    <?php if (get_field('visuel_instagram_contender', $contender_2)) : ?>
                        <img src="<?php the_field('visuel_instagram_contender', $contender_2); ?>" alt="" class="img-fluid contender-2-votes-twitch">
                    <?php else : ?>
                        <?php echo get_the_post_thumbnail($contender_2, 'full', array('class' => 'img-fluid contender-2-votes-twitch')); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_top)) : ?>
                    <h2 id="contender-2" class="title-contender">
                        <?php echo get_the_title($contender_2); ?>
                    </h2>
                <?php endif; ?>
            </div>
        </div>
        <?php if (get_field('lien_vers_contender', $contender_2)) : ?>
            <div class="next-bloc next-bloc2">
                <a href="<?php the_field('lien_vers_contender', $contender_2); ?>" class="seemore" target="_blank">
                    <?php if (get_field('choix_de_licone_contender', $contender_2) == "shop") : ?>
                        Acheter
                    <?php elseif (get_field('choix_de_licone_contender', $contender_2) == "info") : ?>
                        Découvrir
                    <?php endif; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
