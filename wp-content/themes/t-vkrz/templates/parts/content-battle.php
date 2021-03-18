<?php extract( $battle_vars ); ?>
<div class="row align-items-center contenders-containers">
    <div class="col-5 bloc-contenders link-contender_1 contender_1 link-contender">
        <a href="#"
           data-id-winner="<?= $contender_1 ?>"
           data-id-looser="<?= $contender_2?>"
           data-id-tournament="<?= $id_tournament ?>"
           id="c_1"
        >
            <?php
            echo get_the_post_thumbnail( $contender_1, 'full', array( 'class' => 'img-fluid' ) );
            ?>
            <h2 class="title-contender">
                <?php echo get_the_title( $contender_1 ); ?>
            </h2>
        </a>
    </div>

    <div class="col-2">
        <div class="display_votes">
            <h6>
				<?php echo $all_votes_counts; ?> votes
            </h6>
        </div>
        <h4 class="text-center versus">
            VS
        </h4>
    </div>

    <div class="col-5 bloc-contenders link-contender_2 contender_2 link-contender">
        <a href="#"
           data-id-winner="<?= $contender_2 ?>"
           data-id-looser="<?= $contender_1 ?>"
           data-id-tournament="<?= $id_tournament ?>"
           id="c_2"
        >
            <?php
            echo get_the_post_thumbnail( $contender_2, 'full', array( 'class' => 'img-fluid' ) );
            ?>
            <h2 class="title-contender">
                <?php echo get_the_title( $contender_2 ); ?>
            </h2>
        </a>
    </div>
</div>
