<?php
/*
    Template Name: Log votes
*/
?>
<?php
if(isset($_GET['id_ranking']) && $_GET['id_ranking'] != "") :
    $id_ranking                      = $_GET['id_ranking'];
    $id_tournoi                      = get_field('id_tournoi_r', $id_ranking);
    $list_contenders                 = get_field('ranking_r', $id_ranking);
    $list_w_r                        = get_field('list_winners_r', $id_ranking);
    $list_l_r                        = get_field('list_losers_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking = array_column($list_contenders, 'place', 'id_wp');
?>
    <!DOCTYPE html>
    <head>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php bloginfo('template_directory'); ?>/assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <meta http-equiv="refresh" content="1" />
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Place</th>
                        <th scope="col">Ratio</th>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Supérieur à</th>
                        <th scope="col">Inférieur à</th>
                        <th scope="col">ELO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list_contenders as $c) : ?>
                        <tr>
                            <td>
                                <?php echo $c['place']; ?>
                            </td>
                            <td>
                                <?php echo $c['ratio']; ?>
                            </td>
                            <td>
                                <?php echo $c['id']; ?>
                            </td>
                            <td>
                                <?php echo get_the_title($c['id_wp']); ?> - <em><?php echo $c['id_wp']; ?></em>
                            </td>
                            <td>
                                <?php foreach($c['more_to'] as $sup) : ?>
                                    <?php echo $sup." "; ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($c['less_to'] as $inf) : ?>
                                    <?php echo $inf." "; ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php the_field('ELO_c', $c['id_wp']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <?php
                $all_votes = new WP_Query(array('post_type' => 'vote', 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => -1, 'meta_query' => array(
                    array(
                        'key' => 'id_t_v',
                        'value' => $id_tournoi,
                        'compare' => '=',
                    ),
                ))); ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gagnant</th>
                        <th scope="col">Perdant</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; while ($all_votes->have_posts()) : $all_votes->the_post(); ?>
                        <?php
                        $id_v = get_field('id_v_v');
                        $id_l = get_field('id_l_v');
                        $nb_votes = $all_votes->post_count;
                        ?>
                        <tr>
                            <td>
                                <?php echo 1 + $nb_votes - $i; ?>
                            </td>
                            <td>
                                <b><?php echo get_the_title($id_v); ?></b>
                            </td>
                            <td>
                                <?php echo get_the_title($id_l); ?>
                            </td>
                        </tr>
                        <?php $i++; endwhile; ?>
                    </tbody>
                    <tfooter>
                        <th>
                            TOTAL
                        </th>
                        <th colspan="2" class="text-right">
                            <?php echo $all_votes->post_count; ?>
                        </th>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php
                $nb_contenders      = count($list_contenders);
                if($nb_contenders % 2 == 0){
                    // Paire
                    $spaire = 5;
                }
                else{
                    // Impaire
                    $spaire = 6;
                }
                ?>
                <h3>Infos tournoi</h3>
                <ul>
                    <li>
                        NB participans : <b><?php echo $nb_contenders; ?></b>
                    </li>
                    <li>
                        Paire : <b><?php echo $spaire; ?></b>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-6">
                        <b>Liste des perdants :</b>
                        <ol>
                            <?php if($list_l_r): ?>
                                <?php foreach($list_l_r as $item) : ?>
                                    <li>
                                        <?php echo get_the_title($item); ?> (<?php echo $item; ?>)
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ol>
                    </div>
                    <div class="col-6">
                        <b>Liste des gagnants :</b>
                        <ol>
                            <?php if($list_w_r): ?>
                                <?php foreach($list_w_r as $item) : ?>
                                    <li>
                                        <?php echo get_the_title($item); ?> (<?php echo $item; ?>)
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <h3>Timeline</h3>
                <ul class="list-unstyled">
                    <li>
                        Timeline Main : <b><?php the_field('timeline_main', $id_ranking); ?></b>
                    </li>
                    <li>
                        Timeline 2 : <b><?php the_field('timeline_2', $id_ranking); ?></b>
                    </li>
                    <li>
                        Timeline 4 : <b><?php the_field('timeline_4', $id_ranking); ?></b>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <?php
                $ranking = new WP_Query(
                    array(
                        'post_type'      => 'contender',
                        'posts_per_page' => -1,
                        'meta_key'       => 'ELO_c',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                        'meta_query'     => array(
                            array(
                                'key'     => 'id_tournoi_c',
                                'value'   => $id_tournoi,
                                'compare' => 'LIKE',
                            )
                        )
                    )
                );
                ?>
                <h3>Classement ELO global</h3>
                <ol>
                    <?php $i=0; while ($ranking->have_posts()) : $ranking->the_post(); ?>
                        <li>
                            <?php echo $i; ?> -- <?php the_title(); ?> <b><?php the_ID(); ?></b> - <?php the_field('ELO_c'); ?>
                        </li>
                    <?php $i++; endwhile; ?>
                </ol>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</body>
</html>
<?php endif; ?>

