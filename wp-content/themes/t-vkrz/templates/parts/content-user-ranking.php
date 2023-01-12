<?php
extract($current_user_ranking_var);
$current_user_ranking = get_current_user_ranking($id_ranking);
$list_contenders      = get_field('ranking_r', $id_ranking);
$id_top               = get_field('id_tournoi_r', $id_ranking);
$nb_contenders        = count($list_contenders);
?>
<?php if ($nb_contenders < 333) : ?>
    <div class="current_ranking">
        <div class="demo-inline-spacing">
            <ul class="list-unstyled m-0 d-flex align-items-center avatar-group">
                <?php for ($j = 1; $j <= $nb_contenders; $j++) :

                    $do_place = false;

                    foreach ($current_user_ranking as $contender) :

                        if ($contender['place'] == $j) : ?>

                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title($contender['id_wp']); ?>" class="avatar pull-up">
                                <?php $illu = get_the_post_thumbnail_url($contender['id_wp'], 'medium'); ?>
                                <div class="avatar-content">
                                    <img src="<?php echo $illu; ?>" alt="Avatar">
                                </div>
                            </li>

                            <?php $do_place = true; ?>

                    <?php endif;

                    endforeach; ?>

                    <?php if ($do_place == false) : ?>
                        <li class="avatar">
                            <div class="avatar-content">
                                <?php
                                $delay = 0.25 * $j . "s";
                                ?>
                                <span class="lele1" style="animation-delay: <?php echo $delay; ?>;"><?php echo $j; ?></span>
                                <span class="lele2" style="animation-delay: <?php echo $delay; ?>;">?</span>
                            </div>
                        </li>
                    <?php endif; ?>

                <?php endfor; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>