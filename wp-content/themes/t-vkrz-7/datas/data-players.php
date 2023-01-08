<?php
/*
    Template Name: Data - Players
*/
get_header();
$list_of_players = array();
$list_tops       = array(468803, 135149, 395869);
$nb_participants = 0;

foreach ($list_tops as $id_top) :

    $all_players_of_t = new WP_Query(
        array(
            'post_type'                 => 'player',
            'posts_per_page'            => '50',
            'ignore_sticky_posts'       => true,
            'update_post_meta_cache'    => false,
            'no_found_rows'             => true,
            'meta_query' => array(
                array(
                    'key'       => 'id_t_p',
                    'value'     => $list_tops,
                    'compare'   => 'IN',
                )
            )
        )
    );
    while ($all_players_of_t->have_posts()) : $all_players_of_t->the_post();

        array_push($list_of_players, get_field('email_player_p'));
        $nb_participants++;

    endwhile;

endforeach;

$list_of_players = array_unique($list_of_players);
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="classement">
                <section id="profile-info">
                    <?php if (!empty($list_of_players)) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title pt-1 pb-1">
                                    Liste des <span class="text-rose"><?php echo count($list_of_players); ?> participants</span> à vos Tops
                                </h4>

                            </div>
                            <div class="table-responsive">
                                <table class="table table-vainkeurz">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="text-muted">Mail</span>
                                            </th>
                                            <th class="text-right shorted">
                                                <span class="text-muted">Résultats</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_of_players as $player) : ?>

                                            <tr>

                                                <td>
                                                    <?php echo $player; ?>
                                                </td>

                                                <td class="text-right">
                                                    <?php
                                                    $all_players_of_t = new WP_Query(
                                                        array(
                                                            'post_type'                 => 'player',
                                                            'posts_per_page'            => '500',
                                                            'ignore_sticky_posts'       => true,
                                                            'update_post_meta_cache'    => false,
                                                            'no_found_rows'             => true,
                                                            'meta_query' => array(
                                                                'relation' => 'AND',
                                                                array(
                                                                    'key'       => 'email_player_p',
                                                                    'value'     => $player,
                                                                    'compare'   => '=',
                                                                ),
                                                                array(
                                                                    'key'       => 'id_t_p',
                                                                    'value'     => $list_tops,
                                                                    'compare'   => 'IN',
                                                                )
                                                            )
                                                        )
                                                    );
                                                    while ($all_players_of_t->have_posts()) : $all_players_of_t->the_post(); ?>
                                                        <div class="d-flex justify-content-end align-item-center mb-1">
                                                            <h6 class="mr-2 mb-0"><?php echo get_field('question_t', get_field('id_t_p')); ?></h6>
                                                            <?php
                                                            $user_top3 = get_user_ranking(get_field('id_r_p'));
                                                            $l = 1;
                                                            foreach ($user_top3 as $contender) :

                                                                if($l == 1){
                                                                    echo '<span class="badge bg-success">' . get_the_title($contender) . '</span>';
                                                                }
                                                                elseif($l == 2){
                                                                    echo '<span class="badge bg-info">' . get_the_title($contender) . '</span>';
                                                                }
                                                                else{
                                                                    echo '<span class="badge bg-primary">' . get_the_title($contender) . '</span>';
                                                                }

                                                            $l++;
                                                                if ($l == 4) break;
                                                            endforeach; ?>
                                                        </div>
                                                    <?php endwhile;
                                                    $all_players_of_t->reset_postdata(); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>