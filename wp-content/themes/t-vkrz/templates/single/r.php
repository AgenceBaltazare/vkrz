<?php
$id_ranking                      = get_the_ID();
$id_tournament                   = get_field('id_tournoi_r');
$list_contenders_tournament      = get_field('ranking_r');
$list_w_r                        = get_field('list_winners_r');
$list_l_r                        = get_field('list_losers_r');

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($list_contenders_tournament, 'place');
?>
<?php get_header(); ?>
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
                    <?php foreach($list_contenders_tournament as $c) : ?>
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
                if(isset($_GET['nb']) && $_GET['nb'] != ""){
                    $nb = $_GET['nb'];
                }
                else{
                    $nb = 50;
                }
                $all_votes = new WP_Query(array('post_type' => 'vote', 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $nb, 'meta_query' => array(
                    array(
                        'key' => 'id_t_v',
                        'value' => $id_tournament,
                        'compare' => 'LIKE',
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
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
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
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <b>Liste des perdants :</b>
                        <pre>
                            <?php
                                print_r($list_l_r);
                            ?>
                        </pre>
                    </div>
                    <div class="col-6">
                        <b>Liste des gagnants :</b>
                        <pre>
                            <?php
                            print_r($list_w_r);
                            ?>
                        </pre>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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
                                'value'   => $id_tournament,
                                'compare' => 'LIKE',
                            )
                        )
                    )
                );
                ?>
                <h3>Classement ELO global</h3>
                <ul>
                    <?php $i=0; while ($ranking->have_posts()) : $ranking->the_post(); ?>
                        <li>
                            <?php echo $i; ?> -- <?php the_title(); ?> <b><?php the_ID(); ?></b> - <?php the_field('ELO_c'); ?> - (<?php the_field('difference_c'); ?>)
                        </li>
                    <?php $i++; endwhile; ?>
                </ul>
            </div>
            <div class="col-md-3">
                <ul>
                    <li>
                        <b>NB votes</b> : <?php the_field('nb_votes_r', $id_ranking); ?>
                    </li>
                    <li>
                        <b>Timeline main</b> : <?php the_field('timeline_main', $id_ranking); ?>
                    </li>
                    <li>
                        <b>Timeline 2</b> : <?php the_field('timeline_2', $id_ranking); ?>
                    </li>
                    <li>
                        <b>Timeline 4</b> : <?php the_field('timeline_4', $id_ranking); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php get_footer(); ?>