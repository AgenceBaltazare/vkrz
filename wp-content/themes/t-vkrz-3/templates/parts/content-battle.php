<?php extract( $battle_vars );
global $champion_id;
$champion_info = get_userdata($champion_id);

?>

<div class="row align-items-center contenders-containers justify-content-center">
    <div class="col-sm-5 col-6 bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
        <div class="contender_zone animate__animated animate__slideInDown"
           data-id-winner="<?= $contender_1 ?>"
           data-id-looser="<?= $contender_2 ?>"
           data-id-tournament="<?= $id_tournament ?>" data-id-ranking="<?= $id_ranking ?>"
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
                    <h1 id="count1" class="twitch_vote">Taper 1</h1>
                </h2>

            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-2 d-none d-sm-block">
        <?php if(isset($nb_user_votes) && $nb_user_votes != ""): ?>
            <div class="display_votes">
                <h6>
                    <?php if ($nb_user_votes == 0) : ?>
                        Aucun vote encore
                    <?php elseif ($nb_user_votes == 1) : ?>
                        Bravo pour ton 1er vote
                    <?php else : ?>
                        Tes votes : <?php echo $nb_user_votes; ?>
                    <?php endif; ?>
                </h6>
            </div>
        <?php endif; ?>
        <h4 class="text-center versus">
            VS
        </h4>
    </div>

    <div class="col-sm-5 col-6 bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
        <div class="contender_zone animate__animated animate__slideInUp"
           data-id-winner="<?= $contender_2 ?>"
           data-id-looser="<?= $contender_1 ?>"
           data-id-tournament="<?= $id_tournament ?>" data-id-ranking="<?= $id_ranking ?>"
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
                    <h1 id="count2" class="twitch_vote">Taper 2</h1>
                </h2>
            <?php endif; ?>
        </div>
    </div>
</div>
<button type="button" onclick="clear_click()" class="btn btn-secondary twitch_vote" >Reset</button>
<button type="button" onclick="stop_count()" class="btn btn-primary twitch_vote" id="twitch_vote">Mettre fin au vote</button>
