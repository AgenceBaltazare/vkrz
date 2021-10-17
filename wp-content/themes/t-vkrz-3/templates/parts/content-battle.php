<?php extract($battle_vars); ?>
<div class="row align-items-center contenders-containers justify-content-center battle-marqueblanche">
    <div class="col-sm-5 col-12 bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
        <div class="contender_zone animate__animated animate__slideInDown" data-id-winner="<?= $contender_1 ?>" data-id-looser="<?= $contender_2 ?>" data-id-top="<?= $id_top ?>" data-id-ranking="<?= $id_ranking ?>" id="c_1">
            <?php if (get_field('visuel_cover_t', $id_top)) : ?>
                <?php $illu = get_the_post_thumbnail_url($contender_1, 'full'); ?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
            <?php else : ?>
                <?php echo get_the_post_thumbnail($contender_1, 'full', array('class' => 'img-fluid')); ?>
            <?php endif; ?>
            <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_top)) : ?>
                <?php if(get_field('marqueblanche_t', $id_top)): ?>
                    <h2 class="title-contender-marqueblanche">
                        <?php echo get_the_title($contender_1); ?>
                    </h2>
                <?php else: ?>
                    <h2 class="title-contender">
                        <?php echo get_the_title($contender_1); ?>
                    </h2>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-2">
        <?php if (isset($nb_user_votes) && $nb_user_votes != "") : ?>
            <?php if(!get_field('marqueblanche_t', $id_top)): ?>
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
            <?php else: ?>
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
        <?php if(get_field('marqueblanche_t', $id_top)): ?>
            <h4 class="text-center versus-marqueblanche">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/versus.svg" alt="" class="img-fluid">
            </h4>
        <?php else: ?>
            <h4 class="text-center versus">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/vainkeurz-eclair.svg" alt="" class="img-fluid">
            </h4>
        <?php endif; ?>
    </div>

    <div class="col-sm-5 col-12 bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
        <div class="contender_zone animate__animated animate__slideInUp" data-id-winner="<?= $contender_2 ?>" data-id-looser="<?= $contender_1 ?>" data-id-top="<?= $id_top ?>" data-id-ranking="<?= $id_ranking ?>" id="c_2">
            <?php if (get_field('visuel_cover_t', $id_top)) : ?>
                <?php $illu = get_the_post_thumbnail_url($contender_2, 'full'); ?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
            <?php else : ?>
                <?php echo get_the_post_thumbnail($contender_2, 'full', array('class' => 'img-fluid')); ?>
            <?php endif; ?>
            <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_top)) : ?>
                <?php if(get_field('marqueblanche_t', $id_top)): ?>
                    <h2 class="title-contender-marqueblanche">
                        <?php echo get_the_title($contender_2); ?>
                    </h2>
                <?php else: ?>
                    <h2 class="title-contender">
                        <?php echo get_the_title($contender_2); ?>
                    </h2>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>