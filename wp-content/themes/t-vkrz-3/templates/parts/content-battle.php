<?php
global $top_title;
global $top_question;
global $uuiduser;
global $user_id;
global $id_tournament;
global $utm;
$utm = deal_utm();
global $typetop;
$list_cat = get_the_terms($id_tournament, 'categorie');
foreach($list_cat as $cat ) {
    $cat_name   = $cat->name;
}
?>
<script>
    const top_title_layer  = "<?php echo $top_title; ?>";
    const top_question_layer  = "<?php echo $top_question; ?>";
    const top_categorie_layer  = "<?php echo $cat->name; ?>";
    const top_id_top_layer  = "<?php echo $id_tournament; ?>";
    const top_uuiduser_layer  = "<?php echo $uuiduser; ?>";
    const top_id_user_layer  = "<?php echo $user_id;; ?>";
    const top_type__layer  = "<?php echo $typetop; ?>";
    const top_utm__layer  = "<?php echo $utm; ?>";
</script>
<?php extract( $battle_vars ); ?>
<div class="row align-items-center contenders-containers justify-content-center">
    <div class="col-sm-5 col-6 bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
        <div class="contender_zone animate__animated animate__slideInDown"
           data-id-winner="<?= $contender_1 ?>"
           data-id-looser="<?= $contender_2 ?>"
           data-id-tournament="<?= $id_tournament ?>" data-id-ranking="<?= $id_ranking ?>" id="c_1">
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
           id="c_2">
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
