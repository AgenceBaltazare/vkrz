<?php
extract($current_user_ranking_var);
$current_user_ranking = get_current_user_ranking($id_ranking);
$list_contenders      = get_field('ranking_r', $id_ranking);
$nb_contenders        = count($list_contenders);
?>
<div class="current_ranking">
    <div class="demo-inline-spacing">
        <div class="avatar-group">
        <?php
            for($j=1; $j<=$nb_contenders; $j++){

                $do_place             = false;

                foreach($current_user_ranking as $contender) :

                    if($contender['place'] == $j) : ?>

                        <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title($contender['id_wp']); ?>" class="avatar pull-up">
                            <?php $illu = get_the_post_thumbnail_url($contender['id_wp'], 'full'); ?>
                            <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                        </div>

                        <?php $do_place = true; ?>

                    <?php endif;

                endforeach; ?>


                <?php if($do_place == false): ?>
                    <div class="avatar bg-secondary">
                        <div class="avatar-content">
                            <?php echo $j; ?>
                        </div>
                    </div>
                <?php endif; ?>

<?php
            }
        ?>
        </div>
    </div>
</div>
