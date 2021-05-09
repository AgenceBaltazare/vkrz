<?php extract( $battle_vars ); ?>
<div class="row align-items-center contenders-containers justify-content-center">
    <div class="col-sm-5 col-6 bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
        <div class="contender_zone animate__animated"
           data-id-winner="<?= $contender_1 ?>"
           data-id-looser="<?= $contender_2?>"
           data-id-tournament="<?= $id_tournament ?>"
           id="c_1"
        >
            <?php if(get_field('visuel_cover_t', $id_tournament)): ?>
                <?php $illu = get_the_post_thumbnail_url( $contender_1, 'full' ); ?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
            <?php else: ?>
                <?php echo get_the_post_thumbnail( $contender_1, 'full', array( 'class' => 'img-fluid' ) ); ?>
            <?php endif; ?>
            <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_tournament)): ?>
                <h2 class="title-contender">
                    <?php echo get_the_title( $contender_1 ); ?>
                </h2>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-2 d-none d-sm-block">
        <?php if(isset($nb_user_votes) && $nb_user_votes != ""): ?>
            <div class="display_votes">
                <h6>
                    <?php if($nb_user_votes == 1): ?>
                        <?php echo $nb_user_votes; ?> vote
                    <?php else: ?>
                        <?php echo $nb_user_votes; ?> votes
                    <?php endif; ?>
                </h6>
            </div>
        <?php endif; ?>
        <h4 class="text-center versus">
            VS
        </h4>
    </div>

    <div class="col-sm-5 col-6 bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
        <div class="contender_zone animate__animated"
           data-id-winner="<?= $contender_2 ?>"
           data-id-looser="<?= $contender_1 ?>"
           data-id-tournament="<?= $id_tournament ?>"
           id="c_2"
        >
            <?php if(get_field('visuel_cover_t', $id_tournament)): ?>
                <?php $illu = get_the_post_thumbnail_url( $contender_2, 'full' ); ?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
            <?php else: ?>
                <?php echo get_the_post_thumbnail( $contender_2, 'full', array( 'class' => 'img-fluid' ) ); ?>
            <?php endif; ?>
            <?php if (!get_field('ne_pas_afficher_les_titres_t', $id_tournament)): ?>
                <h2 class="title-contender">
                    <?php echo get_the_title( $contender_2 ); ?>
                </h2>
            <?php endif; ?>
        </div>
    </div>
</div>
